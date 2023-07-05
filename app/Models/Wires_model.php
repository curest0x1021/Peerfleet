<?php

namespace App\Models;

class Wires_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $wires_table = $this->db->prefixTable("wires");
        $history_table = $this->db->prefixTable("wires_history");

        // 8 months before exchaning wires
        $reminder_date = get_wire_exchange_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    IF(COUNT($wires_table.id) > 0, 1, 0) as hasCrane,
                    COUNT(DISTINCT($wires_table.crane)) as cranes, COUNT($wires_table.wire) as wires, c.required_exchanges
                FROM $clients_table
                LEFT JOIN $wires_table ON $clients_table.id = $wires_table.client_id
                LEFT JOIN (
                    SELECT $wires_table.client_id, COUNT(a.last_replacement) as required_exchanges
                    FROM (
                        SELECT $history_table.wire_id, MAX($history_table.replacement) as last_replacement
                        FROM $history_table
                        GROUP BY $history_table.wire_id
                    ) a
                    JOIN $wires_table ON $wires_table.id = a.wire_id
                    WHERE Date(a.last_replacement) < '$reminder_date'
                    GROUP BY $wires_table.client_id
                ) c ON $clients_table.id = c.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_cranes_dropdown($client_id) {
        $wires_table = $this->db->prefixTable("wires");

        $sql = "SELECT DISTINCT crane FROM $wires_table WHERE $wires_table.client_id = $client_id";
        $list = $this->db->query($sql)->getResult();

        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->crane] = $item->crane;
        }

        return $dropdown;
    }

    function get_wires_dropdown($client_id, $crane) {
        $wires_table = $this->db->prefixTable("wires");

        $sql = "SELECT id, wire FROM $wires_table WHERE client_id = $client_id AND crane = '$crane'";
        $list = $this->db->query($sql)->getResult();

        $dropdown = array();
        foreach ($list as $item) {
            $dropdown[] = array("id" => $item->id, "text" => $item->wire);
        }

        return $dropdown;
    }
}