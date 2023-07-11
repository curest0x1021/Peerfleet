<?php

namespace App\Models;

class Misc_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'misc';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $misc_table = $this->db->prefixTable("misc");

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    COUNT($misc_table.id) as total_items
                FROM $clients_table
                LEFT JOIN $misc_table ON $clients_table.id = $misc_table.client_id AND $misc_table.deleted = 0
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_misc_details($options = array()) {
        $misc_table = $this->db->prefixTable("misc");
        $loadtest_table = $this->db->prefixTable("misc_loadtest");
        $inspection_table = $this->db->prefixTable("misc_inspection");
        $icc_table = $this->db->prefixTable("color_codes");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $certificate_table = $this->db->prefixTable("certificate_types");
        $types_table = $this->db->prefixTable("misc_types");

        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $misc_table.id=$id";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $misc_table.client_id=$client_id";
        }

        $sql = "SELECT $misc_table.*, $types_table.name as type, $icc_table.name as icc, $certificate_table.name as certificate_type, $manufacturer_table.name as manufacturer, lt.passed as loadtest_passed, it.passed as inspection_passed, it.remarks
                FROM $misc_table
                LEFT JOIN (SELECT a.* FROM $loadtest_table a JOIN (SELECT misc_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY misc_id) b ON a.misc_id = b.misc_id AND a.test_date = b.test_date) lt
                    ON lt.misc_id = $misc_table.id
                LEFT JOIN (SELECT a.* FROM $inspection_table a JOIN (SELECT misc_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY misc_id) b ON a.misc_id = b.misc_id AND a.inspection_date = b.inspection_date) it
                    ON it.misc_id = $misc_table.id
                LEFT JOIN $types_table ON $types_table.id = $misc_table.type_id
                LEFT JOIN $icc_table ON $icc_table.id = $misc_table.icc_id
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $misc_table.manufacturer_id
                LEFT JOIN $certificate_table ON $certificate_table.id = $misc_table.certificate_type_id
                WHERE $misc_table.deleted = 0 $where
                ORDER BY $misc_table.id ASC";

        return $this->db->query($sql);
    }

    function get_internal_index($client_id, $wll, $wl) {
        $misc_table = $this->db->prefixTable("misc");
        $sql = "SELECT max(internal_id) as internal_id FROM $misc_table WHERE client_id=$client_id AND wll=$wll AND wl=$wl";
        $result = $this->db->query($sql)->getRow();
        if (empty($result->internal_id)) {
            return 1;
        } else {
            $strs = explode("-", $result->internal_id);
            $newIndex = intval(end($strs)) + 1;
            return $newIndex;
        }
    }

    // get id, internal_id only
    function get_data($client_id) {
        $misc_table = $this->db->prefixTable("misc");
        $sql = "SELECT id, internal_id FROM $misc_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

}