<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hf_leave_ctrl extends CI_Controller {	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','hod/Hod_model','hod/Hf_leave_model'));
		$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}
	
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
	    $data['body'] = $this->load->view('pages/hod/hf_leave_requests',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | Leave Requests';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    
	    $this->load->view('layout_master',$data);
	}
	
	
	function hf_request_ajax($page=0,$str=''){
	    $config = array();
	    
	    $data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
	    $users = $this->Emp_model->get_employee($this->session->userdata('ecode'));
	    $ulist = '';
	    foreach($users as $user) {
	        $ulist = $ulist.",'".$user['ecode']."'";
	    }
	    $ulist = ltrim($ulist,',');
	    
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Hf_leave_model->total_hf_requests($ulist,$str);
	    $config["per_page"] = $this->config->item('row_count');
	    $config["uri_segment"] = $page;
	    $config['attributes'] = array('class' => 'page-link myLinks');
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item">';
	    $config['last_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item">';
	    $config['first_tag_close'] = '</li>';
	    $this->pagination->initialize($config);
	    
	    $data["links"] = $this->pagination->create_links();
	    $records = $this->Hf_leave_model->hf_leave_request($ulist,$str,$config["per_page"],$page);
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['reference_id'] = $this->my_library->remove_hyphen($record['reference_id']);
	            $temp['dept_name'] = $record['dept_name'];
	            $temp['emp_name'] = $record['name'];
	            $temp['created_at'] = $record['created_at'];
	            $temp['ecode'] = $record['ecode'];
	            $temp['date_from'] = $record['date'];
	            $temp['requirment'] = $record['requirment'];
	            $temp['hod_remark'] = ($record['hod_remark'])?$record['hod_remark']:'';
	            $temp['hod_id'] = $record['hod_id'];
	            $temp['hod_status'] = $record['hod_status'];
	            $temp['hod_remark_date'] = $record['hod_remark_date'];
	            $temp['wod'] = $record['wod'];
	            $temp['request_id'] = $record['request_id'];
	            $temp['status'] = $record['status'];
	            
	            $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
	}
	
	
	function hf_pending_request_ajax($page=0,$str=''){
	    $config = array();
	    
	    $data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
	    $users = $this->Emp_model->get_employee($this->session->userdata('ecode'));
	    $ulist = '';
	    foreach($users as $user) {
	        $ulist = $ulist.",'".$user['ecode']."'";
	    }
	    $ulist = ltrim($ulist,',');
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Hf_leave_model->total_pending_hf_requests($ulist,$str);
	    $config["per_page"] = $this->config->item('row_count');
	    $config["uri_segment"] = $page;
	    $config['attributes'] = array('class' => 'page-link myLinks1');
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item">';
	    $config['last_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item">';
	    $config['first_tag_close'] = '</li>';
	    $this->pagination->initialize($config);
	    
	    $data["links"] = $this->pagination->create_links();
	    $records = $this->Hf_leave_model->pending_hf_requests($ulist,$str,$config["per_page"],$page);
	    
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['reference_id'] = $this->my_library->remove_hyphen($record['reference_id']);
	            $temp['dept_name'] = $record['dept_name'];
	            $temp['emp_name'] = $record['name'];
	            $temp['created_at'] = $record['created_at'];
	            $temp['ecode'] = $record['ecode'];
	            $temp['date_from'] = $record['date'];
	            $temp['requirment'] = $record['requirment'];
	            $temp['hod_remark'] = ($record['hod_remark'])?$record['hod_remark']:'';
	            $temp['hod_id'] = $record['hod_id'];
	            $temp['hod_remark_date'] = $record['hod_remark_date'];
	            $temp['wod'] = $record['wod'];
	            $temp['request_id'] = $record['request_id'];
	            $temp['status'] = $record['status'];
	            
	            $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
	}
	
	function hf_leave_request_update(){
	    $data['req_id'] = $this->input->post('req_id');
	    $data['hod_status'] = $this->input->post('hod_status');
	    $data['hod_remark'] = $this->input->post('hod_remark');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    if($data['hod_status'] == 'GRANTED'){
	        $data['hr_status'] = 'PENDING';
	        $data['request_status_code'] = 2;
	    } else {
	        $data['request_status_code'] = 4;
	    }
	    $data['hod_id'] = $this->session->userdata('ecode');
	    if($this->Hf_leave_model->hf_leave_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
}