<?php

namespace App\Models;

class Wires_history_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_history';
        parent::__construct($this->table);
    }

    function get_details($client_id) {
        $wires_table = $this->db->prefixTable("wires");
        $history_table = $this->db->prefixTable("wires_history");

        $sql = "SELECT id as wire_id, client_id, CONCAT(crane, ' ', wire) as name
                FROM $wires_table
                WHERE client_id = $client_id
                ORDER BY id ASC";
        $wires = $this->db->query($sql)->getResult();

        $sql1 = "SELECT * FROM $history_table WHERE client_id = $client_id ORDER BY wire_id ASC, replacement ASC";
        $history_data = $this->db->query($sql1)->getResult();

        // 8 months before exchaning wires
        $reminder_date = get_wire_exchange_reminder_date();
        $result = array();
        foreach ($wires as $item) {
            $history = array_filter($history_data, function($k) use($item) { return $k->wire_id == $item->wire_id; });
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

    function get_wire_history($wire_id) {
        $wires_table = $this->db->prefixTable("wires");
        $clients_table = $this->db->prefixTable("clients");
        $history_table = $this->db->prefixTable("wires_history");

        $sql = "SELECT $wires_table.id as wire_id, $wires_table.client_id, CONCAT($wires_table.crane, ' ', $wires_table.wire) as name, $clients_table.charter_name as vessel, MAX($history_table.replacement) as last_replacement
                FROM $wires_table
                JOIN $clients_table ON $clients_table.id = $wires_table.client_id
                LEFT JOIN $history_table ON $wires_table.id = $history_table.wire_id
                WHERE $wires_table.id = $wire_id";
        $wire = $this->db->query($sql)->getRow();

        // The default for the replacement of crane wires is 8 years
        $wire->due_date = date("Y-m-d", strtotime($wire->last_replacement, ' + 8 years'));
        return $wire;
    }

    function get_required_exchange_wires() {
        $wires_table = $this->db->prefixTable("wires");
        $history_table = $this->db->prefixTable("wires_history");

        // 8 months before exchaning wires
        $reminder_date = get_wire_exchange_reminder_date();

        $sql = "SELECT $wires_table.id as crane_id, $wires_table.client_id, a.last_replacement
                FROM (
                    SELECT $history_table.wire_id, $history_table.client_id, MAX($history_table.replacement) as last_replacement
                    FROM $history_table
                    GROUP BY $history_table.wire_id
                ) a
                JOIN $wires_table ON $wires_table.id = a.wire_id
                WHERE Date(a.last_replacement) < '$reminder_date'";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }
}