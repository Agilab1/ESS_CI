<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['user_validation_rules'] = array(
    array(
        'field' => 'mail_id',
        'label' => 'Email ID',
        'rules' => 'required|valid_email',
        'errors' => array(
            'required' => 'Email ID is required.',
            'valid_email' => 'Please enter a valid email address.',
            'is_unique' => 'This email is already registered.'
        )
    ),
    array(
        'field' => 'user_nm',
        'label' => 'User Name',
        'rules' => 'required|trim',
        'errors' => array(
            'required' => 'User Name is required.'
        )
    ),
    array(
        'field' => 'user_ph',
        'label' => 'Phone Number',
        'rules' => 'required|numeric|min_length[10]|max_length[15]',
        'errors' => array(
            'required' => 'Phone number is required.',
            'numeric' => 'Phone number must be digits only.',
            'min_length' => 'Phone number must be at least 10 digits.',
            'max_length' => 'Phone number cannot exceed 15 digits.'
        )
    ),
    array(
        'field' => 'pass_wd',
        'label' => 'Password',
        'rules' => 'required|min_length[6]',
        'errors' => array(
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 6 characters long.'
        )
    ),
    array(
        'field' => 'cpas_wd',
        'label' => 'Confirm Password',
        'rules' => 'required|matches[pass_wd]',
        'errors' => array(
            'required' => 'Please confirm your password.',
            'matches' => 'Passwords do not match.'
        )
    ),
    array(
        'field' => 'role_id',
        'label' => 'User Role',
        'rules' => 'required',
        'errors' => array(
            'required' => 'User Role is required.'
        )
    ),
    array(
        'field' => 'user_st',
        'label' => 'Status',
        'rules' => 'required',
        'errors' => array(
            'required' => 'User Status is required.'
        )
    )
);
