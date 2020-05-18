<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empcode_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Empcode_model'));
    }
	
	function index(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/empcode',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | EmpCode Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function empcode($empcode_id = null){
		if($empcode_id == null){
			$result = $this->Empcode_model->get_empcode();
		} else {
			$result = $this->Empcode_model->get_empcode($empcode_id);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Empcode List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function empcode_update(){
		$data['id'] = trim($this->input->post('empcode_id'));
		$data['name'] = trim($this->input->post('name'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Empcode_model->empcode_update($data)){
			echo json_encode(array('msg'=>'Empcode update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function empcode_create(){
		$data['name'] = trim($this->input->post('name'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Empcode_model->empcode_create($data)){
			echo json_encode(array('msg'=>'Empcode created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function empcode_delete(){
		$data['id'] = $this->input->post('empcode_id');
		
		if($this->Empcode_model->empcode_delete($data)){
			echo json_encode(array('msg'=>'Empcode deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}