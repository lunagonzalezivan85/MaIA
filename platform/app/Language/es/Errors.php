<?php

// Errores de API (códigos del contrato TRN §3)
return [
    'VALIDATION_ERROR'    => 'Campo requerido o formato inválido.',
    'UNAUTHENTICATED'     => 'Autenticación requerida.',
    'FORBIDDEN'           => 'No tienes permiso para esta operación.',
    'NOT_FOUND'           => 'Recurso no encontrado.',
    'CONFLICT'            => 'Conflicto con el estado actual del recurso.',
    'SEMANTIC_ERROR'      => 'La configuración es semánticamente inválida.',
    'RATE_LIMITED'        => 'Límite de solicitudes alcanzado. Intenta más tarde.',
    'UNAVAILABLE'         => 'Servicio temporalmente no disponible.',
    'IDEMPOTENCY_MISMATCH'=> 'La clave de idempotencia ya fue usada con otro contenido.',
    'PAYLOAD_TOO_LARGE'   => 'La solicitud excede el tamaño máximo permitido.',
];
