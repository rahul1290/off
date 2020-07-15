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
                
                
                $insert_data = array();
                
                $diff = date_diff(date_create(date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('from_date'))))),date_create(date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('to_date'))))));
                $x = $diff->format("%a") + 1;
                
                $from_Date = date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('from_date'))));
                for($i=0;$i<$x;$i++){
                    $temp = array();
                    $from_Date = date('Y-m-d',strtotime(date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('from_date')))).'+'.$i.' day'));
                    $temp['ecode'] = $this->session->userdata('ecode');
                    $temp['request_date'] = date('Y-m-d H:i:s');
                    $temp['from_date'] = $from_Date;
                    $temp['to_date'] = $from_Date;
                    $temp['type'] = $this->input->post('pickdrop');
                    $temp['time'] = $this->input->post('time');
                    $temp['area'] = $this->input->post('zone');
                    $temp['address'] = $this->input->post('address');
                    $temp['cab_status'] = 'PENDING';
                    $temp['action_taken_by'] = $this->session->userdata('ecode');
                    
                    $insert_data[] = $temp;
                }
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
    
    
    function view_requests(){
        $result = $this->Cab_model->view_requests();
        echo json_encode(array('data'=>$result,'status'=>200));
    }
    
    
    //////////////////////ajax calls////////////////////////////////
    function request_detail(){
        $data = array();
        $data['type'] = $this->input->post('type');
        $data['area'] = $this->input->post('area');
        $data['time'] = $this->input->post('time');
        $result = $this->Cab_model->request_detail($data);
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'status'=>200));
        } else {
            echo json_encode(array('msg'=>'no record found.','status'=>500));
        }
    }
    
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