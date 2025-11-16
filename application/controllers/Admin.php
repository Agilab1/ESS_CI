<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('User_model');

        
        if (!$this->session->userdata('logged_in')) {
            redirect('user');
        }
    }

	public function index() {
       
		$this->load->view('incld/verify');
		$this->load->view('incld/header');
		$this->load->view('incld/top_menu');
		$this->load->view('incld/side_menu');
		$this->load->view('admin/dashboard');
		$this->load->view('incld/jslib');
		$this->load->view('incld/footer');
		$this->load->view('incld/script');	

	}
	
    public function dashboard() {
        $data['users'] = $this->User_model->get_user();
        $data['user_count'] = $this->User_model->get_user_count();
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    
}

