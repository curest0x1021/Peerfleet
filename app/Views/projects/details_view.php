<?php
if (!function_exists("make_project_tabs_data")) {

    function make_project_tabs_data($default_project_tabs = array(), $is_client = false) {
        $project_tab_order = get_setting("project_tab_order");
        $project_tab_order_of_clients = get_setting("project_tab_order_of_clients");
        $custom_project_tabs = array();

        if ($is_client && $project_tab_order_of_clients) {
            //user is client
            $custom_project_tabs = explode(',', $project_tab_order_of_clients);
        } else if (!$is_client && $project_tab_order) {
            //user is team member
            $custom_project_tabs = explode(',', $project_tab_order);
        }

        $final_projects_tabs = array();
        if ($custom_project_tabs) {
            foreach ($custom_project_tabs as $custom_project_tab) {
                if (array_key_exists($custom_project_tab, $default_project_tabs)) {
                    $final_projects_tabs[$custom_project_tab] = get_array_value($default_project_tabs, $custom_project_tab);
                }
            }
        }

        $final_projects_tabs = $final_projects_tabs ? $final_projects_tabs : $default_project_tabs;

        foreach ($final_projects_tabs as $key => $value) {
            echo "<li class='nav-item' role='presentation'><a class='nav-link' data-bs-toggle='tab' href='" . get_uri($value) . "' data-bs-target='#project-$key-section'>" . app_lang($key) . "</a></li>";
        }
    }

}
?>

