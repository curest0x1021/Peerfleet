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
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->addColumn('task_libraries','created_at');
    }
}
