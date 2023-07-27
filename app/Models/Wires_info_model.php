<?php

namespace App\Models;

class Wires_info_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_info';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $info_table = $this->db->prefixTable("wires_info");
        $wires_table = $this->db->prefixTable("wires");

        $where = "";
        $wire_id = $this->_get_clean_value($options, "wire_id");
        if ($wire_id) {
            $where .= " AND $wires_table.id = $wire_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $wires_table.client_id = $client_id";
        }

        $sql = "SELECT $wires_table.id as wire_id, $wires_table.client_id, $wires_table.crane, $wires_table.wire, $info_table.id, $info_table.diameter, $info_table.length, $info_table.swl
                FROM $wires_table
                LEFT JOIN $info_table ON $wires_table.id = $info_table.wire_id
                WHERE $wires_table.deleted = 0 $where";

        return $this->db->query($sql);
    }
}