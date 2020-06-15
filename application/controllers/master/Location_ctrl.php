<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Location_model'));
    }
	
	function index(){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/location',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | EmpCode Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function location($location_id = null){
		if($location_id == null){
			$result = $this->Location_model->get_location();
		} else {
			$result = $this->Location_model->get_location($location_id);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Location List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function location_update(){
		$data['id'] = trim($this->input->post('location_id'));
		$data['name'] = trim($this->input->post('name'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Location_model->location_update($data)){
			echo json_encode(array('msg'=>'Location update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function location_create(){
		$data['name'] = trim($this->input->post('name'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Location_model->location_create($data)){
			echo json_encode(array('msg'=>'Location created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function location_delete(){
		$data['id'] = $this->input->post('location_id');
		
		if($this->Location_model->location_delete($data)){
			echo json_encode(array('msg'=>'Location deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}