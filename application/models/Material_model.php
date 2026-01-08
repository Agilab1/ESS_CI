<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material_model extends CI_Model
{
    private $table = 'material';

    // GET ALL
    public function get_all()
    {
        return $this->db
            ->order_by('material_id', 'ASC')
            ->get($this->table)
            ->result();
    }

    // GET BY ID
    public function get_by_id($id)
    {
        return $this->db
            ->where('material_id', $id)
            ->get($this->table)
            ->row();
    }

    // INSERT
    public function insert($data)
    {
        // IMPORTANT FIX
        if (empty($data['asset_id'])) {
            unset($data['asset_id']); // ⬅️ THIS IS THE KEY FIX
        }

        return $this->db->insert($this->table, $data);
    }

    // UPDATE
    public function update($id, $data)
    {
        //  SAFETY: asset_id null handling
        if (!isset($data['asset_id']) || $data['asset_id'] === '') {
            $data['asset_id'] = null;
        }

        return $this->db
            ->where('material_id', $id)
            ->update($this->table, $data);
    }

    // DELETE
    public function delete($id)
    {
        return $this->db
            ->where('material_id', $id)
            ->delete($this->table);
    }
}
