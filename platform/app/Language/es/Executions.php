<?php

// Ejecuciones, acciones e historial (TRN §5)
return [
    'list.title'     => 'Ejecuciones',
    'list.filter'    => 'Filtrar por agente, fecha y estado',
    'detail.title'   => 'Detalle de ejecución',
    'detail.actions' => 'Acciones',
    'detail.attempts'=> 'Intentos',

    // Estado de ejecución
    'status.queued'              => 'En cola',
    'status.running'             => 'En curso',
    'status.waiting_provider'    => 'Esperando proveedor',
    'status.succeeded'           => 'Exitosa',
    'status.partially_succeeded' => 'Parcialmente exitosa',
    'status.failed'              => 'Fallida',
    'status.needs_review'        => 'Requiere revisión',
    'status.blocked'             => 'Bloqueada por políticas',
    'status.cancelled'           => 'Cancelada',

    // Estado de acción
    'action.planned'    => 'Planificada',
    'action.sending'    => 'Enviando',
    'action.accepted'   => 'Aceptada por proveedor',
    'action.delivered'  => 'Entregada',
    'action.completed'  => 'Completada',
    'action.failed'     => 'Fallida',
    'action.skipped'    => 'Omitida por política',
    'action.unknown'    => 'Resultado desconocido',

    'msg.noContactPermission' => 'Sin permiso de contacto para este propósito/canal.',
    'msg.quotaReached'        => 'Límite de cuota alcanzado.',
    'msg.ambiguousTimeout'    => 'Timeout tras posible aceptación; requiere conciliación antes de reenviar.',
    'msg.retryOnlyEligible'   => 'Solo se reintentan acciones elegibles; la deduplicación se conserva.',
];
