<?php

namespace App\Models;

class Report_templates_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'report_templates';
        parent::__construct($this->table);
    }

}
