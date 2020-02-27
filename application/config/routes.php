<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';

///emp///////////
$route['dashboard'] = 'Emp_ctrl/index/';
$route['es/leave-request'] = 'Emp_ctrl/leave_request/';
$route['es/hf-leave-request'] = 'Emp_ctrl/hf_leave_request/';
$route['es/hf-leave-request-cancel/(:any)'] = 'Emp_ctrl/hf_leave_request_cancel/$1';
$route['es/off-day-duty-form'] = 'Emp_ctrl/off_day_duty_form/';
$route['es/nh-fh-day-duty-form'] = 'Emp_ctrl/nh_fh_day_duty_form/';
$route['es/Tour-Request-Form'] = 'Emp_ctrl/tour_request_form/';
$route['es/All-Report'] = 'Emp_ctrl/all_report/';
$route['emp/es/NH-FH-Avail-Form'] = 'Emp_ctrl/nh_fh_avail_form/';
$route['emp/es/PL-Summary-Report'] = 'Emp_ctrl/pl_summary_report/';
$route['emp/es/Attendance-Record'] = 'Emp_ctrl/attendance_record/';
$route['es/Attendance-Record'] = 'Emp_ctrl/attendance/';

///hod////////////////
$route['hod/hf_leave_request'] = 'hod/Hod_ctrl/hf_leave_request/';
$route['hod/hf_leave_request/(:any)'] = 'hod/Hod_ctrl/hf_leave_request/$1';
$route['hod/hf_leave_request_update'] = 'hod/Hod_ctrl/hf_leave_request_update';


////HR////////////////
$route['ibc/hr/roster'] = 'Hr_ctrl/roster/';
$route['ibc/hr/HR-Policies'] = 'Hr_ctrl/hr_policies/';
$route['ibc/IT-Policies'] = 'Hr_ctrl/it_policies/';
$route['emp/hr/Emp-Info'] = 'Hr_ctrl/emp_info/';
$route['emp/hr/Salary-Slip'] = 'Hr_ctrl/salary_slip/';
$route['emp/hr/Holiday-List'] = 'Hr_ctrl/holiday_list/';

/////master//////////
$route['master/USER-ROLE'] = 'master/Role_ctrl/index';


$route['master/SHIFT'] = 'master/Shift_ctrl/index';
$route['master/nhfh/create'] = 'master/Nh_fh_ctrl/nhfh_create';
$route['master/nhfh/update'] = 'master/Nh_fh_ctrl/nhfh_update';
$route['master/nhfh/delete'] = 'master/Nh_fh_ctrl/nhfh_delete';

$route['master/NH-FH'] = 'master/Nh_fh_ctrl/index';
$route['master/nhfh/create'] = 'master/Nh_fh_ctrl/nhfh_create';
$route['master/nhfh/update'] = 'master/Nh_fh_ctrl/nhfh_update';
$route['master/nhfh/delete'] = 'master/Nh_fh_ctrl/nhfh_delete';

$route['master/department'] = 'master/Department_ctrl/index';
$route['master/department/list'] = 'master/Department_ctrl/department';
$route['master/department/update'] = 'master/Department_ctrl/department_update';
$route['master/department/create'] = 'master/Department_ctrl/department_create';
$route['master/department/delete'] = 'master/Department_ctrl/department_delete';

$route['master/designation'] = 'master/Designation_ctrl/index';
$route['master/designation/list'] = 'master/Designation_ctrl/designation';
$route['master/designation/update'] = 'master/Designation_ctrl/designation_update';
$route['master/designation/create'] = 'master/Designation_ctrl/designation_create';
$route['master/designation/delete'] = 'master/Designation_ctrl/designation_delete';

$route['master/grade'] = 'master/Grade_ctrl/index';
$route['master/grade/list'] = 'master/Grade_ctrl/grade';
$route['master/grade/update'] = 'master/Grade_ctrl/grade_update';
$route['master/grade/create'] = 'master/Grade_ctrl/grade_create';
$route['master/grade/delete'] = 'master/Grade_ctrl/grade_delete';

$route['master/empcode'] = 'master/Empcode_ctrl/index';
$route['master/empcode/list'] = 'master/Empcode_ctrl/empcode';
$route['master/empcode/update'] = 'master/Empcode_ctrl/empcode_update';
$route['master/empcode/create'] = 'master/Empcode_ctrl/empcode_create';
$route['master/empcode/delete'] = 'master/Empcode_ctrl/empcode_delete';

$route['master/location'] = 'master/Location_ctrl/index';
$route['master/location/list'] = 'master/Location_ctrl/location';
$route['master/location/update'] = 'master/Location_ctrl/location_update';
$route['master/location/create'] = 'master/Location_ctrl/location_create';
$route['master/location/delete'] = 'master/Location_ctrl/location_delete';

$route['master/employee'] = 'master/Employee_ctrl/index';
$route['master/employee/create'] = 'master/Employee_ctrl/create';
$route['master/employee/update/(:any)'] = 'master/Employee_ctrl/update/$1';
$route['master/employee/privileges/(:any)'] = 'master/Employee_ctrl/privileges/$1';
$route['master/employee/(:any)'] = 'master/Employee_ctrl/employee_detail/$1';

$route['translate_uri_dashes'] = FALSE;
