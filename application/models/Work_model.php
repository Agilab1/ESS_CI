<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') or exit('No direct script access allowed');

class Work_model extends CI_Model
{

    // =====================================================
    // MONTHLY ATTENDANCE (emp_details & punch_details)
    // =====================================================
    public function get_monthly_attendance($staff_id, $month = null, $year = null)
    {
        if ($month === null) $month = date('m');
        if ($year === null)  $year  = date('Y');

        $start_date = date('Y-m-01', strtotime("$year-$month-01"));
        $end_date   = date('Y-m-t', strtotime($start_date));

        $this->db->select('
            dates.date AS punch_date,
            staffs.staff_id,
            staffs.emp_name,
            works.staff_st,
            works.remark,
            works.cin_time,
            works.cout_time,
            works.duration
        ');

        $this->db->from('dates');

        $this->db->join(
            'works',
            'works.date = dates.date 
             AND works.staff_id = ' . $this->db->escape($staff_id),
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

    // =====================================================
    // GET STATUS (single date)
    // =====================================================
    public function get_status($staff_id, $date)
    {
        $row = $this->db->get_where('works', [
            'staff_id' => $staff_id,
            'date'     => $date
        ])->row();

        return $row ? $row->staff_st : null;
    }

    // =====================================================
    // DELETE RECORD
    // =====================================================
    public function delete_status($staff_id, $date)
    {
        return $this->db
            ->where('staff_id', $staff_id)
            ->where('date', $date)
            ->delete('works');
    }

    // =====================================================
    // MANUAL SAVE / ADMIN UPDATE
    // =====================================================
    public function upsert_status($data)
    {
        $row = $this->db->get_where('works', [
            'staff_id' => $data['staff_id'],
            'date'     => $data['date']
        ])->row();

        // Record already exists
        if ($row) {

            // NFC cin already present → DO NOT overwrite cin/cout
            if (!empty($row->cin_time)) {
                return $this->db->update(
                    'works',
                    [
                        'staff_st' => $data['staff_st'] ?? $row->staff_st,
                        'remark'   => $data['remark'] ?? $row->remark
                    ],
                    [
                        'staff_id' => $data['staff_id'],
                        'date'     => $data['date']
                    ]
                );
            }

            // Rare case: record exists but cin missing
            return $this->db->update(
                'works',
                ['cin_time' => $data['cin_time']],
                [
                    'staff_id' => $data['staff_id'],
                    'date'     => $data['date']
                ]
            );
        }

        // First insert (manual entry)
        return $this->db->insert('works', $data);
    }

    // =====================================================
    // NFC FIRST TAP → SAVE CIN TIME
    // =====================================================
    public function insert_cin($data)
    {
        return $this->db->insert('works', $data);
    }

    // =====================================================
    // NFC SECOND TAP → SAVE COUT + DURATION
    // =====================================================
    public function update_cout($data)
    {
        $row = $this->db->get_where('works', [
            'staff_id' => $data['staff_id'],
            'date'     => $data['date']
        ])->row();

        if (!$row) return false;
        if (empty($row->cin_time)) return false; // IN must exist

        $cin  = strtotime($row->cin_time);
        $cout = strtotime($data['cout_time']);

        if ($cout <= $cin) return false;

        $duration = gmdate("H:i:s", $cout - $cin);

        // 🔥 ALWAYS UPDATE OUT + DURATION
        return $this->db->update(
            'works',
            [
                'cout_time' => $data['cout_time'],
                'duration'  => $duration
            ],
            [
                'staff_id' => $data['staff_id'],
                'date'     => $data['date']
            ]
        );
    }
}
