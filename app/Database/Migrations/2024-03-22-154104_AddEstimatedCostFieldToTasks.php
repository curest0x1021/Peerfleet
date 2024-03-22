<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEstimatedCostFieldToTasks extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'estimated_cost' => [
                'type' => 'DOUBLE',
                "default"=>0,
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tasks', 'estimated_cost');
    }
}
