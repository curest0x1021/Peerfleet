<input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("company"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "company",
            "name" => "company",
            "value" => $model_info->company ? $model_info->company : "",
            "class" => "form-control",
            "placeholder" => app_lang('company'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("serviced_ports"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "serviced_ports",
            "name" => "serviced_ports",
            "value" => $model_info->serviced_ports ? $model_info->serviced_ports : "",
            "class" => "form-control",
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("service_type"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "service_type",
            "name" => "service_type",
            "value" => $model_info->service_type ? $model_info->service_type : "",
            "class" => "form-control",
            "placeholder" => app_lang('service_type'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("website"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "website",
            "name" => "website",
            "value" => $model_info->website ? $model_info->website : "",
            "class" => "form-control",
            "placeholder" => app_lang('website'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("email"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "email",
            "name" => "email",
            "value" => $model_info->email ? $model_info->email : "",
            "class" => "form-control",
            "placeholder" => app_lang('email'),
            "type" => "email",
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("phone"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "phone",
            "name" => "phone",
            "value" => $model_info->phone ? $model_info->phone : "",
            "class" => "form-control",
            "placeholder" => app_lang('phone'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("fax"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "fax",
            "name" => "fax",
            "value" => $model_info->fax ? $model_info->fax : "",
            "class" => "form-control",
            "placeholder" => app_lang('fax'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("address"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "address",
            "name" => "address",
            "value" => $model_info->address ? $model_info->address : "",
            "class" => "form-control",
            "placeholder" => app_lang('address'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("city"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "city",
            "name" => "city",
            "value" => $model_info->city ? $model_info->city : "",
            "class" => "form-control",
            "placeholder" => app_lang('city'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("po_box"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "po_box",
            "name" => "po_box",
            "value" => $model_info->po_box ? $model_info->po_box : "",
            "class" => "form-control",
            "placeholder" => app_lang('po_box'),
            "data-rule-required" => true,
            "data-msg-required" => app_lang("field_required"),
        ));
        ?>
    </div>
</div>

<div class="form-group row">
    <div class="<?php echo $label_column; ?>">
        <span><?php echo app_lang("country"); ?>:</span>
    </div>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_dropdown("country_id", $country_dropdown, array($model_info->country_id), "class='select2 validate-hidden' id='country_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#country_id').select2();
    });
</script>