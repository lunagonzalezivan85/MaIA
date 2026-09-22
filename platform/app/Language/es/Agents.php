<?php

// Agentes: asistente, hitos de configuración, versiones y simulación
return [
    'list.title'          => 'Agentes',
    'list.new'            => 'Nuevo agente',
    'list.draftProgress'  => 'Borrador: {0} %',
    'list.activeAgent'    => 'Agente activo',

    // Modalidad (RF-18)
    'mode.choose'    => '¿Cómo obtendrá los datos tu agente?',
    'mode.import'    => 'Importar datos',
    'mode.api'       => 'Consumir API',
    'mode.importAlt' => 'Carga un archivo CSV o XLSX y mapea sus columnas.',
    'mode.apiAlt'    => 'Conecta una API REST y analiza su respuesta.',

    // Hitos de configuración (CONFIGURACION-AGENTE)
    'milestone.identity'    => 'Identidad',
    'milestone.modePurpose' => 'Modalidad y propósito',
    'milestone.sourceData'  => 'Fuente y datos',
    'milestone.behavior'    => 'Comportamiento',
    'milestone.channel'     => 'Canal y acción',
    'milestone.rules'       => 'Reglas y límites',
    'milestone.simulation'  => 'Simulación',
    'milestone.review'      => 'Revisión',

    'milestone.pending'    => 'Pendiente',
    'milestone.validating' => 'Validando',
    'milestone.complete'   => 'Completo',
    'milestone.invalid'    => 'Requiere corrección',

    'progress.label'    => 'Configuración',
    'progress.complete' => 'Configuración completa; un administrador debe publicar',
    'progress.ready'    => 'Listo para publicar',
    'progress.next'     => 'Siguiente paso: {0}',
    'progress.invalidated' => 'Cambiaste {0}; vuelve a validar los hitos afectados.',

    // Identidad
    'identity.name'         => 'Nombre del agente',
    'identity.avatar'       => 'Avatar',
    'identity.changeAvatar' => 'Cambiar avatar de {0}',

    // Publicación y operación
    'publish.success'   => 'Versión {0} publicada.',
    'publish.blocked'   => 'La configuración está incompleta. Revisa el checklist.',
    'simulate.title'    => 'Simulación',
    'simulate.noRealFx' => 'La simulación no envía mensajes ni realiza llamadas.',
    'pause.notice'      => 'Pausar bloquea nuevos envíos; no detiene acciones ya aceptadas por el proveedor.',
];
