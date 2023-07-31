<?php

namespace App\Models;

class Grommets_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'grommets';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $grommets_table = $this->db->prefixTable("grommets");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name, a.total_items,
                    (a.total_items - IFNULL(b.passed, 0)) as require_loadtests,
                    (a.total_items - IFNULL(c.passed, 0)) as require_inspections
                FROM $clients_table
                LEFT JOIN (SELECT client_id, COUNT(id) as total_items FROM $grommets_table WHERE deleted = 0 GROUP BY client_id) a
                    ON $clients_table.id = a.client_id
                LEFT JOIN (
                    SELECT $grommets_table.client_id, SUM(bb.passed) as passed
                    FROM $grommets_table
                    JOIN (SELECT $loadtest_table.grommet_id, IF(($loadtest_table.passed = 1 AND $loadtest_table.test_date > '$loadtest_reminder_date'), 1, 0) as passed FROM $loadtest_table
                        JOIN (SELECT grommet_id, MAX(test_date) as test_date FROM $loadtest_table WHERE deleted = 0 GROUP BY grommet_id) b
                        ON $loadtest_table.grommet_id = b.grommet_id AND $loadtest_table.test_date = b.test_date) bb
                    ON $grommets_table.id = bb.grommet_id
                    WHERE $grommets_table.deleted = 0
                    GROUP BY $grommets_table.client_id
                ) b ON $clients_table.id = b.client_id
                LEFT JOIN (
                    SELECT $grommets_table.client_id, SUM(bb.passed) as passed
                    FROM $grommets_table
                    JOIN (SELECT $inspection_table.grommet_id, IF(($inspection_table.passed = 1 AND $inspection_table.inspection_date > '$inspection_reminder_date'), 1, 0) as passed FROM $inspection_table
                        JOIN (SELECT grommet_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 GROUP BY grommet_id) b
                        ON $inspection_table.grommet_id = b.grommet_id AND $inspection_table.inspection_date = b.inspection_date) bb
                    ON $grommets_table.id = bb.grommet_id
                    WHERE $grommets_table.deleted = 0
                    GROUP BY $grommets_table.client_id
                ) c ON $clients_table.id = c.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_warnning_info($client_id, $main_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT (a.total_items - IFNULL(b.passed, 0)) as require_loadtests, (a.total_items - IFNULL(c.passed, 0)) as require_inspections
                FROM (SELECT main_id, COUNT(id) as total_items FROM $grommets_table WHERE deleted = 0 AND client_id = $client_id and main_id = $main_id GROUP BY main_id) a
                LEFT JOIN (
                    SELECT $grommets_table.main_id, SUM(bb.passed) as passed
                    FROM $grommets_table
                    JOIN (SELECT $loadtest_table.grommet_id, IF(($loadtest_table.passed = 1 AND $loadtest_table.test_date > '$loadtest_reminder_date'), 1, 0) as passed FROM $loadtest_table
                        JOIN (SELECT grommet_id, MAX(test_date) as test_date FROM $loadtest_table WHERE deleted = 0 GROUP BY grommet_id) b
                        ON $loadtest_table.grommet_id = b.grommet_id AND $loadtest_table.test_date = b.test_date) bb
                    ON $grommets_table.id = bb.grommet_id
                    WHERE $grommets_table.deleted = 0 AND $grommets_table.client_id = $client_id AND $grommets_table.main_id = $main_id
                    GROUP BY $grommets_table.main_id
                ) b ON a.main_id = b.main_id
                LEFT JOIN (
                    SELECT $grommets_table.main_id, SUM(bb.passed) as passed
                    FROM $grommets_table
                    JOIN (SELECT $inspection_table.grommet_id, IF(($inspection_table.passed = 1 AND $inspection_table.inspection_date > '$inspection_reminder_date'), 1, 0) as passed FROM $inspection_table
                        JOIN (SELECT grommet_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 GROUP BY grommet_id) b
                        ON $inspection_table.grommet_id = b.grommet_id AND $inspection_table.inspection_date = b.inspection_date) bb
                    ON $grommets_table.id = bb.grommet_id
                    WHERE $grommets_table.deleted = 0 AND $grommets_table.client_id = $client_id AND $grommets_table.main_id = $main_id
                    GROUP BY $grommets_table.main_id
                ) c ON a.main_id = c.main_id";

        return $this->db->query($sql)->getRow();
    }

    function get_grommets_details($options = array()) {
        $grommets_table = $this->db->prefixTable("grommets");
        $main_table = $this->db->prefixTable("grommets_main");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");
        $inspection_table = $this->db->prefixTable("grommets_inspection");
        $icc_table = $this->db->prefixTable("color_codes");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $certificate_table = $this->db->prefixTable("certificate_types");
        $types_table = $this->db->prefixTable("grommet_types");

        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $grommets_table.id=$id";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $grommets_table.client_id=$client_id";
        }

        $main_id = $this->_get_clean_value($options, "main_id");
        if ($main_id) {
            $where .= " AND $grommets_table.main_id=$main_id";
        }

        $sql = "SELECT $main_table.item_description, $main_table.wll, $main_table.wl, $main_table.dia, $main_table.bl, $types_table.name as type,
                    $grommets_table.*, $icc_table.name as icc, $certificate_table.name as certificate_type, $manufacturer_table.name as manufacturer,
                    lt.passed as loadtest_passed, lt.test_date as test_date, it.passed as inspection_passed, it.inspection_date as inspection_date, it.remarks
                FROM $grommets_table
                JOIN $main_table ON $main_table.id = $grommets_table.main_id
                LEFT JOIN (SELECT a.* FROM $loadtest_table a JOIN (SELECT grommet_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.test_date = b.test_date) lt
                    ON lt.grommet_id = $grommets_table.id
                LEFT JOIN (SELECT a.* FROM $inspection_table a JOIN (SELECT grommet_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.inspection_date = b.inspection_date) it
                    ON it.grommet_id = $grommets_table.id
                LEFT JOIN $types_table ON $types_table.id = $main_table.type_id
                LEFT JOIN $icc_table ON $icc_table.id = $grommets_table.icc_id
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $grommets_table.manufacturer_id
                LEFT JOIN $certificate_table ON $certificate_table.id = $grommets_table.certificate_type_id
                WHERE $grommets_table.deleted = 0 $where
                ORDER BY $grommets_table.id ASC";

        return $this->db->query($sql);
    }

    function get_internal_id($client_id, $wll, $wl) {
        $grommets_table = $this->db->prefixTable("grommets");
        $main_table = $this->db->prefixTable("grommets_main");
        $sql = "SELECT max(internal_id) as internal_id
                FROM $grommets_table
                WHERE client_id=$client_id AND main_id=(SELECT id FROM $main_table WHERE wll=$wll AND wl=$wl)
                GROUP BY main_id";
        $result = $this->db->query($sql)->getRow();
        if (empty($result->internal_id)) {
            $internal_id = "G-" . $wll . "-" . $wl * 10 . "-1";
        } else {
            $strs = explode("-", $result->internal_id);
            $newIndex = intval(end($strs)) + 1;
            $internal_id = "G-" . $wll . "-" . $wl * 10 . "-" . $newIndex;
        }
        return $internal_id;
    }

    function get_next_internal_id($client_id, $main_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $sql = "SELECT max(internal_id) as internal_id
                FROM $grommets_table
                WHERE client_id = $client_id AND main_id = $main_id
                GROUP BY main_id";
        $result = $this->db->query($sql)->getRow();
        $strs = explode("-", $result->internal_id);
        $newIndex = intval(end($strs)) + 1;
        $strs[count($strs) - 1] = $newIndex;
        return implode("-", $strs);
    }

    // get id, internal_id only
    function get_data($client_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $sql = "SELECT id, internal_id FROM $grommets_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    // get required loadtest reminder items
    function get_required_loadtest_items() {
        $grommets_table = $this->db->prefixTable("grommets");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");

        $reminder_date = get_loadtest_reminder_date();

        $sql = "SELECT $grommets_table.id as grommet_id, $grommets_table.client_id, aa.test_date
                FROM (
                    SELECT $loadtest_table.* FROM $loadtest_table
                    JOIN (
                        SELECT grommet_id, MAX(test_date) as test_date
                        FROM $loadtest_table
                        WHERE deleted = 0
                        GROUP BY grommet_id
                    ) a ON $loadtest_table.grommet_id = a.grommet_id AND $loadtest_table.test_date = a.test_date
                    WHERE $loadtest_table.test_date < '$reminder_date' OR $loadtest_table.passed = 0 ) aa
                JOIN $grommets_table ON $grommets_table.id = aa.grommet_id
                WHERE $grommets_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    // get required visual inspection reminder items
    function get_required_visual_inspection_items() {
        $grommets_table = $this->db->prefixTable("grommets");
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT $grommets_table.id as grommet_id, $grommets_table.client_id, aa.inspection_date
                FROM (
                    SELECT $inspection_table.* FROM $inspection_table
                    JOIN (
                        SELECT grommet_id, MAX(inspection_date) as inspection_date
                        FROM $inspection_table
                        WHERE deleted = 0
                        GROUP BY grommet_id
                    ) a ON $inspection_table.grommet_id = a.grommet_id AND $inspection_table.inspection_date = a.inspection_date
                    WHERE $inspection_table.inspection_date < '$reminder_date' OR $inspection_table.passed = 0 ) aa
                JOIN $grommets_table ON $grommets_table.id = aa.grommet_id
                WHERE $grommets_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    function get_loadtest_info($grommet_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $main_table = $this->db->prefixTable("grommets_main");
        $clients_table = $this->db->prefixTable("clients");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.internal_id, ' (', $main_table.item_description, ')') as name, MAX(b.test_date) as last_test_date
                FROM (SELECT * FROM $grommets_table WHERE id = $grommet_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                JOIN $main_table ON $main_table.id = a.main_id
                LEFT JOIN (SELECT * FROM $loadtest_table WHERE deleted=0 AND grommet_id = $grommet_id AND test_date IS NOT NULL) b
                    ON a.id = b.grommet_id";

        $row = $this->db->query($sql)->getRow();
        // Loadtest: 5 years
        $row->due_date = date("Y-m-d", strtotime($row->last_test_date . ' + 5 years'));
        return $row;
    }

    function get_inspection_info($grommet_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $main_table = $this->db->prefixTable("grommets_main");
        $clients_table = $this->db->prefixTable("clients");
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.internal_id, ' (', $main_table.item_description, ')') as name, MAX(b.inspection_date) as last_inspection_date
                FROM (SELECT * FROM $grommets_table WHERE id = $grommet_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                JOIN $main_table ON $main_table.id = a.main_id
                LEFT JOIN (SELECT * FROM $inspection_table WHERE deleted=0 AND grommet_id = $grommet_id AND inspection_date IS NOT NULL) b
                    ON a.id = b.grommet_id";

        $row = $this->db->query($sql)->getRow();
        // Visual inspection: 12 months
        $row->due_date = date("Y-m-d", strtotime($row->last_inspection_date . ' + 12 months'));
        return $row;
    }
}