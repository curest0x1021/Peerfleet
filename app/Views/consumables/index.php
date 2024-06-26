<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('consumables'); ?></h1>
                </div>
                <ul id="consumable-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs bg-white title" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("consumables/chemicals_tab"); ?>" data-bs-target="#chemicals-tab"> <?php echo app_lang('chemicals'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("consumables/oils_tab"); ?>" data-bs-target="#oils-tab"> <?php echo app_lang('oils_greases'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("consumables/paints_tab"); ?>" data-bs-target="#paints-tab"> <?php echo app_lang('paints'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="chemicals-tab"></div>
                    <div role="tabpanel" class="tab-pane fade" id="oils-tab"></div>
                    <div role="tabpanel" class="tab-pane fade" id="paints-tab"></div>
                </div>
            </div>
        </div>
    </div>
</div>
