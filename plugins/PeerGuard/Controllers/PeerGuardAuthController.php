<?php

namespace PeerGuard\Controllers;

use App\Controllers\App_Controller;

class PeerGuardAuthController extends App_Controller
{
    protected $PeerGuardmodel;
    protected $settings;
    protected $signin_validation_errors;

    function __construct()
    {
        parent::__construct();

        $this->PeerGuardmodel = model('PeerGuard\Models\PeerGuardModel');
        $this->settings = new \App\Models\Settings_model();
        $this->signin_validation_errors = [];

        helper('email');
    }

    public function resetSession()
    {
        if ($this->request->getPost()) {
            $validation = $this->validate_submitted_data([
                'email'    => 'required|valid_email',
                'password' => 'required'
            ], true);

            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");
            if (!$email) {
                app_redirect('peerguard/reset_session');
            }

            if (is_array($validation)) {
                //has validation errors
                $this->signin_validation_errors = $validation;
            }

            //don't check password if there is any error
            if ($this->signin_validation_errors) {
                $this->session->setFlashdata("signin_validation_errors", $this->signin_validation_errors);
                app_redirect('peerguard/reset_session');
            }

            if (!$this->Users_model->authenticate($email, $password)) {
                //authentication failed
                array_push($this->signin_validation_errors, app_lang("authentication_failed"));
                $this->session->setFlashdata("signin_validation_errors", $this->signin_validation_errors);
                app_redirect('peerguard/reset_session');
            }

            $this->Users_model->sign_out();
        }

        $viewData['title'] = app_lang('reset_session');
        
        return $this->template->view('PeerGuard\Views\reset_session',$viewData);
    }

}
