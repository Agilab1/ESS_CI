<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bom extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bom_model');
        $this->load->model('Material_model');
        $this->load->model('Dashboard_model');
    }
    public function add_child($material_id)
    {
        $data = new stdClass();

        $data->action   = 'add_child';
        $data->material = $this->Material_model->get_by_id($material_id);
        $data->counts = $this->Dashboard_model->counts();
        if (!$data->material) show_404();

        // child materials (exclude parent itself)
        $this->db->where('material_id !=', $material_id);
        $data->materials = $this->Material_model->get_all();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Bom/add_child_form', $data);
        $this->load->view('incld/footer');
    }

    // ================= MATERIAL WISE BOM VIEW =================
    public function material($material_id)
    {
        $data = new stdClass();

        $data->material = $this->Material_model->get_by_id($material_id);
        if (!$data->material) show_404();

        // 🔥 THIS LINE WAS MISSING
        $data->materials = $this->Material_model->get_all();

        $data->boms  = $this->Bom_model->get_by_parent_material($material_id);
        $data->uoms  = $this->db->get('uom_master')->result();
        $data->counts = $this->Dashboard_model->counts();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Bom/material_bom', $data);
        $this->load->view('incld/footer');
    }

    // ================= DASH / LIST =================
    public function bom_dash()
    {
        $data = new stdClass();
        $data->boms   = $this->Bom_model->get_all();
        $data->counts = $this->Dashboard_model->counts();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Bom/list', $data);
        $this->load->view('incld/footer');
    }

    // ================= ADD =================
    public function add()
    {
        $data = new stdClass();
        $data->action = 'add';

        $data->materials = $this->Material_model->get_all();

        //  ADD THIS LINE
        $data->uoms = $this->db->get('uom_master')->result();

        // empty bom object for add form
        $data->bom = (object)[
            'bom_id' => '',
            'parent_material_id' => '',
            'child_material_id'  => '',
            'uom' => '',
            'qty' => ''
        ];

        $this->load->view('incld/header');
        $this->load->view('Bom/form', $data);
        $this->load->view('incld/footer');
    }


    // ================= EDIT =================
    public function edit($bom_id)
    {
        $data = new stdClass();
        $data->action = 'edit';
        $data->materials = $this->Material_model->get_all();
        $data->uoms = $this->db->get('uom_master')->result(); // ✅ ADD THIS
        $data->bom = $this->Bom_model->get_by_id($bom_id);

        if (!$data->bom) show_404();

        $this->load->view('incld/header');
        $this->load->view('Bom/form', $data);
        $this->load->view('incld/footer');
    }

    // ================= VIEW =================
    public function view($bom_id)
    {
        $data = new stdClass();
        $data->action = 'view';
        $data->materials = $this->Material_model->get_all();
        $data->bom = $this->Bom_model->get_by_id_with_material($bom_id);

        if (!$data->bom) show_404();

        $this->load->view('incld/header');
        $this->load->view('Bom/form', $data);
        $this->load->view('incld/footer');
    }

    // ================= DELETE =================
    public function delete($bom_id)
    {
        // delete  parent material id 
        $bom = $this->Bom_model->get_by_id($bom_id);

        if (!$bom) {
            show_404();
        }

        $parent_id = $bom->parent_material_id;

        $this->Bom_model->delete($bom_id);
        $this->session->set_flashdata('success', 'BOM deleted successfully!');

        redirect('Bom/material/' . $parent_id);
    }


    // ================= VALIDATION =================
    private function validate()
    {
        $this->form_validation->set_rules('parent_material_id', 'Parent Material', 'required');
        $this->form_validation->set_rules('child_material_id', 'Child Material', 'required');
        $this->form_validation->set_rules('uom', 'UOM', 'required');
        $this->form_validation->set_rules('qty', 'Quantity', 'required|numeric');

        if ($this->form_validation->run()) {
            return [
                'parent_material_id' => $this->input->post('parent_material_id'),
                'child_material_id'  => $this->input->post('child_material_id'),
                'uom'                => $this->input->post('uom'),
                'qty'                => $this->input->post('qty'),
                'status'             => 1
            ];
        }
        return false;
    }

    // ================= SAVE (SWITCH CASE) =================
    public function save()
    {
        $action = strtolower($this->input->post('action'));
        $bom_id = $this->input->post('bom_id');

        switch ($action) {

            case 'add':
                $data = $this->validate();
                if ($data) {
                    $this->Bom_model->insert($data);
                    $this->session->set_flashdata('success', 'BOM added successfully!');
                    redirect('Bom/bom_dash');
                } else {
                    $this->add();
                }
                break;

            case 'edit':
                $data = $this->validate();
                if ($data) {

                    $this->Bom_model->update($bom_id, $data);

                    // 👉 parent material id form 
                    $parent_id = $this->input->post('parent_material_id');

                    $this->session->set_flashdata('success', 'BOM updated successfully!');
                    redirect('Bom/material/' . $parent_id);
                } else {
                    $this->edit($bom_id);
                }
                break;


            case 'delete':
                $this->Bom_model->delete($bom_id);
                redirect('Bom/bom_dash');
                break;

            default:
                show_error('Invalid Action');
        }
    }
    public function save_child()
    {
        $uom_id = $this->input->post('uom_id');

        $data = [
            'parent_material_id' => $this->input->post('parent_material_id'),
            'child_material_id'  => $this->input->post('child_material_id'),
            'uom'                => $uom_id,
            'qty'                => $this->input->post('qty'),
            'status'             => 1
        ];

        $exists = $this->db
            ->where('parent_material_id', $data['parent_material_id'])
            ->where('child_material_id', $data['child_material_id'])
            ->get('bom')
            ->row();

        if ($exists) {
            $this->session->set_flashdata('error', 'Child already exists in BOM');
            redirect('Bom/material/' . $data['parent_material_id']);
            return;
        }

        $this->Bom_model->insert($data);
        $this->session->set_flashdata('success', 'Child BOM added successfully');

        redirect('Bom/material/' . $data['parent_material_id']);
    }

    public function create($material_id)
    {
        $data['material']  = $this->Material_model->get($material_id);
        $data['materials'] = $this->Material_model->get_all();
        $data['boms']      = $this->Bom_model->get_by_parent($material_id);

        // 🔽 ADD THIS
        $data['uoms'] = $this->db->get('uom_master')->result();

        $this->load->view('bom_form', $data);
    }
    
    
// ================= INLINE UPDATE FROM MATERIAL PAGE =================
public function update_child()
{
    $bom_id = $this->input->post('bom_id');

    $data = [
        'child_material_id' => $this->input->post('child_material_id'),
        'uom'               => $this->input->post('uom_id'),
        'qty'               => $this->input->post('qty')
    ];

    $this->Bom_model->update($bom_id, $data);

    echo json_encode(['status' => 'success']);
}

// ================= INLINE DELETE FROM MATERIAL PAGE =================
public function delete_child($bom_id)
{
    $bom = $this->Bom_model->get_by_id($bom_id);
    if (!$bom) show_404();

    $parent_id = $bom->parent_material_id;
    $this->Bom_model->delete($bom_id);

    $this->session->set_flashdata('success', 'BOM deleted successfully!');
    redirect('Bom/material/' . $parent_id);
}

}
