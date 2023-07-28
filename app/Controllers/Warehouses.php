<?php

namespace App\Controllers;

use stdClass;
use Exception;

class Warehouses extends Security_Controller {

    function __construct() {
        parent::__construct();
        // $this->access_only_allowed_members();
    }

    //load note list view
    function index() {
        return $this->template->rander("warehouses/index");
    }

    function list_data() {
        $list_data = $this->Warehouses_model->get_vessels();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }

        echo json_encode(array("data" => $result));
    }

    private function _make_row($data) {
        $icon = "";
        $total = $data->spare_min + $data->chemical_min + $data->oil_min + $data->paint_min;
        if ($total > 0) {
            $icon = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $total . '</span>';
        }
        $vessel = $data->vessel;
        if ($this->can_access_own_client($data->client_id)) {
            $vessel = anchor(get_uri("warehouses/main_view/" . $data->client_id), $data->vessel);
        }

        $spare_min = "---";
        if ($data->spare_min > 0) {
            $spare_min = '<span style="color: #d50000">' . $data->spare_min . '</span>';
        }

        $chemical_min = "---";
        if ($data->chemical_min > 0) {
            $chemical_min = '<span style="color: #d50000">' . $data->chemical_min . '</span>';
        }

        $oil_min = "---";
        if ($data->oil_min > 0) {
            $oil_min = '<span style="color: #d50000">' . $data->oil_min . '</span>';
        }

        $paint_min = "---";
        if ($data->paint_min > 0) {
            $paint_min = '<span style="color: #d50000">' . $data->paint_min . '</span>';
        }

        return array(
            $icon,
            $vessel,
            $spare_min . " / " . ($data->spare_total > 0 ? $data->spare_total : "---"),
            $chemical_min . " / " . ($data->chemical_total > 0 ? $data->chemical_total : "---"),
            $oil_min . " / " . ($data->oil_total > 0 ? $data->oil_total : "---"),
            $paint_min . " / " . ($data->paint_total > 0 ? $data->paint_total : "---"),
        );
    }

    function main_view($client_id = 0) {
        $vessel = $this->Clients_model->get_one($client_id);
        if ($vessel->id) {
            $view_data["vessel"] = $vessel;
            return $this->template->rander("warehouses/main_view", $view_data);
        } else {
            show_404();
        }
    }

    function main_list_data($client_id) {
        $list_data = $this->Warehouses_model->get_warehouses($client_id);
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_main_make_row($data);
        }

        echo json_encode(array("data" => $result));
    }

    private function _main_make_row($data) {
        $icon = "";
        $total = $data->spare_min + $data->chemical_min + $data->oil_min + $data->paint_min;
        if ($total > 0) {
            $icon = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $total . '</span>';
        }
        $name = $data->name;
        if ($this->can_access_own_client($data->client_id)) {
            $name = anchor(get_uri("warehouses/view/" . $data->client_id . "/" . $data->id), $name);
        }

        $spare_min = "---";
        if ($data->spare_min > 0) {
            $spare_min = '<span style="color: #d50000">' . $data->spare_min . '</span>';
        }

        $chemical_min = "---";
        if ($data->chemical_min > 0) {
            $chemical_min = '<span style="color: #d50000">' . $data->chemical_min . '</span>';
        }

        $oil_min = "---";
        if ($data->oil_min > 0) {
            $oil_min = '<span style="color: #d50000">' . $data->oil_min . '</span>';
        }

        $paint_min = "---";
        if ($data->paint_min > 0) {
            $paint_min = '<span style="color: #d50000">' . $data->paint_min . '</span>';
        }

        return array(
            $data->id,
            $icon,
            $data->code,
            $name,
            $spare_min . " / " . ($data->spare_total > 0 ? $data->spare_total : "---"),
            $chemical_min . " / " . ($data->chemical_total > 0 ? $data->chemical_total : "---"),
            $oil_min . " / " . ($data->oil_total > 0 ? $data->oil_total : "---"),
            $paint_min . " / " . ($data->paint_total > 0 ? $data->paint_total : "---"),
        );
    }

    function view($client_id, $warehouse_id = 0) {
        if ($warehouse_id) {
            $view_data["model_info"] = $this->Warehouses_model->get_one($warehouse_id);
            $view_data["client_id"] = $client_id;
            $view_data["warehouse_id"] = $warehouse_id;

            $minstock_items = $this->Warehouses_model->get_minstock_reached_items($warehouse_id);
            if ($minstock_items->spares > 0) {
                $warn_spares = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $minstock_items->spares . '</span>';
            } else {
                $warn_spares = "";
            }
            if ($minstock_items->chemicals > 0) {
                $warn_chemicals = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $minstock_items->chemicals . '</span>';
            } else {
                $warn_chemicals = "";
            }
            if ($minstock_items->oils > 0) {
                $warn_oils = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $minstock_items->oils . '</span>';
            } else {
                $warn_oils = "";
            }
            if ($minstock_items->paints > 0) {
                $warn_paints = '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $minstock_items->paints . '</span>';
            } else {
                $warn_paints = "";
            }
            $view_data["warns"] = array(
                "spares" => $warn_spares,
                "chemicals" => $warn_chemicals,
                "oils" => $warn_oils,
                "paints" => $warn_paints
            );

            return $this->template->rander("warehouses/view", $view_data);
        } else {
            show_404();
        }
    }


    // Spare parts tab
    function spares_tab($client_id, $warehouse_id) {
        $view_data["can_edit_items"] = $this->can_access_own_client($client_id);
        $view_data["warehouse_id"] = $warehouse_id;
        $view_data["client_id"] = $client_id;
        return $this->template->view("warehouses/spares/index", $view_data);
    }

    function spares_modal_form() {
        $client_id = $this->request->getPost("client_id");
        $warehouse_id = $this->request->getPost("warehouse_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($warehouse_id) {
            $this->validate_submitted_data(array(
                "id" => "numeric",
            ));
            $id = $this->request->getPost('id');
            $view_data['model_info'] = $this->Warehouse_spares_model->get_one($id);
            $view_data["warehouse_id"] = $warehouse_id;
            $view_data["client_id"] = $client_id;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            if ($id) {
                $view_data["items_dropdown"] = $this->get_spare_parts_dropdown();
            } else {
                $view_data["items_dropdown"] = $this->Warehouse_spares_model->get_items_dropdown($warehouse_id);
            }

            $spare_parts = $this->Spare_parts_model->get_details()->getResult();
            $manufacturers = $this->Manufacturers_model->get_all()->getResult();
            $applicable_equipments = $this->Applicable_equipments_model->get_all()->getResult();
            $ship_equipments = $this->Ship_equipments_model->get_all()->getResult();
            $spare_parts = array_map(function ($item) use ($manufacturers, $applicable_equipments, $ship_equipments) {
                $manufacturer = $this->_get_names_by_ids($item->manufacturer_id, $manufacturers);
                $item->manufacturer = $manufacturer;
                $applicable_equip = $this->_get_names_by_ids($item->applicable_equip_id, $applicable_equipments);
                $item->applicable_equip = $applicable_equip;
                $ship_equip = $this->_get_names_by_ids($item->ship_equip_id, $ship_equipments);
                $item->ship_equip = $ship_equip;
                return $item;
            }, $spare_parts);
            $view_data["spare_parts"] = $spare_parts;

            return $this->template->view("warehouses/spares/modal_form", $view_data);
        } else {
            show_404();
        }
    }

    function save_spare() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "warehouse_id" => "required|numeric",
            "spare_id" => "required|numeric",
            "quantity" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "warehouse_id" => $this->request->getPost("warehouse_id"),
            "spare_id" => $this->request->getPost("spare_id"),
            "quantity" => $this->request->getPost("quantity"),
            "min_stocks" => $this->request->getPost("min_stocks"),
            "max_stocks" => $this->request->getPost("max_stocks"),
        );

        if ($data["max_stocks"] > 0 && $data["quantity"] > $data["max_stocks"]) {
            echo json_encode(array("success" => false, 'message' => app_lang("quantity_exceeds_max_stocks")));
            exit();
        }
        if ($data["min_stocks"] > 0 && $data["max_stocks"] > 0 && $data["min_stocks"] > $data["max_stocks"]) {
            echo json_encode(array("success" => false, 'message' => app_lang("min_stocks_should_less_than_max_stocks")));
            exit();
        }
        if ($this->Warehouse_spares_model->is_duplicate_item($data["spare_id"], $data["warehouse_id"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_item")));
            exit();
        }

        $save_id = $this->Warehouse_spares_model->ci_save($data, $id);
        if ($save_id) {
            if ($data["min_stocks"] > 0 && $data["quantity"] <= $data["min_stocks"]) {
                // TODO: notification, add todo (private)
                $notification_option = array("client_id" => $client_id, "warehouse_id" => $data["warehouse_id"], "warehouse_item_id" => $save_id, "warehouse_tab" => "spares");
                log_notification("warehouse_item_minimum_reached", $notification_option, "0");

                $client = $this->Clients_model->get_one($client_id);
                $info = $this->Warehouse_spares_model->get_infomation($save_id);
                $url = get_uri("warehouses/view/" . $client_id . "/" . $data["warehouse_id"]);
                $description = "<strong>" . $info->name . "</strong> (" . $info->quantity . " / " . $info->min_stocks . ", " . app_lang("spare_parts") . ") on <strong>" . $info->warehouse . "</strong> (warehouse) has been reached minimum of stocks.<br/>";
                $description .= '<a href="' . $url . '" target="_blank">' . $url . '</a>';
                $todo_data = array(
                    "client_id" => $client_id,
                    "title" => app_lang("spare_parts") . " - " . app_lang("minimum_item_reached"),
                    "description" => $description,
                    "created_by" => $client->owner_id,
                    "created_at" => get_current_utc_time(),
                    "start_date" => get_current_utc_time("Y-m-d")
                );
                $this->Todo_model->ci_save($todo_data, null);

                $primary_contact_id = $this->Clients_model->get_primary_contact($client_id);
                $todo_data["created_by"] = $primary_contact_id;
                $this->Todo_model->ci_save($todo_data, null);

                echo json_encode(array("success" => true, "min_stock_reached" => true, "data" => $this->_spare_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('minimum_item_reached')));
            } else {
                echo json_encode(array("success" => true, "min_stock_reached" => false, "data" => $this->_spare_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_spare() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Warehouse_spares_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function spares_list_data($client_id, $warehouse_id) {
        $list_data = $this->Warehouse_spares_model->get_details(array("warehouse_id" => $warehouse_id))->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $applicable_equipments = $this->Applicable_equipments_model->get_all()->getResult();
        $ship_equipments = $this->Ship_equipments_model->get_all()->getResult();
        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_spare_make_row($client_id, $data, $manufacturers, $applicable_equipments, $ship_equipments);
        }

        echo json_encode(array("data" => $result));
    }

    private function _spare_row_data($client_id, $id) {
        $data = $this->Warehouse_spares_model->get_details(array("id" => $id))->getRow();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $applicable_equipments = $this->Applicable_equipments_model->get_all()->getResult();
        $ship_equipments = $this->Ship_equipments_model->get_all()->getResult();
        return $this->_spare_make_row($client_id, $data, $manufacturers, $applicable_equipments, $ship_equipments);
    }

    private function _spare_make_row($client_id, $data, $manufacturers, $applicable_equipments, $ship_equipments) {
        $actions = "";
        if ($this->can_access_own_client($client_id)) {
            $actions = modal_anchor(get_uri("warehouses/spares_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-client_id" => $client_id, "data-post-warehouse_id" => $data->warehouse_id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("warehouses/delete_spare"), "data-action" => "delete-confirmation"));
        }

        $icon = "";
        $quantity = $data->quantity;
        if ($data->quantity <= $data->min_stocks) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $quantity = '<span style="color: #d50000">' . $quantity . '</span>';
        }

        $checkbox_class = "checkbox-blank";
        if ($data->is_critical) {
            $checkbox_class = "checkbox-checked";
        }
        $check_critical = "<span class='$checkbox_class mr15 float-start'></span>";

        $manufacturer = $this->_get_names_by_ids($data->manufacturer_id, $manufacturers);
        $applicable_equip = $this->_get_names_by_ids($data->applicable_equip_id, $applicable_equipments);
        $ship_equip = $this->_get_names_by_ids($data->ship_equip_id, $ship_equipments);

        return array(
            $data->id,
            $icon,
            $data->is_critical,
            $check_critical,
            $data->name,
            $manufacturer,
            $applicable_equip,
            $ship_equip,
            $quantity,
            $data->unit,
            $data->min_stocks > 0 ? $data->min_stocks : "---",
            $data->max_stocks > 0 ? $data->max_stocks : "---",
            $data->part_number,
            $data->article_number,
            $data->drawing_number,
            $data->hs_code,
            $actions
        );
    }


    // Chemicals parts tab
    function chemicals_tab($client_id, $warehouse_id) {
        $view_data["can_edit_items"] = $this->can_access_own_client($client_id);
        $view_data["warehouse_id"] = $warehouse_id;
        $view_data["client_id"] = $client_id;
        return $this->template->view("warehouses/chemicals/index", $view_data);
    }

    function chemicals_modal_form() {
        $client_id = $this->request->getPost("client_id");
        $warehouse_id = $this->request->getPost("warehouse_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($warehouse_id) {
            $id = $this->request->getPost('id');
            $view_data['model_info'] = $this->Warehouse_chemicals_model->get_one($id);
            $view_data["warehouse_id"] = $warehouse_id;
            $view_data["client_id"] = $client_id;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            if ($id) {
                $view_data["items_dropdown"] = $this->get_chemicals_dropdown();
            } else {
                $view_data["items_dropdown"] = $this->Warehouse_chemicals_model->get_items_dropdown($warehouse_id);
            }
            $chemicals = $this->Chemicals_model->get_details()->getResult();
            $manufacturers = $this->Manufacturers_model->get_all()->getResult();
            $chemicals = array_map(function ($item) use ($manufacturers) {
                $manufacturer = $this->_get_names_by_ids($item->manufacturer_id, $manufacturers);
                $item->manufacturer = $manufacturer;
                return $item;
            }, $chemicals);
            $view_data["chemicals"] = $chemicals;

            return $this->template->view("warehouses/chemicals/modal_form", $view_data);
        } else {
            show_404();
        }
    }

    function save_chemical() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "warehouse_id" => "required|numeric",
            "chemical_id" => "required|numeric",
            "quantity" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "warehouse_id" => $this->request->getPost("warehouse_id"),
            "chemical_id" => $this->request->getPost("chemical_id"),
            "quantity" => $this->request->getPost("quantity"),
            "min_stocks" => $this->request->getPost("min_stocks")
        );

        if ($this->Warehouse_chemicals_model->is_duplicate_item($data["chemical_id"], $data["warehouse_id"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_item")));
            exit();
        }

        $save_id = $this->Warehouse_chemicals_model->ci_save($data, $id);
        if ($save_id) {
            if ($data["min_stocks"] > 0 && $data["quantity"] <= $data["min_stocks"]) {
                // TODO: notification, add todo (private)
                $notification_option = array("client_id" => $client_id, "warehouse_id" => $data["warehouse_id"], "warehouse_item_id" => $save_id, "warehouse_tab" => "chemicals");
                log_notification("warehouse_item_minimum_reached", $notification_option, "0");

                $client = $this->Clients_model->get_one($client_id);
                $info = $this->Warehouse_chemicals_model->get_infomation($save_id);
                $url = get_uri("warehouses/view/" . $client_id . "/" . $data["warehouse_id"]);
                $description = "<strong>" . $info->name . "</strong> (" . $info->quantity . " / " . $info->min_stocks . ", " . app_lang("chemicals") . ") on <strong>" . $info->warehouse . "</strong> (warehouse) has been reached minimum of stocks.<br/>";
                $description .= '<a href="' . $url . '" target="_blank">' . $url . '</a>';
                $todo_data = array(
                    "client_id" => $client_id,
                    "title" => app_lang("chemicals") . " - " . app_lang("minimum_item_reached"),
                    "description" => $description,
                    "created_by" => $client->owner_id,
                    "created_at" => get_current_utc_time(),
                    "start_date" => get_current_utc_time("Y-m-d")
                );
                $this->Todo_model->ci_save($todo_data, null);

                $primary_contact_id = $this->Clients_model->get_primary_contact($client_id);
                $todo_data["created_by"] = $primary_contact_id;
                $this->Todo_model->ci_save($todo_data, null);

                echo json_encode(array("success" => true, "min_stock_reached" => true, "data" => $this->_chemical_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('minimum_item_reached')));
            } else {
                echo json_encode(array("success" => true, "min_stock_reached" => false, "data" => $this->_chemical_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_chemical() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Warehouse_chemicals_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function chemicals_list_data($client_id, $warehouse_id) {
        $list_data = $this->Warehouse_chemicals_model->get_details(array("warehouse_id" => $warehouse_id))->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_chemical_make_row($client_id, $data, $manufacturers);
        }

        echo json_encode(array("data" => $result));
    }

    private function _chemical_row_data($client_id, $id) {
        $data = $this->Warehouse_chemicals_model->get_details(array("id" => $id))->getRow();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        return $this->_chemical_make_row($client_id, $data, $manufacturers);
    }

    private function _chemical_make_row($client_id, $data, $manufacturers) {
        $actions = "";
        if ($this->can_access_own_client($client_id)) {
            $actions = modal_anchor(get_uri("warehouses/chemicals_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-client_id" => $client_id, "data-post-warehouse_id" => $data->warehouse_id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("warehouses/delete_chemical"), "data-action" => "delete-confirmation"));
        }

        $icon = "";
        $quantity = $data->quantity;
        if ($data->quantity <= $data->min_stocks) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $quantity = '<span style="color: #d50000">' . $quantity . '</span>';
        }

        $checkbox_class = "checkbox-blank";
        if ($data->is_critical) {
            $checkbox_class = "checkbox-checked";
        }
        $check_critical = "<span class='$checkbox_class mr15 float-start'></span>";
        $manufacturer = $this->_get_names_by_ids($data->manufacturer_id, $manufacturers);

        return array(
            $data->id,
            $icon,
            $data->is_critical,
            $check_critical,
            $data->name,
            $manufacturer,
            $quantity,
            $data->unit,
            $data->min_stocks > 0 ? $data->min_stocks : "---",
            $data->part_number,
            $data->article_number,
            $data->hs_code,
            $actions
        );
    }



    // Oils parts tab
    function oils_tab($client_id, $warehouse_id) {
        $view_data["can_edit_items"] = $this->can_access_own_client($client_id);
        $view_data["warehouse_id"] = $warehouse_id;
        $view_data["client_id"] = $client_id;
        return $this->template->view("warehouses/oils/index", $view_data);
    }

    function oils_modal_form() {
        $client_id = $this->request->getPost("client_id");
        $warehouse_id = $this->request->getPost("warehouse_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($warehouse_id) {
            $id = $this->request->getPost('id');
            $view_data['model_info'] = $this->Warehouse_oils_model->get_one($id);
            $view_data["warehouse_id"] = $warehouse_id;
            $view_data["client_id"] = $client_id;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            if ($id) {
                $view_data["items_dropdown"] = $this->get_oils_dropdown();
            } else {
                $view_data["items_dropdown"] = $this->Warehouse_oils_model->get_items_dropdown($warehouse_id);
            }
            $oils = $this->Oils_model->get_details()->getResult();
            $manufacturers = $this->Manufacturers_model->get_all()->getResult();
            $oils = array_map(function ($item) use ($manufacturers) {
                $manufacturer = $this->_get_names_by_ids($item->manufacturer_id, $manufacturers);
                $item->manufacturer = $manufacturer;
                return $item;
            }, $oils);
            $view_data["oils"] = $oils;

            return $this->template->view("warehouses/oils/modal_form", $view_data);
        } else {
            show_404();
        }
    }

    function save_oil() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "warehouse_id" => "required|numeric",
            "oil_id" => "required|numeric",
            "quantity" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "warehouse_id" => $this->request->getPost("warehouse_id"),
            "oil_id" => $this->request->getPost("oil_id"),
            "quantity" => $this->request->getPost("quantity"),
            "min_stocks" => $this->request->getPost("min_stocks")
        );

        if ($this->Warehouse_oils_model->is_duplicate_item($data["oil_id"], $data["warehouse_id"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_item")));
            exit();
        }

        $save_id = $this->Warehouse_oils_model->ci_save($data, $id);
        if ($save_id) {
            if ($data["min_stocks"] > 0 && $data["quantity"] <= $data["min_stocks"]) {
                // TODO: notification, add todo (private)
                $notification_option = array("client_id" => $client_id, "warehouse_id" => $data["warehouse_id"], "warehouse_item_id" => $save_id, "warehouse_tab" => "oils");
                log_notification("warehouse_item_minimum_reached", $notification_option, "0");

                $client = $this->Clients_model->get_one($client_id);
                $info = $this->Warehouse_oils_model->get_infomation($save_id);
                $url = get_uri("warehouses/view/" . $client_id . "/" . $data["warehouse_id"]);
                $description = "<strong>" . $info->name . "</strong> (" . $info->quantity . " / " . $info->min_stocks . ", " . app_lang("oils_greases") . ") on <strong>" . $info->warehouse . "</strong> (warehouse) has been reached minimum of stocks.<br/>";
                $description .= '<a href="' . $url . '" target="_blank">' . $url . '</a>';
                $todo_data = array(
                    "client_id" => $client_id,
                    "title" => app_lang("oils_greases") . " - " . app_lang("minimum_item_reached"),
                    "description" => $description,
                    "created_by" => $client->owner_id,
                    "created_at" => get_current_utc_time(),
                    "start_date" => get_current_utc_time("Y-m-d")
                );
                $this->Todo_model->ci_save($todo_data, null);

                $primary_contact_id = $this->Clients_model->get_primary_contact($client_id);
                $todo_data["created_by"] = $primary_contact_id;
                $this->Todo_model->ci_save($todo_data, null);

                echo json_encode(array("success" => true, "min_stock_reached" => true, "data" => $this->_oil_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('minimum_item_reached')));
            } else {
                echo json_encode(array("success" => true, "min_stock_reached" => false, "data" => $this->_oil_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_oil() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Warehouse_oils_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function oils_list_data($client_id, $warehouse_id) {
        $list_data = $this->Warehouse_oils_model->get_details(array("warehouse_id" => $warehouse_id))->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_oil_make_row($client_id, $data, $manufacturers);
        }

        echo json_encode(array("data" => $result));
    }

    private function _oil_row_data($client_id, $id) {
        $data = $this->Warehouse_oils_model->get_details(array("id" => $id))->getRow();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        return $this->_oil_make_row($client_id, $data, $manufacturers);
    }

    private function _oil_make_row($client_id, $data, $manufacturers) {
        $actions = "";
        if ($this->can_access_own_client($client_id)) {
            $actions = modal_anchor(get_uri("warehouses/oils_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-client_id" => $client_id, "data-post-warehouse_id" => $data->warehouse_id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("warehouses/delete_oil"), "data-action" => "delete-confirmation"));
        }

        $icon = "";
        $quantity = $data->quantity;
        if ($data->quantity <= $data->min_stocks) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $quantity = '<span style="color: #d50000">' . $quantity . '</span>';
        }

        $checkbox_class = "checkbox-blank";
        if ($data->is_critical) {
            $checkbox_class = "checkbox-checked";
        }
        $check_critical = "<span class='$checkbox_class mr15 float-start'></span>";
        $manufacturer = $this->_get_names_by_ids($data->manufacturer_id, $manufacturers);

        return array(
            $data->id,
            $icon,
            $data->is_critical,
            $check_critical,
            $data->name,
            $manufacturer,
            $quantity,
            $data->unit,
            $data->min_stocks > 0 ? $data->min_stocks : "---",
            $data->part_number,
            $data->article_number,
            $data->hs_code,
            $actions
        );
    }



    // Paints parts tab
    function paints_tab($client_id, $warehouse_id) {
        $view_data["can_edit_items"] = $this->can_access_own_client($client_id);
        $view_data["warehouse_id"] = $warehouse_id;
        $view_data["client_id"] = $client_id;
        return $this->template->view("warehouses/paints/index", $view_data);
    }

    function paints_modal_form() {
        $client_id = $this->request->getPost("client_id");
        $warehouse_id = $this->request->getPost("warehouse_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($warehouse_id) {
            $id = $this->request->getPost('id');
            $view_data['model_info'] = $this->Warehouse_paints_model->get_one($id);
            $view_data["warehouse_id"] = $warehouse_id;
            $view_data["client_id"] = $client_id;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            if ($id) {
                $view_data["items_dropdown"] = $this->get_paints_dropdown();
            } else {
                $view_data["items_dropdown"] = $this->Warehouse_paints_model->get_items_dropdown($warehouse_id);
            }
            $paints = $this->Paints_model->get_details()->getResult();
            $manufacturers = $this->Manufacturers_model->get_all()->getResult();
            $paints = array_map(function ($item) use ($manufacturers) {
                $manufacturer = $this->_get_names_by_ids($item->manufacturer_id, $manufacturers);
                $item->manufacturer = $manufacturer;
                return $item;
            }, $paints);
            $view_data["paints"] = $paints;

            return $this->template->view("warehouses/paints/modal_form", $view_data);
        } else {
            show_404();
        }
    }

    function save_paint() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "warehouse_id" => "required|numeric",
            "paint_id" => "required|numeric",
            "quantity" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "warehouse_id" => $this->request->getPost("warehouse_id"),
            "paint_id" => $this->request->getPost("paint_id"),
            "quantity" => $this->request->getPost("quantity"),
            "min_stocks" => $this->request->getPost("min_stocks")
        );

        if ($this->Warehouse_paints_model->is_duplicate_item($data["paint_id"], $data["warehouse_id"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_item")));
            exit();
        }

        $save_id = $this->Warehouse_paints_model->ci_save($data, $id);
        if ($save_id) {
            if ($data["min_stocks"] > 0 && $data["quantity"] <= $data["min_stocks"]) {
                // TODO: notification, add todo (private)
                $notification_option = array("client_id" => $client_id, "warehouse_id" => $data["warehouse_id"], "warehouse_item_id" => $save_id, "warehouse_tab" => "paints");
                log_notification("warehouse_item_minimum_reached", $notification_option, "0");

                $client = $this->Clients_model->get_one($client_id);
                $info = $this->Warehouse_paints_model->get_infomation($save_id);
                $url = get_uri("warehouses/view/" . $client_id . "/" . $data["warehouse_id"]);
                $description = "<strong>" . $info->name . "</strong> (" . $info->quantity . " / " . $info->min_stocks . ", ". app_lang("paints") . ") on <strong>" . $info->warehouse . "</strong> (warehouse) has been reached minimum of stocks.<br/>";
                $description .= '<a href="' . $url . '" target="_blank">' . $url . '</a>';
                $todo_data = array(
                    "client_id" => $client_id,
                    "title" => app_lang("paints") . " - " . app_lang("minimum_item_reached"),
                    "description" => $description,
                    "created_by" => $client->owner_id,
                    "created_at" => get_current_utc_time(),
                    "start_date" => get_current_utc_time("Y-m-d")
                );
                $this->Todo_model->ci_save($todo_data, null);

                $primary_contact_id = $this->Clients_model->get_primary_contact($client_id);
                $todo_data["created_by"] = $primary_contact_id;
                $this->Todo_model->ci_save($todo_data, null);

                echo json_encode(array("success" => true, "min_stock_reached" => true, "data" => $this->_paint_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('minimum_item_reached')));
            } else {
                echo json_encode(array("success" => true, "min_stock_reached" => false, "data" => $this->_paint_row_data($client_id, $save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_paint() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Warehouse_paints_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function paints_list_data($client_id, $warehouse_id) {
        $list_data = $this->Warehouse_paints_model->get_details(array("warehouse_id" => $warehouse_id))->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_paint_make_row($client_id, $data, $manufacturers);
        }

        echo json_encode(array("data" => $result));
    }

    private function _paint_row_data($client_id, $id) {
        $data = $this->Warehouse_paints_model->get_details(array("id" => $id))->getRow();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        return $this->_paint_make_row($client_id, $data, $manufacturers);
    }

    private function _paint_make_row($client_id, $data, $manufacturers) {
        $actions = "";
        if ($this->can_access_own_client($client_id)) {
            $actions = modal_anchor(get_uri("warehouses/paints_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-client_id" => $client_id, "data-post-warehouse_id" => $data->warehouse_id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("warehouses/delete_paint"), "data-action" => "delete-confirmation"));
        }

        $icon = "";
        $quantity = $data->quantity;
        if ($data->quantity <= $data->min_stocks) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $quantity = '<span style="color: #d50000">' . $quantity . '</span>';
        }

        $checkbox_class = "checkbox-blank";
        if ($data->is_critical) {
            $checkbox_class = "checkbox-checked";
        }
        $check_critical = "<span class='$checkbox_class mr15 float-start'></span>";
        $manufacturer = $this->_get_names_by_ids($data->manufacturer_id, $manufacturers);

        return array(
            $data->id,
            $icon,
            $data->is_critical,
            $check_critical,
            $data->name,
            $manufacturer,
            $quantity,
            $data->unit,
            $data->min_stocks > 0 ? $data->min_stocks : "---",
            $data->part_number,
            $data->article_number,
            $data->hs_code,
            $actions
        );
    }



    function import_modal_form() {
        $client_id = $this->request->getPost("client_id");
        $warehouse_id = $this->request->getPost("warehouse_id");
        $tab = $this->request->getPost("tab");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $view_data["client_id"] = $client_id;
        $view_data["warehouse_id"] = $warehouse_id;
        $view_data["tab"] = $tab;
        return $this->template->view("warehouses/import_modal_form", $view_data);
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

    function download_sample_excel_file($tab) {
        $file_name = "";
        if ($tab == "spares") {
            $file_name = "import-warehouse-spare-parts-sample.xlsx";
        } else if ($tab == "chemicals") {
            $file_name = "import-warehouse-chemicals-sample.xlsx";
        } else if ($tab == "oils") {
            $file_name = "import-warehouse-oils-sample.xlsx";
        } else if ($tab == "paints") {
            $file_name = "import-warehouse-paints-sample.xlsx";
        }
        if (!empty($file_name)) {
            return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
        }
    }

    private function _get_allowed_headers($tab) {
        if ($tab == "spares") {
            return array(
                [ "key" => "name", "required" => true ],
                [ "key" => "manufacturer", "required" => true ],
                [ "key" => "applicable_equipment", "required" => false ],
                [ "key" => "ship_equipment", "required" => false ],
                [ "key" => "quantity", "required" => true ],
                [ "key" => "unit", "required" => true ],
                [ "key" => "part_description", "required" => false ],
                [ "key" => "part_number", "required" => false ],
                [ "key" => "article_number", "required" => false ],
                [ "key" => "drawing_number", "required" => false ],
                [ "key" => "hs_code", "required" => false ],
                [ "key" => "is_critical", "required" => false ],
                [ "key" => "min_stocks", "required" => false ],
                [ "key" => "max_stocks", "required" => false ],
            );
        } else if ($tab == "chemicals") {
            return array(
                [ "key" => "name", "required" => true ],
                [ "key" => "manufacturer", "required" => true ],
                [ "key" => "quantity", "required" => true ],
                [ "key" => "unit", "required" => true ],
                [ "key" => "part_description", "required" => false ],
                [ "key" => "part_number", "required" => false ],
                [ "key" => "article_number", "required" => false ],
                [ "key" => "hs_code", "required" => false ],
                [ "key" => "is_critical", "required" => false ],
                [ "key" => "min_stocks", "required" => false ],
            );
        } else if ($tab == "oils") {
            return array(
                [ "key" => "name", "required" => true ],
                [ "key" => "manufacturer", "required" => true ],
                [ "key" => "quantity", "required" => true ],
                [ "key" => "unit", "required" => true ],
                [ "key" => "part_description", "required" => false ],
                [ "key" => "part_number", "required" => false ],
                [ "key" => "article_number", "required" => false ],
                [ "key" => "hs_code", "required" => false ],
                [ "key" => "is_critical", "required" => false ],
                [ "key" => "min_stocks", "required" => false ],
            );
        } else if ($tab == "paints") {
            return array(
                [ "key" => "name", "required" => true ],
                [ "key" => "manufacturer", "required" => true ],
                [ "key" => "quantity", "required" => true ],
                [ "key" => "unit", "required" => true ],
                [ "key" => "part_description", "required" => false ],
                [ "key" => "part_number", "required" => false ],
                [ "key" => "article_number", "required" => false ],
                [ "key" => "hs_code", "required" => false ],
                [ "key" => "is_critical", "required" => false ],
                [ "key" => "min_stocks", "required" => false ],
            );
        } else {
            return [];
        }
    }

    private function _store_item_headers_position($tab, $headers_row = array()) {
        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers($tab));

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

    private function _row_data_validation_and_get_error_message($tab, $key, $data) {
        $allowed_headers = $this->_get_allowed_headers($tab);
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
        $manufacturer_data = array();
        $applicable_data = array();
        $ship_data = array();
        $unit_data = array();
        $warehouse_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }

            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "manufacturer") {
                $manufacturer_data["name"] = $row_data_value;
            } else if ($header_key_value == "applicable_equipment") {
                $applicable_data["name"] = $row_data_value;
            } else if ($header_key_value == "ship_equipment") {
                $ship_data["name"] = $row_data_value;
            } else if ($header_key_value == 'unit') {
                $unit_data["name"] = $row_data_value;
            } else if ($header_key_value == 'quantity') {
                $warehouse_data["quantity"] = $row_data_value;
            } else if ($header_key_value == 'min_stocks') {
                $warehouse_data["min_stocks"] = $row_data_value;
            } else if ($header_key_value == 'max_stocks') {
                $warehouse_data["max_stocks"] = $row_data_value;
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "item_data" => $item_data,
            "manufacturer_data" => $manufacturer_data,
            "applicable_data" => $applicable_data,
            "ship_data" => $ship_data,
            "unit_data" => $unit_data,
            "warehouse_data" => $warehouse_data
        );
    }

    function validate_import_file_data($tab, $check_on_submit = false) {
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
                $headers = $this->_store_item_headers_position($tab, $value);

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
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($tab, $key, $row_data);
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
        $client_id = $this->request->getPost("client_id");
        $tab = $this->request->getPost("tab");
        $warehouse_id = $this->request->getPost("warehouse_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if (!$this->validate_import_file_data($tab, true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();
        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers($tab));

        if ($tab == "spares") {
            $this->save_spares_from_excel_file($allowed_headers, $excel_file, $warehouse_id);
        } else if ($tab == "chemicals") {
            $this->save_chemicals_from_excel_file($allowed_headers, $excel_file, $warehouse_id);
        } else if ($tab == "oils") {
            $this->save_oils_from_excel_file($allowed_headers, $excel_file, $warehouse_id);
        } else if ($tab == "paints") {
            $this->save_paints_from_excel_file($allowed_headers, $excel_file, $warehouse_id);
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    function save_spares_from_excel_file($allowed_headers, $excel_file, $warehouse_id) {
        $spare_list = $this->Spare_parts_model->get_all()->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $applicable_equipments = $this->Applicable_equipments_model->get_all()->getResult();
        $ship_equipments = $this->Ship_equipments_model->get_all()->getResult();
        $units = $this->Units_model->get_all()->getResult();
        $warehouse_items_list = $this->Warehouse_spares_model->get_all_where(array("deleted" => 0, "warehouse_id" => $warehouse_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $applicable_data = get_array_value($data_array, "applicable_data");
            $ship_data = get_array_value($data_array, "ship_data");
            $unit_data = get_array_value($data_array, "unit_data");
            $warehouse_data = get_array_value($data_array, "warehouse_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // manufacturer
                if (isset($manufacturer_data["name"]) && !empty($manufacturer_data["name"]) && $manufacturer_data["name"] !== "---") {
                    $names = explode(",", $manufacturer_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $manufacturers);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $manufacturer_data["name"] = trim($name);
                            $m_save_id = $this->Manufacturers_model->ci_save($manufacturer_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $manufacturers[] = $temp;
                        }
                    }

                    $item_data["manufacturer_id"] = implode(",", $m_ids);
                }

                // applicable machinery equipments
                if (isset($applicable_data["name"]) && !empty($applicable_data["name"]) && $applicable_data["name"] !== "---") {
                    $names = explode(",", $applicable_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $applicable_equipments);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $applicable_data["name"] = trim($name);
                            $m_save_id = $this->Applicable_equipments_model->ci_save($applicable_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $applicable_equipments[] = $temp;
                        }
                    }

                    $item_data["applicable_equip_id"] = implode(",", $m_ids);
                }

                // ship machinery equipments
                if (isset($ship_data["name"]) && !empty($ship_data["name"]) && $ship_data["name"] !== "---") {
                    $names = explode(",", $ship_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $ship_equipments);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $ship_data["name"] = trim($name);
                            $m_save_id = $this->Ship_equipments_model->ci_save($ship_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $ship_equipments[] = $temp;
                        }
                    }

                    $item_data["ship_equip_id"] = implode(",", $m_ids);
                }

                // units
                if (isset($unit_data["name"]) && !empty($unit_data["name"]) && $unit_data["name"] !== "---") {
                    $unit = $this->_findObjectByName($unit_data["name"], $units);
                    if ($unit) {
                        $item_data["unit_id"] = $unit->id;
                    } else {
                        $m_save_id = $this->Units_model->ci_save($unit_data);
                        $item_data["unit_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $unit_data["name"];
                        $units[] = $temp;
                    }
                }

                // Spare parts
                $spare = $this->_findObjectByName($item_data["name"], $spare_list);
                if ($spare) {
                    $warehouse_data["spare_id"] = $spare->id;
                } else {
                    $m_save_id = $this->Spare_parts_model->ci_save($item_data);
                    $warehouse_data["spare_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $item_data["name"];
                    $spare_list[] = $temp;
                }

                // Warehouse-spares
                if (isset($warehouse_data["quantity"])) {
                    $warehouse_data["warehouse_id"] = $warehouse_id;

                    $row = $this->_findObjectBySpareId($warehouse_data["spare_id"], $warehouse_items_list);
                    if ($row) {
                        $this->Warehouse_spares_model->ci_save($warehouse_data, $row->id);
                    } else {
                        $m_save_id = $this->Warehouse_spares_model->ci_save($warehouse_data);

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->spare_id = $warehouse_data["spare_id"];
                        $warehouse_items_list[] = $temp;
                    }
                }

            } catch (Exception $e) {
                print_r($e->getMessage());
                return;
            }
        }
    }

    function save_chemicals_from_excel_file($allowed_headers, $excel_file, $warehouse_id) {
        $chemical_list = $this->Chemicals_model->get_all()->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $units = $this->Units_model->get_all()->getResult();
        $warehouse_items_list = $this->Warehouse_chemicals_model->get_all_where(array("deleted" => 0, "warehouse_id" => $warehouse_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $unit_data = get_array_value($data_array, "unit_data");
            $warehouse_data = get_array_value($data_array, "warehouse_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // manufacturer
                if (isset($manufacturer_data["name"]) && !empty($manufacturer_data["name"]) && $manufacturer_data["name"] !== "---") {
                    $names = explode(",", $manufacturer_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $manufacturers);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $manufacturer_data["name"] = trim($name);
                            $m_save_id = $this->Manufacturers_model->ci_save($manufacturer_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $manufacturers[] = $temp;
                        }
                    }

                    $item_data["manufacturer_id"] = implode(",", $m_ids);
                }

                // units
                if (isset($unit_data["name"]) && !empty($unit_data["name"]) && $unit_data["name"] !== "---") {
                    $unit = $this->_findObjectByName($unit_data["name"], $units);
                    if ($unit) {
                        $item_data["unit_id"] = $unit->id;
                    } else {
                        $m_save_id = $this->Units_model->ci_save($unit_data);
                        $item_data["unit_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $unit_data["name"];
                        $units[] = $temp;
                    }
                }

                // Chemicals
                $chemical = $this->_findObjectByName($item_data["name"], $chemical_list);
                if ($chemical) {
                    $warehouse_data["chemical_id"] = $chemical->id;
                } else {
                    $m_save_id = $this->Chemicals_model->ci_save($item_data);
                    $warehouse_data["chemical_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $item_data["name"];
                    $chemical_list[] = $temp;
                }

                // Warehouse-chemicals
                if (isset($warehouse_data["quantity"])) {
                    $warehouse_data["warehouse_id"] = $warehouse_id;

                    $row = $this->_findObjectByChemicalId($warehouse_data["chemical_id"], $warehouse_items_list);
                    if ($row) {
                        $this->Warehouse_chemicals_model->ci_save($warehouse_data, $row->id);
                    } else {
                        $m_save_id = $this->Warehouse_chemicals_model->ci_save($warehouse_data);

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->chemical_id = $warehouse_data["chemical_id"];
                        $warehouse_items_list[] = $temp;
                    }
                }

            } catch (Exception $e) {
                print_r($e->getMessage());
                return;
            }
        }
    }

    function save_oils_from_excel_file($allowed_headers, $excel_file, $warehouse_id) {
        $oil_list = $this->Oils_model->get_all()->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $units = $this->Units_model->get_all()->getResult();
        $warehouse_items_list = $this->Warehouse_oils_model->get_all_where(array("deleted" => 0, "warehouse_id" => $warehouse_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $unit_data = get_array_value($data_array, "unit_data");
            $warehouse_data = get_array_value($data_array, "warehouse_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // manufacturer
                if (isset($manufacturer_data["name"]) && !empty($manufacturer_data["name"]) && $manufacturer_data["name"] !== "---") {
                    $names = explode(",", $manufacturer_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $manufacturers);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $manufacturer_data["name"] = trim($name);
                            $m_save_id = $this->Manufacturers_model->ci_save($manufacturer_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $manufacturers[] = $temp;
                        }
                    }

                    $item_data["manufacturer_id"] = implode(",", $m_ids);
                }

                // units
                if (isset($unit_data["name"]) && !empty($unit_data["name"]) && $unit_data["name"] !== "---") {
                    $unit = $this->_findObjectByName($unit_data["name"], $units);
                    if ($unit) {
                        $item_data["unit_id"] = $unit->id;
                    } else {
                        $m_save_id = $this->Units_model->ci_save($unit_data);
                        $item_data["unit_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $unit_data["name"];
                        $units[] = $temp;
                    }
                }

                // Oils
                $oil = $this->_findObjectByName($item_data["name"], $oil_list);
                if ($oil) {
                    $warehouse_data["oil_id"] = $oil->id;
                } else {
                    $m_save_id = $this->Oils_model->ci_save($item_data);
                    $warehouse_data["oil_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $item_data["name"];
                    $oil_list[] = $temp;
                }

                // Warehouse-oils
                if (isset($warehouse_data["quantity"])) {
                    $warehouse_data["warehouse_id"] = $warehouse_id;

                    $row = $this->_findObjectByOilId($warehouse_data["oil_id"], $warehouse_items_list);
                    if ($row) {
                        $this->Warehouse_oils_model->ci_save($warehouse_data, $row->id);
                    } else {
                        $m_save_id = $this->Warehouse_oils_model->ci_save($warehouse_data);

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->oil_id = $warehouse_data["oil_id"];
                        $warehouse_items_list[] = $temp;
                    }
                }

            } catch (Exception $e) {
                print_r($e->getMessage());
                return;
            }
        }
    }

    function save_paints_from_excel_file($allowed_headers, $excel_file, $warehouse_id) {
        $paint_list = $this->Paints_model->get_all()->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $units = $this->Units_model->get_all()->getResult();
        $warehouse_items_list = $this->Warehouse_paints_model->get_all_where(array("deleted" => 0, "warehouse_id" => $warehouse_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $unit_data = get_array_value($data_array, "unit_data");
            $warehouse_data = get_array_value($data_array, "warehouse_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // manufacturer
                if (isset($manufacturer_data["name"]) && !empty($manufacturer_data["name"]) && $manufacturer_data["name"] !== "---") {
                    $names = explode(",", $manufacturer_data["name"]);
                    $m_ids = array();
                    foreach ($names as $name) {
                        $_item = $this->_findObjectByName($name, $manufacturers);
                        if ($_item) {
                            $m_ids[] = $_item->id;
                        } else {
                            $manufacturer_data["name"] = trim($name);
                            $m_save_id = $this->Manufacturers_model->ci_save($manufacturer_data);
                            $m_ids[] = $m_save_id;

                            $temp = new stdClass();
                            $temp->id = $m_save_id;
                            $temp->name = trim($name);
                            $manufacturers[] = $temp;
                        }
                    }

                    $item_data["manufacturer_id"] = implode(",", $m_ids);
                }

                // units
                if (isset($unit_data["name"]) && !empty($unit_data["name"]) && $unit_data["name"] !== "---") {
                    $unit = $this->_findObjectByName($unit_data["name"], $units);
                    if ($unit) {
                        $item_data["unit_id"] = $unit->id;
                    } else {
                        $m_save_id = $this->Units_model->ci_save($unit_data);
                        $item_data["unit_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $unit_data["name"];
                        $units[] = $temp;
                    }
                }

                // Paints
                $paint = $this->_findObjectByName($item_data["name"], $paint_list);
                if ($paint) {
                    $warehouse_data["paint_id"] = $paint->id;
                } else {
                    $m_save_id = $this->Paints_model->ci_save($item_data);
                    $warehouse_data["paint_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $item_data["name"];
                    $paint_list[] = $temp;
                }

                // Warehouse-paintss
                if (isset($warehouse_data["quantity"])) {
                    $warehouse_data["warehouse_id"] = $warehouse_id;

                    $row = $this->_findObjectByPaintId($warehouse_data["paint_id"], $warehouse_items_list);
                    if ($row) {
                        $this->Warehouse_paints_model->ci_save($warehouse_data, $row->id);
                    } else {
                        $m_save_id = $this->Warehouse_paints_model->ci_save($warehouse_data);

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->paint_id = $warehouse_data["paint_id"];
                        $warehouse_items_list[] = $temp;
                    }
                }

            } catch (Exception $e) {
                print_r($e->getMessage());
                return;
            }
        }
    }

    private function _findObjectByName($name, $arr) {
        $name = trim($name);
        foreach ($arr as $item) {
            if ($name == $item->name) {
                return $item;
            }
        }
        return false;
    }

    private function _findObjectBySpareId($spare_id, $arr) {
        foreach ($arr as $item) {
            if ($spare_id == $item->spare_id) {
                return $item;
            }
        }
        return false;
    }

    private function _findObjectByChemicalId($chemical_id, $arr) {
        foreach ($arr as $item) {
            if ($chemical_id == $item->chemical_id) {
                return $item;
            }
        }
        return false;
    }

    private function _findObjectByOilId($oil_id, $arr) {
        foreach ($arr as $item) {
            if ($oil_id == $item->oil_id) {
                return $item;
            }
        }
        return false;
    }

    private function _findObjectByPaintId($paint_id, $arr) {
        foreach ($arr as $item) {
            if ($paint_id == $item->paint_id) {
                return $item;
            }
        }
        return false;
    }

    private function _get_names_by_ids($ids_str, $arr) {
        if (empty($ids_str)) {
            return "";
        }
        $ids = explode(",", $ids_str);
        $filtered_array = array_filter($arr, function ($obj) use ($ids) {
            return in_array($obj->id, $ids);
        });
        if (count($filtered_array) > 0) {
            $names = array_map(function($val) { return $val->name; }, $filtered_array);
            return implode(", ", $names);
        } else {
            return "";
        }
    }

}

/* End of file notes.php */
/* Location: ./app/controllers/notes.php */