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
                'constraint' => 500,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'dock_list_number' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'reference_drawing' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'assigned_to' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'collaborators' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'status_id'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'priority_id'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'milestone_id'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'supplier'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'supplier'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'location'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'specification'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'requisition_number'=>[
                'type'=>'INT',
                'null'=>true
            ],
            'budget'=>[
                'type'=>'FLOAT',
                'default'=>0
            ],
            'gas_free_certificate'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'light'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'ventilation'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'crane_assistance'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'cleaning_before'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'cleaning_after'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'work_permit'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'painting_after_completion'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'parts_on_board'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'transport_to_yard_workshop'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'transport_outside_yard'=>[
                'type'=>'TINYINT',
                'default'=>0
            ],
            'material_yards_supply' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'risk_assessment' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'marker' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'type' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'serial_number'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'pms_scs_number'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'checklists'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'dependencies'=>[
                'type'=>'VARCHAR',
                'constraint' => 500,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
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
