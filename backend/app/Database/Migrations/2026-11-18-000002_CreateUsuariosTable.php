<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_usuario' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_rol' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'shield_user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nombre_completo' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'correo' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tipo_participante' => [
                'type'       => 'ENUM',
                'constraint' => ['INTERNO_IPN', 'EXTERNO'],
                'default'    => 'INTERNO_IPN',
            ],
            'boleta_curp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'grado_estudios' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'num_empleado' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'telefono_contacto' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'null'       => true,
            ],
            'estado_cuenta' => [
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

        $this->forge->addPrimaryKey('id_usuario');
        $this->forge->addUniqueKey('shield_user_id', 'uq_usuarios_shield_user_id');
        $this->forge->addUniqueKey('correo', 'uq_usuarios_correo');
        $this->forge->addForeignKey('id_rol', 'roles', 'id_rol', 'CASCADE', 'RESTRICT', 'fk_usuarios_rol');
        $this->forge->createTable('usuarios', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('usuarios', true);
    }
}
