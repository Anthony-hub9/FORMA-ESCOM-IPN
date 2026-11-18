<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGruposTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_grupo' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_curso' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'id_prof' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'clave_grupo' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'aula' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'periodo' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'modalidad' => [
                'type'       => 'ENUM',
                'constraint' => ['PRESENCIAL', 'EN_LINEA', 'HIBRIDA'],
                'default'    => 'PRESENCIAL',
            ],
            'cupo_minimo' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 25,
            ],
            'cupo_maximo' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 35,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['PROPUESTO', 'PRERREGISTRO', 'ABIERTO', 'CERRADO', 'FINALIZADO', 'CANCELADO'],
                'default'    => 'PROPUESTO',
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

        $this->forge->addPrimaryKey('id_grupo');
        $this->forge->addUniqueKey('clave_grupo', 'uq_grupos_clave_grupo');
        $this->forge->addForeignKey('id_curso', 'cursos', 'id_curso', 'CASCADE', 'RESTRICT', 'fk_grupos_curso');
        $this->forge->addForeignKey('id_prof', 'usuarios', 'id_usuario', 'CASCADE', 'RESTRICT', 'fk_grupos_profesor');
        $this->forge->createTable('grupos', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('grupos', true);
    }
}
