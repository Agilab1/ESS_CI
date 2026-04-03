<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Work_model');
        $this->load->model('Holiday_model');
        $this->load->model('User_model');
    }
    private function is_admin()
    {
        return ((int)$this->session->userdata('role_id') === 1);
    }

    public function status($staff_id)
    {
        $date = $this->input->get('date');
        $mode = $this->input->get('mode');

        if (!$date) {
            $date = date('Y-m-d');
        }
        $data['staff'] = $this->db->get_where('staffs', [
            'staff_id' => $staff_id
        ])->row();
        $data['todayStatus'] = $this->Work_model->get_status($staff_id, $date);
        $data['today'] = $date;
        $month = $this->input->get('month');
        $year  = $this->input->get('year');

        if (!$month) $month = date('m', strtotime($date));
        if (!$year)  $year  = date('Y', strtotime($date));

        $data['month'] = $month;
        $data['year']  = $year;

        // FETCH MONTHLY ATTENDANCE
        $data['attendance'] = $this->Work_model->get_monthly_attendance(
            $staff_id,
            $month,
            $year
        );

        // PASS BASIC VALUES
        $data['staff_id'] = $staff_id;
        $data['selected_date'] = $date;
        $data['mode'] = $mode;
        $data['counts'] = $this->Dashboard_model->counts();
        // LOAD VIEW
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        // $this->load->view('incld/top_menu');
        // $this->load->view('incld/side_menu');
        // $this->load->view('user/dashboard', $data);
        $this->load->view('Staff/form', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
        $this->load->view('incld/footer');
    }

    public function save_status()
    {
        if (!$this->is_admin()) {
            show_error('Unauthorized access', 403);
        }
        $staff_id = $this->input->post('staff_id');
        $date     = $this->input->post('date');
        $status   = $this->input->post('staff_st');
        $remark   = $this->input->post('remark');

        if (!$staff_id || !$date) {
            show_error("Missing Staff ID or Date");
        }

        // Prepare data
        $data = [
            'staff_id' => $staff_id,
            'date'     => $date,
            'staff_st' => $status,
            'remark'   => $remark,
        ];

        // Insert/Update work status
        $this->Work_model->upsert_status($data);

        $this->session->set_flashdata("success", "Status saved!");

        // Redirect back to attendance page
        redirect('Staff/emp_list/' . $staff_id . '?date=' . $date);
    }

    public function delete_status($staff_id, $date)
    {
        if (!$this->is_admin()) {
            show_error('Unauthorized access', 403);
        }
        $this->Work_model->delete_status($staff_id, $date);
        $this->session->set_flashdata('success', 'Record deleted!');
        redirect('Staff/emp_list/' . $staff_id);
    }

    // ================= PUNCH DETAILS (PORTRAIT VIEW) =================
    public function punch_details($staff_id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('user');
        }

        $data['staff'] = $this->Staff_model->get_user($staff_id);
        if (!$data['staff']) show_error('Employee not found');

        $month = $this->input->get('month') ?? date('m');
        $year  = $this->input->get('year') ?? date('Y');

        $data['month'] = $month;
        $data['year']  = $year;
        $data['daysInMonth'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $records = $this->Work_model->get_monthly_attendance($staff_id, $month, $year);

        $attendance = [];
        foreach ($records as $r) {
            $attendance[$r->punch_date] = $r;
        }

        $data['attendance'] = $attendance;
        $this->load->view('incld/header');
        $this->load->view('Staff/punch_details', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
    }

    // MAIN PAGE — MONTHLY ATTENDANCE
    public function emp_list($staff_id = null)
    {
        if ($staff_id === null) {
            $staff_id = $this->input->get('staff_id');
        }
        if (empty($staff_id)) redirect('Staff/list');

        $data['staff'] = $this->Staff_model->get_user($staff_id);
        if (!$data['staff']) show_error("Employee not found.");

        //  BLOCK NFC AUTO-PUNCH FOR NORMAL USERS
        if ($this->input->get('auto') && (int)$this->session->userdata('role_id') !== 1) {
            redirect('Staff/punch_details/' . $staff_id);
            return;
        }

        // ================= NFC AUTO-PUNCH (ADMIN ONLY) =================
        if ($this->input->get('auto') && (int)$this->session->userdata('role_id') === 1) {

            $today = date('Y-m-d');
            $time  = date('H:i:s');
            $day   = date('l');

            if ($day === 'Saturday' || $day === 'Sunday') {
                $this->session->set_flashdata(
                    'error',
                    'Saturday / Sunday punch not allowed'
                );
                redirect('Staff/punch_details/' . $staff_id);
                return;
            }

            $exists = $this->db->get_where('works', [
                'staff_id' => $staff_id,
                'date'     => $today
            ])->row();

            if (!$exists) {

                $remark = null;
                if (strtotime($time) > strtotime('10:00:00')) {
                    $remark = 'Late';
                }
                // CHECK IN
                $this->Work_model->insert_cin([
                    'staff_id' => $staff_id,
                    'staff_st' => 'Punched',
                    'date'     => $today,
                    'cin_time' => $time,
                    'remark'   => $remark
                ]);

                $this->session->set_flashdata(
                    'success',
                    $staff_id . ' CHECK IN at ' . date('h:i A', strtotime($time))
                );
            } else {
                // CHECK OUT
                $this->Work_model->update_cout([
                    'staff_id'  => $staff_id,
                    'date'      => $today,
                    'cout_time' => $time
                ]);

                $this->session->set_flashdata(
                    'success',
                    $staff_id . ' CHECK OUT at ' . date('h:i A', strtotime($time))
                );
            }

            redirect(
                'Staff/punch_details/' . $staff_id .
                    '?month=' . date('m', strtotime($today)) .
                    '&year=' . date('Y', strtotime($today))
            );
        }


        // ================= NORMAL MONTH VIEW =================
        if ($this->input->get('date')) {
            $d = $this->input->get('date');
            $month = date('m', strtotime($d));
            $year  = date('Y', strtotime($d));
        } else {
            $month = $this->input->get('month') ?? date('m');
            $year  = $this->input->get('year') ?? date('Y');
        }


        // PREV / NEXT LOGIC
        $prevM = $month - 1;
        $prevY = $year;
        if ($prevM < 1) {
            $prevM = 12;
            $prevY--;
        }

        $nextM = $month + 1;
        $nextY = $year;
        if ($nextM > 12) {
            $nextM = 1;
            $nextY++;
        }

        $data['month'] = $month;
        $data['year']  = $year;
        $data['prevM'] = $prevM;
        $data['prevY'] = $prevY;
        $data['nextM'] = $nextM;
        $data['nextY'] = $nextY;

        $data['works'] = $this->Work_model->get_monthly_attendance($staff_id, $month, $year);

        $data['holiday_model'] = $this->Holiday_model;
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Staff/emp_details', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
    }




    public function update_status_inline()
    {
        if (!$this->is_admin()) {
            echo json_encode(["status" => "unauthorized"]);
            return;
        }
        $data = [
            'staff_id' => $this->input->post('staff_id'),
            'date'     => $this->input->post('date'),
            'staff_st' => $this->input->post('staff_st'),
            'remark'   => $this->input->post('remark'),
        ];

        $this->Work_model->upsert_status($data);
        echo json_encode(["status" => "success"]);
    }



    public function list()
    {
        $data['staffs'] = $this->Staff_model->get_user();
        $data['counts'] = $this->Dashboard_model->counts();
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Staff/list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }



    public function add()
    {
        if (!$this->is_admin()) show_error('Unauthorized', 403);
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
            'staff_st' => '',
            'remark'   => ''
        ];

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }



    public function edit($staff_id)
    {
        if (!$this->is_admin()) show_error('Unauthorized', 403);
        $data = new stdClass();
        $data->action = 'edit';
        $data->staff  = $this->Staff_model->get_user($staff_id);
        if (!$data->staff) show_404();

        $data->staff->join_dt  = !empty($data->staff->join_dt) ? date('Y-m-d', strtotime($data->staff->join_dt)) : '';
        $data->staff->birth_dt = !empty($data->staff->birth_dt) ? date('Y-m-d', strtotime($data->staff->birth_dt)) : '';

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }


    public function view($staff_id)
    {
        $data = new stdClass();
        $data->action = 'view';

        $data->staff = $this->Staff_model->get_user($staff_id);
        if (!$data->staff) show_404();

        // ===============================
        // 🔥 STAFF NFC FLOW (WITHOUT ?nfc)
        // ===============================

        $logged_user_id = $this->session->userdata('user_id');

        if ($logged_user_id) {

            // 1️ Assign staff to logged-in user
            $this->User_model->edit_user($logged_user_id, [
                'staff_id' => $staff_id,
                'user_st'  => 'Active'
            ]);

            // 2️ Set flow flag ONLY for next page
            $this->session->set_userdata('nfc_staff_flow', true);
        }

        // ===============================
        // NORMAL VIEW RENDER
        // ===============================

        $data->staff->join_dt  = !empty($data->staff->join_dt)
            ? date('Y-m-d', strtotime($data->staff->join_dt)) : '';

        $data->staff->birth_dt = !empty($data->staff->birth_dt)
            ? date('Y-m-d', strtotime($data->staff->birth_dt)) : '';

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }



    public function delete($staff_id)
    {
        if (!$this->is_admin()) show_error('Unauthorized', 403);
        $data = new stdClass();
        $data->action = 'delete';
        $data->staff = $this->Staff_model->get_user($staff_id);
        if (!$data->staff) show_404();

        $this->Staff_model->delete_user($staff_id);

        $this->session->set_flashdata('success', $staff_id . ' Staff deleted successfully!');
        redirect('Staff/list');
    }
    private function validate()
    {
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'required|trim');
        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('nfc_card', 'NFC Card No', 'required|trim');
        $this->form_validation->set_rules('desig', 'Designation', 'required|trim');
        $this->form_validation->set_rules('join_dt', 'Join Date', 'required|trim');
        $this->form_validation->set_rules('phn_no', 'Phone Number', 'required|trim|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('birth_dt', 'Birth Date', 'required|trim');
        $this->form_validation->set_rules('staff_st', 'Status', 'required|trim');
        $this->form_validation->set_rules('remark', 'Remark', 'trim');

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
                'remark'   => $this->input->post('remark')
            ];
        } else {
            return false;
        }
    }
    public function save()
    {
        if (!$this->is_admin()) show_error('Unauthorized', 403);
        $action = strtolower($this->input->post('action'));
        $staff_id = $this->input->post('old_staff_id');

        switch ($action) {
            case 'add':
                $data = $this->validate();
                if ($data) {

                    if ($this->Staff_model->exists($data['staff_id'])) {
                        $this->session->set_flashdata('error', 'This Staff ID already exists!');
                        redirect('Staff/add');
                    }

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
                    $staff_id = $data['staff_id'];
                    $this->session->set_flashdata('success', $staff_id . ' Staff updated successfully!');
                    redirect('Staff/list');
                } else {
                    $this->edit($staff_id);
                }
                break;

            case 'delete':
                $this->Staff_model->delete_user($staff_id);
                $this->session->set_flashdata('success', $staff_id . ' Staff deleted successfully!');
                redirect('Staff/list');
                break;

            default:
                show_error("Invalid Action");
        }
    }
    public function asset_form($staff_id)
{
    $this->load->model('Staff_model');
    $this->load->model('Asset_model');

    $data['staff'] = $this->Staff_model->get_by_id($staff_id);
    $data['assets'] = $this->Asset_model->get_assets_with_site_by_staff($staff_id);

    // ✅ ADD THIS LINE (IMPORTANT)
    $data['serials'] = $this->db->get('assdet')->result();

    // 🔥 ALL STAFF LIST
    $data['all_staff'] = $this->Staff_model->get_user();

    $this->load->view('incld/header');
    $this->load->view('Staff/asset_form', $data);
    $this->load->view('incld/footer');
}
    // public function change_asset_owner()
    // {
    //     $assdet_id = $this->input->post('assdet_id');
    //     $staff_id  = $this->input->post('staff_id');

    //     $this->load->model('Asset_model');

    //     // update ownership
    //     $this->Asset_model->update_asset_owner($assdet_id, $staff_id);

    //     // 🔥 fetch updated asset row (new owner ke liye)
    //     $asset = $this->Asset_model->get_asset_by_assdet($assdet_id);

    //     echo json_encode([
    //         'status' => 'success',
    //         'asset'  => $asset
    //     ]);
    // }

 public function change_asset_owner()
    {
        if (!$this->is_admin()) {
            echo json_encode(['status' => 'unauthorized']);
            return;
        }

        $assdet_id = $this->input->post('assdet_id');
        $staff_id  = $this->input->post('staff_id');

        if (!$assdet_id || !$staff_id) {
            echo json_encode(['status' => 'invalid']);
            return;
        }

        $this->load->model('Asset_model');

        $this->Asset_model->update_asset_owner($assdet_id, $staff_id);

        echo json_encode(['status' => 'success']);

    }
     public function add_asset_ajax()
    {
        $this->load->model('Staff_model');

        $data = [
            'staff_id'   => $this->input->post('staff_id'),
            'asset_id'   => $this->input->post('asset_id'),
            'asset_name' => $this->input->post('asset_name'),
            'serial_no'  => $this->input->post('serial_no'),
            'site_id'  => $this->input->post('site_id')
        ];

        $assdet_id = $this->Staff_model->insert_asset($data);

        if ($assdet_id) {
            echo json_encode([
                'status' => 'success',
                'assdet_id' => $assdet_id
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

     public function get_asset_by_serial()
    {
        $serial_no = $this->input->post('serial_no');

        $asset = $this->db
            ->select('ad.asset_id, a.asset_name, ad.site_id')
            ->from('assdet ad')
            ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
            ->where('ad.serial_no', $serial_no)
            ->get()
            ->row();

        if ($asset) {
            echo json_encode([
                'status' => 'success',
                'data'   => $asset
            ]);
        } else {
            echo json_encode([
                'status' => 'error'
            ]);
        }
    }
     public function save_staff_asset()
    {
        // 🔥 Correct model
        $this->load->model('Assdet_model');

        $data = array(
            'staff_id'  => $this->input->post('staff_id'),
            'serial_no' => $this->input->post('serial_no'),
            'asset_id'  => $this->input->post('asset_id'),
            'site_id'   => $this->input->post('site_id')
        );

        // 🔥 Correct insert
        $this->Assdet_model->insert($data);
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function save_single_asset()
    {
        $this->db->insert('staff_asset', [
            'staff_id'   => $this->input->post('staff_id'),
            'serial_no'  => $this->input->post('serial_no'),
            'asset_id'   => $this->input->post('asset_id'),
            'asset_name' => $this->input->post('asset_name'),
            'site_id'  => $this->input->post('site_id')
        ]);

        echo json_encode(['status' => 'success']);
    }


    public function get_asset_name()
    {
        $asset = $this->db
            ->where('asset_id', $this->input->post('asset_id'))
            ->get('assets')
            ->row();

        if ($asset) {
            echo json_encode([
                'status' => 'success',
                'asset_name' => $asset->asset_name
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // staff asset_form serial no dropdown ajax method 
    public function get_asset_by_serial_ajax()
    {
        $serial_no = $this->input->post('serial_no');

        $this->load->model('Asset_model');
        $asset = $this->Asset_model->get_asset_by_serial($serial_no);

        if ($asset) {
            echo json_encode([
                'status' => 'success',
                'data'   => $asset
            ]);
        } else {
            echo json_encode([
                'status' => 'error'
            ]);
        }
    }

    // staff/asset_form serial_no row delete
    public function delete_asset($assdet_id = null)
    {
        // 🔐 Admin protection (optional but recommended)
        if (!$this->is_admin()) {
            show_error('Unauthorized', 403);
        }

        if ($assdet_id === null) {
            show_404();
        }

        $this->db->where('assdet_id', $assdet_id)->delete('assdet');

        $this->session->set_flashdata('success', 'Asset deleted successfully');

        redirect($_SERVER['HTTP_REFERER']);
    }



    //
}
