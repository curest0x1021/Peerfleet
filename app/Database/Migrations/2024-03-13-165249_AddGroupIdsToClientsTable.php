<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGroupIdsToClientsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('clients', [
            'group_ids' => [
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>500
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('clients', 'group_ids');
    }
}
