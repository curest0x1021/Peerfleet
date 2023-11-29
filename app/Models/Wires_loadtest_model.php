<?php

namespace App\Models;

class Wires_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_loadtest';
        parent::__construct($this->table);
    }

    function get_loadtests($client_id) {
        $loadtest_table = $this->db->prefixTable("wires_loadtest");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");

        $sql = "SELECT $wires_table.id, $wires_table.client_id, CONCAT($equipments_table.name, ' - ', $type_table.name) as name, IFNULL(k.passed, 0) as passed,
                    k.test_date, k.location, k.result, k.files
                FROM $wires_table
                LEFT JOIN $type_table ON $wires_table.wire_type = $type_table.id
                LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
                LEFT JOIN (
                    SELECT $loadtest_table.*
                    FROM $loadtest_table
                    JOIN (SELECT wire_id, MAX(test_date) as test_date FROM $loadtest_table WHERE client_id=$client_id GROUP BY wire_id) a
                    ON $loadtest_table.wire_id = a.wire_id AND $loadtest_table.test_date = a.test_date
                    WHERE $loadtest_table.deleted = 0 AND $loadtest_table.client_id = $client_id
                ) k ON $wires_table.id = k.wire_id
                WHERE $wires_table.deleted = 0 AND $wires_table.client_id = $client_id";

        return $this->db->query($sql)->getResult();
    }

    function get_details($wire_id) {
        $loadtest_table = $this->db->prefixTable("wires_loadtest");

        $sql = "SELECT * FROM $loadtest_table
                WHERE deleted = 0 AND wire_id = $wire_id
                ORDER BY test_date DESC";

        return $this->db->query($sql)->getResult();
    }
}