<div class="card mb0 mt10">
    <ul id="project-files-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li class="nav-item title-tab"><h4 class="pl15 pt10 pr15"><?php echo app_lang('tasks') . " " . app_lang('kanban'); ?></h4></li>

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
            <?php
            if ($login_user->user_type == "staff" && $can_edit_tasks) {
                echo modal_anchor("", "<i data-feather='edit' class='icon-16'></i> " . app_lang('batch_update'), array("class" => "btn btn-info text-white hide batch-update-btn", "title" => app_lang('batch_update'), "data-post-project_id" => $project_id));
                echo js_anchor("<i data-feather='check-square' class='icon-16'></i> " . app_lang("cancel_selection"), array("class" => "hide btn btn-default batch-cancel-btn"));
            }
            if ($can_create_tasks) {
                echo modal_anchor(get_uri("tasks/modal_import_from_gl_shipmanager/".$project_id), "<i data-feather='upload' class='icon-16'></i> " . "Import xlsx from GL Shipmanager", array("class" => "btn btn-default import_libraries_btn", "title" => "Import xlsx from GL shipmanager"));
                echo modal_anchor(get_uri("tasks/modal_apply/".$project_id), "<i data-feather='upload' class='icon-16'></i> " . "Import task templates", array("class" => "btn btn-default import_libraries_btn", "title" => "Import from libraries"));
                echo modal_anchor(get_uri("tasks/modal_form_new/".$project_id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_multiple_tasks'), array("class" => "btn btn-default", "title" => app_lang('add_multiple_tasks'), "data-post-project_id" => $project_id, "data-post-add_type" => "multiple"));
                echo modal_anchor(get_uri("tasks/modal_form_new/".$project_id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_task'), array("class" => "btn btn-default", "title" => app_lang('add_task'), "data-post-project_id" => $project_id));
                echo modal_anchor(get_uri("tasks/import_tasks_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_tasks'), array("class" => "btn btn-default import_tasks_btn", "title" => app_lang('import_tasks'), "data-post-project_id" => $project_id));
                echo modal_anchor(get_uri("tasks/export_project_modal_form"), "<i data-feather='external-link' class='icon-16'></i> " . app_lang('export'), array("class" => "btn btn-default export-excel-btn", "title" => app_lang('export_project'), "data-post-project_id" => $project_id));
            }
            

            ?>
            </div>
        </div>
    </ul>
    <div class="bg-white">
        <div id="kanban-filters"></div>
             
    </div>
</div>
<div id="load-kanban"></div>

<script type="text/javascript">

    $(document).ready(function () {
        var filterDropdown = [];
        $(".modal-dialog").removeClass("modal-lg");
        $(".modal-dialog").addClass("modal-xl");


        if ("<?php echo $login_user->user_type ?>" == "staff") {
            filterDropdown = [
                {name: "quick_filter", class: "w200", showHtml: true, options: <?php echo view("tasks/quick_filters_dropdown"); ?>},
                {name: "milestone_id", class: "w200", options: <?php echo $milestone_dropdown; ?>},
                {name: "priority_id", class: "w200", options: <?php echo $priorities_dropdown; ?>},
                {name: "label_id", class: "w200", options: <?php echo $labels_dropdown; ?>},
                {name: "specific_user_id", class: "w200", options: <?php echo $assigned_to_dropdown; ?>}
                , <?php echo $custom_field_filters; ?>
            ];
        } else {
<?php if ($show_milestone_info) { ?>
                filterDropdown = [
                    {name: "milestone_id", class: "w200", options: <?php echo $milestone_dropdown; ?>}
                    , <?php echo $custom_field_filters; ?>
                ];
<?php } else { ?>
                filterDropdown = [<?php echo $custom_field_filters; ?>];
<?php } ?>
        }

        var smartFilter = "project_tasks_kanban"; //a to z and _ only. should be unique to avoid conflicts 
        if ("<?php echo $login_user->user_type ?>" == "client") {
            smartFilter = false;
        }

        var scrollLeft = 0;
        $("#kanban-filters").appFilters({
            source: '<?php echo_uri("tasks/project_tasks_kanban_data/" . $project_id) ?>',
            targetSelector: '#load-kanban',
            reloadSelector: "#reload-kanban-button",
            smartFilterIdentity: smartFilter,
            contextMeta: {contextId: "<?php echo $project_id; ?>", dependencies: ["milestone_id"]}, //useful to seperate instance related filters. Ex. Milestones are different for each projects. 
            search: {name: "search"},
            filterDropdown: filterDropdown,
            singleDatepicker: [{name: "deadline", defaultText: "<?php echo app_lang('deadline') ?>", class: "w200",
                    options: [
                        {value: "expired", text: "<?php echo app_lang('expired') ?>"},
                        {value: moment().format("YYYY-MM-DD"), text: "<?php echo app_lang('today') ?>"},
                        {value: moment().add(1, 'days').format("YYYY-MM-DD"), text: "<?php echo app_lang('tomorrow') ?>"},
                        {value: moment().add(7, 'days').format("YYYY-MM-DD"), text: "<?php echo sprintf(app_lang('in_number_of_days'), 7); ?>"},
                        {value: moment().add(15, 'days').format("YYYY-MM-DD"), text: "<?php echo sprintf(app_lang('in_number_of_days'), 15); ?>"}
                    ]}],
            beforeRelaodCallback: function () {
                scrollLeft = $("#kanban-wrapper").scrollLeft();
            },
            afterRelaodCallback: function () {
                setTimeout(function () {
                    $("#kanban-wrapper").animate({scrollLeft: scrollLeft}, 'slow');
                }, 500);
                hideBatchTasksBtn();
            }
        });

        $('body').on('click', '.project-title-section-hide-button', function (e) {
            $(".project-title-section").addClass("hide");
            $(this).addClass("project-title-section-show-button");
            $(this).removeClass("project-title-section-hide-button");

            $(this).html("<?php echo "<i data-feather='arrow-down' class='icon-16'></i> "; ?>");
            feather.replace();

            adjustViewHeightWidth();
        });

        $('body').on('click', '.project-title-section-show-button', function (e) {
            $(".project-title-section").removeClass("hide");
            $(this).addClass("project-title-section-hide-button");
            $(this).removeClass("project-title-section-show-button");

            $(this).html("<?php echo "<i data-feather='arrow-up' class='icon-16'></i> "; ?>");
            feather.replace();
            adjustViewHeightWidth();
        });

    });

</script>

<?php echo view("tasks/quick_filters_helper_js"); ?>
