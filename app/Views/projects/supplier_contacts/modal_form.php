<?php echo form_open(get_uri("projects/save_project_supplier"), array("id" => "project-supplier-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="supplier" class=" col-md-3"><?php echo app_lang('supplier'); ?></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "supplier",
                        "name" => "supplier",
                        "value" => $model_info->supplier ? $model_info->supplier : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('supplier'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="contact_person" class=" col-md-3"><?php echo app_lang('contact_person'); ?></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "contact_person",
                        "name" => "contact_person",
                        "value" => $model_info->contact_person ? $model_info->contact_person : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('contact_person'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="email" class=" col-md-3"><?php echo app_lang('email'); ?></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "email",
                        "name" => "email",
                        "value" => $model_info->email ? $model_info->email : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('email'),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="phone" class=" col-md-3"><?php echo app_lang('phone'); ?></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "phone",
                        "name" => "phone",
                        "value" => $model_info->phone ? $model_info->phone : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('phone'),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="mobile" class=" col-md-3"><?php echo app_lang('mobile'); ?></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "mobile",
                        "name" => "mobile",
                        "value" => $model_info->mobile ? $model_info->mobile : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('mobile'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="min-height: 50px">
            <div class="row">
                <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => process_images_from_content($model_info->description, false),
                        "class" => "form-control",
                        "placeholder" => app_lang('description'),
                        "data-rich-text-editor" => true
                    ));
                    ?>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="modal-footer">

    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>

</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        window.projectMemberForm = $("#project-supplier-form").appForm({
            closeModalOnSuccess: false,
            onSuccess: function (result) {
                window.projectMemberForm.closeModal();
                location.reload();
            }
        });
        $('#description').summernote();

    });
</script>    