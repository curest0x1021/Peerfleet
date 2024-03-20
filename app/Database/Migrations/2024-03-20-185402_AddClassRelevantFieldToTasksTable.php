<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassRelevantFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tasks', [
            'class_relevant' => [
                'type' => 'TINYINT',
                "default"=>0,
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tasks', 'class_relevant');
    }
}
