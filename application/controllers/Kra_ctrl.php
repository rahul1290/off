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

	function index($session=null,$ecode=null){
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
	        $this->form_validation->set_rules('weightage1','Weightage','trim');
	        $this->form_validation->set_rules('weightage2','Weightage','trim');
	        $this->form_validation->set_rules('weightage3','Weightage','trim');
	        $this->form_validation->set_rules('weightage4','Weightage','trim');
	        $this->form_validation->set_rules('weightage5','Weightage','trim');
	        $this->form_validation->set_rules('weightage6','Weightage','trim');
	        $this->form_validation->set_rules('target1','Target','trim');
	        $this->form_validation->set_rules('target2','Target','trim');
	        $this->form_validation->set_rules('target3','Target','trim');
	        $this->form_validation->set_rules('target4','Target','trim');
	        $this->form_validation->set_rules('target5','Target','trim');
	        $this->form_validation->set_rules('target6','Target','trim');
	        $this->form_validation->set_rules('acheived1','Acheived','trim');
	        $this->form_validation->set_rules('acheived2','Acheived','trim');
	        $this->form_validation->set_rules('acheived3','Acheived','trim');
	        $this->form_validation->set_rules('acheived4','Acheived','trim');
	        $this->form_validation->set_rules('acheived5','Acheived','trim');
	        $this->form_validation->set_rules('acheived6','Acheived','trim');
	        $this->form_validation->set_rules('weighted_score1','Weighted score','trim');
	        $this->form_validation->set_rules('weighted_score2','Weighted score','trim');
	        $this->form_validation->set_rules('weighted_score3','Weighted score','trim');
	        $this->form_validation->set_rules('weighted_score4','Weighted score','trim');
	        $this->form_validation->set_rules('weighted_score5','Weighted score','trim');
	        $this->form_validation->set_rules('weighted_score6','Weighted score','trim');
	        $this->form_validation->set_rules('appraisel_cmt','Appraisal comment','trim');
	        $this->form_validation->set_rules('develop_need1','Development Need','trim');
	        $this->form_validation->set_rules('develop_need2','Development Need','trim');
	        $this->form_validation->set_rules('develop_plan','Development Plan','trim');
	        
	        
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
	            $data['weightage1'] = $this->input->post('weightage1');
	            $data['weightage2'] = $this->input->post('weightage2');
	            $data['weightage3'] = $this->input->post('weightage3');
	            $data['weightage4'] = $this->input->post('weightage4');
	            $data['weightage5'] = $this->input->post('weightage5');
	            $data['weightage6'] = $this->input->post('weightage6');
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
				
				
				$data = array();
				$this->session->set_flashdata('msg', '<h3 class="text-center bg-success">KRA Updated successfully.</h3>');
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
	    } else {
			if($ecode == null){
				$ecode = $session;
				$session = '2018-19';
			}
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
	
	
	
	
	function hod_dashboard($ecode,$session_id=null){
	    if($session_id == null){
	        $session_id = $this->my_library->get_current_session();
	    }
	    $data = array();
	    $this->db->select('*');
	    $data['session'] = $this->db->get_where('session',array('status'=>1))->result_array();
	    
	    $this->db->select('s_id');
	    $session = $this->db->get_where('session',array('name'=>$session_id,'status'=>1))->result_array();
	    
	    $data['pending_employees'] = $this->Kra_model->get_employee_list($ecode,$session_id,0);
	    $data['employees'] = $this->Kra_model->get_employee_list($ecode,$session_id,1);
	    
	    $data['user_detail'] = $this->Kra_model->get_detail($ecode);
	    $data['kra_feeds'] = $this->Kra_model->kra_feed($ecode,$session[0]['s_id']);
	    
	    $data['title'] = $this->config->item('project_title').' |HOD KRA';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('pages/hod/kra',$data);
	}
	
	function employee_detail($session_id,$ecode){
	    $data = array();
	    $this->db->select('*');
	    $data['session'] = $this->db->get_where('session',array('status'=>1))->result_array();
	    
	    $this->db->select('s_id');
	    $session = $this->db->get_where('session',array('name'=>$session_id,'status'=>1))->result_array();
	    
	    $data['pending_employees'] = $this->Kra_model->get_employee_list($ecode,$session_id,0);
	    $data['employees'] = $this->Kra_model->get_employee_list($ecode,$session_id,1);
	    
	    $data['user_detail'] = $this->Kra_model->get_detail($ecode);
	    $data['kra_feeds'] = $this->Kra_model->kra_feed($ecode,$session[0]['s_id']);
	    
	    $data['title'] = $this->config->item('project_title').' |HOD KRA';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('pages/hod/employee_detail_kra',$data);
	}
	
	function appraiser_score($hod,$session,$ecode){
	    $other['hod'] = $hod;
	    $other['session'] = $session;
	    $other['ecode'] = $ecode;
	    $data['appraiser_score1_hod'] = $this->input->post('appraiser_score1');
	    $data['appraiser_score2_hod'] = $this->input->post('appraiser_score2');
	    $data['appraiser_score3_hod'] = $this->input->post('appraiser_score3');
	    $data['appraiser_score4_hod'] = $this->input->post('appraiser_score4');
	    $data['appraiser_score5_hod'] = $this->input->post('appraiser_score5');
	    $data['appraiser_score6_hod'] = $this->input->post('appraiser_score6');
	    $data['appraiser_comment_hod'] = $this->input->post('appraiser_score_comment');
	    $data['hod_status'] = date('Y-m-d H:i:s');
	    
	    $this->Kra_model->appraiser_score($data,$other);
	    redirect('/HOD/'.$hod.'/KRA/'.$session.'/'.$ecode);
	}
	
}