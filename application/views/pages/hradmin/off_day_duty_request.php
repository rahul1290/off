  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">EMPLOYEE'S OFF DAY DUTY REQUESTS</h1>
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
		
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">NEW REQUESTS</h3>
				  </div>
				  <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="example">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>DEPARTMENT</th>
									<th>EMPLOYEE NAME</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>HALF TAKEN DATE</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<th>HR REMARK</th>
									<th>HR STATUS</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($pending_requests)>0){?>
									<?php $c=1; foreach($pending_requests as $request){?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $request['refrence_id']; ?></td>
											<td><?php echo $request['dept_name']; ?></td>
											<td><?php echo $request['name']; ?></td>
											<td><?php echo $request['created_at']; ?></td>
											<td><?php echo $request['date']; ?></td>
											<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
											<td>
												<label><?php echo $request['hod_remark']; ?><br/><?php echo $request['hod_remark_date']; ?></label>
											</td>
											<td>
												<label><?php echo $request['hod_status']; ?><br/><?php echo $request['hod_remark_date']; ?></label>
											</td>
											<td>
												<textarea class="form-control hr_remark" data-rid="<?php echo $request['id']; ?>"><?php if(isset($request['hr_remark'])){ echo $request['hr_remark']; }?></textarea>
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
								<?php } ?>
							</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </div>
		
		
		
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">PREVIOUS OFF DAY REQUESTS</h3>
				  </div>
				  <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="example2">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>DEPARTMENT</th>
									<th>EMPLOYEE NAME</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>HALF TAKEN DATE</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<th>HR REMARK</th>
									<th>HR STATUS</th>
									<th>LAST UPDATE</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($requests)>0){?>
									<?php $c=1; foreach($requests as $request){ ?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $request['refrence_id']; ?></td>
											<td><?php echo $request['dept_name']; ?></td>
											<td><?php echo $request['name']; ?></td>
											<td><?php echo $request['created_at']; ?></td>
											<td><?php echo $request['date']; ?></td>
											<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
											<td><label><?php echo $request['hod_remark']; ?></label></td>
											<td><?php echo $request['hod_status']; ?><hr/><?php echo $request['hod_remark_date']; ?></td>
											<td><label><?php echo $request['hr_remark']; ?></label></td>
											<td><?php echo $request['hr_status']; ?><hr/><?php echo $request['hr_remark_date']; ?></td>
											<td><?php echo $request['hr_name']; ?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
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

    $(".hr_status").on('focus', function () {
        previous = this.value;
    }).change(function() {
		var req_id = $(this).data('rid');
		var status = $(this).val();
		var that = this;
		var c = confirm('Are you sure!');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'hr/hf-leave-request-update/',
				data: { 
					'req_id' : req_id,
					'key' : 'hr_status',
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
		} else {
			$(that).val(previous);
		}
        
    });
	
	$(document).on('blur','.hr_remark',function(){
		var req_id = $(this).data('rid');
		var status = $(this).val();		
		$.ajax({
			type: 'POST',
			url: baseUrl+'hr/hf-leave-request-update/',
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
	
});
</script>
</body>