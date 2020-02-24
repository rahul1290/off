<?php 
	$fromdate = $this->input->get('from_date');
	$todate = $this->input->get('to_date');
?>
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">All REPORT</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
						<li class="breadcrumb-item active">All Report</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		  
		  <div class="offset-md-1 col-md-10">
			<form name="f2" method="GET" action="<?php echo base_url('es/All-Report');?>">
				<div class="row mb-3">
				<span class="col">
					  <select class="form-control" name="report_type" id="report_type">
						<option value="All">ALL REPORT</option>
						<option value="OFF_DAY" <?php if($this->input->get('report_type') == 'OFF_DAY'){ echo "selected"; }?>>OFF DAY DUTY</option>
						<option value="NH_FH" <?php if($this->input->get('report_type') == 'NH_FH'){ echo "selected"; }?>>NH/FH DAY DUTY</option>
						<option value="HALF" <?php if($this->input->get('report_type') == 'HALF'){ echo "selected"; }?>>HALF DAY DUTY</option>
					  </select>
				</span>
				<span class="col">
					  <input type="text" name="from_date" id="from_date" class="form-control datepicker" value="<?php if(isset($fromdate)){ echo $fromdate; } else { echo date("d-m-Y", strtotime("first day of previous month")); } ?>" autocomplete="off">
				</span>
				<span class="col">
					  <input type="text" name="to_date" id="to_date" class="form-control datepicker" value="<?php if(isset($todate)){ echo $todate; } else { echo date("t/m/Y", strtotime(date('Y-m-d'))); } ?>" autocomplete="off">
				</span>
				<span class="col">
					<input type="submit" value="Search" class="btn btn-secondary">
					<a href="<?php echo base_url('es/All-Report');?>" class="btn btn-secondary">Reset</a>
				</span>
				</div>
			</form>
		  </div>
		
		<?php if(count($records)>0){ ?>	
		  <div class="offset-md-1 col-md-10">
			<div class="card card-info">
			  <div class="card-header" style="border-radius:0px;">
				<h3 class="card-title">ALL REQUESTS</h3>
			  </div>
			  <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="example">
						<thead>	
							<tr class="bg-dark">
								<th>S.No.</th>
								<th>REQUEST TYPE</th>
								<th>REQUEST SUBMIT DATE</th>
								<th>DATE</th>
								<th>REASON</th>
								<th>HOD REMARK</th>
								<th>HOD STATUS</th>
								<th>HR REMARKS</th>
								<th>HR STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php $c=1; foreach($records as $record){ ?>
								<tr>
									<td><?php echo $c++; ?>.</td>
									<td><?php echo str_replace('_',' ',$record['request_type']); ?></td>
									<td><?php echo $record['created_at']; ?></td>
									<td><?php echo $record['date']; ?></td>
									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
									<td><?php echo $record['hod_remark']; ?></td>
									<td class="
									<?php if($record['hod_status'] == 'GRANTED'){ 
											echo "bg-success"; 
										  } else if($record['hod_status'] == 'PENDING') {
											echo "bg-warning";
										  } else {
											echo "bg-danger";
										  }?>"><?php echo $record['hod_status']; ?></td>
									<td><?php echo $record['hr_remark']; ?></td>
									<td class="
									<?php if($record['hr_status'] == 'GRANTED'){ 
											echo "bg-success"; 
										  } else if($record['hr_status'] == 'PENDING') {
											echo "bg-warning";
										  } else {
											echo "bg-danger";
										  }?>"><?php echo $record['hr_status']; ?></td>
									<td><a href="#">CANCEL</a></td>
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
					} else {
						var x = response.msg;
						$('#duty_detail').html('<p class="text-danger"><b>'+ x +'</b></p>');
						$('#submit').prop("disabled", true);
					}
				}
			});
		}
	}
	
});
</script>
</body>