<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nh_fh_model extends CI_Model {
    
    ////////nh fh avail form
    function nh_fh_day_duty_request_update($data){
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
    
    ////NH FH DAY DUTY REQUEST
    function total_nhfh_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function nh_fh_day_duty_request($ulist,$ref_id){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($ref_id != null){
            $this->db->where('ulr.reference_id',$ref_id);
        }
        $this->db->order_by('ulr.hod_remark_date','desc');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status<>'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
    
    function total_pending_nhfh_requests($ulist,$str){
        $this->db->select('count(*) as total');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result[0]['total'];
    }
    
    function pending_nhfh_requests($ulist,$str,$offset,$limit){
        $this->db->select('ulr.*,u.name,dm.dept_name,DATE_FORMAT(ulr.date_from,"%d/%m/%Y") as date,DATE_FORMAT(ulr.created_at,"%d/%m/%Y %H:%i:%s") as created_at,DATE_FORMAT(ulr.hod_remark_date,"%d/%m/%Y %H:%i:%s") as last_update');
        $this->db->where_in('ulr.ecode',$ulist,false);
        $this->db->join('users u','u.ecode = ulr.ecode');
        $this->db->join('department_master dm','dm.id = u.department_id');
        if($str != null){
            $this->db->where('ulr.reference_id',$str);
        }
        $this->db->limit($offset,$limit);
        $this->db->order_by('ulr.id','DESC');
        $result = $this->db->get_where('users_leave_requests ulr',array('request_type'=>'NH_FH','ulr.hod_status'=>'PENDING','ulr.status'=>1))->result_array();
        return $result;
    }
} 