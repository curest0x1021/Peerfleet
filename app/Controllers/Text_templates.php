<?php

namespace App\Controllers;

class Text_templates extends Security_Controller {

    protected $Text_templates_model;

    function __construct() {
        parent::__construct();

        $this->Text_templates_model = model('App\Models\Text_templates_model');
    }
    function index(){
        return $this->template->rander("text_templates/index");
    }
    function save(){
        $new_data=array(
            "title"=>$this->request->getPost("title"),
            "content"=>$this->request->getPost("content"),
        );
        $saved_id=$this->Text_templates_model->ci_save($new_data);
        $data=array(
            $saved_id,
            $this->request->getPost("title"),
            js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $saved_id, "data-action-url" => get_uri("text_templates/delete"), "data-action" => "delete-confirmation"))
        );
        return json_encode(array("success"=>true,"data"=>$data,"message"=>"Saved!","id"=>$saved_id));
    }
    function delete(){
        $id = $this->request->getPost('id');
        $this->Text_templates_model->delete_permanently($id);
        return json_encode(array("success"=>true,"message"=>"Deleted!"));
    }
    function modal_form(){
        return $this->template->view("text_templates/modal_form");
    }
    function list_data(){
        $allTextTemplates=$this->Text_templates_model->get_all_where(array("deleted"=>0))->getResult();
        $data=array();
        foreach ($allTextTemplates as $key => $oneTextTemplate) {
            $data[]=array(
                $oneTextTemplate->id,
                $oneTextTemplate->title,
                js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $oneTextTemplate->id, "data-action-url" => get_uri("text_templates/delete"), "data-action" => "delete-confirmation"))
            );
        }
        return json_encode(array("data"=>$data));
    }

}