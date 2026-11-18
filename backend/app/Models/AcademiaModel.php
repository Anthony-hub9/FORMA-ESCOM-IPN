<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class AcademiaModel extends Model
{
    protected $table            = 'academias';
    protected $primaryKey       = 'id_academia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_coordinador',
        'nombre',
        'clave',
        'descripcion',
        'activa',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
