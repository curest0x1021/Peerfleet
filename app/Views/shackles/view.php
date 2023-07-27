<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $main_info->item_description . " (" . $vessel->charter_name . ")"; ?></h1>
                </div>
                <ul id="shackles-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("shackles/info_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#shackles-info"> <?php echo $main_info->item_description; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("shackles/loadtest_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#shackles-loadtest"> <?php echo app_lang('loadtest'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("shackles/inspection_tab/" . $client_id . "/" . $main_id); ?>" data-bs-target="#shackles-inspection"> <?php echo app_lang('visual_inspection'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="shackles-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="shackles-loadtest"></div>
                    <div role="tabpanel" class="tab-pane fade" id="shackles-inspection"></div>
                </div>
            </div>
        </div>
    </div>
</div>