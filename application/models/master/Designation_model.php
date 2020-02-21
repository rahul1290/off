<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designation_model extends CI_Model {
	
	function get_designation($des_id = null){
		if($des_id == null){ 
			$this->db->select('dm.*,date_format(dm.updated_at,"%d/%m/%Y %H:%i:%s") as updated_at,IFNULL(u.name,"-") as updated_by');
			$this->db->join('users u','u.ecode = dm.updated_by','left');
			$result = $this->db->get_where('designation_master dm',array('dm.status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('designation_master',array('id'=>$des_id,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function designation_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('designation_master',array(
			'desg_name'=>$data['name'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		return true;
	}
	
	function designation_create($data){
		$this->db->insert('designation_master',array(
			'desg_name' => $data['name'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['created_at'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function designation_delete($data){
		$this->db->where('id',$data['desg_id']);
		$this->db->update('designation_master',array('status'=>0));
		return true;
	}
}