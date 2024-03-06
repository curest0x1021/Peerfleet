<?php

namespace App\Controllers;
use DateTime;
class Task_comments extends Security_Controller 
{
    public function __construct() {
        parent::__construct();
        // $this->access_only_admin_or_settings_admin();
        $this->Tasks_model = model("App\Models\Tasks_model");
        $this->Task_comments_model = model("App\Models\Task_comments_model");
        $this->Projects_model = model("App\Models\Projects_model");
    }
    public function index()
    {
        //
    }
    function save_comment() {
        $id = $this->request->getPost('id');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "task_comment");

        $task_id = $this->request->getPost('task_id');
        $task_info=$this->Tasks_model->get_one($task_id);
        $file_id = $this->request->getPost('file_id');
        $customer_feedback_id = $this->request->getPost('customer_feedback_id');
        $comment_id = $this->request->getPost('comment_id');
        $description = $this->request->getPost('description');

        if ($customer_feedback_id && $this->login_user->user_type == "staff") {
            if (!$this->has_client_feedback_access_permission()) {
                app_redirect("forbidden");
            }
        }

        $data = array(
            "created_by" => $this->login_user->id,
            "created_at" => get_current_utc_time(),
            "project_id" => $task_info->project_id,
            "file_id" => $file_id ? $file_id : 0,
            "task_id" => $task_id,
            "customer_feedback_id" => $customer_feedback_id ? $customer_feedback_id : 0,
            "comment_id" => $comment_id ? $comment_id : 0,
            "description" => $description
        );

        $data = clean_data($data);

        $data["files"] = $files_data; //don't clean serilized data

        $save_id = $this->Task_comments_model->ci_save($data, $id);
        if ($save_id) {
            $response_data = "";
            $options = array("id" => $save_id, "created_by" => $this->login_user->id);

            if ($this->request->getPost("reload_list")) {
                $view_data['comments'] = $this->Task_comments_model->get_details($options)->getResult();
                $response_data = $this->template->view("tasks/comments/comment_list_text", $view_data);
            }
            echo json_encode(array("success" => true, "data" => $response_data, 'message' => app_lang('comment_submited')));

            $comment_info = $this->Task_comments_model->get_one($save_id);

            $notification_options = array("project_id" => $comment_info->project_id, "project_comment_id" => $save_id);

            if ($comment_info->file_id) { //file comment
                $notification_options["project_file_id"] = $comment_info->file_id;
                log_notification("project_file_commented", $notification_options);
            } else if ($comment_info->customer_feedback_id) {  //customer feedback comment
                if ($comment_id) {
                    log_notification("project_customer_feedback_replied", $notification_options);
                } else {
                    log_notification("project_customer_feedback_added", $notification_options);
                }
            } else {  //project comment
                if ($comment_id) {
                    log_notification("project_comment_replied", $notification_options);
                } else {
                    log_notification("project_comment_added", $notification_options);
                }
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }
    function modal_category_comments(){
    }
    function modal_project_comments($project_id){
        $options = array("project_id" => $project_id);
        $allComments=$this->Task_comments_model->get_details($options)->getResult();
        // $task_info=$this->Tasks_model->get_one($task_id);
        // $allComments=$this->Task_comments_model->get_all_where(array("task_id"=>$task_id))->getResult();
        return $this->template->view("tasks/comments/modal_project_comments",["comments"=>$allComments,"project_id"=>$project_id]);
    }
    function modal_task_comments($task_id){
        $options = array("task_id" => $task_id);
        $allComments=$this->Task_comments_model->get_details($options)->getResult();
        $task_info=$this->Tasks_model->get_one($task_id);
        // $allComments=$this->Task_comments_model->get_all_where(array("task_id"=>$task_id))->getResult();
        return $this->template->view("tasks/comments/modal_comments",["task_info"=>$task_info,"comments"=>$allComments,"task_id"=>$task_id,"project_id"=>$task_info->project_id]);
    }
    function upload_file(){
        upload_file_to_temp();
    }
    function validate_comment_file(){
        return json_encode(array("success"=>true));
    }
    function download_comment_files($id) {

        $info = $this->Task_comments_model->get_one($id);

        // $this->init_project_permission_checker($info->project_id);
        // if ($this->login_user->user_type == "client" && !$this->is_clients_project) {
        //     app_redirect("forbidden");
        // } else if ($this->login_user->user_type == "user" && !$this->is_user_a_project_member) {
        //     app_redirect("forbidden");
        // }

        return $this->download_app_files(get_setting("timeline_file_path"), $info->files);
    }
}
