<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLocaleToTenants extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tenants', [
            'locale' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'es',
                'after'      => 'timezone',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tenants', 'locale');
    }
}
