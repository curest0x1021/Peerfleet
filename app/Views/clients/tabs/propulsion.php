<div class="card" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-4" >
                <h3>Main Engine</h3>
                <h4>
                    Maker : <?php echo $client_info->main_engine_maker;?>
                </h4>
                <h4>
                    Model : <?php echo $client_info->main_engine_model;?>
                </h4>
                <div class="form-group" >
                    <label>Continuous Output</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->main_engine_continuous_output;?>" />
                </div>
                <div class="form-group" >
                    <label>Bore</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->main_engine_bore;?>" />
                </div>
                <div class="form-group" >
                    <label>Stroke</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->main_engine_stroke;?>" />
                </div>
                <div class="form-group" >
                    <label>Serial number</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->main_engine_serial_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->main_engine_quantity;?>" />
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Auxiliary Engine</h4>
                <div class="form-group" >
                    <label>Maker</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->auxiliary_engine_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Model</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->auxiliary_engine_model;?>" />
                </div>
                <div class="form-group" >
                    <label>Output</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->auxiliary_engine_output;?>" />
                </div>
                <div class="form-group" >
                    <label>Serial number</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->auxiliary_engine_serial_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->auxiliary_engine_quantity;?>" />
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h4>Emergency Generator</h4>
                <div class="form-group" >
                    <label>Maker</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->emergency_generator_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Model</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->emergency_generator_model;?>" />
                </div>
                <div class="form-group" >
                    <label>Output</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->emergency_generator_output;?>" />
                </div>
                <div class="form-group" >
                    <label>Serial number</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->emergency_generator_serial_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->emergency_generator_quantity;?>" />
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Shaft Generator</h4>
                <div class="form-group" >
                    <label>Maker</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->shaft_generator_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Model</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->shaft_generator_model;?>" />
                </div>
                <div class="form-group" >
                    <label>Output</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->shaft_generator_output;?>" />
                </div>
                <div class="form-group" >
                    <label>Serial number</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->shaft_generator_serial_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->shaft_generator_quantity;?>" />
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4" >
                <h4>Propeller </h4>
                <div class="form-group" >
                    <label>Maker</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Type</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_type;?>" />
                </div>
                <div class="form-group" >
                    <label>Number of blades</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_number_of_blades;?>" />
                </div>
                <div class="form-group" >
                    <label>Diameter</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_diameter;?>" />
                </div>
                <div class="form-group" >
                    <label>Pitch</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_pitch;?>" />
                </div>
                <div class="form-group" >
                    <label>Material</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_material;?>" />
                </div>
                <div class="form-group" >
                    <label>Weight</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_weight;?>" />
                </div>
                <div class="form-group" >
                    <label>Output</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_output;?>" />
                </div>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->propeller_quantity;?>" />
                </div>
            </div>
            <div class="col-md-2" ></div>
            <div class="col-md-4" >
                <h4>Side Thruster</h4>
                <div class="form-group" >
                    <label>Number of bow thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->bow_thruster_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Maker of bow thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->bow_thruster_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Type of bow thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->bow_thruster_type;?>" />
                </div>
                <div class="form-group" >
                    <label>Power of bow thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->bow_thruster_power;?>" />
                </div>

                <div class="form-group" >
                    <label>Number of Stern thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->stern_thruster_number;?>" />
                </div>
                <div class="form-group" >
                    <label>Maker of Stern thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->stern_thruster_maker;?>" />
                </div>
                <div class="form-group" >
                    <label>Type of Stern thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->stern_thruster_type;?>" />
                </div>
                <div class="form-group" >
                    <label>Power of Stern thrusters</label>
                    <input readonly disabled class="form-control" value="<?php echo $client_info->stern_thruster_power;?>" />
                </div>
            </div>
        </div>
    </div>
</div>