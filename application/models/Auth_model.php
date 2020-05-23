<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Auth_model extends CI_Model {
	
	function login($data){
		$this->db->select('ecode,id,name,password,department_id');
		$result = $this->db->get_where('users',array('ecode'=>$data['identity'],'password'=>$data['password'],'status'=>1))->result_array();
		return $result;
	}
	
	function userDetail($data){
	    $this->db->select('u.name,ui.company_mailid');
	    $this->db->join('user_info ui','ui.ecode = u.ecode');
	    $result = $this->db->get_where('users u',array('u.is_active'=>'YES','u.ecode'=>$data['ecode'],'u.status'=>1))->result_array();
	    return $result;
	}
}