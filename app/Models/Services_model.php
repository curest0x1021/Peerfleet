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
        $service_ports_table = $this->db->prefixTable("service_ports");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $service_table.id=$id";
        }

        $search = $this->_get_clean_value($options, "search");
        $country_id = $this->_get_clean_value($options, "country_id");
        $service_type = $this->_get_clean_value($options, "service_type");

        if ($search) {
            $search = $this->db->escapeLikeString($search);
        }

        if ($search) {
            $where = " AND $service_table.company LIKE '%$search%'";
        }

        if ($country_id) {
            $where .= " AND $service_table.country_id='$country_id'";
        }

        if ($service_type) {
            $where .= " AND $service_table.service_type='$service_type'";
        }

        $sql = "SELECT $service_table.*, $country_table.name as country, d2.served_ports 
                FROM $service_table
                JOIN $country_table ON $country_table.id = $service_table.country_id
                LEFT JOIN (SELECT service_id, COUNT(id) as served_ports FROM $service_ports_table GROUP BY $service_ports_table.service_id) d2 ON d2.service_id = $service_table.id
                WHERE $service_table.deleted = 0 $where";
 
        return $this->db->query($sql);
    }

}