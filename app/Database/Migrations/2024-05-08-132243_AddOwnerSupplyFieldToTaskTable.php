<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOwnerSupplyFieldToTaskTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'owner_supply' => [
                'type' => 'LONG',
                "null"=>true,
                "default"=>0
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tasks', 'owner_supply');
    }
}
