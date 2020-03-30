 <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Create</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('master/employee');?>">Employee List</a></li>
						<li class="breadcrumb-item active">Employee Create</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="col-12">
            <form name="f1" method="POST" action="<?php echo base_url('master/employee/create'); ?>">
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-info pl-2">Official Details</legend>
					<div class="form-group col-md-2">
						<label for="ecode"><span class="text-danger pr-1">*</span>Employee Code</label>
						<input type="text" class="form-control" id="ecode" name="ecode" placeholder="Enter Employee Code" value="<?php if(set_value('ecode') != '') { echo set_value('ecode'); } else { echo 'SBMMPL-0'; } ?>">
						<?php echo form_error('ecode'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="pay_code"><span class="text-danger pr-1">*</span>Paycode</label>
						<input type="text" class="form-control" id="pay_code" name="pay_code" placeholder="Enter Pay-Code" value="<?php echo set_value('pay_code'); ?>">
						<?php echo form_error('pay_code'); ?>
					</div>
					<div class="form-group col-md-3">
						<label for="employee_name"><span class="text-danger pr-1">*</span>Employee Name</label>
						<input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Enter Employee Name" value="<?php echo set_value('employee_name'); ?>">
						<?php echo form_error('employee_name'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="password"><span class="text-danger pr-1">*</span>Password</label>
						<input type="text" class="form-control" name="password" id="password" placeholder="Enter password for Employee" value="<?php echo set_value('password'); ?>">
						<?php echo form_error('password'); ?>
					</div>
					<div class="form-group col-md-3">
						<label for="department"><span class="text-danger pr-1">*</span>Department</label>
						<select class="form-control" name="department" id="department">
							<option value="0">Select Department</option>
							<?php foreach($departments as $department){ ?>
								<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == set_value('department')){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
							<?php } ?>
						</select>
						<?php echo form_error('department'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="department"><span class="text-danger pr-1">*</span>Designation</label>
						<select class="form-control" name="designation" id="designation">	
							<option value="0">Select Designation</option>
						<?php foreach($designations as $designation){ ?>
								<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == set_value('designation')){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
							<?php } ?>
						</select>
						<?php echo form_error('designation'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Location</label>
						<select name="location" id="location" class="form-control">
							<option value="0">Select location</option>
							<?php foreach($locations as $location){ ?>
								<option value="<?php echo $location['id']; ?>" <?php if(set_value('location') == $location['id']){ echo "selected"; }?>><?php echo $location['name']; ?></option>
							<?php } ?>
						</select>
						<?php echo form_error('location'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Gender</label>
						<select name="gender" id="gender" class="form-control">
							<option value="MALE" <?php if($designation['id'] == set_value('gender')){ echo "selected"; } ?>>MALE</option>
							<option value="FEMALE" <?php if($designation['id'] == set_value('gender')){ echo "selected"; } ?>>FEMALE</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Joining Date</label>
						
						<input type="text" class="form-control datepicker" id="jdate" name="jdate" value="<?php echo set_value('jdate'); ?>">
						<?php echo form_error('jdate'); ?>
					</div>
					
					
					<div class="form-group col-md-2">
						<label for="empcode"><span class="text-danger pr-1">*</span>Code</label>
						<select name="empcode" class="form-control" id="empcode">
							<option value="0">Select Code</option>
							<?php foreach($empcodes as $empcode){ ?>
								<option value="<?php echo $empcode['id']; ?>" <?php if($empcode['id'] == set_value('empcode')){ echo "selected"; } ?>><?php echo $empcode['ecode_name']; ?></option>
							<?php } ?>
						</select>
						<?php echo form_error('empcode'); ?>
					</div>
					<div class="form-group col-md-2">
						<label for="employee_code"><span class="text-danger pr-1">*</span>Grade</label>
						<select name="grade" class="form-control" id="grade">
							<option value="0">Select Grade</option>
							<?php foreach($grades as $grade){ ?>
								<option value="<?php echo $grade['id']; ?>" <?php if($grade['id'] == set_value('grade')){ echo "selected"; } ?>><?php echo $grade['grade_name']; ?></option>
							<?php } ?>
						</select>
						<?php echo form_error('grade'); ?>
					</div>
					
					<span class="col-md-12"><b>Reporting To</b></span>
						<div class="form-group col-md-2">
							<select class="form-control" name="repto_department" id="repto_department">	
								<option value="0">Select Department</option>
								<?php foreach($departments as $department){ ?>
									<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == set_value('repto_department')){ echo "selected"; } ?>><?php echo $department['dept_name']; ?>( <?php echo $department['dept_code']; ?> )</option>
								<?php } ?>							
							</select>
							<?php echo form_error('repto_department'); ?>
						</div>
						
						<div class="form-group col-md-2">
							<select class="form-control" name="repto_designation" id="repto_designation">	
								<option value="0">Select Designation</option>
							<?php foreach($designations as $designation){ ?>
									<option value="<?php echo $designation['id']; ?>" <?php if($designation['id'] == set_value('repto_designation')){ echo "selected"; } ?>><?php echo $designation['desg_name']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('repto_designation'); ?>
						</div>
				</div>
				
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-info pl-2">Employee Info</legend>
					
					<div class="form-group col-md-2">
						<label for="contactno">Contact No.</label>
						<input type="text" name="contactno" class="form-control" placeholder="Enter Contact no." value="<?php echo set_value('contactno'); ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="alternetno">Alternet No.</label>
						<input type="text" name="alternetno" class="form-control" placeholder="Enter Alternet Contact no." value="<?php echo set_value('alternetno'); ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="employee_dob">DOB</label>
						<input type="text" name="employee_dob" class="form-control datepicker" value="<?php echo set_value('employee_dob'); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="personal_mail">Personal Mail-ID</label>
						<input type="text" name="personal_mail" class="form-control" placeholder="Enter Employee mailId" value="<?php echo set_value('personal_mail'); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="company_mail"><span class="text-danger pr-1">*</span>Company Mail-ID</label>
						<input type="text" name="company_mail" class="form-control" placeholder="Enter Company mailID" value="<?php echo set_value('company_mail'); ?>">
						<?php echo form_error('company_mail'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="employee_name">Address</label>
						<textarea class="form-control" name="address" id="address"><?php echo set_value('address'); ?></textarea>
					</div>
					
					<div class="custom-file mb-2 ml-2 mr-2">
					  <input type="file" class="custom-file-input" id="customFile">
					  <label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				
				<div class="form-row mb-3" style="border: solid 1px #123456;">
					<legend class="the-legend bg-info pl-2">Other Info</legend>
					
					<div class="form-group col-md-6">
						<label for="father_name">Father Name</label>
						<input type="text" name="father_name" id="father_name" class="form-control" placeholder="Enter Father Name" value="<?php echo set_value('father_name'); ?>"> 
					</div>
					<div class="form-group col-md-6">
						<label for="father_dob">Father's DOB</label>
						<input type="text" id="father_dob" name="father_dob" class="form-control datepicker" value="<?php echo set_value('father_dob'); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="mother_name">Mother Name</label>
						<input type="text" id="mother_name" name="mother_name" class="form-control" placeholder="Enter Mother Name" value="<?php echo set_value('mother_name'); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="mother_dob">Mother's DOB</label>
						<input type="text" id="mother_dob" name="mother_dob" class="form-control datepicker" value="<?php echo set_value('mother_dob'); ?>">
					</div>
					<div class="form-group col-md-12">
						<label>Marital Status</label>
						<select name="marital" id="marital" class="form-control">
							<option value="NO" <?php if(set_value('marital') == 'NO') { echo "selected"; }?>>NO</option>
							<option value="YES" <?php if(set_value('marital') == 'YES') { echo "selected"; }?>>YES</option>
						</select>
					</div>
					
					<div class="row col-md-12" id="family_detail" style="display:<?php if(set_value('marital') == 'YES') { echo "contents"; } else {  echo "none"; }?>">
						<div class="form-group col-md-4">
							<label>Spouse Name</label>
							<input type="text" name="spouse_name" class="form-control" id="spouse_name" placeholder="Enter Spouse Name">
						</div>
						<div class="form-group col-md-4">
							<label>Anniversary</label>
							<input type="text" name="anniversary" class="form-control datepicker" id="anniversary" value="<?php echo set_value('anniversary');?>">
						</div>
						<div class="form-group col-md-4">
							<label>childrens</label>
							<select name="childrens" id="childrens" class="form-control">
								<option value="0" <?php if(set_value('childrens')==0){ echo "selected"; }?>>0</option>
								<option value="1" <?php if(set_value('childrens')==1){ echo "selected"; }?>>1</option>
								<option value="2" <?php if(set_value('childrens')==2){ echo "selected"; }?>>2</option>
								<option value="3" <?php if(set_value('childrens')==3){ echo "selected"; }?>>3</option>
							</select>
						</div>
					</div>
					
					<div class="row col-md-12" id="fcchild_detail" style="display:<?php if(set_value('childrens') > 0 && (set_value('marital') == 'YES')) { echo "contents"; } else { echo "none"; }?>">
						<div class="form-group col-md-4">
							<label>Child Name</label>
							<input type="text" name="f_child_name" class="form-control" id="f_child_name" placeholder="Enter First Child Name" value="<?php echo set_value('f_child_name');?>">
							<?php echo form_error('f_child_name'); ?>
						</div>
						<div class="form-group col-md-4">
							<label>Gender</label>
							<select class="form-control" name="fcgender" id="fcgender">
								<option value="MALE" <?php if(set_value('fcgender') == 'MALE'){ echo "selected"; }?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('fcgender') == 'FEMALE'){ echo "selected"; }?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>DOB</label>
							<input type="text" name="fcdob" class="form-control datepicker" value="<?php echo set_value('fcdob'); ?>">
						</div>
					</div>
					<div class="row col-md-12" id="scchild_detail" style="display:<?php if(set_value('childrens') > 1 && (set_value('marital') == 'YES')) { echo "contents"; } else { echo "none"; }?>">
						<div class="form-group col-md-4">
							<input type="text" name="s_child_name" class="form-control" id="s_child_name" placeholder="Enter second Child Name" value="<?php echo set_value('s_child_name'); ?>">
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="scgender" id="scgender">
								<option value="MALE" <?php if(set_value('scgender') == 'MALE'){ echo "selected"; }?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('scgender') == 'FEMALE'){ echo "selected"; }?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="scdob" class="form-control datepicker" value="<?php echo set_value('scdob'); ?>">
							
						</div>
					</div>
					<div class="row col-md-12" id="tcchild_detail" style="display:<?php if(set_value('childrens') > 2 && (set_value('marital') == 'YES')) { echo "contents"; } else { echo "none"; }?>;">
						<div class="form-group col-md-4">
							<input type="text" name="t_child_name" class="form-control" id="t_child_name" placeholder="Enter Third Child Name" value="<?php echo set_value('t_child_name'); ?>">
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="tcgender" id="tcgender">
								<option value="MALE" <?php if(set_value('tcgender') == 'MALE') { echo "selected"; }?>>MALE</option>
								<option value="FEMALE" <?php if(set_value('tcgender') == 'FEMALE') { echo "selected"; }?>>FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="tcdob" class="form-control datepicker" value="<?php echo set_value('tcdob'); ?>">
						</div>
					</div>
					
				</div>
				
				<button type="submit" class="btn btn-success">Create</button>
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
	
	$(document).on('blur','#ecode',function(){
		var ecode = $(this).val();
		if(ecode != ''){ 
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/Employee_ctrl/is_unique_ecode',
				data: { 
					'ecode' : ecode,
				},
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					console.log(response);
					if(response.status == 200){
						console.log('ecode is unique');
						$('#ecode').addClass('success');
						$('#ecode').removeClass('error');
					} else {
						$('#ecode').focus();
						$('#ecode').addClass('error');
						$('#ecode').removeClass('success');
					}
				}
			});
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