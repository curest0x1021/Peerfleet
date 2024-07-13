<?php echo form_open(get_uri("clients/save_contact"), array("id" => "contact-form", "class" => "general-form", "role" => "form", "autocomplete" => "false")); ?>
<div class="modal-body clearfix">
    <?php echo view("clients/contacts/contact_general_info_fields", ["is_crew" => true]); ?>
</div>
<div class="modal-footer">
    <div id="link-of-add-contact-modal" class="hide">
        <?php echo modal_anchor(get_uri("clients/add_new_contact_modal_form"), "", array()); ?>
    </div>

    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span>
        <?php echo app_lang('close'); ?></button>

    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span>
        <?php echo app_lang('save'); ?></button>

</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var addType = "<?php echo $add_type; ?>";
        //send data to show the task after save
        window.showAddNewModal = false;

        $("#save-and-add-button").click(function () {
            window.showAddNewModal = true;
            $(this).trigger("submit");
        });

        window.contactForm = $("#contact-form").appForm({
            closeModalOnSuccess: true,
            onSuccess: function (result) {

                $("#contact-table").appTable({ newData: result.data, dataId: result.id });
                window.contactForm.closeModal();

                // Close the modal
                // $('#contact-form').closest('.modal').modal('hide');
            }
        });
        setTimeout(function () {
            $("#first_name").focus();
        }, 200);
    });
</script>