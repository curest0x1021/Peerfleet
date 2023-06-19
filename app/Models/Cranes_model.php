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
        $history_table = $this->db->prefixTable("cranes_history");

        // 8 months before exchaning ropes
        $reminder_date = get_rope_exchange_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    IF(COUNT($cranes_table.id) > 0, 1, 0) as hasCrane,
                    COUNT(DISTINCT($cranes_table.crane)) as cranes, COUNT($cranes_table.rope) as ropes, c.required_exchanges
                FROM $clients_table
                LEFT JOIN $cranes_table ON $clients_table.id = $cranes_table.client_id
                LEFT JOIN (
                    SELECT $cranes_table.client_id, COUNT(a.last_replacement) as required_exchanges
                    FROM (
                        SELECT $history_table.rope_id, MAX($history_table.replacement) as last_replacement
                        FROM $history_table
                        GROUP BY $history_table.rope_id
                    ) a
                    JOIN $cranes_table ON $cranes_table.id = a.rope_id
                    WHERE Date(a.last_replacement) < '$reminder_date'
                    GROUP BY $cranes_table.client_id
                ) c ON $clients_table.id = c.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_cranes_dropdown($client_id) {
        $cranes_table = $this->db->prefixTable("cranes");

        $sql = "SELECT DISTINCT crane FROM $cranes_table WHERE $cranes_table.client_id = $client_id";
        $list = $this->db->query($sql)->getResult();

        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->crane] = $item->crane;
        }

        return $dropdown;
    }

    function get_ropes_dropdown($client_id, $crane) {
        $cranes_table = $this->db->prefixTable("cranes");

        $sql = "SELECT id, rope FROM $cranes_table WHERE client_id = $client_id AND crane = '$crane'";
        $list = $this->db->query($sql)->getResult();

        $dropdown = array();
        foreach ($list as $item) {
            $dropdown[] = array("id" => $item->id, "text" => $item->rope);
        }

        return $dropdown;
    }
}