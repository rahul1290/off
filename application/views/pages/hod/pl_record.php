  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">PL RECORD</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HOD section</a></li>
						<li class="breadcrumb-item active">PL record</li>
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
                <h3 class="card-title">PL RECORD</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
				<form method="GET" action="<?php echo base_url(); ?>emp/es/PL-Summary-Report">
				  
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
				  
				  <fieldset class="form-group">
					<div class="row">
					  <legend class="col-form-label col-sm-2 pt-0"></legend>
					  <div class="col-sm-10">
						<input type="button" id="submit" value="View" class="btn btn-warning">
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
                <h3 class="card-title"><span id="plsummary-heading"></span> SUMMARY REPORT</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  <div class="form-group" id="plsummary">
                    
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
	//get_employee();
	function get_employee(){
		var dept_id = $('#department').val();
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
	}
	
	$(document).on('change','#department',function(){
		get_employee();	
	});


	$(document).on('click','#submit',function(){

		var dept_id = $('#department').val();
		var employee = $('#employee').val(); 
		
		$.ajax({
			type: 'POST',
			url: baseUrl+'es/PL-Summary-Report',
			data: {
				'department' : dept_id,
				'employee' : employee
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
			//	console.log()
			}
		});	
	});
});
</script>
</body>