<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <?php
                        $website = $model_info->website;
                        if (strpos($website, "http") !== 0) {
                            $website = "https://" . $website;
                        }
                        $link = anchor($website, "<i data-feather='external-link' class='icon-16'></i>", array("class" => "ml15", "target" => "_blank"));
                    ?>
                    <h1 class="pl0"><?php echo $model_info->company . $link; ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("services/info_tab/" . $model_info->id); ?>" data-bs-target="#company-info"> <?php echo app_lang('general_info'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("services/contacts_tab/" . $model_info->id); ?>" data-bs-target="#service-contacts"> <?php echo app_lang('contacts'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="company-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="service-contacts"></div>
                </div>
            </div>
        </div>
    </div>
</div>