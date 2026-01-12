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
            'type_id'    => $this->input->post('type_id'),
            'ownership_type' => $this->input->post('ownership_type'),

        ];

        // Duplicate Asset Number Check
        $asset_no = trim($this->input->post('asset_no'));
        $asset_id = $this->input->post('asset_id');

        $this->db->where('asset_no', $asset_no);
        if (!empty($asset_id)) {
            $this->db->where('asset_id !=', $asset_id);
        }

        if ($this->db->get('assets')->row()) {
            $this->session->set_flashdata('error', 'Asset Number already exists!');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

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
        } elseif ($action == 'edit') {
            $asset_id = $this->input->post('asset_id');
            $this->Asset_model->updateAsset($asset_id, $assetData);
            $this->session->set_flashdata('success', 'Asset updated successfully!');
        }

        redirect('Asset/list');
    }

    public function serials($asset_id)
    {
        $data = new stdClass();
        $data->counts = $this->Dashboard_model->counts();
        $data->asset = $this->Asset_model->getById($asset_id);
        if (!$data->asset) show_404();

        $data->departments = $this->db->get('department')->result();
        $this->attachLoginUser($data);

        $data->serials = $this->db
            ->select('assdet.*, sites.site_name, staffs.emp_name, department.department_name')
            ->from('assdet')
            ->join('sites', 'sites.site_id = assdet.site_id', 'left')
            ->join('staffs', 'staffs.staff_id = assdet.staff_id', 'left')
            ->join('department', 'department.department_id = assdet.department_id', 'left')
            ->where('assdet.asset_id', $asset_id)
            ->get()
            ->result();

       
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
        $data->ownership_type = $data->asset->ownership_type;

        $data->sites  = $this->db->get('sites')->result();
        $data->staffs = $this->db->get('staffs')->result();
        $data->departments = $this->db->get('department')->result();
        $data->action = 'add';
        $data->detail = null;

        $this->attachLoginUser($data);

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
        $data->ownership_type = $data->asset->ownership_type;
        $data->sites  = $this->db->get('sites')->result();
        $data->staffs = $this->db->get('staffs')->result();
        $data->departments = $this->db->get('department')->result();
        $data->action = 'edit';

        $this->attachLoginUser($data);

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Asset/detail_form', $data);
        $this->load->view('incld/footer');
    }

    public function save_detail()
    {
        $asset_id = $this->input->post('asset_id');

        $data = [
            'asset_id'       => $asset_id,
            'serial_no'      => $this->input->post('serial_no'),
            'site_id'        => $this->input->post('site_id'),
            'staff_id'       => $this->input->post('staff_id'),
            'department_id'  => $this->input->post('department_id'),
            'net_val'        => $this->input->post('net_val'),
            'status'         => $this->input->post('status')
        ];

        // 🔹 Get ownership type from asset
        $asset = $this->Asset_model->getById($asset_id);

        if ($asset->ownership_type === 'department') {
            // Department owns it → wipe staff
            $data['staff_id'] = null;
        } else {
            // Staff owns it → wipe department
            $data['department_id'] = null;
        }

        if ($this->input->post('action') === 'add') {
            $this->db->insert('assdet', $data);
        } else {
            $this->db->where('assdet_id', $this->input->post('assdet_id'))
                ->update('assdet', $data);
        }

        redirect('asset/serials/' . $asset_id);
    }


    // 


    public function detail($type = 'add', $id = null)
    {
        $data = new stdClass();
        $data->counts = $this->Dashboard_model->counts();

        switch ($type) {
            case "edit":

                $data->action = "edit";
                $data->detail = $this->db
                    ->get_where('assdet', ['assdet_id' => $id])
                    ->row();

                if (!$data->detail) show_404();

                $data->asset = $this->Asset_model
                    ->getById($data->detail->asset_id);
                $data->ownership_type = $data->asset->ownership_type;
                $data->sites  = $this->db->get('sites')->result();
                $data->staffs = $this->db->get('staffs')->result();

                break;


            case "view":

                // NFC TAP DETECT
                if ($this->input->get('nfc') == 1 && $id) {

                    $this->Asset_model->update_assdet_verify($id, 1);

                    $logged_user_id = $this->session->userdata('user_id');

                    $assdet = $this->db
                        ->select('serial_no')
                        ->get_where('assdet', ['assdet_id' => $id])
                        ->row();

                    if (!empty($logged_user_id) && !empty($assdet->serial_no)) {
                        $this->User_model->edit_user($logged_user_id, [
                            'serial_no' => $assdet->serial_no,
                            'user_st'   => 'Active'
                        ]);
                    }
                }

                // 🔹 MAIN DETAIL (FIXED)
                $data->action = "view";
                $data->detail = $this->Asset_model->get_asset_by_assdet($id);

                if (!$data->detail) show_404();

                $data->asset = $this->Asset_model
                    ->getById($data->detail->asset_id);

                //  ADD THESE TWO LINES (IMPORTANT)
                $data->sites  = $this->db->get('sites')->result();
                $data->staffs = $this->db->get('staffs')->result();

                break;

            default:
                show_404();
        }

        $this->attachLoginUser($data);

        $this->load->view('incld/header');
        $this->load->view('Asset/detail_form', $data);
        $this->load->view('incld/footer');
    }




    public function updateStaff()
    {
        $staff_id = $this->input->post('staff_id');

        $this->db
            ->where('assdet_id', $this->input->post('assdet_id'))
            ->update('assdet', ['staff_id' => $staff_id]);

        $this->session->set_flashdata('success', 'Staff updated successfully');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updateSite()
    {
        $assdet_id = (int) $this->input->post('assdet_id');
        $site_id   = (int) $this->input->post('site_id');

        if (!$assdet_id || !$site_id) {
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $this->db->where('assdet_id', $assdet_id)
            ->limit(1)
            ->update('assdet', ['site_id' => $site_id]);

        redirect($_SERVER['HTTP_REFERER']);
    }

    private function attachLoginUser(&$data)
    {
        $data->loginUser = $this->User_model->get_user(
            $this->session->userdata('user_id')
        );
    }

    public function verify_assdet()
    {
        $assdet_id = $this->input->post('assdet_id');
        $verified  = $this->input->post('verified');

        $this->db->where('assdet_id', $assdet_id)
            ->update('assdet', ['verified' => $verified]);

        echo json_encode(['success' => true]);
    }
    public function change_owner()
    {
        $assdet_id = $this->input->post('assdet_id');
        $staff_id  = $this->input->post('staff_id');

        if (!$assdet_id || !$staff_id) {
            show_error('Invalid data');
        }

        $this->db->where('assdet_id', $assdet_id)
            ->update('assdet', [
                'staff_id' => $staff_id
            ]);

        echo json_encode(['status' => 'success']);
    }


    // asset nfc scan using ajax for location/asset_view .
    public function check_verify_ajax($assdet_id)
{
    $row = $this->db
        ->select('verified')
        ->where('assdet_id', $assdet_id)
        ->get('assdet')
        ->row();

    echo json_encode([
        'verified' => $row ? (int)$row->verified : 0
    ]);
}

}
