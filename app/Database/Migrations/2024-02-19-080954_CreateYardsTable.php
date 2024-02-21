<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYardsTable extends Migration
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
            'shipyard_id'=>[
                'type'=>'INT',
                'null'=>true
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
            'measurement_unit' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'unit_price' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'discount' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            
            // Add other fields here...
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('shipyard_cost_items');
    }

    public function down()
    {
        //
    }
}
