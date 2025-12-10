<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Work_model extends CI_Model
{

    // Fixed: month first, then year
    public function get_monthly_attendance($staff_id, $month = null, $year = null)
    {
        if ($month === null) $month = date('m');
        if ($year  === null) $year  = date('Y');

        $start_date = date('Y-m-01', strtotime("$year-$month-01"));
        $end_date   = date('Y-m-t', strtotime($start_date));

        $this->db->select('
            dates.date AS punch_date,
            works.date AS work_date,
            staffs.staff_id, 
            works.staff_st,
            works.remark,
            staffs.emp_name
        ');


        $this->db->from('dates');

        // ⭐ CORRECT — join with alias date AS punch_date
        $this->db->join(
            'works',
            'works.date = dates.date AND works.staff_id = ' . $this->db->escape($staff_id),
            'left',
            false
        );

        $this->db->join(
            'staffs',
            'staffs.staff_id = ' . $this->db->escape($staff_id),
            'left',
            false
        );

        $this->db->where('dates.date >=', $start_date);
        $this->db->where('dates.date <=', $end_date);
        $this->db->order_by('dates.date', 'ASC');

        return $this->db->get()->result();
    }


    public function get_status($staff_id, $date)
    {
        $row = $this->db->get_where('works', [
            'staff_id' => $staff_id,
            'date'     => $date
        ])->row();

        return $row ? $row->staff_st : null;
    }


    public function delete_status($staff_id, $date)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->where('date', $date);
        return $this->db->delete('works');
    }


    public function upsert_status($data)
    {
        $this->db->where('staff_id', $data['staff_id']);
        $this->db->where('date', $data['date']);
        $query = $this->db->get('works');

        if ($query->num_rows() > 0) {

            return $this->db->update(
                'works',
                [
                    'staff_st' => $data['staff_st'],
                    'remark'   => $data['remark']
                ],
                [
                    'staff_id' => $data['staff_id'],
                    'date'     => $data['date']
                ]
            );
        } else {

            return $this->db->insert('works', $data);
        }
    }
}
