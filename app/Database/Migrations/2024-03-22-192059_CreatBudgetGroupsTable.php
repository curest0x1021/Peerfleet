<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatBudgetGroupsTable extends Migration
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
            "title"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "number"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>20
            ],
            "cost"=>[
                'type'=>"DOUBLE",
                'default'=>0,
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('budget_groups');
    }

    public function down()
    {
        //
        $this->forge->drop('budget_groups');
    }
}
