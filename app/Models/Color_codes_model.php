<?php

namespace App\Models;

class Color_codes_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'color_codes';
        parent::__construct($this->table);
    }

    function is_duplicated($name, $id = 0) {

        $result = $this->get_all_where(array("name" => $name, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}