<?php

namespace App\Models;

class Text_templates_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'text_templates';
        parent::__construct($this->table);
    }

}