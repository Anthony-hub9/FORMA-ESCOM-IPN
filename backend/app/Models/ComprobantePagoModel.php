<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class ComprobantePagoModel extends Model
{
    protected $table            = 'comprobantes_pago';
    protected $primaryKey       = 'id_comprobante';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_inscripcion',
        'id_supervisor',
        'folio_practicaja',
        'monto',
        'ruta_archivo_cifrado',
        'dictamen',
        'motivo_rechazo',
        'fecha_dictamen',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
