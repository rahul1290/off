<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_model extends CI_Model {
	
	function hf_leave_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,,u1.name as hod_name');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('users u1','u1.ecode = ulr.hod_id','LEFT');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		
		return $result;
	}
	
	function hf_leave_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF',
		'ulr.hod_status'=>'GRANTED',
		'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	
	////OFF DAY DUTY REQUEST
	function off_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hr_name');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();

		return $result;
	}
	
	function off_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'GRANTED','ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}

////NH FH DAY DUTY REQUEST
	function nh_fh_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hr_name');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function nh_fh_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'PENDING','ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function hf_leave_request_update($data){
		$this->db->where('id',$data['req_id']);
		$this->db->update('users_leave_requests',array(
						$data['key'] => $data['value'],
						'hr_id' => $data['hr_id'],
						'hr_remark_date' => $data['created_at']
						)
		);
		return true;
	}
	
}