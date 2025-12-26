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
    $this->db->select('
        a.asset_id,
        a.asset_no,
        a.asset_name,
        c.cat_no,
        c.cat_name,
        COUNT(DISTINCT ad.assdet_id) AS quantity
    ');
    $this->db->from('assets a');
    $this->db->join('categories c', 'c.cat_id = a.type_id', 'left');
    $this->db->join('assdet ad', 'ad.asset_id = a.asset_id', 'left');
    $this->db->group_by('a.asset_id');
    $this->db->order_by('a.asset_id', 'DESC');

    return $this->db->get()->result();
}


    public function getCategories()
    {
        return $this->db->get('categories')->result();
    }

   public function getSites()
{
    return $this->db->get('sites')->result();
}

}
