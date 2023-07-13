<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang("warehouses"); ?></h1>
                </div>
                <div class="clearfix grid-button">
                    <ul id="warehouse-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                        <li class="title-tab"><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang("warehouses"); ?></a></li>
                    </ul>
                    <div class="card">
                        <div class="table-responsive">
                            <table id="warehouse-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadWarehouseTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("warehouses/list_data") ?>',
            filterDropdown: [
                {name: "client_id", class: "w200", options: <?php echo $vessels_dropdown; ?>},
            ],
            columns: [
                {visible: false, searchable: false},
                {title: "", "class": "text-center w25"},
                {title: '<?php echo app_lang("code") ?>', class: "w100"},
                {title: '<?php echo app_lang("name") ?>', class: "all"},
                {title: '<?php echo app_lang("vessel") ?>', class: "w150"},
                {title: '<?php echo app_lang("spare_parts") ?>', class:"text-center w150"},
                {title: '<?php echo app_lang("chemicals") ?>', class:"text-center w150"},
                {title: '<?php echo app_lang("oils_greases") ?>', class:"text-center w150"},
                {title: '<?php echo app_lang("paints") ?>', class:"text-center w150"}
            ]
        });
    }

    $(document).ready(function () {
        loadWarehouseTable("#warehouse-table");
    });
</script>