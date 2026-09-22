<?php

// Ciclo API: consumir, analizar, preparar, ejecutar, informe y retorno (CICLO-API)
return [
    'connector.url'        => 'URL de consumo',
    'connector.method'     => 'Método',
    'connector.auth'       => 'Autenticación',
    'connector.headers'    => 'Headers (sin secretos)',
    'connector.params'     => 'Parámetros',
    'connector.test'       => 'Probar conexión',
    'connector.testNotice' => 'La prueba consume datos y genera un snapshot.',

    'stage.consume' => 'Consultando',
    'stage.save'    => 'Guardando JSON',
    'stage.analyze' => 'Analizando',
    'stage.prepare' => 'Preparando acciones',
    'stage.execute' => 'Ejecutando',
    'stage.report'  => 'Generando informe',

    'analysis.title'      => 'Análisis de datos',
    'analysis.scope'      => 'Analizamos una muestra de {0} de {1} registros',
    'analysis.scopeFull'  => 'Análisis completo de {0} registros',
    'analysis.empty'      => 'La consulta no devolvió datos. Ajusta la consulta.',
    'analysis.fields'     => 'Campos detectados',
    'analysis.sample'     => 'Muestra',
    'analysis.suggestion' => 'Sugerencia',
    'analysis.intent'     => '¿Qué quieres hacer con estos datos?',
    'analysis.ownGoal'    => 'Escribir mi propio objetivo',

    'batch.title'      => 'Preparar batch',
    'batch.planned'    => '{0} acciones preparadas; {1} registros excluidos.',
    'batch.validity'   => 'Vigencia de datos hasta',
    'batch.noResend'   => 'Un batch no reenvía acciones completadas.',

    'report.title'         => 'Informe del ciclo',
    'report.delivery'      => 'Entrega a la empresa',
    'report.endpoint'      => 'URL receptora',
    'report.testEndpoint'  => 'Probar con datos sintéticos',
    'report.deliveryState' => 'Estado de entrega',
    'report.cycleState'    => 'Resultado del ciclo',
    'report.noData'        => 'Ciclo sin datos; cero acciones.',

    'run.start'       => 'Iniciar ciclo',
    'run.manual'      => 'Ejecución manual',
    'run.scheduled'   => 'Programada',
    'run.recurrence'  => 'Recurrencia',
];
