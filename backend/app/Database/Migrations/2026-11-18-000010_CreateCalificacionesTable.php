<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCalificacionesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_calif' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_inscripcion' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'porcentaje_asistencia' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => '0.00',
            ],
            'calificacion' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => '0.00',
            ],
            'dictamen' => [
                'type'       => 'ENUM',
                'constraint' => ['PENDIENTE', 'ACREDITADO', 'NO_ACREDITADO'],
                'default'    => 'PENDIENTE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_calif');
        $this->forge->addUniqueKey('id_inscripcion', 'uq_calificaciones_inscripcion');
        $this->forge->addForeignKey('id_inscripcion', 'inscripciones', 'id_inscripcion', 'CASCADE', 'CASCADE', 'fk_calificaciones_inscripcion');
        $this->forge->createTable('calificaciones', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('calificaciones', true);
    }
}
