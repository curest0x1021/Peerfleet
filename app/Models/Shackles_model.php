<?php

namespace App\Models;

class Shackles_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shackles';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $shackles_table = $this->db->prefixTable("shackles");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name, a.total_items, b.require_loadtests, c.require_inspections
                FROM $clients_table
                LEFT JOIN (SELECT client_id, COUNT(id) as total_items FROM $shackles_table WHERE deleted = 0 GROUP BY client_id) a
                    ON $clients_table.id = a.client_id
                LEFT JOIN (
                    SELECT $shackles_table.client_id, COUNT($shackles_table.id) as require_loadtests
                    FROM $shackles_table
                    JOIN (SELECT shackle_id, MAX(test_date) as test_date FROM $loadtest_table WHERE deleted = 0 AND test_date IS NOT NULL GROUP BY shackle_id) b
                        ON $shackles_table.id = b.shackle_id
                    WHERE b.test_date < '$loadtest_reminder_date'
                    GROUP BY $shackles_table.client_id
                ) b ON $clients_table.id = b.client_id
                LEFT JOIN (
                    SELECT $shackles_table.client_id, COUNT($shackles_table.id) as require_inspections
                    FROM $shackles_table
                    JOIN (SELECT shackle_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 AND inspection_date IS NOT NULL GROUP BY shackle_id) b
                        ON $shackles_table.id = b.shackle_id
                    WHERE b.inspection_date < '$inspection_reminder_date'
                    GROUP BY $shackles_table.client_id
                ) c ON $clients_table.id = c.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_shackles_details($options = array()) {
        $shackles_table = $this->db->prefixTable("shackles");
        $main_table = $this->db->prefixTable("shackles_main");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");
        $inspection_table = $this->db->prefixTable("shackles_inspection");
        $types_table = $this->db->prefixTable("shackle_types");
        $icc_table = $this->db->prefixTable("color_codes");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $certificate_table = $this->db->prefixTable("certificate_types");

        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $shackles_table.id=$id";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $shackles_table.client_id=$client_id";
        }

        $sql = "SELECT $main_table.item_description, $main_table.wll, $main_table.bl, $main_table.iw, $main_table.pd, $main_table.il, $shackles_table.*, $types_table.name as type, $icc_table.name as icc, $certificate_table.name as certificate_type, $manufacturer_table.name as manufacturer, lt.passed as loadtest_passed, it.passed as inspection_passed, it.remarks
                FROM $shackles_table
                JOIN $main_table ON $main_table.id = $shackles_table.main_id
                LEFT JOIN (SELECT a.* FROM $loadtest_table a JOIN (SELECT shackle_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY shackle_id) b ON a.shackle_id = b.shackle_id AND a.test_date = b.test_date) lt
                    ON lt.shackle_id = $shackles_table.id
                LEFT JOIN (SELECT a.* FROM $inspection_table a JOIN (SELECT shackle_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY shackle_id) b ON a.shackle_id = b.shackle_id AND a.inspection_date = b.inspection_date) it
                    ON it.shackle_id = $shackles_table.id
                LEFT JOIN $types_table ON $types_table.id = $main_table.type_id
                LEFT JOIN $icc_table ON $icc_table.id = $shackles_table.icc_id
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $shackles_table.manufacturer_id
                LEFT JOIN $certificate_table ON $certificate_table.id = $shackles_table.certificate_type_id
                WHERE $shackles_table.deleted = 0 $where
                ORDER BY $shackles_table.id ASC";

        return $this->db->query($sql);
    }

    function get_internal_id($client_id, $wll, $type_id) {
        $shackles_table = $this->db->prefixTable("shackles");
        $main_table = $this->db->prefixTable("shackles_main");
        $sql = "SELECT max(internal_id) as internal_id, main_id
                FROM $shackles_table
                WHERE client_id=$client_id AND main_id=(SELECT id FROM $main_table WHERE wll=$wll AND type_id=$type_id)
                GROUP BY $shackles_table.main_id";
        $row = $this->db->query($sql)->getRow();
        if (empty($row->internal_id)) {
            $main_id = $this->get_next_group_id();
            $internal_id = "S-" . $wll . "-0" . $main_id . "-1";
        } else {
            $strs = explode("-", $row->internal_id);
            $newIndex = intval(end($strs)) + 1;
            $internal_id = "S-" . $wll . "-0" . $row->main_id . "-" . $newIndex;
        }
        return $internal_id;
    }

    function get_next_group_id() {
        $main_table = $this->db->prefixTable("shackles_main");
        $sql = "SELECT MAX(id) as id FROM $main_table";
        $row = $this->db->query($sql)->getRow();
        if (empty($row->id)) {
            return 1;
        } else {
            return intval($row->id) + 1;
        }
    }

    // get id, internal_id only
    function get_data($client_id) {
        $shackles_table = $this->db->prefixTable("shackles");
        $sql = "SELECT id, internal_id FROM $shackles_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    // get required loadtest reminder items
    function get_required_loadtest_items() {
        $shackles_table = $this->db->prefixTable("shackles");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");

        $reminder_date = get_loadtest_reminder_date();

        $sql = "SELECT $shackles_table.id as shackle_id, $shackles_table.client_id, a.test_date
                FROM (
                    SELECT shackle_id, MAX(test_date) as test_date
                    FROM $loadtest_table
                    WHERE deleted = 0 AND test_date IS NOT NULL
                    GROUP BY shackle_id
                ) a
                JOIN $shackles_table ON $shackles_table.id = a.shackle_id
                WHERE Date(a.test_date) < '$reminder_date'";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    // get required visual inspection reminder items
    function get_required_visual_inspection_items() {
        $shackles_table = $this->db->prefixTable("shackles");
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT $shackles_table.id as shackle_id, $shackles_table.client_id, a.inspection_date
                FROM (
                    SELECT shackle_id, MAX(inspection_date) as inspection_date
                    FROM $inspection_table
                    WHERE deleted = 0 AND inspection_date IS NOT NULL
                    GROUP BY shackle_id
                ) a
                JOIN $shackles_table ON $shackles_table.id = a.shackle_id
                WHERE Date(a.inspection_date) < '$reminder_date'";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    function get_loadtest_info($shackle_id) {
        $shackles_table = $this->db->prefixTable("shackles");
        $main_table = $this->db->prefixTable("shackles_main");
        $clients_table = $this->db->prefixTable("clients");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.internal_id, ' (', $main_table.item_description, ')') as name, MAX(b.test_date) as last_test_date
                FROM (SELECT * FROM $shackles_table WHERE id = $shackle_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                JOIN $main_table ON $main_table.id = a.main_id
                LEFT JOIN (SELECT * FROM $loadtest_table WHERE deleted=0 AND shackle_id = $shackle_id AND test_date IS NOT NULL) b
                    ON a.id = b.shackle_id";

        $row = $this->db->query($sql)->getRow();
        // Loadtest: 5 years
        $row->due_date = date("Y-m-d", strtotime($row->last_test_date . ' + 5 years'));
        return $row;
    }

    function get_inspection_info($shackle_id) {
        $shackles_table = $this->db->prefixTable("shackles");
        $main_table = $this->db->prefixTable("shackles_main");
        $clients_table = $this->db->prefixTable("clients");
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, CONCAT(a.internal_id, ' (', $main_table.item_description, ')') as name, MAX(b.inspection_date) as last_inspection_date
                FROM (SELECT * FROM $shackles_table WHERE id = $shackle_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                JOIN $main_table ON $main_table.id = a.main_id
                LEFT JOIN (SELECT * FROM $inspection_table WHERE deleted=0 AND shackle_id = $shackle_id AND inspection_date IS NOT NULL) b
                    ON a.id = b.shackle_id";

        $row = $this->db->query($sql)->getRow();
        // Visual inspection: 12 months
        $row->due_date = date("Y-m-d", strtotime($row->last_inspection_date . ' + 12 months'));
        return $row;
    }

}