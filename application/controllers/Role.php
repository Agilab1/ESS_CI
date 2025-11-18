<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->model('dashboard_model');
       
    }
    public function role_dash(){
        $this->load->model('dashboard_model');
        $data['roles'] =$this->Role_model->get_user();
        $data['counts'] = $this->dashboard_model->counts(); 
        
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard',$data);
        $this->load->view('Role/role_list',$data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');

    }
//     public function add(){
//     $data = new stdClass();
//     $data->action = 'add';
//     $data->role = (object)[
//         'role_id' => '',
//         'usr_role' => '',
//         'role_st' => ''
//     ];

//     $this->load->view('incld/header');
//     $this->load->view('Role/role_form', $data);  // FIXED
//     $this->load->view('incld/footer');
// }
    public function add(){
        $data = new stdClass();
        $data->action ='add';
        $data->role = (object)[
            'role_id' =>'',
            'usr_role'=>'',
            'role_st'=>''
        ];
        $this->load->view('incld/header');
        $this->load->view('Role/role_form',$data);
        $this->load->view('incld/footer');
    }
   public function edit($role_id){
    $data = new stdClass();
    $data->action = 'edit';
    $data->role = $this->Role_model->get_user($role_id);

    $this->load->view('incld/header');
    $this->load->view('Role/role_form', $data);
    $this->load->view('incld/footer');
}

   public function view($role_id){
    $data = new stdClass();
    $data->action = 'view';
    $data->role = $this->Role_model->get_user($role_id);

    $this->load->view('incld/header');
    $this->load->view('Role/role_form', $data);
    $this->load->view('incld/footer');
}

public function delete($role_id){
    $this->Role_model->delete_user($role_id);
    $this->session->set_flashdata('success','Role Deleted Successfully!');
    redirect('Role/role_dash');
}

    // public function delete($role_id){
    //     $data = new stdClass();
    //     $data->action ='delete';
    //     $data->role = $this->Role_model->get_user($role_id);
    //     $this->load->view('incld/header');
    //     $this->load->view('Role/role_form');
    //     $this->load->view('incld/footer');
    // }
    public function validate(){
        $this->form_validation->set_rules('role_id', 'Role ID', 'required|trim');
        $this->form_validation->set_rules('usr_role', 'User Role', 'required|trim');
        $this->form_validation->set_rules('role_st', 'Role Status', 'required|trim');

        if($this->form_validation->run()){
            return[
                'role_id' => $this->input->post('role_id'),
                'usr_role'=> $this->input->post('usr_role'),
                'role_st' => $this->input->post('role_st'),
            ];
        } else {
            return false;
        }
        
    }
    public function save(){
        $action = strtolower($this->input->post('action'));
        $role_id = $this->input->post('old_role_id');

        switch ($action){
            case 'add':
                $data = $this->validate();
                if($data){
                    $this->Role_model->add_user($data);
                    // $this->session->set_flashdata('success', '.$data['role_id'].', 'Role addedd successfully!');
                    $this->session->set_flashdata('success',$data['role_id'] . ', User Role: ' . $data['usr_role'] . ' added successfully!'); 
                    redirect('Role/role_dash');
                } else {
                    $this->add();
                }
                break;
            case 'edit':
                $data = $this->validate();
                if($data){
                    $this->Role_model->edit_user($role_id, $data);
                    $this->session->set_flashdata('success',$data['role_id'] . ', User Role: ' . $data['usr_role'] . ' updated successfully!');     
                    redirect('Role/role_dash');
                } else {
                    $this->edit($role_id);
                }
                break;
            case 'delete':
                $this->Role_model->delete_user($role_id);
                $this->session->set_flashdata('success',$data['role_id'] . ', User Role: ' . $data['usr_role'] . ' Delete successfully!');                   
                redirect('Role/role_dash');
                break;
            
            default:
                show_error('Invalid Action');
        }
    }
}

?>