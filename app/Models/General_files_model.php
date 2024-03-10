<?php

namespace App\Models;

class General_files_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'general_files';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        // $general_files_table = $this->db->prefixTable('general_files');
        // $users_table = $this->db->prefixTable('users');
        // $where = "";
        // $id = $this->_get_clean_value($options, "id");
        // if ($id) {
        //     $where = " AND $general_files_table.id=$id";
        // }

        // $client_id = $this->_get_clean_value($options, "client_id");
        // if ($client_id) {
        //     $where = " AND $general_files_table.client_id=$client_id";
        // }
        

        // $user_id = $this->_get_clean_value($options, "user_id");
        // if ($user_id) {
        //     $where = " AND $general_files_table.user_id = $user_id";
        // }


        // $sql = "SELECT $general_files_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS uploaded_by_user_name, $users_table.image AS uploaded_by_user_image, $users_table.user_type AS uploaded_by_user_type
        // FROM $general_files_table
        // LEFT JOIN $users_table ON $users_table.id= $general_files_table.uploaded_by
        // WHERE $general_files_table.deleted=0 $where";
        // return $this->db->query($sql);
        $general_files_table = $this->db->prefixTable('general_files');
        $users_table = $this->db->prefixTable('users');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $general_files_table.id=$id ";
        }

        $client_id = $this->_get_clean_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $general_files_table.client_id=$client_id ";
        }

        $user_id = $this->_get_clean_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $general_files_table.user_id = $user_id ";
        }

        $folder_id = $this->_get_clean_value($options, "folder_id");
        $context_type = $this->_get_clean_value($options, "context_type");
        $is_admin = $this->_get_clean_value($options, "is_admin");

        if ($context_type == "file_manager") { // file manager view
            if ($folder_id) {
                //in a folder in the file manager
                $where = " AND $general_files_table.folder_id=$folder_id AND $general_files_table.context='global_files' ";
            } else {
                //root in the file manager
                if ($is_admin) {
                    $where = " AND $general_files_table.folder_id<=0 AND $general_files_table.context='global_files' ";
                } else {
                    $where = " AND $general_files_table.context='dont_show_global_files' "; //don't show any root files for non admin users. 
                }
            }
        } else if ($context_type == "client") { // client details view
            if ($folder_id) {
                //in a folder in the client details page
                $where = " AND $general_files_table.folder_id=$folder_id AND $general_files_table.context='client' AND $general_files_table.client_id = $client_id ";
            } else {
                //root in the client details page
                $where = " AND $general_files_table.folder_id<=0 AND $general_files_table.context='client' AND $general_files_table.client_id = $client_id ";
            }
        } else if ($context_type == "client_portal") { // client_portal folder view
            if ($folder_id) {
                //in a folder in the client details page
                //$where = " AND $general_files_table.folder_id=$folder_id AND (($general_files_table.context='client' AND $general_files_table.client_id = $client_id) OR ($general_files_table.context='global_files')) ";
                $where = " AND $general_files_table.folder_id=$folder_id AND $general_files_table.context='client' AND $general_files_table.client_id = $client_id ";

            } else {
                //root in the client details page
                $where = " AND $general_files_table.folder_id<=0 AND $general_files_table.context='client' AND $general_files_table.client_id = $client_id ";
            }
        } else if ($context_type == "client_portal_list_view") { // client_portal list view
            //$where = " AND (($general_files_table.context='client' AND $general_files_table.client_id = $client_id) OR ($general_files_table.context='global_files' AND $general_files_table.folder_id=$folder_id)) ";
            $where = " AND $general_files_table.context='client' AND $general_files_table.client_id = $client_id ";

        }


        $sql = "SELECT $general_files_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS uploaded_by_user_name, $users_table.image AS uploaded_by_user_image, $users_table.user_type AS uploaded_by_user_type
        FROM $general_files_table
        LEFT JOIN $users_table ON $users_table.id= $general_files_table.uploaded_by
        WHERE $general_files_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
