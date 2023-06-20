<?php

namespace App\Models;

class Cranes_info_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes_info';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $info_table = $this->db->prefixTable("cranes_info");
        $cranes_table = $this->db->prefixTable("cranes");

        $where = "";
        $rope_id = $this->_get_clean_value($options, "rope_id");
        if ($rope_id) {
            $where .= " AND $cranes_table.id = $rope_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $cranes_table.client_id = $client_id";
        }

        $sql = "SELECT $cranes_table.id as rope_id, $cranes_table.client_id, $cranes_table.crane, $cranes_table.rope, $info_table.id, $info_table.diameter, $info_table.length, $info_table.swl
                FROM $cranes_table
                LEFT JOIN $info_table ON $cranes_table.id = $info_table.rope_id
                WHERE 1=1 $where";

        return $this->db->query($sql);
    }
}