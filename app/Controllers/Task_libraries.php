<?php

namespace App\Controllers;

class Task_libraries extends Security_Controller {
    public function __construct() {
        parent::__construct();
        // $this->access_only_admin_or_settings_admin();
    }

    function index() {
        $allTasks=$this->Tasks_model->get_all()->getResultarray();
        $allCategories=$this->Labels_model->get_all()->getResultArray();
        return $this->template->rander('task_libraries/index',["allTasks"=>$allTasks,'allCategories'=>$allCategories]);
    }

    function save(){
        redirect("/task_libraries");
    }

}