<div class="card">
    <ul id="project-files-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li class="nav-item title-tab"><h4 class="pl15 pt10 pr15"><?php echo app_lang("checklist"); ?></h4></li>

        <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("checklist_template"); ?>" data-bs-target="#task-checklist-template-tab"><?php echo app_lang('checklist_template'); ?></a></li>
        <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("checklist_groups"); ?>" data-bs-target="#task-checklist-group-tab"><?php echo app_lang('checklist_group'); ?></a></li>

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("checklist_template/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import'), array("class" => "btn btn-default", "title" => app_lang('import'))); ?>
                <?php echo modal_anchor(get_uri("checklist_template/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_checklist_template'), array("class" => "btn btn-default", "title" => app_lang('add_checklist_template'), "id" => "add_checklist-button")); ?>
            </div>
        </div>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="task-checklist-template-tab"></div>
        <div role="tabpanel" class="tab-pane fade" id="task-checklist-group-tab"></div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function () {
//change the add button attributes on changing tab panel
        var addButton = $("#add_checklist-button");
        $(".nav-tabs li").click(function () {
            var activeField = $(this).find("a").attr("data-bs-target");
            if (activeField === "#task-checklist-template-tab") { //checklist template
                addButton.removeClass("hide");
                addButton.attr("title", "<?php echo app_lang("add_checklist_template"); ?>");
                addButton.attr("data-title", "<?php echo app_lang("add_checklist_template"); ?>");
                addButton.attr("data-action-url", "<?php echo get_uri("checklist_template/modal_form"); ?>");

                addButton.html("<?php echo "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_checklist_template'); ?>");
                feather.replace();
            } else if (activeField === "#task-checklist-group-tab") {
                addButton.removeClass("hide");
                addButton.attr("title", "<?php echo app_lang("add_checklist_group"); ?>");
                addButton.attr("data-title", "<?php echo app_lang("add_checklist_group"); ?>");
                addButton.attr("data-action-url", "<?php echo get_uri("checklist_groups/modal_form"); ?>");

                addButton.html("<?php echo "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_checklist_group'); ?>");
                feather.replace();
            }

            feather.replace();
        });
    });
</script>