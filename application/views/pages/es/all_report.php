<?php if(!isset($pls[0]['balance'])){ 
	$pls[0]['balance'] = 0;
}?>
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
					  <input type="text" name="from_date" id="from_date" class="form-control datepicker" value="<?php if(isset($fromdate)){ echo $fromdate; } else { echo date('01-m-Y'); }?>" autocomplete="off">
				</span>
				<span class="col">
					  <input type="text" name="to_date" id="to_date" class="form-control datepicker" value="<?php if(isset($todate)){ echo $todate; } else { echo date("d/m/Y", strtotime(date('Y-m-d'))); } ?>" autocomplete="off">
				</span>
				<span class="col">
					<input type="submit" value="Search" class="btn btn-secondary">
					<a href="<?php echo base_url('es/All-Report');?>" class="btn btn-secondary">Reset</a>
				</span>
				</div>
			</form>
		  </div>
		
		<?php if(count($records)>0){ ?>	
		  <div class="col-md-12">
			<div class="card card-info">
			  <div class="card-header" style="border-radius:0px;">
				<span class="card-title">ALL REQUESTS</span>
				<span class="float-right">Current Remaining Pl's : <?php echo $pls[0]['balance']; ?></span>
			  </div>
			  <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="example">
						<thead>	
							<tr class="bg-dark">
								<th>S.No.</th>
								<th>REFERENCE NO.</th>
								<th>REQUEST SUBMIT DATE</th>
								<th>LEAVE DATE</th>
								<th>REASON</th>
								<th>PL DEDUCT</th>
								<th>LOP</th>
								<th>LEAVE ADJUSTMENT</th>
								<th>HOD REMARK</th>
								<th>HR REMARKS</th>
								<th>HOD STATUS</th>
								<th>HR STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php $c=1; foreach($records as $record){ ?>
								<tr>
									<td><?php echo $c++; ?>.</td>
									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
									<td><?php echo $record['created_at']; ?></td>
									<td><?php echo $record['from_date'].' - '.$record['to_date']; ?></td>
									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
									<td><?php if((int)$record['pl']){ echo (int)$record['pl']; } else { echo '-'; } ?></td>
									<td><?php if((int)$record['lop']){ echo (int)$record['lop']; }else { echo '-'; } ?></td>
									<td>COFF'S:</br><?php echo $record['COFF']; ?></br>NH/FH:<?php echo $record['NHFH']; ?></td>
									<td><?php echo $record['hod_remark']; ?></td>
									<td><?php echo $record['hr_remark']; ?></td>
									<td class="
									<?php if($record['hod_status'] == 'GRANTED'){ 
											echo "bg-success"; 
										  } else if($record['hod_status'] == 'PENDING') {
											echo "bg-warning";
										  } else {
											echo "bg-danger";
										  }?>"><?php echo $record['hod_status']; ?></td>
									<td class="
									<?php if($record['hr_status'] == 'GRANTED'){ 
											echo "bg-success"; 
										  } else if($record['hr_status'] == 'PENDING') {
											echo "bg-warning";
										  } else {
											echo "bg-danger";
										  }?>"><?php echo $record['hr_status']; ?></td>
									<td>
										<?php if($record['hod_status'] == 'PENDING' && $record['hr_status'] == 'PENDING'){ ?>
										<a href="javascript:void(0);" class="req_cancel" data-id="<?php echo $record['reference_id']; ?>">CANCEL</a>
										<?php } ?>
									</td>
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

	$(document).on('click','.req_cancel',function(){
		var req_id = $(this).data('id');
		$.ajax({
        	type: 'GET',
        	url: baseUrl+'Emp_ctrl/request_cancel/'+ req_id,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {
            	$('.modal').show();
            },
        	success: function(response){
            	if(response.status == 200){
                	alert(response.msg);
                } else {
                    alert(response.msg);
                }
            	location.reload(true); 
        	}
		});
	});
</script>
</body>