<?php if(!isset($pls[0]['balance'])){ 
	$pls[0]['balance'] = 0;
}?>
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">PL SUMMARY REGISTER</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">PL SUMMARY</li>
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
                <span class="card-title">PL SUMMARY REGISTER</span>
                <span class="float-right">Current Remaining Pl's : <?php echo $pls[0]['balance']; ?></span>
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
	
	fetch_record();
	
	$(document).on('click','#submit',function(){
		fetch_record();
	});
	
	function fetch_record(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'es/PL-Summary-Report',
			data: {
				'department' : $('#department').val(),
				'employee' : $('#employee').val(),
			},
			dataType: 'json',
			beforeSend: function() {
				$('#plsummary').html('<p class="text-center">Feaching the records..</p>')
			},
			success: function(response){
				if(response.status == 200){
					$('#attendance-heading').html($("#month option:selected").text()+'-'+ $("#year option:selected").text());
					var x = '<div class="table-responsive"><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								'<th>DATE</th>'+
								'<th>REFRENCE</th>'+
								'<th>ADD</th>'+
								'<th>DEDUCT</th>'+
								'<th>BALANCE</th>'+
							'</tr>';
					$.each(response.data,function(key,value){
						x = x +'<tr>'+
									'<td>'+ value.date +'</td>'+
									'<td>'+ value.refrence_no +'</td>'+
									'<td>'+ value.credit +'</td>'+
									'<td>'+ value.debit +'</td>'+
									'<td>'+ value.balance +'</td>'+
								'</tr>';
					});
					x = x + '</table></div>';
					$('#plsummary').html(x);
				} else {
					$('#plsummary').html('<p class="text-center">No record to show.</p>');
				}
			},
			error: function (error) {
				$('#plsummary').html('<p class="text-center">No record to show.</p>');
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