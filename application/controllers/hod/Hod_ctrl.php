
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hod_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','hod/Hod_model'));
		$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}

	function leave_request($ref_id = null){
	    
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
	    //$data['open'] = 'true';
	    $data['notepad'] = $this->load->view('include/shift_timing','',true);
	    $data['pending_requests'] = $this->Hod_model->leave_pending_request($ulist,$ref_id);
	    
	    $data['requests'] = $this->Hod_model->leave_request($ulist,$ref_id);
	    $data['body'] = $this->load->view('pages/hod/leave_requests',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | Leave Requests';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	   
	    $this->load->view('layout_master',$data);
	}
	
	function leave_request_update(){
	    $data['req_id'] = $this->input->post('req_id');
	    $data['key'] = $this->input->post('key');
	    $data['value'] = $this->input->post('value');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    $data['hod_id'] = $this->session->userdata('ecode');
	    if($this->Hod_model->leave_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
	
	///HALF DAY REQUEST
	function hf_leave_request($ref_id = null){		
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
		//$data['open'] = 'true';
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['pending_requests'] = $this->Hod_model->hf_leave_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hod_model->hf_leave_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hod/hf_leave_requests',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | HF Day Leave Requests';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		
		$this->load->view('layout_master',$data);
	}

	function hf_leave_request_update(){
		$data['req_id'] = $this->input->post('req_id');
		$data['key'] = $this->input->post('key');
		$data['value'] = $this->input->post('value');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['hod_id'] = $this->session->userdata('ecode');
		if($this->Hod_model->hf_leave_request_update($data)){
			echo json_encode(array('status'=>200));
		}
	}
	
	///OFF DAY DUTY REQUEST
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
		$data['pending_requests'] = $this->Hod_model->off_day_duty_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hod_model->off_day_duty_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hod/off_day_duty_request',$data,true);
		
		$data['title'] = $this->config->item('project_title').' | OFF Day Duty Requests';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	///NH FH DAY DUTY REQUEST
	function nh_fh_day_duty_request($ref_id = null){		
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
		$data['pending_requests'] = $this->Hod_model->nh_fh_day_duty_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hod_model->nh_fh_day_duty_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hod/nh_fh_day_duty_request',$data,true);
		
		$data['title'] = $this->config->item('project_title').' | OFF Day Duty Requests';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	
	
	
	
	
	
	
	
	
}