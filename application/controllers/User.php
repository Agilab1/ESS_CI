<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model(model:'Dashboard_model');
        //
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

        if ($this->form_validation->run()) {
            $mail_id = $this->input->post('mail_id');
            $pass_wd = $this->input->post('pass_wd');
            $user    = $this->User_model->read_user($mail_id);
            if($user) {
                if (password_verify($pass_wd, $user->pass_wd)) {
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
                    redirect('user');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid User');
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
		$this->load->view('user/dashboard',$data);  //update here change admin to user
		$this->load->view('user/list',$data);
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

	}
    public function add(){
		$data['action'] = 'Add' or 'Edit';
        $this->load->view('incld/verify');
		$this->load->view('incld/header');
		$this->load->view('incld/top_menu');
		$this->load->view('incld/side_menu');
		$this->load->view('user/dashboard');    //change here admin to user
		$this->load->view('user/form' ,$data);
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

	}
	public function edit($user_id) {
        $data = new stdClass();
        $data->action = 'edit';
        $data->user   = $this->User_model->get_user($user_id);
        $this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("user/form",$data);
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
    } 
    public function view($user_id) {
        $data['action'] = 'view';
        $data['user'] = $this->User_model->get_user($user_id);
        $this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("user/form",$data);       //change here admin to user
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
    } 
    public function delete($user_id) {
        $data['action'] = 'delete';
        $data['user'] = $this->User_model->get_user($user_id);
        	$this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("user/form",$data);       //change here user
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
        
    }
    public function delete_user($user_id){
        if (!$user_id) {
            $this->session->set_flashdata('error', 'Invalid user ID.');
            return redirect('user/list');
        }

        $this->User_model->delete_user($user_id);
        $this->session->set_flashdata('success', 'User deleted successfully!');
        return redirect('user/list');
    }

	public function save_validate() {
        $this->load->model('User_model');
        
        $user_id = $this->input->post('user_id');
        $data = [
            'mail_id' => $this->input->post('mail_id'),
            'user_nm' => $this->input->post('user_nm'),
            'user_ph' => $this->input->post('user_ph'),
            'pass_wd' => $this->input->post('pass_wd'),
            'role_id' => $this->input->post('role_id'),
            'user_st' => $this->input->post('user_st'),
            'user_ty' => $this->input->post('user_ty'),
            'user_ad' => $this->input->post('user_ad')
        ];

        if ($user_id) {
            $this->User_model->update_user($user_id, $data);
            $this->session->set_flashdata('success', 'User updated successfully!');
        } else {
            $this->User_model->add_user($data);
        }

        redirect('user/list');
    }
    public function save() {
        $action  = strtolower($this->input->post('action'));
        $user_id = $this->input->post('user_id');

        $data = $this->validate();
        if ($data === false) return; 

        switch ($action) {
            case 'add':
                $this->User_model->add_user($data);
                $this->session->set_flashdata('success', 'User added successfully!');
                break;

            case 'edit':
                $this->User_model->edit_user($user_id, $data);
                $this->session->set_flashdata('success', 'User updated successfully!');
                break;

            case 'delete':
                $this->User_model->delete_user($user_id);
                $this->session->set_flashdata('success', 'User deleted successfully!');
                break;

            default:
                $this->session->set_flashdata('error', 'Invalid action!');
                break;
        }

        redirect('user/list');
    }


    public function validate() {
        $action = strtolower($this->input->post('action'));
        $user_id = $this->input->post('user_id');

        $this->load->library('form_validation');
        $this->config->load('form_validate');

        $config = $this->config->item('user_validation_rules');

        foreach ($config as &$rule) {
            if ($rule['field'] === 'mail_id' && $action === 'add') {
                $rule['rules'] .= '|is_unique[users.mail_id]';
            }
        }

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-danger">', '</div>'));

            if ($action === 'add') {
                $this->add();
            } else {
                $this->edit($user_id);
            }
            return false;
        }
        $data = [
            'mail_id' => $this->input->post('mail_id'),
            'user_nm' => $this->input->post('user_nm'),
            'user_ph' => $this->input->post('user_ph'),
            'pass_wd' => password_hash($this->input->post('pass_wd'), PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role_id'),
            'user_st' => $this->input->post('user_st'),
            'user_ty' => $this->input->post('user_ty'),
            'user_ad' => $this->input->post('user_ad') ?? 0
        ];

        return $data;
    }

}