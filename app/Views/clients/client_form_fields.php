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
                "maxlength" => 30,
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
                "maxlength" => 30,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <label for="owner_id" class="<?php echo $label_column; ?>"><?php echo app_lang('responsible_tsi'); ?>
            <span class="help" data-container="body" data-bs-toggle="tooltip" title="<?php echo app_lang('the_person_who_will_manage_this_client') ?>"><i data-feather="help-circle" class="icon-16"></i></span>
        </label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "owner_id",
                "name" => "owner_id",
                "value" => $model_info->owner_id ? $model_info->owner_id : $login_user->id,
                "class" => "form-control",
                "placeholder" => app_lang('responsible_tsi'),
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
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
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
                "maxlength" => 30,
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
                "maxlength" => 40,
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
                "maxlength" => 20,
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
                "maxlength" => 30,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
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
                "maxlength" => 40,
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
                "maxlength" => 40,
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
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

    });
</script>