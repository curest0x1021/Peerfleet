<div id="kanban-wrapper">
    <?php
    load_css(array(
        "assets/css/todo.css",
    ));
    $columns_data = array();

    foreach ($data as $item) {

        $exising_items = get_array_value($columns_data, $item->status);
        if (!$exising_items) {
            $exising_items = "";
        }

        $todo_labels = "";
        $todo_checklist_status = "";
        $checklist_label_color = "#6690F4";

        if ($item->total_checklist_checked <= 0) {
            $checklist_label_color = "#E18A00";
        } else if ($item->total_checklist_checked == $item->total_checklist) {
            $checklist_label_color = "#01B392";
        }

        if ($item->total_checklist) {
            $todo_checklist_status .= "<div class='meta float-start badge rounded-pill mr5' style='background-color:$checklist_label_color'><span data-bs-toggle='tooltip' title='" . app_lang("checklist_status") . "'><i data-feather='check' class='icon-14'></i> $item->total_checklist_checked/$item->total_checklist</span></div>";
        }

        $labels_data = make_labels_view_data($item->labels_list);

        if ($labels_data) {
            $todo_labels .= "<div class='meta float-start mr5'>" . $labels_data . "</div>";
        }

        $priority = "";
        if ($item->priority_id) {
            $priority = "<div class='meta float-start mr5' title='" . app_lang('priority') . "'><span class='sub-task-icon priority-badge' style='background: $item->priority_color'><i data-feather='$item->priority_icon' class='icon-14'></i></span><span class='small'> $item->priority_title</span></div>";
        }

        $disable_dragging = can_edit_this_todo($item->created_by) ? "" : "disable-dragging";

        $start_date = "";
        if ($item->start_date) {
            $start_date = "<div class='mt10 font-12 float-start' title='" . app_lang("start_date") . "'><i data-feather='calendar' class='icon-14 text-off mr5'></i> " . format_to_date($item->start_date, false) . "</div>";
        }

        $deadline_text = "-";
        if ($item->deadline && is_date_exists($item->deadline)) {
            $deadline_text = format_to_date($item->deadline, false);
            if (get_my_local_time("Y-m-d") > $item->deadline && $item->status != "done") {
                $deadline_text = "<span class='text-danger'>" . $deadline_text . "</span> ";
            } else if (get_my_local_time("Y-m-d") == $item->deadline && $item->status != "done") {
                $deadline_text = "<span class='text-warning'>" . $deadline_text . "</span> ";
            }
        }

        $end_date = "";
        if ($item->deadline) {
            $end_date = "<div class='mt10 font-12 float-end' title='" . app_lang("deadline") . "'><i data-feather='calendar' class='icon-14 text-off mr5'></i> " . $deadline_text . "</div>";
        }

        $new_item = "<div class='d-block'>";
        $new_item .= "<div class='clearfix todo_kanban_title'>" . $item->title . "</div>";
        // $new_item .= "<div class='clearfix todo_kanban_description'>" . $item->description . "</div>";
        $new_item .= "<div class='clearfix'>" . $start_date . $end_date . "</div>";
        $new_item .= $todo_labels . $todo_checklist_status . $priority;
        $new_item .= "</div>";

        $temp = $exising_items . modal_anchor(get_uri("todo/view"), $new_item, array("class" => "kanban-item $disable_dragging", "data-id" => $item->id, "data-sort" => $item->new_sort, "data-post-id" => $item->id, "title" => app_lang('todo') . " #$item->id", "data-modal-lg" => "1"));

        $columns_data[$item->status] = $temp;
    }
    ?>

    <ul id="kanban-container" class="kanban-container clearfix">

        <?php foreach ($columns as $column) { ?>
            <li class="kanban-col kanban-<?php echo $column->id; ?>" >
                <div class="kanban-col-title" style="border-bottom: 3px solid <?php echo $column->color ? $column->color : "#2e4053"; ?>;"> <?php echo $column->key_name ? app_lang($column->key_name) : $column->title; ?> <span class="<?php echo $column->id; ?>-todo-count float-end"></span></div>

                <div  id="kanban-item-list-<?php echo $column->key_name; ?>" class="kanban-item-list" data-status="<?php echo $column->key_name; ?>">
                    <?php echo get_array_value($columns_data, $column->key_name); ?>
                </div>
            </li>
        <?php } ?>

    </ul>
</div>

<img id="move-icon" class="hide" src="<?php echo get_file_uri("assets/images/move.png"); ?>" alt="..." />

<script type="text/javascript">
    var kanbanContainerWidth = "";

    adjustViewHeightWidth = function () {

        if (!$("#kanban-container").length) {
            return false;
        }


        var totalColumns = "<?php echo $total_columns ?>";
        var columnWidth = (335 * totalColumns) + 5;

        if (columnWidth > kanbanContainerWidth) {
            $("#kanban-container").css({width: columnWidth + "px"});
        } else {
            $("#kanban-container").css({width: "100%"});
        }


        //set wrapper scroll
        if ($("#kanban-wrapper")[0].offsetWidth < $("#kanban-wrapper")[0].scrollWidth) {
            $("#kanban-wrapper").css("overflow-x", "scroll");
        } else {
            $("#kanban-wrapper").css("overflow-x", "hidden");
        }


        //set column scroll

        var columnHeight = $(window).height() - $(".kanban-item-list").offset().top - 57;
        if (isMobile()) {
            columnHeight = $(window).height() - 30;
        }

        $(".kanban-item-list").height(columnHeight);

        $(".kanban-item-list").each(function (index) {

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
            url: '<?php echo_uri("todo/save_todo_sort_and_status") ?>',
            type: "POST",
            data: {id: id, sort: newSort, status: status},
            success: function () {
                appLoader.hide();

                if (isMobile()) {
                    adjustViewHeightWidth();
                }
            }
        });

    };



    $(document).ready(function () {
        kanbanContainerWidth = $("#kanban-container").width();

        if (isMobile() && window.scrollToKanbanContent) {
            window.scrollTo(0, 220); //scroll to the content for mobile devices
            window.scrollToKanbanContent = false;
        }

        var isChrome = !!window.chrome && !!window.chrome.webstore;


        $(".kanban-item-list").each(function (index) {
            var id = this.id;

            var options = {
                animation: 150,
                group: "kanban-item-list",
                filter: ".disable-dragging",
                cancel: ".disable-dragging",
                onAdd: function (e) {
                    //moved to another column. update bothe sort and status
                    saveStatusAndSort($(e.item), $(e.item).closest(".kanban-item-list").attr("data-status"));

                    update_counts();
                },
                onUpdate: function (e) {
                    //updated sort
                    saveStatusAndSort($(e.item));

                    update_counts();
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

        adjustViewHeightWidth();

        update_counts();

        $('[data-bs-toggle="tooltip"]').tooltip();

    });


    function update_counts() {
<?php foreach ($columns as $column) { ?>
            $('.<?php echo $column->id; ?>-todo-count').html($('.kanban-<?php echo $column->id; ?>').find('.kanban-item').length);
<?php } ?>
    }

    $(window).resize(function () {
        adjustViewHeightWidth();
    });

</script>
