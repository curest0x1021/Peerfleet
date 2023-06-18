<div class="row clearfix">
    <?php if (!in_array("total_projects", $hidden_menu) && $show_project_info) { ?>
        <div class="col-md-3 col-sm-6 widget-container">
            <?php echo view("clients/info_widgets/tab", array("tab" => "total_projects")); ?>
        </div>
    <?php } ?>

    <?php if (!in_array("open_tickets", $hidden_menu)) { ?>
        <div class="col-md-3 col-sm-6  widget-container">
            <?php echo view("clients/info_widgets/tab", array("tab" => "open_tickets")); ?>
        </div>
    <?php } ?>

    <?php if (!in_array("total_vessels", $hidden_menu)) { ?>
        <div class="col-md-3 col-sm-6  widget-container">
            <?php echo view("clients/info_widgets/tab", array("tab" => "total_vessels")); ?>
        </div>
    <?php } ?>

    <?php if (!in_array("last_announcement", $hidden_menu)) { ?>
        <div class="col-md-3 col-sm-6  widget-container">
            <?php echo view("clients/info_widgets/tab", array("tab" => "last_announcement")); ?>
        </div>
    <?php } ?>

    <?php if ((in_array("projects", $hidden_menu))) { ?>
        <div class="col-sm-12 col-md-12" style="margin-top: 10%">
            <div class="text-center box">
                <div class="box-content" style="vertical-align: middle; height: 100%">
                    <span data-feather="meh" height="20rem" width="20rem" style="color:#CBCED0;"></span>
                </div>
            </div>
        </div>
    <?php } ?>
</div>