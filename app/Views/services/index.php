<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="service-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('services'); ?></a></li>
            <?php if ($can_edit_items) { ?>
                <div class="tab-title clearfix no-border">
                    <div class="title-button-group">
                        <?php echo modal_anchor(get_uri("services/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                        <?php echo modal_anchor(get_uri("services/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                    </div>
                </div>
            <?php } ?>
        </ul>
        <div class="card">
        <div class="services-items" id="services-items">

        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#services-items").html(<?php echo $services_items; ?>);
</script>