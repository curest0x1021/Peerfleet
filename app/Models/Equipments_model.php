<?php

namespace App\Models;

class Equipments_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'equipments';
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
    function get_one($id = 0) {
        $equipments_table = $this->db->prefixTable("equipments");

        $sql = "SELECT $equipments_table.*
        FROM $equipments_table
        WHERE $equipments_table.deleted = 0 AND $equipments_table.id = $id";
        return $this->db->query($sql)->getRow();
    }
}