<div class="tab-content">
    <?php echo form_open(get_uri("clients/save_contact/"), array("id" => "contact-form", "class" => "general-form dashed-row white", "role" => "form")); ?>
    <div class="card">
        <div class=" card-header d-flex align-items-center">
            <h4 class="mr15"> <?php echo app_lang('communication'); ?></h4>
            <?php if ($model_info) {
                echo anchor(get_uri("clients/contact_profile/" . $model_info->id . "/general"), "<i data-feather='external-link' class='icon-16'></i>", array("target" => "_blank"));
            }
            ?>
        </div>
        <div class="card-body">
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
            <input type="hidden" name="contact_id" value="<?php echo $model_info ? $model_info->id : null; ?>" />
            <input type="hidden" name="first_name" value="<?php echo $model_info ? $model_info->first_name : null; ?>" />
            <input type="hidden" name="last_name" value="<?php echo $model_info ? $model_info->last_name : null; ?>" />

            <div class="form-group">
                <div class="row">
                    <label for="email" class="<?php echo $label_column; ?>"><?php echo app_lang('vessel_email'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "email",
                            "name" => "email",
                            "value" => $model_info ? $model_info->email : "",
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
                            "value" => $model_info ? $model_info->sat : "",
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
                            "value" => $model_info ? $model_info->phone : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('mobile')
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="alternative_phone" class="<?php echo $label_column; ?>"><?php echo app_lang('iridium_phone'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "alternative_phone",
                            "name" => "alternative_phone",
                            "value" => $model_info ? $model_info->alternative_phone : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('iridium_phone')
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($can_edit_clients) { ?>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
            </div>
        <?php } ?>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#contact-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        });
    });
</script>