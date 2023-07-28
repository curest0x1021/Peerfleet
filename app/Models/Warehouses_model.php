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

    function get_vessels($options = array()) {
        $warehouse_table = $this->db->prefixTable("warehouses");
        $clients_table = $this->db->prefixTable("clients");
        $spare_table = $this->db->prefixTable("warehouse_spares");
        $chemical_table = $this->db->prefixTable("warehouse_chemicals");
        $oil_table = $this->db->prefixTable("warehouse_oils");
        $paint_table = $this->db->prefixTable("warehouse_paints");

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $warehouse_table.client_id = $client_id";
        }

        $sql = "SELECT $clients_table.charter_name as vessel, kk.client_id, kk.spare_total, kk.spare_min, kk.chemical_total, kk.chemical_min,
                    kk.oil_total, kk.oil_min, kk.paint_total, kk.paint_min
                FROM (
                    SELECT $warehouse_table.client_id, SUM(a1.total_items) as spare_total, SUM(a2.min_stock_items) as spare_min,
                        SUM(b1.total_items) as chemical_total, SUM(b2.min_stock_items) as chemical_min,
                        SUM(c1.total_items) as oil_total, SUM(c2.min_stock_items) as oil_min,
                        SUM(d1.total_items) as paint_total, SUM(d2.min_stock_items) as paint_min
                    FROM $warehouse_table
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $spare_table GROUP BY warehouse_id) a1 ON a1.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $spare_table WHERE quantity <= min_stocks GROUP BY warehouse_id) a2 ON a2.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $chemical_table GROUP BY warehouse_id) b1 ON b1.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $chemical_table WHERE quantity <= min_stocks GROUP BY warehouse_id) b2 ON b2.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $oil_table GROUP BY warehouse_id) c1 ON c1.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $oil_table WHERE quantity <= min_stocks GROUP BY warehouse_id) c2 ON c2.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $paint_table GROUP BY warehouse_id) d1 ON d1.warehouse_id = $warehouse_table.id
                    LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $paint_table WHERE quantity <= min_stocks GROUP BY warehouse_id) d2 ON d2.warehouse_id = $warehouse_table.id
                    WHERE $warehouse_table.deleted = 0 $where
                    GROUP BY $warehouse_table.client_id) kk
                LEFT JOIN $clients_table ON $clients_table.id = kk.client_id
                ORDER BY vessel ASC";

        return $this->db->query($sql)->getResult();
    }

    function get_warehouses($client_id) {
        $warehouse_table = $this->db->prefixTable("warehouses");
        $clients_table = $this->db->prefixTable("clients");
        $spare_table = $this->db->prefixTable("warehouse_spares");
        $chemical_table = $this->db->prefixTable("warehouse_chemicals");
        $oil_table = $this->db->prefixTable("warehouse_oils");
        $paint_table = $this->db->prefixTable("warehouse_paints");

        $sql = "SELECT $warehouse_table.*, $clients_table.charter_name as vessel, a1.total_items as spare_total, a2.min_stock_items as spare_min,
                    b1.total_items as chemical_total, b2.min_stock_items as chemical_min, c1.total_items as oil_total, c2.min_stock_items as oil_min,
                    d1.total_items as paint_total, d2.min_stock_items as paint_min
                FROM $warehouse_table
                LEFT JOIN $clients_table ON $clients_table.id = $warehouse_table.client_id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $spare_table GROUP BY warehouse_id) a1 ON a1.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $spare_table WHERE quantity <= min_stocks GROUP BY warehouse_id) a2 ON a2.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $chemical_table GROUP BY warehouse_id) b1 ON b1.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $chemical_table WHERE quantity <= min_stocks GROUP BY warehouse_id) b2 ON b2.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $oil_table GROUP BY warehouse_id) c1 ON c1.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $oil_table WHERE quantity <= min_stocks GROUP BY warehouse_id) c2 ON c2.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as total_items FROM $paint_table GROUP BY warehouse_id) d1 ON d1.warehouse_id = $warehouse_table.id
                LEFT JOIN (SELECT warehouse_id, COUNT(id) as min_stock_items FROM $paint_table WHERE quantity <= min_stocks GROUP BY warehouse_id) d2 ON d2.warehouse_id = $warehouse_table.id
                WHERE $warehouse_table.deleted = 0 AND $warehouse_table.client_id = $client_id
                ORDER BY $warehouse_table.code ASC";

        return $this->db->query($sql)->getResult();
    }

    function get_minstock_reached_items($warehouse_id) {
        $spare_table = $this->db->prefixTable("warehouse_spares");
        $chemical_table = $this->db->prefixTable("warehouse_chemicals");
        $oil_table = $this->db->prefixTable("warehouse_oils");
        $paint_table = $this->db->prefixTable("warehouse_paints");

        $sql = "SELECT SUM(a.spares) as spares, SUM(a.chemicals) as chemicals, SUM(a.oils) as oils, SUM(a.paints) as paints
            FROM (SELECT COUNT(id) as spares, 0 as chemicals, 0 as oils, 0 as paints FROM $spare_table WHERE deleted = 0 AND warehouse_id=$warehouse_id AND min_stocks > 0 AND min_stocks >= quantity
            UNION
            SELECT 0 as spares, COUNT(id) as chemicals, 0 as oils, 0 as paints FROM $chemical_table WHERE deleted = 0 AND warehouse_id=$warehouse_id AND min_stocks > 0 AND min_stocks >= quantity
            UNION
            SELECT 0 as spares, 0 as chemicals, COUNT(id) as oils, 0 as paints FROM $oil_table WHERE deleted = 0 AND warehouse_id=$warehouse_id AND min_stocks > 0 AND min_stocks >= quantity
            UNION
            SELECT 0 as spares, 0 as chemicals, 0 as oils, COUNT(id) as paints FROM $paint_table WHERE deleted = 0 AND warehouse_id=$warehouse_id AND min_stocks > 0 AND min_stocks >= quantity) a
            ";

        return $this->db->query($sql)->getRow();
    }

    function get_infomation($warehouse_id) {
        $warehouse_table = $this->db->prefixTable("warehouses");
        $clients_table = $this->db->prefixTable("clients");

        $sql = "SELECT $clients_table.charter_name as vessel, CONCAT(a.code, ' - ', a.name) as title
                FROM (SELECT * FROM $warehouse_table WHERE id=$warehouse_id) a
                JOIN $clients_table ON $clients_table.id = $warehouse_table.client_id";

        $row = $this->db->query($sql)->getRow();
        return $row;
    }

}
