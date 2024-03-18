<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToClientsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('clients', [
            "gross_tonnage"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "net_tonnage"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "lightweight"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "length_over_all"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "length_between_perpendiculars"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "length_of_waterline"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "breadth_moulded"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "depth_moulded"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "draught_desgin"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "draught_scantling"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "hull_design"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "top_sides"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "bottom_sides"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "flat_bottom"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "dwt_cargo"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "dwt_design"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "dwt_scantling"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "heavy_fuel_oil"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "marine_diesel_oil"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "marine_gas_oil"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "lng_capacity"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "lub_oil"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "ballast_water"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "fresh_water"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('clients', 'penalty_limit');
    }
}
