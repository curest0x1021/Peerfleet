<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddManyFieldsToTicketsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('tickets', [
            'manufacturer' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraints"=>200
            ],
            'equipment' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraints"=>200
            ],
            'serial_number' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraints"=>200
            ],
            'critical_disturbance' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraints"=>200
            ],
            'critical_equipment' => [
                'type' => 'VARCHAR',
                "null"=>true,
                "constraints"=>200
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('tickets', 'equipment');
        $this->forge->dropColumn('tickets', 'manufacturer');
        $this->forge->dropColumn('tickets', 'serial_number');
        $this->forge->dropColumn('tickets', 'critical_disturbance');
        $this->forge->dropColumn('tickets', 'critical_equipment');
    }
}
