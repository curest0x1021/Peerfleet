<?php

namespace App\Controllers;

class Report_templates extends Security_Controller {

    function __construct() {
        parent::__construct();
        $this->Report_templates_model=model("App\models\Report_templates_model");
    }
    function index(){
        return $this->template->rander("report_templates/index");
    }
    function edit(){
        return $this->template->rander("report_templates/edit");
    }
    function view($id){
        $gotTemplate=$this->Report_templates_model->get_one($id);
        return $this->template->rander("report_templates/edit",["gotTemplate"=>$gotTemplate]);
    }
    function save(){
        $title=$this->request->getPost('title');
        $description=$this->request->getPost('description');
        $content=$this->request->getPost('content');
        $id=$this->request->getPost('id');
        $new_data=array(
            "title"=>$title,
            "description"=>$description,
            "content"=>$content
        );
        $saved_id=$this->Report_templates_model->ci_save($new_data,$id);
        return json_encode(array("success"=>true,"saved_id"=>$saved_id));
    }
    function delete(){
        $report_id=$this->request->getPost('id');
        $this->Report_templates_model->delete_permanently($report_id);
        return json_encode(array("success"=>true));
    }
    function list_data(){
        $allTemplates=$this->Report_templates_model->get_all()->getResult();
        $data=array();
        foreach ($allTemplates as $key => $oneTemplate) {
            $data[]=array(
                $oneTemplate->id,
                "<a href='".get_uri("report_templates/view/".$oneTemplate->id)."' >".$oneTemplate->title."</a>",
                js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_note'), "class" => "delete", "data-id" => $oneTemplate->id, "data-action-url" => get_uri("report_templates/delete"), "data-action" => "delete-confirmation"))
            );
        }
        return json_encode(array("data"=>$data));
    }
    function upload_editor_image(){
        // if (!(isset($_FILES['upload']) && $_uploadS['upload']['error'] == 0)) {
        //     //no file found
        //     return false;
        // }

        // $file = get_array_value($_FILES, "upload");
        // $temp_file = get_array_value($file, "tmp_name");
        // $file_name = get_array_value($file, "name");
        // $file_size = get_array_value($file, "size");

        // if (!is_viewable_image_file($file_name)) {
        //     //not an image file
        //     return false;
        // }

        // $image_name = "image_" . make_random_string(5) . ".png";
        // $timeline_file_path = get_setting("timeline_file_path");

        // $file_info = move_temp_file($image_name, $timeline_file_path, "pasted_image", $temp_file, "", "", false, $file_size);
        // if (!$file_info) {
        //     // couldn't upload it
        //     return false;
        // }

        // $new_file_name = get_array_value($file_info, 'file_name');
        // $url = get_source_url_of_file($file_info, $timeline_file_path, "thumbnail");

        // return json_encode(array(
        //     "default"=>$new_file_name
        // ));
        return json_encode(array("success"=>true));
    }

}