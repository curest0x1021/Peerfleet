<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassRelevantFieldToTaskLibrariesTable extends Migration
{
    public function up()
    {
        //
        // $this->forge->dropColumn('task_libraries', 'class_relevant');
        $this->forge->addColumn('task_libraries', [
            'class_relevant' => [
                'type' => 'TINYINT',
                "default"=>0,
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('task_libraries', 'class_relevant');
    }
}
