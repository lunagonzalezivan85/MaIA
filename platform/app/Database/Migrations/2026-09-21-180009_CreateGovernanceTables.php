<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGovernanceTables extends Migration
{
    public function up()
    {
        // contact_permissions: permiso/exclusión por contacto, canal y propósito
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'contact_identifier'  => ['type' => 'VARCHAR', 'constraint' => 190],
            'contact_hash'        => ['type' => 'CHAR', 'constraint' => 64],
            'channel'             => ['type' => 'VARCHAR', 'constraint' => 20],
            'purpose'             => ['type' => 'VARCHAR', 'constraint' => 50],
            'status'              => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'granted'],
            'origin'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'evidence'            => ['type' => 'JSON', 'null' => true],
            'granted_at'          => ['type' => 'DATETIME', 'null' => true],
            'revoked_at'          => ['type' => 'DATETIME', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'channel', 'purpose']);
        $this->forge->addKey('contact_hash');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contact_permissions', true, ['ENGINE' => 'InnoDB']);

        // usage_ledger: reserva, consumo y ajuste de cuota por empresa/ejecución
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'execution_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'entry_type'   => ['type' => 'VARCHAR', 'constraint' => 20],
            'unit'         => ['type' => 'VARCHAR', 'constraint' => 30],
            'quantity'     => ['type' => 'DECIMAL', 'constraint' => '14,4'],
            'context'      => ['type' => 'JSON', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'entry_type']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('execution_id', 'executions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('usage_ledger', true, ['ENGINE' => 'InnoDB']);

        // audit_events: actor, recurso, operación, diferencias redactadas y correlación
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'actor_user_id'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'actor_type'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'user'],
            'resource_type'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'resource_id'    => ['type' => 'VARCHAR', 'constraint' => 64],
            'operation'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'diff_redacted'  => ['type' => 'JSON', 'null' => true],
            'correlation_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['tenant_id', 'resource_type', 'resource_id']);
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('actor_user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('audit_events', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('audit_events', true);
        $this->forge->dropTable('usage_ledger', true);
        $this->forge->dropTable('contact_permissions', true);
    }
}
