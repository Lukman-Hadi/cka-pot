<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getLogin($username)
    {
    	$this->db->where('nik',$username);
    	return $this->db->get('tbl_user');
    }

    function getUser()
    {
        $result = array();
        $item = $this->db->get('tbl_user')->result_array();
        $result = array_merge($result, ['rows' => $item]);
        return $result;
    }
}