<?php

namespace App\Models;

class Cranes_wire_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes_wire_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $inspection_table = $this->db->prefixTable("cranes_wire_inspection");
        $cranes_table = $this->db->prefixTable("cranes");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $inspection_table.id = $id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $inspection_table.client_id = $client_id";
        }

        $sql = "SELECT $inspection_table.*, $cranes_table.crane, $cranes_table.rope
                FROM $inspection_table
                LEFT JOIN $cranes_table ON $cranes_table.id = $inspection_table.rope_id
                WHERE deleted=0 $where
                ORDER BY $inspection_table.inspection_date DESC";

        return $this->db->query($sql);
    }
}