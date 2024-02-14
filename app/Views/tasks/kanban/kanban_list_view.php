<div id="kanban-wrapper">
    <ul id="kanban-list-container" class="kanban-list-container clearfix">
        <li class="kanban-list-col kanban--1" >
            <table class="w-100 display dataTable no-footer" id="kanban-item-list--1" class="kanban-list-items" data-status_id="-1">
                <thead>
                    <tr role="row">
                        <th width="50px" style="min-width: 35px;" class="sorting"  aria-controls="task-table"  aria-sort="descending" aria-label=""></th>
                        <th width="10%" class="sorting"  aria-controls="task-table"  aria-label="">Dock list number</th>
                        <th width="40%" class="sorting"  aria-controls="task-table"  aria-label="">Title</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Reference drawing</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Start date</th>
                        <th width="6%" class="sorting"  aria-controls="task-table"  aria-label="">Deadline</th>
                        <th width="12%" class="min-w150 sorting"  aria-controls="task-table"  aria-label="">Assigned to</th>
                        <th width="8%" class="sorting_disabled"  aria-label="">Status</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label=""></th>
                    </tr>
                </thead>
            </table>
        </li>
        <?php $index = 0; foreach ($columns as $column) { ?>
            <div class="kanban-list-col kanban-<?php
            echo $column->id;
            $tasks = get_array_value($tasks_list, $column->id);
            $tasks_count = count($tasks);
            $index++;
            if (!$tasks) {
                $tasks = array();
            }
            ?>" >
                <input checked type="checkbox" id="list-item-<?php echo $column->id;?>">
                <label for="list-item-<?php echo $column->id;?>" class="kanban-list-col-title  mt20 mb10" style="background-color: <?php echo $column->color ? $column->color : "#2e4053"; ?>;"> <?php echo $column->title; ?> <span class="kanban-item-count <?php echo $column->id; ?>-task-count float-end ml10"><?php echo $tasks_count; ?> </span></label>

                <div class="kanban-input general-form hide">
                    <?php
                    echo form_input(array(
                        "id" => "title",
                        "name" => "title",
                        "value" => "",
                        "class" => "form-control",
                        "placeholder" => app_lang('add_a_task')
                    ));
                    ?>
                </div>

                <table class="w-100 display dataTable no-footer" id="kanban-item-list-<?php echo $column->id; ?>" class="kanban-list-items" data-status_id="<?php echo $column->id; ?>">
                <thead style="visibility:collapse;">
                    <tr role="row">
                        <th width="50px" class="sorting"  aria-controls="task-table"  aria-sort="descending" aria-label=""></th>
                        <th width="10%" class="sorting"  aria-controls="task-table"  aria-label="">Dock list number</th>
                        <th width="40%" class="sorting"  aria-controls="task-table"  aria-label="">Title</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Reference drawing</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Start date</th>
                        <th width="6%" class="sorting"  aria-controls="task-table"  aria-label="">Deadline</th>
                        <th width="12%" class="min-w150 sorting"  aria-controls="task-table"  aria-label="">Assigned to</th>
                        <th width="8%" class="sorting_disabled"  aria-label="">Status</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label=""></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo view("tasks/kanban/kanban_list_column_items", array(
                        "tasks" => $tasks,
                        "can_edit_project_tasks" > $can_edit_project_tasks,
                        "project_id" > $project_id,
                        "tasks_edit_permissions"=> get_array_value($tasks_edit_permissions_list, $column->id)
                    ));
                    ?>
                </tbody>
                </table>
            </div>
        <?php } ?>

    </ul>
</div>

<img id="move-icon" class="hide" src="<?php echo get_file_uri("assets/images/move.png"); ?>" alt="..." />

