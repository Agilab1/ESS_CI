<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function counts() {

        $dash = (object) [
            'cnt1' => '',  // Users
            'cnt2' => '',  // Roles
            'cnt3' => ''   // Staffs
        ];

        // USERS
        if ($this->db->table_exists('users')) {
            $count = $this->db->count_all('users');
            $dash->cnt1 = $count > 0 ? $count : '';
        }

        // ROLES
        if ($this->db->table_exists('roles')) {
            $count = $this->db->count_all('roles');
            $dash->cnt2 = $count > 0 ? $count : '';
        }

        // STAFF (your table name must be correct: staffs OR staff)
        if ($this->db->table_exists('staffs')) {
            $count = $this->db->count_all('staffs');
            $dash->cnt3 = $count > 0 ? $count : '';
        }

        return $dash;
    }
}
