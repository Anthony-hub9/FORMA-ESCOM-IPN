<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsistenciasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_asistencia' => [
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
            'fecha_sesion' => [
                'type' => 'DATE',
            ],
            'presente' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'observaciones' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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

        $this->forge->addPrimaryKey('id_asistencia');
        $this->forge->addUniqueKey(['id_inscripcion', 'fecha_sesion'], 'uq_asistencia_inscripcion_fecha');
        $this->forge->addForeignKey('id_inscripcion', 'inscripciones', 'id_inscripcion', 'CASCADE', 'CASCADE', 'fk_asistencias_inscripcion');
        $this->forge->createTable('asistencias', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('asistencias', true);
    }
}
