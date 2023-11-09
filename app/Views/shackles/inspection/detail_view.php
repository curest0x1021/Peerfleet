<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo $shackle->internal_id . " - " . app_lang("visual_inspection"); ?></h1>
                </div>
                <div class="clearfix grid-button">
                    <ul id="loadtest-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                        <li class="title-tab"><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang("visual_inspection"); ?></a></li>
                        <div class="tab-title clearfix no-border">
                            <div class="title-button-group">
                                <?php echo modal_anchor(get_uri("shackles/inspection_modal_form/" . $shackle->id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'), "data-post-force_refresh" => false)); ?>
                            </div>
                        </div>
                    </ul>
                    <div class="card">
                        <div class="table-responsive">
                            <table id="inspection-detail-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadInspectionDetailTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("shackles/inspection_detail_list_data/" . $shackle->client_id . "/" . $shackle->id) ?>',
            order: [[2, "desc"]],
            columns: [
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("inspection_date") ?>", "class": "w100"},
                {title: "<?php echo app_lang("inspected_by") ?>", "class": "w150"},
                {title: "<?php echo app_lang("location") ?>", "class": "w150"},
                {title: "<?php echo app_lang("passed") ?>", "class": "text-center w70"},
                {title: "<?php echo app_lang("remarks") ?>", "class": "all"},
                {visible: false, searchable: false},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6],
            xlsColumns: [2, 3, 4, 5, 6]
        });
    };
    $(document).ready(function() {
        loadInspectionDetailTable("#inspection-detail-table");
    });
</script>