<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="wire-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('grommets_wire_slings'); ?></a></li>
        </ul>
        <div class="card">
            <div class="table-responsive">
                <table id="grommet-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadGrommetsTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("grommets/list_data") ?>',
            columns: [
                { visible: false, searchable: false },
                { title: "<?php echo app_lang("vessel") ?>", "class": "all" },
                { title: "<?php echo app_lang("require_loadtests") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("require_inspections") ?>", "class": "text-center w15p" },
                { title: "<?php echo app_lang("total_items") ?>", "class": "text-center w15p" }
            ]
        });
    };
    $(document).ready(function() {
        loadGrommetsTable("#grommet-table");
    });
</script>