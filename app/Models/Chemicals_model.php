<?php

namespace App\Models;

class Chemicals_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'chemicals';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $chemial_table = $this->db->prefixTable("chemicals");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $chemial_table.id = $id";
        }

        $is_critical = $this->_get_clean_value($options, "is_critical");
        if ($is_critical != "") {
            $where .= " AND FIND_IN_SET($chemial_table.is_critical,'$is_critical')";
        }

        $sql = "SELECT $chemial_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                FROM $chemial_table
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $chemial_table.manufacturer_id
                LEFT JOIN $units_table ON $units_table.id = $chemial_table.unit_id
                WHERE $chemial_table.deleted = 0 $where
                ORDER BY $chemial_table.is_critical DESC, $chemial_table.name ASC";

        return $this->db->query($sql);
    }

}
