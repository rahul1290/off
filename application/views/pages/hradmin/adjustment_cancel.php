<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">PL Adjustment Cancel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">PL Adjustment Cancel</li>
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
              		<a class="nav-link active" id="#leave_adjustment_tab" data-toggle="tab" href="#leave_adjustment_cacellation">LEAVE ADJUSTMENT CANCELLATION</a>
            	</li>
            	<li class="nav-item">
              		<a class="nav-link" id="hf_day_tab" data-toggle="tab" href="#hf_day_cancellation">HALF DAY CANCELLATION</a>
            	</li>
          	</ul>
          	
          	<div class="tab-content">
          		<div id="leave_adjustment_cacellation" class="tab-pane active"><br>
          			<div class="offset-1 col-6">
              			<label>Select Request</label>
              			<select id="leave_request">
              				<option value="0">Select Request</option>
              				<?php if(count($requests)>0){ foreach($requests as $request){ ?>
              					<option value="<?php echo $request['id']; ?>"><?php echo $request['reference_id']; ?></option>
              				<?php } } ?>
              			</select>
          			</div>
          			
          			<div class="offset-1 col-6 mt-3" id="leave_request_detail" style="display: none;"></div>
          		</div>
          		
          		
          		<div id="hf_day_cancellation" class="tab-pane fade"><br>
          			<div class="offset-1 col-6">
              			<label>Select Request</label>
              			<select id="hf_leave_request">
              				<option value="0">Select Request</option>
              				<?php if(count($hf_requests)>0){
              				    foreach($hf_requests as $hf_request){ ?>
              				      <option value="<?php echo $hf_request['id']; ?>"><?php echo str_replace('-', '/', $hf_request['reference_id']); ?></option>  
              				<?php }
              				}?>
              			</select>
          			</div>
          			<div class="offset-1 col-6 mt-3" id="hf_request_detail" style="display: none;"></div>
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

	$(document).on('change','#leave_request',function(){
		var ref_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/leave_detail/',
        	data: {
            	'ref_id' : ref_id
            },
        	dataType: 'json',
        	beforeSend: function() {
        		$('#leave_request_detail').html('').hide();
            },
        	success: function(response){
            	if(response.status == 200){
                	var x = '<table width="100%" border="1">'+
                  				'<tr>'+
            						'<td><b>Name:</b></td>'+
            						'<td>'+ response.data.user_detail[0].name +'</td>'+
            						'<td><b>Emp Code:</b></td>'+
            						'<td>'+ response.data.user_detail[0].ecode +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td><b>Department:</b></td>'+
            						'<td>'+ response.data.user_detail[0].dept_name +'</td>'+
            						'<td><b>Emp Designation:</b></td>'+
            						'<td>'+ response.data.user_detail[0].desg_name +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td><b>Date Duration:</b></td>'+
            						'<td>'+ response.data.leave_detail[0].date_from.split("-").reverse().join("/") +'-' + response.data.leave_detail[0].date_to.split("-").reverse().join("/") +'</td>'+
            						'<td><b>Reason:</b></td>'+
            						'<td>'+ response.data.leave_detail[0].requirment +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td><b>Leave Requested:</b></td>'+
            						'<td colspan="3">'+ response.data.leave_detail[0].hr_remark +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td colspan="4" class="bg-dark text-center">HOD SECTION</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td><b>HOD Remark:</b></td>'+
            						'<td>'+ response.data.leave_detail[0].hod_remark +'</td>'+
            						'<td><b>Approval Status:</b></td>'+
            						'<td>'+ response.data.leave_detail[0].hod_status +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td colspan="4" class="bg-dark text-center">HR Cancellation  Section</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td><b>HR Remarks :</b></td>'+
            						'<td>'+ response.data.leave_detail[0].hr_remark +'</td>'+
            						'<td><b>LOP :</b></td>'+
            						'<td>'+ response.data.leave_detail[0].lop +'</td>'+
            					'</tr>'+
            					'<tr class="bg-dark text-center">'+
            						'<td><b>Avail FH/NH :</b></td>'+
            						'<td><b>Avail Comp OFFs :</b></td>'+
            						'<td colspan="2"><b>Remaining PL :</b>'+ response.data.pls[0].balance +'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td colspan="4" class="text-right">'+
            							'<label><b>Select PL to Cancel :</b></label>'+
            							'<select id="pl_cancel">';
            								for(i=0; i<=101; i++){
                								x = x + '<option value="'+ i +'">'+ i +'</option>';
            								}
            					x = x + '</select>'+
            						'</td>'+
            					'</tr>'+
            					'<tr>'+
            						'<td colspan="4" class="text-center">'+
            							'<input type="button" id="leave_cancel" value="Cancel Adjustment" />'+
            						'</td>'+
            					'</tr>'+
            				'</table>';
            		$('#leave_request_detail').html(x).show();
                }
        	}
		});
	});

	$(document).on('change','#hf_leave_request',function(){
		var ref_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'hr/Hf_leave_ctrl/request_detail/',
        	data: {
            	'ref_id' : ref_id
            },
        	dataType: 'json',
        	beforeSend: function() {
        		$('#hf_request_detail').html('').hide();
            },
        	success: function(response){    	
            	if(response.status == 200){
					console.log(response);
            		var x = '<table width="100%" border="1">'+
        						'<tr>'+
                    				'<td><b>Name:</b></td>'+
                    				'<td>'+ response.data.user_detail[0].name +'</td>'+
                    				'<td><b>Emp Code:</b></td>'+
                    				'<td>'+ response.data.user_detail[0].ecode +'</td>'+
        						'</tr>'+
                    			'<tr>'+
                    				'<td><b>Department:</b></td>'+
                    				'<td>'+ response.data.user_detail[0].dept_name +'</td>'+
                    				'<td><b>Date Duration:</b></td>'+
                    				'<td>'+ response.data.leave_detail[0].date_from.split("-").reverse().join("/") +'</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td><b>Reason:</b></td>'+
                    				'<td colspan="3">'+ response.data.leave_detail[0].requirment +'</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td colspan="4" class="text-center bg-dark">HOD SECTION</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td><b>HOD Remarks:</b></td>'+
                    				'<td>'+ response.data.leave_detail[0].hod_remark +'</td>'+
                    				'<td><b>Approval status:</b></td>'+
                    				'<td>'+ response.data.leave_detail[0].hr_status +'</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td colspan="4" class="text-center bg-dark">HR CANCELLATION SECTION</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td><b>HR Remarks:</b></td>'+
                    				'<td>'+ response.data.leave_detail[0].hod_remark +'</td>'+
                    				'<td><b>LOP:</b></td>'+
                    				'<td>'+ response.data.leave_detail[0].lop +'</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td><b>Remaining PL:</b></td>'+
                    				'<td colspan="3">'+ response.data.pls[0].balance +'</td>'+
                    			'</tr>'+
                    			'<tr>'+
                    				'<td colspan="4" class="text-center">'+
                    					'<input type="button" name="submit" id="submit" value="Cancel Adjustment">'+
                    				'</td>'+
                    			'</tr>'+
                    		'</table>';
            		$('#hf_request_detail').html(x).show();
                }
        	}
		});
	});

	$(document).on('click','#submit',function(){
		var id = $('#hf_leave_request').val();
		var ref_id = $('#hf_leave_request option:selected').text();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'hr/Hf_leave_ctrl/cancel_adjustment/',
        	data: {
            	'ref_id' : ref_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	if(response.status == 200){
                	alert(response.msg);
                	$('#hf_request_detail').html('').hide();
                	$("#hf_leave_request option[value='"+ id +"']").remove();	
                }
        	}
		});
	});


	$(document).on('click','#leave_cancel',function(){
		var id = $('#leave_request').val();
		var ref_id = $('#leave_request option:selected').text();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/cancel_adjustment/',
        	data: {
            	'ref_id' : ref_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	if(response.status == 200){
                	alert(response.msg);
                	$('#leave_request_detail').html('').hide();
                	$("#leave_request option[value='"+ id +"']").remove();	
                } else {
                	alert(response.msg);
                }
        	}
		});
		
	});
</script>
</body>