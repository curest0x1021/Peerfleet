<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
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

                <div>
                    <?php echo view("clients/info_widgets/index"); ?>
                </div>

                <ul id="client-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/contacts/" . $client_info->id); ?>" data-bs-target="#client-contacts"> <?php echo app_lang('contacts'); ?></a></li>
                    <li><a  role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/company_info_tab/" . $client_info->id); ?>" data-bs-target="#client-info"> <?php echo app_lang('vessel_info'); ?></a></li>

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
            }
        }, 210);

        $('[data-bs-toggle="tooltip"]').tooltip();

    });
</script>
