<div id="page-content" class="page-wrapper clearfix grid-button">
    <div class="card">
        <div class="page-title clearfix notes-page-title">
            <h1> Budget Groups</h1>
            <div class="title-button-group">
            <?php echo modal_anchor(get_uri("budget_groups/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . "Add", array("class" => "btn btn-default", "title" => "Add Budget Group")); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="budget-groups-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#budget-groups-table").appTable({
            source: '<?php echo_uri("budget_groups/list_data") ?>',
            order: [[0, 'desc']],
            columns: [
                {title: '<?php echo app_lang("id"); ?>', "class": "w200"},
                {title: '<?php echo app_lang("title"); ?>', "class": "all"},
                {title: 'Number', "class": "w250"},
                {title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
            ]
        });
    });
</script>