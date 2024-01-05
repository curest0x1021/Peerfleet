<?php

namespace App\Models;

class Lashing_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'lashing_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $lashing_table = $this->db->prefixTable("lashing");
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $where = "";
        $lashing_id = $this->_get_clean_value($options, "lashing_id");
        if ($lashing_id) {
            $where .= " AND $lashing_table.id = $lashing_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $lashing_table.client_id = $client_id";
        }

        $sql = "SELECT CONCAT('#', $lashing_table.no, ' - ', $lashing_table.name) as name, $lashing_table.qty as qty, $lashing_table.id as lashing_id, c.id, c.inspection_date, c.inspected_by, c.location, c.passed, c.remarks
                FROM $lashing_table
                LEFT JOIN (
                    SELECT a.* FROM $inspection_table a
                    JOIN (SELECT lashing_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY lashing_id) b ON a.lashing_id = b.lashing_id AND a.inspection_date = b.inspection_date
                    ) c ON $lashing_table.id = c.lashing_id
                WHERE $lashing_table.deleted = 0 $where
                ORDER BY c.inspection_date ASC, $lashing_table.id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $where = "";
        $lashing_id = $this->_get_clean_value($options, "lashing_id");
        if ($lashing_id) {
            $where .= " AND $inspection_table.lashing_id = $lashing_id";
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

    function check_valid_inspection($lashing_id, $inspection_date) {
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted = 0 AND lashing_id = $lashing_id AND inspection_date >= '$inspection_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}