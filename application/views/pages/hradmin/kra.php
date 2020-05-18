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
				<span style="font-size:3vw;" class="offset-sm-4 text-center text-light">REPORT</span>
				<nav class="navbar navbar-expand-lg">
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
						<?php if($this->my_library->reporting_to($user_detail[0]['ecode']) > 0){ ?>		
                          <li class="nav-item float-right" style="background-color: red; border-radius: 11px; display:none;">
                          	<a class="nav-link text-light" href="<?php echo base_url();?>HOD/<?php echo base64_encode($user_detail[0]['ecode']); ?>/KRA">Superior Rating</a>
                          </li>
						<?php } ?>
						<?php if(in_array($user_detail[0]['ecode'], $this->config->item('hr_list'))){ ?>
							<?php if(!$this->my_library->reporting_to($user_detail[0]['ecode'])){ ?>
								<li class="nav-item float-right mr-2" style="background-color: red; border-radius: 11px; display:none;">
									<a class="nav-link text-light" href="<?php echo base_url('es/KRA/');?><?php echo $this->uri->segment('3'); ?>">KRA</a>
								</li>
							<?php } ?>
                                <li class="nov-item float-right" style="background-color: red; border-radius: 11px; display:none;">
                                	<a class="nav-link text-light" href="<?php echo base_url();?>HR/KRA/<?php echo base64_encode($user_detail[0]['ecode']); ?>/<?php
                                	if($this->uri->segment('4') == ''){
                                	    echo base64_encode($this->my_library->get_current_session());
                                	} else{
										echo $this->uri->segment('4');
									}
                                	?>">View Report</a>
                                </li>
                          <?php } ?>                        
						 </ul>
                      </div>
                    </nav>
			</div>
			
			
          	<div class="offset-4 col-4 text-center mb-3">
          		<div class="row mb-2">
          			<input type="hidden" name="ecode" id="ecode" value="<?php echo base64_decode($this->uri->segment('3')); ?>" />
          			<label class="col-3">Session</label>
              		<select class="form-control col-9" name="session" id="session" >
						<?php if($this->uri->segment(4) == '') { ?>
							<option value="NULL">Select Session</option>
							<?php foreach($session as $sess){  
								if($sess['enable'] == 'NO'){
									$x = 'disabled';
								} else {
									$x = '';
								}
							?>
								<option <?php echo $x; ?> value="<?php echo $sess['name']; ?>"><?php echo $sess['name']; ?></option>
							<?php } ?>
						<?php } else { ?>
							<option value="0">Select Session</option>
						<?php foreach($session as $sess){ 
							if($sess['enable'] == 'NO'){
								$x = 'disabled';
							} else {
								$x = '';
							}
						?>
							<option <?php echo $x; ?> value="<?php echo $sess['name']; ?>" <?php if(base64_decode($this->uri->segment('4')) == $sess['name']){ echo 'selected'; }?>><?php echo $sess['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
              		
          		</div>
          		<div class="row mb-2">
          			<label class="col-3">Department</label>
              		<select class="form-control col-9" name="department" id="department">
              			<option value="0">ALL</option>
              			<?php foreach($departments as $department){ ?>
              				<option value="<?php echo $department['dept']; ?>" <?php if(base64_decode($this->uri->segment('5')) == $department['dept']){ echo 'selected'; }?>><?php echo $department['dept']; ?></option>
              			<?php } ?>
              		</select>
          		</div>
				
				<div class="row mb-2">
          			<label class="col-3">Filled</label>
              		<select class="form-control col-9" name="filled" id="filled">
              			<option value="0">ALL</option>
						<option value="YES" <?php if(base64_decode($this->uri->segment('6')) == 'YES'){ echo 'selected'; }?>>YES</option>
						<option value="NO" <?php if(base64_decode($this->uri->segment('6')) == 'NO'){ echo 'selected'; }?>>NO</option>
              		</select>
          		</div>
          		
          		<input type="button" class="btn btn-success" id="view" value="View" />
          		<input type="button" class="btn btn-secondary" value="Reset" />
          	</div>
		</div>
			
			
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					EMPLOYEE'S APPRAISALS
				</span>
              </div>
              <div class="card-body">
				<div class="table-responsive">
              	<table class="table table-bordered" id="example">
              		<thead class="bg-dark">
              			<tr>
              				<th>S.No.</th>
              				<th>Employee Name</th>
              				<th>Employee Code</th>
              				<th>Joining Date</th>
              				<th>Designation</th>
              				<th>Reporting To</th>
							<?php if(base64_decode($this->uri->segment('6')) != 'NO'){ ?>
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							
							<th>Key result area</th>
							<th>Key performance indicator</th>
							<th>Weightage</th>
							<th>Target</th>
							<th>Acheived</th>
							<th>Weighted score</th>
							<th>Appraiser score hod</th>
							<?php } ?>
							
              			</tr>
              		</thead>
              		<tbody>
              			<?php $c=1; foreach($kra_feeds as $kra_feed){ ?>
              				<tr>
              					<td><?php echo $c++; ?></td>
              					<td><?php echo $kra_feed['uname']; ?></td>
              					<td><?php echo $kra_feed['ecode']; ?></td>
              					<td><?php echo $this->my_library->sql_datepicker($kra_feed['jdate']); ?></td>
              					<td><?php echo $kra_feed['post']; ?></td>
              					<td><?php echo $kra_feed['reporting_name']; ?></td>
								
								<?php if(base64_decode($this->uri->segment('6')) != 'NO'){ ?>
								
								<td><?php echo $kra_feed['key_result_area1']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator1']; ?></td>
								<td><?php echo $kra_feed['weightage1']; ?></td>
								<td><?php echo $kra_feed['target1']; ?></td>
								<td><?php echo $kra_feed['acheived1']; ?></td>
								<td><?php echo $kra_feed['weighted_score1']; ?></td>
								<td><?php echo $kra_feed['appraiser_score1_hod']; ?></td>
								
								<td><?php echo $kra_feed['key_result_area2']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator2']; ?></td>
								<td><?php echo $kra_feed['weightage2']; ?></td>
								<td><?php echo $kra_feed['target2']; ?></td>
								<td><?php echo $kra_feed['acheived2']; ?></td>
								<td><?php echo $kra_feed['weighted_score2']; ?></td>
								<td><?php echo $kra_feed['appraiser_score2_hod']; ?></td>
								
								<td><?php echo $kra_feed['key_result_area3']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator3']; ?></td>
								<td><?php echo $kra_feed['weightage3']; ?></td>
								<td><?php echo $kra_feed['target3']; ?></td>
								<td><?php echo $kra_feed['acheived3']; ?></td>
								<td><?php echo $kra_feed['weighted_score3']; ?></td>
								<td><?php echo $kra_feed['appraiser_score3_hod']; ?></td>
								
								<td><?php echo $kra_feed['key_result_area4']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator4']; ?></td>
								<td><?php echo $kra_feed['weightage4']; ?></td>
								<td><?php echo $kra_feed['target4']; ?></td>
								<td><?php echo $kra_feed['acheived4']; ?></td>
								<td><?php echo $kra_feed['weighted_score4']; ?></td>
								<td><?php echo $kra_feed['appraiser_score4_hod']; ?></td>
								
								<td><?php echo $kra_feed['key_result_area5']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator5']; ?></td>
								<td><?php echo $kra_feed['weightage5']; ?></td>
								<td><?php echo $kra_feed['target5']; ?></td>
								<td><?php echo $kra_feed['acheived5']; ?></td>
								<td><?php echo $kra_feed['weighted_score5']; ?></td>
								<td><?php echo $kra_feed['appraiser_score5_hod']; ?></td>
								
								<td><?php echo $kra_feed['key_result_area6']; ?></td>
								<td><?php echo $kra_feed['key_performance_indicator6']; ?></td>
								<td><?php echo $kra_feed['weightage6']; ?></td>
								<td><?php echo $kra_feed['target6']; ?></td>
								<td><?php echo $kra_feed['acheived6']; ?></td>
								<td><?php echo $kra_feed['weighted_score6']; ?></td>
								<td><?php echo $kra_feed['appraiser_score6_hod']; ?></td>
								
								<?php } ?>
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
    
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script>
    	var baseUrl = $('#base_url').val();
    	$('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
    	
//     	$(document).on('change','#session',function(){
//         	var hod = $('#hodID').val()
//     		var session = $("#session option:selected" ).text();
// 			window.location = baseUrl+'HOD/'+ hod +'/KRA/'+ session;
//        	});

       	$(document).on('click','#view',function(){
           	window.location = baseUrl+'HR/KRA/'+btoa($('#ecode').val())+'/'+btoa($('#session').val())+'/'+btoa($('#department').val())+'/'+btoa($('#filled').val());
        });
    </script>
    
    </body>
</html>