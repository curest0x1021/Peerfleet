<?php

namespace App\Controllers;

use App\Libraries\StreamResponse;

class Free_upload extends App_Controller{

    function upload(){
        if (!empty($_FILES)) {
            $file = get_array_value($_FILES, "file");

            if (!$file) {
                die("Invalid file");
            }

            $temp_file = get_array_value($file, "tmp_name");
            $file_name = get_array_value($file, "name");
            $file_size = get_array_value($file, "size");

            if (!is_valid_file_to_upload($file_name)) {
                return false;
            }
            $temp_file_path = get_setting("temp_file_path");
            $target_path = getcwd() . '/' . $temp_file_path;
            if (!is_dir($target_path)) {
                if (!mkdir($target_path, 0755, true)) {
                    die('Failed to create file folders.');
                }
            }
            $target_file = $target_path . $file_name;
            copy($temp_file, $target_file);
            return json_encode(array("success"=>true));
            
        }
    }
}