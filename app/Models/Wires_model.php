<?php

namespace App\Models;

class Wires_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires';
        parent::__construct($this->table);
    }

    function get_one($id = 0) {
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");

        $sql = "SELECT $wires_table.*, CONCAT($equipments_table.name, ' - ', $type_table.name) as name
        FROM $wires_table
        LEFT JOIN $type_table ON $wires_table.wire_type = $type_table.id
        LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
        WHERE $wires_table.deleted = 0 AND $wires_table.id = $id";
        return $this->db->query($sql)->getRow();
    }
    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");
        $history_table = $this->db->prefixTable("wires_history");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $wire_exchange_date = get_wire_exchange_reminder_date();
        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    IFNULL(k0.equipments, 0) as equipments, IFNULL(k0.wires, 0) as wires,
                    (IFNULL(k0.wires, 0) - IFNULL(k1.passed, 0)) as required_exchanges,
                    (IFNULL(k0.wires, 0) - IFNULL(k2.passed, 0)) as required_loadtests,
                    (IFNULL(k0.wires, 0) - IFNULL(k3.passed, 0)) as required_inspections
                FROM $clients_table
                LEFT JOIN (
                    SELECT client_id, COUNT(DISTINCT(equipment)) as equipments, COUNT(wire_type) as wires
                    FROM $wires_table
                    WHERE deleted = 0
                    GROUP BY client_id
                ) k0 ON $clients_table.id = k0.client_id
                LEFT JOIN (
                    SELECT bb.client_id, SUM(bb.passed) as passed
                    FROM (
                        SELECT $history_table.wire_id, $history_table.client_id, IF(b.replacement > '$wire_exchange_date', 1, 0) as passed
                        FROM $history_table
                        JOIN (SELECT wire_id, MAX(replacement) as replacement FROM $history_table GROUP BY wire_id) b
                        ON $history_table.wire_id = b.wire_id AND $history_table.replacement = b.replacement ) bb
                    GROUP BY bb.client_id
                ) k1 ON $clients_table.id = k1.client_id
                LEFT JOIN (
                    SELECT cc.client_id, SUM(cc.passed) as passed
                    FROM (
                        SELECT $loadtest_table.wire_id, $loadtest_table.client_id,
                            IF($loadtest_table.test_date > '$loadtest_reminder_date' AND $loadtest_table.passed = 1, 1, 0) as passed
                        FROM $loadtest_table
                        JOIN (SELECT wire_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY wire_id) c
                        ON $loadtest_table.wire_id = c.wire_id AND $loadtest_table.test_date = c.test_date ) cc
                    GROUP BY cc.client_id
                ) k2 ON $clients_table.id = k2.client_id
                LEFT JOIN (
                    SELECT dd.client_id, SUM(dd.passed) as passed
                    FROM (
                        SELECT $inspection_table.wire_id, $inspection_table.client_id,
                            IF($inspection_table.inspection_date > '$inspection_reminder_date' AND $inspection_table.passed = 1, 1, 0) as passed
                        FROM $inspection_table
                        JOIN (SELECT wire_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY wire_id) d
                        ON $inspection_table.wire_id = d.wire_id AND $inspection_table.inspection_date = d.inspection_date ) dd
                    GROUP BY dd.client_id
                ) k3 ON $clients_table.id = k3.client_id
                WHERE $clients_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

    function get_summary_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");
        $history_table = $this->db->prefixTable("wires_history");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $wire_exchange_date = get_wire_exchange_reminder_date();
        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
       
        $sql = "SELECT client_id, equipment, COUNT(wire_type) as wires, $equipments_table.name as equipment_name
                    FROM $wires_table
                    LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
                    WHERE $wires_table.deleted = 0 AND $wires_table.client_id = $client_id
                    GROUP BY equipment";

        return $this->db->query($sql);
    }

    function get_next_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");
        $history_table = $this->db->prefixTable("wires_history");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $wire_exchange_date = get_wire_exchange_reminder_date();
        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
       
        $sql = "SELECT $wires_table.id as id, equipment, $equipments_table.name as equipment_name, k1.test_date, k.inspection_date
        FROM $wires_table
        LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
        LEFT JOIN (
            SELECT $loadtest_table.*
            FROM $loadtest_table
            JOIN (SELECT wire_id as k1_wire_id, MAX(test_date) as test_date FROM $loadtest_table WHERE client_id=$client_id GROUP BY k1_wire_id) a
            ON $loadtest_table.wire_id = a.k1_wire_id AND $loadtest_table.test_date = a.test_date
            WHERE $loadtest_table.deleted = 0 AND $loadtest_table.client_id = $client_id
        ) k1 ON $wires_table.id = k1.wire_id
        LEFT JOIN (
            SELECT $inspection_table.*
            FROM $inspection_table
            JOIN (SELECT wire_id as k_wire_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE client_id=$client_id GROUP BY k_wire_id) a
            ON $inspection_table.wire_id = a.k_wire_id AND $inspection_table.inspection_date = a.inspection_date
            WHERE $inspection_table.deleted = 0 AND $inspection_table.client_id = $client_id
        ) k ON $wires_table.id = k.wire_id
        WHERE $wires_table.deleted = 0 AND $wires_table.client_id = $client_id
        GROUP BY $wires_table.id";

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

    // get required loadtest reminder items
    function get_required_loadtest_items() {
        $wires_table = $this->db->prefixTable("wires");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");

        $reminder_date = get_loadtest_reminder_date();

        $sql = "SELECT $wires_table.id as wire_id, $wires_table.client_id, aa.test_date
                FROM (
                    SELECT $loadtest_table.* FROM $loadtest_table
                    JOIN (
                        SELECT wire_id, MAX(test_date) as test_date
                        FROM $loadtest_table
                        WHERE deleted = 0
                        GROUP BY wire_id
                    ) a ON $loadtest_table.wire_id = a.wire_id AND $loadtest_table.test_date = a.test_date
                    WHERE $loadtest_table.test_date < '$reminder_date' OR $loadtest_table.passed = 0 ) aa
                JOIN $wires_table ON $wires_table.id = aa.wire_id
                WHERE $wires_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    // get required visual inspection reminder items
    function get_required_visual_inspection_items() {
        $wires_table = $this->db->prefixTable("wires");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT $wires_table.id as wire_id, $wires_table.client_id, aa.inspection_date
                FROM (
                    SELECT $inspection_table.* FROM $inspection_table
                    JOIN (
                        SELECT wire_id, MAX(inspection_date) as inspection_date
                        FROM $inspection_table
                        WHERE deleted = 0
                        GROUP BY wire_id
                    ) a ON $inspection_table.wire_id = a.wire_id AND $inspection_table.inspection_date = a.inspection_date
                    WHERE $inspection_table.inspection_date < '$reminder_date' OR $inspection_table.passed = 0 ) aa
                JOIN $wires_table ON $wires_table.id = aa.wire_id
                WHERE $wires_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    function get_loadtest_info($wire_id) {
        $wires_table = $this->db->prefixTable("wires");
        $clients_table = $this->db->prefixTable("clients");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.crane, ' - ', a.wire) as name, MAX(b.test_date) as last_test_date
                FROM (SELECT * FROM $wires_table WHERE id = $wire_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                LEFT JOIN (SELECT * FROM $loadtest_table WHERE deleted=0 AND wire_id = $wire_id AND test_date IS NOT NULL) b
                    ON a.id = b.wire_id";

        $row = $this->db->query($sql)->getRow();
        // Loadtest: 5 years
        $row->due_date = date("Y-m-d", strtotime($row->last_test_date . ' + 5 years'));
        return $row;
    }

    function get_inspection_info($wire_id) {
        $wires_table = $this->db->prefixTable("wires");
        $clients_table = $this->db->prefixTable("clients");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.crane, ' - ', a.wire) as name, MAX(b.inspection_date) as last_inspection_date
                FROM (SELECT * FROM $wires_table WHERE id = $wire_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                LEFT JOIN (SELECT * FROM $inspection_table WHERE deleted=0 AND wire_id = $wire_id AND inspection_date IS NOT NULL) b
                    ON a.id = b.wire_id";

        $row = $this->db->query($sql)->getRow();
        // Visual inspection: 12 months
        $row->due_date = date("Y-m-d", strtotime($row->last_inspection_date . ' + 12 months'));
        return $row;
    }
}