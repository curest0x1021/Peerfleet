<?php

namespace App\Controllers;

class Task_libraries extends Security_Controller {
    public function __construct() {
        parent::__construct();
        // $this->access_only_admin_or_settings_admin();
    }

    function index() {
        return $this->template->rander('task_libraries/index');
    }
}