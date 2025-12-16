<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends CI_Model
{
    public function getById($site_id)
    {
        return $this->db
            ->where('site_id', $site_id)
            ->get('sites')
            ->row();
    }

    public function exists($site_id)
    {
        return $this->db
            ->where('site_id', $site_id)
            ->count_all_results('sites') > 0;
    }

    public function insertLocation($data)
    {
        return $this->db->insert('sites', $data);
    }

    public function updateLocation($site_id, $data)
    {
        return $this->db
            ->where('site_id', $site_id)
            ->update('sites', $data);
    }

    public function deleteLocation($site_id)
    {
        return $this->db
            ->where('site_id', $site_id)
            ->delete('sites');
    }

    public function getAll()
    {
        return $this->db
           ->order_by('site_id', 'ASC')
           ->get('sites')
           ->result();
    }
      

    public function get_site_by_id($site_id)
    {
        return $this->db->get_where('sites', ['site_id' => $site_id])->row();
    }

    // Get asset list for site
    public function get_assets_by_site($site_id)
    {
        return $this->db->get_where('assets', ['site_id' => $site_id])->result();
    }

    // Get staff with assets using mapping table asset_staff
    public function get_staff_with_assets_by_site($site_id)
    {
        return $this->db
            ->select('
                s.staff_id,
                s.emp_name,
                a.asset_name
            ')
            ->from('assets a')
            ->join('asset_staff ast', 'ast.asset_id = a.asset_id')
            ->join('staff s', 's.staff_id = ast.staff_id')
            ->where('a.site_id', $site_id)
            ->order_by('s.emp_name')
            ->get()
            ->result();
    }




    // Get staff with assets using staff_id in assets table
    public function get_staff_assets_by_site($site_id)
    {
        return $this->db
            ->select('
            s.staff_id,
            s.emp_name,
            GROUP_CONCAT(a.asset_name, ", ") AS assets
        ')
            ->from('assets a')
            ->join('staffs s', 's.staff_id = a.staff_id', 'left') // FIX HERE
            ->where('a.site_id', $site_id)
            ->group_by('s.staff_id, s.emp_name')
            ->order_by('s.emp_name')
            ->get()
            ->result();
    }


}
