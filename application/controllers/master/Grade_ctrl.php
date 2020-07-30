<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Grade_model'));
    }
	
	function index(){
		$data = array();
		$data['results'] = $this->Grade_model->get_grade();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/grade',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | Grade Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function grade($grade_id = null){
		if($grade_id == null){
			$result = $this->Grade_model->get_grade();
		} else {
			$result = $this->Grade_model->get_grade($grade_id);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Grade List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function grade_update(){
		$data['id'] = trim($this->input->post('grade_id'));
		$data['name'] = trim($this->input->post('name'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Grade_model->grade_update($data)){
			echo json_encode(array('msg'=>'Grade update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function grade_create(){
		$data['name'] = trim($this->input->post('name'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Grade_model->grade_create($data)){
			echo json_encode(array('msg'=>'Grade created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function grade_delete(){
		$data['grade_id'] = $this->input->post('grade_id');
		
		if($this->Grade_model->grade_delete($data)){
			echo json_encode(array('msg'=>'Grade deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}