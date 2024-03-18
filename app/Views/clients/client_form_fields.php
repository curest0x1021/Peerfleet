<input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
<input type="hidden" name="view" value="<?php echo isset($view) ? $view : ""; ?>" />

<div class="form-group">
    <div class="row">
        <label for="charter_name" class="<?php echo $label_column; ?> charter_name_section"><?php echo app_lang('charter_name'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "charter_name",
                "name" => "charter_name",
                "value" => $model_info->charter_name ? $model_info->charter_name : "",
                "class" => "form-control charter_name_input_section",
                "placeholder" => app_lang('charter_name'),
                "autofocus" => true,
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="christian_name" class="<?php echo $label_column; ?> christian_name_section"><?php echo app_lang('christian_name'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "christian_name",
                "name" => "christian_name",
                "value" => $model_info->christian_name ? $model_info->christian_name : "",
                "class" => "form-control christian_name_input_section",
                "placeholder" => app_lang('christian_name'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="owner_id" class="<?php echo $label_column; ?>"><?php echo app_lang('responsible_person'); ?>
            <span class="help" data-container="body" data-bs-toggle="tooltip" title="<?php echo app_lang('the_person_who_will_manage_this_client') ?>"><i data-feather="help-circle" class="icon-16"></i></span>
        </label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "owner_id",
                "name" => "owner_id",
                "value" => $model_info->owner_id ? $model_info->owner_id : "",
                "class" => "form-control",
                "placeholder" => app_lang('responsible_person'),
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="backup_id" class="<?php echo $label_column; ?>"><?php echo app_lang('backup_person'); ?>
            <span class="help" data-container="body" data-bs-toggle="tooltip"></span>
        </label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "backup_id",
                "name" => "backup_id",
                "value" => $model_info->backup_id ? $model_info->backup_id : "",
                "class" => "form-control",
                "placeholder" => app_lang('backup_person'),
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="tech_id" class="<?php echo $label_column; ?>"><?php echo app_lang('tech_person'); ?>
            <span class="help" data-container="body" data-bs-toggle="tooltip"></span>
        </label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "tech_id",
                "name" => "tech_id",
                "value" => $model_info->tech_id ? $model_info->tech_id : "",
                "class" => "form-control",
                "placeholder" => app_lang('tech_person'),
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="vessel_type" class="<?php echo $label_column; ?>"><?php echo app_lang('vessel_type'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "vessel_type",
                "name" => "vessel_type",
                "value" => $model_info->type,
                "class" => "form-control",
                "placeholder" => app_lang('vessel_type'),
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="imo_number" class="<?php echo $label_column; ?>"><?php echo app_lang('imo_number'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "imo_number",
                "name" => "imo_number",
                "value" => $model_info->imo_number ? $model_info->imo_number : "",
                "class" => "form-control",
                "placeholder" => app_lang('imo_number'),
                "maxlength" => 7,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="call_sign" class="<?php echo $label_column; ?>"><?php echo app_lang('call_sign'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "call_sign",
                "name" => "call_sign",
                "value" => $model_info->call_sign ? $model_info->call_sign : "",
                "class" => "form-control",
                "placeholder" => app_lang('call_sign'),
                "maxlength" => 15,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="offical_number" class="<?php echo $label_column; ?>"><?php echo app_lang('offical_number'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "offical_number",
                "name" => "offical_number",
                "value" => $model_info->offical_number ? $model_info->offical_number : "",
                "class" => "form-control",
                "placeholder" => app_lang('offical_number'),
                "maxlength" => 15,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="class_number" class="<?php echo $label_column; ?>"><?php echo app_lang('class_number'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "class_number",
                "name" => "class_number",
                "value" => $model_info->class_number ? $model_info->class_number : "",
                "class" => "form-control",
                "placeholder" => app_lang('class_number'),
                "maxlength" => 15,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="mmsi" class="<?php echo $label_column; ?>"><?php echo app_lang('mmsi'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "mmsi",
                "name" => "mmsi",
                "value" => $model_info->mmsi ? $model_info->mmsi : "",
                "class" => "form-control",
                "placeholder" => app_lang('mmsi'),
                "maxlength" => 9,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="build_number" class="<?php echo $label_column; ?>"><?php echo app_lang('build_number'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "build_number",
                "name" => "build_number",
                "value" => $model_info->build_number ? $model_info->build_number : "",
                "class" => "form-control",
                "placeholder" => app_lang('build_number'),
                "maxlength" => 15,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="ice_class" class="<?php echo $label_column; ?>"><?php echo app_lang('ice_class'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "ice_class",
                "name" => "ice_class",
                "value" => $model_info->ice_class ? $model_info->ice_class : "",
                "class" => "form-control",
                "placeholder" => app_lang('ice_class'),
                "maxlength" => 5,
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="classification_society" class="<?php echo $label_column; ?>"><?php echo app_lang('classification_society'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "classification_society",
                "name" => "classification_society",
                "value" => $model_info->classification_society ? $model_info->classification_society : "",
                "class" => "form-control",
                "placeholder" => app_lang('classification_society'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="build_yard" class="<?php echo $label_column; ?>"><?php echo app_lang('build_yard'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "build_yard",
                "name" => "build_yard",
                "value" => $model_info->build_yard ? $model_info->build_yard : "",
                "class" => "form-control",
                "placeholder" => app_lang('build_yard'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="build_series" class="<?php echo $label_column; ?>"><?php echo app_lang('build_series'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "build_series",
                "name" => "build_series",
                "value" => $model_info->build_series ? $model_info->build_series : "",
                "class" => "form-control",
                "placeholder" => app_lang('build_series'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="sister" class="<?php echo $label_column; ?>"><?php echo app_lang('sister'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "sister",
                "name" => "sister",
                "value" => $model_info->sister ? $model_info->sister : "",
                "class" => "form-control",
                "placeholder" => app_lang('sister'),
                "maxlength" => 255,
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="flag_state" class="<?php echo $label_column; ?>"><?php echo app_lang('flag_state'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "flag_state",
                "name" => "flag_state",
                "value" => $model_info->flag_state ? $model_info->flag_state : "",
                "class" => "form-control",
                "placeholder" => app_lang('flag_state'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="port_of_registry" class="<?php echo $label_column; ?>"><?php echo app_lang('port_of_registry'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "port_of_registry",
                "name" => "port_of_registry",
                "value" => $model_info->port_of_registry ? $model_info->port_of_registry : "",
                "class" => "form-control",
                "placeholder" => app_lang('port_of_registry'),
                "maxlength" => 255,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<h3>Vessel Dimensions and Capacities</h3>
<div class="row" >
    <div class="col-md-4" >
        <div class="form-group" >
            <label>Gross Tonnage</label>
            <div class="input-group" >
                <input class="form-control" name="gross_tonnage" />
                <!-- <span class="input-group-text" >t</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Net Tonnage</label>
            <div class="input-group" >
                <input class="form-control" name="net_tonnage" />
                <!-- <span class="input-group-text" >t</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Ligthweight</label>
            <div class="input-group" >
                <input class="form-control" name="lightweight" />
                <!-- <span class="input-group-text" >mt</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Length over all</label>
            <div class="input-group" >
                <input class="form-control" name="length_over_all" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Length between Perpendiculars</label>
            <div class="input-group" >
                <input class="form-control" name="length_between_perpendiculars" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Length of Waterline</label>
            <div class="input-group" >
                <input class="form-control" name="length_of_waterline" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Beam / Breadth Moulded</label>
            <div class="input-group" >
                <input class="form-control" name="breadth_moulded" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Depth Moulded</label>
            <div class="input-group" >
                <input class="form-control" name="depth_moulded" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Draft/Draught Design</label>
            <div class="input-group" >
                <input class="form-control" name="draught_design" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Draft/Draught Scantling</label>
            <div class="input-group" >
                <input class="form-control" name="draught_scantling" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Hull Design</label>
            <input class="form-control" name="hull_design" />
        </div>
    </div>
    <div class="col-md-2" ></div>
    <div class="col-md-4" >
        <div class="form-group" >
            <label>DWT Cargo</label>
            <input class="form-control" name="dwt_cargo" />
        </div>
        <div class="form-group" >
            <label>DWT Design</label>
            <input class="form-control" name="dwt_design" />
        </div>
        <div class="form-group" >
            <label>DWT Scantling</label>
            <div class="input-group" >
                <input class="form-control" name="dwt_scantling" />
                <!-- <span class="input-group-text" >m</span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Heavy Fuel Oil</label>
            <div class="input-group" >
                <input class="form-control" name="heavy_fuel_oil" />
                <!-- <span class="input-group-text" ></span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Marine Diesel Oil</label>
            <div class="input-group" >
                <input class="form-control" name="marine_diesel_oil" />
                <!-- <span class="input-group-text" ></span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Marine Gas Oil</label>
            <div class="input-group" >
                <input class="form-control" name="marine_gas_oil" />
                <!-- <span class="input-group-text" ></span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>lng_capacity</label>
            <div class="input-group" >
                <input class="form-control" name="lng_capacity" />
                <!-- <span class="input-group-text" ></span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Lub Oil</label>
            <div class="input-group" >
                <input class="form-control" name="lub_oil" />
                <!-- <span class="input-group-text" ></span> -->
            </div>
        </div>
        <div class="form-group" >
            <label>Ballast Water</label>
            <div class="input-group" >
                <input class="form-control" name="ballast_water" />
            </div>
        </div>
        <div class="form-group" >
            <label>Fresh Water</label>
            <div class="input-group" >
                <input class="form-control" name="fresh_water" />
            </div>
        </div>
    </div>
</div>
<div class="form-group" >
    <label>Top Sides</label>
    <input class="form-control" name="top_sides" />
</div>
<div class="form-group" >
    <label>Bottom Sides</label>
    <input class="form-control" name="top_sides" />
</div>
<div class="form-group" >
    <label>Flat Bottom</label>
    <input class="form-control" name="flat_bottom" />
</div>
<h3>Propulsion Details</h3>
<div class="row" >
    <div class="col-md-4" >
        <h4>Main Engine</h4>
        <div class="form-group" >
            <label>Maker</label>
            <input class="form-control" name="main_engin_maker" />
        </div>
        <div class="form-group" >
            <label>Model</label>
            <input class="form-control" name="main_engin_model" />
        </div>
        <div class="form-group" >
            <label>Continuous Output</label>
            <input class="form-control" name="main_engin_continuous_output" />
        </div>
        <div class="form-group" >
            <label>Bore</label>
            <input class="form-control" name="main_engin_bore" />
        </div>
        <div class="form-group" >
            <label>Stroke</label>
            <input class="form-control" name="main_engin_stroke" />
        </div>
        <div class="form-group" >
            <label>Serial Number</label>
            <input class="form-control" name="main_engin_serial_number" />
        </div>
        <div class="form-group" >
            <label>Quantity</label>
            <input class="form-control" name="main_engin_quantity" />
        </div>
        
    </div>
    <div class="col-md-2" ></div>
    <div class="col-md-4" >
        <h4>Auxiliary Engine</h4>
        <div class="form-group" >
            <label>Maker</label>
            <input class="form-control" name="auxiliary_engine_maker" />
        </div>
        <div class="form-group" >
            <label>Model</label>
            <input class="form-control" name="auxiliary_engine_model" />
        </div>
        <div class="form-group" >
            <label>Serial Number</label>
            <input class="form-control" name="auxiliary_engine_serial_number" />
        </div>
        <div class="form-group" >
            <label>Output</label>
            <input class="form-control" name="auxiliary_engine_output" />
        </div>
        <div class="form-group" >
            <label>Quantity</label>
            <input class="form-control" name="auxiliary_engine_quantity" />
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-4" >
        <h4>Emergency Generator</h4>
        <div class="form-group" >
            <label>Maker</label>
            <input class="form-control" name="emergency_generator_maker" />
        </div>
        <div class="form-group" >
            <label>Model</label>
            <input class="form-control" name="emergency_generator_model" />
        </div>
        <div class="form-group" >
            <label>Serial Number</label>
            <input class="form-control" name="emergency_generator_serial_number" />
        </div>
        <div class="form-group" >
            <label>Output</label>
            <input class="form-control" name="emergency_generator_output" />
        </div>
        <div class="form-group" >
            <label>Quantity</label>
            <input class="form-control" name="emergency_generator_quantity" />
        </div>
    </div>
    <div class="col-md-2" ></div>
    <div class="col-md-4" >
        <h4>Shaft Generator</h4>
        <div class="form-group" >
            <label>Maker</label>
            <input class="form-control" name="shaft_generator_maker" />
        </div>
        <div class="form-group" >
            <label>Model</label>
            <input class="form-control" name="shaft_generator_model" />
        </div>
        <div class="form-group" >
            <label>Serial Number</label>
            <input class="form-control" name="shaft_generator_serial_number" />
        </div>
        <div class="form-group" >
            <label>Output</label>
            <input class="form-control" name="shaft_generator_output" />
        </div>
        <div class="form-group" >
            <label>Quantity</label>
            <input class="form-control" name="shaft_generator_quantity" />
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-4" >
        <h4>Propeller</h4>
        <div class="form-group" >
            <label>Maker</label>
            <input class="form-control" name="propeller_maker" />
        </div>
        <div class="form-group" >
            <label>Type</label>
            <input class="form-control" name="propeller_type" />
        </div>
        <div class="form-group" >
            <label>Number of blades</label>
            <input class="form-control" name="propeller_number_of_blades" />
        </div>
        <div class="form-group" >
            <label>Diameter</label>
            <input class="form-control" name="propeller_diameter" />
        </div>
        <div class="form-group" >
            <label>Pitch</label>
            <input class="form-control" name="propeller_pitch" />
        </div>
        <div class="form-group" >
            <label>Material</label>
            <input class="form-control" name="propeller_material" />
        </div>
        <div class="form-group" >
            <label>Weight</label>
            <input class="form-control" name="propeller_weight" />
        </div>
        <div class="form-group" >
            <label>Output</label>
            <input class="form-control" name="propeller_output" />
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        <?php if (isset($types_dropdown)) { ?>
            $("#vessel_type").select2({
                multiple: false,
                data: <?php echo json_encode($types_dropdown); ?>
            });
        <?php } ?>

        $('#owner_id').select2({
            data: <?php echo $team_members_dropdown; ?>
        });

        $('#backup_id').select2({
            data: <?php echo $team_members_dropdown; ?>
        });

        $('#tech_id').select2({
            data: <?php echo $team_members_dropdown; ?>
        });

    });
</script>