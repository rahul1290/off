<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model'));
    }
	
	function index(){
		$data = array();
		$data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
		$data['users'] = $this->Emp_model->get_employee($this->session->userdata('ecode'));
		
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/shift',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | Grade Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function get_attendance(){
		$ecode = $this->input->post('ecode');
		$month = $this->input->post('month');
		
		if($month == 'p'){
			///check attendance recodes 
			$this->db->select('count(*) as count');
			$result = $this->db->get_where('temp_attendance ta',array('ta.atten_date >='=>date("Y-m-01",strtotime("first day of previous month")),'ta.atten_date <='=>date("Y-m-t",strtotime("first day of previous month")),'ecode'=>$ecode))->result_array();
			
			//if attendance record not found the insert the default record 
			if(!$result[0]['count']){
				$insertdata = array();
				for($i=1;$i<=date('t',strtotime("first day of previous month"));$i++){
					$temp = array();
					$temp['department_id'] = $this->my_library->get_employee_department($ecode);
					$temp['ecode'] = $ecode;
					$temp['atten_date'] = date("Y-m-$i",strtotime("first day of previous month"));
					$temp['shift_attendance'] = $this->my_library->get_emp_default_shift($ecode);
					$temp['created_at'] = date('Y-m-d H:i:s');
					$temp['created_by'] = $this->session->userdata('ecode');
					$insertdata[] = $temp;
				}
				$this->db->insert_batch('temp_attendance',$insertdata);
			}
			
			//fetch the record of previous month
			$data['paycode'] = $this->my_library->get_paycode($ecode);
			$data['from_date'] = date("Y-m-01", strtotime("first day of previous month"));
			$data['to_date'] = date("Y-m-01");
			$saviour = $this->Emp_model->attendance($data);
			
			$this->db->select('ta.*,u.name as uname,GROUP_CONCAT(shift_attendance) as shift');
			$this->db->where('ta.atten_date >=',date("Y-m-01", strtotime("first day of previous month")));
			$this->db->where('ta.atten_date <=',date("Y-m-t", strtotime("first day of previous month")));
			$this->db->having('shift<>','NULL'); 
			$this->db->join('users u','u.ecode = ta.ecode','left');
			$result = $this->db->get_where('temp_attendance ta',array('ta.ecode'=>$ecode))->result_array();
			
		
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'saviour'=>$saviour,'nofdays'=>date("t", strtotime("first day of previous month")),'status'=>200));
			} else {
				echo json_encode(array('saviour'=>$saviour,'nofdays'=>date("t", strtotime("first day of previous month")),'status'=>500));
			}
		} 
		else {
			///check attendance recodes
			$this->db->select('count(*) as count');
			$result = $this->db->get_where('temp_attendance ta',array('ta.atten_date >='=>date("Y-m-01"),'ta.atten_date <='=>date("Y-m-t"),'ecode'=>$ecode))->result_array();
			
			//if attendance record not found the insert the default record
			if(!$result[0]['count']){
				$insertdata = array();
				for($i=1;$i<=date('t');$i++){
					$temp = array();
					$temp['department_id'] = $this->my_library->get_employee_department($ecode);
					$temp['ecode'] = $ecode;
					$temp['atten_date'] = date("Y-m-$i");
					$temp['shift_attendance'] = $this->my_library->get_emp_default_shift($ecode);
					$temp['created_at'] = date('Y-m-d');
					$temp['created_by'] = $this->session->userdata('ecode');
					$insertdata[] = $temp;
				}
				$this->db->insert_batch('temp_attendance',$insertdata);
			}
			
			//fetch the record of current month
			$data['paycode'] = $this->my_library->get_paycode($ecode);
			$data['from_date'] = date("Y-m-01");
			$data['to_date'] = date("Y-m-01",strtotime("first day of next month"));
			$saviour = $this->Emp_model->attendance($data);
			
			$this->db->select('ta.*,u.name as uname,GROUP_CONCAT(shift_attendance) as shift');
			$this->db->where('ta.atten_date >=',date("Y-m-01"));
			$this->db->where('ta.atten_date <=',date("Y-m-t"));
			$this->db->having('shift<>','NULL'); 
			$this->db->join('users u','u.ecode = ta.ecode','left');
			$result = $this->db->get_where('temp_attendance ta',array('ta.ecode'=>$ecode))->result_array();
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'saviour'=>$saviour,'nofdays'=>date('t'),'status'=>200));
			} else {
				echo json_encode(array('saviour'=>$saviour,'nofdays'=>date('t'),'status'=>500));
			}
		}
	}
	
	function get_department_attendance(){
		$dept_id = $this->input->post('dept_id');
		$month = $this->input->post('month');
		
		if($month == 'p'){
			$this->db->select('ta.*,u.name as uname,GROUP_CONCAT(shift_attendance) as shift');
			$this->db->where('ta.atten_date >=',date("Y-m-01", strtotime("first day of previous month")));
			$this->db->where('ta.atten_date <=',date("Y-m-t", strtotime("first day of previous month")));
			$this->db->join('users u','u.ecode = ta.ecode','left');
			$this->db->having('shift<>','NULL'); 
			$this->db->group_by('ta.ecode');
			$result = $this->db->get_where('temp_attendance ta',array('ta.department_id'=>$dept_id))->result_array();
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'nofdays'=>date("t", strtotime("first day of previous month")),'status'=>200));
			} else {
				echo json_encode(array('status'=>500));
			}	
		} 
		else {
			$this->db->select('ta.*,u.name as uname,GROUP_CONCAT(shift_attendance order by ta.atten_date asc) as shift');
			$this->db->where('ta.atten_date >=',date("Y-m-01"));
			$this->db->where('ta.atten_date <=',date("Y-m-t"));
			$this->db->join('users u','u.ecode = ta.ecode','left');
			$this->db->having('shift<>','NULL');
			$this->db->order_by('ta.atten_date','ASC');
			$this->db->group_by('ta.ecode');
			$result = $this->db->get_where('temp_attendance ta',array('ta.department_id'=>$dept_id))->result_array();
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'nofdays'=>date('t'),'status'=>200));
			} else {
				echo json_encode(array('status'=>500));
			}
		}
	}
	
	function attendance_submit(){
		$dept_id = (int)$this->input->post('dept_id');
		$month = $this->input->post('month');
		$day  = $this->input->post('day');
		$ecode = $this->input->post('ecode');
		$shift = $this->input->post('shift');
		
		if($month == 'p'){
			$this->db->select('*');
			$result = $this->db->get_where('temp_attendance',array('department_id'=>$dept_id,'ecode'=>$ecode,'atten_date'=>date("Y-m-$day", strtotime("first day of previous month"))))->result_array();
			if(count($result)>0){
				$this->db->where('id',$result[0]['id']);
				$this->db->update('temp_attendance',array(
					'shift_attendance'=> $shift,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('ecode'),
					)
				);
			} else {
				$this->db->insert('temp_attendance',array(
					'department_id' => $dept_id,
					'ecode' => $ecode,
					'atten_date' => date("Y-m-$day", strtotime("first day of previous month")),
					'shift_attendance' => $shift,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('ecode')
				));
			}
		} else {
			$this->db->select('*');
			$result = $this->db->get_where('temp_attendance',array('department_id'=>$dept_id,'ecode'=>$ecode,'atten_date'=>date("Y-m-$day")))->result_array();
			if(count($result)>0){
				$this->db->where('id',$result[0]['id']);
				$this->db->update('temp_attendance',array(
					'shift_attendance'=> $shift,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('ecode'),
					)
				);
			} else {
				$this->db->insert('temp_attendance',array(
					'department_id' => $dept_id,
					'ecode' => $ecode,
					'atten_date' => date("Y-m-$day"),
					'shift_attendance' => $shift,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('ecode')
				));
			}
		}
		
		echo json_encode(array('status'=>200));
	}
}