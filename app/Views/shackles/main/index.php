<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
        <ul id="wire-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title mt15" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('shackles') . " - " . $vessel->charter_name; ?></a></li>
            <?php if ($can_edit_items) { ?>
                <div class="tab-title clearfix no-border">
                    <div class="title-button-group">
                        <?php echo modal_anchor(get_uri("shackles/import_modal_form/" . $client_id), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                        <?php echo modal_anchor(get_uri("shackles/main_modal_form/" . $client_id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                    </div>
                </div>
            <?php } ?>
        </ul>
        <div class="card">
            <div class="table-responsive">
                <table id="main-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadMainTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("shackles/main_list_data/" . $client_id) ?>',
            columns: [
                { visible: false, searchable: false },
                { title: "<?php echo app_lang("item"); ?>", "class": "all" },
                { title: "WLL [TS]", "class": "text-center w8p" },
                { title: "<?php echo app_lang("type") ?>", "class": "text-center w8p"},
                { title: "Qty", "class": "text-center w8p" },
                { title: "BL [kN]", "class": "text-center w8p" },
                { title: "IW (mm)", "class": "text-center w8p" },
                { title: "PD (mm)", "class": "text-center w8p" },
                { title: "IL (mm)", "class": "text-center w8p" },
                { title: "<?php echo app_lang("supplier"); ?>", "class": "text-center w10p" },
                { title: "<?php echo app_lang("delivered_on_board") ?>", "class": "text-center w10p" },
                { title: "<?php echo app_lang("loadtest") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("visual_inspection") ?>", "class": "text-center w15p" }
            ]
        });
    };
    $(document).ready(function() {
        loadMainTable("#main-table");
    });
</script>