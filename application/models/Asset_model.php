<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_model extends CI_Model
{
    private $table = "assets";

    // GET ASSET BY ID
    public function getById($asset_id)
    {
        $this->db->select('assets.*, staffs.emp_name, sites.site_no, sites.site_name, categories.cat_no, categories.cat_name');
        $this->db->from('assets');
        $this->db->join('staffs', 'staffs.staff_id = assets.staff_id', 'left');
        $this->db->join('sites', 'sites.site_id = assets.site_id', 'left');
        $this->db->join('categories', 'categories.cat_id = assets.cat_id', 'left');
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
        $this->db->select('
            assets.*, 
            staffs.emp_name,
            sites.site_no,
            sites.site_name,
            categories.cat_no,
            categories.cat_name
        ');
        $this->db->from('assets');
        $this->db->join('staffs', 'staffs.staff_id = assets.staff_id', 'left');
        $this->db->join('sites', 'sites.site_id = assets.site_id', 'left');
        $this->db->join('categories', 'categories.cat_id = assets.cat_id', 'left');
        $this->db->order_by('assets.asset_id', 'DESC');

        return $this->db->get()->result();
    }

    // GET SITE DROPDOWN
    public function getSites()
    {
        return $this->db->get('sites')->result();
    }
    public function getCategories()
{
    return $this->db->get('categories')->result();
}




//test
}
