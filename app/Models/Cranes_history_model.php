<?php

namespace App\Models;

class Cranes_history_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'cranes_history';
        parent::__construct($this->table);
    }

    function get_details($client_id) {
        $cranes_table = $this->db->prefixTable("cranes");
        $history_table = $this->db->prefixTable("cranes_history");

        $sql = "SELECT id as rope_id, client_id, CONCAT(crane, ' ', rope) as name
                FROM $cranes_table
                WHERE client_id = $client_id
                ORDER BY id ASC";
        $ropes = $this->db->query($sql)->getResult();

        $sql1 = "SELECT * FROM $history_table WHERE client_id = $client_id ORDER BY rope_id ASC, replacement ASC";
        $history_data = $this->db->query($sql1)->getResult();

        $result = array();
        foreach ($ropes as $item) {
            $history = array_filter($history_data, function($k) use($item) { return $k->rope_id == $item->rope_id; });
            $item->initial = count($history) > 0 ? array_values($history)[0]->replacement : null;
            $item->first = count($history) > 1 ? array_values($history)[1]->replacement : null;
            $item->second = count($history) > 2 ? array_values($history)[2]->replacement : null;
            $item->third = count($history) > 3 ? array_values($history)[3]->replacement : null;
            $item->forth = count($history) > 4 ? array_values($history)[4]->replacement : null;
            $item->fifth = count($history) > 5 ? array_values($history)[5]->replacement : null;
            $result[] = $item;
        }

        return $result;
    }
}