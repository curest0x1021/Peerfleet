<?php

namespace App\Models;

class Todo_status_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'to_do_status';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $todo_status_table = $this->db->prefixTable('to_do_status');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $todo_status_table.id=$id";
        }

        $hide_from_kanban = $this->_get_clean_value($options, "hide_from_kanban");
        if (!is_null($hide_from_kanban)) {
            $where .= " AND $todo_status_table.hide_from_kanban=$hide_from_kanban";
        }

        $sql = "SELECT $todo_status_table.*
        FROM $todo_status_table
        WHERE $todo_status_table.deleted=0 $where
        ORDER BY $todo_status_table.sort ASC";
        return $this->db->query($sql);
    }

    function get_max_sort_value() {
        $todo_status_table = $this->db->prefixTable('to_do_status');

        $sql = "SELECT MAX($todo_status_table.sort) as sort
        FROM $todo_status_table
        WHERE $todo_status_table.deleted=0";
        $result = $this->db->query($sql);
        if ($result->resultID->num_rows) {
            return $result->getRow()->sort;
        } else {
            return 0;
        }
    }

}
