<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function get_user($role_id = '')
    {
        if ($role_id == '') {
            return $this->db->get('roles')->result();
        } else {
            $this->db->where('role_id', $role_id);
            return $this->db->get('roles')->row();
        }
    }

    //Check if role exists (role id OR role name)
   public function exists($role_id, $role_name)
{
    $this->db->where('role_id', $role_id);
    $this->db->or_where('usr_role', $role_name);
    $query = $this->db->get('roles');
    return $query->num_rows() > 0;
}


    public function add_user($data)
    {
        return $this->db->insert('roles', $data);
    }

    public function edit_user($role_id, $data)
    {
        $this->db->where('role_id', $role_id);
        return $this->db->update('roles', $data);
    }

    public function delete_user($role_id)
    {
        return $this->db->delete('roles', ['role_id' => $role_id]);
    }
}
