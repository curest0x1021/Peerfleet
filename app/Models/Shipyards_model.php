<?php

namespace App\Models;

class Shipyards_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shipyards';
        parent::__construct($this->table);
    }

    function get_all_ids() {
        $shipyard_table = $this->db->prefixTable("shipyards");

        $sql = "SELECT id FROM $shipyard_table";
        $result = $this->db->query($sql)->getResult();
        $ids = array_map(function($x) { return $x->id; }, $result);
        return $ids;
    }

    function get_countries() {
        $shipyard_table = $this->db->prefixTable("shipyards");
        $country_table = $this->db->prefixTable("country");

        $sql = "SELECT LOWER(a.country_id) as id, $country_table.name
                FROM (SELECT DISTINCT country_id FROM $shipyard_table WHERE country_id IS NOT NULL) a
                LEFT JOIN $country_table ON a.country_id = $country_table.id
                ORDER BY $country_table.name ASC";

        return $this->db->query($sql)->getResult();
    }

    function get_regions() {
        $shipyard_table = $this->db->prefixTable("shipyards");
        $country_table = $this->db->prefixTable("country");

        $sql = "SELECT a.region as id, MAX($country_table.sub_region) as name
                FROM (SELECT DISTINCT region FROM $shipyard_table WHERE country_id IS NOT NULL) a
                JOIN $country_table ON a.region = $country_table.sub_region_id
                GROUP BY a.region
                ORDER BY a.region ASC";

        return $this->db->query($sql)->getResult();
    }

    function get_sailing_areas() {
        $shipyard_table = $this->db->prefixTable("shipyards");
        $sailingarea_table = $this->db->prefixTable("sailing_area");

        $sql = "SELECT a.sailingarea_id as id, MAX($sailingarea_table.name) as name
                FROM (SELECT DISTINCT sailingarea_id from $shipyard_table WHERE sailingarea_id IS NOT NULL) a
                JOIN $sailingarea_table ON a.sailingarea_id = $sailingarea_table.id
                GROUP BY a.sailingarea_id
                ORDER BY a.sailingarea_id ASC";

        return $this->db->query($sql)->getResult();
    }

    function get_details($options = array()) {
        $shipyard_table = $this->db->prefixTable("shipyards");
        $country_table = $this->db->prefixTable("country");
        $sailingarea_table = $this->db->prefixTable("sailing_area");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $shipyard_table.id = '$id'";
        }

        $country_id = $this->_get_clean_value($options, "country_id");
        if ($country_id) {
            $where .= " AND $shipyard_table.country_id = '$country_id'";
        }

        $region = $this->_get_clean_value($options, "region");
        if ($region) {
            $where .= " AND $shipyard_table.region = '$region'";
        }

        $sailingarea = $this->_get_clean_value($options, "sailingarea");
        if ($sailingarea) {
            $where .= " AND $shipyard_table.sailingarea_id = '$sailingarea'";
        }

        $sql = "SELECT $shipyard_table.*, $country_table.name as country, $sailingarea_table.name as sailingarea
                FROM $shipyard_table
                LEFT JOIN $country_table ON $shipyard_table.country_id = $country_table.id
                LEFT JOIn $sailingarea_table ON $shipyard_table.sailingarea_id = $sailingarea_table.id
                WHERE $shipyard_table.deleted=0 $where";

        return $this->db->query($sql);
    }

}
