<?php

namespace App\Controllers;

class Budget_groups extends Security_Controller {
    private $Buget_groups_model;
    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
        $this->Budget_groups_model = model('App\Models\Budget_groups_model');
    }
    function save(){
        $new_data=array(
            "title"=>$this->request->getPost("title"),
            "number"=>$this->request->getPost("number"),
        );
        $saved_id=$this->Budget_groups_model->ci_save($new_data);
        $data=array(
            $saved_id,
            $this->request->getPost("title"),
            $this->request->getPost("number"),
            js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_note'), "class" => "delete", "data-id" => $saved_id, "data-action-url" => get_uri("budget_groups/delete"), "data-action" => "delete-confirmation"))
        );
        return json_encode(array("success"=>true,"data"=>$data,"message"=>"Saved!","id"=>$saved_id));
    }
    function index(){
        // $allBudgetGroups=$this->Budget_groups_model->get_all()->getResult();
        return $this->template->rander("budget_groups/index");
    }
    function list_data(){
        $allBudgetGroups=$this->Budget_groups_model->get_all()->getResult();
        $data=array();
        foreach ($allBudgetGroups as $key => $oneBudgetGroup) {
            $data[]=array(
                $oneBudgetGroup->id,
                $oneBudgetGroup->title,
                $oneBudgetGroup->number?$oneBudgetGroup->number:"",
                js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_note'), "class" => "delete", "data-id" => $oneBudgetGroup->id, "data-action-url" => get_uri("budget_groups/delete"), "data-action" => "delete-confirmation"))
            );
        }
        return json_encode(array("data"=>$data));
    }
    function modal_form(){
        return $this->template->view("budget_groups/modal_form");
    }
    function delete(){
        $id = $this->request->getPost('id');
        $this->Budget_groups_model->delete_permanently($id);
        return json_encode(array("success"=>true,"message"=>"Deleted!"));
    }
    
}