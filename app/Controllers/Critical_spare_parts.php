<?php

namespace App\Controllers;

class Critical_spare_parts extends Security_Controller {

    function __construct() {
        parent::__construct();

        // check permission
        $this->init_permission_checker("critical_spare_parts");
    }

    //load note list view
    function index() {
        $this->access_only_allowed_members();
        return $this->template->rander("critical_spare_parts/index");
    }

    //for team members, check only read_only permission here, since other permission will be checked accordingly
    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    function items_tab() {
        $this->access_only_allowed_members();
        $view_data["can_edit_items"] = $this->can_edit_items();
        return $this->template->view("critical_spare_parts/items/index", $view_data);
    }

    function items_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $view_data['model_info'] = $this->Critical_spare_parts_model->get_one($this->request->getPost('id'));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["manufacturers_dropdown"] = $this->get_manufacturers_dropdown();
        $view_data["applicable_equipments_dropdown"] = $this->get_applicable_machinery_equipments_dropdown();
        $view_data["ship_equipments_dropdown"] = $this->get_ship_machinery_equipments_dropdown();
        $view_data["units_dropdown"] = $this->get_units_dropdown();

        return $this->template->view('critical_spare_parts/items/modal_form', $view_data);
    }

    function save_item() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[40]",
            "manufacturer_id" => "required|numeric",
            "applicable_equip_id" => "required|numeric",
            "ship_equip_id" => "required|numeric",
            "unit_code" => "required",
            "part_number" => "required|max_length[30]",
            "part_description" => "required",
            "article_number" => "required|max_length[30]",
            "drawing_number" => "required|max_length[30]",
            "hs_code" => "required|max_length[10]"
        ));

        $id = $this->request->getPost('id');

        $data = array(
            "name" => $this->request->getPost('name'),
            "manufacturer_id" => $this->request->getPost('manufacturer_id'),
            "applicable_equip_id" => $this->request->getPost('applicable_equip_id'),
            "ship_equip_id" => $this->request->getPost('ship_equip_id'),
            "unit_code" => $this->request->getPost('unit_code'),
            "part_number" => $this->request->getPost('part_number'),
            "part_description" => $this->request->getPost('part_description'),
            "article_number" => $this->request->getPost('article_number'),
            "drawing_number" => $this->request->getPost('drawing_number'),
            "hs_code" => $this->request->getPost('hs_code')
        );

        $data = clean_data($data);

        $save_id = $this->Critical_spare_parts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_items_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_item() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Critical_spare_parts_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function items_list_data() {
        $this->access_only_allowed_members();

        $list_data = $this->Critical_spare_parts_model->get_details(array())->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_items_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _items_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Critical_spare_parts_model->get_details($options)->getRow();
        return $this->_items_make_row($data);
    }

    private function _items_make_row($data) {
        $actions = "";
        if ($this->can_edit_items()) {
            $actions = modal_anchor(get_uri("critical_spare_parts/items_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("critical_spare_parts/delete_item"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $data->name,
            $data->manufacturer,
            $data->applicable_equip,
            $data->ship_equip,
            $data->unit,
            $data->part_number,
            $data->hs_code,
            $actions
        );
    }

    function warehouses_tab() {
        $this->access_only_allowed_members();
        $view_data["vessels_dropdown"] = $this->get_vessels_dropdown(true);
        return $this->template->view("critical_spare_parts/warehouses", $view_data);
    }

    function warehouses_list_data() {
        $options = array("client_id" => $this->request->getPost("client_id"));
        $list_data = $this->Warehouse_spare_model->get_warehouses($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_warehouses_make_row($data);
        }

        echo json_encode(array("data" => $result));
    }

    private function _warehouses_make_row($data) {
        $icon = "";
        $min_stock_items = $data->min_stock_items;
        if ($min_stock_items > 0) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $min_stock_items = '<span style="color: #d50000">' . $min_stock_items . '</span>';
        }
        return array(
            $data->id,
            $icon,
            $data->code,
            anchor(get_uri("critical_spare_parts/view/" . $data->id), $data->name),
            anchor(get_uri("clients/view/" . $data->client_id), $data->vessel),
            $data->total_items,
            $data->total_quantities,
            $min_stock_items
        );
    }

    function view($warehouse_id = 0) {
        $this->access_only_allowed_members();
        if ($warehouse_id) {
            $view_data["model_info"] = $this->Warehouse_spare_model->get_warehouses(array("warehouse_id" => $warehouse_id))->getRow();
            $view_data["warehouse_id"] = $warehouse_id;
            $view_data["can_edit_items"] = $this->can_edit_items();

            return $this->template->rander("critical_spare_parts/view", $view_data);
        } else {
            show_404();
        }
    }

    function ws_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
        ));

        $view_data['model_info'] = $this->Warehouse_spare_model->get_one($this->request->getPost('id'));
        $view_data["warehouse_id"] = $this->request->getPost("warehouse_id");
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["items_dropdown"] = $this->critical_spare_parts_dropdown();
        $view_data["spare_parts"] = $this->Critical_spare_parts_model->get_details()->getResult();

        return $this->template->view("critical_spare_parts/ws_modal_form", $view_data);
    }

    function save_ws() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "warehouse_id" => "required|numeric",
            "spare_id" => "required|numeric",
            "quantity" => "required|numeric",
            "min_stocks" => "required|numeric",
            "max_stocks" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "warehouse_id" => $this->request->getPost("warehouse_id"),
            "spare_id" => $this->request->getPost("spare_id"),
            "quantity" => $this->request->getPost("quantity"),
            "min_stocks" => $this->request->getPost("min_stocks"),
            "max_stocks" => $this->request->getPost("max_stocks"),
        );

        if ($data["quantity"] > $data["max_stocks"]) {
            echo json_encode(array("success" => false, 'message' => app_lang("quantity_exceeds_max_stocks")));
            exit();
        }
        if ($data["min_stocks"] > $data["max_stocks"]) {
            echo json_encode(array("success" => false, 'message' => app_lang("min_stocks_should_less_than_max_stocks")));
            exit();
        }
        if ($this->Warehouse_spare_model->is_duplicate_spare_part($data["spare_id"], $data["warehouse_id"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_item")));
            exit();
        }

        $save_id = $this->Warehouse_spare_model->ci_save($data, $id);
        if ($save_id) {
            if ($data["quantity"] <= $data["min_stocks"]) {
                // TODO: notification, add todo (private)
                $warehouse_info = $this->Warehouses_model->get_one($data["warehouse_id"]);
                $notification_option = array("client_id" => $warehouse_info->client_id, "warehouse_id" => $data["warehouse_id"], "warehouse_spare_id" => $save_id);
                log_notification("csp_minimum_reached", $notification_option, "0");
                
                echo json_encode(array("success" => true, "min_stock_reached" => true, "data" => $this->_ws_row_data($save_id), 'id' => $save_id, 'message' => app_lang('minimum_item_reached')));
            } else {
                echo json_encode(array("success" => true, "min_stock_reached" => false, "data" => $this->_ws_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_ws() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Warehouse_spare_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function ws_list_data($warehouse_id) {
        $list_data = $this->Warehouse_spare_model->get_details(array("warehouse_id" => $warehouse_id))->getResult();
        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_ws_make_row($data);
        }

        echo json_encode(array("data" => $result));
    }

    private function _ws_row_data($id) {
        $data = $this->Warehouse_spare_model->get_details(array("id" => $id))->getRow();
        return $this->_ws_make_row($data);
    }

    private function _ws_make_row($data) {
        $actions = "";
        if ($this->can_edit_items()) {
            $actions = modal_anchor(get_uri("critical_spare_parts/ws_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-warehouse_id" => $data->warehouse_id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("critical_spare_parts/delete_ws"), "data-action" => "delete-confirmation"));
        }

        $icon = "";
        $quantity = $data->quantity;
        if ($data->quantity <= $data->min_stocks) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $quantity = '<span style="color: #d50000">' . $quantity . '</span>';
        }

        return array(
            $data->id,
            $icon,
            $data->name,
            $quantity,
            $data->min_stocks,
            $data->max_stocks,
            $data->manufacturer,
            $data->applicable_equip,
            $data->ship_equip,
            $data->unit,
            $data->part_number,
            $data->article_number,
            $data->drawing_number,
            $data->hs_code,
            $actions
        );
    }
}

/* End of file notes.php */
/* Location: ./app/controllers/notes.php */