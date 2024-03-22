<?php echo form_open(get_uri("budget_groups/save"), array("id" => "budget-group", "class" => "general-form", "role" => "form")); ?>
    <div class="modal-body clearfix">
            <div class="form-group">
                <div class="col-md-12">
                    <?php
                    echo form_input(array(
                        "id" => "title",
                        "name" => "title",
                        "value" => "",
                        "class" => "form-control",
                        "placeholder" => "Budget Group Title",
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <?php
                    echo form_input(array(
                        "id" => "number",
                        "name" => "number",
                        "value" => "",
                        "class" => "form-control",
                        "placeholder" => "Budget Group Number",
                        "autofocus" => true,
                        "data-rule-required" => true,
                    ));
                    ?>
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
        $("#budget-group").appForm({
            onSuccess: function (result) {
                $("#budget-groups-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        
    });
</script>    