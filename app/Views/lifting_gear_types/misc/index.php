<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("lifting_gear_types/misc_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_type'), array("class" => "btn btn-default", "title" => app_lang('add_type'))); ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="misc-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#misc-table").appTable({
            source: '<?php echo_uri("lifting_gear_types/misc_list_data") ?>',
            order: [[1, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1],
            xlsColumns: [1]
        });
    });
</script>