<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $model_info->name; ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/spares_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-spares"> <?php echo app_lang('spare_parts') . $warns["spares"]; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/chemicals_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-chemicals"> <?php echo app_lang('chemicals') . $warns["chemicals"];; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/oils_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-oils"> <?php echo app_lang('oils_greases') . $warns["oils"];; ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("warehouses/paints_tab/" . $client_id . "/" . $warehouse_id); ?>" data-bs-target="#warehouse-paints"> <?php echo app_lang('paints') . $warns["paints"];; ?></a></li>
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