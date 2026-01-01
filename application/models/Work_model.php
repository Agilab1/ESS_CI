<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') or exit('No direct script access allowed');

class Work_model extends CI_Model
{

    // =====================================================
    // MONTHLY ATTENDANCE (emp_details & punch_details)
    // =====================================================
    public function get_monthly_attendance($staff_id, $month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date   = date('Y-m-t', strtotime($start_date));

        $this->db->select('
        d.date AS punch_date,
        s.staff_id,
        s.emp_name,
        w.staff_st,
        w.remark,
        w.cin_time,
        w.cout_time,
        w.duration
    ');

        $this->db->from('dates d');

        // ✅ JOIN ONLY ON DATE
        $this->db->join(
            'works w',
            'w.date = d.date',
            'left'
        );

        // ✅ STAFF FILTER SAFE
        $this->db->join(
            'staffs s',
            's.staff_id = ' . $this->db->escape($staff_id),
            'left',
            false
        );

        // ✅ DATE RANGE
        $this->db->where('d.date >=', $start_date);
        $this->db->where('d.date <=', $end_date);

        // ✅ VERY IMPORTANT (staff OR NULL)
        $this->db->group_start();
        $this->db->where('w.staff_id', $staff_id);
        $this->db->or_where('w.staff_id IS NULL', null, false);
        $this->db->group_end();

        $this->db->order_by('d.date', 'ASC');

        return $this->db->get()->result();
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
    // ===============================
    // EMP LIST (ADMIN TABLE VIEW)
    // ===============================
    public function get_monthly_punches($staff_id, $month, $year)
    {
        return $this->db
            ->select('
            w.date AS punch_date,
            w.staff_id,
            s.emp_name,
            w.staff_st,
            w.remark,
            w.cin_time,
            w.cout_time,
            w.duration
        ')
            ->from('works w')
            ->join('staffs s', 's.staff_id = w.staff_id')
            ->where('w.staff_id', $staff_id)
            ->where('MONTH(w.date)', (int)$month)
            ->where('YEAR(w.date)', (int)$year)
            ->order_by('w.date', 'ASC')
            ->get()
            ->result();
    }
}
