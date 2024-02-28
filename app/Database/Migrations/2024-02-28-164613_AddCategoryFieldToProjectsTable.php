<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryFieldToProjectsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('projects', [
            'category' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraint"=>200
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('projects', 'category');
    }
}
