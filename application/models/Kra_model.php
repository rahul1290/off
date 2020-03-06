<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kra_model extends CI_Model {
    
    function set_detail($ecode){
        $db2 = $this->load->database('sqlsrv', TRUE);
        $this->db->trans_begin();
        
        $this->db->select('s_id');
        $session = $this->db->get_where('session',array('is_active'=>'pre','status'=>1))->result_array();
        
        $this->db->select('*');
        $usedetail = $this->db->get_where('kra_user_detail',array('ecode'=>$ecode,'session_id'=>$session[0]['s_id']))->result_array();
        
        if(!count($usedetail)>0){
            $db2->select("*");
            $result = $db2->get_where($this->config->item('NEWZ36').'KRANew',array('EmpCode'=>$ecode))->result_array();
            
            if(count($result)>0){
                $userinfo = array();
                $krafeed = array();
                
                $userinfo['session_id'] = $session[0]['s_id'];
                $userinfo['ecode'] = $ecode;
                $userinfo['post'] = $result[0]['post'];
                $userinfo['uname'] = $result[0]['Name'];
                $userinfo['reporting_ecode'] = $result[0]['KRAReportTo']; 
                $userinfo['reporting_name'] = $result[0]['KRAReportName'];
                $userinfo['dept'] = $result[0]['Dept'];
                $userinfo['jdate'] = $result[0]['JDate'];
                $userinfo['img'] = $result[0]['PImg'];
                $userinfo['created_at'] = date('Y-m-d H:i:s');
                
                $this->db->insert('kra_user_detail',$userinfo);
                
                $x = $this->db->insert_id();
                $krafeed['kra_id'] = $x;
                $krafeed['key_result_area1'] = $result[0]['keyresult1'];
                $krafeed['key_result_area2'] = $result[0]['keyresult2'];
                $krafeed['key_result_area3'] = $result[0]['keyresult3'];
                $krafeed['key_result_area4'] = $result[0]['keyresult4'];
                $krafeed['key_result_area5'] = $result[0]['keyresult5'];
                $krafeed['key_performance_indicator1'] = $result[0]['keyperform1'];
                $krafeed['key_performance_indicator2'] = $result[0]['keyperform2'];
                $krafeed['key_performance_indicator3'] = $result[0]['keyperform3'];
                $krafeed['key_performance_indicator4'] = $result[0]['keyperform4'];
                $krafeed['key_performance_indicator5'] = $result[0]['keyperform5'];
                $krafeed['weightage1'] = $result[0]['Weightage1'];
                $krafeed['weightage2'] = $result[0]['Weightage2'];
                $krafeed['weightage3'] = $result[0]['Weightage3'];
                $krafeed['weightage4'] = $result[0]['Weightage4'];
                $krafeed['weightage5'] = $result[0]['Weightage5'];
                $krafeed['target1'] = $result[0]['Target1'];
                $krafeed['target2'] = $result[0]['Target2'];
                $krafeed['target3'] = $result[0]['Target3'];
                $krafeed['target4'] = $result[0]['Target4'];
                $krafeed['target5'] = $result[0]['Target5'];
                $krafeed['acheived1'] = $result[0]['Achieved1'];
                $krafeed['acheived2'] = $result[0]['Achieved2'];
                $krafeed['acheived3'] = $result[0]['Achieved3'];
                $krafeed['acheived4'] = $result[0]['Achieved4'];
                $krafeed['acheived5'] = $result[0]['Achieved5'];
                $krafeed['weighted_score1'] = $result[0]['Score1'];
                $krafeed['weighted_score2'] = $result[0]['Score2'];
                $krafeed['weighted_score3'] = $result[0]['Score3'];
                $krafeed['weighted_score4'] = $result[0]['Score4'];
                $krafeed['weighted_score5'] = $result[0]['Score5'];
                $krafeed['appraisee_comments'] = $result[0]['AppComments']; 
                $krafeed['develop_need1'] = $result[0]['IDPNeed1'];
                $krafeed['develop_need2'] = $result[0]['IDPNeed2'];
                $krafeed['develop_plan'] = $result[0]['IDPPlan'];
                
                $this->db->insert('kra_feed',$krafeed);
                
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    
    function get_detail($ecode){
        $this->db->select('*');
        $session = $this->db->get_where('session',array('is_active'=>'curr'))->result_array();
        
        $this->db->select('*');
        $userdetail = $this->db->get_where('kra_user_detail',array('ecode'=>$ecode,'session_id'=>$session[0]['s_id'],'status'=>1))->result_array();
        
        if(!count($userdetail)>0){
            $this->db->select('*');
            $session = $this->db->get_where('session',array('is_active'=>'pre'))->result_array();
            
            $this->db->select('*');
            $userdetail = $this->db->get_where('kra_user_detail',array('ecode'=>$ecode,'session_id'=>$session[0]['s_id'],'status'=>1))->result_array();
        }
        return $userdetail;
    }
    
    function kra_feed($ecode,$session){
        $result = $this->db->query("select * from kra_feed where kra_id = (select id from kra_user_detail where ecode = '$ecode' AND session_id = $session AND status = 1)")->result_array();
        return $result;
    }
}