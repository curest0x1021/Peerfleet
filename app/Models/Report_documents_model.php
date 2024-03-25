<?php

namespace App\Models;

class Report_documents_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'report_documents';
        parent::__construct($this->table);
    }

}
