<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgentTables extends Migration
{
    public function up()
    {
        // agents: borrador con draft_revision, input_mode, avatar y progreso calculado por backend
        $this->forge->addField([
            'id'                            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'                     => ['type' => 'BIGINT', 'unsigned' => true],
            'public_id'                     => ['type' => 'CHAR', 'constraint' => 36],
            'name'                          => ['type' => 'VARCHAR', 'constraint' => 150],
            'status'                        => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'published_version_id'          => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'draft_revision'                => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'input_mode'                    => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'avatar_id'                     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'last_visited_step'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'configuration_schema_version'  => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'created_at'                    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('public_id');
        $this->forge->addKey(['tenant_id', 'status']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('avatar_id', 'agent_avatars', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('agents', true, ['ENGINE' => 'InnoDB']);

        // agent_versions: inmutable al publicar; conserva snapshot de plantilla y validación
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'agent_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'version'             => ['type' => 'INT', 'unsigned' => true],
            'input_mode'          => ['type' => 'VARCHAR', 'constraint' => 10],
            'template_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'template_snapshot'   => ['type' => 'JSON', 'null' => true],
            'instructions'        => ['type' => 'TEXT', 'null' => true],
            'variables_schema'    => ['type' => 'JSON', 'null' => true],
            'model'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'limits'              => ['type' => 'JSON', 'null' => true],
            'channel_config'      => ['type' => 'JSON', 'null' => true],
            'avatar_id'           => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'progress_snapshot'   => ['type' => 'JSON', 'null' => true],
            'published_by'        => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'published_at'        => ['type' => 'DATETIME', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['agent_id', 'version']);
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('template_version_id', 'template_versions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('avatar_id', 'agent_avatars', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('published_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('agent_versions', true, ['ENGINE' => 'InnoDB']);

        // agent_source_bindings: vínculo agente-fuente con tipo de disparador
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'agent_id'       => ['type' => 'BIGINT', 'unsigned' => true],
            'data_source_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'trigger_type'   => ['type' => 'VARCHAR', 'constraint' => 30],
            'status'         => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['tenant_id', 'agent_id', 'data_source_id', 'trigger_type'], 'uq_agent_source_trigger');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('data_source_id', 'data_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('agent_source_bindings', true, ['ENGINE' => 'InnoDB']);

        // action_plans: plan declarativo por agente (ruta API)
        $this->forge->addField([
            'id'                   => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'agent_id'             => ['type' => 'BIGINT', 'unsigned' => true],
            'status'               => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'published_version_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_by'           => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'agent_id']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('action_plans', true, ['ENGINE' => 'InnoDB']);

        // action_plan_versions: pasos, dependencias, filtros, límites y confirmación de usuario
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'action_plan_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'version'        => ['type' => 'INT', 'unsigned' => true],
            'steps'          => ['type' => 'JSON', 'null' => true],
            'filters'        => ['type' => 'JSON', 'null' => true],
            'limits'         => ['type' => 'JSON', 'null' => true],
            'confirmed_by'   => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'confirmed_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['action_plan_id', 'version']);
        $this->forge->addForeignKey('action_plan_id', 'action_plans', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('confirmed_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('action_plan_versions', true, ['ENGINE' => 'InnoDB']);

        // result_endpoint_versions: URL receptora de la empresa, versionada por agente
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'agent_id'            => ['type' => 'BIGINT', 'unsigned' => true],
            'version'             => ['type' => 'INT', 'unsigned' => true],
            'url'                 => ['type' => 'VARCHAR', 'constraint' => 500],
            'auth_type'           => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'secret_reference_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'allowed_fields'      => ['type' => 'JSON', 'null' => true],
            'body_limit_bytes'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'              => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['agent_id', 'version']);
        $this->forge->addKey('tenant_id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'agents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('secret_reference_id', 'secret_references', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('result_endpoint_versions', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('result_endpoint_versions', true);
        $this->forge->dropTable('action_plan_versions', true);
        $this->forge->dropTable('action_plans', true);
        $this->forge->dropTable('agent_source_bindings', true);
        $this->forge->dropTable('agent_versions', true);
        $this->forge->dropTable('agents', true);
    }
}