<div class="page-content project-details-view clearfix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>

                <div class="project-title-section">
                    <div class="page-title no-bg clearfix mb5 no-border">
                        <div>
                            <h1 class="pl0">

                                <?php echo $project_info->title; ?>

                                <?php if (!(get_setting("disable_access_favorite_project_option_for_clients") && $login_user->user_type == "client")) { ?>
                                    <span id="star-mark">
                                        <?php
                                        if ($is_starred) {
                                            echo view('projects/star/starred', array("project_id" => $project_info->id));
                                        } else {
                                            echo view('projects/star/not_starred', array("project_id" => $project_info->id));
                                        }
                                        ?>
                                    </span>
                                <?php } ?>
                            </h1>
                        </div>

                        <div class="project-title-button-group-section">
                            <div class="title-button-group mr0" id="project-timer-box">
                                <?php echo view("projects/project_title_buttons"); ?>
                            </div>
                        </div>
                    </div>
                    <ul id="project-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs rounded classic mb20 scrollable-tabs border-white" role="tablist">
                        <?php
                        if ($login_user->user_type === "staff") {
                            //default tab order
                            $project_tabs = array(
                                "overview" => "projects/overview/" . $project_info->id,
                                "tasks_list" => "tasks/project_tasks_kanban_list/" . $project_info->id,
                                "tasks_kanban" => "tasks/project_tasks_kanban_kanban/" . $project_info->id,
                            );

                            if ($show_milestone_info) {
                                $project_tabs["milestones"] = "projects/milestones/" . $project_info->id;
                            }

                            if ($show_gantt_info) {
                                $project_tabs["gantt"] = "tasks/gantt/" . $project_info->id;
                            }

                            if ($show_note_info) {
                                $project_tabs["notes"] = "projects/notes/" . $project_info->id;
                            }

                            $project_tabs["files"] = "projects/files/" . $project_info->id;
                            $project_tabs["comments"] = "projects/comments/" . $project_info->id;

                            // if ($project_info->project_type === "client_project" && $show_customer_feedback) {
                            //     $project_tabs["customer_feedback"] = "projects/customer_feedback/" . $project_info->id;
                            // }

                            if ($show_timesheet_info) {
                                $project_tabs["timesheets"] = "projects/timesheets/" . $project_info->id;
                            }

                            if ($show_invoice_info && $project_info->project_type === "client_project") {
                                $project_tabs["invoices"] = "projects/invoices/" . $project_info->id;
                                $project_tabs["payments"] = "projects/payments/" . $project_info->id;
                            }

                            if ($show_expense_info) {
                                $project_tabs["expenses"] = "projects/expenses/" . $project_info->id;
                            }

                            if ($show_contract_info && $project_info->project_type === "client_project") {
                                $project_tabs["contracts"] = "projects/contracts/" . $project_info->id;
                            }

                            if ($show_ticket_info && $project_info->project_type === "client_project") {
                                $project_tabs["tickets"] = "projects/tickets/" . $project_info->id;
                            }

                            $project_tabs["checklist"] = "projects/checklist/" . $project_info->id;

                            $project_tabs_of_hook_of_staff = array();
                            $project_tabs_of_hook_of_staff = app_hooks()->apply_filters('app_filter_team_members_project_details_tab', $project_tabs_of_hook_of_staff, $project_info->id);
                            $project_tabs_of_hook_of_staff = is_array($project_tabs_of_hook_of_staff) ? $project_tabs_of_hook_of_staff : array();
                            $project_tabs = array_merge($project_tabs, $project_tabs_of_hook_of_staff);

                            make_project_tabs_data($project_tabs);
                        } else {
                            //default tab order
                            $project_tabs = array(
                                "overview" => "projects/overview_for_client/" . $project_info->id
                            );

                            if ($show_tasks) {
                                $project_tabs["tasks_list"] = "tasks/project_tasks_kanban_list/" . $project_info->id;
                                $project_tabs["tasks_kanban"] = "tasks/project_tasks_kanban_kanban/" . $project_info->id;
                            }

                            if ($show_files) {
                                $project_tabs["files"] = "projects/files/" . $project_info->id;
                            }

                            $project_tabs["comments"] = "projects/customer_feedback/" . $project_info->id;

                            if ($show_milestone_info) {
                                $project_tabs["milestones"] = "projects/milestones/" . $project_info->id;
                            }

                            if ($show_gantt_info) {
                                $project_tabs["gantt"] = "tasks/gantt/" . $project_info->id;
                            }

                            if ($show_timesheet_info) {
                                $project_tabs["timesheets"] = "projects/timesheets/" . $project_info->id;
                            }

                            if (get_setting("module_invoice")) {
                                //check left menu settings
                                $left_menu = get_setting("user_" . $login_user->id . "_left_menu") ? get_setting("user_" . $login_user->id . "_left_menu") : get_setting("default_client_left_menu");
                                $left_menu = $left_menu ? json_decode(json_encode(@unserialize($left_menu)), true) : false;
                                if (!$left_menu || in_array("invoices", array_column($left_menu, "name"))) {
                                    $project_tabs["invoices"] = "projects/invoices/" . $project_info->id . "/" . $login_user->client_id;
                                }
                            }

                            $project_tabs_of_hook_of_client = array();
                            $project_tabs_of_hook_of_client = app_hooks()->apply_filters('app_filter_clients_project_details_tab', $project_tabs_of_hook_of_client, $project_info->id);
                            $project_tabs_of_hook_of_client = is_array($project_tabs_of_hook_of_client) ? $project_tabs_of_hook_of_client : array();
                            $project_tabs = array_merge($project_tabs, $project_tabs_of_hook_of_client);

                            make_project_tabs_data($project_tabs, true);
                        }
                        ?>

                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active" id="project-overview-section"></div>
                    <div role="tabpanel" class="tab-pane fade grid-button" id="project-tasks_list-section"></div>
                    <div role="tabpanel" class="tab-pane fade grid-button" id="project-tasks_kanban-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-milestones-section"></div>
                    <div role="tabpanel" class="tab-pane fade grid-button" id="project-gantt-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-files-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-comments-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-customer_feedback-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-notes-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-timesheets-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-invoices-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-payments-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-expenses-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-contracts-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-tickets-section"></div>
                    <div role="tabpanel" class="tab-pane fade" id="project-checklist-section"></div>

                    <?php
                    if ($login_user->user_type === "staff") {
                        $project_tabs_of_hook_targets = $project_tabs_of_hook_of_staff;
                    } else {
                        $project_tabs_of_hook_targets = $project_tabs_of_hook_of_client;
                    }

                    foreach ($project_tabs_of_hook_targets as $key => $value) {
                        ?>
                        <div role="tabpanel" class="tab-pane fade" id="project-<?php echo $key; ?>-section"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="project-footer-button-section">
    <?php echo view("projects/project_title_buttons"); ?>
</div>

<?php
//if we get any task parameter, we'll show the task details modal automatically
$preview_task_id = get_array_value($_GET, 'task');
if ($preview_task_id) {
    echo modal_anchor(get_uri("tasks/view"), "", array("id" => "preview_task_link", "title" => app_lang('task_info') . " #$preview_task_id", "data-post-id" => $preview_task_id, "data-modal-lg" => "1"));
}
?>

<?php
load_css(array(
    "assets/js/gantt-chart/frappe-gantt.css",
));
load_js(array(
    "assets/js/gantt-chart/frappe-gantt.js",
));
?>

<script type="text/javascript">
    RELOAD_PROJECT_VIEW_AFTER_UPDATE = true;

    $(document).ready(function () {
        setTimeout(function () {
            var tab = "<?php echo $tab; ?>";
            if (tab === "comment") {
                $("[data-bs-target='#project-comments-section']").trigger("click");
            } else if (tab === "customer_feedback") {
                $("[data-bs-target='#project-customer_feedback-section']").trigger("click");
            } else if (tab === "files") {
                $("[data-bs-target='#project-files-section']").trigger("click");
            } else if (tab === "gantt") {
                $("[data-bs-target='#project-gantt-section']").trigger("click");
            } else if (tab === "tasks") {
                $("[data-bs-target='#project-tasks_list-section']").trigger("click");
            } else if (tab === "tasks_kanban") {
                $("[data-bs-target='#project-tasks_kanban-section']").trigger("click");
            } else if (tab === "milestones") {
                $("[data-bs-target='#project-milestones-section']").trigger("click");
            }
        }, 210);


        //open task details modal automatically 

        if ($("#preview_task_link").length) {
            $("#preview_task_link").trigger("click");
        }

        
        $('body').on('click', '.export-excel-btn', function (e) {

            $.ajax({
                url: "<?php echo get_uri('tasks/project_tasks_data') ?>",
                type: 'POST',
                dataType: 'json',
                data: {project_id:<?php echo $project_info->id; ?> },
                success: async function (result) {

                    /* dynamically import the scripts in the event listener */
                    const XLSX = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/xlsx.mjs");
                    const cptable = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/cpexcel.full.mjs");
                    XLSX.set_cptable(cptable);

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.json_to_sheet(result);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    XLSX.writeFile(wb, "Mytasks.xlsx");
                    
                    // var CSV = '';
                    // //Set Report title in first row or line
                    // var ReportTitle = 'export-tasks';
                    // var ShowLabel = true;
                    // CSV += ReportTitle + '\r\n\n';

                    // //This condition will generate the Label/Header
                    // if (ShowLabel) {
                    //     var row = "";

                    //     //This loop will extract the label from 1st index of on array
                    //     for (var index in result[0]) {

                    //         //Now convert each value to string and comma-seprated
                    //         row += index + ',';
                    //     }

                    //     row = row.slice(0, -1);

                    //     //append Label row with line break
                    //     CSV += row + '\r\n';
                    // }

                    // //1st loop is to extract each row
                    // for (var i = 0; i < result.length; i++) {
                    //     var row = "";

                    //     //2nd loop will extract each column and convert it in string comma-seprated
                    //     for (var index in result[i]) {
                    //         row += '"' + result[i][index] + '",';
                    //     }

                    //     row.slice(0, row.length - 1);

                    //     //add a line break after each row
                    //     CSV += row + '\r\n';
                    // }

                    // if (CSV == '') {
                    //     alert("Invalid data");
                    //     return;
                    // }

                    // //Generate a file name
                    // var fileName = "MyReport_";
                    // //this will remove the blank-spaces from the title and replace it with an underscore
                    // fileName += ReportTitle.replace(/ /g, "_");

                    // //Initialize file format you want csv or xls
                    // var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

                    // // Now the little tricky part.
                    // // you can use either>> window.open(uri);
                    // // but this will not work in some browsers
                    // // or you will not get the correct file extension    

                    // //this trick will generate a temp <a /> tag
                    // var link = document.createElement("a");
                    // link.href = uri;

                    // //set the visibility hidden so it will not effect on your web-layout
                    // link.style = "visibility:hidden";
                    // link.download = fileName + ".xls";

                    // //this part will append the anchor tag and remove it after automatic click
                    // document.body.appendChild(link);
                    // link.click();
                    // document.body.removeChild(link);
                }
            });

        })
    });
</script>

<?php echo view("tasks/batch_update/batch_update_script"); ?>
<?php echo view("tasks/sub_tasks_helper_js"); ?>