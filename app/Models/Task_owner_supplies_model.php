<?php

namespace App\Models;

use CodeIgniter\Model;

class Task_owner_supplies_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'task_owner_supplies';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
}