<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '1G');
class Output_ctrl extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('download');
        $this->load->model(array('Auth_model','output/Output_model'));
    }
    
    function index($ecode){
        $data = array();
        $data['title'] =  $this->config->item('project_title').'| Broadcast Output';
        $data['head'] = $this->load->view('common/head',$data,true);
        $data['footer'] = $this->load->view('common/footer',$data,true);
        $this->load->view('pages/output/broadcast',$data);
        //$this->load->view('layout_master',$data);
    }
    
    function get_files(){
        $data['date'] = $this->my_library->mydate($this->input->post('date'));
        $data['sloat'] = $this->input->post('sloat');
        
        $sloat = '';
        $time = '';
        switch($data['sloat']){
            case "1": {
                $sloat = '00:00';
                $time = '002800';
                break;
            }
            case "2": {
                $sloat = '00:30';
                $time = '005800';
                break;
            }
            case "3": {
                $sloat = '01:00';
                $time = '012800';
                break;
            }
            case "4":{
                $sloat = '01:30';
                $time = '015800';
                break;
            }
            case "5": {
                $sloat = '02:00';
                $time = '022800';
                break;
            }
            case "6": {
                $sloat = '02:30';
                $time = '025800';
                break;
            }
            case "7":{
                $sloat = '03:00';
                $time = '032800';
                break;
            }
            case "8":{
                $sloat = '03:30';
                $time = '035800';
                break;
            }
            case "9": {
                $sloat = '04:00';
                $time = '042800';
                break;
            }
            case "10": {
                $sloat = '04:30';
                $time = '045800';
                break;
            }
            case "11": {
                $sloat = '05:00';
                $time = '052800';
                break;
            }
            case "12": {
                $sloat = '05:30';
                $time = '055800';
                break;
            }
            case "13": {
                $sloat = '06:00';
                $time = '062600';
                break;
            }
            case "14": {
                $sloat = '06:30';
                $time = '065600';
                break;
            }
            case "15": {
                $sloat = '07:00';
                $time = '072600';
                break;
            }
            case "16":{
                $sloat = '07:30';
                $time = '075600';
                break;
            }
            case "17": {
                $sloat = '08:00';
                $time = '082600';
                break;
            }
            case "18": {
                $sloat = '08:30';
                $time = '085700';
                break;
            }
            case "19": {
                $sloat = '09:00';
                $time = '092700';
                break;
            }
            case "20": {
                $sloat = '09:30';
                $time = '095700';
                break;
            }
            case "21": {
                $sloat = '10:00';
                $time = '102700';
                break;
            }
            case "22":{
                $sloat = '10:30';
                $time = '105700';
                break;
            }
            case "23":{
                $sloat = '11:00';
                $time = '112700';
                break;
            }
            case "24":{
                $sloat = '11:30';
                $time = '115700';
                break;
            }
            case "25": {
                $sloat = '12:00';
                $time = '122700';
                break;
            }
            case "26": {
                $sloat = '12:30';
                $time = '125700';
                break;
            }
            case "27": {
                $sloat = '13:00';
                $time = '132700';
                break;
            }
            case "28": {
                $sloat = '13:30';
                $time = '135700';
                break;
            }
            case "29": {
                $sloat = '14:00';
                $time = '142700';
                break;
            }
            case "30": {
                $sloat = '14:30';
                $time = '145700';
                break;
            }
            case "31":{
                $sloat = '15:00';
                $time = '152700';
                break;
            }
            case "32": {
                $sloat = '15:30';
                $time = '155700';
                break;
            }
            case "33": {
                $sloat = '16:00';
                $time = '162700';
                break;
            }
            case "34":{
                $sloat = '16:30';
                $time = '165700';
                break;
            }
            case "35": {
                $sloat = '17:00';
                $time = '172700';
                break;
            }
            case "36":{
                $sloat = '17:30';
                $time = '175700';
                break;
            }
            case "37": {
                $sloat = '18:00';
                $time = '182700';
                break;
            }
            case "38": {
                $sloat = '18:30';
                $time = '185700';
                break;
            }
            case "39": {
                $sloat = '19:00';
                $time = '192700';
                break;
            }
            case "40": {
                $sloat = '19:30';
                $time = '195700';
                break;
            }
            case "41": {
                $sloat = '20:00';
                $time = '202800';
                break;
            }
            case "42": {
                $sloat = '20:30';
                $time = '205800';
                break;
            }
            case "43": {
                $sloat = '21:00';
                $time = '212800';
                break;
            }
            case "44": {
                $sloat = '21:30';
                $time = '215800';
                break;
            }
            case "45": {
                $sloat = '22:00';
                $time = '222800';
                break;
            }
            case "46": {
                $sloat = '22:30';
                $time = '225800';
                break;
            }
            case "47": {
                $sloat = '23:00';
                $time = '232800';
                break;
            }
            case "48": {
                $sloat = '23:30';
                $time = '235800';
                break;
            }
        }
        $data['time'] = $sloat;
        $data['str1'] = $time;
        $result = $this->Output_model->get_files($data);
        
        
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'status'=>200));
            
        } else {
            echo json_encode(array('msg'=>'No record Found.','status'=>500));
        }
    }
    
    
    function download_file($ecode,$vid){
        $e_code = $ecode;
        $ecode = base64_decode($ecode);
        $db2 = $this->load->database('sqlsrv', TRUE);
        
        $this->db->select('*,REPLACE(file_name,"\\\","/") as file_data');
        $videoDetail = $this->db->get_where('broadcast',array('id'=>$vid))->result_array();
        
        $db2->select("*");
        $results = $db2->get_where($this->config->item('NEWZ36').'LoginKRA',array('EmpCode'=>$ecode))->result_array();
        if(count($results)>0){
            $this->db->insert('broadcast_report',array(
                'ecode' => $ecode,
                'employee_name' => $results[0]['Name'],
                'department' => $results[0]['Dept'],
                'email_id' => $results[0]['EmailID'],
                //'ip' => $this->input->ip_address(),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'file_name' => $videoDetail[0]['file_name'],
                'created_at' => date('Y-m-d H:i:s')
            ));
            
            //$remoteURL = "http://vod.ibc24.in/mp4/".$videoDetail[0]['file_data'];
            $remoteURL = "http://192.168.25.231/mp4/".$videoDetail[0]['file_data'];
            ob_start();
            header("Content-type: application/x-file-to-save");
            header("Content-Disposition: attachment; filename=".basename($remoteURL));
            ob_end_clean();
            readfile($remoteURL);
            
            
            
            
            
            
            
            $this->output_file($remoteURL,$videoDetail[0]['file_data']);
            
            
            
            
            
            
            //force_download($videoDetail[0]['file_name'], 'http://vod.ibc24.in/mp4/'.$videoDetail[0]['file_data']);
            //header("Location: http://vod.ibc24.in/mp4/".$videoDetail[0]['file_data']);
            //force_download($videoDetail[0]['file_name'], 'http://192.168.25.231/recordnew/mp4/2020/06/30MinMcr_2020-06-16-06.26.46.403-IST_41.mp4');
        }
    }
    
    function output_file($file, $name, $mime_type=''){
        //Check the file premission
        if(!is_readable($file)) die('File not found or inaccessible!');
        
        $size = filesize($file);
        $name = rawurldecode($name);
        
        /* Figure out the MIME type | Check in array */
        $known_mime_types=array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg"=> "image/jpg",
            "jpg" =>  "image/jpg",
            "php" => "text/plain",
            "mp4" => "video/mp4"
        );
        
        if($mime_type==''){
            $file_extension = strtolower(substr(strrchr($file,"."),1));
            if(array_key_exists($file_extension, $known_mime_types)){
                $mime_type=$known_mime_types[$file_extension];
            } else {
                $mime_type="application/force-download";
            };
        };
        
        
        @ob_end_clean();
        
        
        if(ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
            
            header('Content-Type: ' . $mime_type);
            header('Content-Disposition: attachment; filename="'.$name.'"');
            
            header("Content-Transfer-Encoding: binary");
            header('Accept-Ranges: bytes');
            
            /* The three lines below basically make the
             download non-cacheable */
            header("Cache-control: private");
            header('Pragma: private');
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            
            // multipart-download and download resuming support
            if(isset($_SERVER['HTTP_RANGE']))
            {
                list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
                list($range) = explode(",",$range,2);
                list($range, $range_end) = explode("-", $range);
                $range=intval($range);
                if(!$range_end) {
                    $range_end=$size-1;
                } else {
                    $range_end=intval($range_end);
                }
                
                $new_length = $range_end-$range+1;
                header("HTTP/1.1 206 Partial Content");
                header("Content-Length: " . filesize($name));
                header("Content-Range: bytes $range-$range_end/$size");
            } else {
                $new_length=$size;
                header("Content-Length: ".$size);
            }
            
            /* Will output the file itself */
            $chunksize = 5*(1024*1024); //you may want to change this
            $bytes_send = 0;
            if ($file = fopen($file, 'r'))
            {
                if(isset($_SERVER['HTTP_RANGE']))
                    fseek($file, $range);
                    
                    while(!feof($file) &&
                        (!connection_aborted()) &&
                        ($bytes_send<$new_length)
                        )
                    {
                        $buffer = fread($file, $chunksize);
                        print($buffer); //echo($buffer); // can also possible
                        flush();
                        $bytes_send += strlen($buffer);
                    }
                    fclose($file);
            } else
                //If no permissiion
                die('Error - can not open file.');
                //die
                output_file($file, $name, 'application/octet-stream');
    }
    
    
    // //Set the time out
    // set_time_limit(0);
    // //path to the file
    // $file_path='../uploaded/client_document/'.$_REQUEST['filename'];
    // //Call the download function with file path,file name and file type
    // output_file($file_path, ''.$_REQUEST['filename'].'', 'text/plain');
    
}