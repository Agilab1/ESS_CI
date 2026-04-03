<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assdet_model extends CI_Model
{
    public function insert($data)
    {
        return $this->db->insert('assdet', $data);
    }

    public function get_staff_assets($staff_id)
{
    $this->db->select('
        ad.assdet_id,
        ad.serial_no,
        a.asset_id,
        a.asset_name,
        s.site_id,
        st.emp_name AS owner
    ');
    $this->db->from('assdet ad');
    $this->db->join('assets a','a.asset_id = ad.asset_id','left');
    $this->db->join('sites s','s.site_name = ad.site_id','left');
    $this->db->join('staff st','st.staff_id = ad.staff_id','left');
    $this->db->where('ad.staff_id', $staff_id);

    return $this->db->get()->result();
}

}
