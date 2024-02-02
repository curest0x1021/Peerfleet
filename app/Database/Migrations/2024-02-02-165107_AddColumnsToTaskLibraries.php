<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToTaskLibraries extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_libraries', [
            'created_date' => [
                'type' => 'DATE',
                'null'=>true
            ],
            'checklists'=>[
                'type'=>'TEXT',
                'default'=>""
            ],
            'dependencies'=>[
                'type'=>'TEXT',
                'default'=>""
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
