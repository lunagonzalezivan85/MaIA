<?php

// API errors (contract codes, TRN §3)
return [
    'VALIDATION_ERROR'    => 'Required field or invalid format.',
    'UNAUTHENTICATED'     => 'Authentication required.',
    'FORBIDDEN'           => 'You do not have permission for this operation.',
    'NOT_FOUND'           => 'Resource not found.',
    'CONFLICT'            => 'Conflict with the current state of the resource.',
    'SEMANTIC_ERROR'      => 'The configuration is semantically invalid.',
    'RATE_LIMITED'        => 'Request limit reached. Try again later.',
    'UNAVAILABLE'         => 'Service temporarily unavailable.',
    'IDEMPOTENCY_MISMATCH'=> 'The idempotency key was already used with different content.',
    'PAYLOAD_TOO_LARGE'   => 'The request exceeds the maximum allowed size.',
];
