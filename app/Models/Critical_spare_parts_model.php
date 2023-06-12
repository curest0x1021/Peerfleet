<?php

namespace App\Models;

class Critical_spare_parts_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'critical_spare_parts';
        parent::__construct($this->table);
    }

}