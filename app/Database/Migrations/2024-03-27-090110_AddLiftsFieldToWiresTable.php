<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLiftsFieldToWiresTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('wires', [
            'lifts' => [
                'type' => 'TINYINT',
                "null"=>true,
                "default"=>0
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('wires', 'lifts');
    }
}
