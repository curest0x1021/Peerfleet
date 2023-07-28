<?php

namespace App\Models;

class Spare_parts_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'spare_parts';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $spare_table = $this->db->prefixTable("spare_parts");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $spare_table.id = $id";
        }

        $is_critical = $this->_get_clean_value($options, "is_critical");
        if ($is_critical != "") {
            $where .= " AND FIND_IN_SET($spare_table.is_critical,'$is_critical')";
        }

        $sql = "SELECT $spare_table.*, $units_table.name as unit
                FROM $spare_table
                LEFT JOIN $units_table ON $units_table.id = $spare_table.unit_id
                WHERE $spare_table.deleted = 0 $where
                ORDER BY $spare_table.is_critical DESC, $spare_table.name ASC";

        return $this->db->query($sql);
    }

}