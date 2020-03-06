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
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <!--h1 class="m-0 text-dark">Starter Page</h1-->
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    
        <!-- Main content -->
        <div class="content">
          <div class="container-fluid col-9">	
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					EMPLOYEE APPRAISAL FORM
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
              		<div class="col-10">
              			<table class="table table-bordered">
              				<tr>
              					<td><b>Employee Code</b></td>
              					<td><?php if(isset($user_detail[0]['ecode'])){ echo $user_detail[0]['ecode']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Name</b></td>
              					<td><?php if(isset($user_detail[0]['uname'])){ echo $user_detail[0]['uname']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Department</b></td>
              					<td><?php if(isset($user_detail[0]['dept'])){ echo $user_detail[0]['dept']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Reporting To</b></td>
              					<td><?php if(isset($user_detail[0]['reporting_name'])){ echo $user_detail[0]['reporting_name']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Date of Joining</b></td>
              					<td><?php if(isset($user_detail[0]['jdate'])){ echo $user_detail[0]['jdate']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Total Experience</b></td>
              					<td><?php if(isset($user_detail[0]['jdate'])){ echo $user_detail[0]['jdate']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Session</b></td>
              					<td>
              						<select class="form-control">
              							<?php foreach($session as $sess){ ?>
              								<option value="<?php echo $sess['s_id']; ?>" <?php if($sess['is_active'] == 'curr'){ echo 'selected'; }?>><?php echo $sess['name']; ?></option>
              							<?php } ?>
              						</select>
								</td>
              				</tr>
              			</table>
              		</div>
              		<div class="col-2 text-right" style="background-image: url('https://employee.ibc24.in/2019OLAppraisal/EmpImage/<?php if(isset($user_detail[0]['img'])){ echo $user_detail[0]['img']; } ?>');background-size: contain;background-repeat: no-repeat;"></div>
              	</div>
              </div>
			</div>
          </div><!-- /.container-fluid -->
        </div><!-- /.content -->
        
        
        <div class="content">
          <div class="container-fluid col-9">	
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					EMPLOYEE APPRAISAL FORM
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
              		<div class="table-responsive">
                  		<table class="table table-bordered">
                  			<thead>
                  				<tr>
                  					<th>S.No.</th>
                  					<th>Key Result Area(s)</th>
                  					<th>Key Performance Indicator(s)</th>
                  					<th>Weightage (%)</th>
                  					<th>Target (In Nos.)</th>
                  					<th>Acheived (In Nos.)</th>
                  					<th>Weighted Score (Out of 100)</th>
                  				</tr>
                  			</thead>
                  			<tbody>
                  				<tr>
                  					<td>1.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area1">
                  							<?php if(isset($kra_feeds[0]['key_result_area1'])){ echo $kra_feeds[0]['key_result_area1']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator1">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator1'])){ echo $kra_feeds[0]['key_performance_indicator1']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage1" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage1'])){ echo $kra_feeds[0]['weightage1']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target1" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target1'])){ echo $kra_feeds[0]['target1']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived1" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived1'])){ echo $kra_feeds[0]['acheived1']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score1" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score1'])){ echo $kra_feeds[0]['weighted_score1']; }?>" />
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>2.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area2">
                  							<?php if(isset($kra_feeds[0]['key_result_area2'])){ echo $kra_feeds[0]['key_result_area2']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator2">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator2'])){ echo $kra_feeds[0]['key_performance_indicator2']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage2" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage2'])){ echo $kra_feeds[0]['weightage2']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target2" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target2'])){ echo $kra_feeds[0]['target2']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived2" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived2'])){ echo $kra_feeds[0]['acheived2']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score2" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score2'])){ echo $kra_feeds[0]['weighted_score2']; }?>" />
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>3.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area3">
                  							<?php if(isset($kra_feeds[0]['key_result_area3'])){ echo $kra_feeds[0]['key_result_area3']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator3">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator3'])){ echo $kra_feeds[0]['key_performance_indicator3']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage3" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage3'])){ echo $kra_feeds[0]['weightage3']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target3" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target3'])){ echo $kra_feeds[0]['target3']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived3" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived3'])){ echo $kra_feeds[0]['acheived3']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score3" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score3'])){ echo $kra_feeds[0]['weighted_score3']; }?>" />
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>4.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area4">
                  							<?php if(isset($kra_feeds[0]['key_result_area4'])){ echo $kra_feeds[0]['key_result_area4']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator4">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator4'])){ echo $kra_feeds[0]['key_performance_indicator4']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage4" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage4'])){ echo $kra_feeds[0]['weightage4']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target4" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target4'])){ echo $kra_feeds[0]['target4']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived4" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived4'])){ echo $kra_feeds[0]['acheived4']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score4" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score4'])){ echo $kra_feeds[0]['weighted_score4']; }?>" />
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>5.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area5">
                  							<?php if(isset($kra_feeds[0]['key_result_area5'])){ echo $kra_feeds[0]['key_result_area5']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator5">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator5'])){ echo $kra_feeds[0]['key_performance_indicator5']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage5" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage5'])){ echo $kra_feeds[0]['weightage5']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target5" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target5'])){ echo $kra_feeds[0]['target5']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived5" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived5'])){ echo $kra_feeds[0]['acheived5']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score5" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score5'])){ echo $kra_feeds[0]['weighted_score5']; }?>" />
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>6.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area6">
                  							<?php if(isset($kra_feeds[0]['key_result_area6'])){ echo $kra_feeds[0]['key_result_area6']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator6">
                  							<?php if(isset($kra_feeds[0]['key_performance_indicator6'])){ echo $kra_feeds[0]['key_performance_indicator6']; }?>
                  						</textarea>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage6" class="form-control" value="<?php if(isset($kra_feeds[0]['weightage6'])){ echo $kra_feeds[0]['weightage6']; }?>">
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                  					</td>
                  					<td>
                  						<input type="number" name=target6" class="form-control" value="
                  							<?php if(isset($kra_feeds[0]['target6'])){ echo $kra_feeds[0]['target6']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=acheived6" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['acheived6'])){ echo $kra_feeds[0]['acheived6']; }?>" />
                  					</td>
                  					<td>
                  						<input type="number" name=weighted_score6" class="form-control" value="
                  						<?php if(isset($kra_feeds[0]['weighted_score6'])){ echo $kra_feeds[0]['weighted_score6']; }?>" />
                  					</td>
                  				</tr>
                  				
                  			</tbody>
                  		</table>
              		</div>
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
    </body>
</html>