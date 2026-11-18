<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConstanciasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_constancia' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_calif' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'token_sha256' => [
                'type'       => 'CHAR',
                'constraint' => 64,
            ],
            'fecha_emision' => [
                'type' => 'DATETIME',
            ],
            'ruta_pdf' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addPrimaryKey('id_constancia');
        $this->forge->addUniqueKey('id_calif', 'uq_constancias_calif');
        $this->forge->addUniqueKey('token_sha256', 'uq_constancias_token_sha256');
        $this->forge->addForeignKey('id_calif', 'calificaciones', 'id_calif', 'CASCADE', 'CASCADE', 'fk_constancias_calificacion');
        $this->forge->createTable('constancias', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('constancias', true);
    }
}
