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
              					<td>
              						<?php if(isset($user_detail[0]['ecode'])){ echo $user_detail[0]['ecode']; } ?>
              					</td>
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
              				<form name="f1" method="POST" action="<?php echo base_url('es/KRA/').$this->uri->segment(3).'/'.$user_detail[0]['ecode']; ?>">
              				<tr>
              					<td><b>Session</b></td>
              					<td>
              						<select class="form-control" name="session" id="session">
              							<?php foreach($session as $sess){ ?>
              								<option value="<?php echo $sess['s_id']; ?>" <?php if($this->uri->segment('3') == $sess['name']){ echo 'selected'; }?>><?php echo $sess['name']; ?></option>
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
					EMPLOYEE APPRAISAL FORM <b>[ <?php echo $this->uri->segment(3);?> ]</b>
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
              		<!-- form name="f1" method="POST" action="<?php //echo base_url('es/KRA/').$user_detail[0]['ecode']; ?>"-->
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
                  						<textarea rows="" cols="" class="form-control" name="key_result_area1" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_result_area1') != '') { echo set_value('key_result_area1'); } else { if(isset($kra_feeds[0]['key_result_area1'])){ echo $kra_feeds[0]['key_result_area1']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area1'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator1" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_performance_indicator1') != '') { echo set_value('key_performance_indicator1'); } else { if(isset($kra_feeds[0]['key_performance_indicator1'])){ echo $kra_feeds[0]['key_performance_indicator1']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator1'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage1" class="form-control" value="<?php if(set_value('weightage1') != '') { echo set_value('weightage1'); } else { if(isset($kra_feeds[0]['weightage1'])){ echo $kra_feeds[0]['weightage1']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage1'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target1" class="form-control" value="<?php if(set_value('target1') != ''){echo trim(set_value('target1'));} else {if(isset($kra_feeds[0]['target1'])){echo $kra_feeds[0]['target1'];}} ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target1'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived1" class="form-control" value="<?php if(set_value('acheived1') != ''){ echo set_value('acheived1'); } else { if(isset($kra_feeds[0]['acheived1'])){ echo $kra_feeds[0]['acheived1']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived1'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score1" class="form-control" value="<?php if(set_value('weighted_score1') != ''){ echo set_value('weighted_score1'); } else { if(isset($kra_feeds[0]['weighted_score1'])){ echo $kra_feeds[0]['weighted_score1']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score1'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>2.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area2" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_result_area2') != '') { echo set_value('key_result_area2'); } else { if(isset($kra_feeds[0]['key_result_area2'])){ echo $kra_feeds[0]['key_result_area2']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area2'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator2" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_performance_indicator2') != '') { echo set_value('key_performance_indicator2'); } else { if(isset($kra_feeds[0]['key_performance_indicator2'])){ echo $kra_feeds[0]['key_performance_indicator2']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator2'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage2" class="form-control" value="<?php if(set_value('weightage2') != '') { echo set_value('weightage2'); } else { if(isset($kra_feeds[0]['weightage2'])){ echo $kra_feeds[0]['weightage2']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage2'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target2" class="form-control" value="<?php if(set_value('target2') != ''){ echo set_value('target2'); } else { if(isset($kra_feeds[0]['target2'])){ echo $kra_feeds[0]['target2']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target2'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived2" class="form-control" value="<?php if(set_value('acheived2') != ''){ echo set_value('acheived2'); } else { if(isset($kra_feeds[0]['acheived2'])){ echo $kra_feeds[0]['acheived2']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived2'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score2" class="form-control" value="<?php if(set_value('weighted_score2') != ''){ echo set_value('weighted_score2'); } else { if(isset($kra_feeds[0]['weighted_score2'])){ echo $kra_feeds[0]['weighted_score2']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score2'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>3.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area3" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_result_area3') != '') { echo set_value('key_result_area3'); } else { if(isset($kra_feeds[0]['key_result_area3'])){ echo $kra_feeds[0]['key_result_area3']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area3'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator3" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  							<?php if(set_value('key_performance_indicator3') != '') { echo set_value('key_performance_indicator3'); } else { if(isset($kra_feeds[0]['key_performance_indicator3'])){ echo $kra_feeds[0]['key_performance_indicator3']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator3'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage3" class="form-control" value="<?php if(set_value('weightage3') != '') { echo set_value('weightage3'); } else { if(isset($kra_feeds[0]['weightage3'])){ echo $kra_feeds[0]['weightage3']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage3'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target3" class="form-control" value="<?php if(set_value('target3') != ''){ echo set_value('target3'); } else { if(isset($kra_feeds[0]['target3'])){ echo $kra_feeds[0]['target3']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target3'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived3" class="form-control" value="<?php if(set_value('acheived3') != ''){ echo set_value('acheived3'); } else { if(isset($kra_feeds[0]['acheived3'])){ echo $kra_feeds[0]['acheived3']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived3'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score3" class="form-control" value="<?php if(set_value('weighted_score3') != ''){ echo set_value('weighted_score3'); } else { if(isset($kra_feeds[0]['weighted_score3'])){ echo $kra_feeds[0]['weighted_score3']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score3'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>4.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area4" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  							<?php if(set_value('key_result_area4') != '') { echo set_value('key_result_area4'); } else { if(isset($kra_feeds[0]['key_result_area4'])){ echo $kra_feeds[0]['key_result_area4']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area4'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator4" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  							<?php if(set_value('key_performance_indicator4') != '') { echo set_value('key_performance_indicator4'); } else { if(isset($kra_feeds[0]['key_performance_indicator4'])){ echo $kra_feeds[0]['key_performance_indicator4']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator4'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage4" class="form-control" value="<?php if(set_value('weightage4') != '') { echo set_value('weightage4'); } else { if(isset($kra_feeds[0]['weightage4'])){ echo $kra_feeds[0]['weightage4']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage4'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target4" class="form-control" value="<?php if(set_value('target4') != ''){ echo set_value('target4'); } else { if(isset($kra_feeds[0]['target4'])){ echo $kra_feeds[0]['target4']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target4'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived4" class="form-control" value="<?php if(set_value('acheived4') != ''){ echo set_value('acheived4'); } else { if(isset($kra_feeds[0]['acheived4'])){ echo $kra_feeds[0]['acheived4']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived4'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score4" class="form-control" value="<?php if(set_value('weighted_score4') != ''){ echo set_value('weighted_score4'); } else { if(isset($kra_feeds[0]['weighted_score4'])){ echo $kra_feeds[0]['weighted_score4']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score4'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>5.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area5" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  							<?php if(set_value('key_result_area5') != '') { echo set_value('key_result_area5'); } else { if(isset($kra_feeds[0]['key_result_area5'])){ echo $kra_feeds[0]['key_result_area5']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area5'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator5" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  							<?php if(set_value('key_performance_indicator5') != '') { echo set_value('key_performance_indicator5'); } else { if(isset($kra_feeds[0]['key_performance_indicator5'])){ echo $kra_feeds[0]['key_performance_indicator5']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator5'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage5" class="form-control" value="<?php if(set_value('weightage5') != '') { echo set_value('weightage5'); } else { if(isset($kra_feeds[0]['weightage5'])){ echo $kra_feeds[0]['weightage5']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage5'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target5" class="form-control" value="<?php if(set_value('target5') != ''){ echo set_value('target5'); } else { if(isset($kra_feeds[0]['target5'])){ echo $kra_feeds[0]['target5']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target5'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived5" class="form-control" value="<?php if(set_value('acheived5') != ''){ echo set_value('acheived5'); } else { if(isset($kra_feeds[0]['acheived5'])){ echo $kra_feeds[0]['acheived5']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived5'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score5" class="form-control" value="<?php if(set_value('weighted_score5') != ''){ echo set_value('weighted_score5'); } else { if(isset($kra_feeds[0]['weighted_score5'])){ echo $kra_feeds[0]['weighted_score5']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score5'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>6.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area6" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> >
                  							<?php if(set_value('key_result_area6') != '') { echo set_value('key_result_area6'); } else { if(isset($kra_feeds[0]['key_result_area6'])){ echo $kra_feeds[0]['key_result_area6']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_result_area6'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator6" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> >
                  							<?php if(set_value('key_performance_indicator6') != '') { echo set_value('key_performance_indicator6'); } else { if(isset($kra_feeds[0]['key_performance_indicator6'])){ echo $kra_feeds[0]['key_performance_indicator6']; } } ?>
                  						</textarea>
                  						<?php echo form_error('key_performance_indicator6'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="number" name="weightage6" class="form-control" value="<?php if(set_value('weightage6') != '') { echo set_value('weightage6'); } else { if(isset($kra_feeds[0]['weightage6'])){ echo $kra_feeds[0]['weightage6']; } }?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
                                        <?php echo form_error('weightage6'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="target6" class="form-control" value="<?php if(set_value('target6') != ''){ echo set_value('target6'); } else { if(isset($kra_feeds[0]['target6'])){ echo $kra_feeds[0]['target6']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('target6'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="acheived6" class="form-control" value="<?php if(set_value('acheived6') != ''){ echo set_value('acheived6'); } else { if(isset($kra_feeds[0]['acheived6'])){ echo $kra_feeds[0]['acheived6']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived6'); ?>
                  					</td>
                  					<td>
                  						<input type="number" name="weighted_score6" class="form-control" value="<?php if(set_value('weighted_score6') != ''){ echo set_value('weighted_score6'); } else { if(isset($kra_feeds[0]['weighted_score6'])){ echo $kra_feeds[0]['weighted_score6']; } } ?>" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> />
                  						<?php echo form_error('weighted_score6'); ?>
                  					</td>
                  				</tr>
                  			</tbody>
                  		</table>
                  		<hr/>
                  		<div class="col-12">
                  			<label>Appraisee Comments:</label>
                  			<textarea class="form-control" name="appraisel_cmt" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> >
                  				<?php if(set_value('appraisel_cmt') != '') { echo set_value('appraisel_cmt'); } else { if(isset($kra_feeds[0]['appraisee_comments'])){ echo $kra_feeds[0]['appraisee_comments']; } } ?>
                  			</textarea>
                  			<?php echo form_error('appraisel_cmt'); ?>
                  		</div>
                  		<hr/>
                  		<div class="col-12">
                  			<label class="bg-dark col-12"><h4>INDIVIDUAL DEVELOPMENT PLAN</h4></label>
                  			<br/><label>Developmental Needs</label><br/>
                  				<textarea class="form-control mb-2" name="develop_need1" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?> >
                  					<?php if(set_value('develop_need1') != '') { echo set_value('develop_need1'); } else { if(isset($kra_feeds[0]['develop_need1'])){ echo $kra_feeds[0]['develop_need1']; } } ?>
                  				</textarea>
                  				<?php echo form_error('develop_need1'); ?>
                  				
                  				<textarea class="form-control mb-3" name="develop_need2" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  					<?php if(set_value('develop_need2') != '') { echo set_value('develop_need2'); } else { if(isset($kra_feeds[0]['develop_need2'])){ echo $kra_feeds[0]['develop_need2']; } } ?>
                  				</textarea>
                  				<?php echo form_error('develop_need2'); ?>
                  			
                  			<label>DEVELOPMENT PLAN</label>
                  				<textarea class="form-control" name="develop_plan" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  					<?php if(set_value('develop_plan') != '') { echo set_value('develop_plan'); } else { if(isset($kra_feeds[0]['develop_plan'])){ echo $kra_feeds[0]['develop_plan']; } } ?>
                  				</textarea>
                  				<?php echo form_error('develop_plan'); ?>
                  		</div>
                  		<div class="text-center mt-3">
                  			<input type="submit" name="submit" class="btn btn-success" value="Submit" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  			<input type="reset" name="reset" class="btn btn-warning" value="Cancel" <?php if($this->my_library->get_current_session() != $this->uri->segment('3')) { echo 'disabled'; }?>>
                  		</div>
              		</div>
              		</form>
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
        var session = $("#session option:selected" ).text();
        window.location = baseUrl+'es/KRA/'+session+'/'+$('#ecode').val();
//         $.ajax({
//     		type: 'POST',
//     		url: baseUrl+'master/department/delete',
//     		data: { 
//     			'dept_id' : dep_id
//     		},
//     		dataType: 'json',
//     		beforeSend: function() {},
//     		success: function(response){
//     			if(response.status == 200){
//     				location.reload();	
//     			} else {
//     				alert(response.msg);
//     			}
//     		}
//     	});
    });
    </script>
    </body>
</html>