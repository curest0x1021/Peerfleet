<?php

namespace App\Controllers;

use App\Libraries\Google;
use App\Libraries\StreamResponse;

class Uploader extends App_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        show_404();
    }

    function upload_file()
    {
        $image = $this->request->getFile('upload');

        $temp_file_path = get_setting("temp_file_path");
        $file_name = $image->getName();
        $target_path = getcwd() . '/' . $temp_file_path;
        if (!is_dir($target_path)) {
            if (!mkdir($target_path, 0755, true)) {
                die('Failed to create file folders.');
            }
        }
        $target_file = $target_path . $file_name;
        // Move the uploaded file to a desired location
        $mimeType=$image->getMimeType();
        $image->move($target_path);

        // Get the path of the uploaded file
        // $imagePath = 'uploads/' . $image->getName();

        // Read the image file as a data URL
        $dataUrl = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($target_file));

        // Pass the data URL to the view
        return json_encode(array("default"=>$dataUrl));
        // return upload_file_to_temp_editor();
    }

    function upload_excel_import_file()
    {
        upload_file_to_temp(true);
    }

    function validate_file()
    {
        return validate_post_file($this->request->getPost("file_name"));
    }

    function validate_image_file()
    {
        $file_name = $this->request->getPost("file_name");
        if (!is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => false, 'message' => app_lang('invalid_file_type')));
            exit();
        }

        if (is_image_file($file_name)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('please_upload_valid_image_files')));
        }
    }

    function stream_google_drive_file($file_id, $filename)
    {

        $google = new Google();
        $file_data = $google->get_file_content($file_id);
        if (is_array($file_data)) {
            if (isset($file_data["mime_type"])) {
                return $this->_download($filename, $file_data["contents"], true);
            }else if (isset($file_data['error']['message'])) {
                echo $file_data['error']['message'];
            }
        }
    }

    private function _download(string $filename = '', $data = '', bool $setMime = false)
    {
        if ($filename === '' || $data === '') {
            return null;
        }

        $filepath = '';
        if ($data === null) {
            $filepath = $filename;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
        }

        $response = new StreamResponse($filename, $setMime);

        if ($filepath !== '') {
            $response->setFilePath($filepath);
        } elseif ($data !== null) {
            $response->setBinary($data);
        }

        return $response;
    }
    
}
