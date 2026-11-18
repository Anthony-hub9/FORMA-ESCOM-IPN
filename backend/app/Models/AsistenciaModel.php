<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model
{
    protected $table            = 'asistencias';
    protected $primaryKey       = 'id_asistencia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_inscripcion',
        'fecha_sesion',
        'presente',
        'observaciones',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
