<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','Hr_model'));
    }
	
	function roster(){
		
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$config['upload_path']          = './assets/';
			$config['allowed_types']        = 'gif|jpg|png|xlsx';
			// $config['max_size']             = 100;
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error); die;
			}
			else{
				$data = array('upload_data' => $this->upload->data());
				
				$file = $data['upload_data']['full_path'];
				
				$nodays = date("t", mktime(0,0,0, date("n") - 1));
				$month = date("m", strtotime("first day of previous month"));
				
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					
					$nofdays = date("t", mktime(0,0,0, date("n") - 1)); 
					$insertdata = array();
					for($row=2; $row <= $highestRow; $row++){
						$col = 1;
						$paycode = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
						
						for($i=1;$i<=$nodays;$i++){
							$temp = array();
							$temp['paycode'] = $paycode;
							// $temp['DateOFFICE'] = date("Y-$month-$i");
							// $temp['SHIFTATTENDED'] = $worksheet->getCellByColumnAndRow($i+2, $row)->getValue();
							
							$this->db->where(array('PAYCODE'=>$paycode,'DateOFFICE'=>date("Y-$month-$i")));
							$this->db->update('saviour',array(
								'SHIFTATTENDED' => $worksheet->getCellByColumnAndRow($i+2, $row)->getValue()
							));
						}
					}
				}
				
				$this->session->set_flashdata('msg', '<p class="bg-success text-center">Roaster uploaded successfully.</p>');
				$data = array();
				$data['footer'] = $this->load->view('include/footer','',true);
				$data['top_nav'] = $this->load->view('include/top_nav','',true);
				$data['aside'] = $this->load->view('include/aside','',true);
				//$data['notepad'] = $this->load->view('include/notepad','',true);
				$data['body'] = $this->load->view('pages/hradmin/roaster',$data,true);
				//===============common===============//
				$data['title'] = 'Home | Emp-Portal';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
			}
		} else {
			$data = array();
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside','',true);
			//$data['notepad'] = $this->load->view('include/notepad','',true);
			$data['body'] = $this->load->view('pages/hradmin/roaster',$data,true);
			//===============common===============//
			$data['title'] = 'Home | Emp-Portal';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function hr_policies(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		//$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/hr_policies',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function emp_info(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function salary_slip(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function holiday_list(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}

	function it_policies(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		//$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/it_policies',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	////////////////////////////////LEAVE Requests
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
	    $data['notepad'] = $this->load->view('include/shift_timing','',true);
	    $data['pending_requests'] = $this->Hr_model->leave_pending_request($ulist,$ref_id);
	    $data['requests'] = $this->Hr_model->hf_leave_request($ulist,$ref_id);
	    $data['body'] = $this->load->view('pages/hradmin/leave_requests',$data,true);
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
	    $data['hr_id']	= $this->session->userdata('ecode');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    if($this->Hr_model->leave_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
	
	////////////////////////////////HALF day requests
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
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['pending_requests'] = $this->Hr_model->hf_leave_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hr_model->hf_leave_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hradmin/hf_leave_requests',$data,true);
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
	    $data['hr_id']	= $this->session->userdata('ecode');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    if($this->Hr_model->hf_leave_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
	
	//////////////////////////off day duty 
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
		$data['pending_requests'] = $this->Hr_model->off_day_duty_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hr_model->off_day_duty_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hradmin/off_day_duty_request',$data,true);
		
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
		$data['pending_requests'] = $this->Hr_model->nh_fh_day_duty_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hr_model->nh_fh_day_duty_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hradmin/nh_fh_day_duty_request',$data,true);
		
		$data['title'] = $this->config->item('project_title').' | OFF Day Duty Requests';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
}