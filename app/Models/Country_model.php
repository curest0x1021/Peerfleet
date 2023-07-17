<?php

namespace App\Models;

class Country_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'country';
        parent::__construct($this->table);
    }

}