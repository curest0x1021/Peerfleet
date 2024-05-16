<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGeneralCostsToProject extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('projects', [
            'deviation_costs' => [
                'type' => 'DOUBLE',
                "null"=>true,
                "default"=>0
            ],
            'loss_of_earnings' => [
                'type' => 'DOUBLE',
                "null"=>true,
                "default"=>0
            ],
            'bunker_costs' => [
                'type' => 'DOUBLE',
                "null"=>true,
                "default"=>0
            ],
            'additional_expenditures' => [
                'type' => 'DOUBLE',
                "null"=>true,
                "default"=>0
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('projects', 'deviation_costs');
        $this->forge->dropColumn('projects', 'loss_of_earnings');
        $this->forge->dropColumn('projects', 'bunker_costs');
        $this->forge->dropColumn('projects', 'additional_expenditures');
    }
}
