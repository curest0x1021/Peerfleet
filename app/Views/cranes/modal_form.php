<?php echo form_open(get_uri("cranes/save"), array("id" => "crane-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="cranes" class="<?php echo $label_column; ?>"><?php echo app_lang('cranes'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("cranes", $cranes_dropdown, array(), "class='select2 validate-hidden' id='cranes' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="gangway" class="<?php echo $label_column; ?>"><?php echo app_lang('gangway'); ?>?</label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_checkbox("gangway", "1", true, "id='gangway' class='form-check-input'");
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="provision" class="<?php echo $label_column; ?>"><?php echo app_lang('provision'); ?>?</label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_checkbox("provision", "0", false, "id='provision' class='form-check-input'");
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#crane-form").appForm({
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
                $("#crane-table").appTable({ reload: true });
            }
        });

        $("#cranes").select2();
    });
</script>