<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInscripcionesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_inscripcion' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_grupo' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'id_alumno' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['PRERREGISTRADO', 'INSCRITO_DEFINITIVO', 'PAGO_RECHAZADO', 'BAJA'],
                'default'    => 'PRERREGISTRADO',
            ],
            'fecha_prerregistro' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_inscripcion' => [
                'type' => 'DATETIME',
                'null' => true,
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

        $this->forge->addPrimaryKey('id_inscripcion');
        $this->forge->addUniqueKey(['id_grupo', 'id_alumno'], 'uq_inscripcion_grupo_alumno');
        $this->forge->addForeignKey('id_grupo', 'grupos', 'id_grupo', 'CASCADE', 'RESTRICT', 'fk_inscripciones_grupo');
        $this->forge->addForeignKey('id_alumno', 'usuarios', 'id_usuario', 'CASCADE', 'RESTRICT', 'fk_inscripciones_alumno');
        $this->forge->createTable('inscripciones', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('inscripciones', true);
    }
}
