<?php

namespace App\Models;

class Cranes_history_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes_history';
        parent::__construct($this->table);
    }

    function get_details($client_id) {
        $cranes_table = $this->db->prefixTable("cranes");
        $history_table = $this->db->prefixTable("cranes_history");

        $sql = "SELECT id as rope_id, client_id, CONCAT(crane, ' ', rope) as name
                FROM $cranes_table
                WHERE client_id = $client_id
                ORDER BY id ASC";
        $ropes = $this->db->query($sql)->getResult();

        $sql1 = "SELECT * FROM $history_table WHERE client_id = $client_id ORDER BY rope_id ASC, replacement ASC";
        $history_data = $this->db->query($sql1)->getResult();

        // 8 months before exchaning ropes
        $reminder_date = get_rope_exchange_reminder_date();
        $result = array();
        foreach ($ropes as $item) {
            $history = array_filter($history_data, function($k) use($item) { return $k->rope_id == $item->rope_id; });
            $item->required_exchanges = false;
            if (count($history) > 0) {
                $item->required_exchanges = end($history)->replacement < $reminder_date;
            }
            $item->initial = count($history) > 0 ? array_values($history)[0]->replacement : null;
            $item->first = count($history) > 1 ? array_values($history)[1]->replacement : null;
            $item->second = count($history) > 2 ? array_values($history)[2]->replacement : null;
            $item->third = count($history) > 3 ? array_values($history)[3]->replacement : null;
            $item->forth = count($history) > 4 ? array_values($history)[4]->replacement : null;
            $item->fifth = count($history) > 5 ? array_values($history)[5]->replacement : null;
            $result[] = $item;
        }

        return $result;
    }

    function get_crane_history($rope_id) {
        $cranes_table = $this->db->prefixTable("cranes");
        $clients_table = $this->db->prefixTable("clients");
        $history_table = $this->db->prefixTable("cranes_history");

        $sql = "SELECT $cranes_table.id as rope_id, $cranes_table.client_id, CONCAT($cranes_table.crane, ' ', $cranes_table.rope) as name, $clients_table.charter_name as vessel, MAX($history_table.replacement) as last_replacement
                FROM $cranes_table
                JOIN $clients_table ON $clients_table.id = $cranes_table.client_id
                LEFT JOIN $history_table ON $cranes_table.id = $history_table.rope_id
                WHERE $cranes_table.id = $rope_id";
        $rope = $this->db->query($sql)->getRow();

        // The default for the replacement of crane ropes is 8 years
        $rope->due_date = date("Y-m-d", strtotime($rope->last_replacement, ' + 8 years'));
        return $rope;
    }

    function get_required_exchange_ropes() {
        $cranes_table = $this->db->prefixTable("cranes");
        $history_table = $this->db->prefixTable("cranes_history");

        // 8 months before exchaning ropes
        $reminder_date = get_rope_exchange_reminder_date();

        $sql = "SELECT $cranes_table.id as crane_id, $cranes_table.client_id, a.last_replacement
                FROM (
                    SELECT $history_table.rope_id, $history_table.client_id, MAX($history_table.replacement) as last_replacement
                    FROM $history_table
                    GROUP BY $history_table.rope_id
                ) a
                JOIN $cranes_table ON $cranes_table.id = a.rope_id
                WHERE Date(a.last_replacement) < '$reminder_date'";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }
}