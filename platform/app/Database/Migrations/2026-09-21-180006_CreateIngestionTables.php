<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngestionTables extends Migration
{
    public function up()
    {
        // ingestion_batches: clave idempotente (tenant_id, source, ingestion_key) única
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'      => ['type' => 'CHAR', 'constraint' => 36],
            'data_source_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'ingestion_key'  => ['type' => 'VARCHAR', 'constraint' => 190],
            'payload_hash'   => ['type' => 'CHAR', 'constraint' => 64],
            'status'         => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'received'],
            'counters'       => ['type' => 'JSON', 'null' => true],
            'errors'         => ['type' => 'JSON', 'null' => true],
            'correlation_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addUniqueKey(['tenant_id', 'data_source_id', 'ingestion_key'], 'uq_ingestion_key');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('data_source_id', 'data_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ingestion_batches', true, ['ENGINE' => 'InnoDB']);

        // source_records: registros normalizados; deduplicación por (tenant, source, external_id, event_version)
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'data_source_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'external_id'         => ['type' => 'VARCHAR', 'constraint' => 190],
            'event_version'       => ['type' => 'VARCHAR', 'constraint' => 64],
            'data'                => ['type' => 'JSON', 'null' => true],
            'content_hash'        => ['type' => 'CHAR', 'constraint' => 64],
            'import_job_id'       => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'ingestion_batch_id'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['tenant_id', 'data_source_id', 'external_id', 'event_version'], 'uq_source_record');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('data_source_id', 'data_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('import_job_id', 'import_jobs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('ingestion_batch_id', 'ingestion_batches', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('source_records', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('source_records', true);
        $this->forge->dropTable('ingestion_batches', true);
    }
}
