<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','Emp_model'));
    }
	
	function is_login(){
		if($this->session->userdata('ecode')){
			return true;
		} else {
			return false ;
		}
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('Auth/login');
	}
	
	function index(){
		if($this->is_login()){
			//redirect('dashboard');
		    redirect('es/Attendance-Record','refresh');
		} else {
			redirect('Auth/login');
		}
	}
	function issession(){
		print_r($this->session->all_userdata());
	}
	
	function excel(){
		$phpExcel = new PHPExcel();
		
		$file = APPPATH.'../assets/attendance_rpt.xlsx';
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
			$highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
			
			for($row=2; $row <= $highestRow; $row++){
                    $col = 1;
                    $paycode = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
					$name = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
					echo $name; die;
			}
		}
	}
	
	function login(){
		if($this->is_login()){
			redirect('Auth');
		} else {
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$this->form_validation->set_rules('identity', 'Identity', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required',
						array('required' => 'You must provide a %s.')
				);
				$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('msg', 'This is my message');
				} else {
					$data['password'] = base64_encode($this->input->post('password'));
					$data['identity'] = $this->input->post('identity');
					$login_result = $this->Auth_model->login($data);
					if($login_result){
						$portaldata = array(
							'username'  => $login_result[0]['name'],
							'ecode'     => $login_result[0]['ecode'],
							'department_id' => $login_result[0]['department_id'],
							'logged_in' => TRUE
						);
						$this->session->set_userdata($portaldata);
						redirect('Auth','refresh');
					} else{
						$this->session->set_flashdata('msg', 'Login credentials not matched.');
					}
				}
			}	
			$data['title'] = 'Login | Emp-Portal';
			$data['head'] = $this->load->view('common/head',$data,true);
			$data['footer'] = $this->load->view('common/footer',$data,true);
			$this->load->view('pages/login',$data);
		}
	}
}
