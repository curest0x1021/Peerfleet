<?php

namespace App\Models;

class Warehouse_oils_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'warehouse_oils';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $wo_table = $this->db->prefixTable('warehouse_oils');
        $oils_table = $this->db->prefixTable("oils");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $wo_table.id=$id";
        }
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $wo_table.warehouse_id=$warehouse_id";
        }

        $sql = "SELECT $wo_table.*, a.name, a.hs_code, a.manufacturer, a.unit, a.part_number, a.article_number, a.is_critical
                FROM $wo_table
                JOIN (
                    SELECT $oils_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                    FROM $oils_table
                    LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $oils_table.manufacturer_id
                    LEFT JOIN $units_table ON $units_table.code = $oils_table.unit_code
                ) a ON a.id = $wo_table.oil_id
                WHERE $wo_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function is_duplicate_item($oil_id, $warehouse_id, $id) {
        $result = $this->get_all_where(array("oil_id" => $oil_id, "warehouse_id" => $warehouse_id, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    function get_items_dropdown($warehouse_id) {
        $oils_table = $this->db->prefixTable("oils");
        $wo_table = $this->db->prefixTable("warehouse_oils");

        $sql = "SELECT $oils_table.id, $oils_table.name
                FROM $oils_table
                WHERE $oils_table.deleted = 0 AND $oils_table.id NOT IN (SELECT oil_id FROM $wo_table WHERE warehouse_id=$warehouse_id AND deleted=0)
                ORDER BY $oils_table.is_critical DESC, $oils_table.name ASC";

        $list = $this->db->query($sql)->getResult();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    function get_infomation($id) {
        $wo_table = $this->db->prefixTable("warehouse_oils");
        $oil_table = $this->db->prefixTable("oils");
        $warehouse_table = $this->db->prefixTable("warehouses");

        $sql = "SELECT a.*, $oil_table.name, $warehouse_table.code, $warehouse_table.name as warehouse
                FROM (SELECT * FROM $wo_table WHERE id=$id) a
                JOIN $oil_table ON $oil_table.id = a.oil_id
                JOIN $warehouse_table ON $warehouse_table.id = a.warehouse_id";

        $row = $this->db->query($sql)->getRow();
        return $row;
    }

}
