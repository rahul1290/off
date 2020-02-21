<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_model extends CI_Model {
	
	function get_grade($grade_id = null){
		if($grade_id == null){ 
			$this->db->select('gm.*,date_format(gm.updated_at,"%d/%m/%Y %H:%i:%s") as updated_at,IFNULL(u.name,"-") as updated_by');
			$this->db->join('users u','u.ecode = gm.updated_by','left');
			$result = $this->db->get_where('grade_master gm',array('gm.status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('grade_master',array('id'=>$grade_id,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function grade_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('grade_master',array(
			'grade_name'=>$data['name'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		return true;
	}
	
	function grade_create($data){
		$this->db->insert('grade_master',array(
			'grade_name' => $data['name'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['created_at'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function grade_delete($data){
		$this->db->where('id',$data['grade_id']);
		$this->db->update('grade_master',array('status'=>0));
		return true;
	}
}