  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">ATTENDANCE REPORT</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Attendance</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">ATTENDANCE REGISTER</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
				<form method="GET" action="<?php echo base_url(); ?>emp/es/Attendance">
				  
				  <div class="form-group row">
					<label for="department" class="col-sm-2 col-form-label">Department</label>
					<div class="col-sm-10">
					  <select class="form-control" name="department" id="department">
						<option value="0">Select Department</option>
						<?php 
						foreach($departments as $department){ ?>
							<option value="<?php echo $department['id'];?>" <?php if($department['id'] == $this->session->userdata('department_id')) { echo "selected"; }?>><?php echo $department['dept_name'];?></option>
						<?php } ?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group row">
					<label for="employee" class="col-sm-2 col-form-label">Employee Name</label>
					<div class="col-sm-10">
					  <select class="form-control" name="employee" id="employee">
						<option value="0">Select Employee</option>
						<?php 
							foreach($users as $user){ ?>
								<option value="<?php echo $user['ecode']; ?>" <?php if($user['ecode'] == $this->session->userdata('ecode')) { echo "selected"; }?>><?php echo $user['name']; ?></option>
						<?php } ?>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 col-form-label">Month / Year</label>
					<div class="col-sm-2">
					  <select name="month" id="month" class="form-control">
						<option value="0">Select Month</option>
						<?php $month = $this->input->get('month'); ?>
						<option value="1" <?php if(isset($month)){ if($this->input->get('month') == 1)  echo "selected"; } else { if(date('n') == 1){ echo "selected"; }} ?>>JANUARY</option>
						<option value="2" <?php if(isset($month)){ if($this->input->get('month') == 2)  echo "selected"; } else { if(date('n') == 2){ echo "selected"; }} ?>>FEBRUARY</option>
						<option value="3" <?php if(isset($month)){ if($this->input->get('month') == 3)  echo "selected"; } else { if(date('n') == 3){ echo "selected"; }} ?>>MARCH</option>
						<option value="4" <?php if(isset($month)){ if($this->input->get('month') == 4)  echo "selected"; } else { if(date('n') == 4){ echo "selected"; }} ?>>APRIL</option>
						<option value="5" <?php if(isset($month)){ if($this->input->get('month') == 5)  echo "selected"; } else { if(date('n') == 5){ echo "selected"; }} ?>>MAY</option>
						<option value="6" <?php if(isset($month)){ if($this->input->get('month') == 6)  echo "selected"; } else { if(date('n') == 6){ echo "selected"; }} ?>>JUNE</option>
						<option value="7" <?php if(isset($month)){ if($this->input->get('month') == 7)  echo "selected"; } else { if(date('n') == 7){ echo "selected"; }} ?>>JULY</option>
						<option value="8" <?php if(isset($month)){ if($this->input->get('month') == 8)  echo "selected"; } else { if(date('n') == 8){ echo "selected"; }} ?>>AUGUST</option>
						<option value="9" <?php if(isset($month)){ if($this->input->get('month') == 9)  echo "selected"; } else { if(date('n') == 9){ echo "selected"; }} ?>>SEPTEMBER</option>
						<option value="10" <?php if(isset($month)){ if($this->input->get('month') == 10)  echo "selected"; } else { if(date('n') == 10){ echo "selected"; }} ?>>OCTOBER</option>
						<option value="11" <?php if(isset($month)){ if($this->input->get('month') == 11)  echo "selected"; } else { if(date('n') == 11){ echo "selected"; }} ?>>NOVEMBER</option>
						<option value="12" <?php if(isset($month)){ if($this->input->get('month') == 12)  echo "selected"; } else { if(date('n') == 12){ echo "selected"; }} ?>>DECEMBER</option>
					  </select>
					</div>
					
					<div class="col-sm-2">
					  <select name="year" id="year" class="form-control">
						<option value="0">Select Year</option>
						<?php $year = $this->input->get('year'); ?>
						<option value="2020" <?php if(isset($year)){ if($this->input->get('year') == 2020)  echo "selected"; } else { if(date('Y') == 2020){ echo "selected"; }} ?>>2020</option>
						<option value="2019" <?php if(isset($year)){ if($this->input->get('year') == 2019)  echo "selected"; } else { if(date('Y') == 2019){ echo "selected"; }} ?>>2019</option>
						<option value="2018" <?php if(isset($year)){ if($this->input->get('year') == 2018)  echo "selected"; } else { if(date('Y') == 2018){ echo "selected"; }} ?>>2018</option>
						<option value="2017" <?php if(isset($year)){ if($this->input->get('year') == 2017)  echo "selected"; } else { if(date('Y') == 2017){ echo "selected"; }} ?>>2017</option>
						<option value="2016" <?php if(isset($year)){ if($this->input->get('year') == 2016)  echo "selected"; } else { if(date('Y') == 2016){ echo "selected"; }} ?>>2016</option>
						<option value="2015" <?php if(isset($year)){ if($this->input->get('year') == 2015)  echo "selected"; } else { if(date('Y') == 2015){ echo "selected"; }} ?>>2015</option>
						<option value="2014" <?php if(isset($year)){ if($this->input->get('year') == 2014)  echo "selected"; } else { if(date('Y') == 2014){ echo "selected"; }} ?>>2014</option>
					  </select>
					</div>
				  </div>
				  <fieldset class="form-group">
					<div class="row">
					  <legend class="col-form-label col-sm-2 pt-0"></legend>
					  <div class="col-sm-10">
						<input type="button" id="submit" value="Search" class="btn btn-warning">
						<input type="button" value="Reset" class="btn btn-secondary">
					  </div>
					</div>
				  </fieldset>
				</form>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- general form elements disabled -->
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title"><span id="attendance-heading"></span> SUMMARY REPORT</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  <div class="form-group" id="attendance">
                    
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
	
	fetch_record();
	
	$(document).on('click','#submit',function(){
		fetch_record();
	});
	
	function fetch_record(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'es/Attendance-Record',
			data: {
				'department' : $('#department').val(),
				'employee' : $('#employee').val(),
				'month' : $('#month').val(),
				'year' : $('#year').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					$('#attendance-heading').html($("#month option:selected").text()+'-'+ $("#year option:selected").text());
					var x = '<div class="table-responsive"><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								'<th>DATE</th>'+
								'<th>SHIFT</th>'+
								'<th>IN TIME</th>'+
								'<th>OUT TIME</th>'+
								'<th>LATE ARRIVAL</th>'+
								'<th>HOURS WORKED</th>'+
							'</tr>';
					$.each(response.data,function(key,value){
						x = x +'<tr>'+
									'<td>'+ value.DateOFFICE +'</td>'+
									'<td>'+ value.SHIFT +'</td>'+
									'<td>'+ value.IN1 +'</td>'+
									'<td>'+ value.OUT2 +'</td>'+
									'<td>'+ value.LATEARRIVAL +'</td>'+
									'<td>'+ value.HOURSWORKED +'</td>'+
								'</tr>';
					});
					x = x + '</table></div>';
					$('#attendance').html(x);
				} else {
					$('#attendance').html('<p class="text-center">No record to show.</p>');
				}
			},
			error: function (error) {
				$('#attendance').html('<p class="text-center">No record to show.</p>');
			}
		});	
	}
	
	
	$(document).on('change','#department',function(){
		var dept_id = $(this).val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'Emp_ctrl/get_employee',
			data: {
				'dept_id' : dept_id
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					var x = '<option value="0">Select Employee</option>';
					$.each(response.data,function(key,value){
						x = x + '<option value="'+ value.ecode +'">'+ value.name +'</option>';
					});
					$('#employee').html(x);
				}
			}
		});
	});
});
</script>
</body>