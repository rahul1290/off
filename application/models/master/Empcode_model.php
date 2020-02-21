<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empcode_model extends CI_Model {
	
	function get_empcode($eid=null){
		if($eid == null){
			$this->db->select('*');
			$result = $this->db->get_where('empcode_master',array('status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('empcode_master',array('id'=>$eid,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function empcode_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('empcode_master',array(
			'ecode_name'=>$data['name'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		
		return true;
	}
	
	function empcode_create($data){
		$this->db->insert('empcode_master',array(
			'ecode_name' => $data['name'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['created_at'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function empcode_delete($data){
		$this->db->where('id',$data['id']);
		$this->db->update('empcode_master',array('status'=>0));
		return true;
	}
}