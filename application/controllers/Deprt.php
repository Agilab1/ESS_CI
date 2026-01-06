<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deprt extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Department_model');
        $this->load->model('Dashboard_model');
        $this->load->library(['session', 'form_validation']);

        if (!$this->session->userdata('logged_in')) {
            redirect('user');
        }
    }

    // ================= LIST =================
    public function list()
    {
        $data['department'] = $this->Department_model->getAll();
        $data['counts']      = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('dept/list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    // ================= ADD =================
    public function add()
    {
        $data['action'] = 'add';
        $data[' department'] = null;
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('dept/form', $data);
        $this->load->view('incld/footer');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data['action'] = 'edit';
        $data[' department'] = $this->Department_model->getById($id);
        if (!$data[' department']) show_404();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('dept/form', $data);
        $this->load->view('incld/footer');
    }

    // ================= SAVE =================
    public function save()
    {
        $this->form_validation->set_rules(
            'department_name',
            'Department Name',
            'required|trim'
        );

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $data = [
            'department_name' => $this->input->post('department_name')
        ];

        if ($this->input->post('action') == 'add') {
            $this->Department_model->insert($data);
            $this->session->set_flashdata('success', 'Department added successfully!');
        } else {
            $this->Department_model->update(
                $this->input->post('department_id'),
                $data
            );
            $this->session->set_flashdata('success', 'Department updated successfully!');
        }

        redirect('deprt/list');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->Department_model->delete($id);
        $this->session->set_flashdata('success', 'Department deleted successfully!');
        redirect('deprt/list');
    }


    public function view($id)
    {
        $data['action'] = 'view';
        $data['department'] = $this->Department_model->getById($id);
        $data['counts'] = $this->Dashboard_model->counts();

        if (!$data['department']) {
            show_404();
        }

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('department/form', $data);
        $this->load->view('incld/footer');
    }
}
