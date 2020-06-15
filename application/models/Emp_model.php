<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_model extends CI_Model {
	
	function employee($emp_id = null){
		if($emp_id == null) { 
			$this->db->select('ecode,id,name,password,department_id');
			$result = $this->db->get_where('users',array('ecode'=>$data['identity'],'password'=>$data['password'],'status'=>1))->result_array();
			
		} else {
			$this->db->select('ecode,id,name,password,department_id');
			$result = $this->db->get_where('users',array('ecode'=>$emp_id,'status'=>1))->result_array();
		}
		if(count($result) == 1){
			return $result;
		} else {
			return false;
		}
	}
	
	function get_employee($ecode,$dept_id = null){
		$this->db->select('u.ecode,u.id,u.name,u.password,u.department_id');
		$this->db->join('users u','u.ecode = ur.r_ecode');
		if($dept_id != null){
			$this->db->where('u.department_id',$dept_id);
		}
		$result = $this->db->get_where('user_rules ur',array('ur.ecode'=>$ecode,'ur.status'=>1))->result_array();
		return $result;
	}
	
	function attendance($data){
		$db2 = $this->load->database('sqlsrv', TRUE);
		
		$db2->select("tblr.*,convert(varchar, tblr.DateOFFICE, 103) as DateOFFICE,
							ISNULL(substring(CONVERT(VARCHAR,tblr.IN1, 108), 0, 6),'') AS IN1, 
							ISNULL(substring(CONVERT(VARCHAR,tblr.OUT2, 108), 0, 6),'') AS OUT2,
							(CASE WHEN LATEARRIVAL >= 60 THEN
								(SELECT CAST((LATEARRIVAL / 60) AS VARCHAR(2)) + ' HOURS ' +  
										CASE WHEN (LATEARRIVAL % 60) > 0 THEN
											CAST((LATEARRIVAL % 60) AS VARCHAR(2)) + ' MINUTES'
										ELSE
											'0 MINUTES'
										END)
							ELSE 
								CASE WHEN LATEARRIVAL = 0 THEN
									' '
								ELSE	
									CAST((LATEARRIVAL % 60) AS VARCHAR(2)) + ' MINUTES'
								END
							END) as LATEARRIVAL,
							(CASE WHEN HOURSWORKED >= 60 THEN
								(SELECT CAST((HOURSWORKED / 60) AS VARCHAR(2)) + ' HOURS ' +  
										CASE WHEN (HOURSWORKED % 60) > 0 THEN
											CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' MINUTES'
										ELSE
											'0 MINUTES'
										END)
							ELSE 
								CASE WHEN HOURSWORKED = 0 THEN
									' '
								ELSE	
									CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' MINUTES'
								END
							END) as HOURSWORKED");
		//$this->db->join($this->config->item('NEWZ36').'LoginKRA l','l.PAYCODE = tblr.PAYCODE');
		$db2->where(array('tblr.DateOFFICE >='=>$data['from_date'],'tblr.DateOFFICE <='=>$data['to_date']));
		$result = $db2->get_where($this->config->item('Savior').'tblTimeRegister tblr',array('tblr.PAYCODE'=>$data['paycode']))->result_array();
		return $result;
	}
	
	function day_attendance($nhfhdate,$emp_paycode){
		$db2 = $this->load->database('sqlsrv', TRUE);
		$db2->select("PRESENTVALUE,
						ISNULL(substring(CONVERT(VARCHAR,IN1, 108), 0, 6),'') AS IN1, 
						ISNULL(substring(CONVERT(VARCHAR,OUT2, 108), 0, 6),'') AS OUT2,
						(CASE WHEN HOURSWORKED >= 60 THEN
								(SELECT CAST((HOURSWORKED / 60) AS VARCHAR(2)) + ' Hours ' +  
										CASE WHEN (HOURSWORKED % 60) > 0 THEN
											CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' Minutes'
										ELSE
											'0 Minutes'
										END)
							ELSE 
								CASE WHEN HOURSWORKED = 0 THEN
									' '
								ELSE	
									CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' Minutes'
								END
							END) as HOURSWORKED"
					);
		$result = $db2->get_where($this->config->item('Savior').'tblTimeRegister',array('DateOFFICE'=>$nhfhdate,'PAYCODE'=>$emp_paycode))->result_array();
		return $result; 
	}
	
	/////////////////////////////////// es leave requests //////////////////////////////
	function total_leave_requests($ecode,$str){
	    $result = $this->db->query('SELECT count(*) as total
                FROM users_leave_requests p
                WHERE p.request_type = "LEAVE"
                AND p.ecode = "'.$ecode.'"
                AND (refrence_id like "%'. $str .'%" OR requirment like "%'. $str .'%")
                AND p.status = 1 order by refrence_id desc')->result_array();
	    return $result[0]['total'];
	}
	
	function leave_requests_ajax($ecode,$str,$offset,$limit){
	    $result = $this->db->query('SELECT p.*, date_format(p.created_at, "%d/%m/%Y %H:%i:%s") as created_at, date_format(p.date_from, "%d/%m/%Y") as date_from, date_format(p.date_to, "%d/%m/%Y") as date_to,
                			(select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("NH_FH")) as NHFH,
                            (select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("OFF_DAY")) as COFF
                FROM users_leave_requests p
                WHERE p.request_type = "LEAVE"
                AND p.ecode = "'.$ecode.'"
                AND (refrence_id like "%'. $str .'%" OR requirment like "%'. $str .'%") 
                AND p.status = 1 order by refrence_id desc limit '.$limit.','.$offset.'')->result_array();
	    return $result;
	}
	
	// 	function leave_requests($ecode){
	//         return $this->db->query('SELECT p.*, date_format(p.created_at, "%d/%m/%Y %H:%i:%s") as created_at, date_format(p.date_from, "%d/%m/%Y") as date_from, date_format(p.date_to, "%d/%m/%Y") as date_to,
	//                 			(select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("NH_FH")) as NHFH,
	//                             (select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("OFF_DAY")) as COFF
	//                 FROM users_leave_requests p
	//                 WHERE p.request_type = "LEAVE"
	//                 AND p.ecode = "'.$ecode.'"
	//                 AND p.status = 1 order by refrence_id desc')->result_array();
	// 	}
	
	/////////////////////////////////// es leave requests //////////////////////////////
	


	/////////////////////////////////// HALF leave requests //////////////////////////////
	function total_hf_leave_requests($ecode,$str){
	    $this->db->select('count(*) as total');
	    $this->db->where('(refrence_id like "%'.$str.'%" OR requirment like "%'.$str.'%")');
	    $result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'HALF','status'=>1))->result_array();
	    return $result[0]['total'];
	}
	
	function hf_leave_requests($ecode,$str,$offset,$limit){
	    $this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date,date_format(hod_remark_date,"%d/%m/%Y %H:%i:%s") as hod_remark_date');
	    $this->db->where('(refrence_id like "%'.$str.'%" OR requirment like "%'.$str.'%")');
	    $this->db->order_by('date_from','DESC');
	    $this->db->limit($offset,$limit);
	    $result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'HALF','status'=>1))->result_array();
	    return $result;   
	}
	
	// 	function hf_leave_requests($ecode){
	// 	    $this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date,date_format(hod_remark_date,"%d/%m/%Y %H:%i:%s") as hod_remark_date');
	// 	    $this->db->order_by('date_from','DESC');
	// 	    $result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'HALF','status'=>1))->result_array();
	// 	    return $result;
	// 	}
	/////////////////////////////////// HALF leave requests //////////////////////////////
	
	
	/////////////////////////////////// OFF day requests //////////////////////////////
	function total_off_day_request_ajax($ecode,$str){
	    $this->db->select('count(*) as total');
	    $this->db->where('(refrence_id like "%'.$str.'%" OR requirment like "%'.$str.'%")');
	    $result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'OFF_DAY','status'=>1))->result_array();
	    return $result[0]['total'];
	}
	
	function off_day_request($ecode,$str,$offset,$limit){
    	$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
    	$this->db->where('(refrence_id like "%'.$str.'%" OR requirment like "%'.$str.'%")');
    	$this->db->order_by('id','desc');
    	$this->db->limit($offset,$limit);
    	$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'request_type'=>'OFF_DAY','status'=>1))->result_array();
    	return $result;
	}
	///////////////////////////////// OFF day requests //////////////////////////////
	
	
	function pl_summary_report($data){
		$this->db->select('*,IFNULL(credit," ") as credit,IFNULL(debit," ") as debit,IFNULL(balance," ") as balance');
		$this->db->order_by('id','desc');
		$result = $this->db->get_where('pl_management',array('ecode'=>$data['paycode'],'status'=>1))->result_array();
		return  $result;
	} 
}