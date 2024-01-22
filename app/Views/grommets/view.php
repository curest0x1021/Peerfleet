<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $main_info->item_description . " (" . $vessel->charter_name . ")"; ?></h1>
                </div>
                <ul id="grommets-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/info_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#grommets-info"> <?php echo $main_info->item_description; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/loadtest_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#grommets-loadtest"> <?php echo app_lang('loadtest') . $warnning["loadtests"]; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/inspection_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#grommets-inspection"> <?php echo app_lang('visual_inspection') . $warnning["inspections"]; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/certificate_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#grommets-certificate"> <?php echo app_lang('certificates'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="grommets-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="grommets-loadtest"></div>
                    <div role="tabpanel" class="tab-pane fade" id="grommets-inspection"></div>
                    <div role="tabpanel" class="tab-pane fade" id="grommets-certificate"></div>
                </div>
            </div>
        </div>
    </div>
</div>