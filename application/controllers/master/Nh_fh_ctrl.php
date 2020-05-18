<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nh_fh_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->library('my_library');
		$this->load->model(array('Auth_model','master/Nh_fh_model'));
    }
	
	function index(){
		$data = array();
		$data['nhfhs'] = $this->Nh_fh_model->get_nhfh();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/nh_fh',$data,true);
		
		
		//===============common===============//
		$data['title'] = 'IBC24 | Department Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function nhfh($nhfh_id = null){
		if($dep_id == null){
			$result = $this->Nh_fh_model->get_nhfh();
		} else {
			$result = $this->Nh_fh_model->get_nhfh($nhfh);
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'NH/FH List.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function nhfh_update(){
		$data['id'] = trim($this->input->post('id'));
		$data['date'] = trim($this->input->post('date'));
		$data['date'] = $this->my_library->mydate($data['date']);
		$data['year'] = date('Y', strtotime($this->my_library->mydate($data['date'])));
		$data['remark'] = trim($this->input->post('remark'));
		$data['updated_by'] = $this->session->userdata('ecode');
		$data['updated_at'] = date('Y-m-d H:i:s');
		
		if($this->Nh_fh_model->nhfh_update($data)){
			echo json_encode(array('msg'=>'Department update successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function nhfh_create(){
		
		$data['nhfh_date'] = trim($this->input->post('nhfh_date'));
		$data['nhfh_date'] = $this->my_library->mydate($data['nhfh_date']);
		$data['year'] = date('Y', strtotime($data['nhfh_date']));
		$data['remark'] = trim($this->input->post('remark'));
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('ecode');
		
		if($this->Nh_fh_model->nhfh_create($data)){
			echo json_encode(array('msg'=>'NH/FH created successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function nhfh_delete(){
		$data['id'] = $this->input->post('nhfh_id');
		
		if($this->Nh_fh_model->nhfh_delete($data)){
			echo json_encode(array('msg'=>'NH/FH deleted successfully.','status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
}