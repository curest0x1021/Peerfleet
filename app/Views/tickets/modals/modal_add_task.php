<div class="modal-body clearfix" >
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3"><?php echo app_lang('title'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "title",
                    "name" => "title",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('title'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "description",
                    "name" => "description",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('description'),
                    "data-rich-text-editor" => true
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="assigned_to" class=" col-md-3"><?php echo app_lang('assigned_to'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "assigned_to",
                    "name" => "assigned_to",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('assigned_to'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="collaborators" class=" col-md-3"><?php echo app_lang('collaborators'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "collaborators",
                    "name" => "collaborators",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('collaborators'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="start_date" class=" col-md-3"><?php echo app_lang('start_date'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "start_date",
                    "name" => "start_date",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('start_date'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="deadline" class=" col-md-3"><?php echo app_lang('deadline'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "deadline",
                    "name" => "deadline",
                    "value" => "",
                    "class" => "form-control",
                    "placeholder" => app_lang('deadline'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" >
    <!-- <button  class="btn btn-default" data-bs-dismiss="modal" >Close</button> -->
    <button  class="btn btn-default btn-cancel-task"  ><i data-feather="x" class="icon-16" ></i>Cancel</button>
    <button  class="btn btn-primary btn-save-task"  ><i data-feather="check-cirlce" class="icon-16" ></i>Save</button>
</div>
<script>
    $(document).ready(function(){
        $(".btn-cancel-task").on("click",function(){
            var $newViewLink = $("#link-of-new-view").find("a");
            $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_add_corrective_action/".$ticket_id); ?>");
            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
            $newViewLink.attr("data-post-id", <?php echo $ticket_id;?>);
            $newViewLink.trigger("click");
        })
    })
</script>