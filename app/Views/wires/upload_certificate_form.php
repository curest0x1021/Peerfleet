<?php echo form_open(get_uri("wires/save_from_excel_file"), array("id" => "import-items-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix import-items-modal-body">
    <div class="container-fluid">
        <div id="upload-area">
            <?php
            echo view("includes/multi_file_uploader", array(
                "upload_url" => get_uri("wires/upload_excel_file"),
                "validation_url" => get_uri("wires/validate_certificate_file"),
                "max_files" => 1,
                "hide_description" => true,
                "disable_button_type" => true
            ));
            ?>
        </div>
        <input type="hidden" name="file_name" id="import_file_name" value="" />
        <input type="hidden" name="tab" value="<?php echo $tab; ?>" />
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <div id="preview-area"></div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button id="form-submit" type="button" disabled="true" class="btn btn-primary start-upload hide"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('upload'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#import-items-form").appForm({
            onSuccess: function() {
                location.reload();
            }
        });

        var $uploadArea = $("#upload-area"),
            $previewArea = $("#preview-area"),
            $previousButton = $("#form-previous"),
            $nextButton = $("#form-next"),
            $modalBody = $(".import-items-modal-body"),
            $submitButton = $("#form-submit"),
            $ajaxModal = $("#ajaxModal");

        removeLargeModal(); //remove app-modal credentials on loading modal

        function addLargeModal() {
            $ajaxModal.addClass("import-items-app-modal");
            $ajaxModal.addClass("app-modal");
            $ajaxModal.find("div.modal-dialog").addClass("app-modal-body mw100p");
            $ajaxModal.find("div.modal-content").addClass("h100p");
        }

        function removeLargeModal() {
            $ajaxModal.find("div.modal-dialog").removeClass("app-modal-body mw100p");
            $ajaxModal.find("div.modal-content").removeClass("h100p");
            $ajaxModal.removeClass("app-modal");
        }

        $submitButton.click(function() {
            $("#import-items-form").trigger("submit");
        });

    });
</script>