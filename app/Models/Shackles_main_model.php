<?php

namespace App\Models;

class Shackles_main_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shackles_main';
        parent::__construct($this->table);
    }

}