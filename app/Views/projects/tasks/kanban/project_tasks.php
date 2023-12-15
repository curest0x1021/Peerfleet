<div class="card">
    <ul id="project-files-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li class="nav-item title-tab"><h4 class="pl15 pt10 pr15"><?php echo app_lang('tasks') . " " . app_lang('kanban'); ?></h4></li>

        <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("tasks/project_tasks_kanban_kanban/" . $project_id); ?>" data-bs-target="#kanban-tasks-tab"><?php echo app_lang('kanban'); ?></a></li>
        <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("tasks/project_tasks_kanban_list/" . $project_id); ?>" data-bs-target="#list-tasks-tab"><?php echo app_lang('list'); ?></a></li>

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
            <?php
            if ($login_user->user_type == "staff" && $can_edit_tasks) {
                echo modal_anchor("", "<i data-feather='edit' class='icon-16'></i> " . app_lang('batch_update'), array("class" => "btn btn-info text-white hide batch-update-btn", "title" => app_lang('batch_update'), "data-post-project_id" => $project_id));
                echo js_anchor("<i data-feather='check-square' class='icon-16'></i> " . app_lang("cancel_selection"), array("class" => "hide btn btn-default batch-cancel-btn"));
            }
            if ($can_create_tasks) {
                echo modal_anchor(get_uri("tasks/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_multiple_tasks'), array("class" => "btn btn-default", "title" => app_lang('add_multiple_tasks'), "data-post-project_id" => $project_id, "data-post-add_type" => "multiple"));
                echo modal_anchor(get_uri("tasks/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_task'), array("class" => "btn btn-default", "title" => app_lang('add_task'), "data-post-project_id" => $project_id));
            }
            ?>
            </div>
        </div>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="kanban-tasks-tab"></div>
        <div role="tabpanel" class="tab-pane fade" id="list-tasks-tab"></div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function () {
    });
</script>