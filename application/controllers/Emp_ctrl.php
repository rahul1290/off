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
			
			$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
			$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls']) > 0){
			    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
			    if($data['pls'][0]['balance'] < 0){
			        $data['pls'][0]['balance'] = 0;
			    }
			}
			
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
	    
	    if ($endDate >= $startDate){
	        return True;
	    }else {
	            $this->form_validation->set_message('compareDate', '%s should be greater than From Date.');
	            
	            $x = $this->my_library->day_duration($_POST['from_date'],$_POST['to_date']);
	            $x = explode(' ',$x);
	            if($x[0]>0){
	                return true;
	            } else {
	               $this->form_validation->set_message('compareDate', '%s should be greater than From Date.');
	               return False;
	            }
	        }
	}
	
	function validateDate($str){
	    $date = explode('/',$str);
	    if(count($date) == 3){
    	    if(strlen($date[2]) == 4){
        	    if(checkdate ( $date[1], $date[0], $date[2])){
        	        return true;
        	    } else {
        	        $this->form_validation->set_message('validateDate', '%s is not valid.');
        	        return false;
        	    }
    	    } else {
    	        $this->form_validation->set_message('validateDate', '%s is not valid.');
    	        return false;
    	    }
	    } else {
	        $this->form_validation->set_message('validateDate', '%s is not valid.');
	        return false;
	    }
	}
	
	function validatePL($str){
	    if($str >= 0){
	        return true;
	    } else {
	        $this->form_validation->set_message('validatePL', '%s is not valid.');
	        return false;
	    }
	}
	
	function validatecoff($str){
	    $from_date = date('Y-m-d', strtotime(str_replace('/', '-',$_POST['from_date'])));
	    if($str != ''){
    	    $dates = $this->db->query("select date_from from users_leave_requests where refrence_id = '".$str."' AND status = 1")->result_array();
    	    $coff_date = date('Y-m-d', strtotime("+3 months", strtotime($dates[0]['date_from'])));
    	    
    	    $diff = date_diff(date_create($from_date),date_create($coff_date));
    	    //$x = $diff->format("%R%a");
    	    if($diff->format("%R") == '+'){
    	        return true;
    	    } else {
    	        $this->form_validation->set_message('validatecoff', '%s only valid for next 3 month of date.');
    	        return false;
    	    }
	    } else {
	        return true;
	    }
	}
	
	function validatenhfh($str){
	    $from_date = date('Y-m-d', strtotime(str_replace('/', '-',$_POST['from_date'])));
	    if($str != ''){
	        $dates = $this->db->query("select date_format(date_from,'%Y') as date_from from users_leave_requests where refrence_id = '".$str."' AND status = 1")->result_array();
	        
	        if(date('Y') == $dates[0]['date_from']){
	            return true;
	        } else {
	            $this->form_validation->set_message('validatenhfh', '%s only valid for current year.');
	            return false;
	        }
	    } else {
	        return true;
	    }
	}
	
	
	function leave_request(){
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
	        $this->form_validation->set_rules('from_date', 'From Date', 'required|callback_compareDate|callback_validateDate');
	        $this->form_validation->set_rules('to_date', 'To Date', 'required|callback_compareDate|callback_validateDate');
	        $this->form_validation->set_rules('reason','Reason','required|trim');
	        $this->form_validation->set_rules('wod','wod','required');
			$this->form_validation->set_rules('coff[]','coff','trim|callback_validatecoff');
			$this->form_validation->set_rules('nhfh[]','Nhfh','trim|callback_validatenhfh');
			$this->form_validation->set_rules('f1_pl','f1_pl', 'required');
	        
	        $this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
	        if ($this->form_validation->run() == FALSE) {
	            $data = array();
	            $data['coffs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND date_from >= '".date('Y-m-d', strtotime('-3 month'))."' AND request_type = 'OFF_DAY' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
	            $data['nhfhs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'NH_FH' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
	            
	            $data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
	            $data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
	            if(count($data['pls'])>0){
	                $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
	                if($data['pls'][0]['balance'] < 0){
	                    $data['pls'][0]['balance'] = 0;
	                }
	            }
	            
	            $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	            $data['footer'] = $this->load->view('include/footer','',true);
	            $data['top_nav'] = $this->load->view('include/top_nav','',true);
	            $data['aside'] = $this->load->view('include/aside',$data,true);
	            $data['notepad'] = $this->load->view('include/shift_timing','',true);
	            //$data['requests'] = $this->Emp_model->leave_requests($this->session->userdata('ecode'));      //leaver request list
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
			$data['coffs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND date_from >= '".date('Y-m-d', strtotime('-3 month'))."' AND request_type = 'OFF_DAY' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
			$data['nhfhs'] = $this->db->query("SELECT * FROM `users_leave_requests` WHERE ecode = '".$this->session->userdata('ecode')."' AND request_type = 'NH_FH' AND (hod_status = 'GRANTED' OR hr_status = 'GRANTED') AND request_id IS NULL")->result_array();
			
    		$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
    		$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls'])>0){
    		  $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
    		  if($data['pls'][0]['balance'] < 0){
    		      $data['pls'][0]['balance'] = 0;
    		  }
    		}
    		
            $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
    		$data['footer'] = $this->load->view('include/footer','',true);
    		$data['top_nav'] = $this->load->view('include/top_nav','',true);
    		$data['aside'] = $this->load->view('include/aside',$data,true);
    		$data['notepad'] = $this->load->view('include/shift_timing','',true);
    		$data['body'] = $this->load->view('pages/es/leave_request',$data,true);
    		$data['title'] = $this->config->item('project_title').' | Leave Request';
    		$data['head'] = $this->load->view('common/head',$data,true);
    		$data['footer'] = $this->load->view('common/footer',$data,true);
    		$this->load->view('layout_master',$data);    		
	    }
	}
	
	
	function leave_request_ajax($page=0,$str=''){
	    $config = array();
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Emp_model->total_leave_requests($this->session->userdata('ecode'),$str);
	    $config["per_page"] = $this->config->item('row_count');
	    $config["uri_segment"] = $page;
	    $config['attributes'] = array('class' => 'page-link myLinks');
	    
	    
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item">';
	    $config['last_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item">';
	    $config['first_tag_close'] = '</li>';
	    
	    $this->pagination->initialize($config);
	    
	    $data["links"] = $this->pagination->create_links();
	    $records = $this->Emp_model->leave_requests_ajax($this->session->userdata('ecode'),$str,$config["per_page"],$page);
	    
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['request_type'] = $record['request_type'];
	            $temp['refrence_id'] = $this->my_library->remove_hyphen($record['refrence_id']);
	            $temp['ecode'] = $record['ecode'];
	            $temp['duration'] = $this->my_library->day_duration($record['date_from'],$record['date_to']);
	            $temp['requirment'] = $record['requirment'];
	            $temp['date_from'] = $record['date_from'] .' - '. $record['date_to'];
	            $temp['date_to'] = $record['date_to'];
	            $temp['hod_remark'] = ($record['hod_remark'])?$record['hod_remark']:'';
	            $temp['hod_status'] = $record['hod_status'];
                $temp['hod_id'] = $record['hod_id'];
                $temp['hod_remark_date'] = $record['hod_remark_date'];
                $temp['hr_remark'] = $record['hr_remark'];
                $temp['hr_status'] = $record['hr_status'];
                $temp['hr_id'] = $record['hr_id'];
                $temp['hr_remark_date'] = $record['hr_remark_date'];
                $temp['created_at'] = $record['created_at'];
                $temp['wod'] = $record['wod'];
                $temp['request_id'] = $record['request_id'];
                $temp['pl'] = $record['pl'];
                $temp['lop'] = $record['lop'];
                $temp['status'] = $record['status'];
                $temp['NHFH'] = ($record['NHFH'])?$record['NHFH']:'-';
                $temp['COFF'] = ($record['COFF'])?$record['COFF']:'-';
                
                $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
	}
	
	
	
	function validateHFDate($str){
	    $onemonthBack = date("Y-m-d",strtotime("-1 month"));
	    $str = date('Y-m-d', strtotime(str_replace('/','-',$str)));
	    $diff = date_diff(date_create($onemonthBack),date_create($str));
	    $x = $diff->format("%R");
	    if($x == '+'){
            return true;
        } else {
            $onemonthBack = date('d/m/Y',strtotime($onemonthBack));
            $this->form_validation->set_message('validateHFDate', 'Please choose date for half day after '.$onemonthBack);
            return false;
        }
	}
	
	function hf_leave_request(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->form_validation->set_rules('half_day_date', 'HALF day date', 'required|callback_validateDate|callback_validateHFDate');
				$this->form_validation->set_rules('reason', 'Reason', 'required|trim');
				
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				if ($this->form_validation->run() == FALSE){
					$data = array();
					$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
					$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
					if(count($data['pls'])>0){
					    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
					    if($data['pls'][0]['balance'] < 0){
					        $data['pls'][0]['balance'] = 0;
					    }
					}
					
					$data['footer'] = $this->load->view('include/footer','',true);
					$data['top_nav'] = $this->load->view('include/top_nav','',true);
					$data['aside'] = $this->load->view('include/aside','',true);
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
					
					$pls = $this->my_library->pl_calculator($this->session->userdata('ecode'));
					$pl_aplied = $this->my_library->pl_applied($this->session->userdata('ecode'));
					$balance = $pls[0]['balance'] - $pl_aplied;
				    if($balance < 0) {
				        $data['lop'] = '0.5';
				    } else {
				        $data['pl'] = '0.5';
				    }
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
			$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
			$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls'])>0){
			    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
			    if($data['pls'][0]['balance'] < 0){
			        $data['pls'][0]['balance'] = 0;
			    }
			}
			//$data['notepad'] = $this->load->view('include/shift_timing','',true);
			//$data['requests'] = $this->Emp_model->hf_leave_requests($this->session->userdata('ecode'));
			$data['body'] = $this->load->view('pages/es/hf_leave_request',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').' | HF Leave Request';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	
	function hf_leave_request_ajax($page=0,$str=''){
	    $config = array();
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Emp_model->total_hf_leave_requests($this->session->userdata('ecode'),$str);
	    $config["per_page"] = $this->config->item('row_count');
	    $config["uri_segment"] = $page;
	    $config['attributes'] = array('class' => 'page-link myLinks');
	    
	    
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item">';
	    $config['last_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item">';
	    $config['first_tag_close'] = '</li>';
	    
	    $this->pagination->initialize($config);
	    
	    $data["links"] = $this->pagination->create_links();
	    $records = $this->Emp_model->hf_leave_requests($this->session->userdata('ecode'),$str,$config["per_page"],$page);
	    
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['request_type'] = $record['request_type'];
	            $temp['refrence_id'] = $this->my_library->remove_hyphen($record['refrence_id']);
	            $temp['ecode'] = $record['ecode'];
	            $temp['requirment'] = $record['requirment'];
	            $temp['date_from'] = $this->my_library->sql_datepicker($record['date_from']);
	            $temp['date_to'] = $record['date_to'];
	            $temp['hod_remark'] = ($record['hod_remark'])?$record['hod_remark']:'';
	            $temp['hod_status'] = $record['hod_status'];
	            $temp['hod_id'] = $record['hod_id'];
	            $temp['hod_remark_date'] = $record['hod_remark_date'];
	            $temp['hr_remark'] = $record['hr_remark'];
	            $temp['hr_status'] = $record['hr_status'];
	            $temp['hr_id'] = $record['hr_id'];
	            $temp['hr_remark_date'] = $record['hr_remark_date'];
	            $temp['created_at'] = $record['created_at'];
	            $temp['wod'] = $record['wod'];
	            $temp['request_id'] = $record['request_id'];
	            $temp['pl'] = $record['pl'];
	            $temp['lop'] = $record['lop'];
	            $temp['status'] = $record['status'];
	            
	            $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
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
				$this->form_validation->set_rules('off_day_date', 'OFF day date', 'required|callback_validateDate');
				$this->form_validation->set_rules('requirment', 'Requirment', 'required|trim');
				
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				if ($this->form_validation->run() == FALSE){
					$data = array();
					$data['footer'] = $this->load->view('include/footer','',true);
					$data['top_nav'] = $this->load->view('include/top_nav','',true);
					$data['aside'] = $this->load->view('include/aside','',true);
					$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
					$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
					if(count($data['pls'])>0){
					    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
					    if($data['pls'][0]['balance'] < 0){
					        $data['pls'][0]['balance'] = 0;
					    }
					}
// 					$data['notepad'] = $this->load->view('include/shift_timing','',true);
// 					$data['requests'] = $this->Emp_model->off_day_duty_form($this->session->userdata('ecode'));
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
				$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
				$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
				if(count($data['pls'])>0){
				    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
				    if($data['pls'][0]['balance'] < 0){
				        $data['pls'][0]['balance'] = 0;
				    }
				}
				$data['body'] = $this->load->view('pages/es/off_day_duty_form',$data,true);
				//===============common===============//
				$data['title'] = $this->config->item('project_title').' | OFF DAY DUTY FORM';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
			}		
	}
	
	function off_day_request_ajax($page=0,$str=''){
	    $config = array();
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Emp_model->total_off_day_request($this->session->userdata('ecode'),$str);
	    $config["per_page"] = $this->config->item('row_count');
	    $config["uri_segment"] = $page;
	    $config['attributes'] = array('class' => 'page-link myLinks');
	    
	    
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item">';
	    $config['last_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item">';
	    $config['first_tag_close'] = '</li>';
	    
	    $this->pagination->initialize($config);
	    
	    $data["links"] = $this->pagination->create_links();
	    $records = $this->Emp_model->off_day_request($this->session->userdata('ecode'),$str,$config["per_page"],$page);
	    
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['request_type'] = $record['request_type'];
	            $temp['refrence_id'] = $this->my_library->remove_hyphen($record['refrence_id']);
	            $temp['ecode'] = $record['ecode'];
	            $temp['requirment'] = $record['requirment'];
	            $temp['date_from'] = $this->my_library->sql_datepicker($record['date_from']);
	            $temp['date_to'] = $record['date_to'];
	            $temp['hod_remark'] = ($record['hod_remark'])?$record['hod_remark']:'';
	            $temp['hod_status'] = $record['hod_status'];
	            $temp['hod_id'] = $record['hod_id'];
	            $temp['hod_remark_date'] = $record['hod_remark_date'];
	            $temp['hr_remark'] = $record['hr_remark'];
	            $temp['hr_status'] = $record['hr_status'];
	            $temp['hr_id'] = $record['hr_id'];
	            $temp['hr_remark_date'] = $record['hr_remark_date'];
	            $temp['created_at'] = $record['created_at'];
	            $temp['wod'] = $record['wod'];
	            $temp['request_id'] = $record['request_id'];
	            $temp['pl'] = $record['pl'];
	            $temp['lop'] = $record['lop'];
	            $temp['status'] = $record['status'];
	            
	            $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
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
			$this->db->where('(hod_status = "GRANTED" OR hr_status = "GRANTED")');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$nhfhdate,'hr_status <>' => 'REJECTED','request_type'=>$type,'status'=>1))->result_array();
			
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
			$this->db->where('(hod_status = "GRANTED" OR hr_status = "GRANTED")');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$date,'hr_status <>' => 'REJECTED','request_type'=>$type,'status'=>1))->result_array();
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
			$this->db->where('(hod_status = "GRANTED" OR hr_status = "GRANTED")');
			$this->db->order_by('created_at','desc');
			$result = $this->db->get_where('users_leave_requests',array('ecode'=>$ecode,'date_from'=>$date,'hr_status <>' => 'REJECTED','request_type'=>$type,'status'=>1))->result_array();
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
				$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
				$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
				if(count($data['pls'])>0){
				    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
				    if($data['pls'][0]['balance'] < 0){
				        $data['pls'][0]['balance'] = 0;
				    }
				}
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
            
			$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
			$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls'])>0){
			    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
			    if($data['pls'][0]['balance'] < 0){
			        $data['pls'][0]['balance'] = 0;
			    }
			}
			$data['nh_fh_requests'] = $this->Nh_fh_model->user_nhfh_requests($this->session->userdata('ecode'));
			//$data['open'] = 'true';
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/es/nh_fh_day_duty_form',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').'| NH FH DAY DUTY FORM';
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
		
		$this->db->select('ulr.*,date_format(ulr.created_at,"%d/%m/%Y") as created_at,
                            (select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = ulr.refrence_id and c.request_type in ("NH_FH")) as NHFH,
                            (select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = ulr.refrence_id and c.request_type in ("OFF_DAY")) as COFF,
                            date_format(ulr.date_from,"%d/%m/%Y") as from_date,date_format(ulr.date_to,"%d/%m/%Y") as to_date');
		if(isset($from_date)){
			$this->db->where('ulr.created_at >=',$from_date);
			$this->db->where('ulr.created_at <=',$to_date);
		}
		if(isset($type) && $type != 'All'){
			$this->db->where('ulr.request_type',$type);
		}
		$this->db->order_by('id','desc');
		$data['records'] = $this->db->get_where('users_leave_requests ulr',array('ulr.ecode'=>$ecode,'ulr.status'=>1))->result_array();
		
		$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
		$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
		if(count($data['pls'])>0){
		    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
		    if($data['pls'][0]['balance'] < 0){
		        $data['pls'][0]['balance'] = 0;
		    }
		}
		$data['title'] = $this->config->item('project_title').'| All Report';
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
	            
	            $data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
	            $data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
	            if(count($data['pls'])>0){
	                $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
	                if($data['pls'][0]['balance'] < 0){
	                    $data['pls'][0]['balance'] = 0;
	                }
	            }
	            
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
	    } else {
    		$data = array();
    		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
    		$data['footer'] = $this->load->view('include/footer','',true);
    		$data['top_nav'] = $this->load->view('include/top_nav','',true);
    		$data['aside'] = $this->load->view('include/aside',$data,true);
    		$data['nhfh_days'] = $this->Nh_fh_model->get_nhfh();
    		$data['nh_fh_avail_requests'] = $this->Nh_fh_model->user_nhfh_avail_requests($this->session->userdata('ecode'));
    		
    		$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
    		$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
    		if(count($data['pls'])>0){
    		    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
    		    if($data['pls'][0]['balance'] < 0){
    		        $data['pls'][0]['balance'] = 0;
    		    }
    		}
    		
    		$data['notepad'] = $this->load->view('include/shift_timing','',true);
    		$data['body'] = $this->load->view('pages/es/nh_fh_avail_form',$data,true);
    		//===============common===============//
    		$data['title'] = $this->config->item('project_title').'| NH FH AVAIL FORM';
    		$data['head'] = $this->load->view('common/head',$data,true);
    		$data['footer'] = $this->load->view('common/footer',$data,true);
    		$this->load->view('layout_master',$data);
	    }
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
			
			$data['pls'] = $this->my_library->pl_calculator($this->session->userdata('ecode'));
			$data['pl_aplied'] = $this->my_library->pl_applied($this->session->userdata('ecode'));
			if(count($data['pls'])>0){
			    $data['pls'][0]['balance'] = $data['pls'][0]['balance'] - $data['pl_aplied'];
			    if($data['pls'][0]['balance'] < 0){
			        $data['pls'][0]['balance'] = 0;
			    }
			}
			
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
	
	function request_cancel($request_id){
	    if($this->Emp_model->request_cancel($request_id)){
	        echo json_encode(array('msg'=>'Request canceled.','status'=>200));
	    } else {
	        echo json_encode(array('msg'=>'Request not canceled.','status'=>500));
	    }
	}
}
