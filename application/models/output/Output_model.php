<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_model extends CI_Model {
	
	function get_files($data){
		$this->db->select('*');
		$result =  $this->db->get_where('broadcast',array('time'=>$data['time'].':00','date'=>$data['date'],'status'=>1))->result_array();
		return $result;
	}
}