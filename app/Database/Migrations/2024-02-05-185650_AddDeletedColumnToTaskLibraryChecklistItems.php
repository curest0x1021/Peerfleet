<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedColumnToTaskLibraryChecklistItems extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_library_checklist_items', [
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
