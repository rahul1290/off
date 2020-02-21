  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">TOUR REQUEST FORM</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
						<li class="breadcrumb-item active">Tour Request form</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="offset-md-1 col-md-10 mb-3">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">TOUR REQUEST FORM</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
					<tr>
						<td><b>Request No</b></td>
						<td><?php echo date('d/m/Y');?></td>
					</tr>
					<tr>
						<td><b>I , Mr./ Ms./ Mrs.</b></td>
						<td>
							<span><?php echo ucfirst($this->session->userdata('username')); ?> [ <?php echo $this->session->userdata('ecode'); ?> ]</span>
						</td>
					</tr>
					<tr>
						<td><b>Date</b></td>
						<td>
							<select class="form-control" name="nhfh_date">
								<option value="0">Select NH/FH Date</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><b>Duty Detail</b></td>
						<td>
						</td>
					</tr>
					<tr>
						<td><b>As Per The Requirment of</b></td>
						<td>
							<textarea class="form-control"></textarea>
						</td>
					</tr>
				</table>
				
              </div>
            </div>
				<div class="text-center">
					<input type="button" value="Send" class="btn btn-warning">
					<input type="button" value="Cancel" class="btn btn-secondary">
				</div>
          </div>
		  <hr/>
		  
		  <div class="offset-md-1 col-md-10">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">PREVIOUS TOUR REQUEST STATUS</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>	
							<tr class="bg-dark">
								<th>REQUEST ID</th>
								<th>REQUEST DATE</th>
								<th>LEAVE TAKEN DATE</th>
								<th>REASON</th>
								<th>HOD APPROVAL STATUS</th>
								<th>HR Adjust(D-Done P-Pending)</th>
								<th>HR REMARKS</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>REQUEST ID</td>
								<td>REQUEST DATE</td>
								<td>LEAVE TAKEN DATE</td>
								<td>REASON</td>
								<td>HOD APPROVAL STATUS</td>
								<td>HR Adjust(D-Done P-Pending)</td>
								<td>HR REMARKS</td>
							</tr>
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
	
});
</script>
</body>