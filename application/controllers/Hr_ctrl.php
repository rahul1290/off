<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Department_model','Emp_model','Hr_model'));
		$this->is_login();
    }
	
	function is_login(){
		if(!$this->session->userdata('ecode')){
			redirect('Auth');
		}
	}
	function roster(){
		
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$config['upload_path']          = './assets/';
			$config['allowed_types']        = 'gif|jpg|png|xlsx';
			// $config['max_size']             = 100;
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error); die;
			}
			else{
				$data = array('upload_data' => $this->upload->data());
				
				$file = $data['upload_data']['full_path'];
				
				$nodays = date("t", mktime(0,0,0, date("n") - 1));
				$month = date("m", strtotime("first day of previous month"));
				
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					
					$nofdays = date("t", mktime(0,0,0, date("n") - 1)); 
					$insertdata = array();
					for($row=2; $row <= $highestRow; $row++){
						$col = 1;
						$paycode = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
						
						for($i=1;$i<=$nodays;$i++){
							$temp = array();
							$temp['paycode'] = $paycode;
							// $temp['DateOFFICE'] = date("Y-$month-$i");
							// $temp['SHIFTATTENDED'] = $worksheet->getCellByColumnAndRow($i+2, $row)->getValue();
							
							$this->db->where(array('PAYCODE'=>$paycode,'DateOFFICE'=>date("Y-$month-$i")));
							$this->db->update('saviour',array(
								'SHIFTATTENDED' => $worksheet->getCellByColumnAndRow($i+2, $row)->getValue()
							));
						}
					}
				}
				
				$this->session->set_flashdata('msg', '<p class="bg-success text-center">Roaster uploaded successfully.</p>');
				$data = array();
				$data['footer'] = $this->load->view('include/footer','',true);
				$data['top_nav'] = $this->load->view('include/top_nav','',true);
				$data['aside'] = $this->load->view('include/aside','',true);
				//$data['notepad'] = $this->load->view('include/notepad','',true);
				$data['body'] = $this->load->view('pages/hradmin/roaster',$data,true);
				//===============common===============//
				$data['title'] = 'Home | Emp-Portal';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
			}
		} else {
			$data = array();
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside','',true);
			$data['body'] = $this->load->view('pages/hradmin/roaster',$data,true);
			//===============common===============//
			$data['title'] = $this->config->item('project_title').' | Roaster';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function emp_info(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function salary_slip(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function holiday_list(){
		$data = array();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside','',true);
		$data['notepad'] = $this->load->view('include/notepad','',true);
		$data['body'] = $this->load->view('pages/emp_dashboard',$data,true);
		//===============common===============//
		$data['title'] = 'Home | Emp-Portal';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}

	////////////////////////////////LEAVE Requests//////////////////
	function leave_request($ref_id = null,$status = null){
	    $data = array();
	    $data['requesets'] = $this->Hr_model->total_leave_pending_request();
	    $data['links'] = $this->my_library->links($this->session->userdata('ecode'));
	    $data['footer'] = $this->load->view('include/footer','',true);
	    $data['top_nav'] = $this->load->view('include/top_nav','',true);
	    $data['aside'] = $this->load->view('include/aside',$data,true);
	    $data['notepad'] = $this->load->view('include/shift_timing','',true);
	    $data['body'] = $this->load->view('pages/hradmin/leave_requests',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | Leave Requests';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('layout_master',$data);
	}
	
	
	function leave_request_submit(){
	    $data['application_no'] = $this->input->post('application_no');
	    $data['nhfh'] = $this->input->post('nhfh');
	    $data['coff'] = $this->input->post('coff');
	    $data['pls'] = $this->input->post('pls');
	    $data['lop'] = $this->input->post('lop');
	    $data['hr_remark'] = $this->input->post('hr_remark');
	    if($this->Hr_model->leave_request_submit($data)){
	        echo json_encode(array('msg'=>'Record updated successfully.','status'=>200));
	    } else {
	        echo json_encode(array('msg'=>'Record not updated.','status'=>500));
	    }
	}
	
	
	function get_leave_ids(){
	    $data['dept_id'] = $this->input->post('dept_id');
	    $result = $this->Hr_model->get_leave_ids($data);
	    if(count($result)>0){
	        echo json_encode(array('data'=>$result,'msg'=>'','status'=>200));
	    } else {
	        echo json_encode(array('msg'=>'No record found.','status'=>500));
	    }
	}
	
	function leave_detail(){
	    $data['ref_id'] = $this->input->post('ref_id');
	    $result = $this->Hr_model->leave_detail($data);
	    if(count($result)>0){
	        echo json_encode(array('data'=>$result,'msg'=>'','status'=>200));
	    } else {
	        echo json_encode(array('msg'=>'No record found.','status'=>500));
	    }
	}
	
	
	
	function leave_request_ajax($page=0,$str=''){
	    $config = array();
	    $config["base_url"] = "javascript:void(0)";
	    $config["total_rows"] = $this->Hr_model->total_leave_request($str);
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
	    $records = $this->Hr_model->leave_request($str,$config["per_page"],$page);
	    if(count($records)>0){
	        $data['final_array'] = array();
	        foreach($records as $record){
	            $temp = array();
	            $temp['id'] = $record['id'];
	            $temp['request_type'] = $record['request_type'];
	            $temp['reference_id'] = $this->my_library->remove_hyphen($record['reference_id']);
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
	            $temp['NHFH'] = ($record['nhfhs'])?$record['nhfhs']:'-';
	            $temp['COFF'] = ($record['coff'])?$record['coff']:'-';
	            
	            $data['final_array'][] = $temp;
	        }
	    }
	    echo json_encode(array('data'=>$data,'status'=>200));
	}
	
	function leave_request_update(){
	    $data['req_id'] = $this->input->post('req_id');
	    $data['key'] = $this->input->post('key');
	    $data['value'] = $this->input->post('value');
	    $data['hr_id']	= $this->session->userdata('ecode');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    if($this->Hr_model->leave_request_update($data)){
	        echo json_encode(array('status'=>200));
	    }
	}
	
	///NH FH DAY DUTY REQUEST
	function nh_fh_day_duty_request($ref_id = null){
		$data = array();
		$data['departments'] = $this->Department_model->get_employee_department($this->session->userdata('ecode'));
		
		$users = $this->Emp_model->get_employee($this->session->userdata('ecode'));			
		$ulist = '';
		foreach($users as $user) {
			$ulist = $ulist.",'".$user['ecode']."'";
		}
		$ulist = ltrim($ulist,',');
		
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['pending_requests'] = $this->Hr_model->nh_fh_day_duty_pending_request($ulist,$ref_id);
		$data['requests'] = $this->Hr_model->nh_fh_day_duty_request($ulist,$ref_id);
		$data['body'] = $this->load->view('pages/hradmin/nh_fh_day_duty_request',$data,true);
		
		$data['title'] = $this->config->item('project_title').' | OFF Day Duty Requests';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	///HR POLICIES
	function policies(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			if($this->input->post('button') == 'submit'){
				$this->form_validation->set_rules('department', 'Department', 'required');
				$this->form_validation->set_rules('order', 'Order', 'required');
				$this->form_validation->set_rules('title', 'Title', 'required');
				if (empty($_FILES['userfile']['name'])){
					$this->form_validation->set_rules('userfile', 'Document', 'required');
				}
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				
				if ($this->form_validation->run() == FALSE) {
					$data = array();
					$data['policies'] = $this->db->query("SELECT p2.id,p1.title as parent,p2.file_name,p2.title as child,p2.sort,date_format(p2.created_at,'%d/%m/%Y') as created_at,u.name as created_by FROM policies p1
														JOIN policies p2 on p2.parent_id = p1.id
														JOIN users u on u.ecode = p2.created_by")->result_array();
					$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
					$data['footer'] = $this->load->view('include/footer','',true);
					$data['top_nav'] = $this->load->view('include/top_nav','',true);
					$data['aside'] = $this->load->view('include/aside',$data,true);
					$data['notepad'] = $this->load->view('include/shift_timing','',true);
					$data['body'] = $this->load->view('pages/hradmin/policies',$data,true);
					$data['title'] = $this->config->item('project_title').' | policies';
					$data['head'] = $this->load->view('common/head',$data,true);
					$data['footer'] = $this->load->view('common/footer',$data,true);
					$this->load->view('layout_master',$data);
					
				} else { 				
					$config['upload_path']          = './policies/';
					$config['allowed_types']        = 'pdf|PDF';
					
					$data['title'] = $this->input->post('title');
					$data['file_name'] = str_replace(' ','_',$data['title']);
					$config['file_name'] = $data['file_name'];
					$config['overwrite'] = true;
					
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('userfile')){
						$data['file_name'] = $data['file_name'].'.pdf';	
						$data['parent_id'] = $this->input->post('department');
						$data['sort'] = $this->input->post('order');
						$data['created_at'] = date('Y-m-d H:i:s');
						$data['created_by'] = $this->session->userdata('ecode');
						if($this->db->insert('policies',$data)){
							$this->session->set_flashdata('msg', '<p class="bg-success text-center">Policies submitted successfully.</p>');
							redirect(base_url('hr/Policies'),'refresh');
							
						}
					} 
				}
			} else {		// if update the record
				$id = $this->input->post('policy_id');
				$this->form_validation->set_rules('department', 'Department', 'required');
				$this->form_validation->set_rules('order', 'Order', 'required');
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				if (!empty($_FILES['userfile']['name'])){
					$config['upload_path']          = './policies/';
					$config['allowed_types']        = 'pdf|PDF';
					$config['overwrite'] = true;
					$data['title'] = $this->input->post('title');
					$data['file_name'] = str_replace(' ','_',$data['title']);
					$config['file_name'] = $data['file_name'];
					$data['file_name'] = $data['file_name'].'.pdf';
					$this->load->library('upload', $config);
					$this->upload->do_upload('userfile');
				}
				$data['title'] = $this->input->post('title');
				$data['parent_id'] = $this->input->post('department');
				$data['sort'] = $this->input->post('order');
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->session->userdata('ecode');
				
				
				$this->db->where('id',$id);
				if($this->db->update('policies',$data)){
					$this->session->set_flashdata('msg', '<p class="bg-success text-center">Policies uploaded successfully.</p>');
					redirect(base_url('hr/Policies'),'refresh');
					
				}
			}
		} else { 
			$data = array();
			$data['policies'] = $this->db->query("SELECT p2.id,p1.title as parent,p2.file_name,p2.title as child,p2.sort,date_format(p2.created_at,'%d/%m/%Y') as created_at,u.name as created_by FROM policies p1
												JOIN policies p2 on p2.parent_id = p1.id
												JOIN users u on u.ecode = p2.created_by")->result_array();
			$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside',$data,true);
			$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/hradmin/policies',$data,true);
			$data['title'] = $this->config->item('project_title').' | policies';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function policy_detail(){
		$id = $this->input->post('id');
		
		$this->db->select('*');
		$result = $this->db->get_where('policies',array('id'=>$id,'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		} else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function policy_delete(){
		$id = $this->input->post('id');
		
		$this->db->where('id',$id);
		$this->db->update('policies',array('status'=>0));
		echo json_encode(array('msg'=>'policies deleted.','status'=>200));
	}
	
	function pl_deduction(){
	    $data = array();
	    $data['footer'] = $this->load->view('include/footer','',true);
	    $data['top_nav'] = $this->load->view('include/top_nav','',true);
	    $data['aside'] = $this->load->view('include/aside','',true);
	    //$data['notepad'] = $this->load->view('include/notepad','',true);
	    $data['body'] = $this->load->view('pages/hradmin/roaster',$data,true);
	    //===============common===============//
	    $data['title'] = $this->config->item('project_title').' | PL-review';
	    $data['head'] = $this->load->view('common/head',$data,true);
	    $data['footer'] = $this->load->view('common/footer',$data,true);
	    $this->load->view('layout_master',$data);
	}
}