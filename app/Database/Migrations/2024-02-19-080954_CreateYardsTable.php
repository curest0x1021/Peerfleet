<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYardsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'project_id'=>[
                'type'=>"INT",
                "null"=>true
            ],
            'work_orders'=>[
                'type'=>'VARCHAR',
                'constraint'=>500
            ],
            'currencies'=>[
                'type'=>'VARCHAR',
                'constraint'=>500
            ],
            'shipyard_id'=>[
                'type'=>'INT',
                'null'=>true
            ]
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('project_yards');
    }

    public function down()
    {
        //
    }
}
