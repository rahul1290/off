<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','master/Employee_model','master/Department_model','master/Designation_model','master/Empcode_model','master/Grade_model','master/Location_model'));
    }
	
	function index(){
		$data = array();
		$data['links'] = $this->my_library->links($this->session->userdata('ecode'));
		$data['employees'] = $this->Employee_model->employees();
		$data['footer'] = $this->load->view('include/footer','',true);
		$data['top_nav'] = $this->load->view('include/top_nav','',true);
		$data['aside'] = $this->load->view('include/aside',$data,true);
		$data['notepad'] = $this->load->view('include/shift_timing','',true);
		$data['body'] = $this->load->view('pages/master/employee',$data,true);
		//===============common===============//
		$data['title'] = $this->config->item('project_title').' | Employee Master';
		$data['head'] = $this->load->view('common/head',$data,true);
		$data['footer'] = $this->load->view('common/footer',$data,true);
		$this->load->view('layout_master',$data);
	}
	
	function employee_detail($eid=null){
		$data['employees'] = $this->Employee_model->employees($eid);
		echo json_encode(array('data'=>$data['employees'],'status'=>200));
	}
	
	function create(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$this->form_validation->set_rules('ecode', 'Employeecode', 'required|trim');
			$this->form_validation->set_rules('pay_code', 'Paycode', 'required|trim');
			$this->form_validation->set_rules('employee_name', 'Employee Name', 'required|trim|alpha_numeric_spaces|min_length[3]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('department', 'Department', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Department.'));
			$this->form_validation->set_rules('designation', 'Designation', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Designation.'));
			$this->form_validation->set_rules('location', 'Location', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Location.'));
			$this->form_validation->set_rules('jdate', 'Jdate', 'required');
			$this->form_validation->set_rules('empcode', 'Employee Code', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Employee Code.'));
			$this->form_validation->set_rules('grade', 'Grade', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Employee Grade.'));
			$this->form_validation->set_rules('company_mail', 'Company Mail', 'required|valid_email');
			
			$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
			if ($this->form_validation->run() == FALSE){
				$data = array();
				$data['departments'] = $this->Department_model->get_department();
				$data['designations'] = $this->Designation_model->get_designation();
				$data['empcodes'] = $this->Empcode_model->get_empcode();
				$data['grades'] = $this->Grade_model->get_grade();
				$data['employees'] = $this->Employee_model->employees();
				$data['locations'] = $this->Location_model->get_location();
				
				$data['footer'] = $this->load->view('include/footer','',true);
				$data['top_nav'] = $this->load->view('include/top_nav','',true);
				$data['aside'] = $this->load->view('include/aside','',true);
				$data['body'] = $this->load->view('pages/master/employee_create',$data,true);
				//===============common===============//
				$data['title'] = 'IBC24 | Employee Create';
				$data['head'] = $this->load->view('common/head',$data,true);
				$data['footer'] = $this->load->view('common/footer',$data,true);
				$this->load->view('layout_master',$data);
			} 
			else {
				$data['name'] = $this->input->post('employee_name');
				$data['ecode'] = $this->input->post('ecode');
				$data['paycode'] = $this->input->post('pay_code');
				$data['password'] = base64_encode($this->input->post('password'));
				$data['department_id'] = $this->input->post('department');
				$data['designation_id'] = $this->input->post('designation');
				$data['grade_id'] = $this->input->post('grade');
				$data['gender'] = $this->input->post('gender');
				$data['code_id'] = $this->input->post('empcode');
				$data['jdate'] = $this->my_library->mydate($this->input->post('jdate'));
				$data['company_id'] = 1;
				$data['location_id'] = $this->input->post('location');
				if($this->input->post('repto_department')){
					$data['report_to_dept'] = $this->input->post('repto_department');
					$data['report_to_desg'] = $this->input->post('repto_designation');
				}
				$data['dob'] = $this->my_library->mydate($this->input->post('employee_dob'));
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->session->userdata('ecode');
				$data['updated_at'] = date('Y-m-d H:i:s');
				$data['updated_by'] = $this->session->userdata('ecode');
				
				$info['contact_no'] = $this->input->post('contactno');
				$info['alternet_no'] = $this->input->post('alternetno');
				$info['personal_mailid'] = $this->input->post('personal_mail');
				$info['company_mailid'] = $this->input->post('company_mail');
				$info['address'] = $this->input->post('address');
				$info['father_name'] = $this->input->post('father_name');
				$info['fdob'] = $this->my_library->mydate($this->input->post('father_dob'));
				$info['mother_name'] = $this->input->post('mother_name');
				$info['mdob'] = $this->my_library->mydate($this->input->post('mother_dob'));
				$info['marital_status'] = $this->input->post('marital');
				if($info['marital_status'] == 'YES'){
					$info['anniversary'] = $this->my_library->mydate($this->input->post('anniversary'));
					$info['spouse_name'] = $this->input->post('spouse_name');
					$info['children'] = $this->input->post('childrens');
					if($info['children'] > 0){ 
						$info['child1_name'] = $this->input->post('f_child_name');
						$info['child1_gender'] = $this->input->post('fcgender');
						$info['child1_dob'] = $this->my_library->mydate($this->input->post('fcdob'));
					}
					if($info['children'] > 1){
						$info['child2_name'] = $this->input->post('s_child_name');
						$info['child2_gender'] = $this->input->post('scgender');
						$info['child2_dob'] = $this->my_library->mydate($this->input->post('scdob'));
					}
					if($info['children'] > 2){
						$info['child3_name'] = $this->input->post('t_child_name');
						$info['child3_gender'] = $this->input->post('tcgender');
						$info['child3_dob'] = $this->my_library->mydate($this->input->post('tcdob'));
					}
				}
				$info['updated_at'] = date('Y-m-d H:i:s');
				$info['updated_by'] = $this->session->userdata('ecode');
				
				
				if($this->Employee_model->employee_create($data,$info)){
					$this->session->set_flashdata('msg', 'Employee add successfully.');
					redirect('master/employee');
				}
			}
				
			
		} else {
			$data = array();
			$data['departments'] = $this->Department_model->get_department();
			$data['designations'] = $this->Designation_model->get_designation();
			$data['empcodes'] = $this->Empcode_model->get_empcode();
			$data['grades'] = $this->Grade_model->get_grade();
			$data['employees'] = $this->Employee_model->employees();
			$data['locations'] = $this->Location_model->get_location();
			
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside','',true);
			$data['body'] = $this->load->view('pages/master/employee_create',$data,true);
			//===============common===============//
			$data['title'] = 'IBC24 | Employee Create';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function update($employee_id=null){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$this->form_validation->set_rules('ecode', 'Employeecode', 'required|trim');
			$this->form_validation->set_rules('pay_code', 'Paycode', 'required|trim');
			$this->form_validation->set_rules('employee_name', 'Employee Name', 'required|trim|alpha_numeric_spaces|min_length[3]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('department', 'Department', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Department.'));
			$this->form_validation->set_rules('designation', 'Designation', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Designation.'));
			$this->form_validation->set_rules('location', 'Location', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Location.'));
			$this->form_validation->set_rules('jdate', 'Jdate', 'required');
			$this->form_validation->set_rules('empcode', 'Employee Code', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Employee Code.'));
			$this->form_validation->set_rules('grade', 'Grade', 'required|is_natural_no_zero',array('is_natural_no_zero'=>'Please select Employee Grade.'));
			$this->form_validation->set_rules('company_mail', 'Company Mail', 'required|valid_email');
			
			$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
			if ($this->form_validation->run() == FALSE){
			} else {
				$data['name'] = $this->input->post('employee_name');
				$data['ecode'] = $this->input->post('ecode');
				$data['paycode'] = $this->input->post('pay_code');
				$data['password'] = base64_encode($this->input->post('password'));
				$data['department_id'] = $this->input->post('department');
				$data['designation_id'] = $this->input->post('designation');
				$data['grade_id'] = $this->input->post('grade');
				$data['gender'] = $this->input->post('gender');
				$data['code_id'] = $this->input->post('empcode');
				$data['jdate'] = $this->my_library->mydate($this->input->post('jdate'));
				$data['company_id'] = 1;
				$data['location_id'] = $this->input->post('location');
				if($this->input->post('repto_department')){
					$data['report_to_dept'] = $this->input->post('repto_department');
					$data['report_to_desg'] = $this->input->post('repto_designation');
				}
				$data['dob'] = $this->my_library->mydate($this->input->post('employee_dob'));
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->session->userdata('ecode');
				$data['updated_at'] = date('Y-m-d H:i:s');
				$data['updated_by'] = $this->session->userdata('ecode');
				
				$info['contact_no'] = $this->input->post('contactno');
				$info['alternet_no'] = $this->input->post('alternetno');
				$info['personal_mailid'] = $this->input->post('personal_mail');
				$info['company_mailid'] = $this->input->post('company_mail');
				$info['address'] = $this->input->post('address');
				$info['father_name'] = $this->input->post('father_name');
				$info['fdob'] = $this->my_library->mydate($this->input->post('father_dob'));
				$info['mother_name'] = $this->input->post('mother_name');
				$info['mdob'] = $this->my_library->mydate($this->input->post('mother_dob'));
				$info['marital_status'] = $this->input->post('marital');
				if($info['marital_status'] == 'YES'){
					$info['anniversary'] = $this->my_library->mydate($this->input->post('anniversary'));
					$info['spouse_name'] = $this->input->post('spouse_name');
					$info['children'] = $this->input->post('childrens');
					if($info['children'] > 0){ 
						$info['child1_name'] = $this->input->post('f_child_name');
						$info['child1_gender'] = $this->input->post('fcgender');
						$info['child1_dob'] = $this->my_library->mydate($this->input->post('fcdob'));
					}
					if($info['children'] > 1){
						$info['child2_name'] = $this->input->post('s_child_name');
						$info['child2_gender'] = $this->input->post('scgender');
						$info['child2_dob'] = $this->my_library->mydate($this->input->post('scdob'));
					}
					if($info['children'] > 2){
						$info['child3_name'] = $this->input->post('t_child_name');
						$info['child3_gender'] = $this->input->post('tcgender');
						$info['child3_dob'] = $this->my_library->mydate($this->input->post('tcdob'));
					}
				}
				$info['updated_at'] = date('Y-m-d H:i:s');
				$info['updated_by'] = $this->session->userdata('ecode');
				
				
				if($this->Employee_model->employee_update($data,$info)){
					$this->session->set_flashdata('msg', 'Employee update successfully.');
					$path = 'master/employee/update/'.$data['ecode']; 
					redirect($path);
				}
			}
			
		} else {
			$data = array();
			$data['departments'] = $this->Department_model->get_department();
			$data['designations'] = $this->Designation_model->get_designation();
			$data['empcodes'] = $this->Empcode_model->get_empcode();
			$data['grades'] = $this->Grade_model->get_grade();
			$data['employees'] = $this->Employee_model->employees();
			$data['locations'] = $this->Location_model->get_location();
			$data['employee_detail'] = $this->Employee_model->employees($employee_id);
			
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside','',true);
			$data['body'] = $this->load->view('pages/master/employee_update',$data,true);
			//===============common===============//
			$data['title'] = 'IBC24 | Employee Update';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function privileges($ecode){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			
			$departments = $this->input->post('departments');
			
			$dep_array = array();
			$this->db->where(array('ecode'=>$ecode));
			$this->db->delete('user_department');
			
			foreach($departments as $department){
				$temp = array();
				$temp['ecode'] = $ecode;
				$temp['dep_id'] = $department;
				$temp['created_at'] = date('Y-m-d H:i:s');
				$temp['updated_at'] = date('Y-m-d H:i:s');
				$temp['created_by'] = $this->session->userdata('ecode');
				$temp['updated_by'] = $this->session->userdata('ecode');
				$dep_array[] = $temp;
			}
			$this->db->insert_batch('user_department',$dep_array); 
			
			$ulist = $this->input->post('ulist');
			$user_list = array();
			$this->db->where('ecode',$ecode);
			$this->db->delete('user_rules');
			
			foreach($ulist as $list){
				$temp = array();
				$temp['ecode'] = $ecode;
				$temp['r_ecode'] = $list;
				$user_list[] = $temp;
			}
			$this->db->insert_batch('user_rules',$user_list); 
			
			$path = base_url('master/employee/privileges/').$ecode;
			redirect($path);
			
		} else{ 
			$data = array();
			$data['results'] = $this->Department_model->get_department();
			$data['departments'] = $this->Department_model->get_department();
			$data['user_departments'] = $this->Department_model->get_employee_department($ecode);
			$data['users'] = $this->Employee_model->departments_users($ecode);
			$data['supervised'] = $this->Employee_model->supervised($ecode);
			$udep = array();
			foreach($data['departments'] as $department) {
				foreach($data['users'] as $users) {
					if($department['id'] == $users['department_id']) {
						$udep[$department['dept_name']][] = $users;
					}
				}
			}
			$data['ulists'] = $udep;
			
			$data['footer'] = $this->load->view('include/footer','',true);
			$data['top_nav'] = $this->load->view('include/top_nav','',true);
			$data['aside'] = $this->load->view('include/aside','',true);
			//$data['notepad'] = $this->load->view('include/shift_timing','',true);
			$data['body'] = $this->load->view('pages/master/privileges',$data,true);
			//===============common===============//
			$data['title'] = 'IBC24 | Department Master';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('layout_master',$data);
		}
	}
	
	function is_unique_ecode(){
		$ecode = $this->input->post('ecode');
		$result = $this->Employee_model->is_unique_ecode($ecode);
		if(count($result)>0){
			echo json_encode(array('status'=>500));
		} else {
			echo json_encode(array('status'=>200));
		}
	}
}