<?php

namespace App\Controllers;

use stdClass;

class Clients extends Security_Controller
{

    function __construct()
    {
        parent::__construct();

        //check permission to access this module
        $this->init_permission_checker("client");
    }

    /* load clients list view */
    function index($tab = "")
    {
        $this->access_only_allowed_members();

        $view_data = $this->make_access_permissions_view_data();

        $view_data['can_edit_clients'] = $this->can_edit_clients();
        $view_data["show_project_info"] = $this->can_manage_all_projects() && !$this->has_all_projects_restricted_role();
        $view_data["show_own_clients_only_user_id"] = $this->show_own_clients_only_user_id();
        $view_data['tab'] = clean_data($tab);
        return $this->template->rander("clients/index", $view_data);
    }

    //for team members, check only read_only permission here, since other permission will be checked accordingly
    protected function can_edit_clients($client_id = 0)
    {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    private function can_view_files()
    {
        if ($this->login_user->user_type == "staff") {
            $this->access_only_allowed_members();
        } else {
            app_redirect("forbidden");
        }
    }

    private function can_add_files()
    {
        if ($this->login_user->user_type == "staff") {
            $this->access_only_allowed_members();
        } else {
            app_redirect("forbidden");
        }
    }

    /* load client add/edit modal */

    function modal_form()
    {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost('id');
        $this->can_access_own_client($client_id);
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";

        $view_data["view"] = $this->request->getPost('view'); //view='details' needed only when loading from the client's details view
        $view_data["ticket_id"] = $this->request->getPost('ticket_id'); //needed only when loading from the ticket's details view and created by unknown client
        $view_data['model_info'] = $this->Clients_model->get_one($client_id);
        //prepare vessel types dropdown list
        $view_data['types_dropdown'] = $this->_get_vessel_types_dropdown_select2_data();
        $view_data["team_members_dropdown"] = $this->get_team_members_dropdown(true);

        return $this->template->view('clients/modal_form', $view_data);
    }

    /* insert or update a client */

    function save()
    {
        $client_id = $this->request->getPost('id');
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->can_access_own_client($client_id);

        $this->access_only_allowed_members_or_client_contact($client_id);

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "charter_name" => "required",
            "christian_name" => "required",
            "owner_id" => "required",
            "vessel_type" => "required",
            "call_sign" => "required",
            "offical_number" => "required",
            "class_number" => "required",
            "mmsi" => "required",
            "build_number" => "required",
            // "ice_class" => "required|max_length[5]",
            "classification_society" => "required",
            "build_yard" => "required",
            "build_series" => "required",
            // "sister" => "required|max_length[30]",
            "flag_state" => "required",
            "port_of_registry" => "required"
        ));

        $data = array(
            "charter_name" => $this->request->getPost('charter_name'),
            "christian_name" => $this->request->getPost('christian_name'),
            "owner_id" => $this->request->getPost('owner_id'),
            "backup_id" => $this->request->getPost('backup_id'),
            "tech_id" => $this->request->getPost('tech_id'),
            "type" => $this->request->getPost('vessel_type'),
            "imo_number" => $this->request->getPost('imo_number'),
            "call_sign" => $this->request->getPost('call_sign'),
            "offical_number" => $this->request->getPost('offical_number'),
            "class_number" => $this->request->getPost('class_number'),
            "mmsi" => $this->request->getPost('mmsi'),
            "build_number" => $this->request->getPost('build_number'),
            "ice_class" => $this->request->getPost('ice_class'),
            "classification_society" => $this->request->getPost('classification_society'),
            "build_yard" => $this->request->getPost('build_yard'),
            "build_series" => $this->request->getPost('build_series'),
            "sister" => $this->request->getPost('sister'),
            "flag_state" => $this->request->getPost('flag_state'),
            "port_of_registry" => $this->request->getPost('port_of_registry'),
        );

        //user has access to change created by
        $data["created_by"] = $this->login_user->id;

        if (!$client_id) {
            $data["created_date"] = get_current_utc_time();
        }

        $data = clean_data($data);

