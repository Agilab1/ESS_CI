<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    // GET ALL USERS OR ONE USER
    public function get_user($user_id = '')
    {
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
            return $this->db->get('users')->row();
        }

        return $this->db->get('users')->result();
    }

    // ADD USER
    public function add_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // EDIT USER
    public function edit_user($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }

    // DELETE USER
    public function delete_user($user_id)
    {
        return $this->db->delete('users', ['user_id' => $user_id]);
    }

    // LOGIN / READ USER
    public function read_user($mail_id)
    {
        $this->db->where('mail_id', $mail_id);
        return $this->db->get('users')->row();
    }

    // COUNTER
    public function get_user_count()
    {
        return $this->db->count_all('users');
    }
}
