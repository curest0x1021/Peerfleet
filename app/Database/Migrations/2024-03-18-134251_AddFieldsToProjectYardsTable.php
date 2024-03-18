<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToProjectYardsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('project_yards', [
            'penalty_price' => [
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            'penalty_limit' => [
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            'payment_terms' => [
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('clients', 'project_yards');
    }
}
