<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBudgetGroupToTaskLibraries extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_libraries', [
            'budget_group' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraint"=>500
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('task_libraries', 'budget_group');
    }
}
