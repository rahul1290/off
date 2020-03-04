<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hod_model extends CI_Model {
	
	////HALF DAY REQUEST
	function hf_leave_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function hf_leave_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}

	function hf_leave_request_update($data){
		$this->db->where('id',$data['req_id']);
		$this->db->update('users_leave_requests',array(
				$data['key'] => $data['value'],
				'hod_id' => $data['hod_id'],
				'hod_remark_date' => $data['created_at']
				)
		);
		return true;
	}
	
	////OFF DAY DUTY REQUEST
	function off_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function off_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}

	
	////NH FH DAY DUTY REQUEST
	function nh_fh_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function nh_fh_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
} 