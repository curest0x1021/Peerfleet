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
            <div class="table-responsive">
                <table id="service-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadServicesTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("services/list_data") ?>',
            columns: [
                { visible: false, searchable: false },
                { title: "<?php echo app_lang("company") ?>", "class": "all" },
                { title: "<?php echo app_lang("serviced_ports") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("service_type") ?>", visible: false },
                { title: "<?php echo app_lang("website") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("email") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("phone") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("fax") ?>", visible: false },
                { title: "<?php echo app_lang("address") ?>", visible: false },
                { title: "<?php echo app_lang("city") ?>", visible: false },
                { title: "<?php echo app_lang("po_box") ?>", visible: false },
                { title: "<?php echo app_lang("country") ?>", "class": "w100" },
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            xlsColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
        });
    };
    $(document).ready(function() {
        loadServicesTable("#service-table");
    });
</script>