<?php

namespace App\Models;

class Ticket_actions_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'ticket_actions';
        parent::__construct($this->table);
    }

}