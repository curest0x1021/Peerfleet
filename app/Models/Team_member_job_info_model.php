<?php

namespace App\Models;

class Team_member_job_info_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'team_member_job_info';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $team_table = $this->db->prefixTable('team_member_job_info');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $team_table.id=$id";
        }

        $sql = "SELECT $team_table.*
        FROM $team_table
        WHERE $team_table.deleted=0 $where";
        return $this->db->query($sql);
    }
}
