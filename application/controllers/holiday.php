<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Holiday_model');
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
    }

    /* ---------------------------------------------------------
        LIST HOLIDAYS
    --------------------------------------------------------- */
public function list()
{
    // Use associative array instead of stdClass
    $data = [
        'holidays' => $this->Holiday_model->getAll(),
        'counts'   => $this->Dashboard_model->counts()
    ];

    // Load all views in proper order
    $this->load->view('incld/verify');
    $this->load->view('incld/header');
    $this->load->view('incld/top_menu');
    $this->load->view('incld/side_menu');
    //$this->load->view('user/dashboard', $data); // Dashboard view
    //$this->load->view('Holiday/list', $data);   // Holiday list view
    $this->load->view('incld/jslib');
    $this->load->view('incld/footer');
    $this->load->view('incld/script');
}

   
    /* ---------------------------------------------------------
        ADD HOLIDAY
    --------------------------------------------------------- */
    public function add()
    {
        $data = new stdClass();
        $data->action  = 'add';
        $data->holiday = null;

        $this->load->view('incld/header');
        $this->load->view('Holiday/add', $data);
        $this->load->view('incld/footer');
    }

    /* ---------------------------------------------------------
        EDIT HOLIDAY
    --------------------------------------------------------- */
    public function edit($date_id)
    {
        $data = new stdClass();
        $data->action  = 'edit';
        $data->holiday = $this->Holiday_model->get_by_id($date_id);

        if (!$data->holiday) show_404();

        $this->load->view('incld/header');
        $this->load->view('Holiday/add', $data);
        $this->load->view('incld/footer');
    }

    /* ---------------------------------------------------------
        VIEW HOLIDAY
    --------------------------------------------------------- */
    public function view($date_id)
    {
        $data = new stdClass();
        $data->action  = 'view';
        $data->holiday = $this->Holiday_model->get_by_id($date_id);

        if (!$data->holiday) show_404();

        $this->load->view('incld/header');
        $this->load->view('Holiday/add', $data);
        $this->load->view('incld/footer');
    }

    /* ---------------------------------------------------------
        DELETE HOLIDAY (DIRECT CALL)
    --------------------------------------------------------- */
  public function delete($date_id)
{
    $holiday = $this->Holiday_model->get_by_id($date_id);
    if (!$holiday) show_404();

    $this->Holiday_model->deleteHoliday($date_id);

    // Flash message with actual date
    $this->session->set_flashdata(
        'success',
        'Holiday on ' . $holiday->date_id . ' deleted successfully!'
    );

    redirect('Holiday/list');
}

    /* ---------------------------------------------------------
        SAVE (ADD, EDIT, DELETE)
    --------------------------------------------------------- */
    public function save()
    {
        $action   = strtolower($this->input->post('action'));
        $old_date = $this->input->post('old_date_id'); // old PK

        switch ($action) {

            /* ========== ADD HOLIDAY ========== */
            case 'add':

                $data = $this->validate();
                if (!$data) return $this->add();

                // Prevent duplicate dates
                if ($this->Holiday_model->get_by_id($data['date_id'])) {
                    $this->session->set_flashdata('error', 'This holiday date already exists!');
                    return redirect('Holiday/add');
                }

                $this->Holiday_model->insertHoliday($data);
                $this->session->set_flashdata('success', 'Holiday on ' . $data['date_id'] . ' added successfully!');

                return redirect('Holiday/list');


            /* ========== EDIT HOLIDAY ========== */
            case 'edit':

                $data = $this->validate();
                if (!$data) return $this->edit($old_date);

                $this->Holiday_model->updateHoliday($old_date, $data);

               $this->session->set_flashdata('success', 'Holiday on ' . $old_date . ' updated successfully!');

                return redirect('Holiday/list');


            /* ========== DELETE HOLIDAY ========== */
            case 'delete':

                if ($old_date) {
                    $this->Holiday_model->deleteHoliday($old_date);
                }

               //$this->session->set_flashdata('success', 'Holiday on ' . $date_id . ' deleted successfully!');


                return redirect('Holiday/list');


            /* ========== INVALID ACTION ========== */
            default:
                show_error("Invalid Action!");
        }
    }

    /* ---------------------------------------------------------
        VALIDATION
    --------------------------------------------------------- */
    private function validate()
    {
        $this->form_validation->set_rules('date_id', 'Holiday Date', 'required');
        $this->form_validation->set_rules('day_cat', 'Day Category', 'required');
        $this->form_validation->set_rules('day_txt', 'Description', 'required');

        if ($this->form_validation->run() === FALSE) {
            return false;
        }
          
        return [
            'date_id' => $this->input->post('date_id'),
            'day_cat' => $this->input->post('day_cat'),
            'day_txt' => $this->input->post('day_txt')
        ];
    }
}
