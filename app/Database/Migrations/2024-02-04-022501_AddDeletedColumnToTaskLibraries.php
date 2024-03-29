<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedColumnToTaskLibraries extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_libraries', [
            'deleted' => [
                'type' => 'TINYINT',
                'default'=>0
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
