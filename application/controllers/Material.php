<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Material_model');
        $this->load->model('Dashboard_model');
        
    }

    // LIST
    public function index()
    {
        $data['materials'] = $this->Material_model->get_all();
        $data['counts'] = $this->Dashboard_model->counts();
        $this->load->view('incld/header');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Material/list', $data);
        $this->load->view('incld/footer');
    }

    // ADD FORM
    public function create()
    {
        $this->load->view('incld/header');
        $this->load->view('Material/form');
        $this->load->view('incld/footer');
    }

    // SAVE
    public function store()
    {
        $data = [
            'material_name' => $this->input->post('material_name'),
            'material_code' => $this->input->post('material_code'),
            'uom'           => $this->input->post('uom'),
            'status'        => 1
        ];

        $this->Material_model->insert($data);
        redirect('material');
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['material'] = $this->Material_model->get_by_id($id);

        if (!$data['material']) show_404();

        $this->load->view('incld/header');
        $this->load->view('Material/form', $data);
        $this->load->view('incld/footer');
    }

    // UPDATE
    public function update($id)
    {
        $data = [
            'material_name' => $this->input->post('material_name'),
            'material_code' => $this->input->post('material_code'),
            'uom'           => $this->input->post('uom'),
        ];

        $this->Material_model->update($id, $data);
        redirect('material');
    }

    // DELETE
    public function delete($id)
    {
        $this->Material_model->delete($id);
        redirect('material');
    }
}
