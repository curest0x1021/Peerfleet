<?php

namespace App\Models;

class Grommets_loadtest_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'grommets_loadtest';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $grommet_table = $this->db->prefixTable("grommets");
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");

        $where = "";
        $grommet_id = $this->_get_clean_value($options, "grommet_id");
        if ($grommet_id) {
            $where .= " AND $grommet_table.id = $grommet_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $grommet_table.client_id = $client_id";
        }

        $sql = "SELECT $grommet_table.internal_id, c.*
                FROM $grommet_table
                LEFT JOIN (
                    SELECT a.* FROM $loadtest_table a
                    JOIN (SELECT grommet_id, MAX(test_date) as test_date FROM $loadtest_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.test_date = b.test_date
                    ) c ON $grommet_table.id = c.grommet_id
                WHERE $grommet_table.deleted = 0 $where
                ORDER BY $grommet_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");

        $where = "";
        $grommet_id = $this->_get_clean_value($options, "grommet_id");
        if ($grommet_id) {
            $where .= " AND $loadtest_table.grommet_id = $grommet_id";
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

    function check_valid_loadtest($grommet_id, $test_date) {
        $loadtest_table = $this->db->prefixTable("grommets_loadtest");

        $sql = "SELECT * FROM $loadtest_table
                WHERE deleted = 0 AND grommet_id = $grommet_id AND test_date >= '$test_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}