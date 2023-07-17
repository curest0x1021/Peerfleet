<?php

namespace App\Models;

class Service_contacts_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'service_contacts';
        parent::__construct($this->table);
    }

}