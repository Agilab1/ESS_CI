<?php

   $user_id =  $this->session->userdata('user_id');

    if ($user_id) {
       
    } else {
         $this->session->set_flashdata('status', 'Please login to access the Page');
        redirect(base_url('login'));   
    }
?>