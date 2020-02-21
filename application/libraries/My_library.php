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
	
	public function department_code($ecode = 'SBMMPL-01149'){
		$this->CI->db->select('dm.dept_code');
		$this->CI->db->join('department_master dm','dm.id = u.department_id');
		$result = $this->CI->db->get_where('users u',array('u.ecode'=>$ecode,'u.status'=>1))->result_array();
		return $result[0]['dept_code'];
	}
	
	
}