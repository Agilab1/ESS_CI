<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends CI_Model {

    public function getHolidayByDate($date) {
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
        $driver = $this->db->platform();

        if ($driver == "sqlite3") {
            $this->db->where("strftime('%m', date_id) =", sprintf("%02d", $month));
            $this->db->where("strftime('%Y', date_id) =", $year);
        } else {
            $this->db->where("MONTH(date_id)", $month);
            $this->db->where("YEAR(date_id)", $year);
        }

        $this->db->order_by('date_id', 'ASC');
        return $this->db->get('holiday')->result();
    }

    // ============================================================
    // PAGINATION LIST (Monthly) - Works on MySQL & SQLite
    // ============================================================
    public function getMonthlyHolidays($limit, $offset)
    {
        $currentMonth = date('m');
        $currentYear  = date('Y');
        $driver = $this->db->platform();

        if ($driver == "sqlite3") {
            $this->db->where("strftime('%m', date_id) =", sprintf("%02d", $currentMonth));
            $this->db->where("strftime('%Y', date_id) =", $currentYear);
        } else {
            $this->db->where("MONTH(date_id)", $currentMonth);
            $this->db->where("YEAR(date_id)", $currentYear);
        }

        $this->db->order_by('date_id', 'ASC');
        return $this->db->get('holiday', $limit, $offset)->result();
    }

    // ============================================================
    // COUNT MONTHLY HOLIDAYS – Works on MySQL & SQLite
    // ============================================================
    public function countMonthlyHolidays()
    {
        $currentMonth = date('m');
        $currentYear  = date('Y');
        $driver = $this->db->platform();

        if ($driver == "sqlite3") {
            $this->db->where("strftime('%m', date_id) =", sprintf("%02d", $currentMonth));
            $this->db->where("strftime('%Y', date_id) =", $currentYear);
        } else {
            $this->db->where("MONTH(date_id)", $currentMonth);
            $this->db->where("YEAR(date_id)", $currentYear);
        }

        return $this->db->count_all_results('holiday');
    }

}
