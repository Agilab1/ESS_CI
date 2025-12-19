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
                if ($this->input->get('nfc') == 1) {

                    $logged_user_id = $this->session->userdata('user_id');
                    $asset_no = $data->asset->asset_no;

                    if ($logged_user_id && $asset_no) {
                        $this->User_model->edit_user($logged_user_id, [
                            'asset_no' => $asset_no,
                            'user_st'  => 'Active'
                        ]);
                    }
                }
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
        $asset_id = $this->input->post('asset_id');
        $staff_id = $this->input->post('staff_id');

        // 1. Update asset
        $this->Asset_model->updateAsset($asset_id, [
            'staff_id' => $staff_id
        ]);

        // 2. Get asset details
        $asset = $this->Asset_model->getById($asset_id);

        if ($asset && $asset->asset_no) {

            // Update users linked with this asset
            $this->User_model->updateByAssetNo($asset->asset_no, [
                'staff_id' => $staff_id
            ]);
        }

        $this->session->set_flashdata('success', 'Staff updated successfully');
        redirect('Asset/action/view/' . $asset_id);
    }
    public function updateSite()
    {
        $asset_id = $this->input->post('asset_id');
        $site_id  = $this->input->post('site_id');

        // 1. Update asset
        $this->Asset_model->updateAsset($asset_id, [
            'site_id' => $site_id
        ]);

        // 2. Get asset + site
        $asset = $this->Asset_model->getById($asset_id);

        if ($asset && $asset->asset_no && $asset->site_no) {

            // Update users linked with this asset
            $this->User_model->updateByAssetNo($asset->asset_no, [
                'site_no' => $asset->site_no
            ]);
        }

        $this->session->set_flashdata('success', 'Site updated successfully');
        redirect('Asset/action/view/' . $asset_id);
    }
}
