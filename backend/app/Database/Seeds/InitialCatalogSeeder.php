<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $roles = [
            [
                'nombre'      => 'Administrador',
                'clave'       => 'administrador',
                'descripcion' => 'Administrador general de la plataforma FORMA-ESCOM-IPN.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nombre'      => 'Coordinador',
                'clave'       => 'coordinador',
                'descripcion' => 'Coordinador de academia encargado de cursos, grupos y constancias.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nombre'      => 'Supervisor',
                'clave'       => 'supervisor',
                'descripcion' => 'Supervisor encargado de validar comprobantes de pago.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nombre'      => 'Profesor',
                'clave'       => 'profesor',
                'descripcion' => 'Docente encargado de impartir cursos, registrar asistencias y calificaciones.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nombre'      => 'Alumno',
                'clave'       => 'alumno',
                'descripcion' => 'Participante interno IPN o externo inscrito en cursos de capacitacion.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('roles')->ignore(true)->insertBatch($roles);

        $academias = [
            [
                'id_coordinador' => null,
                'nombre'         => 'Red Hat',
                'clave'          => 'REDHAT',
                'descripcion'    => 'Academia Red Hat ESCOM-IPN.',
                'activa'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id_coordinador' => null,
                'nombre'         => 'Huawei',
                'clave'          => 'HUAWEI',
                'descripcion'    => 'Academia Huawei ICT ESCOM-IPN.',
                'activa'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id_coordinador' => null,
                'nombre'         => 'Google',
                'clave'          => 'GOOGLE',
                'descripcion'    => 'Academia Google Cloud ESCOM-IPN.',
                'activa'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'id_coordinador' => null,
                'nombre'         => 'LPI',
                'clave'          => 'LPI',
                'descripcion'    => 'Academia Linux Professional Institute ESCOM-IPN.',
                'activa'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];

        $this->db->table('academias')->ignore(true)->insertBatch($academias);
    }
}
