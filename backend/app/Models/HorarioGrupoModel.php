<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class HorarioGrupoModel extends Model
{
    protected $table            = 'horarios_grupos';
    protected $primaryKey       = 'id_horario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_grupo',
        'id_prof',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'aula',
    ];

    protected $useTimestamps = false;
}
