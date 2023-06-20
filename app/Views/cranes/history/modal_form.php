<?php echo form_open(get_uri("cranes/save_history"), array("id" => "history-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <input type="hidden" name="rope_id" value="<?php echo $rope_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="replacement" class="<?php echo $label_column; ?>"><?php echo app_lang('replacement'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "replacement",
                        "name" => "replacement",
                        "class" => "form-control",
                        "placeholder" => app_lang('replacement'),
                        "autocomplete" => "off",
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary start-upload"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#history-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#crane-history-table").appTable({ reload: true });
            }
        });

        setDatePicker("#replacement");

    });
</script>