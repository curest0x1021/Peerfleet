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

    function get_warehouses($options = array()) {
        $warehouse_table = $this->db->prefixTable("warehouses");
        $clients_table = $this->db->prefixTable("clients");
        $spare_table = $this->db->prefixTable("warehouse_spares");

        $where = "";
        $warehouse_id = $this->_get_clean_value($options, "warehouse_id");
        if ($warehouse_id) {
            $where .= " AND $warehouse_table.id = $warehouse_id";
        }
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $warehouse_table.client_id = $client_id";
        }

        $sql = "SELECT $warehouse_table.*, $clients_table.charter_name as vessel, a.total_items, a.total_quantities, b.min_stock_items
                FROM $warehouse_table
                LEFT JOIN $clients_table ON $clients_table.id = $warehouse_table.client_id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items, SUM(quantity) as total_quantities FROM $spare_table GROUP BY warehouse_id) a ON a.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $spare_table WHERE quantity <= min_stocks GROUP BY warehouse_id) b ON b.warehouse_id = $warehouse_table.id
                WHERE $warehouse_table.deleted = 0 $where";

        return $this->db->query($sql);
    }

}
