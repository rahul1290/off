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
			return false;
		}
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('Auth/login');
	}
	
	function index(){
		if($this->is_login()){
			redirect('dashboard');
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
	
	// function saviour(){
		// $this->db2 = $this->load->database('sqlsrv',TRUE);
		
		// $this->db2->select('*');
		// $this->db2->like('PAYCODE','SB','after');
		// $this->db2->not_like('PAYCODE','SBIS','after');
		// $this->db2->where('year(DateOFFICE)>','2019');
		// //$this->db2->limit(10000,180000);
		// $this->db2->order_by('PAYCODE','DESC');
		// $result = $this->db2->get_where($this->config->item('Savior').'tblTimeRegister',array('PAYCODE'=>'SB1149'))->result_array();
		// //print_r($this->db2->last_query()); die;
		// $insert_data = array();
		// foreach($result as $r){
			// $data = array();
			// $data['PAYCODE'] = $r['PAYCODE'];
            // $data['DateOFFICE'] = $r['DateOFFICE'];
            // $data['SHIFTSTARTTIME'] = $r['SHIFTSTARTTIME'];
            // $data['SHIFTENDTIME'] = $r['SHIFTENDTIME'];
            // $data['LUNCHSTARTTIME'] = $r['LUNCHSTARTTIME'];
            // $data['LUNCHENDTIME'] = $r['LUNCHENDTIME']; 
            // $data['HOURSWORKED'] = $r['HOURSWORKED'];
            // $data['EXCLUNCHHOURS'] = $r['EXCLUNCHHOURS'];
            // $data['OTDURATION'] = $r['OTDURATION'];
            // $data['OSDURATION'] = $r['OSDURATION'];
            // $data['OTAMOUNT'] = $r['OTAMOUNT'];
            // $data['EARLYARRIVAL'] = $r['EARLYARRIVAL'];
            // $data['EARLYDEPARTURE'] = $r['EARLYDEPARTURE'];
            // $data['LATEARRIVAL'] = $r['LATEARRIVAL'];
            // $data['LUNCHEARLYDEPARTURE'] = $r['LUNCHEARLYDEPARTURE'];
            // $data['LUNCHLATEARRIVAL'] = $r['LUNCHLATEARRIVAL'];
            // $data['TOTALLOSSHRS'] = $r['TOTALLOSSHRS'];
            // $data['STATUS'] = $r['STATUS'];
            // $data['LEAVETYPE1'] = $r['LEAVETYPE1'];
            // $data['LEAVETYPE2'] = $r['LEAVETYPE2'];
            // $data['FIRSTHALFLEAVECODE'] = $r['FIRSTHALFLEAVECODE'];
            // $data['SECONDHALFLEAVECODE'] = $r['SECONDHALFLEAVECODE'];
            // $data['REASON'] = $r['REASON'];
            // $data['SHIFT'] = $r['SHIFT'];
            // $data['SHIFTATTENDED'] = $r['SHIFTATTENDED'];
            // $data['IN1'] = $r['IN1'];
            // $data['IN2'] = $r['IN2'];
            // $data['OUT1'] = $r['OUT1'];
            // $data['OUT2'] = $r['OUT2'];
            // $data['IN1MANNUAL'] = $r['IN1MANNUAL'];
            // $data['IN2MANNUAL'] = $r['IN2MANNUAL'];
            // $data['OUT1MANNUAL'] = $r['OUT1MANNUAL'];
            // $data['OUT2MANNUAL'] = $r['OUT2MANNUAL'];
            // $data['LEAVEVALUE'] = $r['LEAVEVALUE'];
            // $data['PRESENTVALUE'] = $r['PRESENTVALUE'];
            // $data['ABSENTVALUE'] = $r['ABSENTVALUE'];
            // $data['HOLIDAY_VALUE'] = $r['HOLIDAY_VALUE'];
            // $data['WO_VALUE'] = $r['WO_VALUE'];
            // $data['OUTWORKDURATION'] = $r['OUTWORKDURATION'];
            // $data['LEAVETYPE'] = $r['LEAVETYPE'];
            // $data['LEAVECODE'] = $r['LEAVECODE'];
            // $data['LEAVEAMOUNT'] = $r['LEAVEAMOUNT'];
            // $data['LEAVEAMOUNT1'] = $r['LEAVEAMOUNT1'];
            // $data['LEAVEAMOUNT2'] = $r['LEAVEAMOUNT2'];
            // $data['FLAG'] = $r['FLAG'];
            // $data['LEAVEAPRDate'] = $r['LEAVEAPRDate'];
            // $data['VOUCHER_NO'] = $r['VOUCHER_NO'];
            // $data['ReasonCode'] = $r['ReasonCode'];
            // $data['rescd'] = $r['rescd'];
            // $data['media'] = $r['media'];
            // $data['HShift'] = $r['HShift'];
            // $data['HShiftAtt'] = $r['HShiftAtt'];
            // $data['OS2OTVFlag'] = $r['OS2OTVFlag'];
            // $data['vOtDuration'] = $r['vOtDuration'];
            // $data['vOTAmount'] = $r['vOTAmount'];
            // $data['TLFlag'] = $r['TLFlag'];
            // $data['vEARLYDEPARTURE'] = $r['vEARLYDEPARTURE'];
            // $data['vLATEARRIVAL'] = $r['vLATEARRIVAL'];
            // $data['vLUNCHEARLYDEPARTURE'] = $r['vLUNCHEARLYDEPARTURE'];
            // $data['vLUNCHLATEARRIVAL'] = $r['vLUNCHLATEARRIVAL'];
            // $data['vTotalLossHrs'] = $r['vTotalLossHrs'];
			// $insert_data[] = $data;
		// }
		
		// if($this->db->insert_batch('saviour',$insert_data)){
			// echo "submitted";
		// }
	// }
	
	// function employee(){
		// $result = $this->Emp_model->emp();
		// $insert_data = array();
		// foreach($result as $r){
			// $data = array();
			// $data['name'] = $r['Name'];
			// $data['ecode'] = $r['EmpCode'];
			// $data['paycode'] = $r['PAYCODE'];
			// $data['password'] = $r['Pwd'];
			// $data['department_id'] = $r['department'];
			// $data['designation_id'] = $r['Designation'];
			// $data['grade_id'] = $r['Grade'];
			// $data['gender'] = $r['Gender'];
			// $data['dob'] = $r['BDay'];
			// $data['report_to'] = $this->session->userdata('ecode');
			// $data['jdate'] = $r['JDate'];
			// $data['company_id'] = $r['Company'];
			// $data['created_at'] = date('Y-m-d H:i:s');
			// $data['created_by'] = $this->session->userdata('ecode');
			// $data['code_id'] = $r['Code'];
			// $insert_data[] = $data;
		// }
		
		// if($this->db->insert_batch('users',$insert_data)){
			// echo "data inserted";
		// }
	// }

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
