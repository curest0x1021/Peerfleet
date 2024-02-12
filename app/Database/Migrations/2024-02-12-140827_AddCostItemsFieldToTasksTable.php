<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCostItemsFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'cost_items' => [
                'type' => 'VARCHAR',
                "constraint"=>1000
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
