<?php
$status_dropdown = array();
foreach ($task_statuses as $status) {
    $status_dropdown[] = array("id" => $status->id, "text" => $status->key_name ? app_lang($status->key_name) : $status->title);
}
?>


<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '[data-act=update-task-status]', function () {
            $(this).appModifier({
                value: $(this).attr('data-value'),
                actionUrl: '<?php echo_uri("projects/save_task_status") ?>/' + $(this).attr('data-id'),
                select2Option: {data: <?php echo json_encode($status_dropdown) ?>},
                onSuccess: function (response, newValue) {
                    if (response.success) {
                        $("#task-table").appTable({newData: response.data, dataId: response.id});
                    }
                }
            });

            return false;
        });

        $('body').on('click', '[data-act=update-task-status-checkbox]', function () {
            const el = $(this);
            el.find("span").removeClass("checkbox-checked");
            el.find("span").addClass("inline-loader");
            $.ajax({
                url: '<?php echo_uri("projects/save_task_status") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    // console.log($("#task-table"))
                    if (response.success) {
                        $("#task-table").appTable({newData: response.data, dataId: response.id});
                    } else {
                        appAlert.error(response.message, {duration: 10000});
                        el.find("span").removeClass("inline-loader");
                    }
                }
            });
        });
    });
</script>