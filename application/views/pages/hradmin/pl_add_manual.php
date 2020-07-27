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
								<option value="add" selected>Add</option>
								<option value="sub">Deduct</option> 
							</select>
						</td>
					</tr>
					<tr>
						<td>No. of PL</td>
						<td>
							<input type="text" id="nopl" class="form-control" value=""/>
						</td>
						<td>Status PL</td>
						<td>
							<input type="text" id="status_pl" class="form-control" value="0" disabled />
						</td>
					</tr>
					<tr>
						<td>Remarks</td>
						<td colspan="3">
							<textarea class="form-control" rows="3" id="remark"></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3" class="text-center">
							<input type="button" id="submit" value="Submit" class="btn btn-default">
						</td>
					</tr>
				</table>
				
				<div id="tableData"></div>
				
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
                	console.log(response);
                	var x = '<option value="0">Select Employee</option>';
                	$.each(response.data,function(key,value){
                    	x = x + '<option value="'+ value.ecode.trim() +'">'+ value.name.toUpperCase() +'</option>';
                    });
					$('#employee').html(x);
                }
        	}
		});
	});


	$(document).on('change','#employee',function(){
		var dept_id = $('#department').val();
		var emp_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/plCalculation',
        	data: {
            	'department' : dept_id,
            	'employee' : emp_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	if(response.status == 200){
                	$('#curr_pl').val(response.data['balance'][0].balance);
					$('#status_pl').val(response.data['balance'][0].balance);
					
                	var tableData = '<table class="table table-bordered">'+
    									'<thead class="bg-dark">'+
											'<tr>'+
												'<th>Date</th>'+
												'<th>REFERENCE</th>'+
												'<th>ADD</th>'+
												'<th>DEDUCT</th>'+
												'<th>BALANCE</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>';
						
                	$.each(response.data.report,function(key,value){
                		tableData = tableData + '<tr>'+
                									'<td>'+ value.date +'</td>'+
                									'<td>'+ value.refrence_no +'</td>'+
                									'<td>'+ value.credit +'</td>'+
                									'<td>'+ value.debit +'</td>'+
                									'<td>'+ value.balance +'</td>'+
                								'</tr>';
                    });
                	
					
                	tableData = tableData + '</tbody>'+
								'</table>';
					$('#tableData').html(tableData).show();
                }
        	}
		});
	});


	$(document).on('keyup','#nopl',function(){
		var pl = $('#nopl').val();
		var cpl = $('#curr_pl').val();
		var action = $('#action').val();

		if(action == 'add'){
			pl = parseFloat(parseFloat(cpl) + parseFloat(pl)); 
		} else {
			pl = parseFloat(parseFloat(cpl) - parseFloat(pl));
		}
		$('#status_pl').val(pl);
	});


	$(document).on('change','#action',function(){
		var pl = $('#nopl').val();
		var cpl = $('#curr_pl').val();
		var action = $('#action').val();

		if(action == 'add'){
			pl = parseFloat(parseFloat(cpl) + parseFloat(pl)); 
		} else {
			pl = parseFloat(parseFloat(cpl) - parseFloat(pl));
		}
		$('#status_pl').val(pl);
	});

	$(document).on('click','#submit',function(){
		var dept = $('#department').val();
		var emp = $('#employee').val();
		var nopl = $('#nopl').val();
		var statuspl = $('#status_pl').val();
		var action = $('#action').val();
		var remark = $('#remark').val();
		var formvalid = true;
		
		if(dept != 0){
			formvalid = true;
		} else {
			formvalid = false;
			alert('Please select Department.');
			return false;
		}
		if(emp != 0){
			formvalid = true;
		} else {
			formvalid = false;
			alert('Please select Employee.');
			return false;
		}

		if(action != 0){
			formvalid = true;
		} else {
			formvalid = false;
			alert('Please select action.');
			return false;
		}

		if(nopl != ''){
			formvalid = true;
		} else {
			formvalid = false;
			alert('Please enter no of PL.');
			return false;
		}

		if(formvalid){
    		$.ajax({
            	type: 'POST',
            	url: baseUrl+'Hr_ctrl/plupdate',
            	data: {
                	'department' : dept,
                	'employee' : emp,
                	'nopl' : nopl,
                	'statuspl' : statuspl,
                	'action' : action,
                	'remark' : remark
                },
            	dataType: 'json',
            	beforeSend: function() {},
            	success: function(response){
                	if(response.status == 200){
                    	$('#employee').trigger('change');
                    	alert('PL updated successfully.');
                    	//$('#department').val(0);
                		//$('#employee').val(0);
                		$('#nopl').val('');
                		$('#status_pl').val('');
                		$('#action').val(0);
                		$('#remark').val('');
                    }
            	}
    		});	
		}
	});
	
</script>
</body>