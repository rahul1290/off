<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">HALF DAY LEAVE REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
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
            
              <div class="tab-content"><br/>
                <div id="pending_requests" class="tab-pane fade in active show">
                  <div class="col-md-12">
    				<div class="card card-info">
    				  <div class="card-header" style="border-radius:0px;">
    					<h3 class="card-title">NEW HF REQUESTS</h3>
    				  </div>
    				  
    				  <div class="card-body">
    					<div class="table-responsive">
    						<input id="search" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="hf_pending_requests_head">
    							<thead class="bg-dark">
    								<tr>
            							<th>S.No.</th>
										<th>REFERENCE No.</th>
										<th>DEPARTMENT</th>
										<th>EMPLOYEE NAME</th>
										<th>REQUEST SUBMIT DATE</th>
										<th>HALF TAKEN DATE</th>
										<th>REASON</th>
										<th>REMARK</th>
										<th>HOD STATUS</th>
            						</tr>
    							</thead>
    							<tbody id="hf_pending_requests_body"></tbody>
    						</table>
    						<nav aria-label="Page navigation example" id="hf_pending_requests_links"></nav>
    					</div>
    				</div>
    				</div>
    			  </div>
                </div>
                
                <div id="previous_requests" class="tab-pane fade">
        			<div class="col-md-12">
        				<div class="card card-info">
        				  <div class="card-header" style="border-radius:0px;">
        					<h3 class="card-title">PREVIOUS HF REQUESTS</h3>
        				  </div>
        				  <div class="card-body">
        				  	<div class="table-responsive">
        						<input id="search2" type="text" class="float-right mb-2">
        						<label class="float-right mr-2" for="search2">Search: </label>
        						<table class="table table-bordered table-striped text-center" id="hf_requests_head">
        							<thead class="bg-dark">
        								<tr>
                							<th>S.No.</th>
    										<th>REFERENCE No.</th>
    										<th>DEPARTMENT</th>
    										<th>EMPLOYEE NAME</th>
    										<th>REQUEST SUBMIT DATE</th>
    										<th>HALF TAKEN DATE</th>
    										<th>REASON</th>
    										<th>REMARK</th>
    										<th>HOD STATUS</th>
                						</tr>
        							</thead>
        							<tbody id="hf_requests_body"></tbody>
        						</table>
        						<nav aria-label="Page navigation example" id="hf_requests_links"></nav>
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
	var previous;
	var that;
	$(document).on('focus','.hod_status',function(){
        previous = this.value;
        that = this;
    }).change(function() { 
		var req_id = $(that).data('rid');
		var status = $(that).val();
		
		if(previous != status){
    		var c = confirm('Are you sure!');
    		if(c){
    			remark = $('#hod_remark_'+req_id).val();
    			$.ajax({
    				type: 'POST',
    				url: baseUrl+'hod/hf-leave-request-update/',
    				data: { 
    					'req_id' : req_id,
    					'hod_status' : status,
    					'hod_remark' : remark,
    				},
    				dataType: 'json',
    				beforeSend: function() {},
    				success: function(response){
    					if(response.status == 200){
    						alert('Done');
    						hfPendingRequests(0);
    					} else {
    					}
    				}
    			});
    		} else {
    			$(that).val(previous);
    		}
		}        
    });

	hfPendingRequests(0);	//load pending requests
	$(document).on('keyup','#search',function(){
		hfPendingRequests(0);
	});
	
	function hfPendingRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/hf_leave_ctrl/hf_pending_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#hf_pending_requests_body').html('<td colspan="9" class="text-center">Fatching record.</td>');
            },
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			if(typeof(response.data.final_array) != 'undefined'){
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
        			} else {
        				x = '<td colspan="9" class="text-center">No record found.</td>';
                	}
            		$('#hf_pending_requests_body').html(x);
            		$('#hf_pending_requests_links').html(response.data.links);
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
		hfPendingRequests(x[1]);	
	});


	

	$(document).on('click','#previous_requests_tab',function(){
		hfRequests(0);	
	});
	
	$(document).on('keyup','#search',function(){
		hfRequests(0);
	});
	
	function hfRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/hf_leave_ctrl/hf_request_ajax/'+ page +'/'+ str,
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
            		$('#hf_requests_body').html(x);
            		$('#hf_requests_links').html(response.data.links);
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
		hfRequests(x[1]);	
	});
	
});
</script>
</body>