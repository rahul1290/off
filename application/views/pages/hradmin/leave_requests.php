  
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
        				<div class="card card-info" style="height: 250px; overflow-y:scroll;">
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
            					<?php } } else { ?>
            						<td colspan="3">No record found.</td>
            					<?php } ?>
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
        			 <hr/>
        			 
        			 
        			 <div class="col-8" id="form_detail"></div>
        			 
        			 
        			 
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

	$(document).on('change','#leave_id,#department_id',function(){
		$('#form_detail').html('');
	});

	var globalData= {};
	
	$(document).on('click','#view',function(){
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
            		globalData = response; 
                	x  = x +'<form name="f2" id="f2" method="POST" action="<?php echo base_url('Hr_ctrl/leave_request_submit');?>">'+
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
                        		'<label for="inputPassword" class="col-3 col-form-label">Leaves Requested:</label>'+
                        		'<div class="col-9">';
                        			x = x + '<table>'+
                        					'<tr>'+
                        						'<td><b>Reference No:</b></td>'+
                        						'<td>'+ response.data.leave_detail[0]['reference_id']+'</td>'+
                        					'</tr>'+
                        					'<tr>'+
                        						'<td><b>COFF:</b></td><td>';
                        						y1='';
                                        	  	if(response.data.coff_againts_ref.length){
													$.each(response.data.coff_againts_ref,function(key,value){
														if(value.request_type == "OFF_DAY"){
															y1 = y1 + value.date_from +',';
														}
													});						
                                              	}
                                        		x = x + y1 + '</td><tr><td><b>NHFH:</b></td><td>';
                                        		y2='';
                                        		if(response.data.coff_againts_ref.length){
													$.each(response.data.coff_againts_ref,function(key,value){
														if(value.request_type == "NH_FH"){
															console.log(value);
															y2 = y2 + value.date_from +',';
														}
													});						
                                              	}
                                        		x = x + y2 +'</td>'+
                        					'</tr>'+
                        					'<tr>'+
                        						'<td><b>PL:</b></td>';
                        						if (response.data.leave_detail[0]['pl'] != null){
                        						 x = x + '<td>'+ response.data.leave_detail[0]['pl'] +'</td>';
                        						} else {
                            						x = x + '<td>-</td>';
                            					}
                        					x = x + '</tr>'+
                        				'</table>'+
                        			'</div>'+
                      	    '</div>'+
                      	  '<div class="form-group row" style="margin-bottom:0px;background-color: bisque;">'+
                      		'<label for="inputPassword" class="col-3 col-form-label">Leave Duration:</label>'+
                      		'<div class="col-9">'+
                      		response.data.leave_detail[0]['date_from'] +' - '+ response.data.leave_detail[0]['date_to'] +' <b>: '+ response.data.leave_detail[0]['duration']+'</b>'+
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
                            	  		flag = true;
                            	  		$.each(globalData.data.coff_againts_ref,function(key1,value1){
                            	  			if(value.reference_id == value1.reference_id){
                                	  			flag = false;
                            	  			}
                            	  		});
                            	  		if(flag){
                            	  			y = y+'<li><input type="checkbox" name="nhfh[]" class="hrnhfh" data-id="'+ value.id +'" data-text="'+ value.date_from +'" value="'+ value.reference_id +'"> '+ value.date_from +'</li>';
                            	  		} else {
                            	  			y = y+'<li><input type="checkbox" name="nhfh[]" class="hrnhfh" data-id="'+ value.id +'" data-text="'+ value.date_from +'" value="'+ value.reference_id +'" checked> '+ value.date_from +'</li>';
                                	  	}
                            	  	});
                            	  	y = y + '</ul></td>';
                            	  	x = x + y;
                	  			} else {
                    	  			x = x + '<td>No Remaining NHFH.</td>';
                    	  		}

                    	  		if(response.data.coff.length){
                        	  		y = '<td><ul style="list-style:none;">';
                        	  		$.each(response.data.coff,function(key,value){
                        	  			flag = true;
                        	  			$.each(globalData.data.coff_againts_ref,function(key1,value1){
                            	  			if(value.reference_id == value1.reference_id){
                            	  				flag = false;
                                	  		}
                        	  			});
                        	  			if(flag){	                            	  		
                            	  			y = y+'<li><input type="checkbox" name="coff[]" class="hrcoff" data-id="'+ value.id +'" data-text="'+ value.date_from +'" value="'+ value.reference_id +'"> '+ value.date_from +'</li>';
                        	  			} else {
                        	  				y = y+'<li><input type="checkbox" name="coff[]" class="hrcoff" data-id="'+ value.id +'" data-text="'+ value.date_from +'" value="'+ value.reference_id +'" checked> '+ value.date_from +'</li>';
                            	  		}
                            	  	});
                            	  	y = y + '</ul></td>';
                            	  	x = x + y;
                        	  	} else {
                        	  		x = x + '<td>No Remaining COFF.</td>';
                            	}
                            	
                            	
                	  			x = x +'<td>PL:&nbsp;'+
                	  					'<select id="pl_select" name="pls">';
                	  						for(i=0;i<=parseInt(response.data.pls[0].balance);i++){
                	  							if (response.data.leave_detail[0]['pl'] != null){
                    	  							if(parseInt(response.data.leave_detail[0]['pl']) == i){
                    	  								x = x + '<option value="'+ i +'" selected>'+ i +'</option>';
                        	  						}
                	  							}
                	  							x = x + '<option value="'+ i +'">'+ i +'</option>';
                    	  					}
                	  						x = x +'</select><br/>'+
                	  						'LOP:&nbsp;<select id="lop" name="lop">';
                	  						for(i=0;i<=100;i++){
                	  							x = x + '<option value="'+ i +'">'+ i +'</option>';
                	  						}
                	  						x = x + '</select>'+
                	  				'</td>'+
                	  			'</tr>'+
                	  			'<tr>'+
                	  				'<td>HR Remark</td>'+
                	  				'<td colspan="2"><textarea class="form-control" name="hr_remark" id="hr_remark"></textarea></td>'+
                	  			'</tr>'+
                	  		'</table>'+
                	  		'<div class="text-center">'+
                	  			'<input type="button" id="submit" class="btn btn-success" value="Ok">'+
                	  			'<input type="reset" class="btn btn-danger" value="Cancel">'+
                	  		'</div>'+
                	  	'</div>'+
                       '</form>';
                       x = x + '</div></div>';
                	$('#form_detail').html(x);
                	hr_remark();
                	$('#pls').html(response.data.pls[0]['balance']);
                }
        	} 
		});
	});

	$(document).on('click','.hrnhfh,.hrcoff',function(){
		hr_remark();
	});
	$(document).on('change','#pl_select,#lop',function(){
		hr_remark();
	});
	
	function hr_remark(){
		coff = 'COFF: ';
		coff_flag = false;
		$.each($("input[name='coff[]']:checked"), function(){
			coff_flag = true;
			coff += $(this).data('text')+',';
		});

		nhfh = 'NHFH: ';
		nhfh_flag = false;
		$.each($("input[name='nhfh[]']:checked"), function(){
			nhfh_flag = true;
			nhfh += $(this).data('text')+',';
		});

		pl = 'PL: '+ $('#pl_select').val();
		lop = 'LOP: '+ $('#lop').val();

		str = '';
		if(coff_flag){
			str = str + coff;
		}
		if(nhfh_flag){
			str = str + '\n' + nhfh;
		}
		
		str = str + '\n' + pl + ',' + lop;
		$('#hr_remark').val(str);
	}

	$(document).on('click','#submit',function(){
		var myForm = document.getElementById('f2');
		var formData = new FormData(myForm);
		$.ajax({
	        	type: 'POST',
	        	url: baseUrl+'Hr_ctrl/leave_request_submit',
	        	data: formData,
	        	dataType: 'json',
	        	beforeSend: function() {
	        		$('#leave_requests_body').html('<td colspan="13" class="text-center">Record fatching.</td>');
	            },
	        	success: function(response){
		        	if(response.status =200){
			        	alert(response.msg);
			        	location.reload();
			        } else {
			        	alert(response.msg);
				    }
	        	},
	        	processData: false,
			    contentType: false
		 });
	});


	
	///pagination
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
            						'<td>'+ value.reference_id +'</td>'+
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
    							  	'<td>'+ value.hr_remark +'</td>'+
    							  	'<td>'+ value.hr_status +'</td>'+  	
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