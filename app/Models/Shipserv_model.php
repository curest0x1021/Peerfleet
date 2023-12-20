<?php

namespace App\Models;

class Shipserv_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shipserv';
        parent::__construct($this->table);
    }

}