<script type="text/javascript">
    var kanbanContainerWidth = "";

    adjustViewHeightWidth = function () {

        if (!$("#kanban-list-container").length) {
            return false;
        }


        var totalColumns = "<?php echo count($columns); ?>";
        var columnWidth = (335 * totalColumns) + 5;

        $("#kanban-list-container").css({width: "100%"});


        //set wrapper scroll
        if ($("#kanban-wrapper")[0].offsetWidth < $("#kanban-wrapper")[0].scrollWidth) {
            $("#kanban-wrapper").css("overflow-x", "scroll");
        } else {
            $("#kanban-wrapper").css("overflow-x", "hidden");
        }


        //set column scroll

        $(".kanban-list-items").each(function (index) {

            //set scrollbar on column... if requred
            if ($(this)[0].offsetHeight < $(this)[0].scrollHeight) {
                $(this).css("overflow-y", "scroll");
            } else {
                $(this).css("overflow-y", "hidden");
            }

        });
    };


    saveStatusAndSort = function ($item, status) {
        appLoader.show();
        adjustViewHeightWidth();

        var $prev = $item.prev(),
                $next = $item.next(),
                prevSort = 0, nextSort = 0, newSort = 0,
                step = 100000, stepDiff = 500,
                id = $item.attr("data-id"),
                project_id = $item.attr("data-project_id");

        if ($prev && $prev.attr("data-sort")) {
            prevSort = $prev.attr("data-sort") * 1;
        }

        if ($next && $next.attr("data-sort")) {
            nextSort = $next.attr("data-sort") * 1;
        }


        if (!prevSort && nextSort) {
            //item moved at the top
            newSort = nextSort - stepDiff;

        } else if (!nextSort && prevSort) {
            //item moved at the bottom
            newSort = prevSort + step;

        } else if (prevSort && nextSort) {
            //item moved inside two items
            newSort = (prevSort + nextSort) / 2;

        } else if (!prevSort && !nextSort) {
            //It's the first item of this column
            newSort = step * 100; //set a big value for 1st item
        }

        $item.attr("data-sort", newSort);


        $.ajax({
            url: '<?php echo_uri("tasks/save_task_sort_and_status") ?>',
            type: "POST",
            data: {id: id, sort: newSort, status_id: status, project_id: project_id},
            success: function () {
                appLoader.hide();

                if (isMobile()) {
                    adjustViewHeightWidth();
                }
            }
        });

    };


    setLoadmoreButton = function () {
        $(".kanban-item-count").each(function () {
            var count = $(this).html();

            var $columnItems = $(this).closest(".kanban-col").find(".kanban-list-items").find("a.kanban-item");
            if (count > $columnItems.length) {
                $columnItems.closest(".kanban-list-items").addClass("js-load-more-on-scroll");
            } else {
                $columnItems.closest(".kanban-list-items").removeClass("js-load-more-on-scroll");
            }

        });
    };


    $(document).ready(function () {
        kanbanContainerWidth = $("#kanban-list-container").width();

        if (isMobile() && window.scrollToKanbanContent) {
            window.scrollTo(0, 220); //scroll to the content for mobile devices
            window.scrollToKanbanContent = false;
        }

        var isChrome = !!window.chrome && !!window.chrome.webstore;


<?php if ($login_user->user_type == "staff" || ($login_user->user_type == "client" && $can_edit_project_tasks)) { ?>
            $(".kanban-list-items").each(function (index) {
                var id = this.id;

                var options = {
                    animation: 150,
                    group: "kanban-list-items",
                    filter: ".disable-dragging",
                    cancel: ".disable-dragging",
                    onAdd: function (e, x) {
                        //moved to another column. update bothe sort and status
                        var status_id = $(e.item).closest(".kanban-list-items").attr("data-status_id");
                        saveStatusAndSort($(e.item), status_id);

                        var $countContainer = $("." + status_id + "-task-count");
                        $countContainer.html($countContainer.html().trim() * 1 + 1);
                        var $item = $(e.item);
                        setTimeout(function () {
                            $item.attr("data-status_id", status_id); //update status id in data.
                        });
                    },
                    onRemove: function (e, x) {
                        var status_id = $(e.item)[0].dataset.status_id;
                        var $countContainer = $("." + status_id + "-task-count");
                        $countContainer.html($countContainer.html().trim() * 1 - 1);
                    },
                    onUpdate: function (e) {
                        //updated sort
                        saveStatusAndSort($(e.item));
                    }
                };

                //apply only on chrome because this feature is not working perfectly in other browsers.
                if (isChrome) {
                    options.setData = function (dataTransfer, dragEl) {
                        var img = document.createElement("img");
                        img.src = $("#move-icon").attr("src");
                        img.style.opacity = 1;
                        dataTransfer.setDragImage(img, 5, 10);
                    };

                    options.ghostClass = "kanban-sortable-ghost";
                    options.chosenClass = "kanban-sortable-chosen";
                }

                Sortable.create($("#" + id)[0], options);
            });
<?php } ?>

        //add activated sub task filter class
        if ($(".custom-filter-search").val().substring(0, 1) === "#") {
            $("#kanban-list-container").find("[main-task-id='" + $(".custom-filter-search").val() + "']").addClass("sub-task-filter-kanban-active");
        }

        adjustViewHeightWidth();

        $('[data-bs-toggle="tooltip"]').tooltip();

    });


    $(window).resize(function () {
        adjustViewHeightWidth();
    });
    function delete_task(task_id){
        if(confirm("Are you sure to delete this task? This action is not able to undo.")){
            $.ajax({
                url: '<?php echo_uri("tasks/delete"); ?>/',
                type: 'POST',
                data:{id:task_id},
                // dataType: 'json',
                // data: {value: $(this).attr('data-value')},
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    }


</script>

<?php echo view("tasks/update_task_read_comments_status_script"); ?>
<?php echo view("tasks/task_table_common_script"); ?>