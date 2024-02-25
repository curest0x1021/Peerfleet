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
}