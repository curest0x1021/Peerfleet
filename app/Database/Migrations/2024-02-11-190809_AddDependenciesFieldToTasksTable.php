<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDependenciesFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'dependencies' => [
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
