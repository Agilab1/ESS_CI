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
