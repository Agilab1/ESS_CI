<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Holiday_model extends CI_Model
{

    public function getHolidayByDate($date)
    {
        return $this->db->get_where('holiday', ['date_id' => $date])->row();
    }

    public function get_by_id($date_id)
    {
        return $this->db->get_where('holiday', ['date_id' => $date_id])->row();
    }

    public function insertHoliday($data)
    {
        return $this->db->insert('holiday', $data);
    }

    public function updateHoliday($old_date, $data)
    {
        $this->db->where('date_id', $old_date);
        return $this->db->update('holiday', $data);
    }

    public function deleteHoliday($date_id)
    {
        return $this->db->delete('holiday', ['date_id' => $date_id]);
    }

    public function getAll()
    {
        return $this->db->order_by('date_id', 'ASC')->get('holiday')->result();
    }

    public function exists($date_id)
    {
        return $this->db->get_where('holiday', ['date_id' => $date_id])->num_rows() > 0;
    }

    // ============================================================
    // GET HOLIDAYS BY MONTH - Works on MySQL & SQLite
    // ============================================================
    public function getByMonth($month, $year)
    {
        return $this->db
            ->where('MONTH(date_id)', (int)$month)
            ->where('YEAR(date_id)', (int)$year)
            ->order_by('date_id', 'ASC')
            ->get('holiday')
            ->result();
    }



    // ============================================================
    // PAGINATION LIST (Monthly) - Works on MySQL & SQLite
    // ============================================================
    public function getMonthlyHolidays($limit, $offset)
    {
        $currentMonth = (int)date('m');
        $currentYear  = (int)date('Y');

        return $this->db
            ->where('MONTH(date_id)', $currentMonth)
            ->where('YEAR(date_id)', $currentYear)
            ->order_by('date_id', 'ASC')
            ->get('holiday', $limit, $offset)
            ->result();
    }



    // ============================================================
    // COUNT MONTHLY HOLIDAYS – Works on MySQL & SQLite
    // ============================================================
    public function countMonthlyHolidays()
    {
        $currentMonth = (int)date('m');
        $currentYear  = (int)date('Y');

        return $this->db
            ->where('MONTH(date_id)', $currentMonth)
            ->where('YEAR(date_id)', $currentYear)
            ->count_all_results('holiday');
    }
}
