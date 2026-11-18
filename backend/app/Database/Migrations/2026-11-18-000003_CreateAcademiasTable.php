<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAcademiasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_academia' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_coordinador' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'clave' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'activa' => [
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

        $this->forge->addPrimaryKey('id_academia');
        $this->forge->addUniqueKey('clave', 'uq_academias_clave');
        $this->forge->addForeignKey('id_coordinador', 'usuarios', 'id_usuario', 'CASCADE', 'SET NULL', 'fk_academias_coordinador');
        $this->forge->createTable('academias', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('academias', true);
    }
}
