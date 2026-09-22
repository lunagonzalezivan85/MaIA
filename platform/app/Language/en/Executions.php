<?php

// Executions, actions and history (TRN §5)
return [
    'list.title'     => 'Executions',
    'list.filter'    => 'Filter by agent, date and status',
    'detail.title'   => 'Execution detail',
    'detail.actions' => 'Actions',
    'detail.attempts'=> 'Attempts',

    // Execution status
    'status.queued'              => 'Queued',
    'status.running'             => 'Running',
    'status.waiting_provider'    => 'Waiting for provider',
    'status.succeeded'           => 'Succeeded',
    'status.partially_succeeded' => 'Partially succeeded',
    'status.failed'              => 'Failed',
    'status.needs_review'        => 'Needs review',
    'status.blocked'             => 'Blocked by policies',
    'status.cancelled'           => 'Cancelled',

    // Action status
    'action.planned'    => 'Planned',
    'action.sending'    => 'Sending',
    'action.accepted'   => 'Accepted by provider',
    'action.delivered'  => 'Delivered',
    'action.completed'  => 'Completed',
    'action.failed'     => 'Failed',
    'action.skipped'    => 'Skipped by policy',
    'action.unknown'    => 'Unknown result',

    'msg.noContactPermission' => 'No contact permission for this purpose/channel.',
    'msg.quotaReached'        => 'Quota limit reached.',
    'msg.ambiguousTimeout'    => 'Timeout after possible acceptance; reconciliation required before resending.',
    'msg.retryOnlyEligible'   => 'Only eligible actions are retried; deduplication is preserved.',
];
