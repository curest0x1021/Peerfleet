<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryFieldToTasksTable extends Migration
{
    public function up()
    {
        //
        // $this->forge->dropColumn('tasks', 'category');
        // $this->forge->dropColumn('tasks', 'supplier');
        $this->forge->addColumn('tasks', [
            'category' => [
                'type' => 'VARCHAR',
                "constraint"=>500
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                "constraint"=>500
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tasks', 'category');
        $this->forge->dropColumn('tasks', 'supplier');
    }
}
