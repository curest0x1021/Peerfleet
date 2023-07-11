<?php

namespace App\Models;

class Lashing_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'lashing';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $clients_table = $this->db->prefixTable("clients");
        $lashing_table = $this->db->prefixTable("lashing");

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name,
                    COUNT($lashing_table.id) as total_items
                FROM $clients_table
                LEFT JOIN $lashing_table ON $clients_table.id = $lashing_table.client_id AND $lashing_table.deleted = 0
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_lashing_details($options = array()) {
        $lashing_table = $this->db->prefixTable("lashing");
        $category_table = $this->db->prefixTable("lashing_category");

        $where = "";

        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $lashing_table.id=$id";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $lashing_table.client_id=$client_id";
        }

        $sql = "SELECT $lashing_table.*, $category_table.name as category
                FROM $lashing_table
                LEFT JOIN $category_table ON $category_table.id = $lashing_table.category_id
                WHERE $lashing_table.deleted = 0 $where
                ORDER BY $lashing_table.id ASC";

        return $this->db->query($sql);
    }

    function get_next_no($client_id) {
        $lashing_table = $this->db->prefixTable("lashing");
        $sql = "SELECT MAX(no) as no FROM $lashing_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getRow();
        if ($result->no) {
            return $result->no + 1;
        } else {
            return 1;
        }
    }

    // get id, no. only
    function get_data($client_id) {
        $lashing_table = $this->db->prefixTable("lashing");
        $sql = "SELECT id, no FROM $lashing_table WHERE client_id=$client_id";
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

}