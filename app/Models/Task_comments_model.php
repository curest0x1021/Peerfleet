<?php

namespace App\Models;

use CodeIgniter\Model;

class Task_comments_model extends Crud_model
{
    protected $table = null;

    function __construct() {
        $this->table = 'task_comments';
        parent::__construct($this->table);
    }
    public function getCount($columnName, $specialValue)
    {
        return $this->where($columnName, $specialValue)->countAllResults();
    }
    function get_details($options = array()) {
        $project_comments_table = $this->db->prefixTable('task_comments');
        //$likes_table = $this->db->prefixTable('likes');
        $users_table = $this->db->prefixTable('users');
        //$pin_comments_table = $this->db->prefixTable('pin_comments');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $project_comments_table.id=$id";
        }

        $project_id = $this->_get_clean_value($options, "project_id");
        if ($project_id) {
            // $where .= " AND $project_comments_table.project_id=$project_id AND $project_comments_table.task_id=0 AND $project_comments_table.file_id=0 and $project_comments_table.customer_feedback_id=0";
            $where .= " AND $project_comments_table.project_id=$project_id ";
        }

        $task_id = $this->_get_clean_value($options, "task_id");
        if (isset($task_id)) {
            $where .= " AND $project_comments_table.task_id=$task_id";
        }


        $file_id = $this->_get_clean_value($options, "file_id");
        if ($file_id) {
            $where .= " AND $project_comments_table.file_id=$file_id";
        }

        $customer_feedback_id = $this->_get_clean_value($options, "customer_feedback_id");
        if ($customer_feedback_id) {
            $where .= " AND $project_comments_table.customer_feedback_id=$customer_feedback_id";
        }

        $extra_select = "";
        $login_user_id = $this->_get_clean_value($options, "login_user_id");
        // if ($login_user_id) {
        //     $extra_select = ", (SELECT count($likes_table.id) FROM $likes_table WHERE $likes_table.project_comment_id=$project_comments_table.id AND $likes_table.deleted=0 AND $likes_table.created_by=$login_user_id) as like_status,
        //         (SELECT count($pin_comments_table.id) FROM $pin_comments_table WHERE $pin_comments_table.project_comment_id=$project_comments_table.id AND $pin_comments_table.deleted=0 AND $pin_comments_table.pinned_by=$login_user_id) as pinned_comment_status";
        // }


        //show the main comments in descending mode
        //but show the replies in ascedning mode
        $sort = " DESC";
        $comment_id = $this->_get_clean_value($options, "comment_id");
        if ($comment_id) {
            $where .= " AND $project_comments_table.comment_id=$comment_id";
            $sort = "ASC";
        } else {
            $where .= " AND $project_comments_table.comment_id=0";
        }

        $sql = "SELECT $project_comments_table.*, $project_comments_table.id AS parent_commment_id, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_user, $users_table.image as created_by_avatar, $users_table.user_type,
            (SELECT COUNT($project_comments_table.id) as total_replies FROM $project_comments_table WHERE $project_comments_table.comment_id=parent_commment_id) AS total_replies,
            (SELECT GROUP_CONCAT(' ', $users_table.first_name, ' ', $users_table.last_name) 
                    FROM $users_table
                    WHERE $users_table.deleted=0 AND $users_table.user_type!='lead' 
        FROM $project_comments_table
        LEFT JOIN $users_table ON $users_table.id= $project_comments_table.created_by
        WHERE $project_comments_table.deleted=0 $where
        ORDER BY $project_comments_table.created_at $sort";

        return $this->db->query($sql);
    }
}