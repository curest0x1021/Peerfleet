<?php

namespace App\Models;

use CodeIgniter\Model;

class Task_libraries_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'task_libraries';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
}