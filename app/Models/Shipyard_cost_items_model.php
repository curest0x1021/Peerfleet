<?php

namespace App\Models;

class Shipyard_cost_items_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shipyard_cost_items';
        parent::__construct($this->table);
    }
    public function get_all_with_costs(){
        $task_cost_items_table = $this->db->prefixTable('shipyard_cost_items');
        $sql="SELECT id, shipyard_id, task_id, project_id, name, description, quantity, unit_price, currency, quote_type,
        measurement, discount, yard_remarks, quantity * unit_price * ( 100 - discount ) / 100 AS total_cost FROM $task_cost_items_table";
        return $this->db->query($sql);
    }
    public function get_all_with_costs_where($where = array()){
        $task_cost_items_table = $this->db->prefixTable('shipyard_cost_items');
        $where_clause="";
        $where_count=0;
        foreach ($where as $key => $value) {
            # code...
            if($where_count==0)
                $where_clause.=("WHERE ".$key." = ".$value."");
            else $where_clause.=(" AND ".$key." = ".$value."");
            $where_count++;
        }
        
        $sql="SELECT id, shipyard_id, task_id, project_id, name, description, quantity, unit_price, currency, quote_type, measurement, discount, yard_remarks, quantity * unit_price * ( 100 - discount ) / 100  AS total_cost FROM $task_cost_items_table $where_clause";
        return $this->db->query($sql);
    }
    public function get_details($options=array()){
        $projects_table = $this->db->prefixTable('projects');
        $shipyard_cost_items_table = $this->db->prefixTable('shipyard_cost_items');
        $tasks_table = $this->db->prefixTable('tasks');
        $project_yards_table = $this->db->prefixTable('project_yards');
        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.id=$id";
        }

        $project_id = $this->_get_clean_value($options, "project_id");
        if ($project_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.project_id='$project_id'";
        }

        $task_id = $this->_get_clean_value($options, "task_id");
        if ($task_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.task_id='$task_id'";
        }

        $shipyard_id = $this->_get_clean_value($options, "shipyard_id");
        if ($shipyard_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.shipyard_id='$shipyard_id'";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql="SELECT $shipyard_cost_items_table.* , $shipyard_cost_items_table.quantity * $shipyard_cost_items_table.unit_price * ( 100 - $shipyard_cost_items_table.discount ) / 100  AS total_cost, $projects_table.title AS project_title , $tasks_table.title AS task_title , $project_yards_table.title AS shipyard_title
        FROM $shipyard_cost_items_table
        LEFT JOIN $projects_table ON $projects_table.id=$shipyard_cost_items_table.project_id
        LEFT JOIN $tasks_table ON $tasks_table.id=$shipyard_cost_items_table.task_id
        LEFT JOIN $project_yards_table ON $project_yards_table.id=$shipyard_cost_items_table.shipyard_id
        WHERE  $where
        ";

        $raw_query = $this->db->query($sql);
        return $raw_query;
    }

    public function get_details_grouped_yards($options=array()){
        $projects_table = $this->db->prefixTable('projects');
        $shipyard_cost_items_table = $this->db->prefixTable('shipyard_cost_items');
        $tasks_table = $this->db->prefixTable('tasks');
        $project_yards_table = $this->db->prefixTable('project_yards');
        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.id=$id";
        }

        $project_id = $this->_get_clean_value($options, "project_id");
        if ($project_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.project_id='$project_id'";
        }

        $task_id = $this->_get_clean_value($options, "task_id");
        if ($task_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.task_id='$task_id'";
        }

        $shipyard_id = $this->_get_clean_value($options, "shipyard_id");
        if ($shipyard_id){
            if($where!="") $where.=" AND ";
            $where .= "$shipyard_cost_items_table.shipyard_id='$shipyard_id'";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql="SELECT $shipyard_cost_items_table.shipyard_id as shipyard_id , $project_yards_table.title as shipyard_title , $shipyard_cost_items_table.quantity * $shipyard_cost_items_table.unit_price * ( 100 - $shipyard_cost_items_table.discount ) / 100  AS total_cost, $projects_table.title AS project_title , $tasks_table.title AS task_title , $project_yards_table.title AS shipyard_title, SUM($shipyard_cost_items_table.quantity * $shipyard_cost_items_table.unit_price * ( 100 - $shipyard_cost_items_table.discount ) / 100) AS total_yard_cost
        , COUNT($shipyard_cost_items_table.id) AS number_of_items
        FROM $shipyard_cost_items_table
        LEFT JOIN $projects_table ON $projects_table.id=$shipyard_cost_items_table.project_id
        LEFT JOIN $tasks_table ON $tasks_table.id=$shipyard_cost_items_table.task_id
        LEFT JOIN $project_yards_table ON $project_yards_table.id=$shipyard_cost_items_table.shipyard_id
        WHERE  $where
        GROUP BY $shipyard_cost_items_table.shipyard_id
        ";

        $raw_query = $this->db->query($sql);
        return $raw_query;
    }

}