<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTextTemplatesModel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            "title"=>[
                'type'=>"VARCHAR",
                "constraint"=>500
            ],
            "content"=>[
                'type'=>"LONGTEXT",
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
        $this->forge->createTable('text_templates');
    }

    public function down()
    {
        //
        $this->forge->drop('text_templates');
    }
}
