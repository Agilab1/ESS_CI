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
        $this->load->model('AssetActivity_model');
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

    public function serials($asset_id = null)
    {
        // SAFETY GUARD
        if (empty($asset_id)) {
            redirect('Asset/list');
            return;
        }

        $data = new stdClass();
        $data->counts = $this->Dashboard_model->counts();
        $data->asset = $this->Asset_model->getById($asset_id);

        if (!$data->asset) {
            show_404();
        }

        $data->departments = $this->db->get('department')->result();
        $this->attachLoginUser($data);

        $data->serials = $this->db
            ->select('
            assdet.*,
            sites.site_name,
            staffs.emp_name,
            department.department_name,
            m.material_id,
            m.material_code
        ')
            ->from('assdet')
            ->join('sites', 'sites.site_id = assdet.site_id', 'left')
            ->join('staffs', 'staffs.staff_id = assdet.staff_id', 'left')
            ->join('department', 'department.department_id = assdet.department_id', 'left')
            ->join('material m', 'm.assdet_id = assdet.assdet_id', 'left')
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

    // public function add_detail($asset_id)
    // {
    //     $data = new stdClass();
    //     $data->counts = $this->Dashboard_model->counts();
    //     $data->asset  = $this->Asset_model->getById($asset_id);
    //     $data->ownership_type = $data->asset->ownership_type;

    //     $data->sites  = $this->db->get('sites')->result();
    //     $data->staffs = $this->db->get('staffs')->result();
    //     $data->departments = $this->db->get('department')->result();
    //     $data->action = 'add';
    //     $data->detail = null;

    //     $this->attachLoginUser($data);

    //     $this->load->view('incld/header');
    //     $this->load->view('incld/top_menu');
    //     $this->load->view('incld/side_menu');
    //     $this->load->view('user/dashboard', $data);
    //     $this->load->view('Asset/detail_form', $data);
    //     $this->load->view('incld/footer');
    // }


    // public function edit_detail($assdet_id)
    // {
    //     $data = new stdClass();
    //     $data->counts = $this->Dashboard_model->counts();
    //     $data->detail = $this->db->get_where('assdet', ['assdet_id' => $assdet_id])->row();
    //     $data->asset  = $this->Asset_model->getById($data->detail->asset_id);
    //     $data->ownership_type = $data->asset->ownership_type;
    //     $data->sites  = $this->db->get('sites')->result();
    //     $data->staffs = $this->db->get('staffs')->result();
    //     $data->departments = $this->db->get('department')->result();
    //     $data->action = 'edit';

    //     $this->attachLoginUser($data);

    //     $this->load->view('incld/header');
    //     $this->load->view('incld/top_menu');
    //     $this->load->view('incld/side_menu');
    //     $this->load->view('user/dashboard', $data);
    //     $this->load->view('Asset/detail_form', $data);
    //     $this->load->view('incld/footer');
    // }

    public function save_detail()
    {
        $asset_id = $this->input->post('asset_id');

        $data = [
            'asset_id'       => $asset_id,
            'serial_no'      => $this->input->post('serial_no'),
            'cat_id'         => 0,
            'model_no'       => $this->input->post('model_no'),
            'descr'          => $this->input->post('descr'),
            'site_id'        => $this->input->post('site_id'),
            'staff_id'       => $this->input->post('staff_id'),
            'department_id'  => $this->input->post('department_id'),
            'net_val'        => $this->input->post('net_val'),
            'status'         => $this->input->post('status')
        ];

        /* ================= DELETE OLD IMAGE IF EDIT ================= */

        if ($this->input->post('action') !== 'add') {
            $old = $this->db->get_where('assdet', [
                'assdet_id' => $this->input->post('assdet_id')
            ])->row();

            if (!empty($old->image)) {
                $oldPath = FCPATH . 'uploads/assets/' . $old->image;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }
        /* ================= IMAGE UPLOAD (REPLACE MODE) ================= */
        if (!empty($_FILES['asset_image']['name'])) {

            $serial = $this->input->post('serial_no');
            $serial = preg_replace('/[^A-Za-z0-9_\-]/', '_', $serial);

            $config['upload_path']   = FCPATH . 'uploads/assets/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name']     = $serial;   // always same name
            $config['overwrite']     = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('asset_image')) {
                $up = $this->upload->data();
                $data['image'] = $up['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
        }

        // 🔹 Get ownership type from asset
        $asset = $this->Asset_model->getById($asset_id);

        //  Correct ownership logic
        if ($asset->ownership_type === 'department') {
            // Department owns it → no staff allowed
            $data['staff_id'] = null;
        }
        // If ownership = staff → keep BOTH staff_id & department_id

        if ($this->input->post('action') === 'add') {
            $this->db->insert('assdet', $data);
            $this->session->set_flashdata('success', 'Asset detail added successfully!');
        } else {
            $this->db->where('assdet_id', $this->input->post('assdet_id'))
                ->update('assdet', $data);
            $this->session->set_flashdata('success', 'Asset detail updated successfully!');
        }

        redirect('asset/serials/' . $asset_id);
    }


    //


    public function detail($type = 'view', $id = null)
    {
        if (!$type || !$id) show_404();

        $data = new stdClass();
        $data->counts = $this->Dashboard_model->counts();

        switch ($type) {

            case "add":

                $data->action = "add";
                $data->asset  = $this->Asset_model->getById($id);
                if (!$data->asset) show_404();

                $data->ownership_type = $data->asset->ownership_type;

                $data->detail = (object)[
                    'assdet_id' => '',
                    'serial_no' => '',
                    'image'     => '',
                    'site_id'   => '',
                    'staff_id'  => '',
                    'department_id' => '',
                    'net_val'   => '',
                    'status'    => 1
                ];

                $data->sites  = $this->db->get('sites')->result();
                $data->staffs = $this->db->get('staffs')->result();
                $data->departments = $this->db->get('department')->result();
                break;


            case "edit":

                $data->action = "edit";
                $data->detail = $this->db->get_where('assdet', ['assdet_id' => $id])->row();
                if (!$data->detail) show_404();

                $data->asset = $this->Asset_model->getById($data->detail->asset_id);
                $data->ownership_type = $data->asset->ownership_type;

                $data->sites  = $this->db->get('sites')->result();
                $data->staffs = $this->db->get('staffs')->result();
                $data->departments = $this->db->get('department')->result();
                break;


            // case "view":

            //     // ================= NFC TAP DETECT =================
            //     // ================= NFC AUTO VERIFY (SESSION BASED) =================
            //     if ($this->session->userdata('nfc_scan') && $id) {

            //         $assdet = $this->db
            //             ->select('d.assdet_id, d.asset_id, d.serial_no, d.verified, a.asset_name')
            //             ->from('assdet d')
            //             ->join('assets a', 'a.asset_id = d.asset_id', 'left')
            //             ->where('d.assdet_id', $id)
            //             ->get()
            //             ->row();

            //         if ($assdet) {

            //             // 🔹 Only verify if not already verified
            //             if ((int)$assdet->verified !== 1) {

            //                 // ✅ VERIFY ASSET
            //                 $this->Asset_model->update_assdet_verify($id, 1);

            //                 // ✅ LOG ACTIVITY
            //                 $this->AssetActivity_model->log([
            //                     'assdet_id' => $assdet->assdet_id,
            //                     'asset_id'  => $assdet->asset_id,
            //                     'action'    => 'Verified',
            //                     'action_by' => $this->session->userdata('user_id'),
            //                     'source'    => 'NFC'
            //                 ]);

            //                 // ✅ ASSIGN SERIAL TO LOGGED USER
            //                 $logged_user_id = $this->session->userdata('user_id');
            //                 if ($logged_user_id && $assdet->serial_no) {
            //                     $this->User_model->edit_user($logged_user_id, [
            //                         'serial_no' => $assdet->serial_no,
            //                         'user_st'   => 'Active'
            //                     ]);
            //                 }

            //                 $this->session->set_flashdata(
            //                     'success',
            //                     'Asset "' . $assdet->asset_name . '" verified successfully'
            //                 );
            //             }
            //         }

            //         // 🔥 VERY IMPORTANT — ONE SCAN = ONE ACTION
            //         $this->session->unset_userdata('nfc_scan');

            //         redirect('asset/detail/view/' . $id);
            //         return;
            //     }

            //     // 


            //     // ================= MAIN DATA =================
            //     $data->action = "view";
            //     $data->detail = $this->Asset_model->get_asset_by_assdet($id);
            //     if (!$data->detail) show_404();

            //     $data->asset = $this->Asset_model->getById($data->detail->asset_id);
            //     $data->ownership_type = $data->asset->ownership_type ?? '';

            //     $data->sites  = $this->db->get('sites')->result();
            //     $data->staffs = $this->db->get('staffs')->result();
            //     $data->departments = $this->db->get('department')->result();
            //     break;

            // case "view":

            //     // ================= FETCH ASSET DETAIL =================
            //     $assdet = $this->db
            //         ->select('assdet_id, asset_id, serial_no, site_id, verified')
            //         ->from('assdet')
            //         ->where('assdet_id', $id)
            //         ->get()
            //         ->row();

            //     if (!$assdet) show_404();

            //     $asset = $this->Asset_model->getById($assdet->asset_id);

            //     // ================= NFC FLOW (SESSION BASED) =================
            //     if ($this->session->userdata('nfc_scan') === true) {

            //         $user_id = $this->session->userdata('user_id');
            //         $user    = $this->User_model->get_user($user_id);

            //         if ($user && $asset) {

            //             // 🔹 Ownership logic
            //             if ($asset->ownership_type === 'department') {

            //                 $this->db->where('assdet_id', $id)->update('assdet', [
            //                     'department_id' => $user->department_id,
            //                     'staff_id'      => null,
            //                     'verified'      => 1
            //                 ]);
            //             } else {

            //                 $this->db->where('assdet_id', $id)->update('assdet', [
            //                     'staff_id' => $user->staff_id,
            //                     'verified' => 1
            //                 ]);
            //             }

            //             // 🔥 UPDATE USER SERIAL
            //             $this->db->where('user_id', $user_id)->update('users', [
            //                 'serial_no' => $assdet->serial_no,
            //                 'user_st'   => 'Active'
            //             ]);

            //             // 🔥 SESSION REFRESH (IMPORTANT)
            //             $this->session->set_userdata('serial_no', $assdet->serial_no);

            //             // 🔥 ACTIVITY LOG
            //             $this->AssetActivity_model->log([
            //                 'assdet_id' => $id,
            //                 'asset_id'  => $assdet->asset_id,
            //                 'action'    => 'Verified',
            //                 'action_by' => $user_id,
            //                 'source'    => 'NFC'
            //             ]);
            //         }

            //         // ✅ one tap = one action
            //         $this->session->unset_userdata('nfc_scan');

            //         redirect('asset/detail/view/' . $id);
            //         return;
            //     }

            //     // ================= NORMAL VIEW =================
            //     $data->action = "view";
            //     $data->detail = $this->Asset_model->get_asset_by_assdet($id);
            //     $data->asset  = $asset;
            //     $data->ownership_type = $asset->ownership_type ?? '';

            //     $data->sites       = $this->db->get('sites')->result();
            //     $data->staffs      = $this->db->get('staffs')->result();
            //     $data->departments = $this->db->get('department')->result();
            //     break;

            case "view":

                $data->action = "view";
                $data->detail = $this->Asset_model->get_asset_by_assdet($id);
                if (!$data->detail) show_404();

                // ================= NFC AUTO VERIFY =================
                if ((int)$data->detail->verified === 0) {

                    // ✅ Verify asset
                    $this->Asset_model->update_assdet_verify($id, 1);

                    // ✅ Log activity
                    $this->AssetActivity_model->log([
                        'assdet_id' => $data->detail->assdet_id,
                        'asset_id'  => $data->detail->asset_id,
                        'action'    => 'Verified',
                        'action_by' => $this->session->userdata('user_id'),
                        'source'    => 'NFC'
                    ]);

                    // ✅ Assign serial to logged-in user
                    $logged_user_id = $this->session->userdata('user_id');
                    if ($logged_user_id) {
                        $this->User_model->edit_user($logged_user_id, [
                            'serial_no' => $data->detail->serial_no,
                            'user_st'   => 'Active'
                        ]);
                    }

                    $this->session->set_flashdata(
                        'success',
                        'Asset "' . $data->detail->asset_name . '" verified successfully'
                    );
                } else {
                    $this->session->set_flashdata(
                        'success',
                        'Asset "' . $data->detail->asset_name . '" already verified'
                    );
                }

                // ================= LOAD DATA =================
                $data->asset = $this->Asset_model->getById($data->detail->asset_id);
                $data->ownership_type = $data->asset->ownership_type ?? '';

                $data->sites  = $this->db->get('sites')->result();
                $data->staffs = $this->db->get('staffs')->result();
                $data->departments = $this->db->get('department')->result();

                break;



            case "delete":

                $this->db->where('assdet_id', $id)->delete('assdet');
                $this->session->set_flashdata('success', 'Asset detail deleted successfully!');
                redirect($_SERVER['HTTP_REFERER']);
                return;
        }

        $this->attachLoginUser($data);

        $this->load->view('incld/header');
        $this->load->view('Asset/detail_form', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
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
        $this->session->set_flashdata('success', 'Location updated successfully!');

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
        $this->AssetActivity_model->log([
            'assdet_id' => $assdet_id,
            'asset_id'  => null,
            'action'    => 'Owner Changed',
            'action_by' => $this->session->userdata('user_id'),
            'source'    => 'MANUAL'
        ]);
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

    public function activity_dashboard()
    {
        $this->load->model('AssetActivity_model');

        $data = new stdClass();
        $data->counts = $this->Dashboard_model->counts();
        $data->sites = $this->db->get('sites')->result();

        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Asset/activity_dashboard');
        $this->load->view('incld/footer');
    }

    public function activity_live_ajax()
    {
        $this->load->model('AssetActivity_model');
        echo json_encode($this->AssetActivity_model->get_live_activity());
    }
    public function activity_chart_ajax()
    {
        // Pie 1: Source wise
        $source = $this->db
            ->select('source, COUNT(*) as total')
            ->group_by('source')
            ->get('asset_activity_log')
            ->result();

        // Pie 2: Verified vs Unverified
        $verify = $this->db
            ->select('verified, COUNT(*) as total')
            ->join('assdet', 'assdet.assdet_id = asset_activity_log.assdet_id', 'left')
            ->group_by('verified')
            ->get('asset_activity_log')
            ->result();

        // Line: Timeline (last 1 hour)
        $timeline = $this->db
            ->select("DATE_FORMAT(created_at,'%H:%i') as time, COUNT(*) as total")
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour')))
            ->group_by("DATE_FORMAT(created_at,'%H:%i')")
            ->order_by('created_at', 'ASC')
            ->get('asset_activity_log')
            ->result();

        echo json_encode([
            'source'   => $source,
            'verify'   => $verify,
            'timeline' => $timeline
        ]);
    }

    public function asset_verify_summary_ajax()
    {
        // Total assets
        $total = $this->db->count_all('assdet');

        // Verified assets
        $verified = $this->db
            ->where('verified', 1)
            ->count_all_results('assdet');

        // Unverified assets
        $unverified = $this->db
            ->where('verified', 0)
            ->count_all_results('assdet');

        // Verified list
        $verified_list = $this->db
            ->select('a.asset_name, d.serial_no')
            ->from('assdet d')
            ->join('assets a', 'a.asset_id = d.asset_id', 'left')
            ->where('d.verified', 1)
            ->get()
            ->result();

        // Unverified list
        $unverified_list = $this->db
            ->select('a.asset_name, d.serial_no')
            ->from('assdet d')
            ->join('assets a', 'a.asset_id = d.asset_id', 'left')
            ->where('d.verified', 0)
            ->get()
            ->result();

        echo json_encode([
            'total' => $total,
            'verified' => $verified,
            'unverified' => $unverified,
            'verified_list' => $verified_list,
            'unverified_list' => $unverified_list
        ]);
    }
    public function asset_verify_chart_ajax()
    {
        $site_id = $this->input->get('site_id');

        // =========================
        // PIE : VERIFIED COUNT
        // =========================
        if (!empty($site_id)) {
            $this->db->where('site_id', $site_id);
        }
        $verified = $this->db
            ->where('verified', 1)
            ->count_all_results('assdet');

        // =========================
        // PIE : UNVERIFIED COUNT
        // =========================
        if (!empty($site_id)) {
            $this->db->where('site_id', $site_id);
        }
        $unverified = $this->db
            ->where('verified', 0)
            ->count_all_results('assdet');

        $total = $verified + $unverified;

        // =========================
        // LINE : VERIFIED ACTIVITY
        // =========================
        $this->db
            ->select("
            DATE_FORMAT(l.created_at,'%H:%i') as time,
            COUNT(*) as verified
        ")
            ->from('asset_activity_log l')
            ->join('assdet d', 'd.assdet_id = l.assdet_id', 'left')
            ->where('l.action', 'Verified')
            ->where('l.created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->group_by("DATE_FORMAT(l.created_at,'%H:%i')")
            ->order_by('l.created_at', 'ASC');

        // Site filter only if selected
        if (!empty($site_id)) {
            $this->db->where('d.site_id', $site_id);
        }

        $timeline = $this->db->get()->result();

        echo json_encode([
            'total'      => $total,
            'verified'   => $verified,
            'unverified' => $unverified,
            'timeline'   => $timeline
        ]);
    }
    // ================================
    // PIE SLICE CLICK → ASSET LIST
    // ================================
    public function asset_list_by_verify_ajax()
    {
        $verified = $this->input->get('verified'); // 1 or 0
        $site_id  = $this->input->get('site_id');

        $this->db
            ->select('
            a.asset_name,
            d.serial_no,
            s.site_name
        ')
            ->from('assdet d')
            ->join('assets a', 'a.asset_id = d.asset_id', 'left')
            ->join('sites s', 's.site_id = d.site_id', 'left')
            ->where('d.verified', $verified);

        if (!empty($site_id)) {
            $this->db->where('d.site_id', $site_id);
        }

        $result = $this->db->get()->result();
        echo json_encode($result);
    }
}
