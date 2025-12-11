<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') or exit('No direct script access allowed');

class Work_model extends CI_Model
{

    // Fixed: month first, then year
    public function get_monthly_attendance($staff_id, $month = null, $year = null)
    {
        if ($month === null) $month = date('m');
        if ($year === null) $year = date('Y');

        $start_date = date('Y-m-01', strtotime("$year-$month-01"));
        $end_date   = date('Y-m-t', strtotime($start_date));

        // ⭐ MUST INCLUDE cin_time, cout_time, duration
        $this->db->select('
            dates.date AS punch_date,
            works.date AS work_date,
            staffs.staff_id,
            works.staff_st,
            works.remark,
            works.cin_time,
            works.cout_time,
            works.duration,
            staffs.emp_name
        ');

        $this->db->from('dates');

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
        // Check record
        $this->db->where('staff_id', $data['staff_id']);
        $this->db->where('date', $data['date']);
        $query = $this->db->get('works');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            // CIN already given by NFC → DO NOT OVERWRITE CIN
            if (!empty($row->cin_time)) {
                return $this->db->update(
                    'works',
                    [
                        'staff_st' => $data['staff_st'] ?? $row->staff_st,
                        'remark'   => $data['remark'] ?? $row->remark
                    ],
                    ['staff_id' => $data['staff_id'], 'date' => $data['date']]
                );
            }

            // Record exists but no cin_time (rare)
            return $this->db->update(
                'works',
                ['cin_time' => $data['cin_time']],
                ['staff_id' => $data['staff_id'], 'date' => $data['date']]
            );
        }

        // FIRST TAP → use exact NFC time
        return $this->db->insert('works', $data);
    }


    // ⭐⭐⭐ NEW FUNCTIONS ADDED (do NOT remove anything) ⭐⭐⭐

    // 1️⃣ FIRST TAP → SAVE CIN EXACT TIME
    public function insert_cin($data)
    {
        return $this->db->insert('works', $data);
    }

    // 2️⃣ SECOND TAP → SAVE COUT + AUTO CALCULATE DURATION
    public function update_cout($data)
    {
        $row = $this->db->get_where('works', [
            'staff_id' => $data['staff_id'],
            'date'     => $data['date']
        ])->row();

        if (!$row || empty($row->cin_time)) {
            return false;
        }

        $cin  = strtotime($row->cin_time);
        $cout = strtotime($data['cout_time']);

        $duration = gmdate("H:i:s", $cout - $cin);

        return $this->db->update(
            'works',
            [
                'cout_time' => $data['cout_time'],
                'duration'  => $duration
            ],
            ['staff_id' => $data['staff_id'], 'date' => $data['date']]
        );
    }
}
