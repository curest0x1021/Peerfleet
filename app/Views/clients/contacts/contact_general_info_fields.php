<div class="container-fluid">
    <input type="hidden" name="contact_id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="client_id" value="<?php echo $model_info->client_id; ?>" />
    <?php
    $label_column = isset($label_column) ? $label_column : "col-md-3";
    $field_column = isset($field_column) ? $field_column : "col-md-9";
    ?>
    <div class="form-group">
        <div class="row">
            <label for="email" class="<?php echo $label_column; ?>"><?php echo app_lang('email'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "email",
                    "name" => "email",
                    "value" => $model_info->email,
                    "class" => "form-control",
                    "placeholder" => app_lang('email'),
                    "data-rule-email" => true,
                    "data-msg-email" => app_lang("enter_valid_email"),
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="sat" class="<?php echo $label_column; ?>"><?php echo app_lang('sat'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "sat",
                    "name" => "sat",
                    "value" => $model_info->sat ? $model_info->sat : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('sat')
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="phone" class="<?php echo $label_column; ?>"><?php echo app_lang('mobile'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "phone",
                    "name" => "phone",
                    "value" => $model_info->phone ? $model_info->phone : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('mobile')
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="mobile" class="<?php echo $label_column; ?>"><?php echo app_lang('iridium_phone'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "mobile",
                    "name" => "mobile",
                    "value" => $model_info->mobile ? $model_info->mobile : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('iridium_phone')
                ));
                ?>
            </div>
        </div>
    </div>

    <?php if ($login_user->is_admin) { ?>
        <div class="form-group ">
            <div class="row">
                <label for="is_primary_contact" class="<?php echo $label_column; ?>"><?php echo app_lang('primary_contact'); ?></label>

                <div class="<?php echo $field_column; ?>">
                    <?php
                    //is set primary contact, disable the checkbox
                    $disable = "";
                    if ($model_info->is_primary_contact) {
                        $disable = "disabled='disabled'";
                    }
                    echo form_checkbox("is_primary_contact", "1", $model_info->is_primary_contact, "id='is_primary_contact' class='form-check-input mt-2' $disable");
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    });
</script>