<?php

namespace App\Models;

class Grommets_inspection_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'grommets_inspection';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $grommet_table = $this->db->prefixTable("grommets");
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $where = "";
        $grommet_id = $this->_get_clean_value($options, "grommet_id");
        if ($grommet_id) {
            $where .= " AND $grommet_table.id = $grommet_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $grommet_table.client_id = $client_id";
        }

        $sql = "SELECT $grommet_table.internal_id, $grommet_table.id as misc_id, c.id, c.inspection_date, c.inspected_by, c.location, c.passed, c.remarks
                FROM $grommet_table
                LEFT JOIN (
                    SELECT a.* FROM $inspection_table a
                    JOIN (SELECT grommet_id, MAX(inspection_date) as inspection_date FROM $inspection_table GROUP BY grommet_id) b ON a.grommet_id = b.grommet_id AND a.inspection_date = b.inspection_date
                    ) c ON $grommet_table.id = c.grommet_id
                WHERE $grommet_table.deleted = 0 $where
                ORDER BY $grommet_table.internal_id ASC";

        return $this->db->query($sql);
    }

    function get_history($options = array()) {
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $where = "";
        $grommet_id = $this->_get_clean_value($options, "grommet_id");
        if ($grommet_id) {
            $where .= " AND $inspection_table.grommet_id = $grommet_id";
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

    function check_valid_inspection($grommet_id, $inspection_date) {
        $inspection_table = $this->db->prefixTable("grommets_inspection");

        $sql = "SELECT * FROM $inspection_table
                WHERE deleted = 0 AND grommet_id = $grommet_id AND inspection_date >= '$inspection_date'";
        $count = $this->db->query($sql)->resultID->num_rows;
        return $count == 0;
    }
}