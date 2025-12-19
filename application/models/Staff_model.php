<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff_model extends CI_Model
{

    public function get_user($staff_id = '')
    {
        if ($staff_id == '') {
            return $this->db->get('staffs')->result();
        } else {
            $this->db->where('staff_id', $staff_id);
            return $this->db->get('staffs')->row();
        }
    }

    public function add_user($data)
    {
        // remark is already inside $data from controller
        return $this->db->insert('staffs', $data);
    }

    public function edit_user($staff_id, $data)
    {
        // remark will update properly here
        $this->db->where('staff_id', $staff_id);
        return $this->db->update('staffs', $data);
    }

    public function delete_user($staff_id)
    {
        return $this->db->delete('staffs', ['staff_id' => $staff_id]);
    }

    public function exists($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        return $this->db->get('staffs')->num_rows() > 0;
    }

    ///
}
