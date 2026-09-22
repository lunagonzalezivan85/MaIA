<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExecutionTables extends Migration
{
    public function up()
    {
        // executions: deduplicación por (tenant_id, execution_dedupe_key)
        $this->forge->addField([
            'id'                   => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'            => ['type' => 'CHAR', 'constraint' => 36],
            'agent_id'             => ['type' => 'BIGINT', 'unsigned' => true],
            'agent_version_id'     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'cycle_run_id'         => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'source_record_id'     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'trigger'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'execution_dedupe_key' => ['type' => 'VARCHAR', 'constraint' => 190],
            'status'               => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'queued'],
            'correlation_id'       => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'error_code'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'error_reason'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'queued_at'            => ['type' => 'DATETIME', 'null' => true],
            'started_at'           => ['type' => 'DATETIME', 'null' => true],
            'finished_at'          => ['type' => 'DATETIME', 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addUniqueKey(['tenant_id', 'execution_dedupe_key'], 'uq_execution_dedupe');
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_version_id', 'agent_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('cycle_run_id', 'cycle_runs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('source_record_id', 'source_records', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('executions', true, ['ENGINE' => 'InnoDB']);

        // actions: clave idempotente estable independiente del número de intento
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'           => ['type' => 'CHAR', 'constraint' => 36],
            'execution_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'action_batch_id'     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'channel'             => ['type' => 'VARCHAR', 'constraint' => 20],
            'step_index'          => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'recipient_protected' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'recipient_hash'      => ['type' => 'CHAR', 'constraint' => 64, 'null' => true],
            'dedupe_key'          => ['type' => 'VARCHAR', 'constraint' => 190],
            'status'              => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'planned'],
            'provider'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'provider_id'         => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'payload'             => ['type' => 'JSON', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addUniqueKey(['tenant_id', 'dedupe_key'], 'uq_action_dedupe');
        $this->forge->addKey(['execution_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('execution_id', 'executions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('action_batch_id', 'action_batches', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('actions', true, ['ENGINE' => 'InnoDB']);

        // action_attempts: historial de intentos con error normalizado y respuesta redactada
        $this->forge->addField([
            'id'                => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'action_id'         => ['type' => 'BIGINT', 'unsigned' => true],
            'attempt'           => ['type' => 'INT', 'unsigned' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 30],
            'started_at'        => ['type' => 'DATETIME', 'null' => true],
            'finished_at'       => ['type' => 'DATETIME', 'null' => true],
            'error'             => ['type' => 'JSON', 'null' => true],
            'response_redacted' => ['type' => 'JSON', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['action_id', 'attempt']);
        $this->forge->addForeignKey('action_id', 'actions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('action_attempts', true, ['ENGINE' => 'InnoDB']);

        // provider_events: callbacks verificados; únicos por (tenant, provider, provider_event_id)
        $this->forge->addField([
            'id'                => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'         => ['type' => 'BIGINT', 'unsigned' => true],
            'provider'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'provider_event_id' => ['type' => 'VARCHAR', 'constraint' => 190],
            'action_id'         => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'signature_valid'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'reported_status'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'payload_redacted'  => ['type' => 'JSON', 'null' => true],
            'received_at'       => ['type' => 'DATETIME', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['tenant_id', 'provider', 'provider_event_id'], 'uq_provider_event');
        $this->forge->addKey('action_id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('action_id', 'actions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('provider_events', true, ['ENGINE' => 'InnoDB']);

        // outbox_events: evento transaccional pendiente de publicación a la cola
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'event_type'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'aggregate_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'aggregate_id'   => ['type' => 'BIGINT', 'unsigned' => true],
            'payload'        => ['type' => 'JSON', 'null' => true],
            'attempts'       => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'last_error'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'published_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'published_at']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('outbox_events', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('outbox_events', true);
        $this->forge->dropTable('provider_events', true);
        $this->forge->dropTable('action_attempts', true);
        $this->forge->dropTable('actions', true);
        $this->forge->dropTable('executions', true);
    }
}
