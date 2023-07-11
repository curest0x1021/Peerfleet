<?php

namespace App\Models;

class Misc_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'misc_loadtest';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $misc_table = $this->db->prefixTable("misc");
        $loadtest_table = $this->db->prefixTable("misc_loadtest");

        $where = "";
        $misc_id = $this->_get_clean_value($options, "misc_id");
        if ($misc_id) {
            $where .= " AND $misc_table.id = $misc_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $misc_table.client_id = $client_id";
        }

        $sql = "SELECT $misc_table.internal_id, $misc_table.id as misc_id, c.id, c.test_date, c.tested_by, c.location, c.passed, c.remarks
                FROM $misc_table
                LEFT JOIN (
                    SELECT a.* FROM $loadtest_table a
                    JOIN (SELECT misc_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY misc_id) b ON a.misc_id = b.misc_id AND a.test_date = b.test_date
                    ) c ON $misc_table.id = c.misc_id
                WHERE $misc_table.deleted = 0 $where
                ORDER BY $misc_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $loadtest_table = $this->db->prefixTable("misc_loadtest");

        $where = "";
        $misc_id = $this->_get_clean_value($options, "misc_id");
        if ($misc_id) {
            $where .= " AND $loadtest_table.misc_id = $misc_id";
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

    function check_valid_loadtest($misc_id, $test_date) {
        $loadtest_table = $this->db->prefixTable("misc_loadtest");

        $sql = "SELECT * FROM $loadtest_table
                WHERE deleted = 0 AND misc_id = $misc_id AND test_date >= '$test_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}