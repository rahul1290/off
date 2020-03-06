<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kra_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Kra_model'));
		//$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}

	function index($ecode){
		$data = array();
		//$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		//$data['footer'] = $this->load->view('include/footer','',true);
		//$data['top_nav'] = $this->load->view('include/top_nav','',true);
		//$data['aside'] = $this->load->view('include/aside',$data,true);
		//$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$this->db->select('*');
		$data['session'] = $this->db->get_where('session',array('status'=>1))->result_array();
		
		$this->db->select('s_id');
		$session = $this->db->get_where('session',array('is_active'=>'curr','status'=>1))->result_array();
		$this->Kra_model->set_detail($ecode);
		$data['user_detail'] = $this->Kra_model->get_detail($ecode);
		$data['kra_feeds'] = $this->Kra_model->kra_feed($ecode,$session[0]['s_id']);
		
		$data['title'] = $this->config->item('project_title').' |KRA';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('pages/es/kra',$data);
	}
}