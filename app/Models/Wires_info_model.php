<?php

namespace App\Models;

class Wires_info_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_info';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $info_table = $this->db->prefixTable("wires_info");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");
        $manufacturers_table = $this->db->prefixTable("manufacturers");
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $where = "";
        $wire_id = $this->_get_clean_value($options, "wire_id");
        if ($wire_id) {
            $where .= " AND $wires_table.id = $wire_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $wires_table.client_id = $client_id";
        }

        $equipment_id = $this->_get_clean_value($options, "equipment_id");
        if ($equipment_id) {
            $where .= " AND $wires_table.equipment = $equipment_id";
        }

        $sql = "SELECT $info_table.files, $wires_table.id as wire_id, $wires_table.client_id, $equipments_table.name as crane, $type_table.name as wire, $info_table.id, $info_table.diameter, $info_table.length, $info_table.swl, $info_table.manufacturer_id, $manufacturers_table.name as manufacturer, $info_table.delivered, k1.passed as loadtest_passed, k1.test_date, k.passed as visual_inspection_passed, k.inspection_date
                FROM $wires_table
                LEFT JOIN $info_table ON $wires_table.id = $info_table.wire_id
                LEFT JOIN $type_table ON $wires_table.wire_type = $type_table.id
                LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
                LEFT JOIN $manufacturers_table ON $manufacturers_table.id = $info_table.manufacturer_id
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
                WHERE $wires_table.deleted = 0 $where GROUP BY $wires_table.id";

        return $this->db->query($sql);
    }
}