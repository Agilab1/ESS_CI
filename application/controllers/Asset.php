<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('user');
        }
    }
      public function list()
    {
 
        $this->load->model('Dashboard_model');
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

}