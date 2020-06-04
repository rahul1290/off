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
			$this->db->select('u.*,u.ecode as Ecode,dept_name,desg_name,grade_name,u.jdate,dept_name,desg_name,grade_name,ui.*');
			$this->db->join('department_master dm','dm.id = u.department_id','LEFT');
			$this->db->join('designation_master deg','deg.id = u.designation_id','LEFT');
			$this->db->join('grade_master gm','gm.id = u.grade_id','LEFT');
			$this->db->join('user_info ui','ui.ecode = u.ecode','LEFT');
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
	
	function employee_update($data,$info){
		$this->db->where('ecode',$data['ecode']);
		$this->db->update('users',$data);
		
		$this->db->select('*');
		$result = $this->db->get_where('user_info',array('ecode'=>$data['ecode']))->result_array();
		if(count($result)){
			$this->db->where('ecode',$data['ecode']);
			$this->db->update('user_info',$info);
		} else {
			$info['ecode'] = $data['ecode'];
			$this->db->insert('user_info',$info);
		}
		
		return true;
	}
	
	function departments_users($ecode){
		$this->db->select('u.*');
		$this->db->join('department_master dm','dm.id = ud.dep_id AND dm.status = 1');
		$this->db->join('users u','u.department_id = dm.id AND u.status = 1 AND u.is_active = 1');
		$result = $this->db->get_where('user_department ud',array('ud.ecode'=>$ecode,'ud.status'=>1))->result_array();
		return $result;
	}
	
	function supervised($ecode){
		$this->db->select('*');
		return $result = $this->db->get_where('user_rules',array('ecode'=>$ecode,'status'=>1))->result_array();
	}
	
	function user_link($ecode){
		$this->db->select('*');
		$result = $this->db->get_where('user_links',array('ecode'=>$ecode,'status'=>1))->result_array();
		return $result;
	}
	
	function is_unique_ecode($ecode){
		$this->db->select('*');
		$result = $this->db->get_where('users',array('ecode'=>$ecode,'status'=>1))->result_array();
		return $result;
	}
	
	function links(){
		$this->db->select('*');
		$this->db->order_by('id','asc');
		$result = $this->db->get_where('system-links',array('status'=>1))->result_array();
		return $result;
	}
} 