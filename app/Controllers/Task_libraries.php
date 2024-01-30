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
        $allContexts = $this->Tasks_model->get_enum_values('pf_tasks', 'context');
        return $this->template->rander('task_libraries/index',["allTasks"=>$allTasks,"allContexts"=>$allContexts,'allCategories'=>$allCategories]);
    }

    function save(){
        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "start_date" => $this->request->getPost("start_date"),
            "deadline" => $this->request->getPost('deadline'),
            "context" => $this->request->getPost('category'),
        );
        $save_id = $this->Tasks_model->allowEmptyInserts()->ci_save($data);
 
        return $this->index();
    }

}