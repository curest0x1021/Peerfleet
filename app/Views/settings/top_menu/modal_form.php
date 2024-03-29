<?php echo form_open(get_uri("settings/save_top_menu"), array("id" => "top-menu-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="type" value="data" />
        <div class="row">
            <div class="col-md-6 form-group">
                <?php
                echo form_input(array(
                    "id" => "top_menu_name",
                    "name" => "menu_name",
                    "class" => "form-control",
                    "placeholder" => app_lang('menu_name'),
                    "value" => $model_info->menu_name,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
            <div class="col-md-6 form-group">
                <?php
                echo form_input(array(
                    "id" => "top_url",
                    "name" => "url",
                    "class" => "form-control",
                    "placeholder" => "URL",
                    "value" => $model_info->url,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
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
        $("#top-menu-form").appForm({
            onSuccess: function (result) {
                var $item = $("#top-menus-show-area").find("[data-top_menu_temp_id='" + window.topMenuItemTempId + "']");
                $item.html(result.data);

                saveTopMenusPosition();
                window.topMenuItemTempId = "";
            }
        });
    });
</script>