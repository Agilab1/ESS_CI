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
}
