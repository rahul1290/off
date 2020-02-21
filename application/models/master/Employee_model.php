<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {
	
	function employees($eid=null){
		if($eid == null){
			$this->db->select('u.id,u.ecode,u.name,u.gender,dept_name,desg_name,grade_name,date_format(u.jdate,"%d/%m/%Y") as jdate');
			$this->db->join('department_master dm','dm.id = u.department_id','LEFT');
			$this->db->join('designation_master deg','deg.id = u.designation_id','LEFT');
			$this->db->join('grade_master gm','gm.id = u.grade_id','LEFT');
			$this->db->order_by('u.updated_at','DESC');
			return $result = $this->db->get_where('users u',array('u.status'=>1))->result_array();
		} else {
			$this->db->select('u.*,dept_name,desg_name,grade_name,u.jdate,dept_name,desg_name,grade_name,ui.*');
			$this->db->join('department_master dm','dm.id = u.department_id','LEFT');
			$this->db->join('designation_master deg','deg.id = u.designation_id','LEFT');
			$this->db->join('grade_master gm','gm.id = u.grade_id','LEFT');
			$this->db->join('user_info ui','ui.ecode = u.ecode');
			$this->db->order_by('u.updated_at','DESC');
			$result = $this->db->get_where('users u',array('u.ecode'=>$eid,'u.status'=>1))->result_array();
			return $result;
		}
	}
	
	function employee_create($data,$info){	
		$this->db->trans_begin();

		$this->db->insert('users',$data);
		$uid = $this->db->insert_id(); 
		
		$this->db->select('ecode');
		$result = $this->db->get_where('users',array('id'=>$uid))->result_array();
		
		$info['ecode'] = $result[0]['ecode'];
		$this->db->insert('user_info',$info);

		if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}
}