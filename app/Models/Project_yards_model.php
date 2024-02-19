<?php

namespace App\Models;

use CodeIgniter\Model;

class Project_yards_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'Project_yards';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
}