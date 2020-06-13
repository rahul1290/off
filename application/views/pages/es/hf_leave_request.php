  
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
                <span class="float-right">Current Remaining Pl's : <?php $pl = $this->my_library->pl_calculator($this->session->userdata('ecode')); echo $pl[0]['balance']; ?></span>
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
						<td><b>Date</b></td>
						<td>
							<input type="text" name="half_day_date" id="half_day_date" class="form-control datepicker" value="<?php echo set_value('half_day_date'); ?>" autocomplete="off" maxdate="<?php echo date('Y-m-d'); ?>">
							<?php echo form_error('half_day_date'); ?>
							<span id="duty_detail"></span>
						</td>

					</tr>
					<tr>
						<td><b>REASON FOR LEAVE</b></td>
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
		  
		  <?php if(count($requests)>0){?>
			  <div class="col-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">PREVIOUS HF REQUEST STATUS</h3>
				  </div>
				  <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped text-center" id="example">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>HALF TAKEN DATE</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<!--th>HR REMARKS</th>
									<th>HR STATUS</th-->
								</tr>
							</thead>
							<tbody>
								<?php $c=1; foreach($requests as $request){ ?>
									<tr>	
										<td><?php echo $c++; ?>.</td>
										<td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
										<td><?php echo $request['created_at']; ?></td>
										<td><?php echo $request['date']; ?></td>
										<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
										<td><?php echo ucfirst($request['hod_remark']); ?></td>
										<td class="
											<?php if($request['hod_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hod_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"
										><?php echo $request['hod_status']; ?><?php //echo $request['hod_remark_date']; ?></td>
										<?php /*<td><?php echo $request['hr_remark']; ?></td>
										<td class="
											<?php if($request['hr_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hr_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"
										><?php echo $request['hr_status']; ?></td>
										*/ ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </div>
		<?php } ?>
		  
		  
		
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
	$('#example').DataTable();
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
	
});
</script>
</body>