<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddChecklistsFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'checklists' => [
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
