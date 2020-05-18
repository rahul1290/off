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
    }
	
	
	function employee(){
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
			$data['report_to'] = $this->session->userdata('ecode');
			$data['jdate'] = $r['JDate'];
			$data['company_id'] = $r['Company'];
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('ecode');
			$data['code_id'] = $r['Code'];
			$insert_data[] = $data;
		}
		
		if($this->db->insert_batch('users',$insert_data)){
			echo "data inserted";
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
										when (Grade = 'M 1') then '6'
										when (Grade = 'M1') then '7'
										when (Grade = 'M-3') then '8'
										when (Grade = 'M-4') then '9'
										when (Grade = 'M-5') then '10'
										when (Grade = 'M2') then '11'
										when (Grade = 'M4') then '12'
										when (Grade = 'M-6') then '13'
										when (Grade = 'M5') then '14'
									END) as Grade,
									Gender,
									(case when (Gender = 'Male') then 'MALE' 
										  when (Gender = 'Female') then 'FEMALE'	
									END) as Gender,
									BDay,
									ReportTo,
									JDate,
									Code,
									(case when (Company ='S. B. MULTIMEDIA PVT. LTD.') then '1' else 'NULL' END) as Company
									FROM [NEWZ36].[dbo].[LoginKRA] where Code <> 'NA'")->result_array();
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
		$results = $this->db2->query("SELECT * FROM [NEWZ36].[dbo].[OffTbl] where EmpCode = '".$ecode."'")->result_array();
		
		$insert_record = array();
		foreach($results as $result){
			$temp = array();
			$temp['request_type'] = 'OFF_DAY';
			$temp['refrence_id'] = $result['ID'];
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
	}
	
	function leave_requests($ecode){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		$results = $this->db2->query("SELECT * FROM [NEWZ36].[dbo].[ITDLeaveRequest] where Emp_Code = '".$ecode."' order by App_Date desc")->result_array();
		$insert_record = array();
		foreach($results as $result){
			$temp = array();
			$temp['request_type'] = 'LEAVE';
			$temp['refrence_id'] = $result['Emp_Req_No'];
			$temp['ecode'] = $result['Emp_Code'];
			$temp['requirment'] = $result['LReason'];
			$temp['date_from'] = $result['Leave_From'];
			$temp['date_to'] = $result['Leave_to'];
			$temp['hod_remark'] = $result['HOD_Remarks'];
			$temp['hod_status'] = $result['HOD_Approval'];
			$temp['hod_id'] = '';
			$string = $result['OFF_Taken'];
			
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
					$this->db->where(array('ecode'=>$ecode,'request_type'=>'OFF_DAY','date_from'=>date('Y-d-m',strtotime($coff)),'status'=>1));
					$this->db->update('users_leave_requests',array('request_id'=>$result['Emp_Req_No']));
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
	}
	
	function hf_requests($ecode){
	$this->db2 = $this->load->database('sqlsrv',TRUE);
	$results = $this->db2->query("SELECT * FROM [NEWZ36].[dbo].[HalfDayLeave] where EmpCode = '".$ecode."'")->result_array();
	$insert_record = array();
		foreach($results as $result){
			$temp['request_type'] = 'HALF';
			$temp['refrence_id'] = $result['ID'];
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
	}
	
	function nhfh_day_duty($ecode){
		$this->db2 = $this->load->database('sqlsrv',TRUE);
		$results = $this->db2->query("SELECT * FROM [NEWZ36].[dbo].[NHFHDetail] where EmpCode = '".$ecode."'")->result_array();
		$insert_record = array();
		foreach($results as $result){
			$temp['request_type'] = 'NH_FH';
			$temp['refrence_id'] = $result['ID'];
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
	}
	
	
	function import_records($ecode){
		$this->db->trans_begin();
		
			if($this->coff_requests($ecode)){
				if($this->nhfh_day_duty($ecode)){
					if($this->hf_requests($ecode)){
						if($this->leave_requests($ecode)){
							if($this->fetch_plrecord($ecode)){
							}
						}
					}
				}
			}
			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo $ecode." Something went wrong."; 
		} else {
			$this->db->trans_commit();
			echo $ecode." Record imported successfully."; 
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
