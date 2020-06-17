<?php if(!isset($pls[0]['balance'])){ 
	$pls[0]['balance'] = 0;
}?>
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
		<form name="f1" method="POST" action="<?php echo base_url('/es/hf-leave-request');?>">
		<div class="col-12 mb-3">
			<?php echo $this->session->flashdata('msg'); ?>
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title">HALF DAY LEAVE REQUEST</span>
                <span class="float-right">Current Remaining Pl's : <?php echo $pls[0]['balance']; ?></span>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
					<tr>
						<td><b>I , MR./ MS./ MRS.</b></td>
						<td>
							<span><?php echo ucfirst($this->session->userdata('username')); ?> [ <?php echo $this->session->userdata('ecode'); ?> ]</span>
						</td>
					</tr>
					<tr>
						<td><b>DATE</b><span class="text-danger">*</span></td>
						<td>
							<input type="text" name="half_day_date" id="half_day_date" class="form-control datepicker" value="<?php echo set_value('half_day_date'); ?>" autocomplete="off" max-date="<?php echo date('Y-m-d'); ?>">
							<?php echo form_error('half_day_date'); ?>
							<span id="duty_detail"></span>
						</td>

					</tr>
					<tr>
						<td><b>REASON FOR LEAVE</b><span class="text-danger">*</span></td>
						<td>
							<textarea class="form-control" id="reason" name="reason"><?php echo set_value('reason'); ?></textarea>
							<?php echo form_error('reason'); ?>
						</td>
					</tr>
				</table>
				
              </div>
            </div>
				<div class="text-center">
					<input type="submit" id="submit" value="Send" class="btn btn-warning" disabled>
					<input type="reset" value="Cancel" class="btn btn-secondary">
				</div>
          </div>
		</form>
		  <hr/>
		
		<div class="col-12">
			<div class="card card-info">
			  <div class="card-header" style="border-radius:0px;">
				<h3 class="card-title">PREVIOUS HF REQUEST STATUS</h3>
			  </div>
			  <div class="card-body">
				<div class="table-responsive">
					<input id="search" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="hf_requests_head">
						<thead>	
							<tr class="bg-dark">
								<th>S.No.</th>
								<th>REFERENCE No.</th>
								<th>REQUEST SUBMIT DATE</th>
								<th>HALF TAKEN DATE</th>
								<th>REASON</th>
								<th>PL</th>
								<th>LOP</th>
								<th>HOD REMARK</th>
								<th>HOD STATUS</th>
								<th>HR REMARKS</th>
								<th>HR STATUS</th>
							</tr>
						</thead>
						<tbody id="hf_requests_body"></tbody>
					</table>
					<nav aria-label="Page navigation example" id="hf_requests_links"></nav>
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

$(function() {
	$( ".datepicker" ).datepicker({
	   //appendText:"(yy-mm-dd)",
	   dateFormat:"dd/mm/yy",
	   altField: "#datepicker-4",
	   altFormat: "dd/mm/yy"
	});
});

$(document).ready(function(){
	//$('#example').DataTable();
	get_detail();
	
	$(document).on('change','#half_day_date',function(){
		get_detail();
	});
	
	
	function get_detail(){
		var off_day_date = $('#half_day_date').val();
		if(off_day_date != ''){
			off_day_date = $('#half_day_date').val();
			off_day_date = off_day_date.split("/").reverse().join("-");

			$.ajax({
				type: 'POST',
				url: baseUrl+'Emp_ctrl/day_attendance/'+ off_day_date + '/'+ <?php echo "'".$this->session->userdata('ecode')."'"; ?>+'/HALF',
				data: { },
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						$('#submit').prop("disabled", false);
						$('#duty_detail').html('').hide();
					} else {
						var x = response.msg;
						$('#duty_detail').html('<p class="text-danger"><b>'+ x +'</b></p>').show();
						$('#submit').prop("disabled", true);
					}
				}
			});
		}
	}
	
	
	$(document).on('click','.cancel',function(){
		var req_id = $(this).data('request_id');
		var c = confirm('Are you sure to cance this request.');
		if(c){
			$.ajax({
				type: 'GET',
				url: baseUrl+'/es/hf-leave-request-cancel/'+req_id,
				data: { },
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						alert(response.msg);
						location.reload();
					} else {
						alert(response.msg);
					}
				}
			});
		}
	});


	$('#half_day_date').keypress(function(e) {
	    e.preventDefault();
	}); 
	

	ajax_test(0);	//load requests
	
	$(document).on('keyup','#search',function(){
		ajax_test(0);
	});
	
	function ajax_test(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'Emp_ctrl/hf_leave_request_ajax/'+ page +'/'+ str,
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
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td>'+ value.pl +'</td>'+
            						'<td>'+ value.lop +'</td>'+
            						'<td>'+ value.hod_remark +'</td>';
            						var bgcolor = '';
            						if(value.hod_status == 'REJECTED'){
            							bgcolor = 'bg-danger';
                					} else if(value.hod_status == 'GRANTED'){
                						bgcolor = 'bg-success';
                    				}else if(value.hod_status == 'PENDING'){
                						bgcolor = 'bg-warning';
                    				}
            						x = x+'<td class="'+ bgcolor +'">'+ value.hod_status +'</td>'+
            							'<td>'+ value.hr_remark +'</td>';
            						var bgcolor = '';
            						if(value.hr_status == 'REJECTED'){
            							bgcolor = 'bg-danger';
                					} else if(value.hr_status == 'GRANTED'){
                						bgcolor = 'bg-success';
                    				}else if(value.hr_status == 'PENDING'){
                						bgcolor = 'bg-warning';
                    				}
            						x = x+'<td class="'+ bgcolor +'">'+ value.hr_status +'</td>'+ 	
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
		ajax_test(x[1]);	
	});
	
});
</script>
</body>