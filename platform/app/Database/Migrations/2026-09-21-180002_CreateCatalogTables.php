<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatalogTables extends Migration
{
    public function up()
    {
        // agent_avatars: catálogo de sistema controlado por el producto (CONFIGURACION-AGENTE)
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'resource_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'variants'      => ['type' => 'JSON', 'null' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('agent_avatars', true, ['ENGINE' => 'InnoDB']);

        // templates: alcance system (catálogo, tenant_id NULL) o tenant (privada)
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'public_id'   => ['type' => 'CHAR', 'constraint' => 36],
            'scope'       => ['type' => 'VARCHAR', 'constraint' => 10],
            'tenant_id'   => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'category'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'created_by'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'category']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('templates', true, ['ENGINE' => 'InnoDB']);

        // template_versions: versiones publicadas inmutables (campos, instrucciones, contenido)
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'template_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'version'      => ['type' => 'INT', 'unsigned' => true],
            'fields'       => ['type' => 'JSON', 'null' => true],
            'instructions' => ['type' => 'TEXT', 'null' => true],
            'content'      => ['type' => 'TEXT', 'null' => true],
            'published_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['template_id', 'version']);
        $this->forge->addForeignKey('template_id', 'templates', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('published_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('template_versions', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('template_versions', true);
        $this->forge->dropTable('templates', true);
        $this->forge->dropTable('agent_avatars', true);
    }
}
