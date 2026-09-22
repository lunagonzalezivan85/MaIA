<?php

// Importación de archivos: carga, mapeo, vista previa y confirmación (RF-21/RF-22)
return [
    'upload.title'    => 'Importar archivo',
    'upload.hint'     => 'CSV UTF-8 o XLSX sin macros. Máximo 10 MiB y 10 000 filas.',
    'upload.sheet'    => 'Hoja',
    'mapping.title'   => 'Mapear columnas',
    'mapping.idField' => 'Columna de ID estable (external_id)',
    'mapping.idHint'  => 'Requerida para deduplicar; nunca se usa el número de fila.',

    'preview.title'     => 'Vista previa',
    'preview.valid'     => 'Válidas',
    'preview.rejected'  => 'Rechazadas',
    'preview.duplicates'=> 'Duplicadas',
    'preview.noActions' => 'Confirmar solo incorpora datos; no activa contactos.',

    'confirm.success' => 'Importación confirmada: {0} registros incorporados.',
    'confirm.stale'   => 'La vista previa cambió. Revisa la nueva revisión antes de confirmar.',
    'confirm.expired' => 'El archivo venció. Cárgalo de nuevo; tu plantilla y mapeo se conservan.',

    'error.invalidFile' => 'Archivo inválido o formato no soportado.',
    'error.tooLarge'    => 'El archivo excede el tamaño máximo permitido.',
    'error.formulas'    => 'Se detectaron fórmulas; trátalas como errores de celda y corrige el archivo.',
    'error.duplicateIds'=> 'IDs repetidos dentro del archivo. Corrige los conflictos para incluir esas filas.',
    'error.missingId'   => 'Falta mapear la columna de ID estable.',

    'status.uploaded'      => 'Cargado',
    'status.validating'    => 'Validando',
    'status.preview_ready' => 'Vista previa lista',
    'status.confirming'    => 'Confirmando',
    'status.completed'     => 'Completada',
    'status.partial'       => 'Parcial',
    'status.rejected'      => 'Rechazada',
    'status.cancelled'     => 'Cancelada',
    'status.expired'       => 'Vencida',
];
