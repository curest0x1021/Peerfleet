<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskLibraries extends Migration
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
                'constraint' => 200,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_libraries');
    }

    public function down()
    {
        //
        $this->forge->drop('task_libraries');
    }
}
