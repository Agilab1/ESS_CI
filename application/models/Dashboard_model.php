<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model { //test

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function counts() {

        $dash = (object) [
            'cnt1' => '',  // Users
            'cnt2' => '',  // Roles
            'cnt3' => '',   // Staffs
            'cnt4' => '',    //holidays
            'cnt5' => ''
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

        // Holiday
        if ($this->db->table_exists('holiday')) {
            $count = $this->db->count_all('holiday');
            $dash->cnt4 = $count > 0 ? $count : '';
        }
           if ($this->db->table_exists('assets')) {
            $count = $this->db->count_all('assets');
            $dash->cnt5 = $count > 0 ? $count : '';
        }

        return $dash;
    }
}
?>