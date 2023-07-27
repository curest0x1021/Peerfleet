<?php

namespace App\Models;

class Wires_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $inspection_table = $this->db->prefixTable("wires_inspection");
        $wires_table = $this->db->prefixTable("wires");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $inspection_table.id = $id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $inspection_table.client_id = $client_id";
        }

        $sql = "SELECT $inspection_table.*, $wires_table.crane, $wires_table.wire
                FROM $inspection_table
                LEFT JOIN $wires_table ON $wires_table.id = $inspection_table.wire_id
                WHERE $inspection_table.deleted=0 $where
                ORDER BY $inspection_table.inspection_date DESC";

        return $this->db->query($sql);
    }
}