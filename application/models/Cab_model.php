<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cab_model extends CI_Model {
	
    function cabrequest_count(){
        $this->db->select('max(id) as total');
        return $result = $this->db->get('cab_requests')->result_array();
    }
    
    function cab_timing($data){
        $this->db->select('*');
        $result = $this->db->get_where('cab_pickup_drop_time',array('type'=>$data['type'],'status'=>1))->result_array();
        return $result;
    }
    
    function cab_zone(){
        $this->db->select('*');
        $result = $this->db->get_where('cabzone_master',array('parent_id'=>0,'status'=>1))->result_array();
        return $result;
    }
    
    function get_location($data){
        $this->db->select('*');
        $result = $this->db->get_where('cabzone_master',array('parent_id'=>$data['zone'],'status'=>1))->result_array();
        return $result;
    }
    
    function cab_requests($ecode){
        $this->db->select('ct.*,cm.location_name as area,cpdt.time');
        $this->db->join('cabzone_master cm','cm.id = ct.area AND cm.status = 1');
        $this->db->join('cab_pickup_drop_time cpdt','cpdt.id = ct.time');
        $this->db->order_by('ct.request_date','desc');
        $result = $this->db->get_where('cab_requests ct',array('ct.status'=>1))->result_array();
        return $result;
    }
    
    function cab_request_submit($data){
        $this->db->insert_batch('cab_requests',$data);
        if($this->db->insert_id()){
            return true;
        }
    }
    
    function view_requests(){
        $this->db->select('date_format(from_date,"%d/%m/%Y") as from_date,sum(IF(type="drop",1,0)) as DROPS,sum(IF(type="pick",1,0)) pickup');
        $this->db->group_by('from_date');
        $this->db->order_by('from_date','asc');
        $result = $this->db->get_where('cab_requests',array('cab_status'=>'PENDING','status'=>1))->result_array();
        return $result;
    }
}