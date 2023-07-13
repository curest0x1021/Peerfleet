<?php

namespace App\Models;

class Misc_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'misc_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $misc_table = $this->db->prefixTable("misc");
        $inspection_table = $this->db->prefixTable("misc_inspection");

        $where = "";
        $misc_id = $this->_get_clean_value($options, "misc_id");
        if ($misc_id) {
            $where .= " AND $misc_table.id = $misc_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $misc_table.client_id = $client_id";
        }

        $sql = "SELECT $misc_table.internal_id, $misc_table.id as misc_id, c.id, c.inspection_date, c.inspected_by, c.location, c.passed, c.remarks
                FROM $misc_table
                LEFT JOIN (
                    SELECT a.* FROM $inspection_table a
                    JOIN (SELECT misc_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY misc_id) b ON a.misc_id = b.misc_id AND a.inspection_date = b.inspection_date
                    ) c ON $misc_table.id = c.misc_id
                WHERE $misc_table.deleted = 0 $where
                ORDER BY c.inspection_date ASC, $misc_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $inspection_table = $this->db->prefixTable("misc_inspection");

        $where = "";
        $misc_id = $this->_get_clean_value($options, "misc_id");
        if ($misc_id) {
            $where .= " AND $inspection_table.misc_id = $misc_id";
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

    function check_valid_inspection($misc_id, $inspection_date) {
        $inspection_table = $this->db->prefixTable("misc_inspection");

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted = 0 AND misc_id = $misc_id AND inspection_date >= '$inspection_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}