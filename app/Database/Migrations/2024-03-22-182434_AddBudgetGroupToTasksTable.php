<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBudgetGroupToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
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
        $this->forge->dropColumn('tasks', 'budget_group');
    }
}
