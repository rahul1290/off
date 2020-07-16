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
		  
		  <div class="form-group row">
			<label for="department" class="col-sm-2 col-form-label">Department</label>
			<div class="col-sm-10">
			  <select class="form-control" name="department" id="department">
				<option value="0">Select Department</option>
				<?php 
				foreach($departments as $department){ ?>
					<option value="<?php echo $department['id'];?>"
					<?php if($this->uri->segment(3) == ''){  
					       if($department['id'] == $this->session->userdata('department_id')) { echo "selected"; } } 
					      else {
					        if($department['id'] == $this->uri->segment(3)) { echo "selected"; }
					      } ?>>
					   <?php echo $department['dept_name'];?>
					</option>
				<?php } ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group row">
			<label for="employee" class="col-sm-2 col-form-label">Employee Name</label>
			<div class="col-sm-10">
			  <select class="form-control" name="employee" id="employee">
				<option value="0">Select Employee</option>
				<?php 
					foreach($users as $user){ ?>
						<option value="<?php echo $user['ecode']; ?>"
						<?php if($this->uri->segment(4) == ''){ 
						          if($user['ecode'] == $this->session->userdata('ecode')) { echo "selected"; } }
						      else {
						          if($user['ecode'] == $this->uri->segment(4)) { echo "selected"; }
						      }?>>
						  <?php echo $user['name']; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="offset-2 col-sm-10">
		  	<input type="button" id="getDetail" value="View" class="btn btn-default">
		  	<input type="button" value="Cancel" class="btn btn-danger">
		  </div>
		  <hr/>
		
		<ul class="nav nav-tabs">
			<li class="nav-item">
          		<a class="nav-link active" id="#pending_requests_tab" data-toggle="tab" href="#all_requests">All</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="#pending_requests_tab" data-toggle="tab" href="#full_day_leave_requests">Full Day Leaves Taken</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#half_day_leave_requests">Half Day Leaves Taken</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#off_day_duty_requests">Off Day Duty Detail</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#nh_fh_day_duty_requests">NH/FH Day Duty Detail</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#tour_requests">TOUR DETAIL</a>
        	</li>
        	<li class="nav-item">
          		<a class="nav-link" id="previous_requests_tab" data-toggle="tab" href="#nh_fh_avail_requests"> NH/FH Day Avail Detail</a>
        	</li>
      	</ul>
      	
      	<div class="tab-content">
      		<div id="all_requests" class="tab-pane active"><br>
      			<!-- 
          		----------  All Request  ----------- 
          		-->
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			<div class="card-header m-0 p-0 pl-2" style="border-radius: 0px;">Full Day Leaves Taken</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table-bordered table-striped" id="example">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>LEAVE DURATION</th>
        								<th>REASON</th>
        								<th>HOD REMARK</th>
        								<th>HR REMARKS</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'LEAVE'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date'].' - '.$record['to_date']; ?></td>
        									<td><?php echo $this->my_library->day_duration($record['from_date'],$record['to_date']);?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example').DataTable({"pageLength": 5});</script>
        			  </div>
        			</div>
        		  </div>
        		  <hr/>
				 <!-- Half day leave taken -->
				 
				  <div class="col-md-12">
        			<div class="card card-warning">
        			<div class="card-header m-0 p-0 pl-2" style="border-radius: 0px;">Half Day Leaves Taken</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example_2">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'HALF'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example_2').DataTable({"pagelength":4});</script>
        			  </div>
        			</div>
        		  </div>
        		  <hr/>
        		  
        		  <!-- OFF DAY -->
        		  <div class="col-md-12">
        			<div class="card card-secondary">
        			<div class="card-header m-0 p-0 pl-2" style="border-radius: 0px;">Off Day Duty Detail</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example_3">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>WEEK OFF DAY</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'OFF_DAY'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo $record['wod']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example_3').DataTable({"pagelength":3});</script>
        			  </div>
        			</div>
        		  </div>	 
        		  <hr/>
        		  
        		  <!-- NH/FH Day Duty Detail -->
        		  <div class="col-md-12">
        			<div class="card card-info">
        			<div class="card-header m-0 pl-2 p-0" style="border-radius: 0px;">NH/FH Day Duty Detail</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example_4">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'NH_FH'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example_4').DataTable({"pagelength":3});</script>
        			  </div>
        			</div>
        		  </div>  
        		  <hr/>
        		  
        		  <!-- tour -->
        		  <div class="col-md-12">
        			<div class="card card-primary">
        			<div class="card-header m-0 p-0 pl-2" style="border-radius: 0px;">Tour</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example_5">
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
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'TOUR'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date'].' - '.$record['to_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
        									<td><?php if((int)$record['pl']){ echo (int)$record['pl']; } else { echo '-'; } ?></td>
        									<td><?php if((int)$record['lop']){ echo (int)$record['lop']; }else { echo '-'; } ?></td>
        									<td>COFF'S:</br><?php echo $record['COFF']; ?></br>NH/FH:<?php echo $record['NHFH']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example_5').DataTable({"pagelength":3});</script>
        			  </div>
        			</div>
        		  </div>     		  
        		  <hr/>
        		  
        		  <!-- NH FH Avail -->
        		  <div class="col-md-12">
        			<div class="card card-warning">
        			<div class="card-header m-0 p-0 pl-2" style="border-radius: 0px;">NH FH Avail Deatil</div>
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example_6">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'NH_FH_AVAIL'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example_6').DataTable({"pagelength":3});</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>
      		</div>
      	
      	
      	
      	
      	
      	
      	
      	
      	
      	
      	
      	
      		<!-- 
      		----------  Full day leave request  ----------- 
      		-->
      		<div id="full_day_leave_requests" class="tab-pane fade"><br>
      			
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example1">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>LEAVE DURATION</th>
        								<th>REASON</th>
        								<th>HOD REMARK</th>
        								<th>HR REMARKS</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'LEAVE'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date'].' - '.$record['to_date']; ?></td>
        									<td><?php echo $this->my_library->day_duration($record['from_date'],$record['to_date']);?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example1').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>
      		</div>
      		
      		<!-- 
      		----------  Half day leave request  ----------- 
      		-->
      		<div id="half_day_leave_requests" class="tab-pane fade"><br>
      			
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example2">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'HALF'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example2').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>
      		</div>
      		
      		<!-- 
      		----------  Off Day Duty Request  ----------- 
      		-->
      		<div id="off_day_duty_requests" class="tab-pane fade"><br>
      			
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example3">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>REQUEST SUBMIT DATE</th>
        								<th>LEAVE DATE</th>
        								<th>WEEK OFF DAY</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'OFF_DAY'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo $record['wod']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example3').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>
      		</div>
      		
      		<!-- 
      		----------  NH FH Day Duty Request  ----------- 
      		-->
      		<div id="nh_fh_day_duty_requests" class="tab-pane fade"><br>
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example4">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'NH_FH'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example4').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>
      		</div>
      		
      		<!-- 
      		----------  Tour Request  ----------- 
      		-->
      		<div id="tour_requests" class="tab-pane fade"><br>
      			
      			<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example5">
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
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'TOUR'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['created_at']; ?></td>
        									<td><?php echo $record['from_date'].' - '.$record['to_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
        									<td><?php if((int)$record['pl']){ echo (int)$record['pl']; } else { echo '-'; } ?></td>
        									<td><?php if((int)$record['lop']){ echo (int)$record['lop']; }else { echo '-'; } ?></td>
        									<td>COFF'S:</br><?php echo $record['COFF']; ?></br>NH/FH:<?php echo $record['NHFH']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example5').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>	
      		</div>
      		
      		<!-- 
      		----------  NH FH Avail Request  ----------- 
      		-->
      		<div id="nh_fh_avail_requests" class="tab-pane fade"><br>
    		  	<?php if(count($records)>0){ ?>	
        		  <div class="col-md-12">
        			<div class="card card-info">
        			  <div class="card-body">
        				<div class="table-responsive">
        					<table class="table table-bordered table-striped" id="example6">
        						<thead>	
        							<tr class="bg-dark">
        								<th>S.No.</th>
        								<th>REFERENCE NO.</th>
        								<th>LEAVE DATE</th>
        								<th>REASON</th>
        								<th>HOD STATUS</th>
        								<th>HR STATUS</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php $c=1; foreach($records as $record){
        							    if($record['request_type'] == 'NH_FH_AVAIL'){ ?>
        								<tr>
        									<td><?php echo $c++; ?>.</td>
        									<td><?php echo $this->my_library->remove_hyphen($record['reference_id']); ?></td>
        									<td><?php echo $record['from_date']; ?></td>
        									<td><?php echo strlen($record['requirment']) > 50 ? substr($record['requirment'],0,50)."...<a href='#'>read more</a>" : $record['requirment']; ?></td>
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
        										  }?>"><?php echo $record['hr_status']; ?>
        									</td>
        								</tr>
        							<?php }
        							 continue;
        							} ?>
        						</tbody>
        					</table>
        				</div>
        				<script>$('#example6').DataTable();</script>
        			  </div>
        			</div>
        		  </div>
        		<?php } ?>		
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

	$(document).on('click','#getDetail',function(){
		var department = $('#department').val();
		var employee = $('#employee').val();
		window.location=baseUrl+'es/All-Report/'+ department +'/'+employee;
	});
	
</script>
</body>