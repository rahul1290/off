<?php  
require APPPATH . 'libraries/REST_Controller.php';

class Broadcast extends REST_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model(array('Auth_model','Emp_model','master/Department_model'));
		//$this->load->library('Authorization_Token');
    }
	
	function login_post(){
		$uid = $this->post('identity');
		$password = $this->post('password');
		
		$this->db3 = $this->load->database('newsflow',TRUE);	
		$result = $this->db3->query("SELECT NAME,PLACE,CITYCODE,STATECODE,CONTACTNO,EmailId,Folder_Name,Permission,Photo,Active FROM [Newsflow].[dbo].[Login] where UID = '".$uid."' AND Pwd = '".$password."' AND Permission = 'STRINGER' ")->result_array();
		if(count($result)>0){ 
			$this->response($result, 200);
		} else {
		    $this->response( [
		        'status' => 500,
		        'message' => 'No such user found'
		    ], 404 );
		}
	}
	
}