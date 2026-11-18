<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCursosTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_curso' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_academia' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'clave' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'duracion_horas' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'requisitos' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cuota_interna' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '0.00',
            ],
            'cuota_externa' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '0.00',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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

        $this->forge->addPrimaryKey('id_curso');
        $this->forge->addUniqueKey('clave', 'uq_cursos_clave');
        $this->forge->addForeignKey('id_academia', 'academias', 'id_academia', 'CASCADE', 'RESTRICT', 'fk_cursos_academia');
        $this->forge->createTable('cursos', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('cursos', true);
    }
}
