<?php

namespace App\Models;

class Ticket_actions_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'ticket_actions';
        parent::__construct($this->table);
        parent::init_activity_log("ticket_action", "corrective_action", "ticket", "ticket_id");
    }

}