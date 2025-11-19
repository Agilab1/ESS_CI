<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $this->load->view('incld/header');
        $this->load->view('user/login');
        $this->load->view('incld/footer');
    }

    public function login() {
        $this->form_validation->set_rules('mail_id', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pass_wd', 'Password', 'required');

        if ($this->form_validation->run()) {

            $mail_id = $this->input->post('mail_id');
            $pass_wd = $this->input->post('pass_wd');

            $user = $this->User_model->read_user($mail_id);

            if ($user && password_verify($pass_wd, $user->pass_wd)) {

                $session_data = [
                    'user_id' => $user->user_id,
                    'user_nm' => $user->user_nm,
                    'role_id' => $user->role_id,
                    'logged_in' => TRUE
                ];

                $this->session->set_userdata($session_data);
                redirect('admin/dashboard');

            } else {
                $this->session->set_flashdata('error', 'Invalid login');
                redirect('user');
            }

        } else {
            $this->index();
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('user');
    }

    public function list() {
        $this->load->model('Dashboard_model');
		$data['users'] = $this->User_model->get_user();
        $data['counts'] = $this->Dashboard_model->counts();
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
		$this->load->view('incld/top_menu');
		$this->load->view('incld/side_menu');
		$this->load->view('user/dashboard',$data);  
		$this->load->view('user/list',$data);
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

	}

    public function add() {
        $data['action'] = 'add';

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/form', $data); 
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    public function edit($user_id) {
        $data['action'] = 'edit';
        $data['user'] = $this->User_model->get_user($user_id);

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/form', $data); 
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    public function view($user_id) {
        $data['action'] = 'view';
        $data['user'] = $this->User_model->get_user($user_id);

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/form', $data); 
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    public function delete_user($user_id) {
        $this->User_model->delete_user($user_id);
        $this->session->set_flashdata('success', 'User deleted successfully');
        redirect('user/list');
    }

}
?>
