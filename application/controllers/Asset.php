<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Asset_model');
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
        $this->load->model('Location_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('user');
        }
    }

    public function list()
    {
        $data = new stdClass();
        $data->assets = $this->Asset_model->getAll();
        $data->counts = $this->Dashboard_model->counts();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Asset/list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    public function load_page($data)
    {
        $this->load->view('incld/header');
        $this->load->view('Asset/add', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    public function action($type = 'add', $id = null)
    {
        $data = new stdClass();
        $data->sites = $this->Asset_model->getSites();
        $data->staffs = $this->db->get('staffs')->result();
        $data->categories = $this->Asset_model->getCategories();

        switch ($type) {

            case "add":
                $data->action = "add";
                $data->asset = (object)[
                    'asset_id'   => '',
                    'asset_no'   => '',
                    'asset_name' => '',
                    'cat_id'     => '',
                    'status'     => ''
                ];
                $this->load_page($data);
                break;

            case "edit":
                $data->action = "edit";
                $data->asset = $this->Asset_model->getById($id);
                if (!$data->asset) show_404();
                $this->load_page($data);
                break;

            case "view":
                $data->action = "view";
                $data->asset  = $this->Asset_model->getById($id);
                if (!$data->asset) show_404();
                $data->loginUser = $this->User_model->get_user(
                    $this->session->userdata('user_id')
                );
                $this->load_page($data);
                break;

            case "delete":
                $this->Asset_model->deleteAsset($id);
                $this->session->set_flashdata('success', "Asset deleted successfully!");
                redirect('Asset/list');
                break;

            default:
                show_404();
        }
    }

    public function save()
{
    $action = $this->input->post('action');

    $assetData = [
        'asset_no'   => $this->input->post('asset_no'),
        'asset_name' => $this->input->post('asset_name'),
        'type_id'    => $this->input->post('type_id'),   // ✅ FIXED
    ];

    $this->form_validation->set_rules('asset_no', 'Asset Number', 'required');
    $this->form_validation->set_rules('asset_name', 'Asset Name', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    if ($action == 'add') {
        $this->Asset_model->insertAsset($assetData);
        $this->session->set_flashdata('success', 'Asset added successfully!');
    }

    elseif ($action == 'edit') {
        $asset_id = $this->input->post('asset_id');
        $this->Asset_model->updateAsset($asset_id, $assetData);
        $this->session->set_flashdata('success', 'Asset updated successfully!');
    }

    redirect('Asset/list');
}

    public function serials($asset_id)
{
    $data = new stdClass();

    // Dashboard counters
    $data->counts = $this->Dashboard_model->counts();

    // Asset info
    $data->asset = $this->Asset_model->getById($asset_id);
    if (!$data->asset) show_404();

    // Proper list query (with joins)
    $data->serials = $this->db
        ->select('assdet.*, sites.site_name, staffs.emp_name')
        ->from('assdet')
        ->join('sites', 'sites.site_id = assdet.site_id', 'left')
        ->join('staffs', 'staffs.staff_id = assdet.staff_id', 'left')
        ->where('assdet.asset_id', $asset_id)
        ->get()
        ->result();

    // Load layout
    $this->load->view('incld/header');
    $this->load->view('incld/top_menu');
    $this->load->view('incld/side_menu');
    $this->load->view('user/dashboard', $data);
    $this->load->view('Asset/serial_list', $data);
    $this->load->view('incld/jslib');
    $this->load->view('incld/footer');
    $this->load->view('incld/script');
}

    public function update_serials()
{
    $ids    = $this->input->post('assdet_id');
    $sites  = $this->input->post('site_id');
    $staffs = $this->input->post('staff_id');
    $nets   = $this->input->post('net_val');
    $status = $this->input->post('status');

    for ($i = 0; $i < count($ids); $i++) {
        $this->db->where('assdet_id', $ids[$i])->update('assdet', [
            'site_id'  => $sites[$i],
            'staff_id' => $staffs[$i],
            'net_val'  => $nets[$i],
            'status'   => $status[$i],
        ]);
    }

    $this->session->set_flashdata('success', 'Asset details updated successfully!');
    redirect($_SERVER['HTTP_REFERER']);
}
public function add_detail($asset_id)
{
    $data = new stdClass();
    $data->counts = $this->Dashboard_model->counts();
    $data->asset  = $this->Asset_model->getById($asset_id);
    $data->sites  = $this->db->get('sites')->result();
    $data->staffs = $this->db->get('staffs')->result();
    $data->action = 'add';
    $data->detail = null;

    $this->load->view('incld/header');
    $this->load->view('incld/top_menu');
    $this->load->view('incld/side_menu');
    $this->load->view('user/dashboard', $data);
    $this->load->view('Asset/detail_form', $data);
    $this->load->view('incld/footer');
}

public function edit_detail($assdet_id)
{
    $data = new stdClass();
    $data->counts = $this->Dashboard_model->counts();
    $data->detail = $this->db->get_where('assdet', ['assdet_id' => $assdet_id])->row();
    $data->asset  = $this->Asset_model->getById($data->detail->asset_id);
    $data->sites  = $this->db->get('sites')->result();
    $data->staffs = $this->db->get('staffs')->result();
    $data->action = 'edit';

    $this->load->view('incld/header');
    $this->load->view('incld/top_menu');
    $this->load->view('incld/side_menu');
    $this->load->view('user/dashboard', $data);
    $this->load->view('Asset/detail_form', $data);
    $this->load->view('incld/footer');
}

public function save_detail()
{
    $data = [
        'asset_id'  => $this->input->post('asset_id'),
        'serial_no' => $this->input->post('serial_no'),
        'site_id'   => $this->input->post('site_id'),
        'staff_id'  => $this->input->post('staff_id'),
        'net_val'   => $this->input->post('net_val'),
        'status'    => $this->input->post('status')
    ];

    if ($this->input->post('action') == 'add') {
        $this->db->insert('assdet', $data);
        // echo 'added';
        // print_r($data);
        // exit;
        $this->session->set_flashdata('success', 'Asset detail added successfully!');
    } else {
        $this->db->where('assdet_id', $this->input->post('assdet_id'))->update('assdet', $data);
        $this->session->set_flashdata('success', 'Asset detail updated successfully!');
    }

    redirect('asset/serials/'.$this->input->post('asset_id'));
}


public function delete_detail($assdet_id)
{
    $row = $this->db->get_where('assdet', ['assdet_id' => $assdet_id])->row();
    $this->db->delete('assdet', ['assdet_id' => $assdet_id]);
    redirect('asset/serials/'.$row->asset_id);
}
public function detail($type = 'add', $id = null)
{
    $data = new stdClass();
    $data->counts = $this->Dashboard_model->counts();
    $data->sites  = $this->db->get('sites')->result();
    $data->staffs = $this->db->get('staffs')->result();

    switch ($type) {

        case "add":
            $data->action = "add";
            $data->asset  = $this->Asset_model->getById($id);
            $data->detail = (object)[
                'assdet_id' => '',
                'serial_no' => '',
                'site_id'   => '',
                'staff_id'  => '',
                'net_val'   => '',
                'status'    => 1
            ];
            break;

        case "edit":
            $data->action = "edit";
            $data->detail = $this->db->get_where('assdet', ['assdet_id' => $id])->row();
            if (!$data->detail) show_404();
            $data->asset = $this->Asset_model->getById($data->detail->asset_id);
            break;

        case "view":
            $data->action = "view";
            $data->detail = $this->db->get_where('assdet', ['assdet_id' => $id])->row();
            if (!$data->detail) show_404();
            $data->asset = $this->Asset_model->getById($data->detail->asset_id);
            break;

        case "delete":
    $row = $this->db->get_where('assdet', ['assdet_id' => $id])->row();
    $this->db->delete('assdet', ['assdet_id' => $id]);
    $this->session->set_flashdata('success', 'Asset detail deleted successfully!');
    redirect('asset/serials/'.$row->asset_id);
    return;


        default:
            show_404();
    }

    $this->load->view('incld/header');
    // $this->load->view('incld/top_menu');
    // $this->load->view('incld/side_menu');
    // $this->load->view('user/dashboard', $data);
    $this->load->view('Asset/detail_form', $data);
    $this->load->view('incld/footer');
}


}
    