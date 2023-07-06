<?php

namespace App\Models;

class Todo_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'to_do';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $todo_table = $this->db->prefixTable('to_do');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $todo_table.id=$id";
        }


        $created_by = $this->_get_clean_value($options, "created_by");
        if ($created_by) {
            $where .= " AND $todo_table.created_by=$created_by";
        }


        $status = $this->_get_clean_value($options, "status");
        if ($status) {
            $where .= " AND FIND_IN_SET($todo_table.status,'$status')";
        }

        $select_labels_data_query = $this->get_labels_data_query();

        $sql = "SELECT $todo_table.*, $select_labels_data_query
        FROM $todo_table
        WHERE $todo_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_kanban_details($options = array()) {
        $todo_table = $this->db->prefixTable('to_do');
        $checklist_items_table = $this->db->prefixTable('checklist_items');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $todo_table.id=$id";
        }

        $created_by = $this->_get_clean_value($options, "created_by");
        if ($created_by) {
            $where .= " AND $todo_table.created_by=$created_by";
        }


        $status = $this->_get_clean_value($options, "status");
        if ($status) {
            $where .= " AND FIND_IN_SET($todo_table.status,'$status')";
        }

        $select_labels_data_query = $this->get_labels_data_query();

        $sql = "SELECT $todo_table.*, $select_labels_data_query,
                IF($todo_table.sort!=0, $todo_table.sort, $todo_table.id) AS new_sort,
                (SELECT COUNT($checklist_items_table.id) FROM $checklist_items_table WHERE $checklist_items_table.deleted=0 AND $checklist_items_table.todo_id=$todo_table.id) AS total_checklist,
                (SELECT COUNT($checklist_items_table.id) FROM $checklist_items_table WHERE $checklist_items_table.is_checked=1 AND $checklist_items_table.deleted=0 AND $checklist_items_table.todo_id=$todo_table.id) AS total_checklist_checked
        FROM $todo_table
        WHERE $todo_table.deleted=0 $where
        ORDER BY new_sort ASC";
        return $this->db->query($sql);
    }

    function get_label_suggestions($user_id) {
        $todo_table = $this->db->prefixTable('to_do');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $todo_table
        WHERE $todo_table.deleted=0 AND $todo_table.created_by=$user_id";
        return $this->db->query($sql)->getRow()->label_groups;
    }

    function get_search_suggestion($search = "", $created_by = 0) {
        $todo_table = $this->db->prefixTable('to_do');

        if ($search) {
            $search = $this->db->escapeLikeString($search);
        }

        $sql = "SELECT $todo_table.id, $todo_table.title
        FROM $todo_table  
        WHERE $todo_table.deleted=0 AND $todo_table.created_by=$created_by AND $todo_table.title LIKE '%$search%' ESCAPE '!'
        ORDER BY $todo_table.title ASC
        LIMIT 0, 10";

        return $this->db->query($sql);
    }

    function delete_todo_and_sub_items($todo_id, $undo = false) {
        $todo_table = $this->db->prefixTable('todo');
        $checklist_items_table = $this->db->prefixTable("checklist_items");

        $deleted = $undo ? 0 : 1;
        //delete task
        $delete_task_sql = "UPDATE $todo_table SET $todo_table.deleted=$deleted WHERE $todo_table.id=$todo_id; ";
        $this->db->query($delete_task_sql);

        //delete checklists
        $delete_checklists_sql = "UPDATE $checklist_items_table SET $checklist_items_table.deleted=$deleted WHERE $checklist_items_table.todo_id=$todo_id; ";
        $this->db->query($delete_checklists_sql);

        return true;
    }
}
