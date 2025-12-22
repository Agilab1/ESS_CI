<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // ✅ LOADS (FIXED)
        $this->load->model('User_model');
        $this->load->model('Dashboard_model');
        $this->load->library(['session', 'form_validation']);
    }

    public function index()
    {
        $this->load->view('incld/header');
        $this->load->view('user/login');
        $this->load->view('incld/footer');
    }

    // ================= LOGIN =================
    public function login()
    {
        $this->form_validation->set_rules('mail_id', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pass_wd', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
            return;
        }

        $mail_id = $this->input->post('mail_id');
        $pass_wd = $this->input->post('pass_wd');

        $user = $this->User_model->login_check($mail_id, $pass_wd);

        if (!$user) {
            $this->session->set_flashdata('error', 'Invalid login credentials');
            redirect('user');
        }

        // ✅ SESSION SET
        $this->session->set_userdata([
            'user_id'   => $user->user_id,
            'user_nm'   => $user->user_nm,
            'role_id'   => $user->role_id, // Admin / User
            'staff_id'  => $user->staff_id,
            'logged_in' => true
        ]);

        // 🔀 ROLE BASED REDIRECT
        if ($user->role_id === 'Admin') {
            redirect('Admin/dashboard');   // 🔥 EXISTING CONTROLLER
        } else {
            redirect('User/emp_punch');
        }
    }

    // ================= USER DASHBOARD =================
    public function emp_punch()
    {
        if ($this->session->userdata('role_id') === 1) {
            redirect('Dashboard');
        }

        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/emp_punch', $data);
        $this->load->view('user/homepage', $data);
         $this->load->view('incld/footer');
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');

    }

    // ================= LOGOUT =================
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user');
    }

    // ================= USER LIST =================
    public function list()
    {
        $data['users']  = $this->User_model->getAllUsers();
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('user/list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    // ================= ADD =================
    public function add()
    {
        $data['action'] = 'add';
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('user/form', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    // ================= EDIT =================
    public function edit($user_id)
    {
        $data['action'] = 'edit';
        $data['user']   = $this->User_model->get_user($user_id);

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('user/form', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
        $this->load->view('incld/footer');
    }

    // ================= DELETE =================
    public function delete_user($user_id)
    {
        $this->User_model->delete_user($user_id);
        $this->session->set_flashdata('success', 'User deleted successfully!');
        redirect('user/list');
    }

    // ================= SAVE =================
    public function save()
    {
        $action  = strtolower($this->input->post('action'));
        $user_id = $this->input->post('user_id');

        $data = $this->validate();
        if ($data === false) return;

        if ($action === 'add') {
            $this->User_model->add_user($data);
            $this->session->set_flashdata('success', 'User added successfully!');
        } elseif ($action === 'edit') {
            $this->User_model->edit_user($user_id, $data);
            $this->session->set_flashdata('success', 'User updated successfully!');
        }

        redirect('user/list');
    }

    // ================= VALIDATION =================
    public function validate()
    {
        $this->config->load('form_validate');
        $rules = $this->config->item('user_validation_rules');

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return false;
        }

        return [
            'mail_id' => $this->input->post('mail_id'),
            'user_nm' => $this->input->post('user_nm'),
            'user_ph' => $this->input->post('user_ph'),
            'pass_wd' => password_hash($this->input->post('pass_wd'), PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role_id'),
            'user_st' => $this->input->post('user_st'),
            'user_ty' => $this->input->post('user_ty'),
            'user_ad' => $this->input->post('user_ad') ?? 0
        ];
    }
    
}
