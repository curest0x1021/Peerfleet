<?php

namespace App\Models;

class Shackles_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shackles_loadtest';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $shackles_table = $this->db->prefixTable("shackles");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");

        $where = "";
        $shackle_id = $this->_get_clean_value($options, "shackle_id");
        if ($shackle_id) {
            $where .= " AND $shackles_table.id = $shackle_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $shackles_table.client_id = $client_id";
        }

        $sql = "SELECT $shackles_table.internal_id, $shackles_table.id as shackle_id, c.id, c.test_date, c.tested_by, c.location, c.passed, c.remarks
                FROM $shackles_table
                LEFT JOIN (
                    SELECT a.* FROM $loadtest_table a
                    JOIN (SELECT shackle_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY shackle_id) b ON a.shackle_id = b.shackle_id AND a.test_date = b.test_date
                    ) c ON $shackles_table.id = c.shackle_id
                WHERE $shackles_table.deleted = 0 $where
                ORDER BY c.test_date ASC, $shackles_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");

        $where = "";
        $shackle_id = $this->_get_clean_value($options, "shackle_id");
        if ($shackle_id) {
            $where .= " AND $loadtest_table.shackle_id = $shackle_id";
        }

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $loadtest_table.id = $id";
        }

        $sql = "SELECT * FROM $loadtest_table
                WHERE deleted=0 $where
                ORDER BY test_date DESC";

        return $this->db->query($sql);
    }

    function check_valid_loadtest($shackle_id, $test_date) {
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");

        $sql = "SELECT * FROM $loadtest_table
                WHERE deleted = 0 AND shackle_id = $shackle_id AND test_date >= '$test_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}