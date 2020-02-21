<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model'));
    }
	
	function index(){
		$data = array();
		$data['results'] = $this->Department_model->get_department();
		
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/department',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | Department Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function department($dep_id = null){
		if($dep_id == null){
			$result = $this->Department_model->get_department();
		} else {
			$result = $this->Department_model->get_department($dep_id);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Department List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function department_update(){
		$data['id'] = trim($this->input->post('dept_id'));
		$data['name'] = trim($this->input->post('name'));
		$data['code'] = trim($this->input->post('code'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Department_model->department_update($data)){
			echo json_encode(array('msg'=>'Department update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function department_create(){
		$data['name'] = trim($this->input->post('name'));
		$data['code'] = trim($this->input->post('code'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Department_model->department_create($data)){
			echo json_encode(array('msg'=>'Department created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function department_delete(){
		$data['dep_id'] = $this->input->post('dept_id');
		
		if($this->Department_model->department_delete($data)){
			echo json_encode(array('msg'=>'Department deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function department_employees($dept){
		$result = $this->Department_model->department_employees($dept);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}