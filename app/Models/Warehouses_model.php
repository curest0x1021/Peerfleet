<?php

namespace App\Models;

class Warehouses_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'warehouses';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $warehouse_table = $this->db->prefixTable('warehouses');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $warehouse_table.id=$id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where = " AND $warehouse_table.client_id=$client_id";
        }

        $sql = "SELECT $warehouse_table.*
        FROM $warehouse_table
        WHERE $warehouse_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
