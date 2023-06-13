<?php

namespace App\Models;

class Cranes_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $cranes_table = $this->db->prefixTable("cranes");

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    IF(COUNT($cranes_table.id) > 0, 1, 0) as hasCrane,
                    COUNT(DISTINCT($cranes_table.crane)) as cranes, COUNT($cranes_table.rope) as ropes
                FROM $clients_table
                LEFT JOIN $cranes_table ON $clients_table.id = $cranes_table.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }
}