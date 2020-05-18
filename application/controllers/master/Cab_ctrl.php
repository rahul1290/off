<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cab_ctrl extends CI_Controller {	

	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Cab_model','Emp_model'));
    }
	
	function index(){
		$data = array();
		$data['zones'] = $this->Cab_model->get_parent_zones();
		$data['locations'] = $this->Cab_model->get_all_location();

		$data['users'] = $this->Emp_model->get_employee($this->session->userdata('ecode'));
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['body'] = $this->load->view('pages/master/cab_zone',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | Cab Zone Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}

	function location_submit(){
		$data['location_name'] = $this->input->post('location');
		$data['parent_id'] = $this->input->post('parent');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = $this->session->userdata('ecode');
		if($this->Cab_model->location_submit($data)){
			echo json_encode(array('msg'=>'Location Submited successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}

	function location_update(){
		$id = (int)$this->input->post('id');
		$data['location_name'] = $this->input->post('location');
		$data['parent_id'] = $this->input->post('parent');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		if($this->Cab_model->location_update($data,$id)){
			echo json_encode(array('msg'=>'Location Updated successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}

	function location_delete(){
		$id = (int)$this->input->post('id');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		if($this->Cab_model->location_delete($data,$id)){
			echo json_encode(array('data'=>'Location Deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}