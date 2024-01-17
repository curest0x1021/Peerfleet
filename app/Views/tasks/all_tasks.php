<div id="page-content" class="page-wrapper pb0 clearfix grid-button all-tasks-kanban-view">

    <ul class="nav nav-tabs bg-white title" role="tablist">
        <li class="title-tab all-tasks-kanban"><h4 class="pl15 pt10 pr15"><?php echo app_lang("tasks"); ?></h4></li>

        <?php echo view("tasks/tabs", array("active_tab" => "tasks_list", "selected_tab" => "")); ?>       

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
                <?php
                if ($login_user->user_type == "staff") {
                    echo modal_anchor(get_uri("labels/modal_form"), "<i data-feather='tag' class='icon-16'></i> " . app_lang('manage_categories'), array("class" => "btn btn-outline-light", "title" => app_lang('manage_categories'), "data-post-type" => "task"));
                    echo modal_anchor("", "<i data-feather='edit-2' class='icon-16'></i> " . app_lang('batch_update'), array("class" => "btn btn-info text-white hide batch-update-btn", "title" => app_lang('batch_update')));
                    echo js_anchor("<i data-feather='x' class='icon-16'></i> " . app_lang("cancel_selection"), array("class" => "hide btn btn-default batch-cancel-btn"));
                }
                if ($can_create_tasks) {
                    // echo modal_anchor(get_uri("projects/task_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_multiple_tasks'), array("class" => "btn btn-default", "title" => app_lang('add_multiple_tasks'), "data-post-add_type" => "multiple"));
                    echo modal_anchor(get_uri("tasks/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_task'), array("class" => "btn btn-default", "title" => app_lang('add_task')));
                }
                ?>
            </div>
        </div>
    </ul>
    <div class="bg-white kanban-filters-container">
        <div class="row">
            <div id="kanban-filters" class="col-md-12 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <button class="btn btn-default" id="reload-kanban-button"><i data-feather="refresh-cw" class="icon-16"></i></button>
            </div>
            
        </div>
        
    </div>

    <div id="load-kanban-list"></div>
</div>

<script>
    $(document).ready(function () {
        window.scrollToKanbanContent = true;
    });
</script>

<?php echo view("tasks/batch_update/batch_update_script"); ?>
<?php echo view("tasks/kanban/all_tasks_list_helper_js"); ?>
<?php echo view("tasks/quick_filters_helper_js"); ?>