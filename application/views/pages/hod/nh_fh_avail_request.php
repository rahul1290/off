  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">		
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">NH FH AVAIL REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HOD section</li>
						<li class="breadcrumb-item active">HH/FH avail request</li>
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
                  		<a class="nav-link active" id="#pending_requests_tab" data-toggle="tab" href="#pending_requests">NEW NH FH AVAIL REQUEST</a>
                	</li>
                	<li class="nav-item">
                  		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#previous_requests">PREVIOUS NH FH AVAIL REQUEST</a>
                	</li>
          		</ul>
                
                  <div class="tab-content"><br/>
                    <div id="pending_requests" class="tab-pane fade in active show">
                      <div class="col-md-12">
        				<div class="card card-info">
        				  <div class="card-header" style="border-radius:0px;">
        					<h3 class="card-title">NEW NH FH AVAIL REQUEST</h3>
        				  </div>
        				  
        				  <div class="card-body">
        					<div class="table-responsive">
        						<input id="search" type="text" class="float-right mb-2">
        						<label class="float-right mr-2" for="search">Search: </label>
        						<table class="table table-bordered table-striped text-center" id="nhfh_avail_pending_requests_head">
        							<thead class="bg-dark">
        								<tr>
                							<th>S.No.</th>
        									<th>REFERENCE No.</th>
        									<th>DEPARTMENT</th>
        									<th>EMPLOYEE NAME</th>
        									<th>REQUEST SUBMIT DATE</th>
        									<th>NH/FH DUTY DATE</th>
        									<th>REASON</th>
        									<th>REMARK</th>
        									<th>HOD STATUS</th>
                						</tr>
        							</thead>
        							<tbody id="nhfh_avail_pending_requests_body"></tbody>
        						</table>
        						<nav aria-label="Page navigation example" id="nhfh_avail_pending_requests_links"></nav>
        					</div>
        				</div>
        				</div>
        			  </div>
                    </div>
                    
                    <div id="previous_requests" class="tab-pane fade">
            			<div class="col-md-12">
            				<div class="card card-info">
            				  <div class="card-header" style="border-radius:0px;">
            					<h3 class="card-title">PREVIOUS NH FH AVAIL REQUEST</h3>
            				  </div>
            				  <div class="card-body">
            				  	<div class="table-responsive">
            						<input id="search2" type="text" class="float-right mb-2">
            						<label class="float-right mr-2" for="search2">Search: </label>
            						<table class="table table-bordered table-striped text-center" id="nhfh_avail_requests_head">
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
            							<tbody id="nhfh_avail_requests_body"></tbody>
            						</table>
            						<nav aria-label="Page navigation example" id="nhfh_avail_requests_links"></nav>
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
	var req_id;
	var that;
	
	$(document).on('focus','.hod_status',function(){
        previous = $(this).val();
		that = this;
    }).change(function() {
    	req_id = $(that).data('rid');
    	status = $(that).val();
		remark = $('#hod_remark_'+req_id).val();
		if(previous != $(that).val()){
    		var c = confirm('Are you sure!');
    		if(c){
    			$.ajax({
    				type: 'POST',
    				url: baseUrl+'hod/nh-fh-avail-request-update/',
    				data: { 
    					'req_id' : req_id,
    					'status' : status,
    					'remark' : remark,
    				},
    				dataType: 'json',
    				beforeSend: function() {},
    				success: function(response){
    					if(response.status == 200){
    						nhfhAvailPendingRequests(0);
    					} else {
    					}
    				}
    			});
    		} else {
    			$(that).val(previous);
    		} 
		}
    });


	nhfhAvailPendingRequests(0);	//load pending requests
	$(document).on('keyup','#search',function(){
		nhfhAvailPendingRequests(0);
	});
	
	function nhfhAvailPendingRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/nh_fh_avail_ctrl/nh_fh_avail_pending_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#nhfh_pending_requests_body').html('<td class="text-center" ></td>');
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
            		$('#nhfh_avail_pending_requests_body').html(x);
            		$('#nhfh_avail_pending_requests_links').html(response.data.links);
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
		nhfhAvailPendingRequests(x[1]);	
	});



	
	$(document).on('click','#previous_requests_tab',function(){
		nhfhAvailRequests(0);	//load pending requests			
	});

	$(document).on('keyup','#search',function(){
		nhfhAvailRequests(0);
	});
	
	function nhfhAvailRequests(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'hod/nh_fh_avail_ctrl/nh_fh_avail_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
        		$('#nhfh_avail_requests_body').html('<td class="text-center" ></td>');
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
            		$('#nhfh_avail_requests_body').html(x);
            		$('#nhfh_avail_requests_links').html(response.data.links);
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
		nhfhAvailRequests(x[1]);	
	});
	
});
</script>
</body>