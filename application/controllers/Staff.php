<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Dashboard_model');
        
       
    }
    public function list() {
        $data['staffs'] = $this->Staff_model->get_user();
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard',$data);
        $this->load->view('Staff/list', $data);
        // $this->load->view('staff/staff_list',  $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }
    public function add() {
        $data = new stdClass();
        $data->action = 'add';
        $data->staff = (object)[
            'staff_id' => '',
            'emp_name' => '',
            'nfc_card' => '',
            'desig'    => '',
            'join_dt'  => '',
            'phn_no'   => '',
            'birth_dt' => '',
            'staff_st' =>''
        ];

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }
   
public function edit($staff_id) {

    $data = new stdClass();
    $data->action = 'edit';
    $data->staff  = $this->Staff_model->get_user($staff_id);
    if (!$data->staff) {
        show_404();
    }
    $data->staff->join_dt  = !empty($data->staff->join_dt) ? date('Y-m-d', strtotime($data->staff->join_dt)) : '';
    $data->staff->birth_dt = !empty($data->staff->birth_dt) ? date('Y-m-d', strtotime($data->staff->birth_dt)) : '';
    $this->load->view('incld/header');
    $this->load->view('Staff/staff_form', $data);  
    $this->load->view('incld/footer');
}

    public function view($staff_id) {
    $data = new stdClass();
    $data->action = 'view';
    $data->staff = $this->Staff_model->get_user($staff_id);
    if (!$data->staff) { show_404(); }
    $data->staff->join_dt  = date('Y-m-d', strtotime($data->staff->join_dt));
    $data->staff->birth_dt = date('Y-m-d', strtotime($data->staff->birth_dt));
    $this->load->view('incld/header');
    $this->load->view('Staff/staff_form', $data);  // ✔ Correct
    $this->load->view('incld/footer');
}

    public function delete($staff_id) {
    $data = new stdClass();
    $data->action = 'delete';
    $data->staff = $this->Staff_model->get_user($staff_id);
    if (!$data->staff) { show_404(); }
    $data->staff->join_dt  = date('Y-m-d', strtotime($data->staff->join_dt));
    $data->staff->birth_dt = date('Y-m-d', strtotime($data->staff->birth_dt));
    $this->load->view('incld/header');
    $this->load->view('Staff/staff_form', $data); // ✔ Correct
    $this->load->view('incld/footer');
}

    private function validate() {

        $this->form_validation->set_rules('staff_id', 'Staff ID', 'required|trim');
        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('nfc_card', 'NFC Card No', 'required|trim');

        if ($this->form_validation->run()) {

            return [
                'staff_id' => $this->input->post('staff_id'),
                'emp_name' => $this->input->post('emp_name'),
                'nfc_card' => $this->input->post('nfc_card'),
                'desig'    => $this->input->post('desig'),
                'join_dt'  => $this->input->post('join_dt'),
                'phn_no'   => $this->input->post('phn_no'),
                'birth_dt' => $this->input->post('birth_dt'),
                'staff_st' => $this->input->post('staff_st'),
            ];

        } else {
            return false;
        }
    }
    public function save() {

        $action = strtolower($this->input->post('action'));
        $staff_id = $this->input->post('old_staff_id');

        switch ($action) {

            case 'add':
                $data = $this->validate();
                if ($data) {
                    $this->Staff_model->add_user($data);
                    $this->session->set_flashdata('success', 'Staff added successfully!');
                    redirect('Staff/list');
                } else {
                    $this->add();
                }
                break;

            case 'edit':
                $data = $this->validate();
                if ($data) {
                    $this->Staff_model->edit_user($staff_id, $data);
                    $this->session->set_flashdata('success', 'Staff updated successfully!');
                    redirect('Staff/list');
                } else {
                    $this->edit($staff_id);
                }
                break;

            case 'delete':
                $this->Staff_model->delete_user($staff_id);
                $this->session->set_flashdata('success', 'Staff deleted successfully!');
                redirect('Staff/list');
                break;

            default:
                show_error("Invalid Action");
        }
    }

}
            
?>
