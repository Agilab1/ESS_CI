<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
{
    parent::__construct();
    $this->load->model('Admin_model');

    
    if (!$this->session->userdata('logged_in')) {
        redirect('login');
    }
}

	public function index()
    
	{
       
		$this->load->view('incld/verify');
		$this->load->view('incld/header');
		$this->load->view('incld/top_menu');
		$this->load->view('incld/side_menu');
		$this->load->view('admin/dashboard');
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

		

	}
    // public function form(){
    //      $this->load->view('incld/header');
	// 	$this->load->view('incld/top_menu');
	// 	$this->load->view('incld/side_menu');
	// 	// $this->load->view('admin/dashboard');
	// 	$this->load->view('admin/form');
	// 	$this->load->view('incld/jslib');
	// 	$this->load->view('incld/footer');
	// 	$this->load->view('incld/script');
    // }
	public function userlist(){
		$data['users'] = $this->Admin_model->get_user();
        $data['user_count'] = $this->Admin_model->get_user_count();
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
		$this->load->view('incld/top_menu');
		$this->load->view('incld/side_menu');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/user',$data);
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

	}
    public function dashboard()
{
    $data['users'] = $this->Admin_model->get_user();
    $data['user_count'] = $this->Admin_model->get_user_count();
    $this->load->view('incld/verify');
    $this->load->view('incld/header');
    $this->load->view('incld/top_menu');
    $this->load->view('incld/side_menu');
    $this->load->view('admin/dashboard', $data);
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
		$this->load->view('admin/dashboard');
		$this->load->view('admin/form' ,$data);
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');

	}
	public function edit($user_id) {
        $data = new stdClass();
        $data->action = 'edit';
        $data->user   = $this->Admin_model->get_user($user_id);
        // $data->user->pass_wd = 
        	$this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("admin/form",$data);
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
    } 
    public function view($user_id) {
        $data['action'] = 'view';
        $data['user'] = $this->Admin_model->get_user($user_id);
        	$this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("admin/form",$data);
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
    } 
    public function delete($user_id) {
        $data['action'] = 'delete';
        $data['user'] = $this->Admin_model->get_user($user_id);
        	$this->load->view('incld/verify');
        $this->load->view("incld/header");
        $this->load->view("admin/form",$data);
        $this->load->view("incld/jslib");
        $this->load->view("incld/script");
        $this->load->view("incld/footer");
        
    }
	public function delete_user($user_id)
{
    if (!$user_id) {
        $this->session->set_flashdata('error', 'Invalid user ID.');
        return redirect('admin/user_list');
    }

    $this->Admin_model->delete_user($user_id);
    $this->session->set_flashdata('success', 'User deleted successfully!');
    return redirect('admin/user_list');
}

	public function save_validate()
{
    $this->load->model('Admin_model');
    
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
        $this->Admin_model->update_user($user_id, $data);
        $this->session->set_flashdata('success', 'User updated successfully!');
    } else {
        $this->Admin_model->add_user($data);
    }

    redirect('admin/user_list');
}


  public function save()
{
    $action  = strtolower($this->input->post('action'));
    $user_id = $this->input->post('user_id');

    $data = $this->validate();
    if ($data === false) return; 

    switch ($action) {
        case 'add':
            $this->Admin_model->add_user($data);
            $this->session->set_flashdata('success', 'User added successfully!');
            break;

        case 'edit':
            $this->Admin_model->edit_user($user_id, $data);
            $this->session->set_flashdata('success', 'User updated successfully!');
            break;

        case 'delete':
            $this->Admin_model->delete_user($user_id);
            $this->session->set_flashdata('success', 'User deleted successfully!');
            break;

        default:
            $this->session->set_flashdata('error', 'Invalid action!');
            break;
    }

    redirect('admin/userlist');
}


public function validate()
{
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

