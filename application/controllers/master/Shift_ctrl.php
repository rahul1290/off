<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model'));
    }
	
	function index(){
		$data = array();
		
		$data['departments'] = $this->Department_model->get_department();
		
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/shift',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | Grade Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function get_attendance($ecode){
		$this->db->select('*');
		$result = $this->db->get_where('temp_attendance',array('ecode'=>$ecode))->result_array();
		
		$nodays = date("t", mktime(0,0,0, date("n") - 1));
		$month = date("m", strtotime("first day of previous month"));
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'month'=>$month,'days'=>$nodays,'status'=>200));
		} else {
			echo json_encode(array('month'=>$month,'days'=>$nodays,'status'=>500));
		}
	}
}