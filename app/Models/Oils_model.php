<?php

namespace App\Models;

class Oils_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'oils';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $oil_table = $this->db->prefixTable("oils");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $oil_table.id = $id";
        }

        $is_critical = $this->_get_clean_value($options, "is_critical");
        if ($is_critical != "") {
            $where .= " AND FIND_IN_SET($oil_table.is_critical,'$is_critical')";
        }

        $sql = "SELECT $oil_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                FROM $oil_table
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $oil_table.manufacturer_id
                LEFT JOIN $units_table ON $units_table.id = $oil_table.unit_id
                WHERE $oil_table.deleted = 0 $where
                ORDER BY $oil_table.is_critical DESC, $oil_table.name ASC";

        return $this->db->query($sql);
    }

}
