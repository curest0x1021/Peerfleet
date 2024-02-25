<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskCostItemsTable extends Migration
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
            'task_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'project_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'quantity' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'measurement' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null'=>true
            ],
            'unit_price' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'quote_type' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null'=>true
            ],
            'discount' => [
                'type' => 'FLOAT',
                'null' => true,
            ],
            'yard_remarks'=>[
                'type'=>'VARCHAR',
                'constraint'=>500,
                'null'=>true
            ]
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('task_cost_items');
    }

    public function down()
    {
        //
        $this->forge->drop('task_cost_items');
    }
}
