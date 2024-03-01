<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectCurrencyRatesTable extends Migration
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
            "project_id"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            "name"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>'100'
            ],
            "from"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>'100',
                'default'=>"USD"
            ],
            "to"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>'100',
                'default'=>"USD"
            ],
            'rate'=>[
                'type'=>"DOUBLE",
                'null'=>true,
                'default'=>1
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('project_currency_rates');
    }

    public function down()
    {
        //
        $this->forge->drop('project_currency_rates');
    }
}
