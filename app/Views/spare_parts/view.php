<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $model_info->code . " - " . $model_info->name . " (" . $model_info->vessel . ")"; ?></h1>
                </div>
                <div class="clearfix grid-button">
                    <ul id="ws-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                        <li class="title-tab"><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang("items"); ?></a></li>
                        <?php if ($can_edit_items) { ?>
                            <div class="tab-title clearfix no-border">
                                <div class="title-button-group">
                                    <?php echo modal_anchor(get_uri("spare_parts/ws_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'), "data-post-warehouse_id" => $model_info->id)); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                    <div class="card">
                        <div class="table-responsive">
                            <table id="ws-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadCranesTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("spare_parts/ws_list_data/" . $warehouse_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "", "class": "text-center w25"},
                {title: "<?php echo app_lang("item") ?>", class: "w150"},
                {title: "<?php echo app_lang("quantity") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("min_stocks") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("max_stocks") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("manufacturer") ?>"},
                {title: "<?php echo app_lang("applicable_equipment") ?>"},
                {title: "<?php echo app_lang("ship_equipment") ?>"},
                {title: "<?php echo app_lang("unit") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("part_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("article_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("drawing_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("hs_code") ?>", class: "text-center w100"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            xlsColumns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        });
    };
    $(document).ready(function() {
        loadCranesTable("#ws-table");
    });
</script>