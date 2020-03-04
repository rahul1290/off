<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_ctrl extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model(array('Auth_model','output/Output_model'));
	}

	function index(){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		
		//$data['open'] = 'true';
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/output/broadcast',$data,true);
		//===============common===============//
		$data['title'] =  $this->config->item('project_title').'| Broadcast Output';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function get_files(){
		$data['date'] = $this->my_library->mydate($this->input->post('date'));
		$data['sloat'] = $this->input->post('sloat');
		
		$sloat = '';
		switch($data['sloat']){
			case "1":  
				$sloat = '00:00';
				break;
			case "2": 
				$sloat = '30:00';
				break;
			case "3": 
				$sloat = '01:00';
				break;
			case "4": 
				$sloat = '01:30';
				break;
			case "5": 
				$sloat = '02:00';
				break;
			case "6": 
				$sloat = '02:30';
				break;
			case "7": 
				$sloat = '03:00';
				break;
			case "8": 
				$sloat = '03:30';
				break;
			case "9": 
				$sloat = '04:00';
				break;
			case "10": 
				$sloat = '04:30';
				break;
			case "11": 
				$sloat = '05:00';
				break;
			case "12": 
				$sloat = '05:30';
				break;
			case "13": 
				$sloat = '06:00';
				break;
			case "14": 
				$sloat = '06:30';
				break;
			case "15": 
				$sloat = '07:00';
				break;
			case "16": 
				$sloat = '07:30';
				break;
			case "17": 
				$sloat = '08:00';
				break;
			case "18": 
				$sloat = '08:30';
				break;
			case "19": 
				$sloat = '09:00';
				break;
			case "20": 
				$sloat = '09:30';
				break;
			case "21": 
				$sloat = '10:00';
				break;
			case "22": 
				$sloat = '10:30';
				break;
			case "23": 
				$sloat = '11:00';
				break;
			case "24": 
				$sloat = '11:30';
				break;
			case "25": 
				$sloat = '12:00';
				break;
			case "26": 
				$sloat = '12:30';
				break;
			case "27": 
				$sloat = '13:00';
				break;
			case "28": 
				$sloat = '13:30';
				break;
			case "29": 
				$sloat = '14:00';
				break;
			case "30": 
				$sloat = '14:30';
				break;
			case "31": 
				$sloat = '15:00';
				break;
			case "32": 
				$sloat = '15:30';
				break;
			case "33": 
				$sloat = '16:00';
				break;
			case "34": 
				$sloat = '16:30';
				break;
			case "35": 
				$sloat = '17:00';
				break;
			case "36": 
				$sloat = '17:30';
				break;
			case "37": 
				$sloat = '18:00';
				break;
			case "38": 
				$sloat = '18:30';
				break;
			case "39": 
				$sloat = '19:00';
				break;
			case "40": 
				$sloat = '19:30';
				break;
			case "41": 
				$sloat = '20:00';
				break;
			case "42": 
				$sloat = '20:30';
				break;
			case "43": 
				$sloat = '21:00';
				break;
			case "44": 
				$sloat = '21:30';
				break;
			case "45": 
				$sloat = '22:00';
				break;
			case "46": 
				$sloat = '22:30';
				break;
			case "47": 
				$sloat = '23:00';
				break;
			case "48": 
				$sloat = '23:30';
				break;
		}
		$data['time'] = $sloat;
		$result = $this->Output_model->get_files($data);
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		} else {
			echo json_encode(array('msg'=>'No record Found.','status'=>500));
		}
	}
}