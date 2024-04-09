<div class="card" >
    <div class="card-body" >
        <a class="btn btn-default" target="_blank" href="<?php echo get_uri("clients/export_propulsion/".$client_info->id);?>" ><i data-feather="download" class="icon-16"  ></i>Export Propulsion Info</a>
        <div class="row" >
            <div class="col-md-4" >
                <h3>Main Engine</h3>
                <h4>
                    Maker : <?php echo $client_info->main_engine_maker;?>
                </h4>
                <h4>
                    Model : <?php echo $client_info->main_engine_model;?>
                </h4>
                <h4>
                    Continuous output : <?php echo $client_info->main_engine_continuous_output;?>
                </h4>
                <h4>
                    Bore : <?php echo $client_info->main_engine_bore;?>
                </h4>
                <h4>
                    Stroke : <?php echo $client_info->main_engine_stroke;?>
                </h4>
                <h4>
                    Serial number : <?php echo $client_info->main_engine_serial_number;?>
                </h4>
                <h4>
                    Quantity : <?php echo $client_info->main_engine_quantity;?>
                </h4>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h3>Auxiliary Engine</h3>
                <h4>
                    Maker : <?php echo $client_info->auxiliary_engine_maker;?>
                </h4>
                <h4>
                    Model : <?php echo $client_info->auxiliary_engine_model;?>
                </h4>
                <h4>
                    Output : <?php echo $client_info->auxiliary_engine_output;?>
                </h4>
                <h4>
                    Serial number : <?php echo $client_info->auxiliary_engine_serial_number;?>
                </h4>
                <h4>
                    Quantity : <?php echo $client_info->auxiliary_engine_quantity;?>
                </h4>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h3>Emergency Generator</h3>
                <h4>
                    Maker : <?php echo $client_info->emergency_generator_maker;?>
                </h4>
                <h4>
                    Model : <?php echo $client_info->emergency_generator_model;?>
                </h4>
                <h4>
                    Output : <?php echo $client_info->emergency_generator_output;?>
                </h4>
                <h4>
                    Serial number : <?php echo $client_info->emergency_generator_serial_number;?>
                </h4>
                <h4>
                    Quantity : <?php echo $client_info->emergency_generator_quantity;?>
                </h4>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h3>Shaft Generator</h3>
                <h4>
                    Maker : <?php echo $client_info->shaft_generator_maker;?>
                </h4>
                <h4>
                    Model : <?php echo $client_info->shaft_generator_model;?>
                </h4>
                <h4>
                    Output : <?php echo $client_info->shaft_generator_output;?>
                </h4>
                <h4>
                    Serial number : <?php echo $client_info->shaft_generator_serial_number;?>
                </h4>
                <h4>
                    Quantity : <?php echo $client_info->shaft_generator_quantity;?>
                </h4>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h3>Propeller </h3>
                <h4>
                    Maker : <?php echo $client_info->propeller_maker;?>
                </h4>
                <h4>
                    Type : <?php echo $client_info->propeller_type;?>
                </h4>
                <h4>
                    Number of blades : <?php echo $client_info->propeller_number_of_blades;?>
                </h4>
                <h4>
                    Diameter : <?php echo $client_info->propeller_diameter;?>
                </h4>
                <h4>
                    Pitch : <?php echo $client_info->propeller_pitch;?>
                </h4>
                <h4>
                    Material : <?php echo $client_info->propeller_material;?>
                </h4>
                <h4>
                    Weight : <?php echo $client_info->propeller_weight;?>
                </h4>
                <h4>
                    Output : <?php echo $client_info->propeller_output;?>
                </h4>
                <h4>
                    Quantity : <?php echo $client_info->propeller_quantity;?>
                </h4>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h3>Side Thruster</h3>
                <h4>
                    Number of bow thrusters : <?php echo $client_info->bow_thruster_number;?>
                </h4>
                <h4>
                    Maker of bow thrusters : <?php echo $client_info->bow_thruster_maker;?>
                </h4>
                <h4>
                    Type of bow thrusters : <?php echo $client_info->bow_thruster_type;?>
                </h4>
                <h4>
                    Power of bow thrusters : <?php echo $client_info->bow_thruster_power;?>
                </h4>

                <h4>
                    Number of stern thrusters : <?php echo $client_info->stern_thruster_number;?>
                </h4>
                <h4>
                    Maker of stern thrusters : <?php echo $client_info->stern_thruster_maker;?>
                </h4>
                <h4>
                    Type of stern thrusters : <?php echo $client_info->stern_thruster_type;?>
                </h4>
                <h4>
                    Power of stern thrusters : <?php echo $client_info->stern_thruster_power;?>
                </h4>
            </div>
        </div>
    </div>
</div>