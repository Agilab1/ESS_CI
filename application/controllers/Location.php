<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    // ============================================================
    // LIST LOCATIONS
    // ============================================================
    public function list()
    {
        $data = new stdClass();
        $data->action = "";
        $data->locations = $this->Location_model->getAll();
        $data->counts = $this->Dashboard_model->counts();

        $this->load->view('incld/verify');
        $this->load->view('incld/header');
        $this->load->view('incld/top_menu');
        $this->load->view('incld/side_menu');
        $this->load->view('user/dashboard', $data);
        $this->load->view('Location/list', $data);
        $this->load->view('incld/jslib');
        $this->load->view('incld/footer');
        $this->load->view('incld/script');
    }

    // ============================================================
    // ADD LOCATION
    // ============================================================
    public function add()
    {
        $data = new stdClass();
        $data->action = 'add';
        $data->location = (object)[
            'site_id'      => '',
            'site_no'      => '',
            'site_name'    => '',
            'last_visit'   => '',
            'verify_asset' => '',
            'status'       => '',
            'access_flag'  => '',
            'access_by'    => ''
        ];

        $this->load->view('incld/header');
        $this->load->view('Location/add', $data);
        $this->load->view('incld/footer');
    }

    // ============================================================
    // EDIT LOCATION
    // ============================================================
    public function edit($site_id = null)
    {
        // Redirect if no ID
        if ($site_id === null) {
            redirect('Location/list');
            return;
        }

        $data = new stdClass();
        $data->action = 'edit';
        $data->location = $this->Location_model->getById($site_id);

        if (!$data->location) show_404();

        $this->load->view('incld/header');
        $this->load->view('Location/add', $data);
        $this->load->view('incld/footer');
    }

    public function view($site_id = null)
    {
        if ($site_id === null) redirect('Location/list');

        $location = $this->Location_model->getById($site_id);
        if (!$location) show_404();

        // ===== NFC : LOCATION → ONLY SITE =====
        if ($this->input->get('nfc') == 1) {

            $logged_user_id = $this->session->userdata('user_id');

            if ($logged_user_id && $location->site_no) {
                $this->User_model->edit_user($logged_user_id, [
                    'site_no' => $location->site_no,
                    'user_st' => 'Active'
                ]);
            }
        }

        $data = new stdClass();
        $data->action = 'view';
        $data->location = $location;

        $this->load->view('incld/header');
        $this->load->view('Location/add', $data);
        $this->load->view('incld/footer');
    }




    // ============================================================
    // DELETE LOCATION
    // ============================================================
    public function delete($site_id = null)
    {
        if ($site_id === null) {
            redirect('Location/list');
            return;
        }

        $location = $this->Location_model->getById($site_id);
        if (!$location) show_404();

        $this->Location_model->deleteLocation($site_id);
        $this->session->set_flashdata('success', "Location deleted successfully!");

        redirect('Location/list');
    }

    // ============================================================
    // SAVE (ADD / EDIT)
    // ============================================================
    public function save()
    {
        $action  = strtolower($this->input->post('action'));
        $site_id = $this->input->post('site_id');

        $data = $this->validate();

        if (!$data) {
            return $action === 'add' ? $this->add() : $this->edit($site_id);
        }

        if ($action === 'add') {
            $this->Location_model->insertLocation($data);
            $this->session->set_flashdata('success', "Location added successfully!");
        } elseif ($action === 'edit') {
            $this->Location_model->updateLocation($site_id, $data);
            $this->session->set_flashdata('success', "Location updated successfully!");
        } else {
            show_error("Invalid Action!");
        }

        redirect('Location/list');
    }

    // ============================================================
    // VALIDATION RULES
    // ============================================================
    private function validate()
    {
        $this->form_validation->set_rules('site_no', 'Site Number', 'required');
        $this->form_validation->set_rules('site_name', 'Site Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if (!$this->form_validation->run()) {
            return false;
        }

        return [
            'site_id'      => $this->input->post('site_id'),
            'site_no'      => $this->input->post('site_no'),
            'site_name'    => $this->input->post('site_name'),
            'last_visit'   => $this->input->post('last_visit'),
            'verify_asset' => $this->input->post('verify_asset'),
            'status'       => $this->input->post('status'),
            'access_flag'  => $this->input->post('access_flag'),
            'access_by'    => $this->input->post('access_by')
        ];
    }

    //============================================================
    // ASSET LIST FORM (QR PAGE)
    // ============================================================
    public function asset_list($site_id)
    {
        $site = $this->Location_model->get_site_by_id($site_id);
        $assets = $this->Location_model->get_assets_by_site($site_id);

        if (!$site)
            show_404();

        $data = [
            'site' => $site,
            'assets' => $assets
        ];


        $this->load->view('incld/header');
        $this->load->view('Location/asset_list', $data);
        $this->load->view('incld/footer');
    }

    }






