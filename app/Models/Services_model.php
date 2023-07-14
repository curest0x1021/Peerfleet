<?php

namespace App\Models;

class Services_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'services';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $service_table = $this->db->prefixTable("services");
        $country_table = $this->db->prefixTable("country");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $service_table.id=$id";
        }

        $sql = "SELECT $service_table.*, $country_table.name as country
                FROM $service_table
                JOIN $country_table ON $country_table.id = $service_table.country_id
                WHERE $service_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

}