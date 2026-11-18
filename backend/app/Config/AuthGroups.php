<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * Default group assigned to newly registered users.
     */
    public string $defaultGroup = 'alumno';

    /**
     * Available authorization groups in FORMA-ESCOM-IPN.
     *
     * @var array<string, array<string, string>>
     */
    public array $groups = [
        'administrador' => [
            'title'       => 'Administrador',
            'description' => 'Control total de usuarios, academias, configuracion y base de conocimiento RAG.',
        ],
        'coordinador' => [
            'title'       => 'Coordinador de Academia',
            'description' => 'Gestiona cursos, grupos, horarios, cupos y emision de constancias de su academia.',
        ],
        'supervisor' => [
            'title'       => 'Supervisor de Pagos',
            'description' => 'Valida o rechaza comprobantes de pago de alumnos prerregistrados.',
        ],
        'profesor' => [
            'title'       => 'Profesor',
            'description' => 'Registra asistencias, evaluaciones y calificaciones de los grupos asignados.',
        ],
        'alumno' => [
            'title'       => 'Alumno',
            'description' => 'Consulta oferta de cursos, realiza prerregistro, sube comprobante y descarga constancias.',
        ],
    ];

    /**
     * Available permissions mapped to CU-01..CU-14.
     *
     * @var array<string, string>
     */
    public array $permissions = [
        'admin.access'         => 'Acceso al panel administrativo del sistema',
        'usuarios.manage'      => 'Crear, editar y desactivar cuentas de usuarios y roles',
        'academias.manage'     => 'Gestionar catalogo de academias y asignar coordinadores',
        'cursos.manage'        => 'Crear y actualizar cursos de capacitacion',
        'grupos.manage'        => 'Proponer, abrir, cerrar y gestionar grupos y horarios',
        'inscripciones.manage' => 'Realizar prerregistro, consultar estado de inscripcion y bajas',
        'pagos.upload'         => 'Subir comprobante de pago en Practicaja',
        'pagos.validate'       => 'Dictaminar (validar o rechazar) comprobantes de pago',
        'asistencias.manage'   => 'Registrar y consultar asistencias por sesion',
        'calificaciones.manage'=> 'Registrar calificaciones y dictamen de acreditacion',
        'constancias.issue'    => 'Generar y emitir constancias digitales con sello SHA-256',
        'constancias.view'     => 'Consultar y descargar constancias propias',
        'rag.manage'           => 'Administrar documentos e indexacion de la base RAG',
        'rag.query'            => 'Consultar al asistente informativo RAG',
    ];

    /**
     * Permissions matrix per group.
     *
     * @var array<string, list<string>>
     */
    public array $matrix = [
        'administrador' => [
            'admin.access',
            'usuarios.manage',
            'academias.manage',
            'cursos.manage',
            'grupos.manage',
            'inscripciones.manage',
            'pagos.validate',
            'asistencias.manage',
            'calificaciones.manage',
            'constancias.issue',
            'constancias.view',
            'rag.manage',
            'rag.query',
        ],
        'coordinador' => [
            'cursos.manage',
            'grupos.manage',
            'constancias.issue',
            'rag.query',
        ],
        'supervisor' => [
            'pagos.validate',
            'rag.query',
        ],
        'profesor' => [
            'asistencias.manage',
            'calificaciones.manage',
            'rag.query',
        ],
        'alumno' => [
            'inscripciones.manage',
            'pagos.upload',
            'constancias.view',
            'rag.query',
        ],
    ];
}
