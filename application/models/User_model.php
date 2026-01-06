<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    //  LOGIN CHECK (HASHED PASSWORD)
    public function login_check($mail_id, $pass_wd)
    {
        $user = $this->db
            ->where('mail_id', $mail_id)
            ->where('user_st', 'Active')
            ->get('users')
            ->row();

        if ($user && password_verify($pass_wd, $user->pass_wd)) {
            return $user;
        }
        return false;
    }

    public function get_user($user_id = '')
    {
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
            return $this->db->get('users')->row();
        }
        return $this->db->get('users')->result();
    }

    public function add_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function edit_user($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }

    public function delete_user($user_id)
    {
        return $this->db->delete('users', ['user_id' => $user_id]);
    }

    public function read_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->get('users')->row();
    }

    public function get_user_count()
    {
        return $this->db->count_all('users');
    }

    public function checkAssetUser($asset_no)
    {
        return $this->db->where('asset_no', $asset_no)->get('users')->row();
    }

    public function updateByAssetNo($asset_no, $data)
    {
        $this->db->where('asset_no', $asset_no);
        return $this->db->update('users', $data);
    }

    public function getAllUsers()
    {
        $this->db->select('
            users.user_id,
            users.user_nm,
            users.mail_id,
            users.user_ph,
            users.user_ty,
            users.user_st,
            users.asset_no,
            users.serial_no,      
            users.role_id,
            staffs.staff_id,
            staffs.emp_name,
            sites.site_no,
           department.department_name
           '
            
        );


        $this->db->from('users');
        $this->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
        $this->db->join('sites', 'sites.site_no = users.site_no', 'left');
        $this->db->join('department', 'department.department_id = users.department_id', 'left');
        $this->db->order_by('users.user_id', 'AESC');
        return $this->db->get()->result();
    }
    
//     public function getAllUsers()
// {
//     return $this->db
//         ->select('
//             users.user_id,
//             users.user_nm,
//             users.mail_id,
//             users.user_ph,
//             users.user_ty,
//             users.user_st,
//             users.asset_no,
//             users.serial_no,
//             users.role_id,

//             staffs.staff_id,
//             staffs.emp_name,

//             sites.site_no,
//             sites.site_name,

//             department.department_name
//         ')
//         ->from('users')
//         ->join('staffs', 'staffs.staff_id = users.staff_id', 'left')
//         ->join('sites', 'sites.site_id = users.site_id', 'left')
//         ->join('department', 'department.department_id = users.department_id', 'left')
//         ->order_by('users.user_id', 'ASC')
//         ->get()
//         ->result();
// }

    
}
