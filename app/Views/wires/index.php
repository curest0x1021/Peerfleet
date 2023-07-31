<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="wire-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('wires'); ?></a></li>
        </ul>
        <div class="card">
            <div class="table-responsive">
                <table id="wire-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadWiresTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("wires/list_data") ?>',
            columns: [
                {
                    visible: false, searchable: false
                },
                {
                    title: "<?php echo app_lang("vessel") ?>",
                    "class": "all"
                },
                {
                    title: "<?php echo app_lang("cranes") ?>",
                    "class": "text-center w15p"
                },
                {
                    title: "<?php echo app_lang("wires") ?>",
                    "class": "text-center w15p"
                },
                {
                    title: "<?php echo app_lang("required_exchange_wires") ?>",
                    "class": "text-center w15p"
                },
                {
                    title: "<?php echo app_lang("require_loadtests") ?>",
                    "class": "text-center w15p"
                },
                {
                    title: "<?php echo app_lang("require_inspections") ?>",
                    "class": "text-center w15p"
                },
                {
                    title: '<i data-feather="menu" class="icon-16"></i>',
                    "class": "text-center option w100",
                }
            ],
            printColumns: [2, 3, 4, 5],
            xlsColumns: [2, 3, 4, 5]
        });
    };
    $(document).ready(function() {
        loadWiresTable("#wire-table");
    });
</script>