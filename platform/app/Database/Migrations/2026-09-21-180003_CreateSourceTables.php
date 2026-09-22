<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSourceTables extends Migration
{
    public function up()
    {
        // secret_references: referencia al gestor de secretos; nunca valor plano
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'  => ['type' => 'CHAR', 'constraint' => 36],
            'provider'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'reference'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'metadata'   => ['type' => 'JSON', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey('tenant_id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('secret_references', true, ['ENGINE' => 'InnoDB']);

        // data_sources: tipo file | api_pull | api_push; identidad estable al reimportar
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'  => ['type' => 'CHAR', 'constraint' => 36],
            'type'       => ['type' => 'VARCHAR', 'constraint' => 10],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'type']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_sources', true, ['ENGINE' => 'InnoDB']);

        // connectors: configuración de fuente API; published_version_id se resuelve en código
        $this->forge->addField([
            'id'                   => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'            => ['type' => 'CHAR', 'constraint' => 36],
            'data_source_id'       => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'name'                 => ['type' => 'VARCHAR', 'constraint' => 150],
            'status'               => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'published_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey('tenant_id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('data_source_id', 'data_sources', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('connectors', true, ['ENGINE' => 'InnoDB']);

        // connector_versions: URL autorizada, método, mapeo, secreto por referencia, límites
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'connector_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'version'             => ['type' => 'INT', 'unsigned' => true],
            'method'              => ['type' => 'VARCHAR', 'constraint' => 6, 'default' => 'GET'],
            'base_url'            => ['type' => 'VARCHAR', 'constraint' => 500],
            'allowed_paths'       => ['type' => 'JSON', 'null' => true],
            'headers'             => ['type' => 'JSON', 'null' => true],
            'params'              => ['type' => 'JSON', 'null' => true],
            'secret_reference_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'mapping'             => ['type' => 'JSON', 'null' => true],
            'pagination'          => ['type' => 'JSON', 'null' => true],
            'timeout_ms'          => ['type' => 'INT', 'unsigned' => true, 'default' => 15000],
            'max_response_bytes'  => ['type' => 'INT', 'unsigned' => true, 'default' => 5242880],
            'max_pages'           => ['type' => 'INT', 'unsigned' => true, 'default' => 100],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['connector_id', 'version']);
        $this->forge->addForeignKey('connector_id', 'connectors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('secret_reference_id', 'secret_references', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('connector_versions', true, ['ENGINE' => 'InnoDB']);

        // import_jobs: archivo privado, mapeo, revisión de vista previa y confirmación
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'           => ['type' => 'CHAR', 'constraint' => 36],
            'data_source_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'template_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'file_key'            => ['type' => 'VARCHAR', 'constraint' => 500],
            'file_name'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_hash'           => ['type' => 'CHAR', 'constraint' => 64],
            'sheet'               => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'mapping'             => ['type' => 'JSON', 'null' => true],
            'revision'            => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'confirmed_revision'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'              => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'uploaded'],
            'preview_counts'      => ['type' => 'JSON', 'null' => true],
            'expires_at'          => ['type' => 'DATETIME', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('data_source_id', 'data_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('template_version_id', 'template_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('import_jobs', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('import_jobs', true);
        $this->forge->dropTable('connector_versions', true);
        $this->forge->dropTable('connectors', true);
        $this->forge->dropTable('data_sources', true);
        $this->forge->dropTable('secret_references', true);
    }
}
