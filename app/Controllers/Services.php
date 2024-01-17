<?php

namespace App\Controllers;

use Exception;
use stdClass;

class Services extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    //load services list view
    function index() {
        $view_data["can_edit_items"] = $this->can_edit_items();
        $list_data = $this->Services_model->get_details()->getResult();
        $result = array();
        $service_dropdown = array();

        $service_dropdown[] = array("id" => "", "text" => "- Service type -");

        foreach ($list_data as $data) {
            $result[] = $this->_make_service_row($data);

            
            if ($data->service_type != '') {
                $temp = array(
                    'id'=> $data->service_type,
                    'text'=> $data->service_type,
                );
                if (!in_array($temp, $service_dropdown))
                    $service_dropdown[] = $temp;
            }
        }
        $view_data["services_items"] = json_encode($result);
        $view_data['country_dropdown'] = $this->get_country_table_dropdown(true);
        $view_data['service_dropdown'] = json_encode($service_dropdown);
        return $this->template->rander("services/index", $view_data);
    }

    //search services list view
    function search() {
        $search = $this->request->getPost("search");
        $options = array(
            "search" => $search,
            "country_id" => $this->request->getPost("country_id"),
            "service_type" => $this->request->getPost("service_type"),
        );
        $list_data = $this->Services_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_service_row($data);
        }
        return json_encode(array("data" => $result));
    }

    //prepare an service list row
    private function _make_service_row($data) {
        $company = $data->company;
        $action = "";

        $website = $data->website;
        if (strpos($website, "http") !== 0) {
            $website = "https://" . $website;
        }
        $link = anchor($website, "<i data-feather='external-link' class='icon-16'></i>", array("class" => "ml15", "target" => "_blank"));

        if ($this->can_edit_items()) {
            $company = anchor(get_uri('services/view/' . $data->id), $company);
            $action = modal_anchor(get_uri("services/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete"), "data-action" => "delete-confirmation"));
        }

        return array(
            "<div style='display: flex; justify-content: space-between; width: 100%; position: relative;'>
                <div style='display: flex; flex-direction: column; flex: 1 1 0%;'>
                    <div class='d-flex'>
                        <div class=''>
                            <a href='". get_uri('services/view/' . $data->id) . "'>
                                <div display='flex' class=''>
                                    <div class=''>
                                        <img src='" . get_avatar($data->image) . "' class='service-brand'>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div style='display: flex; flex-direction: column; align-items: flex-start;'>
                            <a href='". get_uri('services/view/' . $data->id) . "'>
                                <h3 style='margin: 0 20px'>" . $data->company . "</h3>
                            </a>
                            
                            <div style='margin-left: 20px'>
                                <svg viewBox='0 0 13 12' width='14' height='14' preserveAspectRatio='xMidYMid meet'>
                                <path fill-rule='evenodd' clip-rule='evenodd' d='M10.985 4.84c-.035-.115-.14-.195-.26-.205l-3.2-.275-1.25-2.96c-.095-.22-.46-.22-.555 0L4.47 4.36l-3.195.275c-.12.01-.225.09-.26.205-.035.115 0 .24.09.32L3.53 7.265l-.725 3.13c-.025.115.02.24.115.31s.23.075.33.015L6 9.06l2.75 1.66c.05.03.1.045.155.045.06 0 .125-.02.175-.055.1-.07.145-.195.115-.31L8.47 7.27l2.425-2.105c.095-.085.125-.21.09-.325z' fill='#ffc107'></path>
                                </svg>
                                <svg viewBox='0 0 13 12' width='14' height='14' preserveAspectRatio='xMidYMid meet'><path fill-rule='evenodd' clip-rule='evenodd' d='M10.985 4.84c-.035-.115-.14-.195-.26-.205l-3.2-.275-1.25-2.96c-.095-.22-.46-.22-.555 0L4.47 4.36l-3.195.275c-.12.01-.225.09-.26.205-.035.115 0 .24.09.32L3.53 7.265l-.725 3.13c-.025.115.02.24.115.31s.23.075.33.015L6 9.06l2.75 1.66c.05.03.1.045.155.045.06 0 .125-.02.175-.055.1-.07.145-.195.115-.31L8.47 7.27l2.425-2.105c.095-.085.125-.21.09-.325z' fill='#ffc107'></path>
                                </svg>
                                <svg viewBox='0 0 13 12' width='14' height='14' preserveAspectRatio='xMidYMid meet'><path fill-rule='evenodd' clip-rule='evenodd' d='M10.985 4.84c-.035-.115-.14-.195-.26-.205l-3.2-.275-1.25-2.96c-.095-.22-.46-.22-.555 0L4.47 4.36l-3.195.275c-.12.01-.225.09-.26.205-.035.115 0 .24.09.32L3.53 7.265l-.725 3.13c-.025.115.02.24.115.31s.23.075.33.015L6 9.06l2.75 1.66c.05.03.1.045.155.045.06 0 .125-.02.175-.055.1-.07.145-.195.115-.31L8.47 7.27l2.425-2.105c.095-.085.125-.21.09-.325z' fill='#ffc107'></path>
                                </svg>
                                <svg viewBox='0 0 13 12' width='14' height='14' preserveAspectRatio='xMidYMid meet'><path fill-rule='evenodd' clip-rule='evenodd' d='M10.985 4.84c-.035-.115-.14-.195-.26-.205l-3.2-.275-1.25-2.96c-.095-.22-.46-.22-.555 0L4.47 4.36l-3.195.275c-.12.01-.225.09-.26.205-.035.115 0 .24.09.32L3.53 7.265l-.725 3.13c-.025.115.02.24.115.31s.23.075.33.015L6 9.06l2.75 1.66c.05.03.1.045.155.045.06 0 .125-.02.175-.055.1-.07.145-.195.115-.31L8.47 7.27l2.425-2.105c.095-.085.125-.21.09-.325z' fill='#ffc107'></path>
                                </svg>
                                <svg viewBox='0 0 13 12' width='14' height='14' preserveAspectRatio='xMidYMid meet'><path fill-rule='evenodd' clip-rule='evenodd' d='M10.985 4.84c-.035-.115-.14-.195-.26-.205l-3.2-.275-1.25-2.96c-.095-.22-.46-.22-.555 0L4.47 4.36l-3.195.275c-.12.01-.225.09-.26.205-.035.115 0 .24.09.32L3.53 7.265l-.725 3.13c-.025.115.02.24.115.31s.23.075.33.015L6 9.06l2.75 1.66c.05.03.1.045.155.045.06 0 .125-.02.175-.055.1-.07.145-.195.115-.31L8.47 7.27l2.425-2.105c.095-.085.125-.21.09-.325z' fill='#ffc107'></path>
                                </svg>
                            </div>
                        </div>
                        
                    
                    </div>

                    <div style='display: flex; flex-direction: column; width: 100%;'>
                        <div height='auto' class='d-flex'>
                            <div class=''>
                                <p class=''>
                                    <div style='display: -webkit-box; overflow: hidden; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>" . $data->description . "</div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div width='100%' class=''>
                        <div class='d-flex align-items-center'>
                            <div>
                                <div class='d-flex align-items-center'>
                                    <div style='display: flex; margin-right: 0.5rem;'>
                                        <svg viewBox='0 0 24 24' width='1rem' height='1rem' preserveAspectRatio='xMidYMid meet'><rect width='24' height='24' fill='none' rx='0' ry='0'></rect><path fill-rule='evenodd' clip-rule='evenodd' d='M18.8 8.85C18.68 5.35 15.64 2.5 12.01 2.5C8.24995 2.5 5.19995 5.44 5.19995 9.05C5.19995 9.83 5.37995 10.7 5.72995 11.54L5.68995 11.56L10.77 20.78C11.01 21.22 11.48 21.5 12 21.5C12.52 21.5 12.99 21.22 13.23 20.78L17.81 12.46L17.83 12.47L18.32 11.54L18.28 11.52C18.64 10.66 18.82 9.7 18.8 8.85ZM14.2 9.3C14.2 10.51 13.21 11.5 12 11.5C10.79 11.5 9.79995 10.51 9.79995 9.3C9.79995 8.09 10.79 7.1 12 7.1C13.21 7.1 14.2 8.09 14.2 9.3Z' fill='#000000'></path></svg>
                                    </div>
                                    <div style='display: flex;'>
                                        <span class=''>" . $data->country . "</span>
                                    </div>
                                </div>
                            </div>
                            <div class='d-flex align-items-center'>
                                <div style='display: flex; margin-right: 0.5rem; margin-left: 1.5rem;'>
                                    <svg viewBox='0 0 16 16' width='1rem' height='1rem' preserveAspectRatio='xMidYMid meet'><path fill-rule='evenodd' d='M8 1c1.127 0 2.041.91 2.041 2.03 0 .792-.46 1.491-1.145 1.825l-.11.05-.084.031v1.4h.829c.335 0 .616.235.685.548l.013.074.004.076c0 .359-.275.656-.626.694l-.076.004h-.83v4.822l.16-.028c1.323-.266 2.437-1.133 3.026-2.312l.074-.156.048-.113-.892.227c-.17.043-.342-.059-.385-.228-.027-.105.002-.216.076-.295l2.445-2.608.194.444.197.457c.022.037.041.077.05.103l.006.02.942 2.159c.07.16-.003.347-.163.416-.097.043-.209.034-.298-.023l-.747-.48-.043.125c-.65 1.755-2.137 3.1-3.967 3.567l-.19.045-.065.012-.667.87c-.213.278-.61.33-.887.118-.044-.034-.084-.073-.117-.117l-.668-.87-.064-.013c-1.856-.405-3.385-1.707-4.09-3.436l-.07-.18-.044-.125-.743.477c-.147.094-.343.051-.438-.096-.056-.089-.065-.2-.023-.297l1.38-3.175 2.453 2.6c.12.127.114.327-.014.447-.078.074-.19.103-.295.076l-.894-.229.05.117c.542 1.207 1.623 2.117 2.91 2.432l.17.038.164.03h.016V7.733h-.83c-.334 0-.616-.236-.685-.549l-.012-.073-.004-.076c0-.36.274-.656.625-.694l.077-.004h.83v-1.4l-.086-.032c-.67-.278-1.15-.898-1.24-1.626l-.011-.13-.004-.118C5.958 1.91 6.873 1 8 1zm0 1.396c-.354 0-.638.283-.638.634 0 .352.284.635.638.635.353 0 .638-.283.638-.635 0-.351-.285-.634-.638-.634z' fill='#000000'></path></svg>
                                </div>
                                <div style='display: flex;'>
                                    <span class=''>" . $data->served_ports . " ports</span>
                                </div>
                            </div>

                            <div class='d-flex align-items-center'>
                                <div style='display: flex; margin-right: 0.5rem; margin-left: 1.5rem;'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='3'></circle><path d='M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z'></path></svg>
                                </div>
                                <span class=''>" . $data->service_type . "</span>
                            </div>
                        </div>
                    </div>
                
                
                </div>
                <div class='css-rv28wb'>
                    <div class='css-1wjjitw'><div style='padding-bottom: 2.25rem;'>
                        <a href='". get_uri('services/view/' . $data->id) . "'>
                            <button class='btn btn-light' tabindex='0' type='button'>View Supplier</button>
                        </a>
                    </div>
                    <div class='css-1ldukxh'>
                        <a href='". get_uri('services/view/' . $data->id) . "'>
                            <div class=''>
                                <div class=''>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>",
        $data->country_id,
    );
    }

    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        }
        return false;
    }

    //load services add/edit modal form
    function modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Services_model->get_one($this->request->getPost('id'));
        $view_data['country_dropdown'] = $this->get_country_dropdown();
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        return $this->template->view('services/modal_form', $view_data);
    }

    //save service
    function save() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "company" => "required",
            "service_type" => "required",
            "country_id" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "company" => $this->request->getPost('company'),
            "serviced_ports" => $this->request->getPost('serviced_ports'),
            "service_type" => $this->request->getPost('service_type'),
            "website" => $this->request->getPost('website'),
            "email" => $this->request->getPost('email'),
            "phone" => $this->request->getPost('phone'),
            "fax" => $this->request->getPost('fax'),
            "address" => $this->request->getPost('address'),
            "city" => $this->request->getPost('city'),
            "po_box" => $this->request->getPost('po_box'),
            "country_id" => $this->request->getPost('country_id'),
            "description" => $this->request->getPost('description')
        );
        $save_id = $this->Services_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //delete a service
    function delete() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->Services_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    //get data for services list
    function list_data() {
        $list_data = $this->Services_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an service row data
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Services_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    //prepare an service list row
    private function _make_row($data) {
        $company = $data->company;
        $action = "";

        $website = $data->website;
        if (strpos($website, "http") !== 0) {
            $website = "https://" . $website;
        }
        $link = anchor($website, "<i data-feather='external-link' class='icon-16'></i>", array("class" => "ml15", "target" => "_blank"));

        if ($this->can_edit_items()) {
            $company = anchor(get_uri('services/view/' . $data->id), $company);
            $action = modal_anchor(get_uri("services/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $company,
            $data->serviced_ports,
            $data->service_type,
            $link,
            $data->email,
            $data->phone,
            $data->fax,
            $data->country,
            $data->address,
            $data->city,
            $data->po_box,
            $action
        );
    }

    // Detail view page
    function view($id) {
        $model_info = $this->Services_model->get_one($id);
        if ($model_info -> id) {
            $view_data["model_info"] = $model_info;

            return $this->template->rander("services/view", $view_data);
        } else {
            show_404();
        }
    }

    // General Information tab
    function info_tab($id) {
        $view_data["model_info"] = $this->Services_model->get_one($id);
        $view_data["can_edit_items"] = $this->can_edit_items();
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        $view_data["country_dropdown"] = $this->get_country_dropdown();

        return $this->template->view("services/info/index", $view_data);
    }

    // Contacts tab
    function contacts_tab($id) {
        $view_data["service_id"] = $id;
        $view_data["can_edit_items"] = $this->can_edit_items();

        return $this->template->view("services/contacts/index", $view_data);
    }

    // ports served tab
    function ports($id) {
        $view_data["service_id"] = $id;
        $view_data["can_edit_items"] = $this->can_edit_items();

        return $this->template->view("services/ports/index", $view_data);
    }

    // get data for port list
    function ports_list_data($service_id) {
        $options = array(
            "service_id"=> $service_id
        );
        $list_data = $this->Service_ports_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_port_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _port_row_data($id) {
        $options = array(
            "id"=> $id
        );
        $list_data = $this->Service_ports_model->get_details($options)->getResult();
        return $this->_make_port_row($list_data[0]);
    }
    //prepare an service list row
    private function _make_port_row($data) {
        $company = $data->company;
        $action = "";

        if ($this->can_edit_items()) {
            $company = anchor(get_uri('services/view/' . $data->id), $company);
            $action = modal_anchor(get_uri("services/ports_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-service_id" => $data->service_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete_port"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $company,
            $data->city,
            $data->country,
            $action
        );
    }

    function contact_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $service_id = $this->request->getPost("service_id");
        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Service_contacts_model->get_one($id);
        $view_data["service_id"] = $service_id;
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";

        return $this->template->view("services/contacts/modal_form", $view_data);
    }

    function ports_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $service_id = $this->request->getPost("service_id");
        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Service_ports_model->get_one($id);
        $view_data["service_id"] = $service_id;
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        $view_data["countries_dropdown"] = $this->_get_countries_dropdown();
        return $this->template->view("services/ports/modal_form", $view_data);
    }

    private function _get_countries_dropdown() {
        $list = $this->Shipyards_model->get_countries();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    // save service contact
    function save_port() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "service_id" => "required",
            "city" => "required",
            "country_id" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "service_id" => $this->request->getPost('service_id'),
            "city" => $this->request->getPost('city'),
            "country_id" => $this->request->getPost('country_id')
        );
        $save_id = $this->Service_ports_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_port_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    // save service contact
    function save_contact() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "service_id" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "job_title" => "required",
            "email" => "required",
            "phone" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "service_id" => $this->request->getPost('service_id'),
            "first_name" => $this->request->getPost('first_name'),
            "last_name" => $this->request->getPost('last_name'),
            "job_title" => $this->request->getPost('job_title'),
            "email" => $this->request->getPost('email'),
            "phone" => $this->request->getPost('phone')
        );
        $save_id = $this->Service_contacts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_contact_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    // delete a service contact
    function delete_contact() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->Service_contacts_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    //get data for service contacts list
    function contact_list_data($service_id) {
        $list_data = $this->Service_contacts_model->get_all_where(array("deleted" => 0, "service_id" => $service_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_contact_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an contact row data
    private function _contact_row_data($id) {
        $data = $this->Service_contacts_model->get_one($id);
        return $this->_contact_make_row($data);
    }

    //prepare an contact list row
    private function _contact_make_row($data) {
        $action = "";

        if ($this->can_edit_items()) {
            $action = modal_anchor(get_uri("services/contact_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-service_id" => $data->service_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete_contact"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $data->first_name,
            $data->last_name,
            $data->job_title,
            $data->email,
            $data->phone,
            $action
        );
    }

    // Import data from excel
    function import_modal_form() {
        return $this->template->view("services/import_modal_form");
    }

    function upload_excel_file() {
        upload_file_to_temp(true);
    }

    function validate_import_file() {
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

    function download_sample_excel_file() {
        $file_name = "import-services-sample.xlsx";
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
    }

    private function _get_allowed_headers() {
        return array(
            ["key" => "company", "required" => true],
            ["key" => "serviced_ports", "required" => true],
            ["key" => "service_type", "required" => true],
            ["key" => "website", "required" => false],
            ["key" => "email", "required" => true],
            ["key" => "phone", "required" => false],
            ["key" => "fax", "required" => false],
            ["key" => "country", "required" => true],
            ["key" => "address", "required" => false],
            ["key" => "city", "required" => false],
            ["key" => "po_box", "required" => false],
            ["key" => "description", "required" => false]
        );
    }

    private function _store_item_headers_position($headers_row = array()) {
        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers());

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

    private function _row_data_validation_and_get_error_message($key, $data) {
        $allowed_headers = $this->_get_allowed_headers();
        $header = null;
        foreach ($allowed_headers as $el) {
            if ($el["key"] == $key) {
                $header = $el;
                break;
            }
        }

        if ($header && $header["required"]) {
            if (empty($data)) {
                $error_message = sprintf(app_lang("import_data_empty_message"), app_lang($header["key"]));
                return $error_message;
            }
        }
    }

    private function _prepare_item_data($data_row, $allowed_headers) {
        //prepare data
        $item_data = array();
        $country_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }
            $row_data_value = trim($row_data_value);
            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "country") {
                $country_data["name"] = $row_data_value;
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "item_data" => $item_data,
            "country_data" => $country_data
        );
    }

    function validate_import_file_data($check_on_submit = false) {
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
                $headers = $this->_store_item_headers_position($value);

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
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($key, $row_data);
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

    function save_from_excel_file() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        if (!$this->validate_import_file_data(true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
            exit;
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers());

        $services = $this->Services_model->get_all()->getResult();
        $countries = $this->Country_model->get_all()->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);

            $item_data = get_array_value($data_array, "item_data");
            $country_data = get_array_value($data_array, "country_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {

                // countries
                $country = $this->findCountry($country_data["name"], $countries);
                if ($country) {
                    $item_data["country_id"] = $country->id;
                } else {
                    continue;
                }

                $service = $this->findService($item_data["company"], $item_data["serviced_ports"], $services);
                if (!$service) {
                    $save_id = $this->Services_model->ci_save($item_data);

                    $temp = new stdClass();
                    $temp->id = $save_id;
                    $temp->company = $item_data["company"];
                    $temp->serviced_ports = $item_data["serviced_ports"];
                    $services[] = $temp;
                }
            } catch (Exception $e) {
                echo json_encode(array('success' => false, 'message' => $e->getMessage()));
                exit;
            }
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function findCountry($name, $arr) {
        $name = trim(strtolower($name));
        foreach ($arr as $item) {
            if ($name == strtolower($item->name) || $name == strtolower($item->id)) {
                return $item;
            }
        }
        return false;
    }

    private function findService($company, $serviced_ports, $arr) {
        $company = trim(strtolower($company));
        $serviced_ports = trim(strtolower($serviced_ports));
        foreach ($arr as $item) {
            if ($company == strtolower($item->company) && $serviced_ports == strtolower($item->serviced_ports)) {
                return $item;
            }
        }
        return false;
    }

    // 
    //save profile image of a contact
    function save_profile_image($service_id = 0)
    {

        $service_info = $this->Services_model->get_one($service_id);
        
        //process the the file which has uploaded by dropzone
        $profile_image = str_replace("~", ":", $this->request->getPost("profile_image"));

        if ($profile_image) {
            $profile_image = serialize(move_temp_file("avatar.png", get_setting("profile_image_path"), "", $profile_image));

            //delete old file
            delete_app_files(get_setting("profile_image_path"), array(@unserialize($service_info->image)));

            $image_data = array("image" => $profile_image);
            $this->Services_model->ci_save($image_data, $service_id);
            echo json_encode(array("success" => true, 'message' => app_lang('service_image_changed')));
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
                delete_app_files(get_setting("profile_image_path"), array(@unserialize($service_info->image)));

                $image_data = array("image" => $profile_image);
                $this->Services_model->ci_save($image_data, $service_id);
                echo json_encode(array("success" => true, 'message' => app_lang('profile_image_changed'), "reload_page" => true));
            }
        }
    }
}

/* End of file Services.php */
/* Location: ./app/controllers/Services.php */