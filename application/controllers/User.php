<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $this->load->view('incld/header');
        $this->load->view('user/login');
        $this->load->view('incld/footer');
    }

    public function login() {
        // $this->form_validation->set_rules($config);
        $this->form_validation->set_rules('mail_id', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pass_wd', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $email = $this->input->post('mail_id');
            $password = $this->input->post('pass_wd');
            $user = $this->Admin_model->read_user($email);

            if (password_verify($password, $user->pass_wd)) {
                $session_data = [
                    'user_id'   => $user->user_id,
                    'user_nm'   => $user->user_nm,
                    'role_id'   => isset($user->role_id) ? $user->role_id : 1,
                    'logged_in' => TRUE
                ];

                    $this->session->set_userdata($session_data);

                    $this->session->set_flashdata('success', 'Login successful!');
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Incorrect password');
                    redirect('login');
                }
            // } else {
            //     $this->session->set_flashdata('error', 'Email not found');
            //     redirect('login');
            // }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
