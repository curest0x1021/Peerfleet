<?php
if (!isset($project_id)) {
    $project_id = "";
}
?>

<script type="text/javascript">
    tasksTableRowCallback = function (nRow, aData) {
        $('td:eq(0)', nRow).attr("style", "border-left:5px solid " + aData[0] + " !important;");
        //add activated sub task filter class
        setTimeout(function () {
            var searchValue = $('#task-table').closest(".dataTables_wrapper").find("input[type=search]").val();
            if (searchValue.substring(0, 1) === "#") {
                $('#task-table').find("[main-task-id='" + searchValue + "']").removeClass("filter-sub-task-button").addClass("remove-filter-button sub-task-filter-active");
            }
        }, 50);
    };

    $(document).ready(function () {
        $.ajax({
            url: "<?php echo get_uri('tasks/get_task_statuses_dropdown/' . $project_id) ?>",
            type: 'POST',
            dataType: 'json',
            success: function (result) {
                if (result) {
                    $('body').on('click', '[data-act=update-task-status]', function () {
                        var selectEl=$(this);
                        $(this).appModifier({
                            value: $(this).attr('data-value'),
                            actionUrl: '<?php echo_uri("tasks/save_task_status") ?>/' + $(this).attr('data-id'),
                            select2Option: {data: result},
                            onSuccess: function (response, newValue) {
                                if (response.success) {
                                    // console.log(selectEl.parent().parent().find("[data-act=update-task-status-checkbox] span"))
                                    if(response.data[response.data.length-1]=="done")
                                        selectEl.parent().parent().find("[data-act=update-task-status-checkbox] span").removeClass('checkbox-blank').addClass('checkbox-checked');
                                    else selectEl.parent().parent().find("[data-act=update-task-status-checkbox] span").removeClass('checkbox-checked').addClass('checkbox-blank');
                                    // $("#task-table").appTable({newData: response.data, dataId: response.id});

                                }
                            }
                        });

                        return false;
                    });
                }
            }
        });

        $('body').on('click', '[data-act=update-task-status-checkbox]', function () {
            $(this).find("span").removeClass("checkbox-checked");
            $(this).find("span").addClass("inline-loader");
            $myEl=$(this);
            $.ajax({
                url: '<?php echo_uri("tasks/save_task_status") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $myEl.attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        console.log(response)
                        $("#reload-kanban-button:visible").trigger("click");
                        $myEl.find("span").removeClass("inline-loader");
                        $myEl.parent().parent().find('td:nth-last-child(2)').html(response.data[13])
                        if(response.data[response.data.length-1]=="done"){
                            $myEl.find("span").removeClass("checkbox-blank").addClass("checkbox-checked");
                            $myEl.attr('data-value',1);
                        }else{
                            $myEl.find("span").removeClass("checkbox-checked").addClass("checkbox-blank");
                            $myEl.attr('data-value',3);
                        }
                        // $("#task-table table").appTable({newData: response.data, dataId: response.id});
                    }
                }
            });
        });
    });
</script>