<?php echo form_open(get_uri("services/save"), array("id" => "service-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <?php echo view("services/service_form_fields"); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>


<script type="text/javascript">
    $(document).ready(function() {
        $("#service-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 5000
                });
                $("#service-table").appTable({
                    newData: result.data,
                    dataId: result.id
                });
            }
        });
    });
</script>