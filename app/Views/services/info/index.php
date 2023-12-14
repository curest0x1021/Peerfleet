<div class="tab-content">
    <?php echo form_open(get_uri("services/save/"), array("id" => "service-form", "class" => "general-form dashed-row white", "role" => "form")); ?>
    <div class="card">
        <div class=" card-header">
            <h4> <?php echo app_lang('general_info'); ?></h4>
        </div>
        <div class="card-body m15">
            <?php echo view("services/service_form_fields"); ?>
        </div>
        <?php if ($can_edit_items) { ?>
            <div class="card-footer rounded-bottom">
                <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
                <!-- <button type="button" class="btn btn-danger"><span data-feather="trash-2" class="icon-16"></span> <?php echo app_lang('delete'); ?></button> -->
            </div>
        <?php } ?>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#service-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });
    });
</script>