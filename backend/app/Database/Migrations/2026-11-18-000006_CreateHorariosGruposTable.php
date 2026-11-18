<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHorariosGruposTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_horario' => [
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
            'id_prof' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'dia_semana' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
            ],
            'hora_inicio' => [
                'type' => 'TIME',
            ],
            'hora_fin' => [
                'type' => 'TIME',
            ],
            'aula' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_horario');
        $this->forge->addKey(['id_prof', 'dia_semana', 'hora_inicio', 'hora_fin'], false, false, 'idx_horario_prof_traslape');
        $this->forge->addForeignKey('id_grupo', 'grupos', 'id_grupo', 'CASCADE', 'CASCADE', 'fk_horarios_grupo');
        $this->forge->addForeignKey('id_prof', 'usuarios', 'id_usuario', 'CASCADE', 'RESTRICT', 'fk_horarios_profesor');
        $this->forge->createTable('horarios_grupos', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('horarios_grupos', true);
    }
}
