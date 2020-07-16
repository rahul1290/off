<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">EMPLOYEE'S HF REQUESTS STATUS</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">HF Leave Request</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
			  
			  <ul class="nav nav-tabs">
				<li class="nav-item">
                	<a class="nav-link active" id="#pending_requests_tab" data-toggle="tab" href="#pending_requests">NEW HF REQUESTS</a>
                </li>
                <li class="nav-item">
                  	<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#previous_requests">PREVIOUS HF REQUESTS</a>
                </li>
              </ul>
              
              <div class="tab-content">
              	<div id="pending_requests" class="tab-pane active"><br>
              		
              		<div class="row">
                  		<div class="col-5">
            				<div class="card card-info" style="height: 250px; overflow-y:scroll;">
            				  <div class="card-body">
            					<table class="table table-bordered">
            						<tr class="bg-dark text-center">
            							<th>Department</th>
            							<th>Total</th>
            							<th>View</th>
            						</tr>
            						<?php 
            						if(isset($pending_requests) && count($pending_requests)>0){ 
            						    foreach($pending_requests as $pending_request){ ?>
            							<tr>
            								<td><?php echo $pending_request['dept_name']; ?></td>
            								<td><?php echo $pending_request['requests']; ?></td>
            								<td><a href="javascript:void(0);">View</a></td>
            							<tr>
            						<?php } 
            						} else { ?>
            						    <td colspan="3">No record found.</td>
            						<?php }?>
            					</table>
            				  </div>
            				</div>
            			</div>
            			
            			<div class="col-7">
            				<div class="card card-info">
            				  <div class="card-body">
            					
            					<form>
                                  <div class="form-group row">
                                    <label for="staticEmail" class="col-3 col-form-label">Select Departmet:</label>
                                    <div class="col-9">
                                      <select class="form-control" name="department_id" id="department_id">
                                      	<option value="">Select Department</option>
                                      	<?php if(isset($pending_requests) && count($pending_requests)>0){
                                      	    foreach($pending_requests as $requeset){ ?>
                                      		<option value="<?php echo $requeset['id'];?>"><?php echo $requeset['dept_name'];?></option>
                                      	<?php } } ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-3 col-form-label">Select Request No.:</label>
                                    <div class="col-9">
                                      <select class="form-control" name="leave_id" id="leave_id">
                                      	<option value="">Select Leave no.</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="text-center"><input type="button" value="View" id="view" class="btn btn-warning"></div>
                               </form>	
            					
            				  </div>
            				</div>
            			</div>
        			</div>
              	</div>
              	<hr/>
              	
              	<div id="previous_requests" class="tab-pane fade"><br>
              		
              		<div class="col-md-12">
    				<div class="card card-info">
    				  <div class="card-header" style="border-radius:0px;">
    					<h3 class="card-title">PREVIOUS HF REQUESTS</h3>
    				  </div>
    				  <div class="card-body">
    					<?php if(count($requests)>0){ ?>
    					<div class="table-responsive">
    						<table class="table table-bordered text-center" id="example2">
    							<thead>	
    								<tr class="bg-dark">
    									<th>S.No.</th>
    									<th>REFERENCE No.</th>
    									<th>DEPARTMENT</th>
    									<th>EMPLOYEE NAME</th>
    									<th>REQUEST SUBMIT DATE</th>
    									<th>HALF TAKEN DATE</th>
    									<th>REASON</th>
    									<th>HOD REMARK</th>
    									<th>HOD STATUS</th>
    									<th>HR REMARK</th>
    									<th>HR STATUS</th>
    									<th>LAST UPDATE BY</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php if(count($requests)>0){?>
    									<?php $c=1; foreach($requests as $request){ ?>
    										<tr>	
    											<td><?php echo $c++; ?>.</td>
    											<td><?php echo $this->my_library->remove_hyphen($request['reference_id']); ?></td>
    											<td><?php echo $request['dept_name']; ?></td>
    											<td><?php echo $request['name']; ?></td>
    											<td><?php echo $request['created_at']; ?></td>
    											<td><?php echo $request['date']; ?></td>
    											<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
    											<td>
    												<label><?php echo $request['hod_remark']; ?></label>
    											</td>
    											<td>
    												<?php echo $request['hod_status']; ?><?php //echo $request['hod_remark_date']; ?>
    											</td>
    											<td><?php echo $request['hr_remark']; ?></td>
    											<td><?php echo $request['hr_status']; ?><?php //echo $request['hr_remark_date']; ?></td>
    											<td>
    												<?php echo $request['hod_name']; ?>
    											</td>
    										</tr>
    									<?php } ?>
    								<?php } ?>
    							</tbody>
    						</table>
    					</div>
    					<?php } else { echo "<p class='text-center'>No record found.</p>"; }?>
    				  </div>
    				</div>
    			  </div>
              	</div>
              	
              	
              	<div class="col-8" id="form_detail"></div>
              	
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
	$('#example').DataTable();
	$('#example2').DataTable();
	
	
	$(document).on('change','#department_id',function(){
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'hr/Hf_leave_ctrl/get_hf_ids/',
        	data: {
            	'dept_id' : $('#department_id').val()
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	var x = '<option value="">Select Leave no.</option>';
            	if(response.status == 200){
                	$.each(response.data,function(key,value){
                    	x = x + '<option value="'+ value.id +'">'+ value.reference_id +'</option>';	
                    });
                } 
                $('#leave_id').html(x);
        	} 
		});
	});


	$(document).on('click','#view',function(){
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'hr/Hf_leave_ctrl/request_detail/',
        	data: {
            	'ref_id' : $('#leave_id').val()
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	var x = '<div class="card card-info">'+      			  
			  				'<div class="card-body">';
            	console.log(response);
            	if(response.status == 200){
                	x  = x +'<form name="f2" id="f2" method="POST" action="<?php echo base_url('hr/Hf_leave_ctrl/hf_request_submit');?>">'+
                			  '<input type="hidden" name="application_no" value="'+ response.data.leave_detail[0]['reference_id'] +'">' +
                        	  '<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                            	'<label for="staticEmail" class="col-3 col-form-label">Employee Name:</label>'+
                            	'<div class="col-3">'+
                              		response.data.user_detail[0]['name'] +
                            	'</div>'+

                            	'<label for="staticEmail" class="col-3 col-form-label">Employee Code:</label>'+
                            	'<div class="col-3">'+
                            		response.data.user_detail[0]['ecode']+
                            	'</div>'+
                          	  '</div>'+
                          	  '<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                            		'<label for="inputPassword" class="col-3 col-form-label">Designation:</label>'+
                            		'<div class="col-3">'+
                            			response.data.user_detail[0]['desg_name']+
                            		'</div>'+
                            		'<label for="inputPassword" class="col-3 col-form-label">Department:</label>'+
                            		'<div class="col-3">'+
                            			response.data.user_detail[0]['dept_name']+
                            		'</div>'+
                          	  '</div>'+
                              '<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                            		'<label for="inputPassword" class="col-3 col-form-label">Employee Remarks:</label>'+
                            		'<div class="col-9">'+
                            			response.data.leave_detail[0]['requirment']+
                            		'</div>'+
                          	  '</div>'+
                          	'<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                        		'<label for="inputPassword" class="col-3 col-form-label">Hod Remarks:</label>'+
                        		'<div class="col-9">'+
                        			response.data.leave_detail[0]['hod_remark']+
                        		'</div>'+
                      	  	'</div>'+
                      	  	'<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                      			'<label for="inputPassword" class="col-3 col-form-label">HOD Approval Status:</label>'+
                      			'<div class="col-9">'+
                      				response.data.leave_detail[0]['hod_status']+ 
                      			'</div>'+
                    	  	'</div>'+
                    	  	'<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                      			'<label for="inputPassword" class="col-3 col-form-label">PL Remainings:</label>'+
                      			'<div class="col-9">'+
                      				response.data.pls[0]['balance']+ 
                      			'</div>'+
                    	  	'</div>'+

                    	  	'<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                      			'<label for="inputPassword" class="col-3 col-form-label">PL Deduction:</label>'+
                      			'<div class="col-9">'+
                      				'<input type="radio" name="pl_deduction" value="no" class="mr-1">No Dectuction'+
                      				'<input type="radio" name="pl_deduction" value="yes" class="ml-2 mr-1">Dectucted'+ 
                      			'</div>'+
                    	  	'</div>'+
                    	  	
                    	  	'<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                      			'<label for="inputPassword" class="col-3 col-form-label">Hr Remark:</label>'+
                      			'<div class="col-9">'+
                      				'<textarea class="form-control" rows="3" name="hr_remark"></textarea>'+
                      			'</div>'+
                	  		'</div>'+
                	  	'<div>'+
                	  		'<div class="text-center">'+
                	  			'<input type="submit" id="submit" class="btn btn-success" value="Ok">'+
                	  			'<input type="reset" class="btn btn-danger" value="Cancel">'+
                	  		'</div>'+
                	  	'</div>'+
                       '</form>';
                       x = x + '</div></div>';
                	$('#form_detail').html(x);
                	$('#pls').html(response.data.pls[0]['balance']);
                }
        	} 
		});
	});
	
});
</script>
</body>