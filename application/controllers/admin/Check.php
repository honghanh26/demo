<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 28/11/2017
 * Time: 4:28 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Check extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('mcode');
    }
    public function login() {
        $this->load->library('form_validation');
        if ($this->mcode->admin_logged_in()) {
            redirect('admin', 'refresh');
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );

        if ($this->form_validation->run() == FALSE)
        {
//            $this->load->view('myform');
//            var_dump(1);
//            redirect('admin/check/login', 'refresh');
        }
        else
        {
//            $this->load->view('formsuccess');
//            redirect('admin', '');
            if ($this->mcode->admin_login($this->input->post('username'), $this->input->post('password'))) {
                redirect('admin', 'refresh');
            }
            else {
                $this->session->set_flashdata('message','Sai tài khoản hoặc mật khẩu');
                redirect('admin/check/login', 'refresh');
            }
        }
//        if($this->input->post()) {
//            if ($this->mcode->admin_login($this->input->post('username'), $this->input->post('password'))) {
//                redirect('admin', 'refresh');
//            }
//            else {
//                $this->session->set_flashdata('message','Sai tài khoản hoặc mật khẩu');
//                redirect('admin/check/login', 'refresh');
//            }
//        }
        $this->render('admin/login_view','master');
    }
    public function logout() {
        $this->mcode->admin_logout();
        redirect('admin/check/login', 'refresh');
    }
}