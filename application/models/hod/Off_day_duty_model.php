<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_day_duty_model extends CI_Model {
    
    ////OFF DAY DUTY REQUEST
    function off_day_duty_request_update($data){
        
        $this->db->trans_begin();
        
        $this->db->where('id',$data['req_id']);
        $this->db->update('users_leave_requests',array(
            'hod_remark' => $data['hod_remark'],
            'hod_status' => $data['value'],
            'hod_remark_date' => $data['created_at'],
            'request_status_code' => $data['request_status_code'],
            'hod_id' => $data['hod_id'] 
        ));
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    function total_off_day_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function off_day_leave_request($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $this->db->order_by('ulr.id','desc');
        $this->db->limit($offset,$limit);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function total_pending_offday_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function pending_offday_requests($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $this->db->order_by('ulr.id','desc');
        $this->db->limit($offset,$limit);
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'OFF_DAY','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
} 