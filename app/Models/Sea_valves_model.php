<?php

namespace App\Models;

class Sea_valves_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'sea_valves';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $valves_table = $this->db->prefixTable('sea_valves');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $valves_table.id=$id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where = " AND $valves_table.client_id=$client_id";
        }

        $sql = "SELECT $valves_table.*
        FROM $valves_table
        WHERE $valves_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
