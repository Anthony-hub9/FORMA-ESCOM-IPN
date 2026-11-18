<?php

declare(strict_types=1);

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use Config\Database;
use InvalidArgumentException;

class HorarioOverlapService
{
    private ?BaseConnection $db;

    public function __construct(?BaseConnection $db = null)
    {
        $this->db = $db;
    }

    /**
     * Checks whether two half-open time intervals [inicioA, finA) and [inicioB, finB) overlap.
     * Adjacent intervals (e.g. 10:00-12:00 and 12:00-14:00) do NOT overlap.
     */
    public function intervalosSeTraslapan(
        string $inicioA,
        string $finA,
        string $inicioB,
        string $finB
    ): bool {
        $startA = $this->parseTimeToSeconds($inicioA);
        $endA   = $this->parseTimeToSeconds($finA);
        $startB = $this->parseTimeToSeconds($inicioB);
        $endB   = $this->parseTimeToSeconds($finB);

        if ($startA >= $endA) {
            throw new InvalidArgumentException('El intervalo A debe tener hora_inicio menor que hora_fin.');
        }

        if ($startB >= $endB) {
            throw new InvalidArgumentException('El intervalo B debe tener hora_inicio menor que hora_fin.');
        }

        return $startA < $endB && $startB < $endA;
    }

    /**
     * Validates professor and classroom availability in horarios_grupos (RN-06).
     *
     * @return array{disponible: bool, conflictos: list<array<string, mixed>>}
     */
    public function validarDisponibilidad(
        int $idProf,
        ?string $aula,
        int $diaSemana,
        string $horaInicio,
        string $horaFin,
        ?int $excludeGrupoId = null
    ): array {
        if ($diaSemana < 1 || $diaSemana > 7) {
            throw new InvalidArgumentException('dia_semana debe estar entre 1 y 7.');
        }

        $startSec = $this->parseTimeToSeconds($horaInicio);
        $endSec   = $this->parseTimeToSeconds($horaFin);
        if ($startSec >= $endSec) {
            throw new InvalidArgumentException('hora_inicio debe ser menor que hora_fin.');
        }

        $db      = $this->db ?? Database::connect();
        $builder = $db->table('horarios_grupos');

        $builder->where('dia_semana', $diaSemana)
            ->where('hora_inicio <', $horaFin)
            ->where('hora_fin >', $horaInicio);

        if ($excludeGrupoId !== null) {
            $builder->where('id_grupo !=', $excludeGrupoId);
        }

        $builder->groupStart()
            ->where('id_prof', $idProf);

        if ($aula !== null && trim($aula) !== '') {
            $builder->orWhere('aula', trim($aula));
        }

        $builder->groupEnd();

        $conflictos = $builder->get()->getResultArray();

        return [
            'disponible' => $conflictos === [],
            'conflictos' => $conflictos,
        ];
    }

    private function parseTimeToSeconds(string $time): int
    {
        if (! preg_match('/^(\d{2}):(\d{2})(?::(\d{2}))?$/', trim($time), $matches)) {
            throw new InvalidArgumentException("Formato de hora invalido: {$time}");
        }

        $hours   = (int) $matches[1];
        $minutes = (int) $matches[2];
        $seconds = isset($matches[3]) ? (int) $matches[3] : 0;

        if ($hours > 23 || $minutes > 59 || $seconds > 59) {
            throw new InvalidArgumentException("Hora fuera de rango: {$time}");
        }

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }
}
