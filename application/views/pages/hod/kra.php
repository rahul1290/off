<!DOCTYPE html>
<html lang="en">
	<head>
		<?php 
			$headerLinks = isset($head) ? $head : 'Head not included'; 
			print_r($headerLinks);
			
			$footerLinks = isset($footer) ? $footer : 'Footer not included'; 
			print_r($footerLinks);
		?>
		
	</head>
	<input type="hidden" name="base_url" id="baseUrl" value="<?php echo base_url();?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if(isset($open)){ echo 'control-sidebar-slide-open'; }?>">
	<div class="wrapper">
		<!--.navbar -->
		<?php 
			$topNav = isset($top_nav) ? $top_nav : ''; 
			print_r($topNav);
		?>  
	  <!-- /.navbar -->

	  <!-- aside -->
		<?php 
			$aSide = isset($aside) ? $aside : ''; 
			print_r($aSide);
		?>  
	  <!-- /aside -->

	<body class="hold-transition sidebar-mini layout-navbar-fixed">
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>" />
	<input type="hidden" name="ecode" id="ecode" value="<?php echo $user_detail[0]['ecode']; ?>" /> 
<div class="wrapper">
	<!--.navbar -->
	<?php 
		$topNav = isset($top_nav) ? $top_nav : ''; 
		print_r($topNav);
	?>  
  <!-- /.navbar -->

  <!-- aside -->
	<?php 
		$aSide = isset($aside) ? $aside : ''; 
		print_r($aSide);
	?>  
  <!-- /aside -->

  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="margin: 0px;">
        <!-- Content Header (Page header) -->
       
        <!-- /.content-header -->
    
        <!-- Main content -->
        <div class="content">
			
          <div class="container-fluid col-10">	
			<div class="col-12 mb-3" style="background-color: #012f6a; important!">
				<img src="<?php echo base_url();?>assets/dist/img/logo_w.png" style="height:100px;"/>
				<span style="font-size:3vw;" class="offset-sm-3 text-center text-light">ONLINE APPRAISAL</span>
			</div>
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					<input type="hidden" id="hodID" value="<?php echo $this->uri->segment('2'); ?>" />
					Session
					<select name="session" id="session">
						<?php foreach($session as $sess){ ?>
							<option value="<?php echo $sess['s_id']; ?>" <?php if($this->uri->segment('4') == '') { if($sess['name'] == $this->my_library->get_current_session()){ echo 'selected'; }} else { if($sess['name'] == $this->uri->segment('4')){ echo 'selected'; }}?>>
								<?php echo $sess['name']; ?>
							</option>
						<?php } ?>
					</select>
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Employee Name</th>
								<th>Employee Code</th>
								<th>Designation</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php $c=1; foreach($employees as $employee){ ?>
								<tr>
									<td><?php echo $c++; ?>.</td>
									<td><?php echo $employee['uname']; ?></td>
									<td><?php echo $employee['ecode']; ?></td>
									<td><?php echo $employee['post']; ?></td>
									<td>
										<?php if($employee['hod_status'] != null){  ?>
										     <img width="50" src="<?php echo base_url('assets/dist/img/mark.png');?>">
										<?php } ?>
										<a href="<?php echo base_url();?>HOD/<?php echo $this->uri->segment('2'); ?>/KRA/<?php if($this->uri->segment('4') == '') { echo $this->my_library->get_current_session(); } else { echo $this->uri->segment('4'); }?>/<?php echo $employee['ecode']; ?>">view</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
              	</div>
              </div>
			</div>
			
			
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					SELF RATING PENDING FROM EMPLOYEE
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Employee Name</th>
								<th>Employee Code</th>
								<th>Designation</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php $c=1; foreach($pending_employees as $employee){ ?>
								<tr>
									<td><?php echo $c++; ?>.</td>
									<td><?php echo $employee['uname']; ?></td>
									<td><?php echo $employee['ecode']; ?></td>
									<td><?php echo $employee['post']; ?></td>
									<td></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
              	</div>
              </div>
			</div>
			
          </div><!-- /.container-fluid -->
        </div><!-- /.content -->
        
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
    	var baseUrl = $('#base_url').val();

    	$(document).on('change','#session',function(){
        	var hod = $('#hodID').val()
    		var session = $("#session option:selected" ).text();
			window.location = baseUrl+'HOD/'+ hod +'/KRA/'+ session;
       	});
    </script>
    
    </body>
</html>