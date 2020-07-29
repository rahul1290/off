<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hf_leave_model extends CI_Model {

    function hf_leave_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update,,u1.name as hod_name');
        //$this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('users u1','u1.ecode = ulr.hr_id','LEFT');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->order_by('hr_remark_date','desc');
        if($ref_id != null){
            $this->db->where('ulr.reference_id',$ref_id);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'GRANTED','ulr.hr_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        
        //print_r($this->db->last_query()); die
        return $result;
    }
    
    function hf_leave_pending_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hr_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        //$this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.reference_id',$ref_id);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    
    function total_hf_pending_request(){
        $this->db->select('dm.id,dm.dept_name,count(*) as requests');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->group_by('dm.id');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function get_hf_ids($data){
        $this->db->select('ulr.id,ulr.reference_id');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->where('dm.id',$data['dept_id']);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function request_detail($parms){
        $this->db->select('*');
        $data['leave_detail'] = $this->db->get_where('users_leave_requests',array('id'=>$parms['ref_id'],'status'=>1))->result_array();
        
        if(count($data['leave_detail'])>0){
            $data['leave_detail'][0]['duration'] = $this->my_library->day_duration($data['leave_detail'][0]['date_from'],$data['leave_detail'][0]['date_to']);
            $this->db->select('u.*,dm.dept_name,desg.desg_name');
            $this->db->join('department_master dm','dm.id = u.department_id');
            $this->db->join('designation_master desg','desg.id = u.designation_id');
            $data['user_detail'] = $this->db->get_where('users u',array('u.ecode'=>$data['leave_detail'][0]['ecode']))->result_array();
            
            $this->db->select('*');
            $this->db->limit(1);
            $this->db->order_by('date','desc');
            $data['pls'] = $this->db->get_where('pl_management',array('ecode'=>$data['leave_detail'][0]['ecode']))->result_array();   
        }
        return $data;
    }
    
    function hf_request_submit($data){
        $this->db->trans_begin();
        
        $this->db->where('reference_id',$data['application_no']);
        $this->db->update('users_leave_requests',array(
                    'hr_id' => $this->session->userdata('ecode'),
                    'hr_remark' => $data['hr_remark'],
                    'hr_status' => 'GRANTED',
                    'hr_remark_date' => date('Y-m-d H:i:s'),
                    'request_status_code' => 3
                ));
        
        if($data['pl_deduction'] == 'yes'){
            $this->db->select('ecode');
            $empDetail = $this->db->get_where('users_leave_requests',array('reference_id'=>$data['application_no']))->result_array();
            $pls = $this->my_library->pl_calculator($empDetail[0]['ecode']);
            
            $this->db->insert("pl_management",array(
                    'type' => 'PL',
                    'refrence_no' => $this->my_library->remove_hyphen($data['application_no']),
                    'ecode' => $empDetail[0]['ecode'],
                    'credit' => NULL,
                    'debit' => '0.5',
                    'balance' => $pls[0]['balance'] - '0.5',
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
    
    function hf_leave_request_update($data){
        $this->db->trans_begin();
        
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
            //$this->db->trans_rollback();
            return true;
        }
    }
    
    ////////HF cancelletion Adjustment/////////////////
    function adjustment_hf_cancel_request(){
        $this->db->select('dm.id,dm.dept_name,ulr.*');
        $this->db->where('u.is_active','YES');
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        $this->db->order_by('ulr.id','DESC');
        $result = $this->db->get_where('users_leave_requests ulr',array(
            'request_type'=>'HALF',
            'ulr.hod_status'=>'GRANTED',
            'ulr.hr_status'=>'GRANTED',
            'ulr.status'=> 1,
            'ulr.request_status_code <>' => 5,
            'ulr.date_from >=' => date('Y-m-d', strtotime("-2 months")),
        ))->result_array();
        return $result;
    }
    
    function cancel_adjustment($ref_id){
        $ecode = '';
        $ecode = $this->my_library->getEcode_refId($ref_id);
        if(isset($ecode)){
            $ref_id = str_replace('/','-',$ref_id);
            $ecode = $this->my_library->getEcode_refId($ref_id);
        }
        
        $pls = $this->my_library->pl_calculator($ecode);
        $balance = $pls[0]['balance'];
        
        $this->db->trans_begin();
        
        $this->db->insert('pl_management',array(
            'type' => 'PL',
            'refrence_no' => $ref_id,
            'ecode' => $ecode,
            'debit' => '0.5',
            'balance' => $balance - '0.5',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('ecode'),
            'date' => date('Y-m-d H:i:s'),
            'status' => 1
        ));
        
        $this->db->where('reference_id',$ref_id);
        $this->db->update('users_leave_requests',array(
            'request_status_code' => 5
        ));
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}