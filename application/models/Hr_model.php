<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_model extends CI_Model {
	
    function leave_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,,u1.name as hod_name,(select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "NH_FH") as nhfhs');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.refrence_id',$ref_id);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        
        return $result;
    }
    
    function leave_pending_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,(select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "NH_FH") as nhfhs');
        //$this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.refrence_id',$ref_id);
        }
        $this->db->order_by('ulr.created_at','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    
	///////////////HALF DAY REQUESTS
    function hf_leave_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,,u1.name as hod_name');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
		$this->db->join('department_master dm','dm.id = u.department_id');
		$this->db->order_by('created_at','desc');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		
		return $result;
	}
	
	function hf_leave_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
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
	
	function leave_request_update($data){
	    $this->db->trans_begin();
	    $this->db->where('id',$data['req_id']);
	    $this->db->update('users_leave_requests',array(
	        $data['key'] => $data['value'],
	        'hr_id' => $data['hr_id'],
	        'hr_remark_date' => $data['created_at']
	    ));
	    
	    //get employee code by refrence id
	    $ecode = $this->my_library->leave_requester_ecode($data['req_id']);
	    
	    $this->db->select('*');
	    $this->db->order_by('date','desc');
	    $this->db->limit('1');
	    $pl_result = $this->db->get_where('pl_management',array('ecode'=>$ecode,'type'=>'PL','status'=>1))->result_array();
	    
	    if(count($pl_result)>0){
	        $this->db->select('*');
	        $request_info = $this->db->get_where('users_leave_requests',array('id'=>$data['req_id'],'status'=>1))->result_array();
	        
	        $this->db->insert('pl_management',array(
	            'type' => 'PL',
	            'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
	            'ecode' => $ecode,
	            'credit' => '',
	            'debit' => $request_info[0]['pl'],
	            'balance' => (float)$pl_result[0]['balance'] - $request_info[0]['pl'],
	            'date' => date('Y-m-d H:i:s'),
	            'created_at' => date('Y-m-d H:i:s'),
	            'created_by' => $this->session->userdata('ecode')
	        ));
	    } else {
	        $this->db->select('*');
	        $request_info = $this->db->get_where('users_leave_requests',array('id'=>$data['req_id'],'status'=>1))->result_array();
	        
	        $this->db->insert('pl_management',array(
	            'type' => 'PL',
	            'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
	            'ecode' => $ecode,
	            'credit' => '0',
	            'debit' => $request_info[0]['pl'],
	            'date' => date('Y-m-d H:i:s'),
	            'balance' => '-'.$request_info[0]['pl'],
	            'created_at' => date('Y-m-d H:i:s'),
	            'created_by' => $this->session->userdata('ecode')
	        ));
	    }
	    
	    if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}
	
	
	////OFF DAY DUTY REQUEST
	function off_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hr_name');
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
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
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
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hr_name');
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
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		return $result;
	}
	
	function hf_leave_request_update($data){
	    $this->db->trans_begin();
	    
    		$this->db->where('id',$data['req_id']);
    		$this->db->update('users_leave_requests',array(
    						$data['key'] => $data['value'],
    						'hr_id' => $data['hr_id'],
    						'hr_remark_date' => $data['created_at']
    						)
    		);
    		
    		$this->db->select('*');
    		$this->db->order_by('created_at','desc');
    		$this->db->limit(1);
    		$pl_result = $this->db->get_where('pl_management',array('ecode'=>$this->my_library->leave_requester_ecode($data['req_id']),'type'=>'PL','status'=>1))->result_array();
    		
    		if(count($pl_result)>0){
    		    $this->db->insert('pl_management',array(
    		        'type' => 'PL',
    		        'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
    		        'ecode' => $this->my_library->leave_requester_ecode($data['req_id']),
    		        'credit' => $pl_result[0]['credit'],
    		        'debit' => '0.5',
    		        'balance' => (float)$pl_result[0]['balance'] - '0.5',
    		        'created_at' => date('Y-m-d H:i:s'),
    		        'created_by' => $this->session->userdata('ecode')
    		    ));
    		} else {
    		    $this->db->insert('pl_management',array(
    		        'type' => 'PL',
    		        'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
    		        'ecode' => $this->my_library->leave_requester_ecode($data['req_id']),
    		        'credit' => '0',
    		        'debit' => '0.5',
    		        'balance' => '-0.5',
    		        'created_at' => date('Y-m-d H:i:s'),
    		        'created_by' => $this->session->userdata('ecode')
    		    ));
    		}
    		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		    //$this->db->trans_rollback();
		    return true;
		}
	}
	
}