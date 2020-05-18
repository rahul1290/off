<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Auth_model extends CI_Model {
	
	function login($data){
		$this->db->select('ecode,id,name,password,department_id');
		$result = $this->db->get_where('users',array('ecode'=>$data['identity'],'password'=>$data['password'],'status'=>1))->result_array();
		if(count($result) == 1){
			return $result;
		} else {
			return false;
		}
	}
}