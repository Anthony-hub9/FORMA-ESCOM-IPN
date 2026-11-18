<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class CalificacionModel extends Model
{
    protected $table            = 'calificaciones';
    protected $primaryKey       = 'id_calif';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_inscripcion',
        'porcentaje_asistencia',
        'calificacion',
        'dictamen',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
