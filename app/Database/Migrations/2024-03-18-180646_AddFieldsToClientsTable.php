<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToClientsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('clients', [
            //////////dimensions/////////////
            ////////////////////////
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
            "draught_design"=>[
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
            //////////////////////////////////////
            "main_engine_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_model"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_continuous_output"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_bore"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_stroke"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_serial_number"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "main_engine_quantity"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            ////////
            "auxiliary_engine_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "auxiliary_engine_model"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "auxiliary_engine_output"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "auxiliary_engine_serial_number"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "auxiliary_engine_quantity"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            ////////////
            "emergency_generator_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "emergency_generator_model"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "emergency_generator_output"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "emergency_generator_serial_number"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "emergency_generator_quantity"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            /////////////////////////////////
            "shaft_generator_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "shaft_generator_model"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "shaft_generator_output"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "shaft_generator_serial_number"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "shaft_generator_quantity"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            ///////////////////////////
            "propeller_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "propeller_type"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "propeller_number_of_blades"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
            "propeller_diameter"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "propeller_pitch"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "propeller_material"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "propeller_weight"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "propeller_output"=>[
                'type' => 'FLOAT',
                "null"=>true,
                'constraint'=>10
            ],
            "propeller_quantity"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>2
            ],
            ///////////////////////////////
            "bow_thruster_number"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "bow_thruster_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "bow_thruster_type"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "bow_thruster_power"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "stern_thruster_number"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "stern_thruster_maker"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "stern_thruster_type"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],
            "stern_thruster_power"=>[
                'type' => 'VARCHAR',
                "null"=>true,
                'constraint'=>100
            ],


        ]);
    }

    public function down()
    {
        //
    }
}
