<?php

declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

class AcreditacionService
{
    /**
     * Computes attendance percentage rounded to 2 decimals.
     */
    public function calcularPorcentajeAsistencia(int $sesionesPresente, int $totalSesiones): float
    {
        if ($sesionesPresente < 0 || $totalSesiones < 0) {
            throw new InvalidArgumentException('Los conteos de sesiones no pueden ser negativos.');
        }

        if ($sesionesPresente > $totalSesiones) {
            throw new InvalidArgumentException('sesionesPresente no puede exceder totalSesiones.');
        }

        if ($totalSesiones === 0) {
            return 0.0;
        }

        return round(($sesionesPresente / $totalSesiones) * 100, 2);
    }

    /**
     * Evaluates accreditation status based on attendance (>= 80%) and grade (>= 70.0).
     */
    public function evaluarDictamen(
        float $porcentajeAsistencia,
        float $calificacion,
        float $minAsistencia = 80.0,
        float $minCalificacion = 70.0
    ): string {
        if ($porcentajeAsistencia < 0.0 || $porcentajeAsistencia > 100.0) {
            throw new InvalidArgumentException('porcentajeAsistencia debe estar entre 0 y 100.');
        }

        if ($calificacion < 0.0 || $calificacion > 100.0) {
            throw new InvalidArgumentException('calificacion debe estar entre 0 y 100.');
        }

        return ($porcentajeAsistencia >= $minAsistencia && $calificacion >= $minCalificacion)
            ? 'ACREDITADO'
            : 'NO_ACREDITADO';
    }

    /**
     * Generates a 64-character lowercase hexadecimal SHA-256 certificate token (RF-11).
     */
    public function generarTokenConstancia(int $idCalif, int $idInscripcion): string
    {
        if ($idCalif < 1 || $idInscripcion < 1) {
            throw new InvalidArgumentException('idCalif e idInscripcion deben ser enteros positivos.');
        }

        $entropy = bin2hex(random_bytes(16));
        $payload = sprintf('%d:%d:%s:%s', $idCalif, $idInscripcion, microtime(true), $entropy);

        return hash('sha256', $payload);
    }
}
