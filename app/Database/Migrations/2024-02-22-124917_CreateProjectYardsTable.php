<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectYardsTable extends Migration
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
            'shipyard_id'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'project_id'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'title'=>[
                'type'=>'VARCHAR',
                'null'=>true,
                'constraint'=>300
            ],
            'work_orders'=>[
                'type'=>'VARCHAR',
                'null'=>true,
                'constraint'=>500
            ],
            'currencies'=>[
                'type'=>'VARCHAR',
                'null'=>true,
                'constraint'=>500
            ],
            'selected'=>[
                'type'=>'TINYINT',
                'null'=>true,
                'default'=>0
            ]
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('project_yards');
    }

    public function down()
    {
        //
        $this->forge->drop('project_yards');
    }
}
