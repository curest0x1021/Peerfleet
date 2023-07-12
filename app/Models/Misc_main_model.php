<?php

namespace App\Models;

class Misc_main_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'misc_main';
        parent::__construct($this->table);
    }

}