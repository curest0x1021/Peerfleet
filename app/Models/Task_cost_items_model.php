<?php

namespace App\Models;

use CodeIgniter\Model;

class Task_cost_items_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'task_cost_items';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
    public function get_all_with_costs(){
        $task_cost_items_table = $this->db->prefixTable('task_cost_items');
        $sql="SELECT id, task_id, project_id, name, description, quantity, unit_price, currency, quote_type,
        measurement, discount, yard_remarks, quantity * unit_price AS total_cost FROM $task_cost_items_table";
        return $this->db->query($sql);
    }
    public function get_all_with_costs_where($where = array()){
        $task_cost_items_table = $this->db->prefixTable('task_cost_items');
        $where_clause="";
        $where_count=0;
        foreach ($where as $key => $value) {
            # code...
            if($where_count==0)
                $where_clause.=("WHERE ".$key." = ".$value."");
            else $where_clause.=(" AND ".$key." = ".$value."");
            $where_count++;
        }
        
        $sql="SELECT id, task_id, project_id, name, description, quantity, unit_price, currency, quote_type, measurement, discount, yard_remarks, quantity * unit_price AS total_cost FROM $task_cost_items_table $where_clause";
        return $this->db->query($sql);
    }
}