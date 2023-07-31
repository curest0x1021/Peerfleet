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

    function get_warnning_info($client_id) {
        $wires_table = $this->db->prefixTable("wires");
        $history_table = $this->db->prefixTable("wires_history");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $wire_exchange_date = get_wire_exchange_reminder_date();
        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT a.client_id, (a.total_wires - IFNULL(k1.passed, 0)) as require_exchanges,
                    (a.total_wires - IFNULL(k2.passed, 0)) as require_loadtests, (a.total_wires - IFNULL(k3.passed, 0)) as require_inspections
                FROM (SELECT client_id, COUNT(id) as total_wires FROM $wires_table WHERE deleted = 0 AND client_id = $client_id GROUP BY client_id) a
                LEFT JOIN (
                    SELECT bb.client_id, SUM(bb.passed) as passed
                    FROM (
                        SELECT $history_table.wire_id, $history_table.client_id, IF(b.replacement > '$wire_exchange_date', 1, 0) as passed
                        FROM $history_table
                        JOIN (SELECT wire_id, MAX(replacement) as replacement FROM $history_table WHERE client_id = $client_id GROUP BY wire_id) b
                        ON $history_table.wire_id = b.wire_id AND $history_table.replacement = b.replacement
                        WHERE $history_table.client_id = $client_id ) bb
                    GROUP BY bb.client_id
                ) k1 ON a.client_id = k1.client_id
                LEFT JOIN (
                    SELECT cc.client_id, SUM(cc.passed) as passed
                    FROM (
                        SELECT $loadtest_table.wire_id, $loadtest_table.client_id,
                            IF($loadtest_table.test_date > '$loadtest_reminder_date' AND $loadtest_table.passed = 1, 1, 0) as passed
                        FROM $loadtest_table
                        JOIN (SELECT wire_id, MAX(test_date) as test_date FROM $loadtest_table WHERE client_id = $client_id GROUP BY wire_id) c
                        ON $loadtest_table.wire_id = c.wire_id AND $loadtest_table.test_date = c.test_date
                        WHERE $loadtest_table.client_id = $client_id ) cc
                    GROUP BY cc.client_id
                ) k2 ON a.client_id = k2.client_id
                LEFT JOIN (
                    SELECT dd.client_id, SUM(dd.passed) as passed
                    FROM (
                        SELECT $inspection_table.wire_id, $inspection_table.client_id,
                            IF($inspection_table.inspection_date > '$inspection_reminder_date' AND $inspection_table.passed = 1, 1, 0) as passed
                        FROM $inspection_table
                        JOIN (SELECT wire_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE client_id = $client_id GROUP BY wire_id) d
                        ON $inspection_table.wire_id = d.wire_id AND $inspection_table.inspection_date = d.inspection_date
                        WHERE $inspection_table.client_id = $client_id ) dd
                    GROUP BY dd.client_id
                ) k3 ON a.client_id = k3.client_id";

        return $this->db->query($sql)->getRow();
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