<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','master/Nh_fh_model','master/Employee_model'));
		$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}

	function index(){
		$this->db2 = $this->load->database('sqlsrv', TRUE);
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | Dashboard';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	
	function dotnet_dashboard(){
	    $data = array();
	    //$data['links'] = $this->Employee_model->links();
	    $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	    //print_r($data['links']); die;
	    $data['footer'] = $this->load->view('include/footer','',true);
	    $data['top_nav'] = $this->load->view('include/top_nav','',true);
	    $data['aside'] = $this->load->view('include/aside',$data,true);
	    $data['notepad'] = $this->load->view('include/shift_timing','',true);
	    $data['body'] = $this->load->view('pages/emp_dotnet_dashboard',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | Dashboard';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('layout_master',$data);
	}
	
	
	function attendance(){
		$data = array();
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$data['department'] = $this->input->post('department');
			$data['paycode'] = $this->input->post('employee');
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			//$pcode = explode('-',$data['paycode']);
			//$data['paycode'] = 'SB'.ltrim($pcode[1], "0");
			
			
			$data['paycode'] = $this->my_library->get_paycode($data['paycode']);
			$data['from_date'] = $year.'-'.$month.'-01';
			$data['to_date'] = date($year.'-'.$month.'-'.date('t',strtotime($data['from_date'])));
			
			$result = $this->Emp_model->attendance($data);
			if($result){
				echo json_encode(array('data'=>$result,'status'=>200));
			} else {
				echo json_encode(array('status'=>500));
			}
		} else {
			$data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
			$data['users'] = $this->Emp_model->get_employee($this->session->userdata('ecode'));
			$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
			
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside',$data,true);
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/es/attendance_record',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').' | Attendance Record';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	///ajax call on attendance page //
	function get_employee(){
		$users = $this->Emp_model->get_employee($this->session->userdata('ecode'),$this->input->post('dept_id'));
		if(count($users)>0){
			echo json_encode(array('data'=>$users,'status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function compareDate() {
	    $startDate = strtotime($_POST['from_date']);
	    $endDate = strtotime($_POST['to_date']);
	    
	    if ($endDate >= $startDate)
	        return True;
	        else {
	            $this->form_validation->set_message('compareDate', '%s should be greater than From Date.');
	            return False;
	        }
	}
	
	function leave_request(){
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
	        $this->form_validation->set_rules('from_date', 'From Date', 'required');
	        $this->form_validation->set_rules('to_date', 'To Date', 'required|callback_compareDate');
	        $this->form_validation->set_rules('reason','Reason','required|trim');
	        $this->form_validation->set_rules('wod','wod','required');
			$this->form_validation->set_rules('coff[]','coff','trim');
	        
	        $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
	        if ($this->form_validation->run() == FALSE) {
	            $data = array();
	            $data['coffs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'OFF_DAY' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
				$data['nhfhs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'NH_FH' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
				$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
	            $data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
				if(count($data['pls'])>0){
				  $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
				}
	            
	            $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	            $data['footer'] = $this->load->view('include/footer','',true);
	            $data['top_nav'] = $this->load->view('include/top_nav','',true);
	            $data['aside'] = $this->load->view('include/aside',$data,true);
	            $data['notepad'] = $this->load->view('include/shift_timing','',true);
	            $data['requests'] = $this->Emp_model->leave_requests($this->session->userdata('ecode'));
	            $data['body'] = $this->load->view('pages/es/leave_request',$data,true);
	            $data['title'] = $this->config->item('project_title').' | Leave Request';
	            $data['head'] = $this->load->view('common/head',$data,true);
	            $data['footer'] = $this->load->view('common/footer',$data,true);
	            $this->load->view('layout_master',$data);
	        }
	        else {
                $from_date = $this->my_library->mydate($this->input->post('from_date'));
                $to_date = $this->my_library->mydate($this->input->post('to_date'));
                $data['request_type'] = 'LEAVE';
                $data['refrence_id'] = 'LEAVE-'.date('Y').'-'.$this->my_library->department_code($this->session->userdata('ecode'));
                $data['ecode'] = $this->session->userdata('ecode');
                $data['requirment'] = $this->input->post('reason');
                $data['date_from'] = $from_date;
                $data['date_to'] = $to_date;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['wod'] = $this->input->post('wod');
                $data['pl'] = $this->input->post('f1_pl');
        		$data['lop'] = $this->input->post('f1_lop');
                $coff = $this->input->post('coff');
                $nhfh = $this->input->post('nhfh');
                
                $coff_ids = array();
                $nhfh_ids = array();
                
                if($this->db->insert('users_leave_requests',$data)){
                    $id = $this->db->insert_id();
                    $this->db->where('id',$id);
                    $this->db->update('users_leave_requests',array('refrence_id'=>$data['refrence_id'].'-'.$id));
                    
                    
                    if($coff != ''){
                        $this->db->where_in('refrence_id',$coff);
                        $this->db->update('users_leave_requests',array('request_id'=>$data['refrence_id'].'-'.$id));
                    }
                    
                    if($nhfh != ''){
                        $this->db->where_in('refrence_id',$nhfh);
                        $this->db->update('users_leave_requests',array('request_id'=>$data['refrence_id'].'-'.$id));
                    }
                    
                    
                    
                    $this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your Leave request submitted successfully.</h3>');
                    
                    redirect('es/leave-request','refresh');
                }
	        } 
	        
	    } else {
    		$data = array();
			$data['coffs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'OFF_DAY' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
			$data['nhfhs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'NH_FH' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
			
    		$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
    		$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls'])>0){
    		  $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
    		}

    		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
    		$data['footer'] = $this->load->view('include/footer','',true);
    		$data['top_nav'] = $this->load->view('include/top_nav','',true);
    		$data['aside'] = $this->load->view('include/aside',$data,true);
    		$data['notepad'] = $this->load->view('include/shift_timing','',true);
    		$data['requests'] = $this->Emp_model->leave_requests($this->session->userdata('ecode'));      //leaver request list
    		$data['body'] = $this->load->view('pages/es/leave_request',$data,true);
    		$data['title'] = $this->config->item('project_title').' | Leave Request';
    		$data['head'] = $this->load->view('common/head',$data,true);
    		$data['footer'] = $this->load->view('common/footer',$data,true);
    		$this->load->view('layout_master',$data);
	    }
	}
	
	function hf_leave_request(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->form_validation->set_rules('half_day_date', 'HALF day date', 'required');
				$this->form_validation->set_rules('reason', 'Reason', 'required|trim');
				
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				if ($this->form_validation->run() == FALSE){
					$data = array();
					$data['footer'] = $this->load->view('include/footer','',true);
					$data['top_nav'] = $this->load->view('include/top_nav','',true);
					$data['aside'] = $this->load->view('include/aside','',true);
					$data['notepad'] = $this->load->view('include/shift_timing','',true);
					
					$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
					$data['requests'] = $this->db->get_where('users_leave_requests',array('ecode'=>$this->session->userdata('ecode'),'request_type'=>'HALF','status'=>1))->result_array();
					$data['body'] = $this->load->view('pages/es/hf_leave_request',$data,true);
					//===============common===============//
					$data['title'] =  $this->config->item('project_title').' | HF Leave Request';
					$data['head'] = $this->load->view('common/head',$data,true);
					$data['footer'] = $this->load->view('common/footer',$data,true);
					$this->load->view('layout_master',$data);

				} else {
					$data['ecode'] = $this->session->userdata('ecode');
					$data['requirment'] = $this->input->post('reason');
					$date = $this->my_library->mydate($this->input->post('half_day_date'));
					$data['date_from'] = $date;
					$data['date_to'] = $date;
					$data['request_type'] = 'HALF';
					$data['refrence_id'] = 'HF-'.date('Y').'-'.$this->my_library->department_code($this->session->userdata('ecode'));
					$data['created_at'] = date('Y-m-d H:i:s');
					
					if($this->db->insert('users_leave_requests',$data)){ 
						$id = $this->db->insert_id();
						$this->db->where('id',$id);
						$this->db->update('users_leave_requests',array('refrence_id'=>$data['refrence_id'].'-'.$id));
						
						// //send mail to reporting persone
						// $mail['name'] = $this->session->userdata('username').$this->session->userdata('ecode');
						// $mail['department'] = $this->my_library->department_code($this->session->userdata('ecode'));
						// $mail['date'] = $this->my_library->sql_datepicker($date);
						// $mail['footer'] = $this->load->view('include/footer','',true);
						// $mail['head'] = $this->load->view('common/head',$mail,true);
						// $mail['body'] = $this->load->view('mail_template/half_day',$mail,true);
						// $mail['footer'] = $this->load->view('common/footer',$mail,true);
						// $mail_body = $this->load->view('layout_master',$mail,true);
						// $this->my_library->sentmail($mail_body,$this->my_library->reporting_to_mailid($this->session->userdata('ecode')));
						
						$this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your HALF day duty request send successfully.</h3>');
					} else {
						$this->session->set_flashdata('msg', '<h3 class="bg-info p-2 text-center">warning! Database issue, Please contact to IT team.</h3>');
					}
					redirect(base_url('es/hf-leave-request'),'refresh');
				}
		} else {
			$data = array();
			$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside',$data,true);
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			
			$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date,date_format(hod_remark_date,"%d/%m/%Y %H:%i:%s") as hod_remark_date');
			$this->db->order_by('date_from','DESC');
			$data['requests'] = $this->db->get_where('users_leave_requests',array('ecode'=>$this->session->userdata('ecode'),'request_type'=>'HALF','status'=>1))->result_array();
			
			$data['body'] = $this->load->view('pages/es/hf_leave_request',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').' | HF Leave Request';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function hf_leave_request_cancel($request_id){
		$this->db->select('*');
		$result = $this->db->get_where('users_leave_requests',array('id'=>$request_id,'ecode'=>$this->session->userdata('ecode'),'hod_status'=>'PENDING','hr_status'=>'PENDING','status'=>1))->result_array();
		if(count($result)>0){
			$this->db->where('id',$request_id);
			$this->db->update('users_leave_requests',array(
				'status' => 0
			));
			
			echo json_encode(array('msg'=>'Half day request canceled.','status'=>200));
		} else {
			echo json_encode(array('msg'=>'you are not Authorized.','status'=>500));
		}
	}
	
	function off_day_duty_form(){
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
			    
				$this->form_validation->set_rules('off_day_date', 'OFF day date', 'required');
				$this->form_validation->set_rules('requirment', 'Requirment', 'required|trim');
				
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				if ($this->form_validation->run() == FALSE){
					$data = array();
					$data['footer'] = $this->load->view('include/footer','',true);
					$data['top_nav'] = $this->load->view('include/top_nav','',true);
					$data['aside'] = $this->load->view('include/aside','',true);
					$data['notepad'] = $this->load->view('include/shift_timing','',true);
					$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
					$data['requests'] = $this->db->get_where('users_leave_requests',array('ecode'=>$this->session->userdata('ecode'),'request_type'=>'OFF_DAY','status'=>1))->result_array();
					
					$data['body'] = $this->load->view('pages/es/off_day_duty_form',$data,true);
					//===============common===============//
					$data['title'] = $this->config->item('project_title').' | OFF DAY DUTY FORM';
					$data['head'] = $this->load->view('common/head',$data,true);
					$data['footer'] = $this->load->view('common/footer',$data,true);
					$this->load->view('layout_master',$data);

				} else {
					$data['ecode'] = $this->session->userdata('ecode');
					$data['requirment'] = $this->input->post('requirment');
					$date = $this->my_library->mydate($this->input->post('off_day_date'));
					$data['date_from'] = $date;
					$data['date_to'] = $date;
					$data['request_type'] = 'OFF_DAY';
					$data['refrence_id'] = 'OFF_DAY-'.date('Y').'-'.$this->my_library->department_code($this->session->userdata('ecode'));
					$data['created_at'] = date('Y-m-d H:i:s');
					
					if($this->db->insert('users_leave_requests',$data)){ 
						$id = $this->db->insert_id();
						$this->db->where('id',$id);
						$this->db->update('users_leave_requests',array('refrence_id'=>$data['refrence_id'].'-'.$id));
					
						$this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your OFF day duty request send successfully.</h3>');
					} else {
						$this->session->set_flashdata('msg', '<h3 class="bg-info p-2 text-center">warning! Database issue, Please contact to IT team.</h3>');
					}
					redirect(base_url('es/off-day-duty-form'),'refresh');
				}

			} else {
				$data = array();
				$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
				$data['footer'] = $this->load->view('include/footer','',true);
				$data['top_nav'] = $this->load->view('include/top_nav','',true);
				$data['aside'] = $this->load->view('include/aside',$data,true);
				//$data['open'] = 'true';
				$data['notepad'] = $this->load->view('include/shift_timing','',true);
				
				$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
				$data['requests'] = $this->db->get_where('users_leave_requests',array('ecode'=>$this->session->userdata('ecode'),'request_type'=>'OFF_DAY','status'=>1))->result_array();

				$data['body'] = $this->load->view('pages/es/off_day_duty_form',$data,true);
				//===============common===============//
				$data['title'] = 'Home | OFF DAY DUTY FORM';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
			}		
	}
	
	function day_attendance($date,$ecode,$type){
		if($type == 'NH_FH'){
			$this->db->select('nhfh_date');
			$result = $this->db->get_where('nh_fh_master',array('id'=>$date))->result_array();
			$nhfhdate = $result[0]['nhfh_date']; 
			
			$this->db->select('paycode');
			$result = $this->db->get_where('users',array('ecode'=>$ecode,'status'=>1))->result_array();
			$emp_paycode = $result[0]['paycode'];
			
			//check user is already requested or not
			$this->db->select('*');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$nhfhdate,'request_type'=>$type,'status'=>1))->result_array();
			
			if(count($result)>0){
				echo json_encode(array('msg'=>'You already requested for this date.','status'=>500));
			} else {
				$result = $this->Emp_model->day_attendance($nhfhdate,$emp_paycode);
				if($result[0]['PRESENTVALUE']){
					echo json_encode(array('data'=>$result,'status'=>200));
				} else {
					echo json_encode(array('msg'=>'NO PUNCH RECORD.','status'=>500));
				}
			}
		}
		else if($type == "OFF_DAY"){
			$this->db->select('*');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$date,'request_type'=>$type,'status'=>1))->result_array();
			if(count($result)>0) { 
				echo json_encode(array('msg'=>'You already requested for this date.','status'=>500));
			} else { 
				$this->db->select('paycode');
				$result = $this->db->get_where('users',array('ecode'=>$ecode,'status'=>1))->result_array();
				$emp_paycode = $result[0]['paycode'];
				
				$result = $this->Emp_model->day_attendance($date,$emp_paycode);
				if($result[0]['PRESENTVALUE']){
					echo json_encode(array('data'=>$result,'status'=>200));
				} else {
					echo json_encode(array('msg'=>'NO PUNCH RECORD.','status'=>500));
				}
			}
		} 
		else if($type == "HALF"){
			$this->db->select('*');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$date,'request_type'=>$type,'status'=>1))->result_array();
			
			if(count($result)>0){
				echo json_encode(array('msg'=>'You already requested for this date.','status'=>500));
			} else {
				echo json_encode(array('status'=>200));
			}
		}
	}
	
	function hr_policies(){
		$data = array();
		
		$this->db->select('*');
		$this->db->order_by('sort','ASC');
		$data['policies'] = $this->db->get_where('policies',array('parent_id'=>1,'status'=>1))->result_array();
		
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['body'] = $this->load->view('pages/es/hr_policies',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | HR-policies';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function it_policies(){
		$data = array();
		$this->db->select('*');
		$this->db->order_by('sort','ASC');
		$data['policies'] = $this->db->get_where('policies',array('parent_id'=>2,'status'=>1))->result_array();
		
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['body'] = $this->load->view('pages/es/it_policies',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | IT-policies';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function nh_fh_day_duty_form(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$this->form_validation->set_rules('nhfh_date', 'NH/FH Date', 'required');
			$this->form_validation->set_rules('requirment', 'Requirment', 'required|trim');
			
			$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
			if ($this->form_validation->run() == FALSE){				
				$data = array();
				$this->session->set_flashdata('msg', '<h3 class="bg-warning p-2 text-center">Something going to be wrong.</h3>');
				$data['footer'] = $this->load->view('include/footer','',true);
				$data['top_nav'] = $this->load->view('include/top_nav','',true);
				$data['aside'] = $this->load->view('include/aside','',true);
				$data['nhfh_days'] = $this->Nh_fh_model->get_nhfh();
				$data['nh_fh_requests'] = $this->Nh_fh_model->user_nhfh_requests($this->session->userdata('ecode'));
				
				//$data['open'] = 'true';
				$data['notepad'] = $this->load->view('include/shift_timing','',true);
				$data['body'] = $this->load->view('pages/es/nh_fh_day_duty_form',$data,true);
				//===============common===============//
				$data['title'] = $this->config->item('project_title').'| NH FH DAY DUTY FORM';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
				
			} else {
				$data['ecode'] = $this->session->userdata('ecode');
				$data['requirment'] = $this->input->post('requirment');
				$date = $this->Nh_fh_model->get_nhfh($this->input->post('nhfh_date'));
				$data['date_from'] = $date[0]['nhfh_date'];
				$data['request_type'] = 'NH_FH';
				$data['refrence_id'] = 'NH_HF-'.date('Y').'-'.$this->my_library->department_code($this->session->userdata('ecode'));
				$data['created_at'] = date('Y-m-d H:i:s');
				
				if($this->Nh_fh_model->nh_fh_day_duty_form($data)){ 
					$id = $this->db->insert_id();
					$this->db->where('id',$id);
					$this->db->update('users_leave_requests',array('refrence_id'=>$data['refrence_id'].'-'.$id));
						
					$this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your NH/FH Request send successfully.</h3>');
				} else{
					$this->session->set_flashdata('msg', '<h3 class="bg-info p-2 text-center">warning! Database issue, Please contact to IT team.</h3>');
				}
				redirect(base_url('es/nh-fh-day-duty-form'),'refresh');
			}
			
 		} else {
			$data = array();
			$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside',$data,true);
			$data['nhfh_days'] = $this->Nh_fh_model->get_nhfh();
			$data['nh_fh_requests'] = $this->Nh_fh_model->user_nhfh_requests($this->session->userdata('ecode'));
			
			//$data['open'] = 'true';
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/es/nh_fh_day_duty_form',$data,true);
			//===============common===============//
			$data['title'] = 'Home | NH FH DAY DUTY FORM';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function tour_request_form(){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		//$data['open'] = 'true';
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/es/tour_request_form',$data,true);
		//===============common===============//
		$data['title'] = 'IBC24 | TOUR INTIMATION FORM';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function all_report($ecode=null){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		if($ecode == null){
			$ecode = $this->session->userdata('ecode');
		}
		if($this->input->get('from_date')){
			$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		} else {
			$from_date = date("d-m-Y", strtotime("first day of previous month"));
		}
			
		if($this->input->get('to_date')){
			$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		} else {
			$to_date = date("t/m/Y", strtotime(date('Y-m-d')));
		}
		$type = $this->input->get('report_type');
		
		$this->db->select('*,date_format(created_at,"%d/%m/%Y %H:%i") as created_at,date_format(date_from,"%d/%m/%Y") as date');
		if(isset($from_date)){
			$this->db->where('date_from >=',$from_date);
			$this->db->where('date_from <=',$to_date);
		}
		if(isset($type) && $type != 'All'){
			$this->db->where('request_type',$type);
		}
		$data['records'] = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'status'=>1))->result_array();
		
		$data['title'] = 'IBC24 | es | All Report';
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/es/all_report',$data,true);
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function nh_fh_avail_form(){
	    if($_SERVER['REQUEST_METHOD'] === 'POST'){
	        $this->form_validation->set_rules('nhfh_date', 'NH/FH Date', 'required');
	        $this->form_validation->set_rules('requirment', 'Requirment', 'required|trim');
	        
	        $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
	        if ($this->form_validation->run() == FALSE){
	            $data = array();
	            $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	            $data['footer'] = $this->load->view('include/footer','',true);
	            $data['top_nav'] = $this->load->view('include/top_nav','',true);
	            $data['aside'] = $this->load->view('include/aside',$data,true);
	            $data['nhfh_days'] = $this->Nh_fh_model->get_nhfh();
	            $data['nh_fh_requests'] = $this->Nh_fh_model->user_nhfh_requests($this->session->userdata('ecode'));
	            
	            $data['notepad'] = $this->load->view('include/shift_timing','',true);
	            $data['body'] = $this->load->view('pages/es/nh_fh_avail_form',$data,true);
	            //===============common===============//
	            $data['title'] = $this->config->item('project_title').'| NH FH DAY DUTY FORM';
	            $data['head'] = $this->load->view('common/head',$data,true);
	            $data['footer'] = $this->load->view('common/footer',$data,true);
	            $this->load->view('layout_master',$data);
	        } else {
	            $data['nhfh_date'] = $this->input->post('nhfh_date');
	            $data['requirment'] = $this->input->post('requirment');
	            if($this->Nh_fh_model->nh_fh_avail($data)){
	                $this->session->set_flashdata('msg', '<h3 class="bg-success p-2 text-center">Your NH/FH AVAIL Request submitted successfully.</h3>');
	                redirect(base_url('es/NH-FH-Avail-Form'),'refresh');
	            } else {
	                $this->session->set_flashdata('msg', '<h3 class="bg-warning p-2 text-center">Your NH/FH AVAIL Request not submitted.</h3>');
	                redirect(base_url('es/NH-FH-Avail-Form'),'refresh');
	            }
	            
	        }
	    }
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['nhfh_days'] = $this->Nh_fh_model->get_nhfh();
		$data['nh_fh_avail_requests'] = $this->Nh_fh_model->user_nhfh_avail_requests($this->session->userdata('ecode'));
		
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/es/nh_fh_avail_form',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').'| NH FH AVAIL FORM';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	
	function nh_fh_avail_ajax(){
	    $data['nhfh_date'] = $this->input->post('nhfh_date');
	    $data['ecode'] = $this->session->userdata('ecode');
	    $result = $this->Nh_fh_model->nh_fh_avail_ajax($data);
	    
	    if($result == '401'){
	        echo json_encode(array('msg'=>'Nh Fh date not found.','status'=>'500'));
	    } else if($result == '501'){
	        echo json_encode(array('msg'=>'Already applied for this.','status'=>'500'));
	    } else {
	        echo json_encode(array('msg'=>'ok','status'=>'200'));
	    }
	}
	
	function pl_summary_report(){
		$data = array();
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$data['department'] = $this->input->post('department');
			$data['paycode'] = $this->input->post('employee');			
			$result = $this->Emp_model->pl_summary_report($data);
			if($result){
				echo json_encode(array('data'=>$result,'status'=>200));
			} else {
				echo json_encode(array('status'=>500));
			}
		} else {
			$data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
			$data['users'] = $this->Emp_model->get_employee($this->session->userdata('ecode'));
			$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
			
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside',$data,true);
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/es/pl_record',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').' | Attendance Record';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function attendance_record(){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}	
}
