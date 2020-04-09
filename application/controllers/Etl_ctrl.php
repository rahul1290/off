<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etl_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','Emp_model'));
    }
	
    function fetch_plrecord(){
        $db2 = $this->load->database('sqlsrv', TRUE);
        $db2->select("*");
        $results = $db2->get_where($this->config->item('NEWZ36').'PLManagement',array('EmpCode'=>'SBMMPL-01037'))->result_array();
        
        $insert_data = array();
        foreach($results as $result){
            $temp = array();
            $temp['type'] = 'PL';
            $temp['refrence_no']= $result['Reference'];
            $temp['ecode'] = $result['EmpCode'];
            $temp['credit'] = $result['Credit'];
            $temp['debit'] = $result['Debit'];
            $temp['balance'] = $result['Balance'];
            $temp['date'] = $result['Date'];
            $temp['created_at'] = date('Y-m-d H:i:s');
            $temp['created_by'] = $this->session->userdata('ecode');
            $insert_data[] = $temp;
        }
        $this->db->insert_batch('pl_management',$insert_data);
    }
}
