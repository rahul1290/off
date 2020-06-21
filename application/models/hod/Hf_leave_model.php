<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hf_leave_model extends CI_Model {
    
    function total_hf_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    
    function hf_leave_request($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $this->db->limit($offset,$limit);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function total_pending_hf_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.id','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'HALF','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function pending_hf_requests($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.refrence_id',$str);
        }
        $this->db->order_by('ulr.id','desc');
        $this->db->limit($offset,$limit);
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
    
} 