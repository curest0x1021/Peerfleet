<?php

namespace App\Models;

class Ship_equipments_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'ship_equipments';
        parent::__construct($this->table);
    }

    function is_duplicate_equipment_name($name, $id = 0) {

        $result = $this->get_all_where(array("name" => $name, "deleted" => 0));
        if (count($result->getResult()) && $result->getRow()->id != $id) {
            return $result->getRow();
        } else {
            return false;
        }
    }

}