<?php  
require APPPATH . 'libraries/REST_Controller.php';
class Authctrl extends REST_Controller {
	
	function login_post(){
		print_r($this->post());
	}
}