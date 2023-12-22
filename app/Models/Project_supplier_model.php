<?php

namespace App\Models;

class Project_supplier_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'project_supplier';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $project_supplier_table = $this->db->prefixTable('project_supplier');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $project_supplier_table.id=$id";
        }

        $project_id = $this->_get_clean_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $project_supplier_table.project_id=$project_id";
        }
        
        $sql = "SELECT $project_supplier_table.*
        FROM $project_supplier_table
        WHERE $project_supplier_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
