<?php

namespace App\Models;

class Budget_groups_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'budget_groups';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $budget_groups_table = $this->db->prefixTable('budget_groups');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $budget_groups_table.id=$id";
        }

        $sql = "SELECT $budget_groups_table.*
        FROM $budget_groups_table
        WHERE $budget_groups_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_id_and_title($options = array()) {
        $budget_groups_table = $this->db->prefixTable('budget_groups');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $budget_groups_table.id=$id";
        }

        $sql = "SELECT $budget_groups_table.id, $budget_groups_table.title
        FROM $budget_groups_table
        WHERE $budget_groups_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
