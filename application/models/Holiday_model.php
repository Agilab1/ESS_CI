<?php
class Holiday_model extends CI_Model
{
    public function getHolidayByDate($date)
    {
        $this->db->where('date', $date);   // 👈 MATCH YYYY-mm-dd
        return $this->db->get('holiday')->row();
    }
}
