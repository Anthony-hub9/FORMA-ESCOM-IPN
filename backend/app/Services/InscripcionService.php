<?php

declare(strict_types=1);

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use Config\Database;
use InvalidArgumentException;
use Throwable;

class InscripcionService
{
    private ?BaseConnection $db;

    public function __construct(?BaseConnection $db = null)
    {
        $this->db = $db;
    }

    /**
     * Pure helper to check whether a group meets the minimum enrollment threshold (RN-03).
     */
    public function puedeAbrirGrupo(int $totalPrerregistros, int $cupoMinimo = 25): bool
    {
        if ($totalPrerregistros < 0) {
            throw new InvalidArgumentException('totalPrerregistros no puede ser negativo.');
        }

        if ($cupoMinimo < 1) {
            throw new InvalidArgumentException('cupoMinimo debe ser al menos 1.');
        }

        return $totalPrerregistros >= $cupoMinimo;
    }

    /**
     * Registers a student pre-enrollment inside an ACID transaction (RN-04, RN-05).
     *
     * @return array{ok: bool, id_inscripcion?: int, estado?: string, error?: string}
     */
    public function prerregistrar(int $idGrupo, int $idAlumno): array
    {
        $db = $this->db ?? Database::connect();
        $db->transBegin();

        try {
            $grupo = $db->table('grupos')
                ->where('id_grupo', $idGrupo)
                ->get()
                ->getRowArray();

            if ($grupo === null) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Grupo no encontrado.'];
            }

            if (! in_array($grupo['estado'], ['PRERREGISTRO', 'ABIERTO'], true)) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'El grupo no acepta prerregistros en su estado actual.'];
            }

            $existente = $db->table('inscripciones')
                ->where('id_grupo', $idGrupo)
                ->where('id_alumno', $idAlumno)
                ->get()
                ->getRowArray();

            if ($existente !== null) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'El alumno ya cuenta con un registro en este grupo.'];
            }

            $ocupados = $db->table('inscripciones')
                ->where('id_grupo', $idGrupo)
                ->whereIn('estado', ['PRERREGISTRADO', 'INSCRITO_DEFINITIVO'])
                ->countAllResults();

            $cupoMaximo = (int) $grupo['cupo_maximo'];
            if ($ocupados >= $cupoMaximo) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Cupo maximo del grupo alcanzado.'];
            }

            $now = date('Y-m-d H:i:s');
            $db->table('inscripciones')->insert([
                'id_grupo'           => $idGrupo,
                'id_alumno'          => $idAlumno,
                'estado'             => 'PRERREGISTRADO',
                'fecha_prerregistro' => $now,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            $idInscripcion = (int) $db->insertID();
            if ($db->transStatus() === false) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'No se pudo completar el prerregistro.'];
            }

            $db->transCommit();

            return [
                'ok'             => true,
                'id_inscripcion' => $idInscripcion,
                'estado'         => 'PRERREGISTRADO',
            ];
        } catch (Throwable $e) {
            $db->transRollback();
            return ['ok' => false, 'error' => 'Error al procesar el prerregistro: ' . $e->getMessage()];
        }
    }

    /**
     * Confirms an enrollment after payment validation inside an ACID transaction (RN-04, RN-05).
     *
     * @return array{ok: bool, id_inscripcion?: int, estado?: string, error?: string}
     */
    public function confirmarInscripcion(int $idInscripcion): array
    {
        $db = $this->db ?? Database::connect();
        $db->transBegin();

        try {
            $inscripcion = $db->table('inscripciones')
                ->where('id_inscripcion', $idInscripcion)
                ->get()
                ->getRowArray();

            if ($inscripcion === null) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Inscripcion no encontrada.'];
            }

            if ($inscripcion['estado'] !== 'PRERREGISTRADO') {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Solo se pueden confirmar inscripciones en estado PRERREGISTRADO.'];
            }

            $grupo = $db->table('grupos')
                ->where('id_grupo', (int) $inscripcion['id_grupo'])
                ->get()
                ->getRowArray();

            if ($grupo === null) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Grupo asociado no encontrado.'];
            }

            $inscritosDefinitivos = $db->table('inscripciones')
                ->where('id_grupo', (int) $inscripcion['id_grupo'])
                ->where('estado', 'INSCRITO_DEFINITIVO')
                ->countAllResults();

            if ($inscritosDefinitivos >= (int) $grupo['cupo_maximo']) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'Cupo maximo definitivo del grupo alcanzado.'];
            }

            $now = date('Y-m-d H:i:s');
            $db->table('inscripciones')
                ->where('id_inscripcion', $idInscripcion)
                ->update([
                    'estado'            => 'INSCRITO_DEFINITIVO',
                    'fecha_inscripcion' => $now,
                    'updated_at'        => $now,
                ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return ['ok' => false, 'error' => 'No se pudo confirmar la inscripcion.'];
            }

            $db->transCommit();

            return [
                'ok'             => true,
                'id_inscripcion' => $idInscripcion,
                'estado'         => 'INSCRITO_DEFINITIVO',
            ];
        } catch (Throwable $e) {
            $db->transRollback();
            return ['ok' => false, 'error' => 'Error al confirmar la inscripcion: ' . $e->getMessage()];
        }
    }
}
