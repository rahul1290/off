<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cab_model extends CI_Model {

	function get_parent_zones(){
		$this->db->select('*');
		$result = $this->db->get_where('cabzone_master',array('parent_id'=>'0','status'=>1))->result_array();
		return $result;
	}
	
	function get_all_location(){
		$this->db->select('*');
		$result = $this->db->get_where('cabzone_master',array('status'=>1))->result_array();
		return $result;
	}

	function location_submit($data){
		$this->db->insert('cabzone_master',$data);
		return true;
	}
	
	function location_update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('cabzone_master',$data);
		return true;
	}

	function location_delete($data,$id){
		$this->db->where('id',$id);
		$data['status'] = '0';
		$this->db->update('cabzone_master',$data);
		return true;
	}
	
}