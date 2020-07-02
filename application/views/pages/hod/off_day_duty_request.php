<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">OFF DAY DUTY REQUESTS</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HOD Section</li>
						<li class="breadcrumb-item active">Off day duty Request</li>
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
                  	<a class="nav-link active" id="#pending_requests_tab" data-toggle="tab" href="#pending_requests">OFF DAY REQUESTS</a>
                </li>
                <li class="nav-item">
                  	<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#previous_requests">PREVIOUS OFF DAY REQUESTS</a>
                </li>
          	</ul>
          	
          	<div class="tab-content"><br/>
                <div id="pending_requests" class="tab-pane fade in active show">
                	  <div class="col-md-12">
        				<div class="card card-info">
        				  <div class="card-header" style="border-radius:0px;">
        					<h3 class="card-title">OFF DAY REQUESTS</h3>
        				  </div>
        				  <div class="card-body">
        					<div class="table-responsive">
        						<input id="search" type="text" class="float-right mb-2">
        						<label class="float-right mr-2" for="search">Search: </label>
        						<table class="table table-bordered table-striped text-center" id="offdudy_pending_requests_head">
        							<thead class="bg-dark">
        								<tr>
                							<th>S.No.</th>
        									<th>REFERENCE No.</th>
        									<th>DEPARTMENT</th>
        									<th>EMPLOYEE NAME</th>
        									<th>REQUEST SUBMIT DATE</th>
        									<th>OFF DAY DATE</th>
        									<th>REASON</th>
        									<th>REMARK</th>
        									<th>HOD STATUS</th>
                						</tr>
        							</thead>
        							<tbody id="offduty_pending_requests_body"></tbody>
        						</table>
        						<nav aria-label="Page navigation example" id="offduty_pending_requests_links"></nav>
        					</div>
        				  </div>
        				</div>
        			  </div>	
                </div>
                
                <div id="previous_requests" class="tab-pane fade">
                	<div class="col-md-12">
        				<div class="card card-info">
        				  <div class="card-header" style="border-radius:0px;">
        					<h3 class="card-title">PREVIOUS OFF DAY REQUESTS</h3>
        				  </div>
        				  <div class="card-body">
        				  	<div class="table-responsive">
        						<input id="search" type="text" class="float-right mb-2">
        						<label class="float-right mr-2" for="search">Search: </label>
        						<table class="table table-bordered table-striped text-center" id="offdudy_requests_head">
        							<thead class="bg-dark">
        								<tr>
                							<th>S.No.</th>
        									<th>REFERENCE No.</th>
        									<th>DEPARTMENT</th>
        									<th>EMPLOYEE NAME</th>
        									<th>REQUEST SUBMIT DATE</th>
        									<th>OFF DAY DATE</th>
        									<th>REASON</th>
        									<th>REMARK</th>
        									<th>HOD STATUS</th>
                						</tr>
        							</thead>
        							<tbody id="offduty_requests_body"></tbody>
        						</table>
        						<nav aria-label="Page navigation example" id="offduty_requests_links"></nav>
        					</div>
        				  <?php /*
        					<div class="table-responsive">
        						<table class="table table-bordered text-center" id="example2">
        							<thead>	
        								<tr class="bg-dark">
        									<th>S.No.</th>
        									<th>REFERENCE No.</th>
        									<th>DEPARTMENT</th>
        									<th>EMPLOYEE NAME</th>
        									<th>REQUEST SUBMIT DATE</th>
        									<th>OFF DAY DATE</th>
        									<th>REASON</th>
        									<th>REMARK</th>
        									<th>HOD STATUS</th>
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
        												<?php echo $request['hod_status']; ?>
        											</td>
        										</tr>
        									<?php } ?>
        								<?php } ?>
        							</tbody>
        						</table>
        					</div>
        					
        					*/ ?>
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
	$('#example').DataTable();
	$('#example2').DataTable();
	
	var previous;
	var that;
	$(document).on('focus','.hod_status',function(){
    //$(".hod_status").on('focus', function () {
        previous = $(this).val();
        that = this;
    }).change(function() {
		var req_id = $(that).data('rid');
		var status = $(that).val();
		var c = confirm('Are you sure!');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'hod/off-day-duty-update/',
				data: { 
					'req_id' : req_id,
					'key' : 'hod_status',
					'value' : status,
				},
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						location.reload(true);
					} else {
					}
				}
			});
		} else {
			$(that).val(previous);
		}    
    });
	

	offDayPendingRequests(0);	//load pending requests
	$(document).on('keyup','#search',function(){
		offDayPendingRequests(0);
	});
	
	function offDayPendingRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/Off_day_duty_ctrl/off_day_pending_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#hf_pending_requests_body').html('<td class="text-center" ></td>');
            },
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.reference_id +'</td>'+
            						'<td>'+ value.dept_name +'</td>'+
            						'<td>'+ value.emp_name +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td><textarea id="hod_remark_'+ value.id +'">'+ value.hod_remark +'</textarea></td>'+
    								'<td><select class="hod_status" data-rid="'+ value.id +'">'+
                        							'<option value="PENDING" selected>PENDING</option>'+
                        							'<option value="REJECTED">REJECTED</option>'+
                        							'<option value="GRANTED">GRANTED</option>'+
                    							'</select></td>'+  	
            					'</tr>';
            		});         	
            		$('#offduty_pending_requests_body').html(x);
            		$('#offduty_pending_requests_links').html(response.data.links);
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
		offDayPendingRequests(x[1]);	
	});




	$(document).on('click','#previous_requests_tab',function(){
		offDayRequests(0);	//load off requests	
	});

	
	$(document).on('keyup','#search',function(){
		offDayRequests(0);
	});
	
	function offDayRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/Off_day_duty_ctrl/off_day_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#offduty_requests_body').html('<td class="text-center" ></td>');
            },
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.reference_id +'</td>'+
            						'<td>'+ value.dept_name +'</td>'+
            						'<td>'+ value.emp_name +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td>'+ value.hod_remark +'</td>'+
            						'<td>'+ value.hod_status +'</td>'+  	
            					'</tr>';
            		});         	
            		$('#offduty_requests_body').html(x);
            		$('#offduty_requests_links').html(response.data.links);
        		}
        	}
        });
	}

	$(document).on('click','.myLinks1',function(){
		var page = $(this).attr('href');
		var x = page.split('/');
		if(x[1] == undefined){
			x[1] = 0;
		}
		offDayRequests(x[1]);	
	});
	
});
</script>
</body>