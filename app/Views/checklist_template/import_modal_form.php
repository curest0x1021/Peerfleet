<?php echo form_open(get_uri("checklist_template/save_from_excel_file"), array("id" => "import-manufacturers-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix import-manufacturer-modal-body">
    <div class="container-fluid">
        <div id="upload-area">
            <?php
            echo view("includes/multi_file_uploader", array(
                "upload_url" => get_uri("checklist_template/upload_excel_file"),
                "validation_url" => get_uri("checklist_template/validate_import_file"),
                "max_files" => 1,
                "hide_description" => true,
                "disable_button_type" => true
            ));
            ?>
        </div>
        <input type="hidden" name="file_name" id="import_file_name" value="" />
        <div id="preview-area"></div>
    </div>
</div>

<div class="modal-footer">
    <?php echo anchor("checklist_template/download_sample_excel_file", "<i data-feather='download' class='icon-16'></i> " . app_lang("download_sample_file"), array("title" => app_lang("download_sample_file"), "class" => "btn btn-default float-start")); ?>
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button id="form-previous" type="button" class="btn btn-default hide"><span data-feather="arrow-left-circle" class="icon-16"></span> <?php echo app_lang('back'); ?></button>
    <button id="form-next" type="button" disabled="true" class="btn btn-info text-white"><span data-feather="arrow-right-circle" class="icon-16"></span> <?php echo app_lang('next'); ?></button>
    <button id="form-submit" type="button" disabled="true" class="btn btn-primary start-upload hide"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('upload'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#import-manufacturers-form").appForm({
            onSuccess: function () {
                location.reload();
            }
        });

        var $uploadArea = $("#upload-area"),
                $previewArea = $("#preview-area"),
                $previousButton = $("#form-previous"),
                $nextButton = $("#form-next"),
                $modalBody = $(".import-manufacturer-modal-body"),
                $submitButton = $("#form-submit"),
                $ajaxModal = $("#ajaxModal");

        $submitButton.click(function () {
            $("#import-manufacturers-form").trigger("submit");
        });

        //validate the uploaded excel file by clicking next
        $nextButton.click(function () {
            var fileName = $("#uploaded-file-previews").find("input[type=hidden]:eq(1)").val();
            if (!fileName) {
                appAlert.error("<?php echo app_lang('something_went_wrong'); ?>");
                return false;
            }
            appLoader.show({container: ".import-manufacturer-modal-body", css: "left:0;"});
            var $button = $(this);
            $button.attr("disabled", true);

            $("#import_file_name").val(fileName);


            $.ajax({
                url: "<?php echo get_uri('checklist_template/validate_import_file_data') ?>",
                type: 'POST',
                dataType: 'json',
                data: {file_name: fileName},
                success: function (result) {
                    appLoader.hide();
                    $button.removeAttr('disabled');

                    if (result.success) {
                        $uploadArea.addClass("hide");
                        $nextButton.addClass("hide");
                        $previousButton.removeClass("hide");
                        $submitButton.removeClass("hide");
                        $previewArea.removeClass("hide");

                        $previewArea.html(result.table_data);
                        $modalBody.height($(window).height() - 165);
                        $modalBody.addClass("overflow-y-scroll");

                        if (result.got_error) {
                            $submitButton.prop("disabled", true);
                        } else {
                            $submitButton.prop("disabled", false);
                        }
                    }
                }
            });


        });

        $previousButton.click(function () {
            $(this).addClass("hide");
            $submitButton.addClass("hide");
            $uploadArea.removeClass("hide");
            $previewArea.addClass("hide");
            $nextButton.removeClass("hide");

            $modalBody.height($(window).height() - 230);
        });
    });
</script>    
