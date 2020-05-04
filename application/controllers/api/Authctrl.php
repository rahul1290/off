<?php  
require APPPATH . 'libraries/REST_Controller.php';


class Authctrl extends REST_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model(array('Auth_model','Emp_model','master/Department_model'));
		$this->load->library('Authorization_Token');
    }
	
	function login_post(){
		$data['identity'] = trim($this->post('identity'));
		$data['password'] = base64_encode(trim($this->post('password')));
		
		$login_result = $this->Auth_model->login($data);
		if(count($login_result)>0){
			$jwt['id'] = $login_result[0]['id'];
			$jwt['ecode'] = $login_result[0]['ecode'];
			$jwt['time'] = time();
			$login_result[0]['key'] = $this->authorization_token->generateToken($jwt);			
		    $this->response($login_result, 200);
		} else {
		    $this->response( [
		        'status' => 500,
		        'message' => 'No such user found'
		    ], 404 );
		}
	}
	
	function attendance_post(){
		$is_valid_token = $this->authorization_token->validateToken();
		if(!empty($is_valid_token) && $is_valid_token['status'] === true){
		
			if($this->post('department') != ''){	
				$data['department'] = $this->post('department');
				$data['paycode'] = $this->post('employee');
				$month = $this->post('month');
				$year = $this->post('year');
				
				$data['paycode'] = $this->my_library->get_paycode($data['paycode']);
				$data['from_date'] = $year.'-'.$month.'-01';
				$data['to_date'] = date($year.'-'.$month.'-'.date('t',strtotime($data['from_date'])));
			} else {
				$this->db->select('department_id');
				$userdepartment = $this->db->get_where('users',array('ecode'=>$is_valid_token['data']->ecode,'status'=>1))->result_array();
				
				$data['department'] = $userdepartment[0]['department_id'];
				$data['paycode'] = $this->my_library->get_paycode($is_valid_token['data']->ecode);
				$data['from_date'] = date('Y-m'.'-01');
				$data['to_date'] = date('Y-m-t');	
			}
			$results = $this->Emp_model->attendance($data);
			if(count($results)>0){
				$app_attendance = array();
				foreach($results as $result){
					$temp = array();
					$temp['Paycode'] = $result['PAYCODE'];	
					$temp['Date'] =  $result['DateOFFICE'];
					$temp['InTime'] = $result['IN1']; 
					$temp['OutTime'] = $result['OUT2'];
					$temp['Shift'] = $result['SHIFT'];
					$app_attendance[] = $temp;
				}
				$this->response($app_attendance, 200);
			} else {
				$this->response('no record found.', 500);
			}
		}else{
			$message = ['status' => FALSE,'message' => $is_valid_token['message'] ];
            $this->response($message, 404);
		}
	}
	
	function user_department_get(){
		$is_valid_token = $this->authorization_token->validateToken();
		if(!empty($is_valid_token) && $is_valid_token['status'] === true){
			$department = $this->Department_model->get_employee_department($is_valid_token['data']->ecode);
			$this->response($department, 200);
		} else {
		    $this->response( [
		        'status' => 500,
		        'message' => 'No such user found'
		    ], 404 );
		}
	}
	
	function user_list_get(){
	$is_valid_token = $this->authorization_token->validateToken();
		if(!empty($is_valid_token) && $is_valid_token['status'] === true){
			$users = $this->Emp_model->get_employee($is_valid_token['data']->ecode);
			$this->response($users, 200);
		} else {
			$this->response( [
		        'status' => 500,
		        'message' => 'No such user found'
		    ], 404 );
		}	
	}
}