<div id="page-content" class="clearfix page-wrapper">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "lifting_gear_types";
            echo view("settings/tabs", $tab_view);
            ?>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="page-title clearfix no-border no-border-top-radius no-bg">
                <h1 class="pl0"><?php echo app_lang('lifting_gear_types'); ?></h1>
            </div>
            <ul id="lifting-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs bg-white title" role="tablist">
                <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("lifting_gear_types/certificates_tab"); ?>" data-bs-target="#certificates-tab"> <?php echo app_lang('certificate_type'); ?></a></li>
                <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("lifting_gear_types/icc_tab"); ?>" data-bs-target="#icc-tab"> <?php echo app_lang('icc'); ?></a></li>
                <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("lifting_gear_types/shackles_tab"); ?>" data-bs-target="#shackles-tab"> <?php echo app_lang('shackle_type'); ?></a></li>
                <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("lifting_gear_types/misc_tab"); ?>" data-bs-target="#misc-tab"> <?php echo app_lang('misc_lifting_type'); ?></a></li>
                <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("lifting_gear_types/lashing_tab"); ?>" data-bs-target="#lashing-tab"> <?php echo app_lang('lashing_type'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade" id="certificates-tab"></div>
                <div role="tabpanel" class="tab-pane fade" id="icc-tab"></div>
                <div role="tabpanel" class="tab-pane fade" id="shackles-tab"></div>
                <div role="tabpanel" class="tab-pane fade" id="misc-tab"></div>
                <div role="tabpanel" class="tab-pane fade" id="lashing-tab"></div>
            </div>
        </div>
    </div>
</div>
