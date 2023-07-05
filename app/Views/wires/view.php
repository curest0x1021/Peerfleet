<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('wire_details') . " - " . $crane->name; ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("wires/info_tab/" . $crane->client_id); ?>" data-bs-target="#wire-info"> <?php echo app_lang('facts_and_figure'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("wires/history_tab/" . $crane->client_id); ?>" data-bs-target="#wire-history"> <?php echo app_lang('history'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("wires/loadtest_tab/" . $crane->client_id); ?>" data-bs-target="#wire-loadtest"> <?php echo app_lang('loadtest'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("wires/wire_inspection_tab/" . $crane->client_id); ?>" data-bs-target="#wire-inspection"> <?php echo app_lang('wire_inspection'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="wire-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="wire-history"></div>
                    <div role="tabpanel" class="tab-pane fade" id="wire-loadtest"></div>
                    <div role="tabpanel" class="tab-pane fade" id="wire-inspection"></div>
                </div>
            </div>
        </div>
    </div>
</div>
