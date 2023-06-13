<?php

namespace App\Models;

class Warehouse_spare_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'warehouse_spare';
        parent::__construct($this->table);
    }

    function get_warehouses($options = array()) {
        $warehouse_table = $this->db->prefixTable("warehouses");
        $clients_table = $this->db->prefixTable("clients");
        $spare_table = $this->db->prefixTable("warehouse_spare");

        $where = "";
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $warehouse_table.id = $warehouse_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $warehouse_table.client_id = $client_id";
        }

        $sql = "SELECT $warehouse_table.*, $clients_table.charter_name as vessel, a.total_items, a.total_quantities
                FROM $warehouse_table
                LEFT JOIN $clients_table ON $clients_table.id = $warehouse_table.client_id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items, SUM(quantity) as total_quantities FROM $spare_table GROUP BY warehouse_id) a ON a.warehouse_id = $warehouse_table.id
                WHERE $warehouse_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function get_details($options = array()) {
        $ws_table = $this->db->prefixTable('warehouse_spare');
        $spare_table = $this->db->prefixTable("critical_spare_parts");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $applicable_table = $this->db->prefixTable("applicable_equipments");
        $ship_table = $this->db->prefixTable("ship_equipments");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $ws_table.id=$id";
        }
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $ws_table.warehouse_id=$warehouse_id";
        }

        $sql = "SELECT $ws_table.*, a.name, a.hs_code, a.manufacturer, a.applicable_equip, a.ship_equip, a.unit, a.part_number, a.article_number, a.drawing_number
                FROM $ws_table
                JOIN (
                    SELECT $spare_table.*, $manufacturer_table.name as manufacturer, $applicable_table.name as applicable_equip, $ship_table.name as ship_equip, $units_table.name as unit
                    FROM $spare_table
                    LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $spare_table.manufacturer_id
                    LEFT JOIN $applicable_table ON $applicable_table.id = $spare_table.applicable_equip_id
                    LEFT JOIN $ship_table ON $ship_table.id = $spare_table.ship_equip_id
                    LEFT JOIN $units_table ON $units_table.code = $spare_table.unit_code
                ) a ON a.id = $ws_table.spare_id
                WHERE $ws_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function is_duplicate_spare_part($spare_id, $warehouse_id, $id) {
        $result = $this->get_all_where(array("spare_id" => $spare_id, "warehouse_id" => $warehouse_id, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}
