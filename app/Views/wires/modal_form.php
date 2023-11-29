<?php echo form_open(get_uri("wires/save"), array("id" => "crane-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="equipments" class=""><?php echo app_lang('equipments'); ?></label>
                <div class="">
                    <?php
                    echo form_input(array(
                        "id" => "equipments",
                        "name" => "equipments",
                        "class" => "form-control",
                        "placeholder" => app_lang('equipments'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required")
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="wire_type" class=""><?php echo app_lang('wire_type'); ?></label>
                <div class="">
                    <?php
                    echo form_input(array(
                        "id" => "wire_type",
                        "name" => "wire_type",
                        "class" => "form-control",
                        "placeholder" => app_lang('wire_type'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required")
                    ));
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
    $(document).ready(function() {
        $("#crane-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 10000
                });
                $("#wire-table").appTable({
                    reload: true
                });
            }
        });

        $("#equipments").select2({
            multiple: false,
            data: <?php echo $equipments_dropdown; ?>
        });
        $("#wire_type").select2({
            multiple: false,
            data: <?php echo $wire_type_dropdown; ?>
        });

    });
</script>