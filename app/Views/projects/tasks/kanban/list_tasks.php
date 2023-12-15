<div class="card mb0 mt10">
    <div class="bg-white">
        <div id="kanban-list-filters"></div>       
    </div>
</div>
<div id="load-kanban-list"></div>

<script type="text/javascript">

    $(document).ready(function () {
        var filterDropdown = [];

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
        $("#kanban-list-filters").appFilters({
            source: '<?php echo_uri("tasks/project_tasks_kanban_list_data/" . $project_id) ?>',
            targetSelector: '#load-kanban-list',
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
