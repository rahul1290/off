  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">EMPLOYEE'S LEAVE REQUEST'S</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">Employee's leave request's</li>
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
              		<a class="nav-link active" id="#pending_requests_tab" data-toggle="tab" href="#pending_requests">NEW LEAVE REQUESTS</a>
            	</li>
            	<li class="nav-item">
              		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#previous_requests">PREVIOUS LEAVE REQUESTS</a>
            	</li>
          	</ul>
          	
          	<div class="tab-content">
          		<div id="pending_requests" class="tab-pane active"><br>
          			<div class="row">
          			<div class="col-5">
        				<div class="card card-info">
        				  <div class="card-body">			
        				  	<table class="table-bordered table-striped" width="100%">
        				  		<tr class="bg-dark text-center">
        							<th>Department</th>
        							<th>Total</th>
        							<th>View</th>
        						</tr>
        						<?php if(isset($requesets) && count($requesets)>0){ 
            					foreach($requesets as $requeset){ ?>
            						<tr>
            							<td><?php echo $requeset['dept_name']; ?></td>
            							<td class="text-center"><?php echo $requeset['requests']; ?></td>
            							<td class="text-center"><a href="javascript:void(0);"><i class="fas fa-pencil"></i>Edit</a></td>
            						</tr>
            					<?php } } ?>
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
                                  	<?php if(isset($requesets) && count($requesets)>0){
                                  	foreach($requesets as $requeset){ ?>
                                  		<option value="<?php echo $requeset['id'];?>"><?php echo $requeset['dept_name'];?></option>
                                  	<?php } } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="inputPassword" class="col-3 col-form-label">Select Leave No.:</label>
                                <div class="col-9">
                                  <select class="form-control" name="leave_id" id="leave_id">
                                  	<option value="">Select Leave no.</option>
                                  </select>
                                </div>
                              </div>
                            </form>		
        				  	
        				  </div>
        				</div>
        			 </div>
        			 </div>
        			 
        			 
        			 
        			 <div id="form_detail"></div>
        			 
        			 
        			 
          		</div>
          		
          		<div id="previous_requests" class="tab-pane fade"><br>
          			<div class="col-md-12">
            			<div class="card card-info">
            			  <div class="card-header" style="border-radius:0px;">
            				<h3 class="card-title">PREVIOUS HF REQUESTS</h3>
            			  </div>
            			  <div class="card-body">
            					<div class="table-responsive">
            						<input id="search2" type="text" class="float-right mb-2">
            						<label class="float-right mr-2" for="search">Search: </label>
            						<table class="table table-bordered table-striped text-center" id="leave_requests_head">
            							<thead class="bg-dark">
            								<tr>
                    							<th>S.No.</th>
                    							<th>REFERENCE No.</th>
                    							<th>REQUEST SUBMIT DATE</th>
                    							<th>LEAVE DATE</th>
                    							<th>REASON</th>
                    							<th>LEAVE DURATION</th>
                    							<th>PL DEDUCT</th>
                    							<th>LOP</th>
                    							<th>LEAVE ADJUSTMENT</th>
                    							<th>HOD REMARK</th>
                    							<th>HOD STATUS</th>
                    							<th>HR REMARK</th>
            									<th>HR STATUS</th>
                    						</tr>
            							</thead>
            							<tbody id="leave_requests_body"></tbody>
            						</table>
            						<nav aria-label="Page navigation example" id="leave_requests_links"></nav>
            					</div>
            			  </div>
            			</div>
            		  </div>
          		</div>
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


	$(document).on('change','#department_id',function(){
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/get_leave_ids/',
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

	$(document).on('change','#leave_id',function(){
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/leave_detail/',
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
                	x  = x +'<form>'+
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
                        		'<label for="inputPassword" class="col-3 col-form-label">Leaves Requested:</label>'+
                        		'<div class="col-9">';
                        			y = '<b>Reference No:</b>'+ response.data.leave_detail[0]['reference_id']+'<br/><b>COFF:</b>';
                        		x = x + y + '</div>'+
                      	    '</div>'+
                      	  '<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                      		'<label for="inputPassword" class="col-3 col-form-label">Leave Duration:</label>'+
                      		'<div class="col-9">'+
                      			response.data.leave_detail[0]['duration']+
                      		'</div>'+
                    	  '</div>'+
                    	  '<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                        		'<label for="inputPassword" class="col-3 col-form-label">Week of Day:</label>'+
                        		'<div class="col-9">';
                        			if(response.data.leave_detail[0]['wod'] == '1'){
                            			x = x + 'Sunday';	
                            		} else if(response.data.leave_detail[0]['wod'] == '2'){
                            			x = x + 'Monday';
                            		} else if(response.data.leave_detail[0]['wod'] == '3'){
                            			x = x + 'Tuesday';
                            		} else if(response.data.leave_detail[0]['wod'] == '4'){
                            			x = x + 'Wednesday';
                            		} else if(response.data.leave_detail[0]['wod'] == '5'){
                            			x = x + 'Thursday';
                            		} else if(response.data.leave_detail[0]['wod'] == '6'){
                            			x = x + 'Friday';
                            		} else if(response.data.leave_detail[0]['wod'] == '7'){
                            			x = x + 'Saturday';
                            		}
                        		x = x + '</div>'+
                      	  '</div>'+
                          '<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                        		'<label for="inputPassword" class="col-3 col-form-label">Employee Remarks:</label>'+
                        		'<div class="col-9">'+
                        			response.data.leave_detail[0]['requirment']+
                        		'</div>'+
                      	  '</div>'+
                      	'<div class="form-group row" style="margin-bottom:0px;background-color: aliceblue;">'+
                    		'<label for="inputPassword" class="col-3 col-form-label">Hod Remarks:</label>'+
                    		'<div class="col-9">'+
                    			response.data.leave_detail[0]['hod_remark']+
                    		'</div>'+
                  	  	'</div>'+
                  	  	'<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                  			'<label for="inputPassword" class="col-3 col-form-label">HOD Approval Status:</label>'+
                  			'<div class="col-9">'+
                  				response.data.leave_detail[0]['hod_status']+
                  			'</div>'+
                	  	'</div>'+
                	  	'<div>'+
                	  		'<table class="table table-bordered">'+
                	  			'<tr class="bg-dark">'+	
                	  				'<th>Remaining NH/FH:</th>'+
                	  				'<th>Remaining Comp OFFs:</th>'+
                	  				'<th>No. of PL Remain:<span id="pls"></span></th>'+
                	  			'</tr>'+
                	  			'<tr>';
                	  			if(response.data.nhfh.length){
                	  				y = '<td><ul style="list-style:none;">';
                        	  		$.each(response.data.nhfh,function(key,value){
                            	  		y = y+'<li><input type="checkbox" class="coff" data-id="'+ value.id +'"> '+ value.date_from +'</li>';
                            	  	});
                            	  	y = y + '</ul></td>';
                            	  	x = x + y;
                	  			} else {
                    	  			x = x + '<td>NHFH not found.</td>';
                    	  		}

                    	  		if(response.data.coff.length){
                        	  		y = '<td><ul style="list-style:none;">';
                        	  		$.each(response.data.coff,function(key,value){
                            	  		y = y+'<li><input type="checkbox" class="coff" data-id="'+ value.id +'"> '+ value.date_from +'</li>';
                            	  	});
                            	  	y = y + '</ul></td>';
                            	  	x = x + y;
                        	  	} else {
                        	  		x = x + '<td>COFF not found.</td>';
                            	}
                            	
                            	console.log(response.data.pls[0].balance);
                	  			x = x +'<td>PL :'+
                	  					'<select id="pls">';
                	  						for(i=1;i<=parseInt(response.data.pls[0].balance);i++){
                    	  						x = x + '<option value="'+ i +'">'+ i +'</option>';
                    	  					}
                	  					x = x +'</select>'+
                	  				'</td>'+
                	  			'</tr>'+
                	  		'</table>'+
                	  		'<div class="text-center"><input type="button" id="submit" class="btn btn-success" value="Ok"><input type="reset" class="btn btn-danger" value="Cancel"></div>'+
                	  	'</div>'+
                       '</form>';
                       x = x + '</div></div>';
                	$('#form_detail').html(x);
                	$('#pls').html(response.data.pls[0]['balance']);
                }
        	} 
		});
	});
	

	requests(0);
	$(document).on('keyup','#search2',function(){
		requests(0);
	});
	
	function requests(page){
		var str = $('#search2').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'Hr_ctrl/leave_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#leave_requests_body').html('<td colspan="13" class="text-center">Record fatching.</td>');
            },
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.refrence_id +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						//'<td>'+ value.date_to +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td>'+ value.duration +'</td>'+
            						'<td>'+ value.pl +'</td>'+
            						'<td>'+ value.lop +'</td>'+
            						'<td>COFF\'s:</br>'+ value.COFF +'</br>NH/FH\'s:</br>'+ value.NHFH +'</td>'+
            						'<td>'+ value.hod_remark +'</td>'+
            						'<td>'+ value.hod_status +'</td>'+
    							  	'<td><textarea name="" id="" data-rid="'+ value.id +'" class="hr_remark form-control"></textarea></td>'+
        						  	'<td>'+
        								'<select class="hr_status" name="hr_status" data-rid="'+ value.id +'">'+
											'<option value="PENDING" selected>PENDING</option>'+
											'<option  value="REJECTED">REJECTED</option>'+
											'<option  value="GRANTED">GRANTED</option>'+
										'</select>'+
    						      	'</td>'+  	
            					'</tr>';
            		});         	
            		$('#leave_requests_body').html(x);
            		$('#leave_requests_links').html(response.data.links);
        		} else {
        			$('#leave_requests_body').html('<td colspan="13" class="text-center">NO Record found.</td>');
            	}
        	}
        });
	}

	$(document).on('click','.myLinks',function(){
		var page = $(this).attr('href');
		var x = page.split('/');
		if(x[1] == undefined){
			x[1] = 0;
		}
		requests(x[1]);	
	});
	
});
</script>
</body>