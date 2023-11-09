<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $main_info->item_description . " (" . $vessel->charter_name . ")"; ?></h1>
                </div>
                <ul id="misc-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("misc/info_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#misc-info"> <?php echo $main_info->item_description; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("misc/loadtest_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#misc-loadtest"> <?php echo app_lang('loadtest') . $warnning["loadtests"]; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("misc/inspection_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#misc-inspection"> <?php echo app_lang('visual_inspection') . $warnning["inspections"]; ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="misc-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="misc-loadtest"></div>
                    <div role="tabpanel" class="tab-pane fade" id="misc-inspection"></div>
                </div>
            </div>
        </div>
    </div>
</div>