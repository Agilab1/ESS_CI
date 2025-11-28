<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* ---------------------------------------------------------
        GET HOLIDAY BY DATE ID (Primary Key)
    --------------------------------------------------------- */
    public function get_by_id($date_id)
    {
        return $this->db->get_where('holiday', ['date_id' => $date_id])->row();
    }

    /* ---------------------------------------------------------
        INSERT NEW HOLIDAY
    --------------------------------------------------------- */
    public function insertHoliday($data)
    {
        return $this->db->insert('holiday', $data);
    }

    /* ---------------------------------------------------------
        UPDATE HOLIDAY
    --------------------------------------------------------- */
    public function updateHoliday($date_id, $data)
    {
        $this->db->where('date_id', $date_id);
        return $this->db->update('holiday', $data);
    }

    /* ---------------------------------------------------------
        DELETE HOLIDAY
    --------------------------------------------------------- */
    public function deleteHoliday($date_id)
    {
        return $this->db->delete('holiday', ['date_id' => $date_id]);
    }

    /* ---------------------------------------------------------
        GET HOLIDAY FOR DELETION CHECK OR VIEW
    --------------------------------------------------------- */
    public function getHolidayByDate($date_id)
    {
        return $this->db->get_where('holiday', ['date_id' => $date_id])->row();
    }

    /* ---------------------------------------------------------
        LIST ALL HOLIDAYS ORDERED BY DATE
    --------------------------------------------------------- */
    public function getAll()
    {
        return $this->db->order_by('date_id', 'ASC')->get('holiday')->result();
    }

    /* ---------------------------------------------------------
        CHECK IF HOLIDAY EXISTS (for validation)
    --------------------------------------------------------- */
    public function exists($date_id)
    {
        $this->db->where('date_id', $date_id);
        return $this->db->get('holiday')->num_rows() > 0;
    }
}
