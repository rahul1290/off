<?php
require APPPATH . 'libraries/REST_Controller.php';


class Emp_ctrl extends REST_Controller {
    var $db2;
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
        
        $this->load->library(array('Authorization_Token','my_library'));
        $this->db2 = $this->load->database('sqlsrv', TRUE);
    }
    
    function leave_request_get(){
        $is_valid_token = $this->authorization_token->validateToken();
        if(!empty($is_valid_token) && $is_valid_token['status'] === true){
            
            $this->db2->select('*');
            $this->db2->limit(10);
            $result = $this->db2->get('PLManagement')->result_array();
            
            $this->response($result,200);
        }else {
            $message = ['status' => FALSE,'message' => $is_valid_token['message'] ];
            $this->response($message, 404);
        }
    }
}