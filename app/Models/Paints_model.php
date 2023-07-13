<?php

namespace App\Models;

class Paints_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'paints';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $paints_table = $this->db->prefixTable("paints");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $paints_table.id = $id";
        }

        $is_critical = $this->_get_clean_value($options, "is_critical");
        if ($is_critical != "") {
            $where .= " AND FIND_IN_SET($paints_table.is_critical,'$is_critical')";
        }

        $sql = "SELECT $paints_table.*, $manufacturer_table.name as manufacturer, $units_table.name as unit
                FROM $paints_table
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $paints_table.manufacturer_id
                LEFT JOIN $units_table ON $units_table.id = $paints_table.unit_id
                WHERE $paints_table.deleted = 0 $where
                ORDER BY $paints_table.is_critical DESC, $paints_table.name ASC";

        return $this->db->query($sql);
    }

}
