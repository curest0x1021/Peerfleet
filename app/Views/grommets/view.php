<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('grommets_wire_slings') . " - " . $vessel->charter_name; ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/info_tab/" . $client_id); ?>" data-bs-target="#grommets-info"> <?php echo app_lang('grommets_info'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/loadtest_tab/" . $client_id); ?>" data-bs-target="#grommets-loadtest"> <?php echo app_lang('loadtest'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("grommets/inspection_tab/" . $client_id); ?>" data-bs-target="#grommets-inspection"> <?php echo app_lang('visual_inspection'); ?></a></li>
                    <?php if ($can_edit_items) { ?>
                        <div class="tab-title clearfix no-border">
                            <div class="title-button-group">
                                <?php echo modal_anchor(get_uri("grommets/import_modal_form/" . $client_id), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                            </div>
                        </div>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="grommets-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="grommets-loadtest"></div>
                    <div role="tabpanel" class="tab-pane fade" id="grommets-inspection"></div>
                </div>
            </div>
        </div>
    </div>
</div>