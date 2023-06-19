<?php

namespace App\Models;

class Cranes_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes_loadtest';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $loadtest_table = $this->db->prefixTable("cranes_loadtest");
        $cranes_table = $this->db->prefixTable("cranes");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $loadtest_table.id = $id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $loadtest_table.client_id = $client_id";
        }

        $sql = "SELECT $loadtest_table.*, $cranes_table.crane, $cranes_table.rope
                FROM $loadtest_table
                LEFT JOIN $cranes_table ON $cranes_table.id = $loadtest_table.rope_id
                WHERE deleted=0 $where
                ORDER BY $loadtest_table.test_date DESC";

        return $this->db->query($sql);
    }
}