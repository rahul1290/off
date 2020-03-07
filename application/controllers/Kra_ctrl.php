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

	function index($session,$ecode){
	    if($_SERVER['REQUEST_METHOD'] === 'POST'){
	        $this->form_validation->set_rules('session', 'Session', 'required');
	        $this->form_validation->set_rules('key_result_area1','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_result_area2','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_result_area3','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_result_area4','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_result_area5','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_result_area6','Key Result Area','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator1','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator2','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator3','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator4','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator5','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('key_performance_indicator6','key performance Indicator','trim|required');
	        $this->form_validation->set_rules('weightage1','Weightage','trim|required');
	        $this->form_validation->set_rules('weightage2','Weightage','trim|required');
	        $this->form_validation->set_rules('weightage3','Weightage','trim|required');
	        $this->form_validation->set_rules('weightage4','Weightage','trim|required');
	        $this->form_validation->set_rules('weightage5','Weightage','trim|required');
	        $this->form_validation->set_rules('weightage6','Weightage','trim|required');
	        $this->form_validation->set_rules('target1','Target','trim|required');
	        $this->form_validation->set_rules('target2','Target','trim|required');
	        $this->form_validation->set_rules('target3','Target','trim|required');
	        $this->form_validation->set_rules('target4','Target','trim|required');
	        $this->form_validation->set_rules('target5','Target','trim|required');
	        $this->form_validation->set_rules('target6','Target','trim|required');
	        $this->form_validation->set_rules('acheived1','Acheived','trim|required');
	        $this->form_validation->set_rules('acheived2','Acheived','trim|required');
	        $this->form_validation->set_rules('acheived3','Acheived','trim|required');
	        $this->form_validation->set_rules('acheived4','Acheived','trim|required');
	        $this->form_validation->set_rules('acheived5','Acheived','trim|required');
	        $this->form_validation->set_rules('acheived6','Acheived','trim|required');
	        $this->form_validation->set_rules('weighted_score1','Weighted score','trim|required');
	        $this->form_validation->set_rules('weighted_score2','Weighted score','trim|required');
	        $this->form_validation->set_rules('weighted_score3','Weighted score','trim|required');
	        $this->form_validation->set_rules('weighted_score4','Weighted score','trim|required');
	        $this->form_validation->set_rules('weighted_score5','Weighted score','trim|required');
	        $this->form_validation->set_rules('weighted_score6','Weighted score','trim|required');
	        $this->form_validation->set_rules('appraisel_cmt','Appraisal comment','trim|required');
	        $this->form_validation->set_rules('develop_need1','Development Need','trim|required');
	        $this->form_validation->set_rules('develop_need2','Development Need','trim|required');
	        $this->form_validation->set_rules('develop_plan','Development Plan','trim|required');
	        
	        
	        $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
	        if ($this->form_validation->run() == FALSE){
	            $data = array();
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
	        } else {
	            $session_id = $this->input->post('session');
	            $ecode = $ecode;
	            $data['key_result_area1'] = $this->input->post('key_result_area1');
	            $data['key_result_area2'] = $this->input->post('key_result_area2');
	            $data['key_result_area3'] = $this->input->post('key_result_area3');
	            $data['key_result_area4'] = $this->input->post('key_result_area4');
	            $data['key_result_area5'] = $this->input->post('key_result_area5');
	            $data['key_result_area6'] = $this->input->post('key_result_area6');
	            $data['key_performance_indicator1'] = $this->input->post('key_performance_indicator1');
	            $data['key_performance_indicator2'] = $this->input->post('key_performance_indicator2');
	            $data['key_performance_indicator3'] = $this->input->post('key_performance_indicator3');
	            $data['key_performance_indicator4'] = $this->input->post('key_performance_indicator4');
	            $data['key_performance_indicator5'] = $this->input->post('key_performance_indicator5');
	            $data['key_performance_indicator6'] = $this->input->post('key_performance_indicator6');
	            $data['weightage1'] = $this->input->post('key_performance_indicator1');
	            $data['weightage2'] = $this->input->post('key_performance_indicator2');
	            $data['weightage3'] = $this->input->post('key_performance_indicator3');
	            $data['weightage4'] = $this->input->post('key_performance_indicator4');
	            $data['weightage5'] = $this->input->post('key_performance_indicator5');
	            $data['weightage6'] = $this->input->post('key_performance_indicator6');
	            $data['target1'] = $this->input->post('target1');
	            $data['target2'] = $this->input->post('target2');
	            $data['target3'] = $this->input->post('target3');
	            $data['target4'] = $this->input->post('target4');
	            $data['target5'] = $this->input->post('target5');
	            $data['target6'] = $this->input->post('target6');
	            $data['acheived1'] = $this->input->post('acheived1');
	            $data['acheived2'] = $this->input->post('acheived2');
	            $data['acheived3'] = $this->input->post('acheived3');
	            $data['acheived4'] = $this->input->post('acheived4');
	            $data['acheived5'] = $this->input->post('acheived5');
	            $data['acheived6'] = $this->input->post('acheived6');
	            $data['weighted_score1'] = $this->input->post('weighted_score1');
	            $data['weighted_score2'] = $this->input->post('weighted_score2');
	            $data['weighted_score3'] = $this->input->post('weighted_score3');
	            $data['weighted_score4'] = $this->input->post('weighted_score4');
	            $data['weighted_score5'] = $this->input->post('weighted_score5');
	            $data['weighted_score6'] = $this->input->post('weighted_score6');
	            $data['appraisee_comments'] = $this->input->post('appraisel_cmt');
	            $data['develop_need1'] = $this->input->post('develop_need1');
	            $data['develop_need2'] = $this->input->post('develop_need2');
	            $data['develop_plan'] = $this->input->post('develop_plan');
	            $this->Kra_model->kra_submit($data,$session_id,$ecode);
	        }
	    } else {
    		$data = array();
    		$this->db->select('*');
    		$data['session'] = $this->db->get_where('session',array('status'=>1))->result_array();
    		
    		$this->db->select('s_id');
    		$session = $this->db->get_where('session',array('name'=>$session,'status'=>1))->result_array();
    		$this->Kra_model->set_detail($ecode);
    		$data['user_detail'] = $this->Kra_model->get_detail($ecode);
    		$data['kra_feeds'] = $this->Kra_model->kra_feed($ecode,$session[0]['s_id']);
    		
    		$data['title'] = $this->config->item('project_title').' |KRA';
    		$data['head'] = $this->load->view('common/head',$data,true);
    		$data['footer'] = $this->load->view('common/footer',$data,true);
    		$this->load->view('pages/es/kra',$data);
	    }
	}
	
}