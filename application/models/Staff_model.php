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

    public function get_by_id($staff_id)
    {
        return $this->db
            ->get_where('staffs', ['staff_id' => $staff_id])
            ->row();
    }
     

     public function insert_asset($data)
    {
        $this->db->insert('assdet',$data);
        return $this->db->insert_id();
    }



    // 🔥 MAIN JOIN QUERY
    public function get_staff_assets($staff_id)
    {
        $this->db->select('
            ad.assdet_id,
            ad.serial_no,
            a.asset_id,
            a.asset_name,
            s.site_name
        ');
        $this->db->from('assdet ad');
        $this->db->join('assets a','a.asset_id = ad.asset_id','left');
        $this->db->join('sites s','s.site_id = ad.site_id','left');
        $this->db->where('ad.staff_id', $staff_id);

        return $this->db->get()->result();
    }
    ///
}
