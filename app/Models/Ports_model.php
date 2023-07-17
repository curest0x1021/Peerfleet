<?php

namespace App\Models;

class Ports_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'ports';
        parent::__construct($this->table);
    }

    function get_all_ids() {
        $port_table = $this->db->prefixTable("ports");

        $sql = "SELECT id FROM $port_table";
        $result = $this->db->query($sql)->getResult();
        $ids = array_map(function($x) { return $x->id; }, $result);
        return $ids;
    }
}
