<?php

// API cycle: consume, analyze, prepare, execute, report and delivery (CICLO-API)
return [
    'connector.url'        => 'Consumption URL',
    'connector.method'     => 'Method',
    'connector.auth'       => 'Authentication',
    'connector.headers'    => 'Headers (no secrets)',
    'connector.params'     => 'Parameters',
    'connector.test'       => 'Test connection',
    'connector.testNotice' => 'The test consumes data and generates a snapshot.',

    'stage.consume' => 'Consulting',
    'stage.save'    => 'Saving JSON',
    'stage.analyze' => 'Analyzing',
    'stage.prepare' => 'Preparing actions',
    'stage.execute' => 'Executing',
    'stage.report'  => 'Generating report',

    'analysis.title'      => 'Data analysis',
    'analysis.scope'      => 'We analyzed a sample of {0} of {1} records',
    'analysis.scopeFull'  => 'Full analysis of {0} records',
    'analysis.empty'      => 'The query returned no data. Adjust the query.',
    'analysis.fields'     => 'Detected fields',
    'analysis.sample'     => 'Sample',
    'analysis.suggestion' => 'Suggestion',
    'analysis.intent'     => 'What do you want to do with this data?',
    'analysis.ownGoal'    => 'Write my own goal',

    'batch.title'      => 'Prepare batch',
    'batch.planned'    => '{0} actions prepared; {1} records excluded.',
    'batch.validity'   => 'Data valid until',
    'batch.noResend'   => 'A batch does not resend completed actions.',

    'report.title'         => 'Cycle report',
    'report.delivery'      => 'Delivery to the company',
    'report.endpoint'      => 'Receiving URL',
    'report.testEndpoint'  => 'Test with synthetic data',
    'report.deliveryState' => 'Delivery status',
    'report.cycleState'    => 'Cycle result',
    'report.noData'        => 'Cycle with no data; zero actions.',

    'run.start'       => 'Start cycle',
    'run.manual'      => 'Manual run',
    'run.scheduled'   => 'Scheduled',
    'run.recurrence'  => 'Recurrence',
];