        //check duplicate company name, if found then show an error message
        if ($this->Clients_model->is_duplicate_charter_name($data["charter_name"], $client_id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("account_already_exists_for_your_charter_name")));
            exit();
        }

        $save_id = $this->Clients_model->ci_save($data, $client_id);

        if ($save_id) {
            //save vessel id on the ticket if any ticket id exists
            $ticket_id = $this->request->getPost('ticket_id');
            if ($ticket_id) {
                $ticket_data = array("client_id" => $save_id);
                $this->Tickets_model->ci_save($ticket_data, $ticket_id);
            }

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'view' => $this->request->getPost('view'), 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete or undo a vessel */

    function delete()
    {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $this->can_access_own_client($id);

        if ($this->Clients_model->delete_client_and_sub_items($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    /* list of vessels, prepared for datatable  */

    function list_data()
    {

        $this->access_only_allowed_members();
        $options = array(
            "type" => $this->request->getPost("type"),
            "show_own_clients_only_user_id" => $this->show_own_clients_only_user_id(),
            "quick_filter" => $this->request->getPost("quick_filter"),
            "created_by" => $this->request->getPost("created_by")
        );

        $all_options = append_server_side_filtering_commmon_params($options);

        $result = $this->Clients_model->get_details($all_options);

        //by this, we can handel the server side or client side from the app table prams.
        if (get_array_value($all_options, "server_side")) {
            $list_data = get_array_value($result, "data");
        } else {
            $list_data = $result->getResult();
            $result = array();
        }

        $result_data = array();
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_row($data);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    /* return a row of vessel list table */
    private function _row_data($id)
    {
        $options = array(
            "id" => $id,
        );
        $data = $this->Clients_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    /* prepare a row of client list table */
    private function _make_row($data)
    {
        $image_url = get_avatar($data->owner_avatar);
        $contact = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->owner_name";
        $owner_name = get_team_member_profile_link($data->owner_id, $contact);

        $image_url = get_avatar($data->image);
        $client_contact = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->charter_name";

        $name = $data->charter_name;
        if ($this->can_access_own_client($data->id)) {
            $name = anchor(get_uri("clients/view/" . $data->id), $client_contact);
        }
        $row_data = array(
            $data->id,
            $name,
            $data->owner_name ? $owner_name : "",
            $data->vessel_type,
            to_decimal_format($data->total_projects)
        );

        $row_data[] = modal_anchor(get_uri("clients/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_vessel'), "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_vessel'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("clients/delete"), "data-action" => "delete-confirmation"));

        return $row_data;
    }

    /* load client details view */
    function view($client_id = 0, $tab = "")
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $options = array("id" => $client_id);
            $client_info = $this->Clients_model->get_details($options)->getRow();
            if ($client_info) {

                $view_data = $this->make_access_permissions_view_data();

                $show_own_clients_only_user_id = $this->show_own_clients_only_user_id();
                $open_tickets = $this->Clients_model->count_total_clients(array("show_own_clients_only_user_id" => $show_own_clients_only_user_id, "filter" => "has_open_tickets"));
                $total_clients = $this->Clients_model->count_total_clients(array("show_own_clients_only_user_id" => $show_own_clients_only_user_id));
                $last_announcement = $this->Announcements_model->get_last_announcement();
                $client_info->open_tickets = $open_tickets;
                $client_info->total_vessels = $total_clients;
                $client_info->last_announcement = $last_announcement;

                $view_data["show_note_info"] = (get_setting("module_note")) ? true : false;
                $view_data['client_info'] = $client_info;
                $view_data["is_starred"] = strpos($client_info->starred_by, ":" . $this->login_user->id . ":") ? true : false;
                $view_data["view_type"] = "";
                $view_data["tab"] = clean_data($tab);

                //even it's hidden, admin can view all information of client
                $view_data['hidden_menu'] = array("");

                return $this->template->rander("clients/view", $view_data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    /* add-remove start mark from client */

    function add_remove_star($client_id, $type = "add")
    {
        if ($client_id) {
            $view_data["client_id"] = clean_data($client_id);

            if ($type === "add") {
                $this->Clients_model->add_remove_star($client_id, $this->login_user->id, $type = "add");
                return $this->template->view('clients/star/starred', $view_data);
            } else {
                $this->Clients_model->add_remove_star($client_id, $this->login_user->id, $type = "remove");
                return $this->template->view('clients/star/not_starred', $view_data);
            }
        }
    }

    function show_my_starred_clients()
    {
        $view_data["clients"] = $this->Clients_model->get_starred_clients($this->login_user->id)->getResult();
        return $this->template->view('clients/star/clients_list', $view_data);
    }

    /* load projects tab  */

    function projects($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        $view_data['can_create_projects'] = $this->can_create_projects();
        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $view_data['client_id'] = clean_data($client_id);
        return $this->template->view("clients/projects/index", $view_data);
    }

    /* load tickets tab  */

    function tickets($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {

            $view_data['client_id'] = clean_data($client_id);
            $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("tickets", $this->login_user->is_admin, $this->login_user->user_type);
            $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("tickets", $this->login_user->is_admin, $this->login_user->user_type);

            $view_data['show_project_reference'] = get_setting('project_reference_in_tickets');

            return $this->template->view("clients/tickets/index", $view_data);
        }
    }

    /* load notes tab  */

    function notes($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = clean_data($client_id);
            return $this->template->view("clients/notes/index", $view_data);
        }
    }

    /* load events tab  */

    function events($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = clean_data($client_id);
            $view_data['calendar_filter_dropdown'] = $this->get_calendar_filter_dropdown("client");
            $view_data['event_labels_dropdown'] = json_encode($this->make_labels_dropdown("event", "", true, app_lang("event") . " " . strtolower(app_lang("label"))));
            return $this->template->view("events/index", $view_data);
        }
    }

    /* load files tab */

    function files($client_id, $view_type = "")
    {
        $this->can_view_files();
        $this->can_access_own_client($client_id);

        if ($this->login_user->user_type == "client") {
            $client_id = $this->login_user->client_id;
        }

        $view_data['client_id'] = clean_data($client_id);
        $view_data['page_view'] = false;

        if ($view_type == "page_view") {
            $view_data['page_view'] = true;
            return $this->template->rander("clients/files/index", $view_data);
        } else {
            return $this->template->view("clients/files/index", $view_data);
        }
    }

    /* file upload modal */

    function file_modal_form()
    {
        $this->can_add_files();

        $view_data['model_info'] = $this->General_files_model->get_one($this->request->getPost('id'));
        $client_id = $this->request->getPost('client_id') ? $this->request->getPost('client_id') : $view_data['model_info']->client_id;
        $this->can_access_own_client($client_id);

        $view_data['client_id'] = $client_id;
        return $this->template->view('clients/files/modal_form', $view_data);
    }

    /* save file data and move temp file to parmanent file directory */

    function save_file()
    {
        $this->can_add_files();

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric"
        ));

        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        $files = $this->request->getPost("files");
        $success = false;
        $now = get_current_utc_time();

        $target_path = getcwd() . "/" . get_general_file_path("client", $client_id);

        //process the fiiles which has been uploaded by dropzone
        if ($files && get_array_value($files, 0)) {
            foreach ($files as $file) {
                $file_name = $this->request->getPost('file_name_' . $file);
                $file_info = move_temp_file($file_name, $target_path);
                if ($file_info) {
                    $data = array(
                        "client_id" => $client_id,
                        "file_name" => get_array_value($file_info, 'file_name'),
                        "file_id" => get_array_value($file_info, 'file_id'),
                        "service_type" => get_array_value($file_info, 'service_type'),
                        "description" => $this->request->getPost('description_' . $file),
                        "file_size" => $this->request->getPost('file_size_' . $file),
                        "created_at" => $now,
                        "uploaded_by" => $this->login_user->id
                    );
                    $success = $this->General_files_model->ci_save($data);
                } else {
                    $success = false;
                }
            }
        }


        if ($success) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* list of files, prepared for datatable  */

    function files_list_data($client_id = 0)
    {
        $this->can_view_files();
        $this->can_access_own_client($client_id);

        $options = array("client_id" => $client_id);
        $list_data = $this->General_files_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_file_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _make_file_row($data)
    {
        $image_url = get_avatar($data->uploaded_by_user_image);
        $uploaded_by = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->uploaded_by_user_name";

        if ($data->uploaded_by_user_type == "staff") {
            $uploaded_by = get_team_member_profile_link($data->uploaded_by, $uploaded_by);
        } else {
            $uploaded_by = get_client_contact_profile_link($data->uploaded_by, $uploaded_by);
        }

        $file_name = $data->file_name;
        if (is_viewable_image_file($file_name)) {
            $target_path = get_general_file_path("client", $data->client_id);
            $file_info = array("file_name" => $data->file_name);
            $thumbnail = get_source_url_of_file($file_info, $target_path, "thumbnail");
            $show = "<img class='mr10 float-start' src='$thumbnail' alt='$file_name' style='width: 40px; height: 40px;'/>";
        } else {
            $file_icon = get_file_icon(strtolower(pathinfo($file_name, PATHINFO_EXTENSION)));
            $show = "<div data-feather='$file_icon' class='mr10 float-start' style='width: 24px; height: 24px;'></div>";
        }

        $description = "<div class='float-start'>" .
            js_anchor(remove_file_prefix($data->file_name), array('title' => "", "data-toggle" => "app-modal", "data-sidebar" => "0", "data-url" => get_uri("clients/view_file/" . $data->id)));

        if ($data->description) {
            $description .= "<br /><span>" . $data->description . "</span></div>";
        } else {
            $description .= "</div>";
        }

        $options = anchor(get_uri("clients/download_file/" . $data->id), "<i data-feather='download-cloud' class='icon-16'></i>", array("title" => app_lang("download")));

        if ($this->login_user->user_type == "staff") {
            $options .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_file'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("clients/delete_file"), "data-action" => "delete-confirmation"));
        }


        return array(
            $data->id,
            "<div class='d-flex align-items-center flex-wrap'>" . $show . $description . "</div>",
            convert_file_size($data->file_size),
            $uploaded_by,
            format_to_datetime($data->created_at),
            $options
        );
    }

    function view_file($file_id = 0)
    {
        $file_info = $this->General_files_model->get_details(array("id" => $file_id))->getRow();

        if ($file_info) {
            $this->can_view_files();

            if (!$file_info->client_id) {
                app_redirect("forbidden");
            }

            $this->can_access_own_client($file_info->client_id);

            $view_data['can_comment_on_files'] = false;
            $file_url = get_source_url_of_file(make_array_of_file($file_info), get_general_file_path("client", $file_info->client_id));

            $view_data["file_url"] = $file_url;
            $view_data["is_image_file"] = is_image_file($file_info->file_name);
            $view_data["is_iframe_preview_available"] = is_iframe_preview_available($file_info->file_name);
            $view_data["is_google_preview_available"] = is_google_preview_available($file_info->file_name);
            $view_data["is_viewable_video_file"] = is_viewable_video_file($file_info->file_name);
            $view_data["is_google_drive_file"] = ($file_info->file_id && $file_info->service_type == "google") ? true : false;
            $view_data["is_iframe_preview_available"] = is_iframe_preview_available($file_info->file_name);

            $view_data["file_info"] = $file_info;
            $view_data['file_id'] = clean_data($file_id);
            return $this->template->view("clients/files/view", $view_data);
        } else {
            show_404();
        }
    }

    /* download a file */

    function download_file($id)
    {
        $this->can_view_files();

        $file_info = $this->General_files_model->get_one($id);

        if (!$file_info->client_id) {
            app_redirect("forbidden");
        }

        $this->can_access_own_client($file_info->client_id);

        //serilize the path
        $file_data = serialize(array(make_array_of_file($file_info)));

        return $this->download_app_files(get_general_file_path("client", $file_info->client_id), $file_data);
    }

    /* upload a post file */

    function upload_file()
    {
        upload_file_to_temp();
    }

    /* check valid file for client */

    function validate_file()
    {
        return validate_post_file($this->request->getPost("file_name"));
    }

    /* delete a file */

    function delete_file()
    {

        $id = $this->request->getPost('id');
        $info = $this->General_files_model->get_one($id);

        if (!$info->client_id || ($this->login_user->user_type == "client" && $info->uploaded_by !== $this->login_user->id)) {
            app_redirect("forbidden");
        }

        $this->can_access_own_client($info->client_id);

        if ($this->General_files_model->delete($id)) {

            //delete the files
            delete_app_files(get_general_file_path("client", $info->client_id), array(make_array_of_file($info)));

            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function contact_profile($contact_id = 0, $tab = "")
    {
        $this->access_only_allowed_members_or_contact_personally($contact_id);

        $view_data['user_info'] = $this->Users_model->get_one($contact_id);
        $this->can_access_own_client($view_data['user_info']->client_id);
        $view_data['client_info'] = $this->Clients_model->get_one($view_data['user_info']->client_id);
        $view_data['tab'] = clean_data($tab);
        if ($view_data['user_info']->user_type === "client") {

            $view_data['show_cotact_info'] = true;
            $view_data['show_social_links'] = true;
            $view_data['social_link'] = $this->Social_links_model->get_one($contact_id);
            return $this->template->rander("clients/contacts/view", $view_data);
        } else {
            show_404();
        }
    }

    //show account settings of a user
    function account_settings($contact_id)
    {
        $this->access_only_allowed_members_or_contact_personally($contact_id);
        $view_data['user_info'] = $this->Users_model->get_one($contact_id);
        $view_data['can_edit_clients'] = $this->can_edit_clients();
        $this->can_access_own_client($view_data['user_info']->client_id);
        return $this->template->view("users/account_settings", $view_data);
    }

    //show my preference settings of a team member
    function my_preferences()
    {
        $view_data["user_info"] = $this->Users_model->get_one($this->login_user->id);

        //language dropdown
        $view_data['language_dropdown'] = array();
        if (!get_setting("disable_language_selector_for_clients")) {
            $view_data['language_dropdown'] = get_language_list();
        }

        $view_data["hidden_topbar_menus_dropdown"] = $this->get_hidden_topbar_menus_dropdown();

        return $this->template->view("clients/contacts/my_preferences", $view_data);
    }

    function save_my_preferences()
    {
        //setting preferences
        $settings = array("notification_sound_volume", "disable_push_notification", "disable_keyboard_shortcuts", "reminder_sound_volume", "reminder_snooze_length");

        if (!get_setting("disable_topbar_menu_customization")) {
            array_push($settings, "hidden_topbar_menus");
        }

        foreach ($settings as $setting) {
            $value = $this->request->getPost($setting);
            if (is_null($value)) {
                $value = "";
            }

            $this->Settings_model->save_setting("user_" . $this->login_user->id . "_" . $setting, $value, "user");
        }

        //there was 3 settings in users table.
        //so, update the users table also

        $user_data = array(
            "enable_web_notification" => $this->request->getPost("enable_web_notification"),
            "enable_email_notification" => $this->request->getPost("enable_email_notification"),
        );

        if (!get_setting("disable_language_selector_for_clients")) {
            $user_data["language"] = $this->request->getPost("personal_language");
        }

        $user_data = clean_data($user_data);

        $this->Users_model->ci_save($user_data, $this->login_user->id);

        try {
            app_hooks()->do_action("app_hook_clients_my_preferences_save_data");
        } catch (\Exception $ex) {
            log_message('error', '[ERROR] {exception}', ['exception' => $ex]);
        }

        echo json_encode(array("success" => true, 'message' => app_lang('settings_updated')));
    }

    function save_personal_language($language)
    {
        if (!get_setting("disable_language_selector_for_clients") && ($language || $language === "0")) {

            $language = clean_data($language);
            $data["language"] = strtolower($language);

            $this->Users_model->ci_save($data, $this->login_user->id);
        }
    }

    /* load contacts tab  */

    function contacts($client_id = 0)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = clean_data($client_id);
            $view_data["model_info"] = $this->Clients_model->get_primary_contact($client_id, true);
            $view_data["label_column"] = "col-3";
            $view_data["field_column"] = "col-9";
        } else {
            $view_data["client_id"] = "";
        }

        $view_data['can_edit_clients'] = $this->can_edit_clients();
        return $this->template->view("clients/contacts/index", $view_data);
    }

    /* contact add modal */

    function add_new_contact_modal_form()
    {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $view_data['model_info'] = $this->Users_model->get_one(0);
        $view_data['model_info']->client_id = $this->request->getPost('client_id');

        $view_data['add_type'] = $this->request->getPost('add_type');

        $this->can_access_own_client($view_data['model_info']->client_id);

        return $this->template->view('clients/contacts/modal_form', $view_data);
    }

    /* load contact's general info tab view */

    function contact_general_info_tab($contact_id = 0)
    {
        if ($contact_id) {
            $this->access_only_allowed_members_or_contact_personally($contact_id);

            $view_data['model_info'] = $this->Users_model->get_one($contact_id);
            $this->can_access_own_client($view_data['model_info']->client_id);
            $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("client_contacts", $contact_id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

            $view_data['label_column'] = "col-md-2";
            $view_data['field_column'] = "col-md-10";
            $view_data['can_edit_clients'] = $this->can_edit_clients();
            return $this->template->view('clients/contacts/contact_general_info_tab', $view_data);
        }
    }

    /* load contact's company info tab view */

    function company_info_tab($client_id = 0)
    {
        if ($client_id) {
            $this->access_only_allowed_members_or_client_contact($client_id);
            $this->can_access_own_client($client_id);

            $view_data['model_info'] = $this->Clients_model->get_one($client_id);

            $view_data['label_column'] = "col-md-2";
            $view_data['field_column'] = "col-md-10";
            $view_data['can_edit_clients'] = $this->can_edit_clients();

            $view_data["team_members_dropdown"] = $this->get_team_members_dropdown(true);
            $view_data['types_dropdown'] = $this->_get_vessel_types_dropdown_select2_data();

            return $this->template->view('clients/contacts/company_info_tab', $view_data);
        }
    }

    /* load contact's social links tab view */

    function contact_social_links_tab($contact_id = 0)
    {
        if ($contact_id) {
            $this->access_only_allowed_members_or_contact_personally($contact_id);

            $contact_info = $this->Users_model->get_one($contact_id);
            $this->can_access_own_client($contact_info->client_id);

            $view_data['user_id'] = clean_data($contact_id);
            $view_data['user_type'] = "client";
            $view_data['model_info'] = $this->Social_links_model->get_one($contact_id);
            $view_data['can_edit_clients'] = $this->can_edit_clients();
            return $this->template->view('users/social_links', $view_data);
        }
    }

    /* insert/upadate a contact */

    function save_contact()
    {
        $contact_id = $this->request->getPost('contact_id');
        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->access_only_allowed_members_or_contact_personally($contact_id);

        $user_data = array(
            "email" => $this->request->getPost("email"),
            "sat" => $this->request->getPost('sat'),
            "phone" => $this->request->getPost('phone'),
            "mobile" => $this->request->getPost('mobile'),
        );

        $this->validate_submitted_data(array(
            "client_id" => "required|numeric",
            "email" => "required"
        ));

        if (!$contact_id) {
            //inserting new contact. client_id is required

            $this->validate_submitted_data(array(
                "email" => "required|valid_email",
            ));

            //we'll save following fields only when creating a new contact from this form
            $user_data["client_id"] = $client_id;
            $user_data["email"] = trim($this->request->getPost('email'));
            if ($this->request->getPost("login_password")) {
                $user_data["password"] = password_hash($this->request->getPost("login_password"), PASSWORD_DEFAULT);
            }
            $user_data["created_at"] = get_current_utc_time();

            //validate duplicate email address
            if ($this->Users_model->is_email_exists($user_data["email"], 0, $client_id)) {
                echo json_encode(array("success" => false, 'message' => app_lang('duplicate_email')));
                exit();
            }
        }

        //by default, the first contact of a client is the primary contact
        //check existing primary contact. if not found then set the first contact = primary contact
        $primary_contact = $this->Clients_model->get_primary_contact($client_id);
        if (!$primary_contact) {
            $user_data['is_primary_contact'] = 1;
        }

        //only admin can change existing primary contact
        $is_primary_contact = $this->request->getPost('is_primary_contact');
        if ($is_primary_contact && $this->login_user->is_admin) {
            $user_data['is_primary_contact'] = 1;
        }

        $user_data = clean_data($user_data);

        $save_id = $this->Users_model->ci_save($user_data, $contact_id);
        if ($save_id) {

            save_custom_fields("client_contacts", $save_id, $this->login_user->is_admin, $this->login_user->user_type);

            //has changed the existing primary contact? updete previous primary contact and set is_primary_contact=0
            if ($is_primary_contact) {
                $user_data = array("is_primary_contact" => 0);
                $this->Users_model->ci_save($user_data, $primary_contact);
            }

            //send login details to user only for first time. when creating  a new contact
            if (!$contact_id && $this->request->getPost('email_login_details')) {
                $email_template = $this->Email_templates_model->get_final_template("login_info"); //use default template since creating a new contact

                $parser_data["SIGNATURE"] = $email_template->signature;
                $parser_data["USER_FIRST_NAME"] = $user_data["first_name"];
                $parser_data["USER_LAST_NAME"] = $user_data["last_name"];
                $parser_data["USER_LOGIN_EMAIL"] = $user_data["email"];
                $parser_data["USER_LOGIN_PASSWORD"] = $this->request->getPost('login_password');
                $parser_data["DASHBOARD_URL"] = base_url();
                $parser_data["LOGO_URL"] = get_logo_url();

                $message = $this->parser->setData($parser_data)->renderString($email_template->message);
                $subject = $this->parser->setData($parser_data)->renderString($email_template->subject);

                send_app_mail($this->request->getPost('email'), $subject, $message);
            }

            echo json_encode(array("success" => true, "data" => $this->_contact_row_data($save_id), 'id' => $contact_id, "client_id" => $client_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //save social links of a contact
    function save_contact_social_links($contact_id = 0)
    {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $contact_id = clean_data($contact_id);

        $this->access_only_allowed_members_or_contact_personally($contact_id);

        $contact_info = $this->Users_model->get_one($contact_id);
        $this->can_access_own_client($contact_info->client_id);

        $id = 0;

        //find out, the user has existing social link row or not? if found update the row otherwise add new row.
        $has_social_links = $this->Social_links_model->get_one($contact_id);
        if (isset($has_social_links->id)) {
            $id = $has_social_links->id;
        }

        $social_link_data = array(
            "facebook" => $this->request->getPost('facebook'),
            "twitter" => $this->request->getPost('twitter'),
            "linkedin" => $this->request->getPost('linkedin'),
            "digg" => $this->request->getPost('digg'),
            "youtube" => $this->request->getPost('youtube'),
            "pinterest" => $this->request->getPost('pinterest'),
            "instagram" => $this->request->getPost('instagram'),
            "github" => $this->request->getPost('github'),
            "tumblr" => $this->request->getPost('tumblr'),
            "vine" => $this->request->getPost('vine'),
            "whatsapp" => $this->request->getPost('whatsapp'),
            "user_id" => $contact_id,
            "id" => $id ? $id : $contact_id
        );

        $social_link_data = clean_data($social_link_data);

        $this->Social_links_model->ci_save($social_link_data, $id);
        echo json_encode(array("success" => true, 'message' => app_lang('record_updated')));
    }

    //save account settings of a client contact (user)
    function save_account_settings($user_id)
    {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }
        $this->access_only_allowed_members_or_contact_personally($user_id);

        $contact_info = $this->Users_model->get_one($user_id);
        $this->can_access_own_client($contact_info->client_id);

        $this->validate_submitted_data(array(
            "email" => "required|valid_email"
        ));

        $email = $this->request->getPost('email');
        $password = $this->request->getPost("password");

        if ($this->Users_model->is_email_exists($email, $user_id, $contact_info->client_id)) {
            echo json_encode(array("success" => false, 'message' => app_lang('duplicate_email')));
            exit();
        }

        $account_data = array(
            "email" => $email
        );

        //don't reset password if user doesn't entered any password
        if ($password) {
            $this->Users_model->update_password($email, password_hash($password, PASSWORD_DEFAULT));
        }

        //only admin can disable other users login permission
        if ($this->login_user->is_admin) {
            $account_data['disable_login'] = $this->request->getPost('disable_login');
        }


        if ($this->Users_model->ci_save($account_data, $user_id)) {

            //resend new password to client contact
            if ($this->request->getPost('email_login_details')) {
                $email_template = $this->Email_templates_model->get_final_template("login_info", true);

                $user_language = $this->Users_model->get_one($user_id)->language;
                $parser_data["SIGNATURE"] = get_array_value($email_template, "signature_$user_language") ? get_array_value($email_template, "signature_$user_language") : get_array_value($email_template, "signature_default");
                $parser_data["USER_FIRST_NAME"] = $this->request->getPost('first_name');
                $parser_data["USER_LAST_NAME"] = $this->request->getPost('last_name');
                $parser_data["USER_LOGIN_EMAIL"] = $account_data["email"];
                $parser_data["USER_LOGIN_PASSWORD"] = $password;
                $parser_data["DASHBOARD_URL"] = base_url();
                $parser_data["LOGO_URL"] = get_logo_url();

                $message = get_array_value($email_template, "message_$user_language") ? get_array_value($email_template, "message_$user_language") : get_array_value($email_template, "message_default");
                $subject = get_array_value($email_template, "subject_$user_language") ? get_array_value($email_template, "subject_$user_language") : get_array_value($email_template, "subject_default");

                $message = $this->parser->setData($parser_data)->renderString($message);
                $subject = $this->parser->setData($parser_data)->renderString($subject);
                send_app_mail($email, $subject, $message);
            }

            echo json_encode(array("success" => true, 'message' => app_lang('record_updated')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //save profile image of a contact
    function save_profile_image($client_id = 0)
    {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $client_info = $this->Clients_model->get_one($client_id);
        
        //process the the file which has uploaded by dropzone
        $profile_image = str_replace("~", ":", $this->request->getPost("profile_image"));

        if ($profile_image) {
            $profile_image = serialize(move_temp_file("avatar.png", get_setting("profile_image_path"), "", $profile_image));

            //delete old file
            delete_app_files(get_setting("profile_image_path"), array(@unserialize($client_info->image)));

            $image_data = array("image" => $profile_image);
            $this->Clients_model->ci_save($image_data, $client_id);
            echo json_encode(array("success" => true, 'message' => app_lang('profile_image_changed')));
        }

        //process the the file which has uploaded using manual file submit
        if ($_FILES) {
            $profile_image_file = get_array_value($_FILES, "profile_image_file");
            $image_file_name = get_array_value($profile_image_file, "tmp_name");
            if ($image_file_name) {
                if (!$this->check_profile_image_dimension($image_file_name)) {
                    echo json_encode(array("success" => false, 'message' => app_lang('profile_image_error_message')));
                    exit();
                }

                $profile_image = serialize(move_temp_file("avatar.png", get_setting("profile_image_path"), "", $image_file_name));

                //delete old file
                delete_app_files(get_setting("profile_image_path"), array(@unserialize($client_info->image)));

                $image_data = array("image" => $profile_image);
                $this->Clients_model->ci_save($image_data, $client_id);
                echo json_encode(array("success" => true, 'message' => app_lang('profile_image_changed'), "reload_page" => true));
            }
        }
    }

    /* delete or undo a contact */

    function delete_contact()
    {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $this->access_only_allowed_members();

        $id = $this->request->getPost('id');

        $contact_info = $this->Users_model->get_one($id);
        $this->can_access_own_client($contact_info->client_id);

        if ($this->request->getPost('undo')) {
            if ($this->Users_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_contact_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Users_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of contacts, prepared for datatable  */

    function contacts_list_data($client_id = 0)
    {

        $this->access_only_allowed_members_or_client_contact($client_id);
        $this->can_access_own_client($client_id);
        $options = array(
            "user_type" => "client",
            "client_id" => $client_id,
            "show_own_clients_only_user_id" => $this->show_own_clients_only_user_id(),
            "quick_filter" => $this->request->getPost("quick_filter"),
        );

        $all_options = append_server_side_filtering_commmon_params($options);

        $result = $this->Users_model->get_details($all_options);

        //by this, we can handel the server side or client side from the app table prams.
        if (get_array_value($all_options, "server_side")) {
            $list_data = get_array_value($result, "data");
        } else {
            $list_data = $result->getResult();
            $result = array();
        }

        $hide_primary_contact_label = false;
        if (!$client_id) {
            $hide_primary_contact_label = true;
        }

        $result_data = array();
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_contact_row($data, $hide_primary_contact_label);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    /* return a row of contact list table */

    private function _contact_row_data($id)
    {
        $options = array(
            "id" => $id,
            "user_type" => "client",
        );
        $data = $this->Users_model->get_details($options)->getRow();
        return $this->_make_contact_row($data);
    }

    /* prepare a row of contact list table */

    private function _make_contact_row($data, $hide_primary_contact_label = false)
    {
        $image_url = get_avatar($data->image);
        $user_avatar = "<span class='avatar avatar-xs'><img src='$image_url' alt='...'></span>";
        $full_name = $data->first_name ?  $data->first_name . " " . $data->last_name . " " : "_";
        $primary_contact = "";
        if ($data->is_primary_contact == "1" && !$hide_primary_contact_label) {
            $primary_contact = "<span class='bg-info badge text-white'>" . app_lang('primary_contact') . "</span>";
        }

        $removal_request_pending = "";
        if ($this->login_user->user_type == "staff" && $data->requested_account_removal) {
            $removal_request_pending = "<span class='bg-danger badge'>" . app_lang("removal_request_pending") . "</span>";
        }

        $contact_link = anchor(get_uri("clients/contact_profile/" . $data->id), $full_name . $primary_contact) . $removal_request_pending;
        if ($this->login_user->user_type === "client") {
            $contact_link = $full_name; //don't show clickable link to client
        }

        $client_info = $this->Clients_model->get_one($data->client_id);

        $row_data = array(
            $user_avatar,
            $contact_link,
            anchor(get_uri("clients/view/" . $data->client_id), $client_info->charter_name),
            $data->email,
            $data->sat ? $data->sat : "-",
            $data->phone ? $data->phone : "-",
            $data->mobile ? $data->mobile : "-"
        );

        $row_data[] = js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_contact'), "class" => "delete", "data-id" => "$data->id", "data-action-url" => get_uri("clients/delete_contact"), "data-action" => "delete"));

        return $row_data;
    }

    /* open invitation modal */

    function invitation_modal()
    {
        if (get_setting("disable_user_invitation_option_by_clients") && $this->login_user->user_type == "client") {
            app_redirect("forbidden");
        }

        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "client_id" => "required|numeric"
        ));

        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        $this->access_only_allowed_members_or_client_contact($client_id);

        $view_data["client_info"] = $this->Clients_model->get_one($client_id);
        return $this->template->view('clients/contacts/invitation_modal', $view_data);
    }

    //send a team member invitation to an email address
    function send_invitation()
    {
        if (get_setting("disable_user_invitation_option_by_clients") && $this->login_user->user_type == "client") {
            app_redirect("forbidden");
        }

        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        $email = trim($this->request->getPost('email'));

        $this->validate_submitted_data(array(
            "client_id" => "required|numeric",
            "email" => "required|valid_email|trim"
        ));

        $this->access_only_allowed_members_or_client_contact($client_id);

        $email_template = $this->Email_templates_model->get_final_template("client_contact_invitation"); //use default template since sending new invitation

        $parser_data["INVITATION_SENT_BY"] = $this->login_user->first_name . " " . $this->login_user->last_name;
        $parser_data["SIGNATURE"] = $email_template->signature;
        $parser_data["SITE_URL"] = get_uri();
        $parser_data["LOGO_URL"] = get_logo_url();

        $verification_data = array(
            "type" => "invitation",
            "code" => make_random_string(),
            "params" => serialize(array(
                "email" => $email,
                "type" => "client",
                "client_id" => $client_id,
                "expire_time" => time() + (24 * 60 * 60) //make the invitation url with 24hrs validity
            ))
        );

        $save_id = $this->Verification_model->ci_save($verification_data);
        $verification_info = $this->Verification_model->get_one($save_id);

        $parser_data['INVITATION_URL'] = get_uri("signup/accept_invitation/" . $verification_info->code);

        //send invitation email
        $message = $this->parser->setData($parser_data)->renderString($email_template->message);
        $subject = $this->parser->setData($parser_data)->renderString($email_template->subject);

        if (send_app_mail($email, $subject, $message)) {
            echo json_encode(array('success' => true, 'message' => app_lang("invitation_sent")));
        } else {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* only visible to client  */

    function users()
    {
        if ($this->login_user->user_type === "client") {
            $view_data['client_id'] = $this->login_user->client_id;
            return $this->template->rander("clients/contacts/users", $view_data);
        }
    }

    /* show keyboard shortcut modal form */

    function keyboard_shortcut_modal_form()
    {
        return $this->template->view('team_members/keyboard_shortcut_modal_form');
    }

    function upload_excel_file()
    {
        upload_file_to_temp(true);
    }

    function import_clients_modal_form()
    {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        return $this->template->view("clients/import_clients_modal_form");
    }

    private function _prepare_client_data($data_row, $allowed_headers)
    {
        //prepare client data
        $client_data = array();
        $contact_data = array();
        $vessel_type_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }

            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "email") {
                $contact_data["email"] = $row_data_value;
            } else if ($header_key_value == "sat") {
                $contact_data["sat"] = $row_data_value;
            } else if ($header_key_value == "mobile") {
                $contact_data["phone"] = $row_data_value;
            } else if ($header_key_value == "iridium_phone") {
                $contact_data["mobile"] = $row_data_value;
            } else if ($header_key_value == "type") {
                $vessel_type_data["title"] = $row_data_value;
            } else {
                $client_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "client_data" => $client_data,
            "contact_data" => $contact_data,
            "vessel_type_data" => $vessel_type_data
        );
    }

    function save_client_from_excel_file()
    {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        if (!$this->validate_import_clients_file_data(true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = $this->_get_allowed_headers();
        $now = get_current_utc_time();
        $vessel_types = $this->Vessel_types_model->get_all()->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }
            
            $client_data_array = $this->_prepare_client_data($value, $allowed_headers);
            $client_data = get_array_value($client_data_array, "client_data");
            $contact_data = get_array_value($client_data_array, "contact_data");
            $vessel_type_data = get_array_value($client_data_array, "vessel_type_data");

            //couldn't prepare valid data
            if (!($client_data && count($client_data))) {
                continue;
            }

            // Vessel types
            $vessel_type = $this->findObjectByTitle($vessel_type_data["title"], $vessel_types);
            if ($vessel_type) {
                $client_data["type"] = $vessel_type->id;
            } else {
                $m_save_id = $this->Vessel_types_model->ci_save($vessel_type_data);
                $client_data["type"] = $m_save_id;

                $temp = new stdClass();
                $temp->id = $m_save_id;
                $temp->title = $vessel_type_data["title"];
                $vessel_types[] = $temp;
            }

            //found information about client, add some additional info
            $client_data["owner_id"] = "";
            $client_data["created_date"] = $now;
            $client_data["created_by"] = $this->login_user->id;

            $client_data = clean_data($client_data);

            //check duplicate company name, if found then show an error message
            if ($this->Clients_model->is_duplicate_charter_name($client_data["charter_name"])) {
                continue;
            }
            //////////////////
            $similar_clients=$this->Clients_model->get_all_where(array("charter_name"=>$client_data["charter_name"]))->getResult();
            if(count($similar_clients)>0) continue;
            /////////////////

            //save client data
            $client_save_id = $this->Clients_model->ci_save($client_data);
            if (!$client_save_id) {
                continue;
            }

            //add client id to contact data
            if (isset($contact_data["email"])) {
                //validate duplicate email address
                if ($this->Users_model->is_email_exists($contact_data["email"], 0, $client_save_id)) {
                    continue;
                }
                $contact_data["client_id"] = $client_save_id;
                $contact_data["first_name"] = "";
                $contact_data["last_name"] = "";
                $contact_data["is_primary_contact"] = 1;
                $this->Users_model->ci_save($contact_data);
            }
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function findObjectByTitle($title, $arr)
    {
        $title = trim($title);
        foreach ($arr as $item) {
            if ($title == $item->title) {
                return $item;
            }
        }
        return false;
    }

    private function _save_custom_fields_of_client($client_id, $custom_field_values_array)
    {
        if (!$custom_field_values_array) {
            return false;
        }

        foreach ($custom_field_values_array as $key => $custom_field_value) {
            $field_value_data = array(
                "related_to_type" => "clients",
                "related_to_id" => $client_id,
                "custom_field_id" => $key,
                "value" => $custom_field_value
            );

            $field_value_data = clean_data($field_value_data);

            $this->Custom_field_values_model->ci_save($field_value_data);
        }
    }

    private function _get_allowed_headers()
    {
        return array(
            "charter_name",
            "christian_name",
            "type",
            "imo_number",
            "call_sign",
            "offical_number",
            "class_number",
            "mmsi",
            "build_number",
            "ice_class",
            "classification_society",
            "build_yard",
            "build_series",
            "sister",
            "flag_state",
            "port_of_registry",
            "email",
            "sat",
            "mobile",
            "iridium_phone"
        );
    }

    function validate_import_clients_file()
    {
        $this->access_only_allowed_members();

        $file_name = $this->request->getPost("file_name");
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => false, 'message' => app_lang('invalid_file_type')));
            exit();
        }

        if ($file_ext == "xlsx") {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('please_upload_a_excel_file') . " (.xlsx)"));
        }
    }

    function validate_import_clients_file_data($check_on_submit = false)
    {
        $this->access_only_allowed_members();

        $table_data = "";
        $error_message = "";
        $headers = array();
        $got_error_header = false; //we've to check the valid headers first, and a single header at a time
        $got_error_table_data = false;

        $file_name = $this->request->getPost("file_name");

        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $table_data .= '<table class="table table-responsive table-bordered table-hover" style="width: 100%; color: #444;">';

        $table_data_header_array = array();
        $table_data_body_array = array();

        foreach ($excel_file as $row_key => $value) {
            if ($row_key == 0) { //validate headers
                $headers = $this->_store_headers_position($value);

                foreach ($headers as $row_data) {
                    $has_error_class = false;
                    if (get_array_value($row_data, "has_error") && !$got_error_header) {
                        $has_error_class = true;
                        $got_error_header = true;

                        $error_message = sprintf(app_lang("import_client_error_header"), app_lang(get_array_value($row_data, "key_value")));
                    }

                    array_push($table_data_header_array, array("has_error_class" => $has_error_class, "value" => get_array_value($row_data, "value")));
                }
            } else { //validate data
                if (!array_filter($value)) {
                    continue;
                }

                $error_message_on_this_row = "<ol class='pl15'>";

                foreach ($value as $key => $row_data) {
                    $has_error_class = false;

                    if (!$got_error_header) {
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($key, $row_data);
                        if ($row_data_validation) {
                            $has_error_class = true;
                            $error_message_on_this_row .= "<li>" . $row_data . ": " . $row_data_validation . "</li>";
                            $got_error_table_data = true;
                        }
                    }

                    if (count($headers) > $key) {
                        $table_data_body_array[$row_key][] = array("has_error_class" => $has_error_class, "value" => $row_data);
                    }
                }

                $error_message_on_this_row .= "</ol>";

                //error messages for this row
                if ($got_error_table_data) {
                    $table_data_body_array[$row_key][] = array("has_error_text" => true, "value" => $error_message_on_this_row);
                }
            }
        }

        //return false if any error found on submitting file
        if ($check_on_submit) {
            return ($got_error_header || $got_error_table_data) ? false : true;
        }

        //add error header if there is any error in table body
        if ($got_error_table_data) {
            array_push($table_data_header_array, array("has_error_text" => true, "value" => app_lang("error")));
        }

        //add headers to table
        $table_data .= "<tr>";
        foreach ($table_data_header_array as $table_data_header) {
            $error_class = get_array_value($table_data_header, "has_error_class") ? "error" : "";
            $error_text = get_array_value($table_data_header, "has_error_text") ? "text-danger" : "";
            $value = get_array_value($table_data_header, "value");
            $table_data .= "<th class='$error_class $error_text'>" . $value . "</th>";
        }
        $table_data .= "</tr>";

        //add body data to table
        foreach ($table_data_body_array as $table_data_body_row) {
            $table_data .= "<tr>";
            $error_text = "";

            foreach ($table_data_body_row as $table_data_body_row_data) {
                $error_class = get_array_value($table_data_body_row_data, "has_error_class") ? "error" : "";
                $error_text = get_array_value($table_data_body_row_data, "has_error_text") ? "text-danger" : "";
                $value = get_array_value($table_data_body_row_data, "value");
                $table_data .= "<td class='$error_class $error_text'>" . $value . "</td>";
            }

            if ($got_error_table_data && !$error_text) {
                $table_data .= "<td></td>";
            }

            $table_data .= "</tr>";
        }

        //add error message for header
        if ($error_message) {
            $total_columns = count($table_data_header_array);
            $table_data .= "<tr><td class='text-danger' colspan='$total_columns'><i data-feather='alert-triangle' class='icon-16'></i> " . $error_message . "</td></tr>";
        }

        $table_data .= "</table>";

        echo json_encode(array("success" => true, 'table_data' => $table_data, 'got_error' => ($got_error_header || $got_error_table_data) ? true : false));
    }

    private function _row_data_validation_and_get_error_message($key, $data)
    {
        $allowed_headers = $this->_get_allowed_headers();
        $header_value = get_array_value($allowed_headers, $key);

        if (((count($allowed_headers)) > $key) && empty($data)) {
            if (
                $header_value == "charter_name" ||
                $header_value == "christan_name" ||
                $header_value == "type" ||
                $header_value == "imo_number" ||
                $header_value == "call_sign" ||
                $header_value == "offical_number" ||
                $header_value == "class_number" ||
                $header_value == "mmsi" ||
                $header_value == "build_number" ||
                $header_value == "classification_society" ||
                $header_value == "build_yard" ||
                $header_value == "build_series" ||
                $header_value == "flat_state" ||
                $header_value == "port_of_registry"
            ) {
                $error_message = sprintf(app_lang("import_data_empty_message"), $header_value);
                return $error_message;
            }
        }
    }

    function download_sample_excel_file()
    {
        $this->access_only_allowed_members();
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => "import-vessels-sample.xlsx"))));
    }

    function gdpr()
    {
        $view_data["user_info"] = $this->Users_model->get_one($this->login_user->id);
        return $this->template->view("clients/contacts/gdpr", $view_data);
    }

    function export_my_data()
    {
        if (get_setting("enable_gdpr") && get_setting("allow_clients_to_export_their_data")) {
            $user_info = $this->Users_model->get_one($this->login_user->id);

            $txt_file_name = $user_info->first_name . " " . $user_info->last_name . ".txt";

            $data = $this->_make_export_data($user_info);

            $handle = fopen($txt_file_name, "w");
            fwrite($handle, $data);
            fclose($handle);

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($txt_file_name));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($txt_file_name));
            readfile($txt_file_name);

            //delete local file
            if (file_exists($txt_file_name)) {
                unlink($txt_file_name);
            }

            exit;
        }
    }

    private function _make_export_data($user_info)
    {
        $required_general_info_array = array("first_name", "last_name", "email", "job_title", "phone", "gender", "linkedin", "created_at");

        $data = strtoupper(app_lang("general_info")) . "\n";

        //add general info
        foreach ($required_general_info_array as $field) {
            if ($user_info->$field) {
                if ($field == "created_at") {
                    $data .= app_lang("created") . ": " . format_to_datetime($user_info->$field) . "\n";
                } else if ($field == "gender") {
                    $data .= app_lang($field) . ": " . ucfirst($user_info->$field) . "\n";
                } else if ($field == "linkedin") {
                    $data .= "Skype: " . ucfirst($user_info->$field) . "\n";
                } else {
                    $data .= app_lang($field) . ": " . $user_info->$field . "\n";
                }
            }
        }

        $data .= "\n\n";
        $data .= strtoupper(app_lang("client_info")) . "\n";

        //add company info
        $client_info = $this->Clients_model->get_one($user_info->client_id);
        $required_client_info_array = array("company_name", "address", "city", "state", "zip", "country", "phone", "website", "vat_number");
        foreach ($required_client_info_array as $field) {
            if ($client_info->$field) {
                $data .= app_lang($field) . ": " . $client_info->$field . "\n";
            }
        }

        $data .= "\n\n";
        $data .= strtoupper(app_lang("social_links")) . "\n";

        //add social links
        $social_links = $this->Social_links_model->get_one($user_info->id);

        unset($social_links->id);
        unset($social_links->user_id);
        unset($social_links->deleted);

        foreach ($social_links as $key => $value) {
            if ($value) {
                $data .= ucfirst($key) . ": " . $value . "\n";
            }
        }

        return $data;
    }

    function request_my_account_removal()
    {
        if (get_setting("enable_gdpr") && get_setting("clients_can_request_account_removal")) {

            $user_id = $this->login_user->id;
            $data = array("requested_account_removal" => 1);
            $this->Users_model->ci_save($data, $user_id);

            $client_id = $this->Users_model->get_one($user_id)->client_id;
            log_notification("client_contact_requested_account_removal", array("client_id" => $client_id), $user_id);

            $this->session->setFlashdata("success_message", app_lang("estimate_submission_message"));
            app_redirect("clients/contact_profile/$user_id/gdpr");
        }
    }

    function clients_list()
    {
        $this->access_only_allowed_members();

        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("clients", $this->login_user->is_admin, $this->login_user->user_type);

        $access_info = $this->get_access_info("invoice");
        $view_data["show_invoice_info"] = (get_setting("module_invoice") && $access_info->access_type == "all") ? true : false;
        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("clients", $this->login_user->is_admin, $this->login_user->user_type);

        $view_data['types_dropdown'] = json_encode($this->_get_vessel_types_dropdown_select2_data(true));
        $view_data['can_edit_clients'] = $this->can_edit_clients();
        $view_data["team_members_dropdown"] = $this->get_team_members_dropdown(true);

        return $this->template->view("clients/clients_list", $view_data);
    }

    private function make_access_permissions_view_data()
    {
        $access_ticket = $this->get_access_info("ticket");
        $view_data["show_ticket_info"] = (get_setting("module_ticket") && $access_ticket->access_type == "all") ? true : false;

        $access_contract = $this->get_access_info("contract");
        $view_data["show_contract_info"] = (get_setting("module_contract") && $access_contract->access_type == "all") ? true : false;
        $view_data["show_project_info"] = !$this->has_all_projects_restricted_role();

        return $view_data;
    }

    function switch_account($user_id)
    {
        validate_numeric_value($user_id);
        $this->access_only_clients();

        $options = array(
            'id' => $user_id,
            'email' => $this->login_user->email,
            'status' => 'active',
            'deleted' => 0,
            'disable_login' => 0,
            'user_type' => 'client'
        );

        $user_info = $this->Users_model->get_one_where($options);
        if (!$user_info->id) {
            show_404();
        }

        $session = \Config\Services::session();
        $session->set('user_id', $user_info->id);

        app_redirect('dashboard/view');
    }

    function total_clients_list()
    {
        $this->access_only_allowed_members();

        $result = $this->Clients_model->get_total_clients();

        $result_data = array();
        foreach ($result as $data) {
            $result_data[] = $this->_make_client_row($data);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    private function _make_client_row($data)
    {
        $favorite = empty($data->starred_by) ? "<i data-feather='star' class='icon-16' style='color: #ffb822;'></i>" : "<i data-feather='star' class='icon-16 icon-fill-warning' style='color: #ffb822;'></i>";
        $row_data = array(
            anchor(get_uri("clients/view/" . $data->id), $data->charter_name),
            $data->vessel_type,
            $data->build_series,
            $favorite
        );

        return $row_data;
    }

    //load the sea valves view
    function sea_valves($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = clean_data($client_id);
            return $this->template->view("clients/sea_valves/index", $view_data);
        }
    }

    function sea_valve_modal_form()
    {
        $this->access_only_allowed_members();
        // if (!$this->can_edit_clients()) {
        //     app_redirect("forbidden");
        // }

        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        $view_data["model_info"] = $this->Sea_valves_model->get_one($this->request->getPost('id'));
        $client_id = $this->request->getPost('client_id') ? $this->request->getPost('client_id') : $view_data['model_info']->client_id;
        $this->can_access_own_client($client_id);

        $view_data['client_id'] = $client_id;

        return $this->template->view('clients/sea_valves/modal_form', $view_data);
    }

    function import_sea_valves_modal_form()
    {
        $this->access_only_allowed_members();

        $client_id = $this->request->getPost('client_id') ? $this->request->getPost('client_id') : $view_data['model_info']->client_id;
        $this->can_access_own_client($client_id);

        $view_data['client_id'] = $client_id;

        return $this->template->view('clients/sea_valves/import_modal_form', $view_data);
    }

    function save_sea_valve_from_excel_file()
    {
        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        if (!$this->validate_import_sea_valves_file_data(true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = $this->_get_allowed_sea_valve_headers();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $sea_valve_data = $this->_prepare_sea_valve_data($value, $allowed_headers);
            //couldn't prepare valid data
            if (!($sea_valve_data && count($sea_valve_data))) {
                continue;
            }
            $sea_valve_data["client_id"] = $client_id;

            //save client data
            $save_id = $this->Sea_valves_model->ci_save($sea_valve_data);
            if (!$save_id) {
                continue;
            }
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    function download_sample_sea_valves_excel_file()
    {
        $this->access_only_allowed_members();
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => "import-sea-valves-sample.xlsx"))));
    }

    function validate_import_sea_valves_file()
    {
        $this->access_only_allowed_members();

        $file_name = $this->request->getPost("file_name");
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => false, 'message' => app_lang('invalid_file_type')));
            exit();
        }

        if ($file_ext == "xlsx") {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('please_upload_a_excel_file') . " (.xlsx)"));
        }
    }

    private function _get_allowed_sea_valve_headers()
    {
        return array(
            "name",
            "description",
            "norm",
            "diameter_nominal",
            "pressure_rating",
            "length",
            "height",
            "diameter"
        );
    }

    private function _store_sea_valve_headers_position($headers_row = array())
    {
        $allowed_headers = $this->_get_allowed_sea_valve_headers();

        //check if all headers are correct and on the right position
        $final_headers = array();
        foreach ($headers_row as $key => $header) {
            if (!$header) {
                continue;
            }

            $key_value = str_replace(' ', '_', strtolower(trim($header, " ")));
            $header_on_this_position = get_array_value($allowed_headers, $key);
            $header_array = array("key_value" => $header_on_this_position, "value" => $header);

            if ($header_on_this_position == $key_value) {
                //allowed headers
                //the required headers should be on the correct positions
                //the rest headers will be treated as custom fields
                //pushed header at last of this loop
            } else { //invalid header, flag as red
                $header_array["has_error"] = true;
            }

            if ($key_value) {
                array_push($final_headers, $header_array);
            }
        }

        return $final_headers;
    }

    private function _sea_valve_row_data_validation_and_get_error_message($key, $data)
    {
        $allowed_headers = $this->_get_allowed_sea_valve_headers();
        $header_value = get_array_value($allowed_headers, $key);

        //there has no date field on default import fields
        if (((count($allowed_headers)) > $key) && $data) {
            if ($header_value == "description") {
            } else {
                if (empty($data)) {
                    $error_message = sprintf(app_lang("import_data_empty_message"), app_lang($header_value));
                    return $error_message;
                } else {
                    if ($header_value == "name") {
                        if (strlen($data) > 30) {
                            $error_message = sprintf(app_lang("import_data_max_length_error_message"), app_lang($header_value), "30");
                            return $error_message;
                        }
                    } else {
                        if (strlen($data) > 20) {
                            $error_message = sprintf(app_lang("import_data_max_length_error_message"), app_lang($header_value), "20");
                            return $error_message;
                        }
                    }
                }
            }
        }
    }

    private function _prepare_sea_valve_data($data_row, $allowed_headers)
    {
        //prepare sea valve data
        $sea_valve_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }

            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            $sea_valve_data[$header_key_value] = $row_data_value;
        }

        return $sea_valve_data;
    }

    function validate_import_sea_valves_file_data($check_on_submit = false)
    {
        $this->access_only_allowed_members();

        $table_data = "";
        $error_message = "";
        $headers = array();
        $got_error_header = false; //we've to check the valid headers first, and a single header at a time
        $got_error_table_data = false;

        $file_name = $this->request->getPost("file_name");

        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $table_data .= '<table class="table table-responsive table-bordered table-hover" style="width: 100%; color: #444;">';

        $table_data_header_array = array();
        $table_data_body_array = array();

        foreach ($excel_file as $row_key => $value) {
            if ($row_key == 0) { //validate headers
                $headers = $this->_store_sea_valve_headers_position($value);

                foreach ($headers as $row_data) {
                    $has_error_class = false;
                    if (get_array_value($row_data, "has_error") && !$got_error_header) {
                        $has_error_class = true;
                        $got_error_header = true;

                        $error_message = sprintf(app_lang("import_error_header"), app_lang(get_array_value($row_data, "key_value")));
                    }

                    array_push($table_data_header_array, array("has_error_class" => $has_error_class, "value" => get_array_value($row_data, "value")));
                }
            } else { //validate data
                if (!array_filter($value)) {
                    continue;
                }

                $error_message_on_this_row = "<ol class='pl15'>";

                foreach ($value as $key => $row_data) {
                    $has_error_class = false;

                    if (!$got_error_header) {
                        $row_data_validation = $this->_sea_valve_row_data_validation_and_get_error_message($key, $row_data);
                        if ($row_data_validation) {
                            $has_error_class = true;
                            $error_message_on_this_row .= "<li>" . $row_data_validation . "</li>";
                            $got_error_table_data = true;
                        }
                    }

                    if (count($headers) > $key) {
                        $table_data_body_array[$row_key][] = array("has_error_class" => $has_error_class, "value" => $row_data);
                    }
                }

                $error_message_on_this_row .= "</ol>";

                //error messages for this row
                if ($got_error_table_data) {
                    $table_data_body_array[$row_key][] = array("has_error_text" => true, "value" => $error_message_on_this_row);
                }
            }
        }

        //return false if any error found on submitting file
        if ($check_on_submit) {
            return ($got_error_header || $got_error_table_data) ? false : true;
        }

        //add error header if there is any error in table body
        if ($got_error_table_data) {
            array_push($table_data_header_array, array("has_error_text" => true, "value" => app_lang("error")));
        }

        //add headers to table
        $table_data .= "<tr>";
        foreach ($table_data_header_array as $table_data_header) {
            $error_class = get_array_value($table_data_header, "has_error_class") ? "error" : "";
            $error_text = get_array_value($table_data_header, "has_error_text") ? "text-danger" : "";
            $value = get_array_value($table_data_header, "value");
            $table_data .= "<th class='$error_class $error_text'>" . $value . "</th>";
        }
        $table_data .= "</tr>";

        //add body data to table
        foreach ($table_data_body_array as $table_data_body_row) {
            $table_data .= "<tr>";
            $error_text = "";

            foreach ($table_data_body_row as $table_data_body_row_data) {
                $error_class = get_array_value($table_data_body_row_data, "has_error_class") ? "error" : "";
                $error_text = get_array_value($table_data_body_row_data, "has_error_text") ? "text-danger" : "";
                $value = get_array_value($table_data_body_row_data, "value");
                $table_data .= "<td class='$error_class $error_text'>" . $value . "</td>";
            }

            if ($got_error_table_data && !$error_text) {
                $table_data .= "<td></td>";
            }

            $table_data .= "</tr>";
        }

        //add error message for header
        if ($error_message) {
            $total_columns = count($table_data_header_array);
            $table_data .= "<tr><td class='text-danger' colspan='$total_columns'><i data-feather='alert-triangle' class='icon-16'></i> " . $error_message . "</td></tr>";
        }

        $table_data .= "</table>";

        echo json_encode(array("success" => true, 'table_data' => $table_data, 'got_error' => ($got_error_header || $got_error_table_data) ? true : false));
    }

    function save_sea_valve()
    {
        // if (!$this->can_edit_clients()) {
        //     app_redirect("forbidden");
        // }
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required",
            "norm" => "required",
            "diameter_nominal" => "required",
            "pressure_rating" => "required",
            "length" => "required",
            "height" => "required",
            "diameter" => "required"
        ));

        $id = $this->request->getPost("id");

        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        $data = array(
            "name" => $this->request->getPost("name"),
            "description" => $this->request->getPost("description"),
            "norm" => $this->request->getPost("norm"),
            "diameter_nominal" => $this->request->getPost("diameter_nominal"),
            "pressure_rating" => $this->request->getPost("pressure_rating"),
            "length" => $this->request->getPost("length"),
            "height" => $this->request->getPost("height"),
            "diameter" => $this->request->getPost("diameter"),
        );
        $data["client_id"] = $client_id;

        $save_id = $this->Sea_valves_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_sea_valve_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_sea_valve()
    {
        // if (!$this->can_edit_clients()) {
        //     app_redirect("forbidden");
        // }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $this->access_only_allowed_members();

        $id = $this->request->getPost('id');

        $sea_valve_info = $this->Sea_valves_model->get_one($id);
        $this->can_access_own_client($sea_valve_info->client_id);

        if ($this->Sea_valves_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function sea_valves_list_data($client_id = 0)
    {
        validate_numeric_value($client_id);

        $options['client_id'] = $client_id;
        $list_data = $this->Sea_valves_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_sea_valve_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_sea_valve_data($id)
    {
        $data = $this->Sea_valves_model->get_one($id);
        return $this->_make_sea_valve_row($data);
    }

    private function _make_sea_valve_row($data)
    {
        $action = modal_anchor(get_uri("clients/sea_valve_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_sea_valve'), "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_sea_valve'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("clients/delete_sea_valve"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $data->description,
            $data->norm,
            $data->diameter_nominal,
            $data->pressure_rating,
            $data->length,
            $data->height,
            $data->diameter,
            $action
        );
    }

    //load the warehouses view
    function warehouses($client_id)
    {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = clean_data($client_id);
            return $this->template->view("clients/warehouses/index", $view_data);
        }
    }

    function warehouse_modal_form()
    {
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        $view_data["model_info"] = $this->Warehouses_model->get_one($this->request->getPost('id'));
        $client_id = $this->request->getPost('client_id') ? $this->request->getPost('client_id') : $view_data['model_info']->client_id;
        $this->can_access_own_client($client_id);

        $view_data['client_id'] = $client_id;

        return $this->template->view('clients/warehouses/modal_form', $view_data);
    }

    function save_warehouse()
    {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "code" => "required",
            "name" => "required",
        ));

        $id = $this->request->getPost("id");

        $client_id = $this->request->getPost('client_id');
        $this->can_access_own_client($client_id);

        $data = array(
            "code" => $this->request->getPost("code"),
            "name" => $this->request->getPost("name"),
            "location" => $this->request->getPost("location"),
        );
        $data["client_id"] = $client_id;

        $save_id = $this->Warehouses_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_warehouse_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_warehouse()
    {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        $warehouse_info = $this->Warehouses_model->get_one($id);
        $this->can_access_own_client($warehouse_info->client_id);

        if ($this->Warehouses_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function warehouses_list_data($client_id = 0)
    {
        validate_numeric_value($client_id);

        $options['client_id'] = $client_id;
        $list_data = $this->Warehouses_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_warehouse_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_warehouse_data($id)
    {
        $data = $this->Warehouses_model->get_one($id);
        return $this->_make_warehouse_row($data);
    }

    private function _make_warehouse_row($data)
    {
        $action = modal_anchor(get_uri("clients/warehouse_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_warehouse'), "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_warehouse'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("clients/delete_warehouse"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->code,
            $data->name,
            $data->location,
            $action
        );
    }
    private function _store_headers_position($headers_row = array())
    {
        $allowed_headers = $this->_get_allowed_headers();

        //check if all headers are correct and on the right position
        $final_headers = array();
        foreach ($headers_row as $key => $header) {
            if (!$header) {
                continue;
            }

            $key_value = str_replace(' ', '_', strtolower(trim($header, " ")));
            $header_on_this_position = get_array_value($allowed_headers, $key);
            $header_array = array("key_value" => $header_on_this_position, "value" => $header);

            if ($header_on_this_position == $key_value) {
                //allowed headers
                //the required headers should be on the correct positions
                //the rest headers will be treated as custom fields
                //pushed header at last of this loop
            } else if (((count($allowed_headers) - 1) < $key) && $key_value) {
                //custom fields headers
                //check if there is any existing custom field with this title
                $existing_id = $this->_get_existing_custom_field_id(trim($header, " "));
                if ($existing_id) {
                    $header_array["custom_field_id"] = $existing_id;
                } else {
                    $header_array["has_error"] = true;
                    $header_array["custom_field"] = true;
                }
            } else { //invalid header, flag as red
                $header_array["has_error"] = true;
            }

            if ($key_value) {
                array_push($final_headers, $header_array);
            }
        }

        return $final_headers;
    }
}

/* End of file clients.php */
/* Location: ./app/controllers/clients.php */