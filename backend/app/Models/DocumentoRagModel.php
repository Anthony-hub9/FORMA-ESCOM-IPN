<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class DocumentoRagModel extends Model
{
    protected $table            = 'documentos_rag';
    protected $primaryKey       = 'id_chunk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_curso',
        'titulo_documento',
        'contenido_texto',
        'embedding_json',
        'fecha_actualizacion',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
