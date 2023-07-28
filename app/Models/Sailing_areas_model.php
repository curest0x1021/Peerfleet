<?php

namespace App\Models;

class Sailing_areas_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'sailing_areas';
        parent::__construct($this->table);
    }

}
