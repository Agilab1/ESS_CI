<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends CI_Model{
   public function __construct()
{
    parent::__construct();
    $this->load->model('Location_model');
    $this->load->model('Dashboard_model');
    $this->load->library('form_validation');
    $this->load->library('session'); // ✅ already correct
    $this->load->model('User_model');
    $this->load->model('Asset_model');
}
public function getAll()
{
    return $this->db->get('sites')->result();
}
public function getById($site_id)
{
    return $this->db
        ->where('site_id', $site_id)
        ->get('sites')
        ->row();
}
public function get_assets_by_site($site_id)
{
    return $this->db
        ->select('ad.*, a.asset_name, s.emp_name')
        ->from('assdet ad')
        ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
        ->join('staffs s', 's.staff_id = ad.staff_id', 'left')
        ->where('ad.site_id', $site_id)
        ->get()
        ->result();
}
public function updateLocation($site_id, $data)
{
    return $this->db
        ->where('site_id', $site_id)
        ->update('sites', $data);
}
    public function list()
    {
        $data = new stdClass();

        $data->locations = $this->Location_model->getAll();
        $data->counts = $this->Dashboard_model->counts();

        $assetCounts = $this->Asset_model->get_asset_count_by_site();

        $assetMap = [];
        foreach ($assetCounts as $row) {
            $assetMap[$row->site_id] = $row->total;
        }

        $data->assetMap = $assetMap;

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Location/list', $data);
        $this->load->view('incld/script');
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
    }

    public function add()
    {
        $data = new stdClass();
        $data->action = 'add';
        $data->location = (object) [
            'site_id' => '',
            'site_no' => '',
            'site_name' => '',
            'last_visit' => '',
            'verify_asset' => '',
            'status' => '',
            'access_flag' => '',
            'access_by' => ''
        ];

        $this->load->view('incld/header');
        $this->load->view('Location/add', $data);
        $this->load->view('incld/footer');
    }

    public function edit($site_id = null)
    {
        if ($site_id === null) {
            redirect('Location/list');
            return;
        }

        $data = new stdClass();
        $data->action = 'edit';
        $data->location = $this->Location_model->getById($site_id);

        if (!$data->location)
            show_404();

        $this->load->view('incld/header');
        $this->load->view('Location/add', $data);
        $this->load->view('incld/footer');
    }

    public function delete($site_id = null)
    {
        if ($site_id === null) {
            redirect('Location/list');
            return;
        }

        $location = $this->Location_model->getById($site_id);
        if (!$location)
            show_404();

        $this->Location_model->deleteLocation($site_id);
        $this->session->set_flashdata('success', "Location deleted successfully!");

        redirect('Location/list');
    }

    // ============================
    // ✅ YOUR REQUIRED FIX LOGIC
    // ============================
    public function save()
    {
        $action  = strtolower($this->input->post('action'));
        $site_id = $this->input->post('site_id');

        $inventory_checked = $this->input->post('inventory_checked') ? 1 : 0;

        $data = $this->validate($inventory_checked);
        if (!$data) {
            return $action === 'add'
                ? $this->add()
                : $this->edit($site_id);
        }

        if ($action === 'add') {
            $this->Location_model->insertLocation($data);
        } else {
            $this->Location_model->updateLocation($site_id, $data);
        }

        // 🔥 ONLY NEW LOGIC (NO OTHER CHANGE)
        if ($action === 'edit') {

            if ($inventory_checked == 1) {
                // ✔ CHECKED → RESET ALL
                $this->db
                    ->where('site_id', $site_id)
                    ->update('assdet', ['verified' => 0]);
            }

            // ❌ UNCHECKED → DO NOTHING (DATA SAFE)

            // existing code (unchanged)
            $this->db
                ->where('site_id', $site_id)
                ->update('sites', [
                    'inventory_checked' => $inventory_checked,
                    'verify_asset'      => ($inventory_checked == 1) ? 0 : 1
                ]);
        }

        $this->session->set_flashdata(
            'success',
            'Location saved successfully.'
        );

        redirect('Location/list');
    }

    private function validate($inventory_checked)
    {
        $this->form_validation->set_rules('site_no', 'Site Number', 'required');
        $this->form_validation->set_rules('site_name', 'Site Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if (!$this->form_validation->run()) {
            return false;
        }

        $verify_asset = ($inventory_checked == 1) ? 0 : 1;

        return [
            'site_id' => $this->input->post('site_id'),
            'site_no' => $this->input->post('site_no'),
            'site_name' => $this->input->post('site_name'),
            'last_visit' => $this->input->post('last_visit'),
            'inventory_checked' => $inventory_checked,
            'verify_asset' => $verify_asset,
            'status' => $this->input->post('status'),
            'access_flag' => $this->input->post('access_flag'),
            'access_by' => $this->input->post('access_by')
        ];
    }
    

    public function asset_list($site_id)
    {
        $site = $this->Location_model->getById($site_id);
        $assets = $this->Location_model->get_assets_by_site($site_id);

        if (!$site) {
            show_404();
        }

        $verified = 0;
        $unverified = 0;

        foreach ($assets as $a) {
            if (isset($a->verified) && (int)$a->verified === 1) {
                $verified++;
            } else {
                $unverified++;
            }
        }

        $data = [
            'site' => $site,
            'assets' => $assets,
            'verify_count' => [
                'verified'   => $verified,
                'unverified' => $unverified
            ]
        ];

        $this->load->view('incld/header');
        $this->load->view('Location/asset_list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
        $this->load->view('incld/footer');
    }

    public function get_verify_count_ajax($site_id)
    {
        $verified = $this->db
            ->where('site_id', $site_id)
            ->where('verified', 1)
            ->count_all_results('assdet');

        $unverified = $this->db
            ->where('site_id', $site_id)
            ->where('verified !=', 1)
            ->count_all_results('assdet');

        echo json_encode([
            'verified'   => $verified,
            'unverified' => $unverified
        ]);
    }
}