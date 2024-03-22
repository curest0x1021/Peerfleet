<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEstimatedCostFieldToTaskLibraries extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_libraries', [
            'estimated_cost' => [
                'type' => 'DOUBLE',
                "default"=>0,
            ]
        ]);
        
    }

    public function down()
    {
        //
        $this->forge->dropColumn('task_libraries', 'estimated_cost');
    }
}
