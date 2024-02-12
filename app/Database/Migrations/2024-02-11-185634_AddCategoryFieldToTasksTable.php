<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'category' => [
                'type' => 'VARCHAR',
                "constraint"=>500
            ],
        ]);
    }

    public function down()
    {
        //
        
    }
}
