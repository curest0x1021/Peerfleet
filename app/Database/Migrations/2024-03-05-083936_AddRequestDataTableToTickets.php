<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRequestDataTableToTickets extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tickets', [
            'request_data' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraint"=>2000
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tickets', 'request_data');
    }
}
