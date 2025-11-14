<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Role_model');
       
    }
    public function role_dash(){
        $data['roles'] =$this->Role_model->get_user();
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('Admin/dashboard');
        $this->load->view('Role/role_list',$data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');

    }
    public function add(){
        $data = new stdClass();
        $data->action ='add';
        $data->role = (object)[
            'role_id' =>'',
            'usr_role'=>'',
            'role_st'=>''
        ];
        $this->load->view('incld/header');
        $this->load->view('Role/role_form');
        $this->load->view('incld/footer');
    }
    public function edit($role_id){
        $data = new stdClass();
        $data->action = 'edit';
        $data->roles = $this->Role_model->get_user($role_id);
        $this->load->view('incld/header');
        $this->load->view('Role/role_form');
        $this->load->view('incld/footer');
    }
    public function delete($role_id){
        $data = new stdClass();
        $data->action ='delete';
        $data->role = $this->Role_model->get_user($role_id);
        $this->load->view('incld/header');
        $this->load->view('Role/role_form');
        $this->load->view('incld/footer');
    }
    public function validate(){
        
    }
}

?>