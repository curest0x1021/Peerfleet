<?php

namespace App\Models;

class Wires_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'wires_inspection';
        parent::__construct($this->table);
    }

    function get_inspections($client_id) {
        $inspection_table = $this->db->prefixTable("wires_inspection");
        $wires_table = $this->db->prefixTable("wires");
        $type_table = $this->db->prefixTable("wire_type");
        $equipments_table = $this->db->prefixTable("equipments");

        $sql = "SELECT $wires_table.id, $wires_table.client_id, CONCAT($equipments_table.name, ' - ', $type_table.name) as name, IFNULL(k.passed, 0) as passed,
                    k.inspection_date, k.location, k.result, k.files
                FROM $wires_table
                LEFT JOIN $type_table ON $wires_table.wire_type = $type_table.id
                LEFT JOIN $equipments_table ON $wires_table.equipment = $equipments_table.id
                LEFT JOIN (
                    SELECT $inspection_table.*
                    FROM $inspection_table
                    JOIN (SELECT wire_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE client_id=$client_id GROUP BY wire_id) a
                    ON $inspection_table.wire_id = a.wire_id AND $inspection_table.inspection_date = a.inspection_date
                    WHERE $inspection_table.deleted = 0 AND $inspection_table.client_id = $client_id
                ) k ON $wires_table.id = k.wire_id
                WHERE $wires_table.deleted = 0 AND $wires_table.client_id = $client_id";

        return $this->db->query($sql)->getResult();
    }

    function get_details($wire_id) {
        $inspection_table = $this->db->prefixTable("wires_inspection");

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted = 0 AND wire_id = $wire_id
                ORDER BY inspection_date DESC";

        return $this->db->query($sql)->getResult();
    }
}