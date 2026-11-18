<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table            = 'cursos';
    protected $primaryKey       = 'id_curso';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_academia',
        'nombre',
        'clave',
        'duracion_horas',
        'requisitos',
        'cuota_interna',
        'cuota_externa',
        'activo',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
