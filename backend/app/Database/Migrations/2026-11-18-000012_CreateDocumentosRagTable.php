<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentosRagTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_chunk' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_curso' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'titulo_documento' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'contenido_texto' => [
                'type' => 'MEDIUMTEXT',
            ],
            'embedding_json' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'fecha_actualizacion' => [
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

        $this->forge->addPrimaryKey('id_chunk');
        $this->forge->addForeignKey('id_curso', 'cursos', 'id_curso', 'CASCADE', 'SET NULL', 'fk_documentos_rag_curso');
        $this->forge->createTable('documentos_rag', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('documentos_rag', true);
    }
}
