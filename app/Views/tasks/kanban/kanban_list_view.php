<div id="kanban-wrapper"  >
    <ul id="kanban-list-container" class="card kanban-list-container clearfix">
        <li class="kanban-list-col kanban--1" >
            <div id="kanban-item-list--1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="filter-section-container">
                    <div class="filter-section-flex-row">
                        <div class="filter-section-left">
                            <div class="filter-item-box">
                                <button class="btn btn-default column-show-hide-popover" data-container="body" data-bs-toggle="popover" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-columns icon-16"><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="filter-section-right">
                            <div class="datatable-export filter-item-box">
                                <div class="dt-buttons btn-group flex-wrap"> 
                                    <button class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="kanban-item-list--1" type="button"><span>Excel</span>
                                    </button> 
                                    <button class="btn btn-default buttons-print" tabindex="0" aria-controls="kanban-item-list--1" type="button">
                                        <span>Print</span>
                                    </button> 
                                </div>
                            </div>
                            <div class="filter-item-box">
                                <div id="kanban-item-list--1_filter" class="dataTables_filter">
                                    <label><input type="search" class="form-control form-control-sm" placeholder="Search" aria-controls="kanban-item-list--1"></label>
                                </div>
                            </div></div>
                        </div>
                        <div id="kanban-item-list--1_processing" class="dataTables_processing card" style="display: none;"><div class="table-loader"><span class="loading"></span>
                        </div>
                    </div>
                </div>
                <table table-id="headers-table" class="w-100 display dataTable no-footer" id="kanban-item-list--1" data-status_id="-1" role="grid" aria-describedby="kanban-item-list--1_info">
                    <thead>
                        <tr role="row">
                            <th style="width:50px;" class="sorting" tabindex="0" aria-controls="kanban-item-list--1" rowspan="1" colspan="1" aria-label="select: activate to sort column ascending">
                                <input class="form-check-input input-check-library" type="checkbox"/>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" style="width:10%;" rowspan="1" colspan="1" aria-label="Dock list number: activate to sort column ascending">Dock list number</th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" style="width:27%;" rowspan="1" colspan="1" aria-label="Title: activate to sort column ascending">Title</th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" style="width:8%;" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Start date</th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" style="width:6%;" rowspan="1" colspan="1" aria-label="Deadline: activate to sort column ascending">Deadline</th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" style="width:6%;"  rowspan="1" colspan="1" aria-label="Milestone: activate to sort column ascending">Milestone</th>
                            <th class="sorting" tabindex="0" aria-controls="kanban-item-list--1"   rowspan="1" colspan="1" aria-label="Supplier: activate to sort column ascending">Supplier</th>
                            <th class="sorting_desc" tabindex="0" aria-controls="kanban-item-list--1" rowspan="1" colspan="1" aria-label="Assigned to: activate to sort column ascending" aria-sort="descending">Assigned to</th><th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" rowspan="1" colspan="1" aria-label="Collaborators: activate to sort column ascending">Collaborators</th><th class="sorting" tabindex="0" aria-controls="kanban-item-list--1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th><th class="text-center option w150 sorting" tabindex="0" aria-controls="kanban-item-list--1" rowspan="1" colspan="1" aria-label=": activate to sort column ascending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu icon-16"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></th>
                        </tr>
                    </thead>
                </table>
        </li>
        <?php $index = 0;
        
        foreach ($columns as $column) { ?>
            <div class="kanban-list-col kanban-<?php
            echo $column['id'];
            $tasks = get_array_value($tasks_list, $column['id']);
            if (!$tasks) {
                $tasks = array();
            }
            $tasks_count = count($tasks);
            $index++;
            
            ?>" >
                <input checked type="checkbox" id="list-item-<?php echo $column['id'];?>">
                <!-- <label for="list-item-<?php //echo $column['id'];?>" class="kanban-list-col-title  mt20 mb10" style="background-color: <?php //echo $column->color ? $column->color : "#2e4053"; ?>;"> <?php //echo $column->title; ?> <span class="kanban-item-count <?php //echo $column['id']; ?>-task-count float-end ml10"><?php //echo $tasks_count; ?> </span></label> -->
                <label for="list-item-<?php echo $column['id'];?>" class="kanban-list-col-title  mt20 mb10" style="background-color: <?php echo  "#2e4053"; ?>;"> <?php echo $column['text']; ?> <span class="kanban-item-count <?php echo $column['id']; ?>-task-count float-end ml10"><?php echo $tasks_count; ?> </span></label>
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
                <div id="task-table" >
                <table class="w-100 display dataTable no-footer kanban-list-items" id="kanban-item-list-<?php echo $column['id']; ?>"  data-status_id="<?php echo $column['id']; ?>">
                <thead style="visibility:collapse;">
                    <tr role="row">
                        <th width="50px" class="sorting"  aria-controls="task-table"  aria-sort="descending" aria-label=""></th>
                        <th width="10%" class="sorting"  aria-controls="task-table"  aria-label="">Dock list number</th>
                        <th width="30%" class="sorting"  aria-controls="task-table"  aria-label="">Title</th>
                        <!-- <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Reference drawing</th> -->
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Start date</th>
                        <th width="6%" class="sorting"  aria-controls="task-table"  aria-label="">Deadline</th>
                        <th width="6%" class="sorting"  aria-controls="task-table"  aria-label="">Milestones</th>
                        <th width="6%" class="sorting"  aria-controls="task-table"  aria-label="">Suppliers</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Assigned to</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label="">Collaborators</th>
                        <th width="8%" class="sorting_disabled"  aria-label="">Status</th>
                        <th width="8%" class="sorting"  aria-controls="task-table"  aria-label=""></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo view("tasks/kanban/kanban_list_column_items", array(
                        "tasks" => $tasks,
                        "allStatus"=>$allStatus,
                        "can_edit_project_tasks" > $can_edit_project_tasks,
                        "project_id" > $project_id,
                        "tasks_edit_permissions"=> get_array_value($tasks_edit_permissions_list, $column['id'])
                    ));
                    ?>
                </tbody>
                </table>
                </div>
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
        if ($(".custom-filter-search").val()&&$(".custom-filter-search").val().substring(0, 1) === "#") {
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
    // $(document).ready(function(){
    //     $("[table-id=headers-table]").appTable({
    //         order: [[0, "desc"]],
    //         source:'<?php //echo get_uri('projects/task_list_headers');?>',
    //         columns: [
    //             {title: 'Dock list number',style:"width:50px;"},
    //             {title: 'Title',style:"width:10%;"},
    //             {title: 'Start date',style:"width:30%;"},
    //             {title: 'Deadline',style:"width:8%;"},
    //             {title: 'Milestone',style:"width:6%;"},
    //             {title: 'Supplier',style:"width:6%;"},
    //             {title: 'Assigned to',style:"width:6%;"},
    //             {title: 'Collaborators',style:"width:12%;"},
    //             {title: 'Status',style:"width:8%;"},
    //             {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w150"}
    //         ],
    //         printColumns: combineCustomFieldsColumns([0, 1, 2, 3, 4, 5], '<?php //echo $custom_field_headers; ?>'),
    //         xlsColumns: combineCustomFieldsColumns([0, 1, 2, 3, 4, 5], '<?php //echo $custom_field_headers; ?>')
    //     });
    // });

</script>

<?php echo view("tasks/update_task_read_comments_status_script"); ?>
<?php echo view("tasks/task_table_common_script"); ?>