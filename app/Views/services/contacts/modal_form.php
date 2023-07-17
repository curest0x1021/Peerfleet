<?php echo form_open(get_uri("services/save_contact"), array("id" => "contact-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>" />

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("first_name"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "first_name",
                    "name" => "first_name",
                    "value" => $model_info->first_name ? $model_info->first_name : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('first_name'),
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("last_name"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "last_name",
                    "name" => "last_name",
                    "value" => $model_info->last_name ? $model_info->last_name : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('last_name'),
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("job_title"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "job_title",
                    "name" => "job_title",
                    "value" => $model_info->job_title ? $model_info->job_title : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('job_title'),
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
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>


<script type="text/javascript">
    $(document).ready(function() {
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