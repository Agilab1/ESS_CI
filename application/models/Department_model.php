<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department_model extends CI_Model
{
    private $table = 'department';

    public function getAll()
    {
        return $this->db
            ->order_by('department_id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function getById($id)
    {
        return $this->db
            ->get_where($this->table, ['department_id' => $id])
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('department_id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, [
            'department_id' => $id
        ]);
    }
}
