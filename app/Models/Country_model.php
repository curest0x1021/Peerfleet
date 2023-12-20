<?php

namespace App\Models;

class Country_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'country';
        parent::__construct($this->table);
    }
    function get_one_by_name($name) {
        $country_table = $this->db->prefixTable("country");

        $sql = "SELECT $country_table.*
        FROM $country_table
        WHERE $country_table.name = '$name'";
        return $this->db->query($sql)->getRow();
    }
}