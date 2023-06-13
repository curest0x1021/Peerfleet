<?php

namespace App\Models;

class Critical_spare_parts_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'critical_spare_parts';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $spare_table = $this->db->prefixTable("critical_spare_parts");
        $manufacturer_table = $this->db->prefixTable("manufacturers");
        $applicable_table = $this->db->prefixTable("applicable_equipments");
        $ship_table = $this->db->prefixTable("ship_equipments");
        $units_table = $this->db->prefixTable("units");

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $spare_table.id = $id";
        }

        $sql = "SELECT $spare_table.*, $manufacturer_table.name as manufacturer, $applicable_table.name as applicable_equip, $ship_table.name as ship_equip, $units_table.name as unit
                FROM $spare_table
                LEFT JOIN $manufacturer_table ON $manufacturer_table.id = $spare_table.manufacturer_id
                LEFT JOIN $applicable_table ON $applicable_table.id = $spare_table.applicable_equip_id
                LEFT JOIN $ship_table ON $ship_table.id = $spare_table.ship_equip_id
                LEFT JOIN $units_table ON $units_table.code = $spare_table.unit_code
                WHERE $spare_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

}