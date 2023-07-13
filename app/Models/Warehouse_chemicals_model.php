<?php

namespace App\Models;

class Warehouse_chemicals_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'warehouse_chemicals';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $wc_table = $this->db->prefixTable('warehouse_chemicals');
        $chemicals_table = $this->db->prefixTable("chemicals");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $wc_table.id=$id";
        }
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $wc_table.warehouse_id=$warehouse_id";
        }

        $sql = "SELECT $wc_table.*, a.name, a.hs_code, a.manufacturer, a.unit, a.part_number, a.article_number, a.is_critical
                FROM $wc_table
                JOIN (
                    SELECT $chemicals_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                    FROM $chemicals_table
                    LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $chemicals_table.manufacturer_id
                    LEFT JOIN $units_table ON $units_table.code = $chemicals_table.unit_code
                ) a ON a.id = $wc_table.chemical_id
                WHERE $wc_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function is_duplicate_item($chemical_id, $warehouse_id, $id) {
        $result = $this->get_all_where(array("chemical_id" => $chemical_id, "warehouse_id" => $warehouse_id, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

    function get_items_dropdown($warehouse_id) {
        $chemicals_table = $this->db->prefixTable("chemicals");
        $wc_table = $this->db->prefixTable("warehouse_chemicals");

        $sql = "SELECT $chemicals_table.id, $chemicals_table.name
                FROM $chemicals_table
                WHERE $chemicals_table.deleted = 0 AND $chemicals_table.id NOT IN (SELECT chemical_id FROM $wc_table WHERE warehouse_id=$warehouse_id AND deleted=0)
                ORDER BY $chemicals_table.is_critical DESC, $chemicals_table.name ASC";

        $list = $this->db->query($sql)->getResult();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    function get_infomation($id) {
        $wc_table = $this->db->prefixTable("warehouse_chemicals");
        $chemical_table = $this->db->prefixTable("chemicals");
        $warehouse_table = $this->db->prefixTable("warehouses");

        $sql = "SELECT a.*, $chemical_table.name, $warehouse_table.code, $warehouse_table.name as warehouse
                FROM (SELECT * FROM $wc_table WHERE id=$id) a
                JOIN $chemical_table ON $chemical_table.id = a.chemical_id
                JOIN $warehouse_table ON $warehouse_table.id = a.warehouse_id";

        $row = $this->db->query($sql)->getRow();
        return $row;
    }

}
