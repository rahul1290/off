<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">PL UPDATE MANUALLY</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">PL Update Manually</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      		<div class="col-6 offset-2">
				<table width="100%" border="0">
					<tr>
						<td>Department</td>
						<td>
							<select id="department" class="form-control">
								<option value="0">Select department</option>
								<?php foreach($departments as $department){ ?>
									<option value="<?php echo $department['id']; ?>"><?php echo $department['dept_name']; ?></option>
								<?php } ?> 
							</select>
						</td>
						<td>Name</td>
						<td>
							<select id="employee" class="form-control">
								<option value="0">Select Employee</option> 
							</select>
						</td>
					</tr>
					<tr>
						<td>Current PL</td>
						<td>
							<input type="text" id="curr_pl" class="form-control" value="0" disabled /> 
						</td>
						<td>Action</td>
						<td>
							<select id="action" class="form-control">
								<option value="0">Select action</option>
								<option value="add">Add</option>
								<option value="sub">Deduct</option> 
							</select>
						</td>
					</tr>
					<tr>
						<td>No. of PL</td>
						<td>
							<input type="text" id="nopl" class="form-control" value="0"/>
						</td>
						<td>Status PL</td>
						<td>
							<input type="text" id="status_pl" class="form-control" value="0" disabled />
						</td>
					</tr>
					<tr>
						<td>Remarks</td>
						<td colspan="3">
							<textarea class="form-control" rows="3"></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3" class="text-center">
							<input type="button" id="submit" value="Submit" class="btn btn-default">
						</td>
					</tr>
				</table>
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

	$(document).on('change','#department',function(){
		var dept_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/getAllEmployee_dept',
        	data: {
            	'dept_id' : dept_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	if(response.status == 200){
                	var x = '<option value="0">Select Employee</option>';
                	$.each(response.data,function(key,value){
                    	x = x + '<option value="'+ value.ecode +'">'+ value.name.toUpperCase() +'</option>';
                    });
					$('#employee').html(x);
                }
        	}
		});
	});


	$(document).on('change','#employee',function(){
		var emp_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/plCalculation',
        	data: {
            	'ecode' : emp_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	console.log(response);
        	}
		});
	});
	
</script>
</body>