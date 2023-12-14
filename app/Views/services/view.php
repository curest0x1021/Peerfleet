<?php echo view("includes/cropbox"); ?>
<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="d-flex bg-success clearfix" style="height: 13.125rem; position: relative; background-image: linear-gradient(rgba(0, 0, 0, 0) 33%, rgba(0, 0, 0, 0.6)); align-items: flex-end;">
                    <?php
                        echo form_open(get_uri("services/save_profile_image/" . $model_info->id), array("id" => "profile-image-form", "class" => "general-form", "role" => "form"));
                    ?>
                    <div class="d-flex" style="flex-direction: column;">
                        <div class="file-upload btn mt0 p0" data-bs-toggle="tooltip" title="<?php echo app_lang("upload_and_crop"); ?>" data-placement="right">
                            <span class="btn color-white"><i data-feather="camera" class="icon-16"></i></span> 
                            <input id="profile_image_file" class="upload" name="profile_image_file" type="file" data-height="200" data-width="200" data-preview-container="#profile-image-preview" data-input-field="#profile_image" />
                        </div>
                    </div>
                    
                    <input type="hidden" id="profile_image" name="profile_image" value=""  />
                    
                    <div style="display:flex; margin-bottom: -0.5rem; width: 5.625rem; height: 5.625rem; min-width: 5.625rem; min-height: 5.625rem; border-radius: 0.25rem; margin-right: 2rem; background: white; position: absolute; bottom: 0px; left: 50px;">
                        <img id="profile-image-preview" src="<?php echo get_avatar($model_info->image); ?>" alt="..." style="max-width: 5.625rem; max-height: 5.625rem; inset: 0px; margin: auto; width: auto; height: auto;">
                    </div>

                    <?php echo form_close(); ?>

                    <div style="position: absolute; top: 1rem; left: 1rem;">
                        <div style="display: flex; align-items: center; cursor: pointer;">
                        <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                        </div>
                    </div>
                    <div display="flex" style="margin-bottom: 0.3rem; margin-left: 7rem;">
                        <h1 class="">
                            <div style="display: -webkit-box; overflow: hidden; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo $model_info->company; ?></div>
                            <div style="padding-top: 0.25rem; display: flex;"></div>
                        </h1>
                    </div>
                    <div class="css-cfcamn">
                        <div class="css-1ooh5bl">
                        <?php
                            $website = $model_info->website;
                            if (strpos($website, "http") !== 0) {
                                $website = "https://" . $website;
                            }
                            $link = anchor($website, "<i data-feather='external-link' class='icon-16'></i>", array("class" => "ml15", "target" => "_blank"));
                        ?>
                        </div>
                    </div>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("services/info_tab/" . $model_info->id); ?>" data-bs-target="#company-info"> <?php echo app_lang('general_info'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("services/contacts_tab/" . $model_info->id); ?>" data-bs-target="#service-contacts"> <?php echo app_lang('contacts'); ?></a></li>
                    <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("services/ports/" . $model_info->id); ?>" data-bs-target="#ports"> <?php echo app_lang('ports_served'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="company-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="service-contacts"></div>
                    <div role="tabpanel" class="tab-pane fade" id="ports"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(".upload").change(function () {
            if (typeof FileReader == 'function' && !$(this).hasClass("hidden-input-file")) {
                showCropBox(this);
            } else {
                $("#profile-image-form").submit();
            }
        });
        $("#profile_image").change(function () {
            $("#profile-image-form").submit();
        });


        $("#profile-image-form").appForm({
            isModal: false,
            beforeAjaxSubmit: function (data) {
                $.each(data, function (index, obj) {
                    if (obj.name === "profile_image") {
                        var profile_image = replaceAll(":", "~", data[index]["value"]);
                        data[index]["value"] = profile_image;
                    }
                });
            },
            onSuccess: function (result) {
                if (typeof FileReader == 'function' && !result.reload_page) {
                    appAlert.success(result.message, {duration: 10000});
                } else {
                    location.reload();
                }
            }
        });

    });
</script>