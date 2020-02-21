<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model {
	
	function get_location($location_id=null){
		if($location_id == null){
			$this->db->select('*');
			$result = $this->db->get_where('location_master',array('status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('location_master',array('id'=>$location_id,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function location_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('location_master',array(
			'name'=>$data['name'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		
		return true;
	}
	
	function location_create($data){
		$this->db->insert('location_master',array(
			'name' => $data['name'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['created_at'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function location_delete($data){
		$this->db->where('id',$data['id']);
		$this->db->update('location_master',array('status'=>0));
		return true;
	}
}