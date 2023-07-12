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

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    COUNT($shackles_table.id) as total_items
                FROM $clients_table
                LEFT JOIN $shackles_table ON $clients_table.id = $shackles_table.client_id AND $shackles_table.deleted = 0
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

}