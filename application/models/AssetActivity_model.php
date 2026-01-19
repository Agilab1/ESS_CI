<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssetActivity_model extends CI_Model
{
    public function log($data)
    {
        // 🔍 DEBUG (temporary)
        // log_message('error', print_r($data, true));

        return $this->db->insert('asset_activity_log', $data);
    }

    public function get_live_activity()
    {
        return $this->db
            ->select('
                l.*,
                a.asset_name,
                d.serial_no,
                s.site_name,
                st.emp_name
            ')
            ->from('asset_activity_log l')
            ->join('assets a', 'a.asset_id = l.asset_id', 'left')
            ->join('assdet d', 'd.assdet_id = l.assdet_id', 'left')
            ->join('sites s', 's.site_id = d.site_id', 'left')
            ->join('staffs st', 'st.staff_id = d.staff_id', 'left')
            ->order_by('l.log_id', 'DESC')
            ->limit(20)
            ->get()
            ->result();
    }
}
