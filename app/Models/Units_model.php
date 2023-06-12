<?php

namespace App\Models;

class Units_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'units';
        parent::__construct($this->table);
    }

    function is_duplicate_unit_code($code, $id = 0) {

        $result = $this->get_all_where(array("code" => $code, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}