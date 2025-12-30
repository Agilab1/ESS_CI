<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material_model extends CI_Model
{
    private $table = 'material';

    // GET ALL
    public function get_all()
    {
        return $this->db
            ->order_by('material_id', 'DESC')
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
        return $this->db->insert($this->table, $data);
    }

    // UPDATE
    public function update($id, $data)
    {
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
