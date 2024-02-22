<?php

namespace App\Models;

use CodeIgniter\Model;

class Project_yards_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'project_yards';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
    function delete_where($where = array()) {
        if (count($where)) {
            return $this->db_builder->delete($where);
        }
    }
}