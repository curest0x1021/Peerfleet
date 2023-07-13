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
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $where = "";
        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $clients_table.id=$client_id";
        }

        $sql = "SELECT $clients_table.id as client_id, $clients_table.charter_name as name, a.total_items, c.require_inspections
                FROM $clients_table
                LEFT JOIN (SELECT client_id, COUNT(id) as total_items FROM $lashing_table WHERE deleted = 0 GROUP BY client_id) a
                    ON $clients_table.id = a.client_id
                LEFT JOIN (
                    SELECT $lashing_table.client_id, COUNT($lashing_table.id) as require_inspections
                    FROM $lashing_table
                    JOIN (SELECT lashing_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 AND inspection_date IS NOT NULL GROUP BY lashing_id) b
                        ON $lashing_table.id = b.lashing_id
                    WHERE b.inspection_date < '$inspection_reminder_date'
                    GROUP BY $lashing_table.client_id
                ) c ON $clients_table.id = c.client_id
                WHERE $clients_table.deleted = 0 $where
                GROUP BY $clients_table.id";

        return $this->db->query($sql);
    }

    function get_warnning_info($client_id) {
        $lashing_table = $this->db->prefixTable("lashing");
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT COUNT(a.id) as require_inspections
                FROM (SELECT id FROM $lashing_table WHERE deleted = 0 AND client_id = $client_id) a
                JOIN (SELECT lashing_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 AND inspection_date IS NOT NULL GROUP BY lashing_id) b
                    ON a.id = b.lashing_id
                WHERE b.inspection_date < '$inspection_reminder_date'";

        return $this->db->query($sql)->getRow();
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

    // get required visual inspection reminder items
    function get_required_visual_inspection_items() {
        $lashing_table = $this->db->prefixTable("lashing");
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT $lashing_table.id as lashing_id, $lashing_table.client_id, a.inspection_date
                FROM (
                    SELECT lashing_id, MAX(inspection_date) as inspection_date
                    FROM $inspection_table
                    WHERE deleted = 0 AND inspection_date IS NOT NULL
                    GROUP BY lashing_id
                ) a
                JOIN $lashing_table ON $lashing_table.id = a.lashing_id
                WHERE Date(a.inspection_date) < '$reminder_date'";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    function get_inspection_info($lashing_id) {
        $lashing_table = $this->db->prefixTable("lashing");
        $clients_table = $this->db->prefixTable("clients");
        $inspection_table = $this->db->prefixTable("lashing_inspection");

        $sql = "SELECT a.id, $clients_table.charter_name as vessel, a.name, MAX(b.inspection_date) as last_inspection_date
                FROM (SELECT * FROM $lashing_table WHERE id = $lashing_id) a
                JOIN $clients_table ON $clients_table.id = a.client_id
                LEFT JOIN (SELECT * FROM $inspection_table WHERE deleted=0 AND lashing_id = $lashing_id AND inspection_date IS NOT NULL) b
                    ON a.id = b.lashing_id";

        $row = $this->db->query($sql)->getRow();
        // Visual inspection: 12 months
        $row->due_date = date("Y-m-d", strtotime($row->last_inspection_date . ' + 12 months'));
        return $row;
    }

}