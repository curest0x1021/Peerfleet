<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('files'); ?></h1>
                </div>
                <div>
                    <button class="btn btn-default btn-select-file" ><i data-feather="upload" class="icon-16" ></i>New file</button>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" data-bs-target="#items-tab"> <?php echo app_lang('items'); ?></a></li>
                </ul>
                <div class="tab-content">
                    
                    <div class="card rounded-bottom">
                        <div class="tab-title clearfix">
                            <?php //if ($can_edit_items) { ?>
                                <!-- <button clas="btn btn-sm btn-default" >
                                    <i data-feature="upload" ></i>Upload
                                </button> -->
                            <?php //} ?>
                        </div>
                        <div class="table-responsive">
                            <table id="item-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="file" class="input-select-file" hidden/>
<script type="text/javascript">
    $(document).ready(function () {
        $("#item-table").appTable({
            source: '<?php echo_uri("spare_parts/list_data") ?>',
            checkBoxes: [
                {text: '<?php echo app_lang("critical") ?>', name: "is_critical", value: "1", isChecked: false},
                {text: '<?php echo app_lang("non_critical") ?>', name: "is_critical", value: "0", isChecked: false}
            ],
            order: [[1, "desc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo "file_name" ?>', visible: false},
                {title: '<?php echo "file_size"?>', class: "text-center w50"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 3, 4, 5, 6, 7, 8, 9],
            xlsColumns: [1, 3, 4, 5, 6, 7, 8, 9]
        });

        $('body').on('click', '[data-act=update-critical-checkbox]', function () {
            $(this).find("span").removeClass("checkbox-checked");
            $(this).find("span").addClass("inline-loader");
            $.ajax({
                url: '<?php echo_uri("spare_parts/save_critical") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        $("#item-table").appTable({newData: response.data, dataId: response.id});
                    }
                }
            });
        });
        $(".btn-select-file").on("click",function(){
            $(".input-select-file").click()
        });
        $(".input-select-file").on("change",function(){
            console.log($(this).target.files[0])
        })
    });
</script>