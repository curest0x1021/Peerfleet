<?php

namespace App\Models;

class Shackles_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shackles_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $shackles_table = $this->db->prefixTable("shackles");
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $where = "";
        $shackle_id = $this->_get_clean_value($options, "shackle_id");
        if ($shackle_id) {
            $where .= " AND $shackles_table.id = $shackle_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $shackles_table.client_id = $client_id";
        }

        $sql = "SELECT $shackles_table.internal_id, $shackles_table.id as misc_id, c.id, c.test_date, c.tested_by, c.location, c.passed, c.remarks
                FROM $shackles_table
                LEFT JOIN (
                    SELECT a.* FROM $inspection_table a
                    JOIN (SELECT shackle_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY shackle_id) b ON a.shackle_id = b.shackle_id AND a.inspection_date = b.inspection_date
                    ) c ON $shackles_table.id = c.shackle_id
                WHERE $shackles_table.deleted = 0 $where
                ORDER BY $shackles_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $where = "";
        $shackle_id = $this->_get_clean_value($options, "shackle_id");
        if ($shackle_id) {
            $where .= " AND $inspection_table.shackle_id = $shackle_id";
        }

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $inspection_table.id = $id";
        }

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted=0 $where
                ORDER BY inspection_date DESC";

        return $this->db->query($sql);
    }

    function check_valid_inspection($shackle_id, $inspection_date) {
        $inspection_table = $this->db->prefixTable("shackles_inspection");

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted = 0 AND shackle_id = $shackle_id AND inspection_date >= '$inspection_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}