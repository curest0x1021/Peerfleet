<?php

namespace App\Models;

class Warehouse_spares_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = "warehouse_spares";
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $ws_table = $this->db->prefixTable("warehouse_spares");
        $spare_table = $this->db->prefixTable("spare_parts");
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

        $sql = "SELECT $ws_table.*, a.name, a.hs_code, a.manufacturer, a.applicable_equip, a.ship_equip, a.unit, a.part_number, a.article_number, a.drawing_number, a.is_critical
                FROM $ws_table
                JOIN (
                    SELECT $spare_table.*, $manufacturer_table.name as manufacturer, $applicable_table.name as applicable_equip, $ship_table.name as ship_equip, $units_table.name as unit
                    FROM $spare_table
                    LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $spare_table.manufacturer_id
                    LEFT JOIN $applicable_table ON $applicable_table.id = $spare_table.applicable_equip_id
                    LEFT JOIN $ship_table ON $ship_table.id = $spare_table.ship_equip_id
                    LEFT JOIN $units_table ON $units_table.id = $spare_table.unit_id
                ) a ON a.id = $ws_table.spare_id
                WHERE $ws_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function is_duplicate_item($spare_id, $warehouse_id, $id) {
        $result = $this->get_all_where(array("spare_id" => $spare_id, "warehouse_id" => $warehouse_id, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    function get_items_dropdown($warehouse_id) {
        $spare_table = $this->db->prefixTable("spare_parts");
        $ws_table = $this->db->prefixTable("warehouse_spares");

        $sql = "SELECT $spare_table.id, $spare_table.name
                FROM $spare_table
                WHERE $spare_table.deleted = 0 AND $spare_table.id NOT IN (SELECT spare_id FROM $ws_table WHERE warehouse_id=$warehouse_id AND deleted=0)
                ORDER BY $spare_table.is_critical DESC, $spare_table.name ASC";

        $list = $this->db->query($sql)->getResult();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    function get_infomation($id) {
        $ws_table = $this->db->prefixTable("warehouse_spares");
        $spare_table = $this->db->prefixTable("spare_parts");
        $warehouse_table = $this->db->prefixTable("warehouses");

        $sql = "SELECT a.*, $spare_table.name, $warehouse_table.code, $warehouse_table.name as warehouse
                FROM (SELECT * FROM $ws_table WHERE id=$id) a
                JOIN $spare_table ON $spare_table.id = a.spare_id
                JOIN $warehouse_table ON $warehouse_table.id = a.warehouse_id";

        $row = $this->db->query($sql)->getRow();
        return $row;
    }
}
