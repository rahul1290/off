<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_day_duty_model extends CI_Model {
 
    
    function off_day_duty_pending_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        //$this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.reference_id',$ref_id);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function total_off_day_duty_pending_request(){
        $this->db->select('dm.id,dm.dept_name,count(*) as requests');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->group_by('dm.id');
        $this->db->order_by('dm.dept_name','asc');
        $this->db->where('ulr.request_id IS NULL', null, false);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING',
            'ulr.date_from >' => date('Y-m-d', strtotime("-60 days")),
            'ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function request_list($data) {
        $this->db->select('dm.id,dm.dept_name,u.name,ulr.*');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->where('ulr.request_id IS NULL', null, false);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING',
            'ulr.date_from >' => date('Y-m-d', strtotime("-60 days")),
            'dm.id' => $data['dept_id'],
            'ulr.status'=>1))->result_array();
        return $result;
    }
    
    function off_day_duty_request_submit($data){
        $this->db->trans_begin();
        
        $this->db->where('reference_id',$data['application_no']);
        $this->db->update('users_leave_requests',array(
            'hr_id' => $this->session->userdata('ecode'),
            'hr_remark' => $data['hr_remark'],
            'hr_status' => 'GRANTED',
            'hr_remark_date' => date('Y-m-d H:i:s')
        ));
        
        if($data['pl_deduction'] == 'yes'){
            $this->db->select('ecode');
            $empDetail = $this->db->get_where('users_leave_requests',array('reference_id'=>$data['application_no']))->result_array();
            $pls = $this->my_library->pl_calculator($empDetail[0]['ecode']);
            
            $this->db->insert("pl_management",array(
                'type' => 'PL',
                'refrence_no' => $data['application_no'],
                'ecode' => $empDetail[0]['ecode'],
                'credit' => NULL,
                'debit' => $pls[0]['balance'] - '0.5',
                'date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('ecode'),
                'status' => 1
            ));
            
        }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    function off_day_duty_request_update($data){
        $this->db->trans_begin();
        
        $this->db->where('id',$data['req_id']);
        $this->db->update('users_leave_requests',array(
            $data['key'] => $data['value'],
            'hr_id' => $data['hr_id'],
            'hr_remark_date' => $data['created_at']
        )
            );
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            //$this->db->trans_rollback();
            return true;
        }
    }
}
