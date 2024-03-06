<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskCommentsTable extends Migration
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
            ],
            "task_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "file_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "comment_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "customer_feedback_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "files"=>[
                'type'=>"TEXT",
                "null"=>true
            ],
            "description"=>[
                'type'=>"TEXT",
                "null"=>true,
            ],
            "created_by"=>[
                "type"=>"INT",
                "null"=>true,
                'constraint'=>5
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "null"=>true
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_comments');
    }

    public function down()
    {
        //
        $this->forge->drop('task_comments');
    }
}
