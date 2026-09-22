<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportTables extends Migration
{
    public function up()
    {
        // run_reports: informe versionado por ciclo; JSON completo en archivo privado
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'cycle_run_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'revision'     => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'file_key'     => ['type' => 'VARCHAR', 'constraint' => 500],
            'summary'      => ['type' => 'JSON', 'null' => true],
            'checksum'     => ['type' => 'CHAR', 'constraint' => 64],
            'status'       => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'generated'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['cycle_run_id', 'revision']);
        $this->forge->addKey('tenant_id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cycle_run_id', 'cycle_runs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('run_reports', true, ['ENGINE' => 'InnoDB']);

        // report_deliveries: entrega independiente del resultado del ciclo; idempotente
        $this->forge->addField([
            'id'                        => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'                 => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'                 => ['type' => 'CHAR', 'constraint' => 36],
            'run_report_id'             => ['type' => 'BIGINT', 'unsigned' => true],
            'result_endpoint_version_id'=> ['type' => 'BIGINT', 'unsigned' => true],
            'idempotency_key'           => ['type' => 'VARCHAR', 'constraint' => 190],
            'status'                    => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'attempts'                  => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'last_http_status'          => ['type' => 'INT', 'null' => true],
            'last_attempt_at'           => ['type' => 'DATETIME', 'null' => true],
            'delivered_at'              => ['type' => 'DATETIME', 'null' => true],
            'created_at'                => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addUniqueKey(['tenant_id', 'idempotency_key'], 'uq_delivery_idem');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('run_report_id', 'run_reports', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('result_endpoint_version_id', 'result_endpoint_versions', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('report_deliveries', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('report_deliveries', true);
        $this->forge->dropTable('run_reports', true);
    }
}
