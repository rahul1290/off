<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off_day_duty_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','hr/Off_day_duty_model','hr/Hf_leave_model'));
		$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}
	
	function off_day_duty_request($ref_id = null){
	    $data = array();
	    $data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
	    
	    $users = $this->Emp_model->get_employee($this->session->userdata('ecode'));
	    $ulist = '';
	    foreach($users as $user) {
	        $ulist = $ulist.",'".$user['ecode']."'";
	    }
	    $ulist = ltrim($ulist,',');
	    
	    $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	    $data['footer'] = $this->load->view('include/footer','',true);
	    $data['top_nav'] = $this->load->view('include/top_nav','',true);
	    $data['aside'] = $this->load->view('include/aside',$data,true);
	    $data['notepad'] = $this->load->view('include/shift_timing','',true);
	    $data['pending_requests'] = $this->Off_day_duty_model->total_off_day_duty_pending_request();
	    
	    $data['body'] = $this->load->view('pages/hradmin/off_day_duty_request',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | HF Day Leave Requests';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('layout_master',$data);
	}
	
	function off_day_duty_request_update(){
	    $data['req_id'] = $this->input->post('req_id');
	    $data['key'] = $this->input->post('key');
	    $data['value'] = $this->input->post('value');
	    $data['hr_id']	= $this->session->userdata('ecode');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    if($this->Off_day_duty_model->off_day_duty_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
	
	function off_day_duty_request_submit(){
	    $data = array();
	    $data['application_no'] = $this->input->post('application_no');
	    $data['pl_deduction'] = $this->input->post('pl_deduction');
	    $data['hr_remark'] = $this->input->post('hr_remark');
	    if($this->Off_day_duty_model->off_day_duty_request_submit($data)){
	        redirect(base_url().'hr/off-day-duty-request','refresh');
	    }
	}
	
	
	function request_list(){
	    $data['dept_id'] = $this->input->post('dept_id');
	    $results = $this->Off_day_duty_model->request_list($data);
	    if(count($results)>0){
	        $final_array = array();
	        foreach($results as $result){
	            $temp = array();
	            $temp['reference_id'] = $this->my_library->remove_hyphen($result['reference_id']);
	            $temp['dept_name'] = $result['dept_name'];
	            $temp['name'] = $result['name'];
	            $temp['ecode'] = $result['ecode'];
	            $temp['date_from'] = date('d/m/Y',strtotime($result['date_from']));
	            $temp['hod_remark'] = $result['hod_remark'];
	            $final_array[] = $temp;
	        }
	        echo json_encode(array('data'=>$final_array,'msg'=>'requests list.','status'=>200));
	    } else {
	        echo json_encode(array('msg'=>'requests list.','status'=>500));
	    }
	}
}