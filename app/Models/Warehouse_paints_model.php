<?php

namespace App\Models;

class Warehouse_paints_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'warehouse_paints';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $wp_table = $this->db->prefixTable('warehouse_paints');
        $paints_table = $this->db->prefixTable("paints");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $wp_table.id=$id";
        }
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $wp_table.warehouse_id=$warehouse_id";
        }

        $sql = "SELECT $wp_table.*, a.name, a.hs_code, a.manufacturer, a.unit, a.part_number, a.article_number, a.is_critical
                FROM $wp_table
                JOIN (
                    SELECT $paints_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                    FROM $paints_table
                    LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $paints_table.manufacturer_id
                    LEFT JOIN $units_table ON $units_table.id = $paints_table.unit_id
                ) a ON a.id = $wp_table.paint_id
                WHERE $wp_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function is_duplicate_item($paint_id, $warehouse_id, $id) {
        $result = $this->get_all_where(array("paint_id" => $paint_id, "warehouse_id" => $warehouse_id, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    function get_items_dropdown($warehouse_id) {
        $paints_table = $this->db->prefixTable("paints");
        $wp_table = $this->db->prefixTable("warehouse_paints");

        $sql = "SELECT $paints_table.id, $paints_table.name
                FROM $paints_table
                WHERE $paints_table.deleted = 0 AND $paints_table.id NOT IN (SELECT paint_id FROM $wp_table WHERE warehouse_id=$warehouse_id AND deleted=0)
                ORDER BY $paints_table.is_critical DESC, $paints_table.name ASC";

        $list = $this->db->query($sql)->getResult();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    function get_infomation($id) {
        $wp_table = $this->db->prefixTable("warehouse_paints");
        $paint_table = $this->db->prefixTable("paints");
        $warehouse_table = $this->db->prefixTable("warehouses");

        $sql = "SELECT a.*, $paint_table.name, $warehouse_table.code, $warehouse_table.name as warehouse
                FROM (SELECT * FROM $wp_table WHERE id=$id) a
                JOIN $paint_table ON $paint_table.id = a.paint_id
                JOIN $warehouse_table ON $warehouse_table.id = a.warehouse_id";

        $row = $this->db->query($sql)->getRow();
        return $row;
    }

}
