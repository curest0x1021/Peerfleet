<div class="modal-body clearfix">
    <?php echo form_open(get_uri("tickets/save_task"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close(); ?>
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <input hidden class="input-action-id" value="<?php if (isset($action_info))
        echo $action_info->id; ?>" />
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3"><?php echo app_lang('title'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "title",
                        "name" => "title",
                        "value" => "",
                        "class" => "form-control input-task-title",
                        "placeholder" => app_lang('title'),
                        "value" => isset($action_info) ? $action_info->task_title : "",
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(
                    array(
                        "id" => "description",
                        "name" => "description",
                        "class" => "form-control input-task-description",
                        "placeholder" => app_lang('description'),
                        "value" => isset($action_info) ? $action_info->task_description : "",
                        "data-rich-text-editor" => true,
                        "style" => "height:15vh"
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="assigned_to" class=" col-md-3"><?php echo app_lang('assigned_to'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "assigned_to",
                        "name" => "assigned_to",
                        "value" => "",
                        "class" => "form-control  input-task-assigned-to",
                        "placeholder" => app_lang('assigned_to'),
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="collaborators" class=" col-md-3"><?php echo app_lang('collaborators'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "collaborators",
                        "name" => "collaborators",
                        "value" => "",
                        "class" => "form-control  input-task-collaborators",
                        "placeholder" => app_lang('collaborators'),
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="start_date" class=" col-md-3"><?php echo app_lang('start_date'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "start_date",
                        "name" => "start_date",
                        "class" => "form-control  input-task-start-date",
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                        "placeholder" => "YYYY-MM-DD",
                        "autocomplete" => true,
                        // "value" => isset($action_info) ? (date('d.m.Y', strtotime($action_info->task_start_date))) : "",
                        // "placeholder" => app_lang('start_date'),
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="deadline" class=" col-md-3"><?php echo app_lang('deadline'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "deadline",
                        "name" => "deadline",
                        "class" => "form-control input-task-deadline",
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                        "placeholder" => "YYYY-MM-DD",
                        "autocomplete" => true,
                        // "value" => isset($action_info) ? (date('d.m.Y', strtotime($action_info->task_deadline))) : "",
                        // "placeholder" => app_lang('deadline'),
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <!-- <button  class="btn btn-default" data-bs-dismiss="modal" >Close</button> -->
    <?php echo modal_anchor(get_uri("tickets/modal_add_corrective_action/" . $ticket_id), '<button  class="btn btn-default btn-cancel-task"  ><i data-feather="x" class="icon-16" ></i>Cancel</button>', array("title" => "Add corrective action")); ?>
    <button class="btn btn-primary btn-save-task"><i data-feather="check" class="icon-16"></i>Save</button>
</div>
<script>
    $(document).ready(function () {
        setDatePicker(".input-task-start-date");
        setDatePicker(".input-task-deadline");
        $(".btn-save-task").on("click", function () {
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            const id = "<?php echo $action_info->id; ?>";
            const title = $(".input-task-title")[0].value;
            const description = $(".input-task-description")[0].value;
            const assigned_to = $(".input-task-assigned-to")[0].value;
            const collaborators = $(".input-task-collaborators")[0].value;
            const start_date = $(".input-task-start-date")[0].value;
            const deadline = $(".input-task-deadline")[0].value;
            var myForm = new FormData();
            myForm.append("rise_csrf_token", rise_csrf_token);
            myForm.append("id", id);
            myForm.append("title", title);
            myForm.append("description", description);
            myForm.append("assigned_to", assigned_to);
            myForm.append("collaborators", collaborators);
            myForm.append("start_date", start_date);
            myForm.append("deadline", deadline);
            $.ajax({
                url: "<?php echo get_uri("tickets/save_task"); ?>",
                type: "POST",
                data: myForm,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false,
                success: function (response) {
                    if (JSON.parse(response).success) {
                        var $newViewLink = $("#link-of-new-view").find("a");
                        $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_corrective_action/" . $action_info->id); ?>");
                        // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
                        $newViewLink.attr("data-post-id", <?php echo $ticket_id; ?>);
                        $newViewLink.trigger("click");
                    }
                }
            })
        })
    })
</script>