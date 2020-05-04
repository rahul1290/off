  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">NH FH DAY DUTY REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HOD section</li>
						<li class="breadcrumb-item active">HH/FH day duty request</li>
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
					<h3 class="card-title">NEW NH/FH REQUESTS</h3>
				  </div>
				  <div class="card-body">
					<?php if(count($pending_requests)>0){?>
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="example">
							<thead>	
								<tr class="bg-dark">
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
							<tbody>
									<?php $c=1; foreach($pending_requests as $request){ ?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
											<td><?php echo $request['dept_name']; ?></td>
											<td><?php echo $request['name']; ?></td>
											<td><?php echo $request['created_at']; ?></td>
											<td><?php echo $request['date']; ?></td>
											<td><?php echo strlen($request['requirment']) > 50 ? ucfirst(substr($request['requirment'],0,50))."...<a href='#'>read more</a>" : ucfirst($request['requirment']); ?></td>
											<td>
												<textarea class="form-control hod_remark" name="hod_remark" data-rid="<?php echo $request['id']; ?>"><?php echo $request['hod_remark']; ?></textarea>
											</td>
											<td>
												<select class="hod_status" name="hod_status" data-rid="<?php echo $request['id']; ?>">
													<option value="PENDING" <?php if($request['hod_status'] == 'PENDING'){ echo 'selected'; }?>>PENDING</option>
													<option  value="REJECTED" <?php if($request['hod_status'] == 'REJECTED'){ echo 'selected'; }?>>REJECTED</option>
													<option  value="GRANTED" <?php if($request['hod_status'] == 'GRANTED'){ echo 'selected'; }?>>GRANTED</option>
												</select>
											</td>
										</tr>
									<?php } ?>
							</tbody>
						</table>
					</div>
					<?php } else {
						echo "<p class='text-center'>No new record found.</p>"; ;
					}?>
				  </div>
				</div>
			  </div>
		
		
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">PREVIOUS HF REQUESTS</h3>
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
									<th>NH/FH DUTY DATE</th>
									<th>REASON</th>
									<th>REMARK</th>
									<th>HOD STATUS</th>
									<th>LAST UPDATE</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($requests)>0){?>
									<?php $c=1; foreach($requests as $request){ ?>
										<tr>	
											<td><?php echo $c++; ?>.</td>
											<td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
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
											<td><?php echo $request['last_update']; ?></td>
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

    $(".hod_status").on('focus', function () {
        previous = this.value;
    }).change(function() {
		var req_id = $(this).data('rid');
		var status = $(this).val();
		var that = this;
		var c = confirm('Are you sure!');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'hod/hf-leave-request-update/',
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
			url: baseUrl+'hod/hf-leave-request-update/',
			data: { 
				'req_id' : req_id,
				'key' : 'hod_remark',
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