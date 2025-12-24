<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_model extends CI_Model
{
    private $table = "assets";

    // GET ASSET BY ID
    public function getById($asset_id)
    {
        $this->db->select('assets.*');
        $this->db->from('assets');
        $this->db->where('assets.asset_id', $asset_id);

        return $this->db->get()->row();
    }


    // INSERT
    public function insertAsset($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // UPDATE
    public function updateAsset($asset_id, $data)
    {
        $this->db->where('asset_id', $asset_id);
        return $this->db->update($this->table, $data);
    }

    // DELETE
    public function deleteAsset($asset_id)
    {
        return $this->db->delete($this->table, ['asset_id' => $asset_id]);
    }

    // CHECK IF ASSET EXISTS
    public function exists($asset_no)
    {
        return $this->db->get_where($this->table, ['asset_no' => $asset_no])->num_rows() > 0;
    }

    // GET ALL FOR LIST PAGE + JOIN STAFF + SITE
    public function getAll()
    {
        $this->db->select('assets.*');
        $this->db->from('assets');
        $this->db->order_by('assets.asset_id', 'DESC');

        return $this->db->get()->result();
    }


    // GET SITE DROPDOWN
    // public function getSites()
    // {
    //     return $this->db->get('sites')->result();
    // }
    public function getCategories()
    {
        return $this->db->get('categories')->result();
    }

    // public function get_assets_with_site_by_staff($staff_id)
    // {
    //     $this->db->select('
    //         a.asset_id,
    //         a.asset_name,
    //         s.site_name,
    //         s.site_no
    //     ');
    //     $this->db->from('assets a');
    //     $this->db->join('sites s', 's.site_id = a.site_id', 'left');
    //     $this->db->where('a.staff_id', $staff_id);

    //     return $this->db->get()->result();
    // }
    //test
}
