<?php

namespace App\Models;

class Vessel_types_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'vessel_types';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $vessel_types_table = $this->db->prefixTable('vessel_types');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $vessel_types_table.id=$id";
        }

        $sql = "SELECT $vessel_types_table.*
        FROM $vessel_types_table
        WHERE $vessel_types_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
