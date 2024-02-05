<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskLibraryChecklistItems extends Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'checked'=>[
                'type'=>"TINYINT",
                "default"=>0
            ],
            'task_library'=>[
                'type'=>'INT',
                'null'=>true
            ]
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_library_checklist_items');
    }

    public function down()
    {
        //
    }
}
