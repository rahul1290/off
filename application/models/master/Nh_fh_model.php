<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nh_fh_model extends CI_Model {
	
	function get_nhfh($nfm_id = null){
		if($nfm_id == null){ 
			$this->db->select('nfm.*,date_format(nfm.nhfh_date,"%d/%m/%Y") as nhfh_date,date_format(nfm.updated_at,"%d/%m/%Y %H:%i:%s") as updated_at,IFNULL(u.name,"-") as updated_by');
			$this->db->join('users u','u.ecode = nfm.updated_by','left');
			$this->db->order_by('nfm.nhfh_date,nfm.year','asc');
			$result = $this->db->get_where('nh_fh_master nfm',array('nfm.status'=>1))->result_array();
			return $result;
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('nh_fh_master',array('id'=>$nfm_id,'status'=>1))->result_array();
			return $result;
		}
	}
	
	function nhfh_update($data){
		$this->db->where('id',$data['id']);
		$this->db->update('nh_fh_master',array(
			'year'=>$data['year'],
			'nhfh_date'=>$data['date'],
			'remark'=>$data['remark'],
			'updated_by' => $data['updated_by'],
			'updated_at' => $data['updated_at']
		));
		return true;
	}
	
	function nhfh_create($data){
		$this->db->insert('nh_fh_master',array(
			'year' => $data['year'],
			'nhfh_date' => $data['nhfh_date'],
			'remark' => $data['remark'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['created_at'],
			'created_by'=>$data['updated_by'],
			'updated_by' => $data['updated_by']
		));
		return true;
	}
	
	function nhfh_delete($data){
		$this->db->where('id',$data['id']);
		$this->db->update('nh_fh_master',array('status'=>0));
		return true;
	}
	
	function user_nhfh_requests($ecode){
		$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
		$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'NH_FH','status'=>1))->result_array();
		return $result;
	}
	
	function nh_fh_day_duty_form($data){
		if($this->db->insert('users_leave_requests',$data)){
			return true;
		} else {
			return false;
		}
	}
	
	
	function nh_fh_avail($data){
	    $this->db->select('*');
	    $date = $this->db->get_where('nh_fh_master',array('id'=>$data['nhfh_date'],'status'=>1))->result_array();
	    
	    $ref['request_type'] = 'NH_FH_AVAIL';
	    $ref['refrence_id'] = 'NH_HF_AVAIL-'.date('Y').'-'.$this->my_library->department_code($this->session->userdata('ecode'));
	    
	    if(count($date)>0){    //if nh/fh date axist 
    	    $this->db->select('*');
    	    $result = $this->db->get_where('users_leave_requests',array(
    	                                               'request_type'=>'NH_FH_AVAIL',
    	                                               'date_from' => $date[0]['nhfh_date'],
    	                                               'status'=>1
    	                                   ))->result_array();
               if(count($result)>0){  // if user already applied
                   return false;
               } else {
                   $this->db->insert('users_leave_requests',array(
                       'request_type'   => 'NH_FH_AVAIL',
                       'refrence_id'    => $ref['refrence_id'],
                       'ecode'          => $this->session->userdata('ecode'),
                       'requirment'     => $data['requirment'],
                       'date_from'      => $date[0]['nhfh_date'], 
                       'date_to'        => $date[0]['nhfh_date'],
                       'created_at'     => date('Y-m-d H:i:s'),
                   ));
                   
                   $x = $this->db->insert_id();
                   $this->db->where('id',$x);
                   $this->db->update('users_leave_requests',array('refrence_id'=>$ref['refrence_id'].'-'.$x));
                   return true; 
               }
	    } else { // if nh/fh date not axist
	        return false;
	    }
	   
	}
	
	function user_nhfh_avail_requests($ecode){
	    $this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
	    $result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'NH_FH_AVAIL','status'=>1))->result_array();
	    return $result;
	}
	
	function nh_fh_avail_ajax($data){
	    $this->db->select('*');
	    $date = $this->db->get_where('nh_fh_master',array('id'=>$data['nhfh_date'],'status'=>1))->result_array();
	    
	    if(count($date)>0){
	        $this->db->select('*');
	        $result = $this->db->get_where('users_leave_requests',array(
	            'request_type'=>'NH_FH_AVAIL',
	            'date_from' => $date[0]['nhfh_date'],
	            'status'=>1
	        ))->result_array();
	        if(count($result)>0){
	            return '501';  //already applied 
	        } else {
	            return '200';
	        }
	    } else {
	       return '401'; //nhfh date not found   
	    }
	}
	
}