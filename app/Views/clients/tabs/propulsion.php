<div class="card" >
    <div class="card-body" >
    <div class="d-flex justify-content-end" >
    <?php echo modal_anchor(get_uri("clients/modal_import_propulsion/".$client_info->id),'<button class="btn btn-default" target="_blank" ><i data-feather="upload" class="icon-16"  ></i>Import</button>',array());?>
        <a class="btn btn-default" style="margin-left:1vw;" href="<?php echo get_uri("clients/export_propulsion/".$client_info->id);?>" target="_blank" ><i data-feather="download" class="icon-16"  ></i>Export</a>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h4>Main Engine</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Maker : <?php echo $client_info->main_engine_maker;?>
                </p>
                <p>
                    Model : <?php echo $client_info->main_engine_model;?>
                </p>
                <p>
                    Continuous output : <?php echo $client_info->main_engine_continuous_output;?>
                </p>
                <p>
                    Bore : <?php echo $client_info->main_engine_bore;?>
                </p>
                <p>
                    Stroke : <?php echo $client_info->main_engine_stroke;?>
                </p>
                <p>
                    Serial number : <?php echo $client_info->main_engine_serial_number;?>
                </p>
                <p>
                    Quantity : <?php echo $client_info->main_engine_quantity;?>
                </p>
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Auxiliary Engine</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Maker : <?php echo $client_info->auxiliary_engine_maker;?>
                </p>
                <p>
                    Model : <?php echo $client_info->auxiliary_engine_model;?>
                </p>
                <p>
                    Output : <?php echo $client_info->auxiliary_engine_output;?>
                </p>
                <p>
                    Serial number : <?php echo $client_info->auxiliary_engine_serial_number;?>
                </p>
                <p>
                    Quantity : <?php echo $client_info->auxiliary_engine_quantity;?>
                </p>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h4>Emergency Generator</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Maker : <?php echo $client_info->emergency_generator_maker;?>
                </p>
                <p>
                    Model : <?php echo $client_info->emergency_generator_model;?>
                </p>
                <p>
                    Output : <?php echo $client_info->emergency_generator_output;?>
                </p>
                <p>
                    Serial number : <?php echo $client_info->emergency_generator_serial_number;?>
                </p>
                <p>
                    Quantity : <?php echo $client_info->emergency_generator_quantity;?>
                </p>
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Shaft Generator</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Maker : <?php echo $client_info->shaft_generator_maker;?>
                </p>
                <p>
                    Model : <?php echo $client_info->shaft_generator_model;?>
                </p>
                <p>
                    Output : <?php echo $client_info->shaft_generator_output;?>
                </p>
                <p>
                    Serial number : <?php echo $client_info->shaft_generator_serial_number;?>
                </p>
                <p>
                    Quantity : <?php echo $client_info->shaft_generator_quantity;?>
                </p>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h4>Propeller </h4>
                <div style="margin-left:2vw;" >
                <p>
                    Maker : <?php echo $client_info->propeller_maker;?>
                </p>
                <p>
                    Type : <?php echo $client_info->propeller_type;?>
                </p>
                <p>
                    Number of blades : <?php echo $client_info->propeller_number_of_blades;?>
                </p>
                <p>
                    Diameter : <?php echo $client_info->propeller_diameter;?>
                </p>
                <p>
                    Pitch : <?php echo $client_info->propeller_pitch;?>
                </p>
                <p>
                    Material : <?php echo $client_info->propeller_material;?>
                </p>
                <p>
                    Weight : <?php echo $client_info->propeller_weight;?>
                </p>
                <p>
                    Output : <?php echo $client_info->propeller_output;?>
                </p>
                <p>
                    Quantity : <?php echo $client_info->propeller_quantity;?>
                </p>
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Side Thruster</h4>
                <div style="margin-left:2vw;" >
                <p>
                    Number of bow thrusters : <?php echo $client_info->bow_thruster_number;?>
                </p>
                <p>
                    Maker of bow thrusters : <?php echo $client_info->bow_thruster_maker;?>
                </p>
                <p>
                    Type of bow thrusters : <?php echo $client_info->bow_thruster_type;?>
                </p>
                <p>
                    Power of bow thrusters : <?php echo $client_info->bow_thruster_power;?>
                </p>

                <p>
                    Number of stern thrusters : <?php echo $client_info->stern_thruster_number;?>
                </p>
                <p>
                    Maker of stern thrusters : <?php echo $client_info->stern_thruster_maker;?>
                </p>
                <p>
                    Type of stern thrusters : <?php echo $client_info->stern_thruster_type;?>
                </p>
                <p>
                    Power of stern thrusters : <?php echo $client_info->stern_thruster_power;?>
                </p>
                </div>
            </div>
        </div>
    </div>
</div>