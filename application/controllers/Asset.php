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
        $this->load->model('User_model');

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
                    'net_value'  => '',
                    'site_id'    => '',
                    'staff_id'   => '',
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

    // logged-in user (for dropdown selected value)
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
        $asset_id = $this->input->post('asset_id');

        $data = [
            'asset_id'   => $this->input->post('asset_id'),
            'asset_no'   => $this->input->post('asset_no'),
            'asset_name' => $this->input->post('asset_name'),
            'net_value'  => $this->input->post('net_value'),
            'site_id'    => $this->input->post('site_id'),
            'staff_id'   => $this->input->post('staff_id'),
            'cat_id'     => $this->input->post('cat_id'),
            'status'     => $this->input->post('status'),
        ];

        $this->form_validation->set_rules('asset_no', 'Asset Number', 'required');
        $this->form_validation->set_rules('asset_name', 'Asset Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        if ($action == 'add') {
            $this->Asset_model->insertAsset($data);
            $this->session->set_flashdata('success', 'Asset added successfully!');
        } elseif ($action == 'edit') {
            $this->Asset_model->updateAsset($asset_id, $data);
            $this->session->set_flashdata('success', 'Asset updated successfully!');
        } else {
            show_404();
        }

        redirect('Asset/list');
    }
    public function updateStaff()
{
    $staff_id = $this->input->post('staff_id');
    $asset_id = $this->input->post('asset_id');
    $user_id  = $this->session->userdata('user_id');

    // update users table
    $this->User_model->edit_user($user_id, [
        'staff_id' => $staff_id
    ]);

    // update CURRENT viewed asset
    $this->db
        ->where('asset_id', $asset_id)
        ->update('assets', [
            'staff_id' => $staff_id
        ]);

    redirect($_SERVER['HTTP_REFERER']);
}

    public function updateSite()
{
    $site_no  = $this->input->post('site_no');
    $asset_id = $this->input->post('asset_id');
    $user_id  = $this->session->userdata('user_id');

    // update users table
    $this->User_model->edit_user($user_id, [
        'site_no' => $site_no
    ]);

    // convert site_no → site_id
    $site = $this->db
        ->where('site_no', $site_no)
        ->get('sites')
        ->row();

    if (!$site) {
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    // update CURRENT viewed asset
    $this->db
        ->where('asset_id', $asset_id)
        ->update('assets', [
            'site_id' => $site->site_id
        ]);

    redirect($_SERVER['HTTP_REFERER']);
}

}
