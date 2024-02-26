<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBudgetGroupFieldToTaskCostItemsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_cost_items', [
            'budget_group' => [
                'type' => 'INT',
                "null"=>true
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('task_cost_items', 'budget_group');
    }
}
