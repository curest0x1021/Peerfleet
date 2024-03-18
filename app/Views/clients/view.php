<?php echo view("includes/cropbox"); ?>
<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <a onclick="history.back()" style="cursor: pointer; font-size: 16px;"><i data-feather="arrow-left" class="icon-24"></i><?php echo app_lang("back"); ?></a>
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0">
                        <?php echo app_lang('client_details') . " - " . $client_info->charter_name ?>
                        <span id="star-mark">
                            <?php
                            if ($is_starred) {
                                echo view('clients/star/starred', array("client_id" => $client_info->id));
                            } else {
                                echo view('clients/star/not_starred', array("client_id" => $client_info->id));
                            }
                            ?>
                        </span>
                    </h1>

                    <?php if (can_access_reminders_module()) { ?>
                        <div class="title-button-group mr0 clients-view">
                            <?php echo modal_anchor(get_uri("events/reminders"), "<i data-feather='clock' class='icon-16'></i> " . app_lang('reminders'), array("class" => "btn btn-default mr0", "id" => "reminder-icon", "data-post-client_id" => $client_info->id, "title" => app_lang('reminders') . " (" . app_lang('private') . ")")); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-md-3 widget-container card">
                        <div class="box-content w200 text-center profile-image  card-body dashboard-icon-widget">
                            <?php
                            echo form_open(get_uri("clients/save_profile_image/" . $client_info->id), array("id" => "profile-image-form", "class" => "general-form", "role" => "form"));
                            ?>
                            
                            <div class="file-upload btn mt0 p0 profile-image-upload" data-bs-toggle="tooltip" title="<?php echo app_lang("upload_and_crop"); ?>" data-placement="right">
                                <span class="btn color-gray"><i data-feather="camera" class="icon-16"></i></span> 
                                <input id="profile_image_file" class="upload" name="profile_image_file" type="file" data-height="200" data-width="200" data-preview-container="#profile-image-preview" data-input-field="#profile_image" />
                            </div>
                            <div class="file-upload btn p0 profile-image-upload profile-image-direct-upload" data-bs-toggle="tooltip" title="<?php echo app_lang("upload"); ?> (200x200 px)" data-placement="right">
                                <?php
                                echo form_upload(array(
                                    "id" => "profile_image_file_upload",
                                    "name" => "profile_image_file",
                                    "class" => "no-outline hidden-input-file upload"
                                ));
                                ?>
                                <label for="profile_image_file_upload" class="clickable">
                                    <span class="btn color-gray ml2"><i data-feather="upload" class="icon-16"></i></span>
                                </label>
                            </div>
                            <input type="hidden" id="profile_image" name="profile_image" value=""  />
                            
                            <span class="avatar avatar-md"><img id="profile-image-preview" src="<?php echo get_avatar($client_info->image); ?>" alt="..."></span> 
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php echo view("clients/info_widgets/index"); ?>
                    </div>
                </div>
                

                <ul id="vessel-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/company_info_tab/" . $client_info->id); ?>" data-bs-target="#client-info"> <?php echo app_lang('vessel_info'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/contacts/" . $client_info->id); ?>" data-bs-target="#client-contacts"> <?php echo app_lang('communication'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/contacts/" . $client_info->id); ?>" data-bs-target="#client-contacts"> Dimensions & Capacities</a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/contacts/" . $client_info->id); ?>" data-bs-target="#client-contacts"> Propulsion</a></li>
                    <?php if ($show_project_info) { ?>
                        <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/projects/" . $client_info->id); ?>" data-bs-target="#client-projects"><?php echo app_lang('projects'); ?></a></li>
                    <?php } ?>

                    <?php if ($show_ticket_info) { ?>
                        <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/tickets/" . $client_info->id); ?>" data-bs-target="#client-tickets"> <?php echo app_lang('tickets'); ?></a></li>
                    <?php } ?>
                    <?php if ($show_note_info) { ?>
                        <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/notes/" . $client_info->id); ?>" data-bs-target="#client-notes"> <?php echo app_lang('notes'); ?></a></li>
                    <?php } ?>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/files/" . $client_info->id); ?>" data-bs-target="#client-files"><?php echo app_lang('files'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/sea_valves/" . $client_info->id); ?>" data-bs-target="#client-sea-valves"><?php echo app_lang('sea_valves'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/warehouses/" . $client_info->id); ?>" data-bs-target="#client-warehouses"><?php echo app_lang('warehouses'); ?></a></li>

                    <?php
                    $hook_tabs = array();
                    $hook_tabs = app_hooks()->apply_filters('app_filter_client_details_ajax_tab', $hook_tabs, $client_info->id);
                    $hook_tabs = is_array($hook_tabs) ? $hook_tabs : array();
                    foreach ($hook_tabs as $hook_tab) {
                        ?>
                        <li><a role="presentation" data-bs-toggle="tab" href="<?php echo get_array_value($hook_tab, 'url') ?>" data-bs-target="#<?php echo get_array_value($hook_tab, 'target') ?>"><?php echo get_array_value($hook_tab, 'title') ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="client-projects"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-files"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-info"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-contacts"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-tickets"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-notes"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-sea-valves"></div>
                    <div role="tabpanel" class="tab-pane fade" id="client-warehouses"></div>
                    <?php foreach ($hook_tabs as $hook_tab) { ?>
                        <div role="tabpanel" class="tab-pane fade" id="<?php echo get_array_value($hook_tab, 'target') ?>"></div>
                    <?php } ?>
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
        setTimeout(function () {
            var tab = "<?php echo $tab; ?>";
            if (tab === "info") {
                $("[data-bs-target='#client-info']").trigger("click");
            } else if (tab === "projects") {
                $("[data-bs-target='#client-projects']").trigger("click");
            } else if (tab === "tickets") {
                $("[data-bs-target='#client-tickets']").trigger("click");
            } else if (tab === "notes") {
                $("[data-bs-target='#client-notes']").trigger("click");
            } else if (tab === "files") {
                $("[data-bs-target='#client-files']").trigger("click");
            } else if (tab === "sea_valves") {
                $("[data-bs-target='#client-sea-valves']").trigger("click");
            } else if (tab === "warehouses") {
                $("[data-bs-target='#client-warehouses']").trigger("click");
            }
        }, 210);

        $('[data-bs-toggle="tooltip"]').tooltip();

    });
</script>
