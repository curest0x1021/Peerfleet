<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCompanynameFieldToClientsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('clients', [
            'company_name' => [
                'type' => 'TEXT',
                "null"=>true,
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('clients', 'company_name');
    }
}
