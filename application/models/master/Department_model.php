<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {
	
	function get_department($dep_id = null){
		if($dep_id == null){ 
			$this->db->select('dm.*,date_format(dm.updated_at,"%d/%m/%Y %H:%i:%s") as updated_at,IFNULL(u.name,"-") as updated_by');
			$this->db->join('users u','u.ecode = dm.updated_by','left');
			$result = $this->db->get_where('department_master dm',array('dm.status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('department_master',array('id'=>$dep_id,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function department_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('department_master',array(
			'dept_name'=>$data['name'],
			'dept_code'=>$data['code'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		return true;
	}
	
	function department_create($data){
		$this->db->insert('department_master',array(
			'dept_name' => $data['name'],
			'dept_code' => $data['code'],
			'created_at' => $data['created_at'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function department_delete($data){
		$this->db->where('id',$data['dep_id']);
		$this->db->update('department_master',array('status'=>0));
		return true;
	}
	
	function department_employees($dept){
		$this->db->select('id,ecode,name');
		$result = $this->db->get_where('users',array('department_id'=>$dept,'status'=>1))->result_array();
		return $result;
	}
}