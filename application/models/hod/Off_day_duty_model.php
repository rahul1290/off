<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_day_duty_model extends CI_Model {
    
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
            $this->db->where('ulr.reference_id',$ref_id);
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
            $this->db->where('ulr.reference_id',$ref_id);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
} 