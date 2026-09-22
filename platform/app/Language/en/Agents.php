<?php

// Agents: wizard, configuration milestones, versions and simulation
return [
    'list.title'          => 'Agents',
    'list.new'            => 'New agent',
    'list.draftProgress'  => 'Draft: {0} %',
    'list.activeAgent'    => 'Active agent',

    // Input mode (RF-18)
    'mode.choose'    => 'How will your agent get its data?',
    'mode.import'    => 'Import data',
    'mode.api'       => 'Consume API',
    'mode.importAlt' => 'Upload a CSV or XLSX file and map its columns.',
    'mode.apiAlt'    => 'Connect a REST API and analyze its response.',

    // Configuration milestones (CONFIGURACION-AGENTE)
    'milestone.identity'    => 'Identity',
    'milestone.modePurpose' => 'Mode and purpose',
    'milestone.sourceData'  => 'Source and data',
    'milestone.behavior'    => 'Behavior',
    'milestone.channel'     => 'Channel and action',
    'milestone.rules'       => 'Rules and limits',
    'milestone.simulation'  => 'Simulation',
    'milestone.review'      => 'Review',

    'milestone.pending'    => 'Pending',
    'milestone.validating' => 'Validating',
    'milestone.complete'   => 'Complete',
    'milestone.invalid'    => 'Needs correction',

    'progress.label'    => 'Configuration',
    'progress.complete' => 'Configuration complete; an administrator must publish',
    'progress.ready'    => 'Ready to publish',
    'progress.next'     => 'Next step: {0}',
    'progress.invalidated' => 'You changed {0}; revalidate the affected milestones.',

    // Identity
    'identity.name'         => 'Agent name',
    'identity.avatar'       => 'Avatar',
    'identity.changeAvatar' => 'Change avatar of {0}',

    // Publishing and operation
    'publish.success'   => 'Version {0} published.',
    'publish.blocked'   => 'Configuration is incomplete. Check the checklist.',
    'simulate.title'    => 'Simulation',
    'simulate.noRealFx' => 'Simulation does not send messages or make calls.',
    'pause.notice'      => 'Pausing blocks new sends; it does not stop actions already accepted by the provider.',
];
