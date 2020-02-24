<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
 
class My_library {
	protected $CI;
	
	public function __construct(){
        $this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->database();
    }
	
	public function mydate($date){
		$date = str_replace('/', '-', $date);
		return date('Y-m-d', strtotime($date));
	}
	
	public function sql_datepicker($date){
		return date("d/m/Y", strtotime($date));
	}
	
	public function department_code($ecode = 'SBMMPL-01149'){
		$this->CI->db->select('dm.dept_code');
		$this->CI->db->join('department_master dm','dm.id = u.department_id');
		$result = $this->CI->db->get_where('users u',array('u.ecode'=>$ecode,'u.status'=>1))->result_array();
		return $result[0]['dept_code'];
	}
	
	public function get_paycode($ecode){
		$this->CI->db->select('paycode');
		$result = $this->CI->db->get_where('users',array('ecode'=>$ecode))->result_array();
		return $result[0]['paycode'];
	}
	
	function links($ecode){
		$this->CI->db->select('sl.link_name');
		$this->CI->db->join('system-links sl','sl.id = ul.link_id');
		$result = $this->CI->db->get_where('user_links ul',array('ul.ecode'=>$ecode,'ul.status'=>1))->result_array();
		if(count($result)>0){
			return $result;
		}	
	}
	
	
}