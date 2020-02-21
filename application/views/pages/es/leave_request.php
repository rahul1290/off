  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">LEAVE REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
						<li class="breadcrumb-item active">Leave Request</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="offset-md-1 col-md-10">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">LEAVE REQUEST</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>DATE OF APPLICATION</td>
							<td><?php echo date('d/m/Y');?></td>
						</tr>
						<tr>
							<td><b>Leave From</b></td>
							<td>
								<input type="date" name="leave_from" class="form-control"><b>TO</b><input type="date" name="leave_to" class="form-control">
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR LEAVE</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
						<tr>
							<td><b>WEEK OFF DAY</b></td>
							<td>
								<input type="radio" name="wod" class="ml-1">SUN
								<input type="radio" name="wod" class="ml-1">MON
								<input type="radio" name="wod" class="ml-1">TUE	
								<input type="radio" name="wod" class="ml-1">WED
								<input type="radio" name="wod" class="ml-1">THU
								<input type="radio" name="wod" class="ml-1">FRI
								<input type="radio" name="wod" class="ml-1">SAT
							</td>
						</tr>
					</table>
				</div>
				
              </div>
            </div>
          </div>
		  
		  
		  <div class="offset-md-1 col-md-10">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">LEAVE ADJUSTMENT SECTION</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>LOSS OF PAY (LOP)</td>
							<td>
								<input type="radio" name="lop" class="ml-1" value="YES">YES
								<input type="radio" name="lop" class="ml-1" value="NO">NO
								</br><span>No of Days</span> : <input type="text" name="lop_days" placeholder="No of days">
							</td>
						</tr>
						<tr>
							<td><b>WORK ON WEEK OFF / HOLIDAY DATES</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR WORKING ON A HOLIDAY / WEEK OFF</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
					</table>
				</div>
              </div>
            </div>
				<div class="text-center">
					<input type="button" value="Send" class="btn btn-warning">
					<input type="button" value="Cancel" class="btn btn-secondary">
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
	
});
</script>
</body>