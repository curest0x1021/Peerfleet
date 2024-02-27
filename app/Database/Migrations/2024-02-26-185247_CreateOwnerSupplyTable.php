<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOwnerSupplyTable extends Migration
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
            "task_id"=>[
                'type'=>"INT",
                'null'=>true
            ],
            "project_id"=>[
                'type'=>"INT",
                'null'=>true
            ],
            "name"=>[
                'type'=>"VARCHAR",
                'constraint' =>200,
                'null'=>true
            ],
            "description"=>[
                'type'=>"VARCHAR",
                'constraint' =>2000,
                'null'=>true
            ],
            "cost"=>[
                'type'=>"INT",
                'null'=>true,
                'default'=>0
            ],
            "order_number"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_owner_supplies');
    }

    public function down()
    {
        //
        $this->forge->drop('task_owner_supplies');
    }
}
