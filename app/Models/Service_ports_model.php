<?php

namespace App\Models;

class Service_ports_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'service_ports';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $service_ports_table = $this->db->prefixTable("service_ports");
        $services_table = $this->db->prefixTable("services");
        $country_table = $this->db->prefixTable("country");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $service_ports_table.id = $id";
        }
        $service_id = $this->_get_clean_value($options, "service_id");
        if ($service_id) {
            $where .= " AND $service_ports_table.service_id = $service_id";
        }

        $sql = "SELECT $service_ports_table.*, $services_table.company, $country_table.name as country 
                FROM $service_ports_table
                LEFT JOIN $services_table ON $services_table.id = $service_ports_table.service_id
                LEFT JOIN $country_table ON $country_table.id = $service_ports_table.country_id
                WHERE $service_ports_table.deleted = 0 $where";

        return $this->db->query($sql);
    }
}
