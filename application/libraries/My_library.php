<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
 
class My_library {
	protected $CI;
	
	function __construct(){
        $this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->database();
    }
	
	function mydate($date){
		$date = str_replace('/', '-', $date);
		return date('Y-m-d', strtotime($date));
	}
	
	function sql_datepicker($date){
		return date("d/m/Y", strtotime($date));
	}
	
	function department_code($ecode){
		$this->CI->db->select('dm.dept_code');
		$this->CI->db->join('department_master dm','dm.id = u.department_id');
		$result = $this->CI->db->get_where('users u',array('u.ecode'=>$ecode,'u.status'=>1))->result_array();
		return $result[0]['dept_code'];
	}
	
	function get_employee_department($ecode){
		$this->CI->db->select('department_id');
		$result = $this->CI->db->get_where('users',array('status'=>1,'is_active'=>1,'ecode'=>$ecode))->result_array();
		return $result[0]['department_id'];
	}
	
	function get_paycode($ecode){
		$this->CI->db->select('paycode');
		$result = $this->CI->db->get_where('users',array('ecode'=>$ecode))->result_array();
		return $result[0]['paycode'];
	}
	
	function get_emp_default_shift($ecode){
		return 'F';
	}
	
	function reporting_to_mailid($ecode){
		$result = $this->CI->db->query("SELECT user_info.company_mailid FROM `users` 
					JOIN user_info on user_info.ecode = users.ecode
					WHERE department_id = (SELECT report_to_dept from users WHERE ecode = '$ecode')
					AND designation_id = (SELECT report_to_desg from users WHERE ecode = '$ecode')
					AND is_active = 1
					AND users.status = 1")->result_array();
		return $result;
	}
	
	function links($ecode){
		$this->CI->db->select('sl.link_name');
		$this->CI->db->join('system-links sl','sl.id = ul.link_id');
		$result = $this->CI->db->get_where('user_links ul',array('ul.ecode'=>$ecode,'ul.status'=>1))->result_array();
		if(count($result)>0){
			return $result;
		}	
	}
	
	function pl_calculator($ecode){
	    $this->CI->db->select('*');
	    $this->CI->db->order_by('created_at','desc');
	    $this->CI->db->limit(1);
	    $result = $this->CI->db->get_where('pl_management',array('type'=>'PL','ecode'=>$ecode))->result_array();
	    return $result;
	}
	
	function coff($ecode){
	    $this->CI->db->select('pl.*,date_format(ulr.date_from,"%d/%m/%Y") as date');
	    $this->CI->db->order_by('pl.created_at','desc');
	    $this->CI->db->join('users_leave_requests ulr','ulr.refrence_id = pl.refrence_no AND ulr.status = 1');
	    $result = $this->CI->db->get_where('pl_management pl',array('pl.type'=>'COFF','pl.credit<>'=>NULL,'pl.ecode'=>$ecode,'pl.status'=>1))->result_array();
	    return $result;
	}
	
	function nhfh($ecode){
	    $this->CI->db->select('pl.*,date_format(ulr.date_from,"%d/%m/%Y") as date');
	    $this->CI->db->order_by('pl.created_at','desc');
	    $this->CI->db->join('users_leave_requests ulr','ulr.refrence_id = pl.refrence_no AND ulr.status = 1');
	    $result = $this->CI->db->get_where('pl_management pl',array('pl.type'=>'NH_FH','pl.credit<>'=>NULL,'pl.ecode'=>$ecode,'pl.status'=>1))->result_array();
	    return $result;
	}
	
	function leave_requester_ecode($ref_id){
	    $this->CI->db->select('ecode');
	    $result = $this->CI->db->get_where('users_leave_requests',array('id'=>$ref_id))->result_array();
	    return $result[0]['ecode'];
	}
	
	function leave_request_refno($ref_id){
	    $this->CI->db->select('refrence_id');
	    $result = $this->CI->db->get_where('users_leave_requests',array('id'=>$ref_id))->result_array();
	    return $result[0]['refrence_id'];
	}
	
	function sentmail($mail_body,$sendto){
		$tos = '';
		foreach($sendto as $send){
			$tos = $tos.$send['company_mailid'].',';
		}
		$ids = rtrim($tos,',');
		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.ibc24.in',
            'smtp_port' => 25,
			'smtp_user' => 'rahul1.sinha@ibc24.in',
            'smtp_pass' => 'rahul1',
            'mailtype'  => 'html',
			'wordwrap' 	=> TRUE,
            'charset'   => 'utf-8'
        );
		$this->CI->load->library('email', $config);
		$this->CI->email->initialize($config);		
		//$this->CI->email->attach($this->export_record());
		$this->CI->email->set_mailtype("html");
		$this->CI->email->from('No_reply@ibc24.in');
		$this->CI->email->to("'".$ids."'");
		$this->CI->email->subject('Half day request');
		$this->CI->email->message($mail_body);
		
		
        if (!$this->CI->email->send()){
            echo $this->CI->email->print_debugger();
        } else {
			echo $this->CI->email->print_debugger();
			print_r('mail send');
		}	
	}
	
}