<?php

namespace App\Models;

class Misc_main_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'misc_main';
        parent::__construct($this->table);
    }

    function get_details($client_id) {
        $main_table = $this->db->prefixTable("misc_main");
        $misc_table = $this->db->prefixTable("misc");
        $loadtest_table = $this->db->prefixTable("misc_loadtest");
        $inspection_table = $this->db->prefixTable("misc_inspection");
        $types_table = $this->db->prefixTable("misc_types");

        $sql = "SELECT $main_table.*, $types_table.name as type, b.qty, b.loadtest_passed, b.inspection_passed, b.total_test, b.supplied_date, b.supplied_place
                FROM $main_table
                JOIN (
                    SELECT kk.main_id, MAX(kk.supplied_date) as supplied_date, MAX(kk.supplied_place) as supplied_place, SUM(kk.qty) as qty, SUM(kk.loadtest_passed) as loadtest_passed, SUM(kk.inspection_passed) as inspection_passed, COUNT(kk.id) as total_test
                    FROM (
                        SELECT $misc_table.*, t.passed as loadtest_passed, s.passed as inspection_passed
                        FROM $misc_table
                        LEFT JOIN (
                            SELECT a.misc_id, a.passed FROM $loadtest_table a
                            JOIN (SELECT misc_id, MAX(test_date) as test_date FROM $loadtest_table WHERE deleted = 0 AND misc_id IN (
                                SELECT id FROM $misc_table WHERE deleted = 0 AND client_id = $client_id
                            ) GROUP BY misc_id) b
                            ON a.misc_id = b.misc_id AND a.test_date = b.test_date
                        ) t ON $misc_table.id = t.misc_id
                        LEFT JOIN (
                            SELECT a.misc_id, a.passed FROM $inspection_table a
                            JOIN (SELECT misc_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 AND misc_id IN (
                                SELECT id FROM $misc_table WHERE deleted = 0 AND client_id = $client_id
                            ) GROUP BY misc_id) b
                            ON a.misc_id = b.misc_id AND a.inspection_date = b.inspection_date
                        ) s ON $misc_table.id = s.misc_id
                        WHERE $misc_table.deleted = 0 AND $misc_table.client_id = $client_id) kk
                    GROUP BY kk.main_id
                ) b ON $main_table.id = b.main_id
                JOIN $types_table ON $types_table.id = $main_table.type_id
                WHERE $main_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }

}