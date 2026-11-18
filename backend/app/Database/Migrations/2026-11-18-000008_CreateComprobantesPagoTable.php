<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComprobantesPagoTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_comprobante' => [
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
            'id_supervisor' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'folio_practicaja' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'ruta_archivo_cifrado' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'dictamen' => [
                'type'       => 'ENUM',
                'constraint' => ['PENDIENTE', 'VALIDADO', 'RECHAZADO'],
                'default'    => 'PENDIENTE',
            ],
            'motivo_rechazo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'fecha_dictamen' => [
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

        $this->forge->addPrimaryKey('id_comprobante');
        $this->forge->addForeignKey('id_inscripcion', 'inscripciones', 'id_inscripcion', 'CASCADE', 'CASCADE', 'fk_comprobantes_inscripcion');
        $this->forge->addForeignKey('id_supervisor', 'usuarios', 'id_usuario', 'CASCADE', 'SET NULL', 'fk_comprobantes_supervisor');
        $this->forge->createTable('comprobantes_pago', true, [
            'ENGINE'          => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('comprobantes_pago', true);
    }
}
