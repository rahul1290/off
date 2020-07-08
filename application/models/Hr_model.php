<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_model extends CI_Model {
	
    function total_leave_request($str){
        $this->db->select('count(*) as total');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->order_by('ulr.id','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array(
            'request_type'=>'LEAVE',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status<>'=>'PENDING',
            'ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function leave_request($str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hod_name,(select group_concat(ulr2.reference_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.reference_id AND ulr2.request_type = "OFF_DAY") as coff,
						 (select group_concat(ulr2.reference_id) from users_leave_requests ulr2 WHERE ulr2.request_id = ulr.reference_id AND ulr2.request_type = "NH_FH") as nhfhs');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->order_by('ulr.id','desc');
        $this->db->where('(ulr.reference_id like "%'.$str.'%" OR ulr.requirment like "%'.$str.'%")');
        $this->db->limit($offset,$limit);
        $result = $this->db->get_where('users_leave_requests ulr',array(
            'request_type'=>'LEAVE',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status<>'=>'PENDING',
            'ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function total_leave_pending_request(){
        $this->db->select('dm.id,dm.dept_name,count(*) as requests');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->group_by('dm.id');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function get_leave_ids($data){
        $this->db->select('ulr.id,ulr.reference_id');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->where('dm.id',$data['dept_id']);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'LEAVE',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function leave_detail($parms){
        $this->db->select('*');
        $data['leave_detail'] = $this->db->get_where('users_leave_requests',array('id'=>$parms['ref_id'],'status'=>1))->result_array();
        
        if(count($data['leave_detail'])>0){
            $data['leave_detail'][0]['duration'] = $this->my_library->day_duration($data['leave_detail'][0]['date_from'],$data['leave_detail'][0]['date_to']);
            $this->db->select('u.*,dm.dept_name,desg.desg_name');
            $this->db->join('department_master dm','dm.id = u.department_id');
            $this->db->join('designation_master desg','desg.id = u.designation_id');
            $data['user_detail'] = $this->db->get_where('users u',array('u.ecode'=>$data['leave_detail'][0]['ecode']))->result_array();
            
            $data['coff'] = $this->my_library->empCoffHr($data['leave_detail'][0]['ecode']);
            $data['nhfh'] = $this->my_library->empNhfhHr($data['leave_detail'][0]['ecode']);
            
            
            $this->db->select('*');
            $this->db->limit(1);
            $this->db->order_by('id','desc');
            $data['pls'] = $this->db->get_where('pl_management',array('ecode'=>$data['leave_detail'][0]['ecode']))->result_array();
            
        }
        return $data;
    }
    
    
    function leave_request_submit($data){
        $this->db->trans_begin();
        
        $this->db->where('reference_id',$data['application_no']);
        $this->db->update('users_leave_requests',array(
                                    'hr_status'=>'GRANTED',
                                    'hr_id' => $this->session->userdata('ecode'),
                                    'hr_remark'=>'',
                                    'hr_remark_date'=>date('y-m-d H:i:s'),
                                    'pl'=>$data['pls'],
                                    'lop'=>$data['lop'])
            );
        
        if(isset($data['coff'])){
            if(count($data['coff'])>0){ 
                $this->db->where_in('reference_id',$data['coff']);
                $this->db->update('users_leave_requests',array('request_id'=>$data['application_no']));
            }
        }
       
        if(isset($data['nhfh'])){
            if(count($data['nhfh'])>0){
                $this->db->where_in('reference_id',$data['nhfh']);
                $this->db->update('users_leave_requests',array('request_id'=>$data['application_no']));
            }
        }
        
        if($data['pls']>0){
            $this->db->select('ecode');
            $empDetail = $this->db->get_where('users_leave_requests',array('reference_id'=>$data['application_no']))->result_array();
            $pls = $this->my_library->pl_calculator($empDetail[0]['ecode']);
            
            $this->db->insert("pl_management",array(
                'type' => 'PL',
                'refrence_no' => $data['application_no'],
                'ecode' => $empDetail[0]['ecode'],
                'credit' => NULL,
                'debit' => $pls[0]['balance'] - $data['pls'],
                'date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('ecode'),
                'status' => 1
            ));
        }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    
	function leave_request_update($data){
	    $this->db->trans_begin();
	    if($data['value'] == 'REJECTED') {   
	        $this->db->query("UPDATE pl_management set status = 0 where refrence_no = '".$this->my_library->leave_request_refno($data['req_id'])."'");
	       $this->db->query("update users_leave_requests set request_id = NULL,pl = 0,lop = 0 where reference_id = '".$this->my_library->leave_request_refno($data['req_id'])."'");
	       
	       $this->db->where('request_id',$this->my_library->leave_request_refno($data['req_id']));
	       $this->db->update('users_leave_requests',array('request_id'=>NULL));
	    }
	    
	    $this->db->where('id',$data['req_id']);
	    $this->db->update('users_leave_requests',array(
	        $data['key'] => $data['value'],
	        'hr_id' => $data['hr_id'],
	        'hr_remark_date' => $data['created_at']
	    ));
	    
	    if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

////NH FH DAY DUTY REQUEST
	function nh_fh_day_duty_request($ulist,$ref_id){
		$this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,u1.name as hr_name');
		$this->db->where_in('ulr.ecode',$ulist,false);
		$this->db->join('users u','u.ecode = ulr.ecode');
		$this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
		$this->db->join('department_master dm','dm.id = u.department_id');
		if($ref_id != null){
			$this->db->where('ulr.reference_id',$ref_id);
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
			$this->db->where('ulr.reference_id',$ref_id);
		}
		$result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		return $result;
	}
	
}