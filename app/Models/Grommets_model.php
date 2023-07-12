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

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    COUNT($grommets_table.id) as total_items
                FROM $clients_table
                LEFT JOIN $grommets_table ON $clients_table.id = $grommets_table.client_id AND $grommets_table.deleted = 0
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_grommets_details($options = array()) {
        $grommets_table = $this->db->prefixTable("grommets");
        $main_table = $this->db->prefixTable("grommets_main");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");
        $inspection_table = $this->db->prefixTable("grommets_inspection");
        $icc_table = $this->db->prefixTable("color_codes");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $certificate_table = $this->db->prefixTable("certificate_types");

        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $grommets_table.id=$id";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $grommets_table.client_id=$client_id";
        }

        $sql = "SELECT $main_table.item_description, $main_table.wll, $main_table.wl, $main_table.dia, $main_table.bl, $grommets_table.*, $icc_table.name as icc, $certificate_table.name as certificate_type, $manufacturer_table.name as manufacturer, lt.passed as loadtest_passed, it.passed as inspection_passed, it.remarks
                FROM $grommets_table
                JOIN $main_table ON $main_table.id = $grommets_table.main_id
                LEFT JOIN (SELECT a.* FROM $loadtest_table a JOIN (SELECT grommet_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.test_date = b.test_date) lt
                    ON lt.grommet_id = $grommets_table.id
                LEFT JOIN (SELECT a.* FROM $inspection_table a JOIN (SELECT grommet_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.inspection_date = b.inspection_date) it
                    ON it.grommet_id = $grommets_table.id
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
                GROUP BY $grommets_table.main_id";
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

    // get id, internal_id only
    function get_data($client_id) {
        $grommets_table = $this->db->prefixTable("grommets");
        $sql = "SELECT id, internal_id FROM $grommets_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

}