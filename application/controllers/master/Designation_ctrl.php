<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designation_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Designation_model'));
    }
	
	function index(){
		$data = array();
		$data['results'] = $this->Designation_model->get_designation();
		
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/designation',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | Designation Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function designation($dep_id = null){
		if($dep_id == null){
			$result = $this->Designation_model->get_designation();
		} else {
			$result = $this->Designation_model->get_designation($dep_id);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Department List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function designation_update(){
		$data['id'] = trim($this->input->post('desg_id'));
		$data['name'] = trim($this->input->post('name'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Designation_model->designation_update($data)){
			echo json_encode(array('msg'=>'Designation update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function designation_create(){
		$data['name'] = trim($this->input->post('name'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Designation_model->designation_create($data)){
			echo json_encode(array('msg'=>'Designation created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function designation_delete(){
		$data['desg_id'] = $this->input->post('desg_id');
		
		if($this->Designation_model->designation_delete($data)){
			echo json_encode(array('msg'=>'Designation deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}