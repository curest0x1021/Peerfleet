<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoldersTable extends Migration
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
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>500
            ],
            "folder_id"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>500
            ],
            "parent_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "level"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "created_by"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "created_at"=>[
                'type'=>"DATETIME",
                'null'=>true,
            ],
            "permissions"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "context"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>500
            ],
            "context_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "starred_by_by"=>[
                'type'=>"MEDIUMTEXT",
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
        $this->forge->createTable('folders');
    }

    public function down()
    {
        //
        $this->forge->drop('folders');
    }
}
