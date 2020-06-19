    <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">LEAVE REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">HOD Section</li>
						<li class="breadcrumb-item active">Leave Request</li>
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
              <a class="nav-link active" data-toggle="tab" href="#home">NEW LEAVE REQUESTS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu1">PREVIOUS HF REQUESTS</a>
            </li>
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
            <div id="home" class="tab-pane active"><br>
             
			  <div class="col-12">
                 <div class="card card-info">
                  <div class="card-header" style="border-radius:0px;">
                     <h3 class="card-title">NEW LEAVE REQUESTS</h3>
                  </div>
                	<div class="card-body">
    					<div class="table-responsive">
    						<input id="search" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="leave_pending_requests_head">
    							<thead class="bg-dark">
    								<tr>
            							<th>S.No.</th>
    									<th>REFERENCE No.</th>
    									<th>DEPARTMENT</th>
    									<th>EMPLOYEE NAME</th>
    									<th>REQUEST SUBMIT DATE</th>
    									<th>LEAVE DATE'S</th>
    									<th>LEAVE DURATION</th>
    									<th>LEAVE ADJUSTMENT'S</th>
    									<th>REASON</th>
    									<th>REMARK</th>
    									<th>HOD STATUS</th>
            						</tr>
    							</thead>
    							<tbody id="leave_pending_requests_body"></tbody>
    						</table>
    						<nav aria-label="Page navigation example" id="leave_pending_requests_links"></nav>
    					</div>
    				</div>
    			   </div>
            	</div>
			  
            </div>
            
            
            <div id="menu1" class="tab-pane fade"><br>
            	
            	<div class="col-12">
                 <div class="card card-info">
                  <div class="card-header" style="border-radius:0px;">
                     <h3 class="card-title">PREVIOUS HF REQUESTS</h3>
                  </div>
                	<div class="card-body">
    					<div class="table-responsive">
    						<input id="search2" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search2">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="leave_requests_head">
    							<thead class="bg-dark">
    								<tr class="bg-dark">
    									<th>S.No.</th>
    									<th>REFERENCE No.</th>
    									<th>DEPARTMENT</th>
    									<th>EMPLOYEE NAME</th>
    									<th>REQUEST SUBMIT DATE</th>
    									<th>LEAVE DATE'S</th>
    									<th>LEAVE DURATION</th>
    									<th>LEAVE ADJUSTMENT'S</th>
    									<th>REASON</th>
    									<th>REMARK</th>
    									<th>HOD STATUS</th>
    									<th>LAST UPDATE</th>
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
        previous = $(this).val();
        that = this;
    }).change(function() {
		var req_id = $(that).data('rid');
		var status = $(that).val();
		var c = confirm('Are you sure!');
		if(c){	
			$.ajax({
				type: 'POST',
				url: baseUrl+'hod/leave-request-update/',
				data: { 
					'req_id' : req_id,
					'key' : 'hod_status',
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
	
	$(document).on('blur','.hod_remark',function(){
		var req_id = $(this).data('rid');
		var status = $(this).val();		
		$.ajax({
			type: 'POST',
			url: baseUrl+'hod/leave-request-update/',
			data: { 
				'req_id' : req_id,
				'key' : 'hod_remark',
				'value' : status,
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					//location.reload();
				} else {
				}
			}
		});
	});


	leavePendingRequests(0);	//load pending requests
	$(document).on('keyup','#search',function(){
		leavePendingRequests(0);
	});
	
	function leavePendingRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/hod_ctrl/leave_pending_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.refrence_id +'</td>'+
            						'<td>'+ value.dept_name +'</td>'+
            						'<td>'+ value.emp_name +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						'<td>'+ value.duration +'</td>'+
            					    '<td>COFF\'s:</br>'+ value.COFF +'</br>NH/FH\'s:</br>'+ value.NHFH +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td><textarea class="hod_remark" data-rid="'+ value.id +'">'+ value.hod_remark +'</textarea></td>'+
    								'<td><select class="hod_status" data-rid="'+ value.id +'">'+
                        							'<option value="PENDING" selected>PENDING</option>'+
                        							'<option value="REJECTED">REJECTED</option>'+
                        							'<option value="GRANTED">GRANTED</option>'+
                    							'</select></td>'+  	
            					'</tr>';
            		});         	
            		$('#leave_pending_requests_body').html(x);
            		$('#leave_pending_requests_links').html(response.data.links);
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
		ajax_test(x[1]);	
	});
	




	leaveRequests(0);	//load pending requests
	$(document).on('keyup','#search2',function(){
		leaveRequests(0);
	});
	
	function leaveRequests(page){
		var str = $('#search2').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/hod_ctrl/leave_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.refrence_id +'</td>'+
            						'<td>'+ value.dept_name +'</td>'+
            						'<td>'+ value.emp_name +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						'<td>'+ value.duration +'</td>'+
            					    '<td>COFF\'s:</br>'+ value.COFF +'</br>NH/FH\'s:</br>'+ value.NHFH +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td><textarea class="hod_remark" data-rid="'+ value.id +'">'+ value.hod_remark +'</textarea></td>'+
    								'<td><select class="hod_status" data-rid="'+ value.id +'">'+
                        							'<option value="PENDING" selected>PENDING</option>'+
                        							'<option value="REJECTED">REJECTED</option>'+
                        							'<option value="GRANTED">GRANTED</option>'+
                    							'</select></td>'+  	
            					'</tr>';
            		});         	
            		$('#leave_requests_body').html(x);
            		$('#leave_requests_links').html(response.data.links);
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
		ajax_test(x[1]);	
	});

	
});
</script>
</body>