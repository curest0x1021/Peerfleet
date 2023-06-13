<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('critical_spare_parts'); ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("critical_spare_parts/items_tab"); ?>" data-bs-target="#items-tab"> <?php echo app_lang('items'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="items-tab"></div>
                    <!-- <div role="tabpanel" class="tab-pane fade" id="critical-units"></div> -->
                </div>
            </div>
        </div>
    </div>
</div>
