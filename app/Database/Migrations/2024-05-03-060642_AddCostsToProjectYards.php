<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCostsToProjectYards extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('project_yards', [
            'estimated_cost' => [
                'type' => 'LONG',
                "null"=>true,
            ],
            'owner_supply' => [
                'type' => 'LONG',
                "null"=>true,
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('project_yards', 'estimated_cost');
        $this->forge->dropColumn('project_yards', 'owner_supply');
    }
}
