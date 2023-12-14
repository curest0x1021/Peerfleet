<?php echo form_open(get_uri("services/save_port"), array("id" => "contact-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>" />

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
                <span><?php echo app_lang("country"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_dropdown("country_id", $countries_dropdown, array(strtolower($model_info->country_id)), "class='select2 validate-hidden' id='country_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                ?>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>


<script type="text/javascript">
    $(document).ready(function() {
        $('#country_id').select2();
        $("#contact-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 5000
                });
                $("#contact-table").appTable({
                    newData: result.data,
                    dataId: result.id
                });
            }
        });
    });
</script>