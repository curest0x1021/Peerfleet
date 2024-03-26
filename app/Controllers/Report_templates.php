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

}