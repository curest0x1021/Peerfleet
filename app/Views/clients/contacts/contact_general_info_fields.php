<div class="container-fluid">
    <input type="hidden" name="contact_id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="client_id" value="<?php echo $model_info->client_id; ?>" />
    <input type="hidden" name="is_crew" value="<?php echo isset($is_crew) ? $is_crew : false; ?>" />
    <?php
    $label_column = isset($label_column) ? $label_column : "col-md-3";
    $field_column = isset($field_column) ? $field_column : "col-md-9";
    ?>
    <div class="form-group">
        <label for="name" class="col-md-12"><?php echo app_lang('first_name'); ?></label>
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "id" => "first_name",
                    "name" => "first_name",
                    "class" => "form-control",
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                )
            );
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="last_name" class="col-md-12"><?php echo app_lang('last_name'); ?></label>
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "id" => "last_name",
                    "name" => "last_name",
                    "class" => "form-control",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                )
            );
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label for="account_type" class="col-md-12"><?php echo app_lang('type'); ?></label>
            <div class="col-md-12">
                <?php
                echo form_radio(
                    array(
                        "id" => "type_organization",
                        "name" => "account_type",
                        "class" => "form-check-input account-type",
                        "data-msg-required" => app_lang("field_required"),
                    ),
                    "organization",
                    true
                );
                ?>
                <label for="type_organization" class="mr15"><?php echo app_lang('organization'); ?></label>
                <?php
                echo form_radio(
                    array(
                        "id" => "type_person",
                        "name" => "account_type",
                        "class" => "form-check-input account-type",
                        "data-msg-required" => app_lang("field_required"),
                    ),
                    "person",
                    false
                );
                ?>
                <label for="type_person" class=""><?php echo app_lang('individual'); ?></label>
            </div>
        </div>
    </div>

    <div class="form-group company-name-section">
        <label for="company_name" class="col-md-12"><?php echo app_lang('company_name'); ?></label>
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "id" => "company_name",
                    "name" => "company_name",
                    "class" => "form-control",
                )
            );
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <label for="email" class="<?php echo $label_column; ?>"><?php echo app_lang('email'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(
                    array(
                        "id" => "email",
                        "name" => "email",
                        "value" => isset($model_info) ? $model_info->email : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('email'),
                        "data-rule-email" => true,
                        "data-msg-email" => app_lang("enter_valid_email"),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                        "autocomplete" => "off"
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="sat" class="<?php echo $label_column; ?>"><?php echo app_lang('sat'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(
                    array(
                        "id" => "sat",
                        "name" => "sat",
                        "value" => isset($model_info) ? $model_info->sat ? $model_info->sat : "" : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('sat')
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="phone" class="<?php echo $label_column; ?>"><?php echo app_lang('mobile'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(
                    array(
                        "id" => "phone",
                        "name" => "phone",
                        "value" => isset($model_info) ? $model_info->phone ? $model_info->phone : "" : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('mobile')
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="mobile" class="<?php echo $label_column; ?>"><?php echo app_lang('iridium_phone'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(
                    array(
                        "id" => "mobile",
                        "name" => "mobile",
                        "value" => isset($model_info) ? $model_info->mobile ? $model_info->mobile : "" : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('iridium_phone')
                    )
                );
                ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-md-12"><?php echo app_lang('password'); ?></label>
        <div class="col-md-12">
            <?php
            echo form_password(
                array(
                    "id" => "password",
                    "name" => "password",
                    "class" => "form-control",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                    "data-rule-minlength" => 6,
                    "data-msg-minlength" => app_lang("enter_minimum_6_characters"),
                    "autocomplete" => "off",
                    "style" => "z-index:auto;"
                )
            );
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="retype_password" class="col-md-12"><?php echo app_lang('retype_password'); ?></label>
        <div class="col-md-12">
            <?php
            echo form_password(
                array(
                    "id" => "retype_password",
                    "name" => "retype_password",
                    "class" => "form-control",
                    "autocomplete" => "off",
                    "style" => "z-index:auto;",
                    "data-rule-equalTo" => "#password",
                    "data-msg-equalTo" => app_lang("enter_same_value")
                )
            );
            ?>
        </div>
    </div>

    <?php if ($login_user->is_admin) { ?>
        <div class="form-group ">
            <div class="row">
                <label for="is_primary_contact"
                    class="<?php echo $label_column; ?>"><?php echo app_lang('primary_contact'); ?></label>

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
    $(document).ready(function () {
        $('.account-type').click(function () {
            var inputValue = $(this).attr("value");
            if (inputValue === "person") {
                $(".company-name-section").addClass("hide");
            } else {
                $(".company-name-section").removeClass("hide");
            }
        });
    });
</script>