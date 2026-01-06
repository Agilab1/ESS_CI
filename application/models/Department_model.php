<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department_model extends CI_Model
{
    private $table = 'department';

    public function getAll()
    {
        return $this->db
            ->select('department.*, sites.site_no, sites.site_name')
            ->from('department')
            ->join('sites', 'sites.site_id = department.site_id', 'left')
            ->order_by('department.department_id', 'DESC')
            ->get()
            ->result();
    }

    public function getById($id)
    {
        return $this->db
            ->get_where('department', ['department_id' => $id])
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
