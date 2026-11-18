<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table            = 'grupos';
    protected $primaryKey       = 'id_grupo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_curso',
        'id_prof',
        'clave_grupo',
        'aula',
        'periodo',
        'modalidad',
        'cupo_minimo',
        'cupo_maximo',
        'estado',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
