  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">NH/FH DAY DUTY FORM</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
						<li class="breadcrumb-item active">NH/FH day duty form</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
	
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<form name="f1" method="POST" action="<?php echo base_url('es/nh-fh-day-duty-form');?>"> 
		<div class="offset-md-1 col-md-10 mb-3">
		   <?php echo $this->session->flashdata('msg'); ?>
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">NH/FH DAY DUTY FORM</h3>
              </div>
              <div class="card-body">
					<table class="table table-bordered">
						<tr>
							<td><b>I , Mr./ Ms./ Mrs.</b></td>
							<td>
								<span><?php echo ucfirst($this->session->userdata('username')); ?> [ <?php echo $this->session->userdata('ecode'); ?> ]</span>
							</td>
						</tr>
						<tr>
							<td><b>Date</b></td>
							<td>
								<select class="form-control" name="nhfh_date" id="nhfh_date">
									<option value="0">Select NH/FH Date</option>
									<?php if(count($nhfh_days)>0){
										foreach($nhfh_days as $nhfh_day){ ?>
											<option value="<?php echo $nhfh_day['id']; ?>" <?php if(set_value('nhfh_date') == $nhfh_day['id']){ echo "selected"; }?>><?php echo $nhfh_day['nhfh_date']; ?> -> '<?php echo $nhfh_day['remark'];?>'</option>
									<?php }
									}?>
								</select>
								<?php echo form_error('nhfh_date'); ?>
							</td>
						</tr>
						<tr>
							<td><b>Duty Detail</b></td>
							<td>
								<span id="duty_detail"></span>
							</td>
						</tr>
						<tr>
							<td><b>As Per The Requirment of</b></td>
							<td>
								<textarea class="form-control" id="requirment" name="requirment"><?php echo set_value('requirment'); ?></textarea>
								<?php echo form_error('requirment'); ?>
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
		  
		  <?php if(count($nh_fh_requests)>0){ ?>
			  <div class="offset-md-1 col-md-10">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">NH/FH DAY DUTY REQUEST'S LIST</h3>
				  </div>
				  <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="example">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>REFERENCE No.</th>
									<th>REQUEST SUBMIT DATE</th>
									<th>NH/FH DATE</th>
									<th>REASON</th>
									<th>HOD REMARK</th>
									<th>HOD STATUS</th>
									<th>HR REMARKS</th>
									<th>HR STATUS</th>
								</tr>
							</thead>
							<tbody>
								<?php $c=1; foreach($nh_fh_requests as $request){ ?>
									<td><?php echo $c++; ?></td>
									<td><?php echo $request['refrence_id']; ?></td>
									<td><?php echo $request['created_at']; ?></td>
									<td><?php echo $request['date']; ?></td>
									<td><?php echo strlen($request['requirment']) > 50 ? substr($request['requirment'],0,50)."...<a href='#'>read more</a>" : $request['requirment']; ?></td>
									<td><?php echo $request['hod_remark']; ?></td>
									<td class="
											<?php if($request['hod_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hod_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"
										><?php echo $request['hod_status']; ?></td>
									<td><?php echo $request['hr_remark']; ?></td>
									<td class="
											<?php if($request['hr_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hr_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"
										><?php echo $request['hr_status']; ?></td>
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
	
	$(document).on('change','#nhfh_date',function(){
		get_detail();
	});
	
	
	function get_detail(){
		var nhfh_date = $('#nhfh_date').val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'Emp_ctrl/day_attendance/'+ nhfh_date + '/'+ <?php echo "'".$this->session->userdata('ecode')."'"; ?>+'/NH_FH',
			data: { },
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					var x = 'In Time: <b class="text-success">'+response.data[0]['IN1'] +'</b>  '+'Out Time: <b class="text-success">'+response.data[0]['OUT2']+'</b><br>'+'Total Work: <b class="text-success">'+response.data[0]['HOURSWORKED']+'</b>';
					$('#duty_detail').html(x);
					
					$('#submit').prop("disabled", false);
				} else {
					var x = response.msg;
					$('#duty_detail').html('<p class="text-danger"><b>'+ x +'</b></p>');
					$('#submit').prop("disabled", true);
				}
			}
		});
	}
	
});
</script>
</body>