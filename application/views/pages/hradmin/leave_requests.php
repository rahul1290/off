  
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
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">NEW REQUESTS</h3>
				  </div>
				  <div class="card-body">
					<?php /* if(count($pending_requests)>0){?>
					<div class="table-responsive table-striped">
						<table class="table table-bordered text-center" id="example">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>DEPARTMENT</th>
									<th>EMPLOYEE NAME</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>LEAVE DATE'S</th>
									<th>LEAVE DURATION</th>
									<th>LEAVE ADJUSTMENT</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<th>HR REMARK</th>
									<th>HR STATUS</th>
								</tr>
							</thead>
							<tbody>
									<?php $c=1; foreach($pending_requests as $request){ ?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
											<td><?php echo $request['dept_name']; ?></td>
											<td><?php echo $request['name']; ?></td>
											<td><?php echo $request['created_at']; ?></td>
											<td><?php echo $this->my_library->sql_datepicker($request['date_from']); ?> - <?php echo $this->my_library->sql_datepicker($request['date_to']); ?></td>
											<td><?php
            								    $date1 = date_create($this->my_library->mydate($request['date_from']));
            								    $date2 = date_create($this->my_library->mydate($request['date_to']));
            								    $diff=date_diff($date1,$date2);
            								    
            								    echo $diff->format("%a") + 1;
            								    if($diff->format("%a") > 0)
            								        echo ' days';
            								    else 
            								        echo ' day';
            								    
                                            ?></td>
											<td>
												<?php 
													if($request['coff'] != null){
														$coffs= explode(',',$request['coff']);
														echo "COFF'S<br/><ul>";
														foreach($coffs as $coff){
															echo "<li>".$this->my_library->remove_hyphen($coff)."</li>";
														}
														echo "</ul>";
													}
													
													if($request['nhfhs'] != null){
														$nhfhs = explode(',',$request['nhfhs']);
														echo "NHFH'S<br/><ul>";
														foreach($nhfhs as $nhfh){
															echo "<li>".$this->my_library->remove_hyphen($nhfh)."</li>";
														}
														echo "</ul>";
													}
												?>
											</td>
											<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
											<td><label><?php echo $request['hod_remark']; ?></label></td>
											<td><label><?php echo $request['hod_status']; ?><!-- <hr/><?php //echo $request['hod_remark_date']; ?></label>--></td>
											<td>
												<textarea name="" id="" class="hr_remark form-control"></textarea>
											</td>
											<td>
												<select class="hr_status" name="hr_status" data-rid="<?php echo $request['id']; ?>">
													<option value="PENDING" <?php if($request['hr_status'] == 'PENDING'){ echo 'selected'; }?>>PENDING</option>
													<option  value="REJECTED" <?php if($request['hr_status'] == 'REJECTED'){ echo 'selected'; }?>>REJECTED</option>
													<option  value="GRANTED" <?php if($request['hr_status'] == 'GRANTED'){ echo 'selected'; }?>>GRANTED</option>
												</select>
											</td>
										</tr>
									<?php } ?>
							</tbody>
						</table>
					</div>
					<?php } else {
						echo "<p class='text-center'>No new record found.</p>";
					} */ ?>
					
						<div class="table-responsive">
    						<input id="search" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="leave_pending_requests_head">
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
    							<tbody id="leave_pending_requests_body"></tbody>
    						</table>
    						<nav aria-label="Page navigation example" id="leave_pending_requests_links"></nav>
    					</div>
    					
				  </div>
				</div>
			  </div>
		
		
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">PREVIOUS HF REQUESTS</h3>
				  </div>
				  <div class="card-body">
					<?php /*if(count($requests)>0){?>
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="example2">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>DEPARTMENT</th>
									<th>EMPLOYEE NAME</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>LEAVE DATE'S</th>
									<th>LEAVE DURATION</th>
									<th>LEAVE ADJUSTMENT</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<th>HR REMARK</th>
									<th>HR STATUS</th>
									<th>LAST UPDATE BY</th>
								</tr>
							</thead>
							<tbody>
									<?php $c=1; foreach($requests as $request){ ?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
											<td><?php echo $request['dept_name']; ?></td>
											<td><?php echo $request['name']; ?></td>
											<td><?php echo $request['created_at']; ?></td>
											<td><?php echo $this->my_library->sql_datepicker($request['date_from']); ?> - <?php echo $this->my_library->sql_datepicker($request['date_to']); ?></td>
											<td><?php
            								    $date1 = date_create($this->my_library->mydate($request['date_from']));
            								    $date2 = date_create($this->my_library->mydate($request['date_to']));
            								    $diff=date_diff($date1,$date2);
            								    
            								    echo $diff->format("%a") + 1;
            								    if($diff->format("%a") > 0)
            								        echo ' days';
            								    else 
            								        echo ' day';
            								    
                                            ?></td>
											<td>
												<?php 
													if($request['coff'] != null){
														$coffs= explode(',',$request['coff']);
														echo "COFF'S<br/><ul>";
														foreach($coffs as $coff){
															echo "<li>".$this->my_library->remove_hyphen($coff)."</li>";
														}
														echo "</ul>";
													}
													
													if($request['nhfhs'] != null){
														$nhfhs = explode(',',$request['nhfhs']);
														echo "NHFH'S<br/><ul>";
														foreach($nhfhs as $nhfh){
															echo "<li>".$this->my_library->remove_hyphen($nhfh)."</li>";
														}
														echo "</ul>";
													}
												?>
											</td>
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
							</tbody>
						</table>
					</div>
					<?php }*/ ?>
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
	
	var previous;
	var that;
	$(document).on('focus','.hr_status',function(){
        previous = $(this).val();
        that = this;
    }).change(function() {
		var req_id = $(that).data('rid');
		var status = $(that).val();
		var c = confirm('Are you sure!');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'hr/leave-request-update/',
				data: { 
					'req_id' : req_id,
					'key' : 'hr_status',
					'value' : status,
				},
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						location.reload();
					} else {
					}
				}
			});
		} else {
			$(that).val(previous);
		}
    });
	
	$(document).on('blur','.hr_remark',function(){
		var req_id = $(this).data('rid');
		var status = $(this).val();		
		$.ajax({
			type: 'POST',
			url: baseUrl+'hr/leave-request-update/',
			data: { 
				'req_id' : req_id,
				'key' : 'hr_remark',
				'value' : status,
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
				} else {
				}
			}
		});
	});


	pending_requests(0);	//load requests
	
	$(document).on('keyup','#search',function(){
		pending_requests(0);
	});
	
	function pending_requests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'Hr_ctrl/leave_pending_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#leave_pending_requests_body').html('<td colspan="13" class="text-center">Record fatching.</td>');
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
            		$('#leave_pending_requests_body').html(x);
            		$('#leave_pending_requests_links').html(response.data.links);
        		} else {
        			$('#leave_pending_requests_body').html('<td colspan="13" class="text-center">NO Record found.</td>');
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
		pending_requests(x[1]);	
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