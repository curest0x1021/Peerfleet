<?php

namespace App\Models;

class Wires_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_loadtest';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $wires_table = $this->db->prefixTable("wires");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $loadtest_table.id = $id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $loadtest_table.client_id = $client_id";
        }

        $sql = "SELECT $loadtest_table.*, $wires_table.crane, $wires_table.wire
                FROM $loadtest_table
                LEFT JOIN $wires_table ON $wires_table.id = $loadtest_table.wire_id
                WHERE deleted=0 $where
                ORDER BY $loadtest_table.test_date DESC";

        return $this->db->query($sql);
    }
}