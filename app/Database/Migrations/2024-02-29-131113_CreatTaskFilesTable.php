<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatTaskFilesTable extends Migration
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
            "task_id"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            'file_name'=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>200,
            ],
            'file_id'=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>200,
            ],
            'service_type'=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>200,
            ],
            'description'=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>2000,
            ],
            'file_size'=>[
                'type'=>"DOUBLE",
                'null'=>true,
            ],
            'created_at'=>[
                'type'=>"DATETIME",
                'null'=>true,
            ],
            "uploaded_by"=>[
                'type'=>"INT",
                'null'=>true,
                "constraint"=>5
            ],
            "category_id"=>[
                'type'=>"INT",
                'null'=>true,
                "constraint"=>5
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_files');
    }

    public function down()
    {
        //
        $this->forge->drop('task_files');
    }
}
