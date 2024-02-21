<?php

namespace App\Models;

class Shipyard_cost_items_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shipyard_cost_items';
        parent::__construct($this->table);
    }

}