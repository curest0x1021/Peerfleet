<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientGroupsTable extends Migration
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
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('client_groups');
    }

    public function down()
    {
        //
        $this->forge->drop('client_groups');
    }
}
