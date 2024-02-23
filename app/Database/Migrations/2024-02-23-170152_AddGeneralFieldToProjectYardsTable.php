<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGeneralFieldToProjectYardsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('project_yards', [
            'general' => [
                'type' => 'VARCHAR',
                "constraint"=>1000,
                "null"=>true
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('project_yards', 'general');
    }
}
