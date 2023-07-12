<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('warehouses') . " - " . $model_info->name; ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/spares_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-spares"> <?php echo app_lang('spare_parts'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/chemicals_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-chemicals"> <?php echo app_lang('chemicals'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/oils_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-oils"> <?php echo app_lang('oils_greases'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/paints_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-paints"> <?php echo app_lang('paints'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="warehouse-spares"></div>
                    <div role="tabpanel" class="tab-pane fade" id="warehouse-chemicals"></div>
                    <div role="tabpanel" class="tab-pane fade" id="warehouse-oils"></div>
                    <div role="tabpanel" class="tab-pane fade" id="warehouse-paints"></div>
                </div>
            </div>
        </div>
    </div>
</div>