<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cab_ctrl extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model(array('Auth_model','master/Department_model','Emp_model','Cab_model'));
        $this->is_login();
    }
    
    function is_login(){
        if(!$this->session->userdata('ecode')){
            redirect('Auth');
        }
    }
    
    public function valid_number($str){
        $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
        return FALSE;
    }
    
    function index(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date', 'To Date', 'required');
            $this->form_validation->set_rules('pickdrop','Pick-Drop','required');
            $this->form_validation->set_rules('time','Time','required|is_natural_no_zero',array('is_natural_no_zero' => 'Please select {field}'));
            $this->form_validation->set_rules('zone','Zone','required|is_natural_no_zero',array('is_natural_no_zero' => 'Please select {field}'));
            $this->form_validation->set_rules('location','Location','required|is_natural_no_zero',array('is_natural_no_zero' => 'Please select {field}'));
            $this->form_validation->set_rules('address','Address','required');
            
            $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
            if ($this->form_validation->run() == FALSE) {
                $data = array();
                $data['cab_requests'] = $this->Cab_model->cab_requests($this->session->userdata('ecode'));
                $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
                
                if($this->input->post('pickdrop')){
                    $parems['type'] = $this->input->post('pickdrop');
                    $result = $this->Cab_model->cab_timing($parems);
                    $data['cabTime'] = $result;
                }
                
                
                ///fetch cab zone
                $result = $this->Cab_model->cab_zone();
                $data['cabZone'] = $result;
                
                
                if($this->input->post('zone')){
                    $parems['zone'] = $this->input->post('zone');
                    $result = $this->Cab_model->get_location($parems);
                    $data['cabLocation'] = $result;
                }
                
                $data['footer'] = $this->load->view('include/footer','',true);
                $data['top_nav'] = $this->load->view('include/top_nav','',true);
                $data['aside'] = $this->load->view('include/aside',$data,true);
                $data['notepad'] = $this->load->view('include/shift_timing','',true);
                $data['body'] = $this->load->view('pages/cab/cab',$data,true);
                //===============common===============//
                $data['title'] = $this->config->item('project_title').' | Cab';
                $data['head'] = $this->load->view('common/head',$data,true);
                $data['footer'] = $this->load->view('common/footer',$data,true);
                $this->load->view('layout_master',$data);
            } else {
                $count = $this->Cab_model->cabrequest_count();
                $x = (int)$count[0]['total'] + 1;
                
                $insert_data['ecode'] = $this->session->userdata('ecode');
                $insert_data['request_date'] = date('Y-m-d H:i:s');
                $insert_data['from_date'] = date('Y-m-d',strtotime($this->input->post('from_date')));
                $insert_data['to_date'] = date('Y-m-d',strtotime($this->input->post('to_date')));
                $insert_data['type'] = $this->input->post('pickdrop');
                $insert_data['time'] = $this->input->post('time');
                $insert_data['area'] = $this->input->post('zone');
                $insert_data['address'] = $this->input->post('address');
                $insert_data['reqest_id'] = 'IBC24/'.date('Y').'/'.$this->my_library->department_code($this->session->userdata('ecode')).'/'.$x;
                $insert_data['cab_status'] = 'REJECTED';
                
                $this->Cab_model->cab_request_submit($insert_data);
                $this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your Cab request submitted successfully.</h3>');
                redirect('es/cab','refresh');
            }
        } else {
            $data = array();
            $data['cab_requests'] = $this->Cab_model->cab_requests($this->session->userdata('ecode'));
            
            $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
            $data['footer'] = $this->load->view('include/footer','',true);
            $data['top_nav'] = $this->load->view('include/top_nav','',true);
            $data['aside'] = $this->load->view('include/aside',$data,true);
            $data['notepad'] = $this->load->view('include/shift_timing','',true);
            $data['body'] = $this->load->view('pages/cab/cab',$data,true);
            //===============common===============//
            $data['title'] = $this->config->item('project_title').' | Cab';
            $data['head'] = $this->load->view('common/head',$data,true);
            $data['footer'] = $this->load->view('common/footer',$data,true);
            $this->load->view('layout_master',$data);
        }
    }
    
    
    
    //////////////////////ajax calls////////////////////////////////
    function cab_timing(){
        $data['type'] = $this->input->post('method');
        $result = $this->Cab_model->cab_timing($data);
        
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'msg'=>'Cab timing list.','status'=>200));
        } else {
            echo json_encode(array('data'=>$result,'msg'=>'No record found.','status'=>500));
        }
    }
    
    function cab_zone(){
        $result = $this->Cab_model->cab_zone();
        
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'msg'=>'cab zone list.','status'=>200));
        } else{
            echo json_encode(array('msg'=>'No record found.','status'=>500));
        }
    }
    
    function get_location(){
        $data['zone'] = $this->input->post('zone');
        $result = $this->Cab_model->get_location($data);
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'msg'=>'zone location list.','status'=>200));
        } else {
            echo json_encode(array('msg'=>'No record found.','status'=>500));
        }
    }
}