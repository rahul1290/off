 <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Update</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('master/employee');?>">Employee List</a></li>
						<li class="breadcrumb-item active">Employee Update</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="offset-md-1 col-md-10">
			<?php echo $this->session->flashdata('msg');?>
            <form name="f1" method="POST" action="<?php echo base_url('master/employee/update/'.$employee_detail[0]['Ecode']); ?>" enctype="multipart/form-data">
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-dark pl-2">Official Details</legend>
					<div class="form-group col-md-2">
						<label for="ecode"><span class="text-danger pr-1">*</span>Employee Code</label>
						<input type="text" class="form-control" id="ecode" name="ecode" placeholder="Enter Employee Code" value="<?php if(set_value('ecode') != '') { echo set_value('ecode'); } else { echo $employee_detail[0]['Ecode']; } ?>">
						<?php echo form_error('ecode'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="pay_code"><span class="text-danger pr-1">*</span>Paycode</label>
						<input type="text" class="form-control" id="pay_code" name="pay_code" placeholder="Enter Pay-Code" value="<?php if(set_value('pay_code') != '') { echo set_value('pay_code'); } else { echo $employee_detail[0]['paycode']; } ?>">
						<?php echo form_error('pay_code'); ?>
					</div>
					<div class="form-group col-md-3">
						<label for="employee_name"><span class="text-danger pr-1">*</span>Employee Name</label>
						<input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Enter Employee Name" value="<?php if(set_value('employee_name') != '') { echo set_value('employee_name'); } else { echo $employee_detail[0]['name']; } ?>">
						<?php echo form_error('employee_name'); ?>
					</div>
					<div class="form-group col-md-3">
						<label for="department"><span class="text-danger pr-1">*</span>Department</label>
						<select class="form-control" name="department" id="department">
							<option value="0">Select Department</option>
							<?php foreach($departments as $department){ ?>
								<?php if(set_value('department')){ ?>
									<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == set_value('department')){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
								<?php } else { ?>
									<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $employee_detail[0]['department_id']){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('department'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="department"><span class="text-danger pr-1">*</span>Designation</label>
						<select class="form-control" name="designation" id="designation">	
							<option value="0">Select Designation</option>
						<?php foreach($designations as $designation){ ?>
								<?php if(set_value('designation')){ ?>
									<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == set_value('designation')){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == $employee_detail[0]['designation_id']){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('designation'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Location</label>
						<select name="location" id="location" class="form-control">
							<option value="0">Select location</option>
							<?php foreach($locations as $location){ ?>
								<?php if(set_value('location')){ ?>
									<option value="<?php echo $location['id']; ?>" <?php if($location['id'] == set_value('location')){ echo "selected"; }?>><?php echo $location['name']; ?></option>
								<?php } else { ?> 
									<option value="<?php echo $location['id']; ?>" <?php if($location['id'] == $employee_detail[0]['location_id']){ echo "selected"; }?>><?php echo $location['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('location'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Gender</label>
						<select name="gender" id="gender" class="form-control">
							<option value="MALE" <?php if(set_value('gender')){ if('MALE' == set_value('gender')){ echo "selected"; } } else { if('MALE' == $employee_detail[0]['gender']){ echo "selected"; }} ?>>MALE</option>
							<option value="FEMALE" <?php if(set_value('gender')){ if('FEMALE' == set_value('gender')){ echo "selected"; } } else { if('FEMALE' == $employee_detail[0]['gender']){ echo "selected"; }} ?>>FEMALE</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Joining Date</label>
						<input type="text" name="jdate" id="jdate" class="form-control datepicker" value="<?php if(set_value('jdate')){ echo set_value('jdate');} else { echo $this->my_library->sql_datepicker($employee_detail[0]['jdate']); } ?>">
						<?php echo form_error('jdate'); ?>
					</div>
					
					
					<div class="form-group col-md-2">
						<label for="empcode"><span class="text-danger pr-1">*</span>Code</label>
						<select name="empcode" class="form-control" id="empcode">
							<option value="0">Select Code</option>
							
							<?php foreach($empcodes as $empcode){ ?>
								<?php if(set_value('empcode')){ ?>
									<option value="<?php echo $empcode['id']; ?>" <?php if($empcode['ecode_name'] == set_value('empcode')){ echo "selected"; } ?>><?php echo $empcode['ecode_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $empcode['id']; ?>" <?php if($empcode['id'] == $employee_detail[0]['code_id']){ echo "selected"; } ?>><?php echo $empcode['ecode_name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('empcode'); ?>
					</div>
					
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Grade</label>
						<select name="grade" class="form-control" id="grade">
							<option value="0">Select Grade</option>
							<?php foreach($grades as $grade){ ?>
								<?php if(set_value('grade')){ ?>
									<option value="<?php echo $grade['id']; ?>" <?php if($grade['id'] == set_value('grade')){ echo "selected"; } ?>><?php echo $grade['grade_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $grade['id']; ?>" <?php if($grade['id'] == $employee_detail[0]['grade_id']){ echo "selected"; } ?>><?php echo $grade['grade_name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('grade'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code">Reporting To Department</label>
						<select name="repto_department" class="form-control" id="repto_department">
							<option value="0">Select Department</option>
							<?php foreach($departments as $department){ ?>
								<?php if(set_value('department')){ ?>
									<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == set_value('repto_department')){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
								<?php } else { ?>
									<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $employee_detail[0]['report_to_dept']){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code">Reporting To Designation</label>
						<select name="repto_designation" class="form-control" id="repto_designation">
							<option value="0">Select Designation</option>
							<?php foreach($designations as $designation){ ?>
								<?php if(set_value('designation')){ ?>
									<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == set_value('designation')){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == $employee_detail[0]['report_to_desg']){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-dark pl-2">Employee Info</legend>
					
					<div class="form-group col-md-2">
						<label for="contactno">Contact No.</label>
						<input type="text" name="contactno" class="form-control" placeholder="Enter Contact no." value="<?php if(set_value('contactno') != '') { echo set_value('contactno'); } else { echo $employee_detail[0]['contact_no']; } ?>">
					</div>
					
					<div class="form-group col-md-2">
						<label for="alternetno">Alternet No.</label>
						<input type="text" name="alternetno" class="form-control" placeholder="Enter Alternet Contact no." value="<?php if(set_value('alternetno') != '') { echo set_value('alternetno'); } else { echo $employee_detail[0]['alternet_no']; } ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="employee_dob">DOB</label>
						<input type="text" name="employee_dob" class="form-control datepicker" value="<?php if(set_value('employee_dob') != '') { echo set_value('employee_dob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['dob']); } ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="personal_mail">Personal Mail-ID</label>
						<input type="text" name="personal_mail" class="form-control" placeholder="Enter Employee mailId" value="<?php if(set_value('personal_mail') != '') { echo set_value('personal_mail'); } else { echo $employee_detail[0]['personal_mailid']; } ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="company_mail"><span class="text-danger pr-1">*</span>Company Mail-ID</label>
						<input type="text" name="company_mail" class="form-control" placeholder="Enter Company mailID" value="<?php if(set_value('company_mail') != '') { echo set_value('company_mail'); } else { echo $employee_detail[0]['company_mailid']; } ?>">
						<?php echo form_error('company_mail'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="employee_name">Address</label>
						<textarea class="form-control" name="address" id="address"><?php if(set_value('address') != '') { echo set_value('address'); } else { echo $employee_detail[0]['address']; } ?></textarea>
					</div>
					
					<div class="text-center mb-2 ml-2" style="width: 200px; height:200px; border:solid black 2px;">
						<img src="<?php echo base_url().$this->config->item('img_url').$employee_detail[0]['image'];?>" width="200px;" height="200px;" />
					</div>
					
					<div class="customFile mb-2 ml-2 mr-2">
					  <input type="file" class="" name="customFile" id="customFile">
					  <label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-dark pl-2">Other Info</legend>
					
					<div class="form-group col-md-6">
						<label for="father_name">Father Name</label>
						<input type="text" name="father_name" id="father_name" class="form-control" placeholder="Enter Father Name" value="<?php if(set_value('father_name') != '') { echo set_value('father_name'); } else { echo $employee_detail[0]['father_name']; } ?>"> 
					</div>
					<div class="form-group col-md-6">
						<label for="father_dob">Father's DOB</label>
						<input type="text" id="father_dob" name="father_dob" class="form-control datepicker" value="<?php if(set_value('father_dob') != '') { echo set_value('father_dob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['fdob']); } ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="mother_name">Mother Name</label>
						<input type="text" id="mother_name" name="mother_name" class="form-control" placeholder="Enter Mother Name" value="<?php if(set_value('mother_name') != '') { echo set_value('mother_name'); } else { echo $employee_detail[0]['mother_name']; } ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="mother_dob">Mother's DOB</label>
						<input type="text" id="mother_dob" name="mother_dob" class="form-control datepicker" value="<?php if(set_value('mother_dob') != '') { echo set_value('mother_dob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['mdob']); } ?>">
					</div>
					<div class="form-group col-md-12">
						<label>Marital Status</label>
						<select name="marital" id="marital" class="form-control">
							<option value="NO" <?php if(set_value('marital')){ if('NO' == set_value('marital')){ echo "selected"; } } else { if('NO' == $employee_detail[0]['marital_status']){ echo "selected"; }} ?>>NO</option>
							<option value="YES" <?php if(set_value('marital')){ if('YES' == set_value('marital')){ echo "selected"; } } else { if('YES' == $employee_detail[0]['marital_status']){ echo "selected"; }} ?>>YES</option>
						</select>
					</div>
					
					<div class="row col-md-12" id="family_detail" style="display:<?php if(set_value('marital') == 'YES' || $employee_detail[0]['marital_status'] == 'YES') { echo "contents"; } else {  echo "none"; }?>">
						<div class="form-group col-md-4">
							<label>Spouse Name</label>
							<input type="text" name="spouse_name" class="form-control" id="spouse_name" placeholder="Enter Spouse Name" value="<?php if(set_value('spouse_name') != '') { echo set_value('spouse_name'); } else { echo $employee_detail[0]['spouse_name']; } ?>">
						</div>
						<div class="form-group col-md-4">
							<label>Anniversary</label>
							<input type="text" name="anniversary" class="form-control datepicker" id="anniversary" value="<?php if(set_value('anniversary') != '') { echo set_value('anniversary'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['anniversary']); } ?>">
						</div>
						<div class="form-group col-md-4">
							<label>childrens</label>
							<select name="childrens" id="childrens" class="form-control">
								<option value="0" <?php if(set_value('childrens')==0 || $employee_detail[0]['children'] == 0){ echo "selected"; }?>>0</option>
								<option value="1" <?php if(set_value('childrens')==1 || $employee_detail[0]['children'] == 1){ echo "selected"; }?>>1</option>
								<option value="2" <?php if(set_value('childrens')==2 || $employee_detail[0]['children'] == 2){ echo "selected"; }?>>2</option>
								<option value="3" <?php if(set_value('childrens')==3 || $employee_detail[0]['children'] == 3){ echo "selected"; }?>>3</option>
							</select>
						</div>
					</div>
					
					<div class="row col-md-12" id="fcchild_detail" style="display:<?php if(set_value('childrens') > 0 || $employee_detail[0]['children'] > 0 || set_value('marital') == 'YES') { echo "contents"; } else { echo "none"; }?>">
						<div class="form-group col-md-4">
							<label>Child Name</label>
							<input type="text" name="f_child_name" class="form-control" id="f_child_name" placeholder="Enter First Child Name" value="<?php if(set_value('f_child_name') != '') { echo set_value('f_child_name'); } else { echo $employee_detail[0]['child1_name']; } ?> <?php echo set_value('f_child_name');?>">
							<?php echo form_error('f_child_name'); ?>
						</div>
						<div class="form-group col-md-4">
							<label>Gender</label>
							<select class="form-control" name="fcgender" id="fcgender">
								<option value="MALE" <?php if(set_value('fcgender')){ if('MALE' == set_value('fcgender')){ echo "selected"; } } else { if('MALE' == $employee_detail[0]['child1_gender']){ echo "selected"; }} ?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('fcgender')){ if('FEMALE' == set_value('fcgender')){ echo "selected"; } } else { if('FEMALE' == $employee_detail[0]['child1_gender']){ echo "selected"; }} ?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>DOB</label>
							<input type="text" name="fcdob" class="form-control datepicker" value="<?php if(set_value('fcdob') != '') { echo set_value('fcdob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['child1_dob']); } ?>">
						</div>
					</div>
					<div class="row col-md-12" id="scchild_detail" style="display:<?php if(set_value('childrens') > 1 || $employee_detail[0]['children'] > 1 || set_value('marital') == 'YES') { echo "contents"; } else { echo "none"; }?>">
						<div class="form-group col-md-4">
							<input type="text" name="s_child_name" class="form-control" id="s_child_name" placeholder="Enter second Child Name" value="<?php if(set_value('s_child_name') != '') { echo set_value('s_child_name'); } else { echo $employee_detail[0]['child2_name']; } ?> <?php echo set_value('s_child_name');?>">
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="scgender" id="scgender">
								<option value="MALE" <?php if(set_value('scgender')){ if('MALE' == set_value('scgender')){ echo "selected"; } } else { if('MALE' == $employee_detail[0]['child2_gender']){ echo "selected"; }} ?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('scgender')){ if('FEMALE' == set_value('scgender')){ echo "selected"; } } else { if('FEMALE' == $employee_detail[0]['child2_gender']){ echo "selected"; }} ?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="scdob" class="form-control datepicker" value="<?php if(set_value('scdob') != '') { echo set_value('scdob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['child2_dob']); } ?>">
						</div>
					</div>
					
					<div class="row col-md-12" id="tcchild_detail" style="display:<?php if(set_value('childrens') > 2 || $employee_detail[0]['children'] > 2 || set_value('marital') == 'YES') { echo "contents"; } else { echo "none"; }?>;">
						<div class="form-group col-md-4">
							<input type="text" name="t_child_name" class="form-control" id="t_child_name" placeholder="Enter Third Child Name" value="<?php if(set_value('t_child_name') != '') { echo set_value('t_child_name'); } else { echo $employee_detail[0]['child3_name']; } ?> <?php echo set_value('t_child_name');?>">
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="tcgender" id="tcgender">
								<option value="MALE" <?php if(set_value('tcgender')){ if('MALE' == set_value('tcgender')){ echo "selected"; } } else { if('MALE' == $employee_detail[0]['child3_gender']){ echo "selected"; }} ?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('tcgender')){ if('FEMALE' == set_value('tcgender')){ echo "selected"; } } else { if('FEMALE' == $employee_detail[0]['child3_gender']){ echo "selected"; }} ?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="tcdob" class="form-control datepicker" value="<?php if(set_value('tcdob') != '') { echo set_value('tcdob'); } else { echo $this->my_library->sql_datepicker($employee_detail[0]['child3_dob']); } ?>">
						</div>
					</div>
					
				</div>
				
				<button type="submit" class="btn btn-success">Update</button>
				<input type="reset" class="btn btn-secondary" name="cancel" value="cancel">
			</form>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  
  <?php 
	$notePad = isset($notepad) ? $notepad : ''; 
	print_r($notePad);
  ?>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php 
	$footer = isset($footer) ? $footer : ''; 
	print_r($footer);
  ?>
</div>

<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	$(document).on('change','#marital',function(){
		if($(this).val() == 'YES'){
			$('#family_detail').css('display','contents');
		} else {
			$('#family_detail').css('display','none');
		}
	});
	
	$(document).on('change','#childrens',function(){
		var childs = $(this).val();
		if(childs == 1){
			$('#fcchild_detail').css('display','contents');
			$('#scchild_detail').css('display','none');
			$('#tcchild_detail').css('display','none');
		}
		else if(childs == 2){
			$('#fcchild_detail').css('display','contents');
			$('#scchild_detail').css('display','contents');
			$('#tcchild_detail').css('display','none');
		}
		else if(childs == 3){
			$('#fcchild_detail').css('display','contents');
			$('#scchild_detail').css('display','contents');
			$('#tcchild_detail').css('display','contents');
		}
	});
	
});
</script>
</body>