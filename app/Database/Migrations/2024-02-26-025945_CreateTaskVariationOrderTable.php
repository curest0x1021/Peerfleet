<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskVariationOrderTable extends Migration
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
            "name"=>[
                'type'=>"VARCHAR",
                'constraint' =>200,
                'null'=>true
            ],
            "cost"=>[
                'type'=>"DOUBLE",
                'null'=>true
            ],
            "start_date"=>[
                'type'=>"DATE",
                'null'=>true
            ],
            "finish_date"=>[
                'type'=>"DATE",
                'null'=>true
            ],
            "notes"=>[
                'type'=>"VARCHAR",
                "constraint"=>1000,
                'null'=>true
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_variation_orders');
    }

    public function down()
    {
        //
        $this->forge->drop('task_variation_orders');
    }
}
