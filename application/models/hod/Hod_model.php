<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hod_model extends CI_Model {

    ////LEAVE REQUEST
    function total_leave_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function leave_request($ulist,$ref_id,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,(select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "NH_FH") as nhfhs');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.refrence_id',$ref_id);
        }
        $this->db->limit($offset,$limit);
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function total_pending_leave_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.created_at','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function leave_pending_request($ulist,$ref_id,$offset,$limit){
        if($ref_id != null){
            $this->db->where('ulr.refrence_id',$ref_id);
        }
        $this->db->order_by('ulr.id','DESC');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function pending_leave_requests($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,(select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "NH_FH") as nhfhs');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->limit($offset,$limit);
        $this->db->order_by('ulr.id','DESC');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function leave_pending_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,(select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.refrence_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.refrence_id AND ulr2.request_type = "NH_FH") as nhfhs');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.refrence_id',$ref_id);
        }
        $this->db->limit($offset,$limit);
        $this->db->order_by('ulr.id','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
    }
    
    
    function leave_request_update($data){
        $this->db->trans_begin();
        
            $this->db->where('id',$data['req_id']);
            $this->db->update('users_leave_requests',array(
                $data['key'] => $data['value'],
                'hod_id' => $data['hod_id'],
                'hod_remark_date' => $data['created_at']
            ));    
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    
	////HALF DAY REQUEST
	function hf_leave_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$this->db->order_by('ulr.hod_remark_date','desc');
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function hf_leave_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$this->db->order_by('ulr.id','desc');
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	

	function hf_leave_request_update($data){
	    $this->db->trans_begin();
    		$this->db->where('id',$data['req_id']);
    		$this->db->update('users_leave_requests',array(
    				$data['key'] => $data['value'],
    				'hod_id' => $data['hod_id'],
    				'hod_remark_date' => $data['created_at']
    				)
    		);
    		
    		if($data['value'] == 'GRANTED'){
    		    $this->db->select('*');
    		    $leave_detail = $this->db->get_where('users_leave_requests',array('id'=>$data['req_id']))->result_array();
    		    
    		    $pls = $this->my_library->pl_calculator($leave_detail[0]['ecode']);
    		    
    		    if($pls < 0){
    		        $update_data = array(
    		            'pl' => '0.5',
    		        );
    		    } else {
    		        $update_data = array(
    		            'lop' => '0.5',
    		        );
    		    }
    		    
    		    $this->db->where('refrence_id',$leave_detail[0]['refrence_id']);
    		    $this->db->update('users_leave_requests',$update_data);
    		    
//     		    $this->db->insert('pl_management',array(
//     		              'type' => 'PL',
//     		        'refrence_no' =>  $leave_detail[0]['refrence_id'],
//     		        'ecode' => $leave_detail[0]['ecode'],
//     		              'credit' => '0',
//     		              'debit' => '0.5',
//     		              'balance' => $pls[0]['balance'] - '0.5',
//     		              'date' => date('Y-m-d H:i:s'),
//     		              'created_at'    => date('Y-m-d H:i:s'),
//     		              'created_by'    => $this->session->userdata('ecode')
//     		    ));
    		}
    		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}
	
	
	////////nh fh avail form
	function nh_fh_day_duty_request_update($data){
	    $this->db->trans_begin();
	    
	    $this->db->where('id',$data['req_id']);
	    $this->db->update('users_leave_requests',array(
	        $data['key'] => $data['value'],
	        'hod_id' => $data['hod_id'],
	        'hod_remark_date' => $data['created_at']
	    ));
	    
// 	    if($data['value'] == 'GRANTED'){
// 	        $this->db->select('*');
// 	        $reqest_details = $this->db->get_where('users_leave_requests',array('id'=>$data['req_id']))->result_array();
	        
// 	        $pls = $this->my_library->pl_calculator($reqest_details[0]['ecode']);
// 	        $balance = $pls[0]['balance'] + 1;
	        
// 	        $this->db->insert('pl_management',array(
// 	            'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
// 	            'ecode' => $reqest_details[0]['ecode'],
// 	            'credit' => 1,
// 	            'balance' => $balance,
// 	            'date' => date('Y-m-d H:i:s'),
// 	            'created_at' => date('Y-m-d H:i:s'),
// 	            'created_by' => $this->session->userdata('ecode')
// 	        ));
// 	    }
	    
	    if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}
	
	////OFF DAY DUTY REQUEST
	function off_day_duty_request_update($data){
	    $this->db->trans_begin();
	    
	    $this->db->where('id',$data['req_id']);
	    $this->db->update('users_leave_requests',array(
	        $data['key'] => $data['value'],
	        'hod_id' => $data['hod_id'],
	        'hod_remark_date' => $data['created_at']
	     ));
	    
// 	    $this->db->select('*');
// 	    $reqest_details = $this->db->get_where('users_leave_requests',array('id'=>$data['req_id']))->result_array();
	    
// 	    $pls = $this->my_library->pl_calculator($reqest_details[0]['ecode']);
// 	    $balance = $pls[0]['balance'] + 1;
	     
// 	    if($data['value'] == 'GRANTED'){
// 	        $this->db->insert('pl_management',array(
// 	            'refrence_no' => $this->my_library->leave_request_refno($data['req_id']),
// 	            'ecode' => $reqest_details[0]['ecode'],
// 	            'credit' => 1,
// 	            'balance' => $balance,
// 	            'date' => date('Y-m-d H:i:s'),
// 	            'created_at' => date('Y-m-d H:i:s'),
// 	            'created_by' => $this->session->userdata('ecode')
// 	        ));
// 	    }
	    
	    if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}
	
	function off_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$this->db->order_by('ulr.hod_remark_date','desc');
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function off_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
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
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$this->db->order_by('ulr.hod_remark_date','desc');
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	function nh_fh_day_duty_pending_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.refrence_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
		return $result;
	}
	
	////NH FH AVAIL REQUEST
	function nh_fh_avail_request($ulist,$ref_id){
	    $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
	    $this->db->where_in('ulr.ecode',$ulist,false);
	    $this->db->join('users u','u.ecode = ulr.ecode');
	    $this->db->join('department_master dm','dm.id = u.department_id');
	    if($ref_id != null){
	        $this->db->where('ulr.refrence_id',$ref_id);
	    }
	    $this->db->order_by('ulr.created_at','desc');
	    $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH_AVAIL','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
	    return $result;
	}
	
	function nh_fh_avail_pending_request($ulist,$ref_id){
	    $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
	    $this->db->where_in('ulr.ecode',$ulist,false);
	    $this->db->join('users u','u.ecode = ulr.ecode');
	    $this->db->join('department_master dm','dm.id = u.department_id');
	    if($ref_id != null){
	        $this->db->where('ulr.refrence_id',$ref_id);
	    }
	    $this->db->order_by('ulr.created_at','desc');
	    $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH_AVAIL','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
	    return $result;
	}
	
	function nh_fh_avail_request_update($data){
	    $this->db->where('id',$data['req_id']);
	    $this->db->update('users_leave_requests',array(
	        $data['key'] => $data['value'],
	        'hod_id' => $data['hod_id'],
	        'hod_remark_date' => $data['created_at']
	    )
	   );
	    return true;
	}
} 