<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCycleTables extends Migration
{
    public function up()
    {
        // cycle_runs: ejecución completa del ciclo API; agrupa executions/actions
        $this->forge->addField([
            'id'                     => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'              => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'              => ['type' => 'CHAR', 'constraint' => 36],
            'agent_id'               => ['type' => 'BIGINT', 'unsigned' => true],
            'agent_version_id'       => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'action_plan_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'schedule_id'            => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'trigger'                => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'manual'],
            'window_start'           => ['type' => 'DATETIME', 'null' => true],
            'window_end'             => ['type' => 'DATETIME', 'null' => true],
            'status'                 => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'queued'],
            'stages'                 => ['type' => 'JSON', 'null' => true],
            'summary'                => ['type' => 'JSON', 'null' => true],
            'correlation_id'         => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'started_at'             => ['type' => 'DATETIME', 'null' => true],
            'finished_at'            => ['type' => 'DATETIME', 'null' => true],
            'created_at'             => ['type' => 'DATETIME', 'null' => true],
            'updated_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_version_id', 'agent_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('action_plan_version_id', 'action_plan_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('cycle_runs', true, ['ENGINE' => 'InnoDB']);

        // api_snapshots: un archivo JSON duradero por intento/página de consumo
        $this->forge->addField([
            'id'                   => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'            => ['type' => 'CHAR', 'constraint' => 36],
            'connector_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'cycle_run_id'         => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'request_index'        => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'file_key'             => ['type' => 'VARCHAR', 'constraint' => 500],
            'checksum'             => ['type' => 'CHAR', 'constraint' => 64],
            'size_bytes'           => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'http_status'          => ['type' => 'INT', 'null' => true],
            'complete'             => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'error'                => ['type' => 'JSON', 'null' => true],
            'fetched_at'           => ['type' => 'DATETIME', 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'cycle_run_id']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('connector_version_id', 'connector_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('cycle_run_id', 'cycle_runs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('api_snapshots', true, ['ENGINE' => 'InnoDB']);

        // analysis_results: perfil estructural, métricas y recomendaciones con evidencia
        $this->forge->addField([
            'id'               => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'        => ['type' => 'CHAR', 'constraint' => 36],
            'agent_id'         => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'config_revision'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'analyzer_version' => ['type' => 'VARCHAR', 'constraint' => 30],
            'scope'            => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'sample'],
            'sample_size'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'total_records'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'inferred_schema'  => ['type' => 'JSON', 'null' => true],
            'metrics'          => ['type' => 'JSON', 'null' => true],
            'recommendations'  => ['type' => 'JSON', 'null' => true],
            'warnings'         => ['type' => 'JSON', 'null' => true],
            'status'           => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'agent_id']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('analysis_results', true, ['ENGINE' => 'InnoDB']);

        // analysis_result_snapshots: linaje N:M análisis ↔ snapshots
        $this->forge->addField([
            'analysis_result_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'api_snapshot_id'    => ['type' => 'BIGINT', 'unsigned' => true],
        ]);
        $this->forge->addKey(['analysis_result_id', 'api_snapshot_id'], true);
        $this->forge->addForeignKey('analysis_result_id', 'analysis_results', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('api_snapshot_id', 'api_snapshots', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('analysis_result_snapshots', true, ['ENGINE' => 'InnoDB']);

        // action_batches: conjunto finito de acciones preparadas; conserva snapshot/plan fijado
        $this->forge->addField([
            'id'                     => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'              => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'              => ['type' => 'CHAR', 'constraint' => 36],
            'cycle_run_id'           => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'api_snapshot_id'        => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'action_plan_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'validity_until'         => ['type' => 'DATETIME', 'null' => true],
            'status'                 => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'prepared'],
            'planned_count'          => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'results'                => ['type' => 'JSON', 'null' => true],
            'created_by'             => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'             => ['type' => 'DATETIME', 'null' => true],
            'updated_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cycle_run_id', 'cycle_runs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('api_snapshot_id', 'api_snapshots', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('action_plan_version_id', 'action_plan_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('action_batches', true, ['ENGINE' => 'InnoDB']);

        // schedules: target_type cycle|batch|binding; target_id genérico sin FK (polimórfico)
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'target_type'    => ['type' => 'VARCHAR', 'constraint' => 10],
            'target_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'timezone'       => ['type' => 'VARCHAR', 'constraint' => 64, 'default' => 'UTC'],
            'frequency'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'once'],
            'recurrence'     => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'next_run_at'    => ['type' => 'DATETIME', 'null' => true],
            'overlap_policy' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'skip'],
            'missed_policy'  => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'consolidate'],
            'limits'         => ['type' => 'JSON', 'null' => true],
            'status'         => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addKey('next_run_at');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('schedules', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('schedules', true);
        $this->forge->dropTable('action_batches', true);
        $this->forge->dropTable('analysis_result_snapshots', true);
        $this->forge->dropTable('analysis_results', true);
        $this->forge->dropTable('api_snapshots', true);
        $this->forge->dropTable('cycle_runs', true);
    }
}
