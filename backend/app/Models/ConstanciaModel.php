<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class ConstanciaModel extends Model
{
    protected $table            = 'constancias';
    protected $primaryKey       = 'id_constancia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_calif',
        'token_sha256',
        'fecha_emision',
        'ruta_pdf',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
