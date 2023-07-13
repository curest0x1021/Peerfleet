<?php

namespace App\Models;

class Grommets_main_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'grommets_main';
        parent::__construct($this->table);
    }
}