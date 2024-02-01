<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToTaskLibraries extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('task_libraries', [
            'dock_list_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'reference_drawing' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'assigned_to' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'collaborators' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'priority' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'milestone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'location' => [
                'type' => 'TEXT',
            ],
            'specification' => [
                'type' => 'TEXT',
            ],
            'budget' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'gas_free_certificate' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'light' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'ventilation' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'crane_assistance' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'cleaning_before' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'cleaning_after' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'work_permit' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'painting_after_completion' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'parts_on_board' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'transport_to_yard_work' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'transport_outsite_yard' => [
                'type' => 'TINYINT',
                'default' => 0,
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


        ]);
    }

    public function down()
    {
        //
    }
}
