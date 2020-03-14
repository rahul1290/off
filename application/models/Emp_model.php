<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_model extends CI_Model {
	
	function employee($emp_id = null){
		if($emp_id == null) { 
			$this->db->select('ecode,id,name,password,department_id');
			$result = $this->db->get_where('users',array('ecode'=>$data['identity'],'password'=>$data['password'],'status'=>1))->result_array();
			
		} else {
			$this->db->select('ecode,id,name,password,department_id');
			$result = $this->db->get_where('users',array('ecode'=>$emp_id,'status'=>1))->result_array();
		}
		if(count($result) == 1){
			return $result;
		} else {
			return false;
		}
	}
	
	function get_employee($ecode,$dept_id = null){
		$this->db->select('u.ecode,u.id,u.name,u.password,u.department_id');
		$this->db->join('users u','u.ecode = ur.r_ecode');
		if($dept_id != null){
			$this->db->where('u.department_id',$dept_id);
		}
		$result = $this->db->get_where('user_rules ur',array('ur.ecode'=>$ecode,'ur.status'=>1))->result_array();
		return $result;
	}
	
	function attendance($data){
		$db2 = $this->load->database('sqlsrv', TRUE);
		
		$db2->select("tblr.*,convert(varchar, tblr.DateOFFICE, 103) as DateOFFICE,
							ISNULL(substring(CONVERT(VARCHAR,tblr.IN1, 108), 0, 6),'') AS IN1, 
							ISNULL(substring(CONVERT(VARCHAR,tblr.OUT2, 108), 0, 6),'') AS OUT2,
							(CASE WHEN LATEARRIVAL >= 60 THEN
								(SELECT CAST((LATEARRIVAL / 60) AS VARCHAR(2)) + ' HOURS ' +  
										CASE WHEN (LATEARRIVAL % 60) > 0 THEN
											CAST((LATEARRIVAL % 60) AS VARCHAR(2)) + ' MINUTES'
										ELSE
											'0 MINUTES'
										END)
							ELSE 
								CASE WHEN LATEARRIVAL = 0 THEN
									' '
								ELSE	
									CAST((LATEARRIVAL % 60) AS VARCHAR(2)) + ' MINUTES'
								END
							END) as LATEARRIVAL,
							(CASE WHEN HOURSWORKED >= 60 THEN
								(SELECT CAST((HOURSWORKED / 60) AS VARCHAR(2)) + ' HOURS ' +  
										CASE WHEN (HOURSWORKED % 60) > 0 THEN
											CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' MINUTES'
										ELSE
											'0 MINUTES'
										END)
							ELSE 
								CASE WHEN HOURSWORKED = 0 THEN
									' '
								ELSE	
									CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' MINUTES'
								END
							END) as HOURSWORKED");
		//$this->db->join($this->config->item('NEWZ36').'LoginKRA l','l.PAYCODE = tblr.PAYCODE');
		$db2->where(array('tblr.DateOFFICE >='=>$data['from_date'],'tblr.DateOFFICE <'=>$data['to_date']));
		$result = $db2->get_where($this->config->item('Savior').'tblTimeRegister tblr',array('tblr.PAYCODE'=>$data['paycode']))->result_array();
		return $result;
	}
	
	function day_attendance($nhfhdate,$emp_paycode){
		$db2 = $this->load->database('sqlsrv', TRUE);
		$db2->select("PRESENTVALUE,
						ISNULL(substring(CONVERT(VARCHAR,IN1, 108), 0, 6),'') AS IN1, 
						ISNULL(substring(CONVERT(VARCHAR,OUT2, 108), 0, 6),'') AS OUT2,
						(CASE WHEN HOURSWORKED >= 60 THEN
								(SELECT CAST((HOURSWORKED / 60) AS VARCHAR(2)) + ' Hours ' +  
										CASE WHEN (HOURSWORKED % 60) > 0 THEN
											CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' Minutes'
										ELSE
											'0 Minutes'
										END)
							ELSE 
								CASE WHEN HOURSWORKED = 0 THEN
									' '
								ELSE	
									CAST((HOURSWORKED % 60) AS VARCHAR(2)) + ' Minutes'
								END
							END) as HOURSWORKED"
					);
		$result = $db2->get_where($this->config->item('Savior').'tblTimeRegister',array('DateOFFICE'=>$nhfhdate,'PAYCODE'=>$emp_paycode))->result_array();
		return $result; 
	}
	
	
	function leave_requests($ecode){
        return $this->db->query('SELECT p.*, date_format(p.created_at, "%d/%m/%Y %H:%i:%s") as created_at, date_format(p.date_from, "%d/%m/%Y") as date_from, date_format(p.date_to, "%d/%m/%Y") as date_to,
                			(select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("NH_FH")) as NHFH,
                            (select GROUP_CONCAT(c.date_from) from users_leave_requests c WHERE c.request_id = p.refrence_id and c.request_type in ("OFF_DAY")) as COFF
                FROM users_leave_requests p
                WHERE p.request_type = "LEAVE"
                AND p.ecode = "'.$ecode.'"
                AND p.status = 1')->result_array();
	}
	
	
	/*
	function emp(){
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
	*/ 
}