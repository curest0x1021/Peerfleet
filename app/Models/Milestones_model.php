<?php

namespace App\Models;

class Milestones_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'milestones';
        parent::__construct($this->table);
        parent::init_activity_log("milestone", "title", "project", "project_id");
    }

    function schema() {
        return array(
            "id" => array(
                "label" => app_lang("id"),
                "type" => "int"
            ),
            "title" => array(
                "label" => app_lang("title"),
                "type" => "text"
            ),
            "project_id" => array(
                "label" => app_lang("project"),
                "type" => "foreign_key",
                "linked_model" => model("App\Models\Projects_model"),
                "label_fields" => array("title"),
            ),
            "due_date" => array(
                "label" => app_lang("due_date"),
                "type" => "date"
            ),
            "deleted" => array(
                "label" => app_lang("deleted"),
                "type" => "int"
            )
        );
    }

    function get_details($options = array()) {
        $milestones_table = $this->db->prefixTable('milestones');
        $tasks_table = $this->db->prefixTable('tasks');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $milestones_table.id=$id";
        }

        $project_id = $this->_get_clean_value($options, "project_id");
        if ($project_id) {
            $where = " AND $milestones_table.project_id=$project_id";
        }

        $sql = "SELECT $milestones_table.*, total_points_table.total_points, total_points_table.total_tasks, completed_points_table.completed_points, completed_points_table.completed_tasks
        FROM $milestones_table
        LEFT JOIN (SELECT milestone_id, SUM(points) AS total_points, COUNT($tasks_table.id) AS total_tasks FROM $tasks_table WHERE deleted=0 AND milestone_id !=0 GROUP BY milestone_id) AS  total_points_table ON total_points_table.milestone_id= $milestones_table.id
        LEFT JOIN (SELECT milestone_id, SUM(points) AS completed_points, COUNT($tasks_table.id) AS completed_tasks FROM $tasks_table WHERE deleted=0 AND milestone_id !=0 AND status_id=3 GROUP BY milestone_id) AS  completed_points_table ON completed_points_table.milestone_id= $milestones_table.id
        WHERE $milestones_table.deleted=0 $where
        ORDER BY $milestones_table.due_date DESC";
        return $this->db->query($sql);
    }

    function upcoming($options=array()){
        $milestones_table = $this->db->prefixTable('milestones');
        $date=$options['date'];
        $project_id=$options['project_id'];
        $sql = "SELECT * FROM $milestones_table where $milestones_table.due_date >= $date AND $milestones_table.project_id = $project_id ORDER BY $milestones_table.due_date ASC LIMIT 1;";
        return $this->db->query($sql);
    }

}
