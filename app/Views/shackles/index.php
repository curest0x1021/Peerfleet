<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="wire-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('shackles'); ?></a></li>
        </ul>
        <div class="card">
            <div class="table-responsive">
                <table id="shackle-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadShacklesTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("shackles/list_data") ?>',
            columns: [{
                    visible: false, searchable: false
                },
                {
                    title: "<?php echo app_lang("vessel") ?>",
                    "class": "all"
                },
                {
                    title: "<?php echo app_lang("total_items") ?>",
                    "class": "text-center w150"
                }
            ]
        });
    };
    $(document).ready(function() {
        loadShacklesTable("#shackle-table");
    });
</script>