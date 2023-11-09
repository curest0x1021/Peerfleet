<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('contacts'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("services/contact_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'), "data-post-service_id" => $service_id)); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="contact-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadContactsTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("services/contact_list_data/" . $service_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("first_name") ?>", "class": "w100"},
                {title: "<?php echo app_lang("last_name") ?>", "class": "w150"},
                {title: "<?php echo app_lang("job_title") ?>", "class": "w150"},
                {title: "<?php echo app_lang("email") ?>", "class": "w150"},
                {title: "<?php echo app_lang("phone") ?>", "class": "w150"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]
        });
    };
    $(document).ready(function() {
        loadContactsTable("#contact-table");
    });
</script>