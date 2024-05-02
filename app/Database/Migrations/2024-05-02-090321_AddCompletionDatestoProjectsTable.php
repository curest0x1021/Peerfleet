<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCompletionDatestoProjectsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('projects', [
            'contractual_delivery_date' => [
                'type' => 'DATE',
                "null"=>true,
            ],
            'yard_estimated_completion_date' => [
                'type' => 'DATE',
                "null"=>true,
            ],
            'own_estimated_completion_date' => [
                'type' => 'DATE',
                "null"=>true,
            ],
            'actual_completion_date' => [
                'type' => 'DATE',
                "null"=>true,
            ],
        ]);
    }
    

    public function down()
    {
        //
        $this->forge->dropColumn('projects', 'contractual_delivery_date');
        $this->forge->dropColumn('projects', 'yard_estimated_completion_date');
        $this->forge->dropColumn('projects', 'own_estimated_completion_date');
        $this->forge->dropColumn('projects', 'actual_completion_date');
    }
}
