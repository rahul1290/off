<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Etl_ctrl extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
		$this->load->model(array('Auth_model','Emp_model'));
    }
	
    function fetch_plrecord($ecode){
        $db2 = $this->load->database('sqlsrv', TRUE);
        $db2->select("*");
        $results = $db2->get_where($this->config->item('NEWZ36').'PLManagement',array('EmpCode'=>$ecode))->result_array();
        if(count($results)>0){ 
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
            if($this->db->insert_batch('pl_management',$insert_data))
    			return true;
    		else 
    			return false;
        } else {
            return true;
        }
    }
	
	
	function employee(){
	    $this->db->trans_begin();
	    
		$result = $this->fetch_emp_detail();
		$insert_data = array();
		foreach($result as $r){
			$data = array();
			$data['name'] = $r['Name'];
			$data['ecode'] = $r['EmpCode'];
			$data['paycode'] = $r['PAYCODE'];
			$data['password'] = $r['Pwd'];
			$data['department_id'] = $r['department'];
			$data['designation_id'] = $r['Designation'];
			$data['grade_id'] = $r['Grade'];
			$data['gender'] = $r['Gender'];
			$data['dob'] = $r['BDay'];
			$data['location_id'] = $r['Location'];
			$data['report_to_desg'] = $this->session->userdata('ecode');
			$data['jdate'] = $r['JDate'];
			$data['company_id'] = $r['Company'];
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('ecode');
			$data['code_id'] = $r['Code'];
			$insert_data[] = $data;
		}
		if($this->db->insert_batch('users',$insert_data)){
		    $insert_data = array();
		    foreach($result as $r){
		        $data = array();
		        $data['ecode'] = $r['EmpCode'];
		        $data['contact_no'] = $r['contact_no'];
		        $data['company_mailid'] = $r['EmailID'];
		        $data['address'] = $r['address'];
		        $data['father_name'] = $r['father_name'];
		        $data['fdob'] = $r['fdob'];
		        $data['mother_name'] = $r['mother_name'];
		        $data['mdob'] = $r['mdob'];
		        $data['marital_status'] = $r['marital_status'];
		        $data['anniversary'] = $r['anniversary'];
		        $data['spouse_name'] = $r['spouse_name'];
		        $data['image'] = $r['image'];
		        $insert_data[] = $data;
		    }
		    if($this->db->insert_batch('user_info',$insert_data)){
		        foreach($result as $r){
		            if($this->import_records($r['EmpCode'])){
		                continue;
		            }
		        }
		    }
		}
		
		$result = $this->fetch_emp_detail();
		foreach($result as $r){
		    if($this->under_me($r['EmpCode'])){
		        continue;
		    }
		}
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    echo "something wrong";
		} else {
		    $this->db->trans_commit();
		    echo "record submitted";
		}
	}
	
	
	function underme(){
	    $this->db->trans_begin();
	    
	    $result = $this->fetch_emp_detail();
	    foreach($result as $r){
	        if($this->under_me($r['EmpCode'])){
	            continue;
	        }
	    }
	    
	    if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	        echo "something wrong";
	    } else {
	        $this->db->trans_commit();
	        echo "record submitted";
	    }
	    
	}
	
	function fetch_emp_detail(){
		$this->db2 = $this->load->database('sqlsrv',TRUE);	
		$result = $this->db2->query("SELECT  Name,
									EmpCode,
									PAYCODE,
									Pwd,
									(case when (Dept = 'ADMIN') then '1'
										  when (Dept = 'BMS') then '2'
										  when (Dept = 'CHAIRMAN') then '5'
										  when (Dept = 'CITY SALES') then '6'
										  when (Dept = 'COO') then '7'
										  when (Dept = 'COPY') then '8'
										  when (Dept = 'CORPORATE SALES') then '9'
										  when (Dept = 'DISTRIBUTION') then '10'
										  when (Dept = 'EDITORIAL') then '11'
										  when (Dept = 'EMERGING MARKETING') then '12'
										  when (Dept = 'FINANCE') then '13'
										  when (Dept = 'GOVT. SALES') then '14'
										  when (Dept = 'GRAPHICS/ PROMO') then '15'
										  when (Dept = 'HUMAN RESOURCE') then '16'
										  when (Dept = 'INFORMATION TECHNOLOGY') then '17'
										  when (Dept = 'INPUT') then '18'
										  when (Dept = 'MARKETING') then '19'
										  when (Dept = 'MD') then '20'
										  when (Dept = 'MEDIA MONITORING') then '21'
										  when (Dept = 'MP SALES') then '22'
										  when (Dept = 'OTHERS') then '23'
										  when (Dept = 'OUTPUT') then '24'
										  when (Dept = 'SOCIAL MEDIA') then '25'
										  when (Dept = 'TECHNICAL') then '26'
                                          when (Dept = 'OTT') then '27'
									END) as department,
									Designation,
									(case when (Designation = 'DEVELOPER') then '1'
										when (Designation = 'ASSOCIATE PRODUCER') then '3'
										when (Designation = 'ASSISTANT PRODUCER') then '4'
										when (Designation = 'PRODUCTION EXECUTIVE') then '5'
										when (Designation = 'CAMERAMAN') then '7'
										when (Designation = 'PRODUCER') then '8'
										when (Designation = 'MAKEUP ARTIST') then '9'
										when (Designation = 'SENIOR ENGINEER - VSAT') then '10'
										when (Designation = 'TRAINEE PRODUCTION EXECUTIVE') then '12'
										when (Designation = 'SR. CAMERAMAN') then '13'
										when (Designation = 'ASSISTANT  EDITOR') then '14'
										when (Designation = 'EXECUTIVE FACILITY') then '15'
										when (Designation = 'SENIOR PRODUCER') then '16'
										when (Designation = 'SR. OFFICER - MCR') then '17'
										when (Designation = 'SENIOR CAMERAMAN') then '18'
										when (Designation = 'REPORTER') then '19'
										when (Designation = 'SENIOR VT EDITOR') then '20'
										when (Designation = 'SENIOR PRODUCTION EXECUTIVE') then '21'
										when (Designation = 'ENGINEER - VSAT') then '22'
										when (Designation = 'GRAPHIC DESIGNER') then '23'
										when (Designation = 'DEPUTY EDITOR') then '24'
										when (Designation = 'VT EDITOR') then '25'
										when (Designation = 'SENIOR PRINCIPAL CORRESPONDENT') then '26'
										when (Designation = 'TRAINEE REPORTER') then '27'
										when (Designation = 'CHIEF CAMERAMAN') then '28'
										when (Designation = 'CORRESPONDENT') then '29'
										when (Designation = 'ASSISTANT EDITOR') then '30'
										when (Designation = 'Assistant Manager') then '31'
										when (Designation = 'ASST. MANAGER - TECHNICAL') then '32'
										when (Designation = 'ASST. MANAGER (MEDIA MONITORING)') then '33'
										when (Designation = 'SENIOR GRAPHICS DESIGNER') then '34'
										when (Designation = 'SENIOR LIBRARIAN') then '35'
										when (Designation = 'SOUND ENGINEER') then '36'
										when (Designation = 'FRONT OFFICE EXECUTIVE') then '37'
										when (Designation = 'EXECUTIVE STUDIO') then '38'
										when (Designation = 'SENIOR CG OPERATOR') then '39'
										when (Designation = 'MANAGER') then '40'
										when (Designation = 'MANAGER - BUSINESS') then '41'
										when (Designation = 'MANAGER - BUSINESS (BHOPAL)') then '42'
										when (Designation = 'MANAGER - VSAT') then '43'
										when (Designation = 'MANAGER BUSINESS') then '44'
										when (Designation = 'MANAGER- BUSINESS') then '45'
										when (Designation = 'MANAGER BUSINESS- BILASPUR') then '46'
										when (Designation = 'MANAGER DISTRIBUTION-BHOPAL') then '47'
										when (Designation = 'MANAGER DISTRIBUTION-INDORE') then '48'
										when (Designation = 'MANAGER HR') then '49'
										when (Designation = 'MANAGING DIRECTOR') then '50'
										when (Designation = 'MANAGING EDITOR') then '51'
										when (Designation = 'Office Boy') then '52'
										when (Designation = 'OFFICER - MCR') then '53'
										when (Designation = 'PRINCIPAL CORRESPONDENT') then '54'
										when (Designation = 'PRINCIPAL CORRESPONDENT-BHOPAL') then '55'
										when (Designation = 'PRODICTION EXECUTIVE') then '56'
										when (Designation = 'SENIOR CORRESPONDENT') then '57'
										when (Designation = 'SENIOR CORRESPONDENT-RAIGARH') then '58'
										when (Designation = 'PROMO EDITOR') then '59'
										when (Designation = 'REGIONAL BUSINESS HEAD-CG') then '60'
										when (Designation = 'SENIOR CAMERAMAN - INDORE') then '61'
										when (Designation = 'SENIOR CAMERAMAN (AMBIKAPUR)') then '62'
										when (Designation = 'SENIOR CAMERAMAN-BHOPAL') then '63'
										when (Designation = 'SENIOR CAMERAMAN-INDORE') then '64'
										when (Designation = 'SENIOR CAMERAMAN-JABALPUR') then '65'
										when (Designation = 'EXECUTIVE VT EDITOR') then '66'
										when (Designation = 'FINANCE & HR HEAD') then '67'
										when (Designation = 'REPORTER-BILASPUR') then '68'
										when (Designation = 'REPORTER-INDORE') then '69'
										when (Designation = 'REPOTER') then '70'
										when (Designation = 'SALES CO-ORDINATOR') then '71'
										when (Designation = 'SENIOR ASSOCIATE PRODUCER') then '72'
										when (Designation = 'SPECIAL CORRESPONDENT-JAGDALPUR') then '73'
										when (Designation = 'SR CAMERAMAN-BHOPAL') then '74'
										when (Designation = 'SR EXECUTIVE ASSISTANT TO COO') then '75'
										when (Designation = 'SR EXECUTIVE MARKETING') then '76'
										when (Designation = 'SR PRODUCER') then '77'
										when (Designation = 'SR VT EDITOR') then '78'
										when (Designation = 'SR. BUSINESS  EXECUTIVE') then '79'
										when (Designation = 'SR. VM EDITOR') then '80'
										when (Designation = 'SR.BUSINESS EXECUTIVE.-KORBA') then '81'
										when (Designation = 'SR.CAMERAMAN') then '82'
										when (Designation = 'SR.CAMERAMAN-BHOPAL') then '83'
										when (Designation = 'SR.PRODUCTION IN-CHARGE FOR EVENTS') then '84'
										when (Designation = 'SR.V.T EDITOR') then '85'
										when (Designation = 'TECHNICIAN') then '86'
										when (Designation = 'TRAINEE- LIBRARY') then '87'
										when (Designation = 'SENIOR MANAGER- BUSINESS') then '88'
										when (Designation = 'SENIOR MANAGER -HR') then '89'
										when (Designation = 'SENIOR EXECUTIVE - TRAFFIC') then '90'
										when (Designation = 'SENIOR EXECUTIVE ADMIN') then '91'
										when (Designation = 'SENIOR EXECUTIVE STUDIO') then '92'
										when (Designation = 'SENIOR REPORTER') then '93'
										when (Designation = 'SENIOR REPORTER -JABALPUR') then '94'
										when (Designation = 'SENIOR REPORTER -UJJAIN') then '95'
										when (Designation = 'SENIOR REPORTER-AMBIKAPUR') then '96'
										when (Designation = 'SENIOR SOUND ENGINEER') then '97'
										when (Designation = 'SENIOR V.T.EDITOR') then '98'
										when (Designation = 'SENIOR VM EDITOR') then '99'
										when (Designation = 'AVP-BUSINESS') then '100'
										when (Designation = 'BACK OFFICE EXECUTIVE') then '101'
										when (Designation = 'BUSINESS EXECUTIVE') then '102'
										when (Designation = 'BUSINESS EXECUTIVE - MAHASAMUND') then '103'
										when (Designation = 'BUSINESS EXECUTIVE-AMBIKAPUR') then '104'
										when (Designation = 'BUSINESS EXECUTIVE-BILASPUR') then '105'
										when (Designation = 'BUSINESS EXECUTIVE-KAWARDHA') then '106'
										when (Designation = 'CAMERAMAN (JAGDALPUR)') then '107'
										when (Designation = 'CAMERAMAN- JAGDALPUR') then '108'
										when (Designation = 'CAMERAMAN- RAIGARH') then '109'
										when (Designation = 'CAMERAMAN-GWALIOR') then '110'
										when (Designation = 'CAMERAMAN-JABALPUR') then '111'
										when (Designation = 'CAMERAMAN-JAGDALPUR') then '112'
										when (Designation = 'CG OPERATOR') then '113'
										when (Designation = 'CHAIRMAN') then '114'
										when (Designation = 'ASST. MANAGER (MCR)') then '115'
										when (Designation = 'ASSISTANT VICE PRESIDENT') then '116'
										when (Designation = 'Associate Editor – Bureau Head MP') then '117'
										when (Designation = 'ASST ENGINEER') then '118'
										when (Designation = 'ASST MANAGER ADMIN') then '119'
										when (Designation = 'ASST. EDITOR') then '120'
										when (Designation = 'ASST. MANAGER - BUSINESS (BALODA BAZAR)') then '121'
										when (Designation = 'ASSISTANT MANAGER –IT') then '122'
										when (Designation = 'Assistant Manager-Business') then '123'
										when (Designation = 'ASSISTANT MANAGER-RAJNANDGAON') then '124'
										when (Designation = 'ASSISTANT  MANAGER - IT') then '125'
										when (Designation = 'ASSISTANT  MANAGER - TRAFFIC') then '126'
										when (Designation = 'ASSISTANT  VICE PRESIDENT - TECHNICAL') then '127'
										when (Designation = 'CORRESPONDENT -BHOPAL') then '128'
										when (Designation = 'CORRESPONDENT -GWALIOR') then '129'
										when (Designation = 'COSTUME STYLIST') then '130'
										when (Designation = 'CHIEF OPERATING OFFICER') then '131'
										when (Designation = 'CHIEF SOUND ENGINEER') then '132'
										when (Designation = 'CHIEF VT EDITOR') then '133'
										when (Designation = 'CONTENT EXECUTIVE') then '134'
										when (Designation = 'DIGITAL MARKETING MANAGER') then '135'
										when (Designation = 'DY. MANAGER - BUSINESS') then '136'
										when (Designation = 'DY. MANAGER BUSINESS- JAGDALPUR') then '137'
										when (Designation = 'DEPUTY MANAGER - TECHNICAL') then '138'
										when (Designation = 'DEPUTY MANAGER - TRAFFIC') then '139'
										when (Designation = 'DEPUTY MANAGER BUSINESS') then '140'
										when (Designation = 'GRAPHICS ARTIST') then '141'
										when (Designation = 'GRAPHICS DESIGNER') then '142'
										when (Designation = 'INPUT EDITOR') then '143'
										when (Designation = 'JR. CG OPERATOR') then '144'
										when (Designation = 'JR. VT EDITOR') then '145'
										when (Designation = 'JUNIOR ENGINEER') then '146'
										when (Designation = 'JUNIOR PROMO EDITOR') then '147'
										when (Designation = 'LIBRARY MANAGER') then '148'
										when (Designation = 'LIBRARY MANAGER (INCHARGE)') then '149'
										when (Designation = 'ENGINEER-VSAT') then '150'
										when (Designation = 'EXECUTIVE ACCOUNTANT') then '151'
										when (Designation = 'EXECUTIVE ACCOUNTS') then '152'
										when (Designation = 'EXECUTIVE ADMIN') then '153'
										when (Designation = 'EXECUTIVE ASSISTANT TO CHAIRMAN') then '154'
										when (Designation = 'EXECUTIVE EDITOR') then '155'
										when (Designation = 'Executive Graphics Designer') then '156'
										when (Designation = 'Executive Recovery') then '157'
										when (Designation = 'EXECUTIVE SOUND ENGINEER') then '158'
										when (Designation = 'TRAINEE- SOCIAL MEDIA') then '159'
										when (Designation = 'TRAINEE TECHNICAL') then '160'
										when (Designation = 'TRAINEE VIDEO EDITOR') then '161'
										when (Designation = 'V.T.Editor') then '162'
										when (Designation = 'VICE PRESIDENT - IT') then '163'
										when (Designation = 'VM EDITOR') then '164'
										when (Designation = 'VM-HEAD') then '165'
										when (Designation = 'VP SALES-NORTH') then '166'
										when (Designation = 'SR. CAMERAMAN (BHOPAL)') then '167'
										when (Designation = 'SR. CAMERAMAN (INDORE)') then '168'
										when (Designation = 'SR. ENGINEER - IT') then '169'
										when (Designation = 'SR. ENGINEER - VSAT') then '170'
										when (Designation = 'SR. MANAGER - CORPORATE BUSINESS (DELHI)') then '171'
									END) as Designation,
									(case when (Grade = 'E') then '1'
										when (Grade = 'M-1') then '3'
										when (Grade = 'S') then '4'
										when (Grade = 'M-2') then '5'
										when (Grade = 'M 1') then '3'
										when (Grade = 'M1') then '3'
										when (Grade = 'M-3') then '8'
										when (Grade = 'M-4') then '9'
										when (Grade = 'M-5') then '10'
										when (Grade = 'M2') then '5'
										when (Grade = 'M4') then '9'
										when (Grade = 'M-6') then '13'
										when (Grade = 'M5') then '10'
									END) as Grade,
									Gender,
									(case when (Gender = 'Male') then 'MALE' 
										  when (Gender = 'Female') then 'FEMALE'	
									END) as Gender,
                                    (case when (Location = 'RAIPUR') then '1'
                                          when (LOcation = 'INDOR') then '3'
                                          when (Location = 'BHOPAL') then '4'
                                    END ) as Location,
									BDay,
									ReportTo,
									JDate,
									Code,
									(case when (Company ='S. B. MULTIMEDIA PVT. LTD.') then '1' else 'NULL' END) as Company,
                                    PImg as image,
                                    CntNo as contact_no,
                                    EmailID,address,FatherName as father_name,FDOB as fdob,MotherName as mother_name,MDOB as mdob,
                                    MaritalStatus as marital_status,
                                    Anniversary as anniversary,
                                    AlternateContact as alternet_no,
                                    NoOfKids as children,
                                    SpouseName as spouse_name
									FROM ".$this->config->item('NEWZ36')."LoginKRA where Code <> 'NA' AND EmpCode like 'SB%' ")->result_array();

		return $result;
	}
	
	/* not used */
	function saviour(){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		
		$this->db2->select('*');
		$this->db2->like('PAYCODE','SB','after');
		$this->db2->not_like('PAYCODE','SBIS','after');
		$this->db2->where('year(DateOFFICE)>','2019');
		//$this->db2->limit(10000,180000);
		$this->db2->order_by('PAYCODE','DESC');
		$result = $this->db2->get_where($this->config->item('Savior').'tblTimeRegister',array('PAYCODE'=>'SB1149'))->result_array();
		//print_r($this->db2->last_query()); die;
		$insert_data = array();
		foreach($result as $r){
			$data = array();
			$data['PAYCODE'] = $r['PAYCODE'];
            $data['DateOFFICE'] = $r['DateOFFICE'];
            $data['SHIFTSTARTTIME'] = $r['SHIFTSTARTTIME'];
            $data['SHIFTENDTIME'] = $r['SHIFTENDTIME'];
            $data['LUNCHSTARTTIME'] = $r['LUNCHSTARTTIME'];
            $data['LUNCHENDTIME'] = $r['LUNCHENDTIME']; 
            $data['HOURSWORKED'] = $r['HOURSWORKED'];
            $data['EXCLUNCHHOURS'] = $r['EXCLUNCHHOURS'];
            $data['OTDURATION'] = $r['OTDURATION'];
            $data['OSDURATION'] = $r['OSDURATION'];
            $data['OTAMOUNT'] = $r['OTAMOUNT'];
            $data['EARLYARRIVAL'] = $r['EARLYARRIVAL'];
            $data['EARLYDEPARTURE'] = $r['EARLYDEPARTURE'];
            $data['LATEARRIVAL'] = $r['LATEARRIVAL'];
            $data['LUNCHEARLYDEPARTURE'] = $r['LUNCHEARLYDEPARTURE'];
            $data['LUNCHLATEARRIVAL'] = $r['LUNCHLATEARRIVAL'];
            $data['TOTALLOSSHRS'] = $r['TOTALLOSSHRS'];
            $data['STATUS'] = $r['STATUS'];
            $data['LEAVETYPE1'] = $r['LEAVETYPE1'];
            $data['LEAVETYPE2'] = $r['LEAVETYPE2'];
            $data['FIRSTHALFLEAVECODE'] = $r['FIRSTHALFLEAVECODE'];
            $data['SECONDHALFLEAVECODE'] = $r['SECONDHALFLEAVECODE'];
            $data['REASON'] = $r['REASON'];
            $data['SHIFT'] = $r['SHIFT'];
            $data['SHIFTATTENDED'] = $r['SHIFTATTENDED'];
            $data['IN1'] = $r['IN1'];
            $data['IN2'] = $r['IN2'];
            $data['OUT1'] = $r['OUT1'];
            $data['OUT2'] = $r['OUT2'];
            $data['IN1MANNUAL'] = $r['IN1MANNUAL'];
            $data['IN2MANNUAL'] = $r['IN2MANNUAL'];
            $data['OUT1MANNUAL'] = $r['OUT1MANNUAL'];
            $data['OUT2MANNUAL'] = $r['OUT2MANNUAL'];
            $data['LEAVEVALUE'] = $r['LEAVEVALUE'];
            $data['PRESENTVALUE'] = $r['PRESENTVALUE'];
            $data['ABSENTVALUE'] = $r['ABSENTVALUE'];
            $data['HOLIDAY_VALUE'] = $r['HOLIDAY_VALUE'];
            $data['WO_VALUE'] = $r['WO_VALUE'];
            $data['OUTWORKDURATION'] = $r['OUTWORKDURATION'];
            $data['LEAVETYPE'] = $r['LEAVETYPE'];
            $data['LEAVECODE'] = $r['LEAVECODE'];
            $data['LEAVEAMOUNT'] = $r['LEAVEAMOUNT'];
            $data['LEAVEAMOUNT1'] = $r['LEAVEAMOUNT1'];
            $data['LEAVEAMOUNT2'] = $r['LEAVEAMOUNT2'];
            $data['FLAG'] = $r['FLAG'];
            $data['LEAVEAPRDate'] = $r['LEAVEAPRDate'];
            $data['VOUCHER_NO'] = $r['VOUCHER_NO'];
            $data['ReasonCode'] = $r['ReasonCode'];
            $data['rescd'] = $r['rescd'];
            $data['media'] = $r['media'];
            $data['HShift'] = $r['HShift'];
            $data['HShiftAtt'] = $r['HShiftAtt'];
            $data['OS2OTVFlag'] = $r['OS2OTVFlag'];
            $data['vOtDuration'] = $r['vOtDuration'];
            $data['vOTAmount'] = $r['vOTAmount'];
            $data['TLFlag'] = $r['TLFlag'];
            $data['vEARLYDEPARTURE'] = $r['vEARLYDEPARTURE'];
            $data['vLATEARRIVAL'] = $r['vLATEARRIVAL'];
            $data['vLUNCHEARLYDEPARTURE'] = $r['vLUNCHEARLYDEPARTURE'];
            $data['vLUNCHLATEARRIVAL'] = $r['vLUNCHLATEARRIVAL'];
            $data['vTotalLossHrs'] = $r['vTotalLossHrs'];
			$insert_data[] = $data;
		}
		
		if($this->db->insert_batch('saviour',$insert_data)){
			echo "submitted";
		}
	}
	
	function coff_requests($ecode){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		    
		$results = $this->db2->query("SELECT * FROM ".$this->config->item('NEWZ36')."OffTbl where EmpCode = '".$ecode."'")->result_array();
		if(count($results)>0){
    		$insert_record = array();
    		foreach($results as $result){
    			$temp = array();
    			$temp['request_type'] = 'OFF_DAY';
    			$temp['reference_id'] = $result['ID'];
    			$temp['ecode'] = $result['EmpCode'];
    			$temp['requirment'] = $result['Requirement'];
    			$temp['date_from'] = $result['Date1'];
    			$temp['date_to'] = $result['Date1'];
    			$temp['hod_remark'] = $result['HODRemarks'];
    			$temp['hod_status'] = $result['HODApp'];
    			$temp['hod_id'] = '';
    			$temp['hod_remark_date'] = '';
    			$temp['hr_remark'] = '';
    			$temp['hr_status'] = $result['HRStatus'];
    			$temp['hr_id'] = '';
    			$temp['hr_remark_date'] = '';
    			$temp['created_at'] = $result['AppDate'];
    			$insert_record[] = $temp;
    		}
    		
    		if($this->db->insert_batch('users_leave_requests',$insert_record))
    			return true;
    		else 
    			return false;
		} else {
		    return true;
		}
	}
	
	function leave_requests($ecode){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		$results = $this->db2->query("SELECT * FROM ".$this->config->item('NEWZ36')."ITDLeaveRequest where Emp_Code = '".$ecode."' order by App_Date desc")->result_array();
		
		if(count($results)>0){
    		$insert_record = array();
    		foreach($results as $result){
    			$temp = array();
    			$temp['request_type'] = 'LEAVE';
    			$temp['reference_id'] = $result['Emp_Req_No'];
    			$temp['ecode'] = $result['Emp_Code'];
    			$temp['requirment'] = $result['LReason'];
    			$temp['date_from'] = $result['Leave_From'];
    			$temp['date_to'] = $result['Leave_to'];
    			$temp['hod_remark'] = $result['HOD_Remarks'];
    			$temp['hod_status'] = $result['HOD_Approval'];
    			$temp['hod_id'] = '';
    			$string = $result['OFF_Taken'];
    			$string2 = $result['HR_Remarks'];
    			
    			///string  check start
    			if (strpos($string, 'NH/FH') !== false) {	
    			$x = explode('NH/FH',$string);
    				$nhfh = '';
    				$c = (int)strlen($x[1]);
    				for($i=0;$i<$c;$i++){
    					$c = ord($x[1][$i]);
    					if(($c>64 && $c<91) || ($c>96 && $c<123)){
    						break;
    					}
    					$nhfh.=$x[1][$i];
    				}
    				$nhfhs = explode(',',rtrim(ltrim(str_replace(' ', '', $nhfh),':'),','));
    				foreach($nhfhs as $nhfh){
    					$var = $nhfh;
    					$date = str_replace('/', '-', $var);
    					$this->db->where(array('ecode'=>$ecode,'request_type'=>'NH_FH','date_from'=>date('Y-m-d', strtotime($date)),'status'=>1));
    					$this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
    				}
    			}
    			
    			if (strpos($string, 'Comp OFFs') !== false) {
    			$x = explode('Comp OFFs',$string);
    				$coff = '';
    				for($i=0;$i<strlen($x[1]);$i++){
    					$c = ord($x[1][$i]);
    					if(($c>64 && $c<91) || ($c>96 && $c<123)){
    						break;
    					}
    					$coff.=$x[1][$i];
    				}
    				$coffs = explode(',',rtrim(ltrim(str_replace(' ', '', $coff),':'),','));
    				
    				foreach($coffs as $coff){
    				    $coff = str_replace('/', '-', $coff);
    				    $this->db->where(array('ecode'=>$ecode,'request_type'=>'OFF_DAY','date_from'=>date('Y-m-d',strtotime($coff)),'status'=>1));
    					$this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
    				}
    			}
    			///string check end
    			
    			///string2 check start
    			if($string2 != ''){
        			if (strpos($string2, 'NH/FH') !== false) {
        			    $x = explode('NH/FH',$string2);
        			    $nhfh = '';
        			    $c = (int)strlen($x[1]);
        			    for($i=0;$i<$c;$i++){
        			        $c = ord($x[1][$i]);
        			        if(($c>64 && $c<91) || ($c>96 && $c<123)){
        			            break;
        			        }
        			        $nhfh.=$x[1][$i];
        			    }
        			    $nhfhs = explode(',',rtrim(ltrim(str_replace(' ', '', $nhfh),':'),','));
        			    foreach($nhfhs as $nhfh){
        			        $var = $nhfh;
        			        $date = str_replace('/', '-', $var);
        			        $this->db->where(array('ecode'=>$ecode,'request_type'=>'NH_FH','date_from'=>date('Y-m-d', strtotime($date)),'status'=>1));
        			        $this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
        			    }
        			}
        			
        			if (strpos($string2, 'Comp OFFs') !== false) {
        			    $x = explode('Comp OFFs',$string2);
        			    $coff = '';
        			    for($i=0;$i<strlen($x[1]);$i++){
        			        $c = ord($x[1][$i]);
        			        if(($c>64 && $c<91) || ($c>96 && $c<123)){
        			            break;
        			        }
        			        $coff.=$x[1][$i];
        			    }
        			    $coffs = explode(',',rtrim(ltrim(str_replace(' ', '', $coff),':'),','));
        			    
        			    foreach($coffs as $coff){
        			        $coff = str_replace('/', '-', $coff);
        			        $this->db->where(array('ecode'=>$ecode,'request_type'=>'OFF_DAY','date_from'=>date('Y-m-d',strtotime($coff)),'status'=>1));
        			        $this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
        			    }
        			}
    			}
    			/// string2 chek end 
    			
    			if($result['AvailCompOFF'] != ''){
    			    $coffs = '';
    			    $coffs = explode(',', $result['AvailCompOFF']);
    			    
    			    foreach($coffs as $coff){
    			        if($coff != ''){ 
        			        $coff = str_replace('/', '-', $coff);
        			        $date = explode('-', $coff);
        			        $coff = trim($date[1]).'-'.trim($date[0]).'-'.trim($date[2]);
        			        
        			        $this->db->where(array('ecode'=>$ecode,'request_type'=>'OFF_DAY','date_from'=>date('Y-m-d',strtotime($coff)),'status'=>1));
        			        $this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
    			        }
    			    }
    			}
    			
    			
    			$temp['hod_remark_date'] = $result['Approval_Date'];
    			$temp['hr_remark'] = $result['HR_Remarks'];
    			$temp['hr_status'] = $result['HR_Approval'];
    			$temp['hr_id'] = '';
    			$temp['hr_remark_date'] = $result['HR_Approval_Date'];
    			$temp['created_at'] = $result['App_Date'];
    			$temp['wod'] = $result['WODay'];
    			$temp['request_id'] = '';
    			$temp['pl'] = $result['PLTaken'];
    			$temp['lop'] = '';
    			$temp['status'] = 1;
    			
    			$insert_record[] = $temp;
    		}
    		if($this->db->insert_batch('users_leave_requests',$insert_record))
    			return true;
    		else	
    			return false;
		} else {
		    return true;
		}
	}
	
	function hf_requests($ecode){
	$this->db2 = $this->load->database('sqlsrv',TRUE);
	$results = $this->db2->query("SELECT * FROM ".$this->config->item('NEWZ36')."HalfDayLeave where EmpCode = '".$ecode."'")->result_array();
    	if(count($results)>0){ 
        	$insert_record = array();
    		foreach($results as $result){
    			$temp['request_type'] = 'HALF';
    			$temp['reference_id'] = $result['ID'];
    			$temp['ecode'] = $result['EmpCode'];
    			$temp['requirment'] = $result['Reason'];
    			$temp['date_from'] = $result['RDate'];
    			$temp['date_to'] = $result['RDate'];
    			$temp['hod_remark'] = $result['Remarks'];
    			$temp['hod_status'] = $result['AppStatus'];
    			$temp['hod_id'] = NULL;
    			$temp['hod_remark_date'] = NULL;
    			$temp['hr_remark'] = $result['HRRemarks'];
    			$temp['hr_status'] = $result['HRStatus'];
    			$temp['hr_id'] = '';
    			$temp['hr_remark_date'] = NULL;
    			$temp['created_at'] = $result['UDate'];
    			$temp['wod'] = NULL;
    			$temp['request_id'] = '';
    			$temp['pl'] = NULL;
    			$temp['lop'] = '';
    			$temp['status'] = 1;
    			$insert_record[] = $temp;
    		}
    		if($this->db->insert_batch('users_leave_requests',$insert_record))
    			return true;
    		else 
    			return false;
    	} else {
    	    return true;
    	}
	}
	
	function nhfh_day_duty($ecode){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		$results = $this->db2->query("SELECT * FROM ".$this->config->item('NEWZ36')."NHFHDetail where EmpCode = '".$ecode."'")->result_array();
		
		if(count($results)>0){ 
    		$insert_record = array();
    		foreach($results as $result){
    			$temp['request_type'] = 'NH_FH';
    			$temp['reference_id'] = $result['ID'];
    			$temp['ecode'] = $result['EmpCode'];
    			$temp['requirment'] = $result['Requirement'];
    			$temp['date_from'] = $result['Date1'];
    			$temp['date_to'] = $result['Date1'];
    			$temp['hod_remark'] = $result['HODRemarks'];
    			$temp['hod_status'] = $result['HODApp'];
    			$temp['hod_id'] = NULL;
    			$temp['hod_remark_date'] = NULL;
    			$temp['hr_remark'] = '';
    			$temp['hr_status'] = $result['HRStatus'];
    			$temp['hr_id'] = '';
    			$temp['hr_remark_date'] = NULL;
    			$temp['created_at'] = $result['AppDate'];
    			$temp['wod'] = NULL;
    			$temp['request_id'] = '';
    			$temp['pl'] = NULL;
    			$temp['lop'] = '';
    			$temp['status'] = 1;
    			$insert_record[] = $temp;
    		}
    		if($this->db->insert_batch('users_leave_requests',$insert_record))
    			return true;
    		else 
    			return false;
		} else {
		    return true;
		}
	}
	
	
	function nhfhavail($ecode){
	    $this->db2 = $this->load->database('sqlsrv',TRUE);
	    $results = $this->db2->query("SELECT * FROM ".$this->config->item('NEWZ36')."NHFHAvail where EmpCode = '".$ecode."'")->result_array();
	    if(count($results)>0){
	        $insert_data = array();
	        foreach($results as $result){
	            $temp = array();
	            $temp['request_type'] = 'NH_FH_AVAIL';
	            $temp['reference_id'] = $result['ID'];
	            $temp['ecode'] = $result['EmpCode'];
	            $temp['requirment'] = $result['Requirement'];
	            $temp['date_from'] = $this->my_library->mydate(substr($result['workoffday'], 0,10));
	            $temp['date_to'] = $this->my_library->mydate(substr($result['workoffday'], 0,10));
	            $temp['hod_remark'] = $result['HODRemarks'];
	            
	            if($result['HODApp'] == 'GRANTED'){
	                $temp['hod_status'] = 'GRANTED';
	            } else {
	                $temp['hod_status'] = 'PENDING';
	            }
	            $temp['created_at'] = $result['AppDate'];
	            $insert_data[] = $temp;
	        }
	        $this->db->insert_batch('users_leave_requests',$insert_data);
	        return true;
	    }
	    return true;
	}
	
	
	function cab_mng($ecode){
	    $this->db2 = $this->load->database('sqlsrv',TRUE);
	    $results = $this->db2->query("SELECT t1.*,t2.* FROM [NEWZ36].[dbo].[CABFormTbl] as t1 join [NEWZ36].[dbo].[CABTransaction] as t2 on t1.ReqID = t2.ReqID where t1.EmpCode = '".$ecode."'")->result_array();
	    
	    if(count($results)>0){ 
    	    $insert_data = array();
    	    foreach($results as $result){
    	        $temp = array();
    	        
    	        $this->db->select('id');
    	        $times = $this->db->get_where('cab_pickup_drop_time',array('time'=>date('H:i:s',strtotime($result['Time'])),'status'=>1))->result_array();
    	        
    	        $this->db->select('*');
    	        $areas = $this->db->get_where('cabzone_master',array('location_name'=>$result['Area'],'parent_id'=>0))->result_array();
    	        $temp['ecode'] = $result['EmpCode'];
    	        $temp['request_date'] = $result['Date'];
    	        $temp['from_date'] = $result['Date1']; 
    	        $temp['to_date'] = $result['Date2'];
    	        if($result['PDType'] == 'DROPING'){ 
    	           $temp['type'] = 'drop';
    	        } else {
    	            $temp['type'] = 'pick';
    	        }
    	        $temp['time'] = $times[0]['id'];
    	        $temp['area'] = $areas[0]['id'];
    	        $temp['reqest_id'] = $result['ReqID'];
    	        $temp['remark'] = $result['Remarks'];
    	        $temp['is_active'] = 1;
    	        $temp['last_update_user'] = '';
    	        $temp['cab_status'] = $result['Status'];
    	        $temp['action_taken_by'] = '';
    	        $temp['vehicle_no'] = $result['VehicleNo'];
    	        $temp['drivername'] = $result['Drivername'];
    	        $temp['action_taken_date'] = $result['Date'];
    	        $insert_data[] = $temp;
    	    }
    	    $this->db->insert_batch('car_transection',$insert_data);
	    } else {
	        return true;
	    }
	}
	
	
	function reporting_to($ecode){
	    $this->db2 = $this->load->database('sqlsrv',TRUE);
	    $results = $this->db2->query("select * from ".$this->config->item('NEWZ36')." LoginKRA where EmpCode = (SELECT Report1 FROM ".$this->config->item('NEWZ36')."LoginKRA where EmpCode = '".$ecode."') AND Code <> 'NA'")->result_array();
	    
	    if(count($results)>0){
	        $this->db->select('id');
	        $userdept = $this->db->get_where('department_master',array('dept_name'=>$results[0]['Dept'],'status'=>1))->result_array();
	                
	        
	        $this->db->select('id');
	        $userdesig = $this->db->get_where('designation_master',array('desg_name'=>$results[0]['Designation'],'status'=>1))->result_array();
	        
	        $this->db->where('ecode',$ecode);
	        $this->db->update('users',array('report_to_dept'=>$userdept[0]['id'],'report_to_desg'=>$userdesig[0]['id']));
	        
	        $result = $this->db2->query("SELECT Report1 FROM ".$this->config->item('NEWZ36')."LoginKRA where EmpCode = '".$ecode."'")->result_array();
	        
	        $this->db->insert('user_rules',array('ecode'=>$result[0]['Report1'],'r_ecode'=>$ecode));
	    }
	    return true;
	}
	
	function under_me($ecode){
	    $this->db2 = $this->load->database('sqlsrv',TRUE);
	    $results = $this->db2->query("select * from ".$this->config->item('NEWZ36')." LoginKRA where EmpCode = (SELECT Report1 FROM ".$this->config->item('NEWZ36')."LoginKRA where EmpCode = '".$ecode."') AND Code <> 'NA'")->result_array();
	    
	    if(count($results)>0){
	        $results = $this->db2->query("SELECT EmpCode FROM [NEWZ36].[dbo].[LoginKRA] where Report1 = '".$ecode."' AND Code <> 'NA'")->result_array();
	        
	        if(count($results)>0){
	            $insert_data = array();
	            foreach ($results as $result){
	                if($result['EmpCode'] == 'assign'){
	                    continue;
	                } else {
    	                $temp = array();
    	                $temp['ecode'] = $ecode;
    	                $temp['r_ecode'] = $result['EmpCode'];
    	                $insert_data[] = $temp;
	                }
	            }
	            $this->db->insert_batch('user_rules',$insert_data);
	            $this->db->insert('user_rules',array('ecode'=>$ecode,'r_ecode'=>$ecode));
	            return true;
	        } else {
	            $this->db->insert('user_rules',array('ecode'=>$ecode,'r_ecode'=>$ecode));
	            return true;
	        }
	    } else {
	        return true;
	    }
	}
	
	
	function import_records($ecode){
			if($this->coff_requests($ecode)){
				if($this->nhfh_day_duty($ecode)){
					if($this->hf_requests($ecode)){
						if($this->leave_requests($ecode)){
							if($this->fetch_plrecord($ecode)){
							     if($this->permission($ecode)){
							         //if($this->under_me($ecode)){
							            if($this->nhfhavail($ecode)){
							                return true;
							            }else{
							                echo "nhfhavail -".$ecode;
							            }
							        //} else {
							          //  echo "permission -".$ecode;
							          //  return false;
							       // }
							    } else {
							        echo "reporting to -".$ecode;
							        return false;
							    }
							} else {
							    echo "fetch pl- ".$ecode;
							    return false;
							}
						} else {
						    echo "leave-request -".$ecode;
						    return false;
						}
					} else {
					    echo "hf_request- ".$ecode;
					    return false;
					}
				} else {
				    echo "nhfh- ".$ecode;
				    return false;
				}
			} else{
			    echo "coff- ".$ecode;
			    return false;
			}
	}
	
	
	function permission($ecode){
	    $this->db2 = $this->load->database('sqlsrv',TRUE);
	    $results = $this->db2->query("SELECT p.*,u.Code FROM ".$this->config->item('NEWZ36')."Permission p join ".$this->config->item('NEWZ36')." LoginKRA u on u.EmpCode = p.EmpCode where p.EmpCode = '".$ecode."'")->result_array();
	    
	    if(count($results)>0){
	        $departs = $this->db2->query("SELECT distinct(Dept) as Dept FROM ".$this->config->item('NEWZ36')."LoginKRA where Report1 = '".$ecode."'")->result_array();
	        
	        if(count($departs)>0){ 
    	        $inser_data = array();
    	        foreach($departs as $dept){
    	            $temp = array();
    	            $temp['ecode'] = $ecode;
    	           
    	            if(trim($dept['Dept']) == ''){
    	                continue;
    	            }
    	            if(trim($dept['Dept']) == 'ADMIN'){
    	                $temp['dep_id'] = '1';
    	            } else if(trim($dept['Dept']) == 'BMS'){
    	                $temp['dep_id'] = '2';
    	            } else if(trim($dept['Dept']) == 'CHAIRMAN'){
    	                $temp['dep_id'] = '5';
    	            } else if(trim($dept['Dept']) == 'CITY SALES'){
    	                $temp['dep_id'] = '6';
    	            } else if(trim($dept['Dept']) == 'COO'){
    	                $temp['dep_id'] = '7';
    	            } else if(trim($dept['Dept']) == 'COPY'){
    	                $temp['dep_id'] = '8';
    	            } else if(trim($dept['Dept']) == 'CORPORATE SALES'){
    	                $temp['dep_id'] = '9';
    	            } else if(trim($dept['Dept']) == 'DISTRIBUTION'){
    	                $temp['dep_id'] = '10';
    	            } else if(trim($dept['Dept']) == 'EDITORIAL'){
    	                $temp['dep_id'] = '11';
    	            } else if(trim($dept['Dept']) == 'EMERGING MARKETING'){
    	                $temp['dep_id'] = '12';
    	            } else if(trim($dept['Dept']) == 'FINANCE'){
    	                $temp['dep_id'] = '13';
    	            } else if(trim($dept['Dept']) == 'GOVT. SALES'){
    	                $temp['dep_id'] = '14';
    	            } else if(trim($dept['Dept']) == 'GRAPHICS/ PROMO'){
    	                $temp['dep_id'] = '15';
    	            } else if(trim($dept['Dept']) == 'HUMAN RESOURCE'){
    	                $temp['dep_id'] = '16';
    	            } else if(trim($dept['Dept']) == 'INFORMATION TECHNOLOGY'){
    	                $temp['dep_id'] = '17';
    	            } else if(trim($dept['Dept']) == 'INPUT'){
    	                $temp['dep_id'] = '18';
    	            } else if(trim($dept['Dept']) == 'MARKETING'){
    	                $temp['dep_id'] = '19';
    	            } else if(trim($dept['Dept']) == 'MD'){
    	                $temp['dep_id'] = '20';
    	            } else if(trim($dept['Dept']) == 'MEDIA MONITORING'){
    	                $temp['dep_id'] = '21';
    	            } else if(trim($dept['Dept']) == 'MP SALES'){
    	                $temp['dep_id'] = '22';
    	            } else if(trim($dept['Dept']) == 'OTHERS'){
    	                $temp['dep_id'] = '23';
    	            } else if(trim($dept['Dept']) == 'OUTPUT'){
    	                $temp['dep_id'] = '24';
    	            } else if(trim($dept['Dept']) == 'SOCIAL MEDIA'){
    	                $temp['dep_id'] = '25';
    	            } else if(trim($dept['Dept']) == 'TECHNICAL'){
    	                $temp['dep_id'] = '26';
    	            }
    	            else if(trim($dept['Dept']) == 'OTT'){
    	                $temp['dep_id'] = '27';
    	            }
    	            $temp['created_at'] = date('Y-m-d H:i:s');
    	            $inser_data[] = $temp;
    	        }
    	        $this->db->insert_batch('user_department',$inser_data);
    	        
	        } else {
	            $this->db->insert('user_department',array(
	                'ecode' => $ecode,
	                'dep_id' => $this->my_library->get_employee_department($ecode),
	                'status' => 1,
	                'created_at' => date('Y-m-d H:i:s')
	            ));
	        }
	        
    	    //$this->db->insert('user_rules',array('ecode'=>$ecode,'r_ecode'=>$ecode));
    	    
	        $permission = array();
	        if($results[0]['Code'] == 'H'){
	            $temp = array('link_id'=>29,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>30,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>31,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>32,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>33,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>34,'ecode'=>$ecode);
	            array_push($permission, $temp);
	        }
	        
	        if($results[0]['Leave']){
	            $temp = array('link_id'=>1,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>2,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>3,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>4,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>5,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>6,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>7,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>8,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>9,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>10,'ecode'=>$ecode);
// 	            array_push($permission, $temp);
// 	            $temp = array('link_id'=>11,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>44,'ecode'=>$ecode);
	            array_push($permission, $temp);
	            $temp = array('link_id'=>28,'ecode'=>$ecode);
	            array_push($permission, $temp);
	       }
	       
	       if($results[0]['Sales']){
	           $temp = array('link_id'=>38,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Library']){
	           $temp = array('link_id'=>39,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Appraisal']){
	           $temp = array('link_id'=>40,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['NoticeBoard']){
	           
	       }
	       if($results[0]['NewEvents']){
	           
	       }
	       if($results[0]['Shoot']){
	           $temp = array('link_id'=>41,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Graphics']){
	           
	       }
	       if($results[0]['HR']){
	           $temp = array('link_id'=>18,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>20,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>21,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>22,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>23,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>24,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>25,'ecode'=>$ecode);
	           array_push($permission, $temp);
	           $temp = array('link_id'=>25,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       
	       if($results[0]['Monitoring']){
	           $temp = array('link_id'=>45,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['PCR']){
	           $temp = array('link_id'=>46,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Stringer']){
	           $temp = array('link_id'=>47,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['CAB']){
	           $temp = array('link_id'=>48,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Property']){
	           $temp = array('link_id'=>49,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['SMS']){
	           $temp = array('link_id'=>50,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Vendor']){
	           $temp = array('link_id'=>51,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Store']){
	           $temp = array('link_id'=>52,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['IPL']){
	           $temp = array('link_id'=>53,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['MPLM']){
	           $temp = array('link_id'=>54,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Stationary']){
	           $temp = array('link_id'=>55,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Reporting']){
	           $temp = array('link_id'=>56,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['MCR']){
	           $temp = array('link_id'=>57,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['ITPOLICY']){
	           $temp = array('link_id'=>58,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['Distribution']){
	           $temp = array('link_id'=>59,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['HRAdmin']){
	           $temp = array('link_id'=>11,'ecode'=>$ecode);       // HR management
	           array_push($permission, $temp);
	           $temp = array('link_id'=>12,'ecode'=>$ecode);       // ROSTER
	           array_push($permission, $temp);
	           $temp = array('link_id'=>14,'ecode'=>$ecode);       // EMPLOYEE INFORMATION
	           array_push($permission, $temp);
	           $temp = array('link_id'=>15,'ecode'=>$ecode);       // SALARY SLIP
	           array_push($permission, $temp);
	           $temp = array('link_id'=>16,'ecode'=>$ecode);       // HOLIDAY LIST
	           array_push($permission, $temp);
	       }
	       if($results[0]['Stock']){
	           $temp = array('link_id'=>61,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['livespr']){
	           $temp = array('link_id'=>62,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['channel_distribution']){
	           $temp = array('link_id'=>42,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       if($results[0]['social_media']){
	           $temp = array('link_id'=>43,'ecode'=>$ecode);
	           array_push($permission, $temp);
	       }
	       $this->db->insert_batch('user_links',$permission);
	       return true;
	    }
	}
	
	
	function delete_record($ecode){
		$this->db->where('ecode',$ecode);
		$this->db->delete('users_leave_requests');
		
		$this->db->where('ecode',$ecode);
		$this->db->delete('pl_management');
		
		echo "record deleted successfully.";
	}
}
