<?php

namespace App\Models;

class Ports_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'ports';
        parent::__construct($this->table);
    }

    function get_all_names() {
        $port_table = $this->db->prefixTable("ports");

        $sql = "SELECT main_port_name FROM $port_table";
        $result = $this->db->query($sql)->getResult();
        $names = array_map(function($x) { return $x->main_port_name; }, $result);
        return $names;
    }
}
