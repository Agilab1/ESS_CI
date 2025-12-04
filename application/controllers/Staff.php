<?php
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
    }

    public function status($staff_id = null)
    {
        if ($staff_id === null) {
            show_error("Staff ID missing in URL");
        }

        $data['staff'] = $this->Staff_model->get_user($staff_id);
        if (!$data['staff']) show_404();

        // Get date from URL or today
        $data['today'] = $this->input->get('date') ?? date('Y-m-d');

        // ⭐ GET FULL ROW FROM WORKS TABLE (Status + Remark)
        $row = $this->db->get_where('works', [
            'staff_id' => $staff_id,
            'date'     => $data['today']
        ])->row();

        // Pass data to view
        $data['todayStatus'] = $row ? $row->staff_st : "No Punch";
        $data['todayRemark'] = $row ? $row->remark : "";

        $data['counts'] = $this->Dashboard_model->counts();

        $mode = $this->input->get('mode') ?? 'edit';
        $data['mode'] = $mode;
        $data['is_view_only'] = ($mode === 'view');

        // Load views
        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Staff/form', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
    }

    public function delete_status($staff_id, $date)
    {
        $this->Work_model->delete_status($staff_id, $date);
        $this->session->set_flashdata('success', 'Record deleted!');
        redirect('Staff/emp_list/' . $staff_id);
    }

    // 🔥 SHOW MONTHLY ATTENDANCE + SAVE STATUS + REMARK
    public function emp_list($staff_id = null)
    {
        if ($staff_id === null) {
            $staff_id = $this->input->get('staff_id');
        }
        if (empty($staff_id)) redirect('Staff/list');

        $data['staff'] = $this->Staff_model->get_user($staff_id);
        if (!$data['staff']) show_error("Employee not found.");

        if ($this->input->method() === 'post') {

            $insert = [
                'staff_id' => $staff_id,
                'staff_st' => $this->input->post('staff_st'),
                'remark'   => $this->input->post('remark'),   // ⭐ NEW
                'date'     => $this->input->post('old_date')
            ];

            $this->Work_model->upsert_status($insert);
            redirect('Staff/emp_list/' . $staff_id);
        }

        // ⭐ Month + Year (GET params)
        $month = $this->input->get('month') ?? date('m');
        $year  = $this->input->get('year') ?? date('Y');

        // ⭐ Prev/Next Month
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

        // ⭐ Pass to View (THIS IS IMPORTANT)
        $data['month'] = $month;
        $data['year']  = $year;
        $data['prevM'] = $prevM;
        $data['prevY'] = $prevY;
        $data['nextM'] = $nextM;
        $data['nextY'] = $nextY;

        // ⭐ Monthly Attendance
        $data['works'] = $this->Work_model->get_monthly_attendance(
            $staff_id,
            $month,
            $year
        );

        $data['holiday_model'] = $this->Holiday_model;
        $data['counts'] = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Staff/emp_details', $data); // MUST RECEIVE month/year
        $this->load->view('incld/jslib');
        $this->load->view('incld/script');
    }



    // 🔥 INLINE UPDATE (AJAX) — Added remark support
    public function update_status_inline()
    {
        $data = [
            'staff_id' => $this->input->post('staff_id'),
            'date'     => $this->input->post('date'),
            'staff_st' => $this->input->post('staff_st'),
            'remark'   => $this->input->post('remark'),  // ⭐ NEW
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
            'remark'   => ''  // keep field
        ];

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }



    public function edit($staff_id)
    {
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

        $data->staff->join_dt  = date('Y-m-d', strtotime($data->staff->join_dt));
        $data->staff->birth_dt = date('Y-m-d', strtotime($data->staff->birth_dt));

        $this->load->view('incld/header');
        $this->load->view('Staff/staff_form', $data);
        $this->load->view('incld/footer');
    }



    public function delete($staff_id)
    {
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
}
