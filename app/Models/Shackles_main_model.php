<?php

namespace App\Models;

class Shackles_main_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'shackles_main';
        parent::__construct($this->table);
    }

    function get_details($client_id) {
        $main_table = $this->db->prefixTable("shackles_main");
        $shackles_table = $this->db->prefixTable("shackles");
        $loadtest_table = $this->db->prefixTable("shackles_loadtest");
        $inspection_table = $this->db->prefixTable("shackles_inspection");
        $types_table = $this->db->prefixTable("shackle_types");

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $sql = "SELECT $main_table.*, $types_table.name as type, b.loadtest_passed, b.inspection_passed, b.total_test, b.supplied_date, b.supplied_place
                FROM $main_table
                JOIN (
                    SELECT kk.main_id, MAX(kk.supplied_date) as supplied_date, MAX(kk.supplied_place) as supplied_place, SUM(kk.loadtest_passed) as loadtest_passed, SUM(kk.inspection_passed) as inspection_passed, COUNT(kk.id) as total_test
                    FROM (
                        SELECT $shackles_table.*, t.passed as loadtest_passed, s.passed as inspection_passed
                        FROM $shackles_table
                        LEFT JOIN (
                            SELECT a.shackle_id, IF((a.passed = 1 AND a.test_date > '$loadtest_reminder_date'), 1, 0) as passed FROM $loadtest_table a
                            JOIN (SELECT shackle_id, MAX(test_date) as test_date FROM $loadtest_table WHERE deleted = 0 AND shackle_id IN (
                                SELECT id FROM $shackles_table WHERE deleted = 0 AND client_id = $client_id
                            ) GROUP BY shackle_id) b
                            ON a.shackle_id = b.shackle_id AND a.test_date = b.test_date
                        ) t ON $shackles_table.id = t.shackle_id
                        LEFT JOIN (
                            SELECT a.shackle_id, IF((a.passed = 1 AND a.inspection_date > '$inspection_reminder_date'), 1, 0) as passed FROM $inspection_table a
                            JOIN (SELECT shackle_id, MAX(inspection_date) as inspection_date FROM $inspection_table WHERE deleted = 0 AND shackle_id IN (
                                SELECT id FROM $shackles_table WHERE deleted = 0 AND client_id = $client_id
                            ) GROUP BY shackle_id) b
                            ON a.shackle_id = b.shackle_id AND a.inspection_date = b.inspection_date
                        ) s ON $shackles_table.id = s.shackle_id
                        WHERE $shackles_table.deleted = 0 AND $shackles_table.client_id = $client_id) kk
                    GROUP BY kk.main_id
                ) b ON $main_table.id = b.main_id
                JOIN $types_table ON $types_table.id = $main_table.type_id
                WHERE $main_table.deleted = 0";

        $result = $this->db->query($sql)->getResult();
        return $result;
    }
}