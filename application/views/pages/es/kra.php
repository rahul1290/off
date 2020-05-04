<?php 
$sdate = $user_detail[0]['jdate'];
$edate = date('Y-m-d');

$date_diff = abs(strtotime($edate) - strtotime($sdate));

$years = floor($date_diff / (365*60*60*24));
$months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

//printf("%d years, %d months, %d days", $years, $months, $days); die;
?>
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
				<span style="font-size:3vw;" class="offset-sm-3 text-center text-light">KRA ALLOCATION</span>
				
				<nav class="navbar navbar-expand-lg">
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
						<?php if($this->my_library->reporting_to($user_detail[0]['ecode']) > 0){ ?>		
                          <li class="nav-item float-right" style="background-color: red; border-radius: 11px; display:inline;">
                          	<a class="nav-link text-light" href="<?php echo base_url();?>HOD/<?php echo base64_encode($user_detail[0]['ecode']); ?>/KRA">Superior Rating</a>
                          </li>
						<?php } ?>
						<?php if(in_array($user_detail[0]['ecode'], $this->config->item('hr_list'))){ ?>
                                <li class="nov-item float-right" style="background-color: red; border-radius: 11px; display:inline;">
                                	<a class="nav-link text-light" href="<?php echo base_url();?>HR/KRA/<?php echo base64_encode($user_detail[0]['ecode']); ?>/<?php
                                	if($this->uri->segment('4') == ''){
                                	    echo base64_encode($this->my_library->get_current_session());
                                	}
                                	?>">View Report</a>
                                </li>
                          <?php } ?>                        
						 </ul>
                      </div>
                    </nav>
			</div>
			
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					USER PROFILE
				</span>
				<span class="float-right">
					<a href="https://employee.ibc24.in/Home.aspx" class="btn btn-danger">&nbsp;&nbsp;Back&nbsp;&nbsp;</a>
				</span>
              </div>
              <div class="card-body">
              	<div class="row">
					<div class="col-2">
						<img class="" src="https://employee.ibc24.in/OLAppraisal/EmpImage/<?php if(isset($user_detail[0]['img'])){ echo $user_detail[0]['img']; } ?>" style="width: auto; height:200px; margin: 20px 10px 10px 10px;max-width:158px;" />
					</div>
              		<div class="col-md-10 col-xs-12">
              			<table class="table table-bordered table-striped">
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
              					<td><?php if(isset($user_detail[0]['jdate1'])){ echo $user_detail[0]['jdate1']; } ?></td>
              				</tr>
              				<tr>
              					<td><b>Total Experience</b></td>
              					<td><b><?php if(isset($user_detail[0]['jdate'])){ printf("%d years %d months %d days", $years, $months, $days); } ?></b></td>
              				</tr>
              				<form id="f1" method="POST" action="<?php echo base_url('es/KRA/').$this->uri->segment(3).'/'.base64_encode($user_detail[0]['ecode']); ?>" onsubmit="return form_submit()">
              			</table>
              		</div>
              		<!--div class="col-sm-2" style="background-image: url('https://employee.ibc24.in/2019OLAppraisal/EmpImage/<?php //if(isset($user_detail[0]['img'])){ echo $user_detail[0]['img']; } ?>');background-size: contain;background-repeat: no-repeat;"></div-->
              	</div>
				
				<table class="table" style="background-color: blanchedalmond;">
							<tr>
              					<td><b>Session</b></td>
              					<td>
              						<select class="form-control" name="session" id="session" >
										<?php if($this->uri->segment(4) == '') { ?>
											<option value="0">Select Session</option>
											<?php foreach($session as $sess){  
												if($sess['enable'] == 'NO'){
													$x = 'disabled';
												} else {
													$x = '';
												}
											?>
												<option <?php echo $x; ?> value="<?php echo $sess['s_id']; ?>"><?php echo $sess['name']; ?></option>
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
              								<option <?php echo $x; ?> value="<?php echo $sess['s_id']; ?>" <?php if(base64_decode($this->uri->segment('3')) == $sess['name']){ echo 'selected'; }?>><?php echo $sess['name']; ?></option>
              							<?php } ?>
										<?php } ?>
              						</select>
								</td>
              				</tr>
						</table>
				
              </div>
			</div>
          </div><!-- /.container-fluid -->
        </div><!-- /.content -->
        
        
        <div class="content" style="display:<?php if($this->uri->segment(4) == '') { echo 'none';} else { echo 'block'; } ?>">
          <div class="container-fluid col-10">	
		  <?php echo $this->session->flashdata('msg'); ?>
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="text-center">
					EMPLOYEE APPRAISAL FORM <b>[ <?php echo base64_decode($this->uri->segment(3));?> ]</b>
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
                  					<th>Target </br><small>(In Nos.)</small></th>
                  					<th>Achieved </br><small>(In Nos.)</small></th>
                  					<th>Weighted Score (Out of 100)
									</br><small>(acheived/target) * weightage</small>
									</th>
                  				</tr>
                  			</thead>
                  			<tbody>
                  				<tr>
                  					<td>1.</td>
                  					<td>
                  						<textarea style="width:230px;" rows="" cols="" class="form-control" name="key_result_area1" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_result_area1') != '') { echo set_value('key_result_area1'); } else { if(isset($kra_feeds[0]['key_result_area1'])){ echo $kra_feeds[0]['key_result_area1']; } } ?></textarea>
                  						<?php echo form_error('key_result_area1'); ?>
                  					</td>
                  					<td>
                  						<textarea style="width:230px;" rows="" cols="" class="form-control" name="key_performance_indicator1" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_performance_indicator1') != '') { echo set_value('key_performance_indicator1'); } else { if(isset($kra_feeds[0]['key_performance_indicator1'])){ echo $kra_feeds[0]['key_performance_indicator1']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator1'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage1" id="weightage1" data-id="1" class="form-control weightage visible" value="<?php if(set_value('weightage1') != '') { echo set_value('weightage1'); } else { if(isset($kra_feeds[0]['weightage1'])){ echo $kra_feeds[0]['weightage1']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>>
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage1'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target1" id="target1" data-id="1" class="form-control target visible" value="<?php if(set_value('target1') != ''){echo trim(set_value('target1'));} else {if(isset($kra_feeds[0]['target1'])){echo $kra_feeds[0]['target1'];}} ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target1'); ?>
										<span class="text-danger" style="display:none;" id="target1_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived1" id="acheived1" data-id="1" class="form-control acheived visible" value="<?php if(set_value('acheived1') != ''){ echo set_value('acheived1'); } else { if(isset($kra_feeds[0]['acheived1'])){ echo $kra_feeds[0]['acheived1']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived1'); ?>
										<span class="text-danger" style="display:none;" id="acheived1_errors"></span>
                  					</td>
                  					<td>
										<?php //echo $kra_feeds[0]['weighted_score1']; ?>
                  						<input type="text" name="weighted_score1" id="score1" class="form-control score visible" value="<?php if(set_value('weighted_score1') != ''){ echo set_value('weighted_score1'); } else { if(isset($kra_feeds[0]['weighted_score1'])){ echo $kra_feeds[0]['weighted_score1']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score1'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>2.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area2" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_result_area2') != '') { echo set_value('key_result_area2'); } else { if(isset($kra_feeds[0]['key_result_area2'])){ echo $kra_feeds[0]['key_result_area2']; } } ?></textarea>
                  						<?php echo form_error('key_result_area2'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator2" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_performance_indicator2') != '') { echo set_value('key_performance_indicator2'); } else { if(isset($kra_feeds[0]['key_performance_indicator2'])){ echo $kra_feeds[0]['key_performance_indicator2']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator2'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage2" id="weightage2" data-id="2" class="form-control weightage visible" value="<?php if(set_value('weightage2') != '') { echo set_value('weightage2'); } else { if(isset($kra_feeds[0]['weightage2'])){ echo $kra_feeds[0]['weightage2']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage2'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target2" id="target2" data-id="2" class="form-control target visible" value="<?php if(set_value('target2') != ''){ echo set_value('target2'); } else { if(isset($kra_feeds[0]['target2'])){ echo $kra_feeds[0]['target2']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target2'); ?>
										<span class="text-danger" style="display:none;" id="target2_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived2" id="acheived2" data-id="2" class="form-control acheived visible" value="<?php if(set_value('acheived2') != ''){ echo set_value('acheived2'); } else { if(isset($kra_feeds[0]['acheived2'])){ echo $kra_feeds[0]['acheived2']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived2'); ?>
										<span class="text-danger" style="display:none;" id="acheived2_errors"></span>
                  					</td>
                  					<td>
                  						<input type="text" name="weighted_score2" id="score2" class="form-control score visible" value="<?php if(set_value('weighted_score2') != ''){ echo set_value('weighted_score2'); } else { if(isset($kra_feeds[0]['weighted_score2'])){ echo $kra_feeds[0]['weighted_score2']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score2'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>3.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area3" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_result_area3') != '') { echo set_value('key_result_area3'); } else { if(isset($kra_feeds[0]['key_result_area3'])){ echo $kra_feeds[0]['key_result_area3']; } } ?></textarea>
                  						<?php echo form_error('key_result_area3'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator3" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('key_performance_indicator3') != '') { echo set_value('key_performance_indicator3'); } else { if(isset($kra_feeds[0]['key_performance_indicator3'])){ echo $kra_feeds[0]['key_performance_indicator3']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator3'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage3" id="weightage3" data-id="3" class="form-control weightage visible" value="<?php if(set_value('weightage3') != '') { echo set_value('weightage3'); } else { if(isset($kra_feeds[0]['weightage3'])){ echo $kra_feeds[0]['weightage3']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage3'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target3" id="target3" data-id="3" class="form-control target visible" value="<?php if(set_value('target3') != ''){ echo set_value('target3'); } else { if(isset($kra_feeds[0]['target3'])){ echo $kra_feeds[0]['target3']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target3'); ?>
										<span class="text-danger" style="display:none;" id="target3_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived3" id="acheived3" data-id="3" class="form-control acheived visible" value="<?php if(set_value('acheived3') != ''){ echo set_value('acheived3'); } else { if(isset($kra_feeds[0]['acheived3'])){ echo $kra_feeds[0]['acheived3']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived3'); ?>
										<span class="text-danger" style="display:none;" id="acheived3_errors"></span>
                  					</td>
                  					<td>
                  						<input type="text" name="weighted_score3" id="score3" class="form-control score visible" value="<?php if(set_value('weighted_score3') != ''){ echo set_value('weighted_score3'); } else { if(isset($kra_feeds[0]['weighted_score3'])){ echo $kra_feeds[0]['weighted_score3']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score3'); ?>
                  					</td>
                  				</tr>
                  				
                  				<tr>
                  					<td>4.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area4" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> /><?php if(set_value('key_result_area4') != '') { echo set_value('key_result_area4'); } else { if(isset($kra_feeds[0]['key_result_area4'])){ echo $kra_feeds[0]['key_result_area4']; } } ?></textarea>
                  						<?php echo form_error('key_result_area4'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator4" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> /><?php if(set_value('key_performance_indicator4') != '') { echo set_value('key_performance_indicator4'); } else { if(isset($kra_feeds[0]['key_performance_indicator4'])){ echo $kra_feeds[0]['key_performance_indicator4']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator4'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage4" id="weightage4" data-id="4" class="form-control weightage visible" value="<?php if(set_value('weightage4') != '') { echo set_value('weightage4'); } else { if(isset($kra_feeds[0]['weightage4'])){ echo $kra_feeds[0]['weightage4']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage4'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target4" id="target4" data-id="4" class="form-control target visible" value="<?php if(set_value('target4') != ''){ echo set_value('target4'); } else { if(isset($kra_feeds[0]['target4'])){ echo $kra_feeds[0]['target4']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target4'); ?>
										<span class="text-danger" style="display:none;" id="target4_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived4" id="acheived4" data-id="4" class="form-control acheived visible" value="<?php if(set_value('acheived4') != ''){ echo set_value('acheived4'); } else { if(isset($kra_feeds[0]['acheived4'])){ echo $kra_feeds[0]['acheived4']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived4'); ?>
										<span class="text-danger" style="display:none;" id="acheived4_errors"></span>
                  					</td>
                  					<td>
                  						<input type="text" name="weighted_score4" id="score4" class="form-control score visible" value="<?php if(set_value('weighted_score4') != ''){ echo set_value('weighted_score4'); } else { if(isset($kra_feeds[0]['weighted_score4'])){ echo $kra_feeds[0]['weighted_score4']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score4'); ?>
                  					</td>
                  				</tr>
                  				<tr class="text-center"><td colspan="7"><input id="section5_toggle" data-id="section5" type="button" value="Add More" class="btn btn-default" style="display:none;"/></td></tr>
								
                  				<tr id="section5" style="display:<?php if(set_value('weightage5')!= '' || isset($kra_feeds[0]['weightage5'])){ echo ""; } else { echo "none"; }?>;">
                  					<td>5.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area5" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> /><?php if(set_value('key_result_area5') != '') { echo set_value('key_result_area5'); } else { if(isset($kra_feeds[0]['key_result_area5'])){ echo $kra_feeds[0]['key_result_area5']; } } ?></textarea>
                  						<?php echo form_error('key_result_area5'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator5" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> /><?php if(set_value('key_performance_indicator5') != '') { echo set_value('key_performance_indicator5'); } else { if(isset($kra_feeds[0]['key_performance_indicator5'])){ echo $kra_feeds[0]['key_performance_indicator5']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator5'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage5" id="weightage5" data-id="5" class="form-control weightage <?php if(set_value('weightage5')!= '' || isset($kra_feeds[0]['weightage5'])){ echo "visible"; }?>" value="<?php if(set_value('weightage5') != '') { echo set_value('weightage5'); } else { if(isset($kra_feeds[0]['weightage5'])){ echo $kra_feeds[0]['weightage5']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage5'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target5" id="target5" data-id="5" class="form-control target <?php if(set_value('weightage5')!= '' || isset($kra_feeds[0]['weightage5'])){ echo "visible"; }?>" value="<?php if(set_value('target5') != ''){ echo set_value('target5'); } else { if(isset($kra_feeds[0]['target5'])){ echo $kra_feeds[0]['target5']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target5'); ?>
										<span class="text-danger" style="display:none;" id="target5_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived5" id="acheived5" data-id="5" class="form-control acheived <?php if(set_value('weightage5')!= '' || isset($kra_feeds[0]['weightage5'])){ echo "visible"; }?>" value="<?php if(set_value('acheived5') != ''){ echo set_value('acheived5'); } else { if(isset($kra_feeds[0]['acheived5'])){ echo $kra_feeds[0]['acheived5']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived5'); ?>
										<span class="text-danger" style="display:none;" id="acheived5_errors"></span>
                  					</td>
                  					<td>
                  						<input type="text" name="weighted_score5" id="score5" class="form-control score <?php if(set_value('weightage5')!= '' || isset($kra_feeds[0]['weightage5'])){ echo "visible"; }?>" value="<?php if(set_value('weighted_score5') != ''){ echo set_value('weighted_score5'); } else { if(isset($kra_feeds[0]['weighted_score5'])){ echo $kra_feeds[0]['weighted_score5']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score5'); ?>
                  					</td>
                  				</tr>
                  				<?php if(base64_decode($this->uri->segment('3')) != '2018-19') { ?>
								<tr class="text-center">
									<td colspan="7">
										<input id="section5_cancel" data-id="section6" type="button" value="Cancel" class="btn btn-danger" style="display:
										<?php if(isset($kra_feeds[0]['weightage6'])){ 
												if($kra_feeds[0]['weightage6'] == ''){ 
													if(set_value('weightage6') != '' || isset($kra_feeds[0]['weightage6'])){
														echo ""; 
													} else { 
														echo "none"; 
													}
												} else { 
													echo "none"; 
												}
											} else { echo "none"; }?>" />
										<input id="section6_toggle" data-id="section6" type="button" value="Add More" class="btn btn-default" style="display:<?php if(set_value('weightage6')!= '' || !isset($kra_feeds[0]['weightage6'])){ echo "none"; } else { echo  ""; }?>;" />
									</td>
								</tr>
                  				<tr id="section6" style="display:<?php if(set_value('weightage6')!= '' || isset($kra_feeds[0]['weightage6'])){ echo ""; } else { echo "none"; }?>;">
                  					<td>6.</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_result_area6" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> ><?php if(set_value('key_result_area6') != '') { echo set_value('key_result_area6'); } else { if(isset($kra_feeds[0]['key_result_area6'])){ echo $kra_feeds[0]['key_result_area6']; } } ?></textarea>
                  						<?php echo form_error('key_result_area6'); ?>
                  					</td>
                  					<td>
                  						<textarea rows="" cols="" class="form-control" name="key_performance_indicator6" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> ><?php if(set_value('key_performance_indicator6') != '') { echo set_value('key_performance_indicator6'); } else { if(isset($kra_feeds[0]['key_performance_indicator6'])){ echo $kra_feeds[0]['key_performance_indicator6']; } } ?></textarea>
                  						<?php echo form_error('key_performance_indicator6'); ?>
                  					</td>
                  					<td>
                  						<div class="input-group">
                                          <input type="text" name="weightage6" id="weightage6" data-id="6" class="form-control weightage <?php if(set_value('weightage6')!= '' || isset($kra_feeds[0]['weightage6'])){ echo "visible"; }?>" value="<?php if(set_value('weightage6') != '') { echo set_value('weightage6'); } else { if(isset($kra_feeds[0]['weightage6'])){ echo $kra_feeds[0]['weightage6']; } }?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                                          <div class="input-group-append"><span class="input-group-text">%</span></div>
                                        </div>
										<span class="text-danger" style="display:none;" id="weightage1_errors"></span>
                                        <?php echo form_error('weightage6'); ?>
                  					</td>
                  					<td>
                  						<input type="text" name="target6" id="target6" data-id="6" class="form-control target <?php if(set_value('weightage6')!= '' || isset($kra_feeds[0]['weightage6'])){ echo "visible"; }?>" value="<?php if(set_value('target6') != ''){ echo set_value('target6'); } else { if(isset($kra_feeds[0]['target6'])){ echo $kra_feeds[0]['target6']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('target6'); ?>
										<span class="text-danger" style="display:none;" id="target6_errors"></span>
                  					</td>
                  					<td>
                  						<input readonly type="text" name="acheived6" id="acheived6" data-id="6" class="form-control acheived <?php if(set_value('weightage6')!= '' || isset($kra_feeds[0]['weightage6'])){ echo "visible"; }?>" value="<?php if(set_value('acheived6') != ''){ echo set_value('acheived6'); } else { if(isset($kra_feeds[0]['acheived6'])){ echo $kra_feeds[0]['acheived6']; } } ?>" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> />
                  						<?php echo form_error('acheived6'); ?>
									<span class="text-danger" style="display:none;" id="acheived6_errors"></span>
                  					</td>
                  					<td>
                  						<input type="text" name="weighted_score6" id="score6" class="form-control score <?php if(set_value('weightage6')!= '' || isset($kra_feeds[0]['weightage6'])){ echo "visible"; }?>" value="<?php if(set_value('weighted_score6') != ''){ echo set_value('weighted_score6'); } else { if(isset($kra_feeds[0]['weighted_score6'])){ echo $kra_feeds[0]['weighted_score6']; } } ?>" readonly />
                  						<?php echo form_error('weighted_score6'); ?>
                  					</td>
                  				</tr>
								<tr class="text-center">
									<td colspan="7">
										<input id="section6_cancel" type="button" value="Cancel" class="btn btn-danger" style="display:
										<?php if(set_value('weightage6') != '' || isset($kra_feeds[0]['weightage6'])){ echo ""; } else { echo "none"; }?>;" />
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="3" class="text-center"><b>Total</b></td>
									<td class="text-center"><b><span id="weightage_total">0</span>%</b></td>
									<td colspan="2"></td>
									<td class="text-center"><b><span id="score_total">0</b></td>
								</tr>
                  			</tbody>
                  		</table>
						</div>
                  		<hr/>
                  		<div class="col-12 mb-2">
                  			<label>APPRAISEE COMMENTS:</label>
                  			<textarea class="form-control" name="appraisel_cmt" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> ><?php if(set_value('appraisel_cmt') != '') { echo set_value('appraisel_cmt'); } else { if(isset($kra_feeds[0]['appraisee_comments'])){ echo $kra_feeds[0]['appraisee_comments']; } } ?></textarea>
                  			<?php echo form_error('appraisel_cmt'); ?>
                  		</div>
                  		<hr/>
                  		<div class="col-12">
                  			<label class="bg-dark col-12"><h4>INDIVIDUAL DEVELOPMENT PLAN</h4></label>
                  			<br/><label>DEVELOPMENTAL NEEDS</label><br/>
                  				<textarea class="form-control mb-2" name="develop_need1" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?> ><?php if(set_value('develop_need1') != '') { echo set_value('develop_need1'); } else { if(isset($kra_feeds[0]['develop_need1'])){ echo $kra_feeds[0]['develop_need1']; } } ?></textarea>
                  				<?php echo form_error('develop_need1'); ?>
                  				
                  				<textarea class="form-control mb-3" name="develop_need2" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('develop_need2') != '') { echo set_value('develop_need2'); } else { if(isset($kra_feeds[0]['develop_need2'])){ echo $kra_feeds[0]['develop_need2']; } } ?></textarea>
                  				<?php echo form_error('develop_need2'); ?>
                  			
                  			<label>DEVELOPMENT PLAN</label>
                  				<textarea class="form-control" name="develop_plan" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>><?php if(set_value('develop_plan') != '') { echo set_value('develop_plan'); } else { if(isset($kra_feeds[0]['develop_plan'])){ echo $kra_feeds[0]['develop_plan']; } } ?></textarea>
                  				<?php echo form_error('develop_plan'); ?>
							<div class="text-center mt-3">
								<input type="submit" name="submit" id="submit" class="btn btn-success" value="UPDATE" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>>
								<?php /* <input type="reset" name="reset" class="btn btn-warning" value="Cancel" <?php if($this->my_library->get_current_session() != base64_decode($this->uri->segment('3'))) { echo 'disabled'; }?>>*/?>
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
	
	function form_submit(){
		var counter = 0;
		$(".acheived").each(function(){
			var id = $(this).data('id');
			if($('#acheived'+id).hasClass('visible')){
				if($('#target'+id).val() < $('#acheived'+id).val()){
					counter = counter + 1;
					console.log('eroor 511');
				}
			}
			
			// if(!parseFloat($('#acheived'+id).val()) > '0'){
				// counter = counter + 1;
				// $('#acheived'+id+'_errors').html('not to be zero').show();
			// } 
		});
		
		$('.target').each(function(){
			var id = $(this).data('id');
			if($('#target'+id).hasClass('visible')){
				if($('#target'+id).val() == ''){
					counter = counter + 1;
					$('#target'+id+'_errors').html('Targer is not empty').show();
					console.log('error 527:'+id);
				} 
				// else if(parseFloat($('#target'+id).val()) > 100){
					// counter = counter + 1;
					// $('#target'+id+'_errors').html('Target not grater then 100').show();
					// console.log('error 531:'+id);
				// }
			}
		});
		
		if(!counter){
			var x = parseFloat($('#weightage1').val())+parseFloat($('#weightage2').val())+parseFloat($('#weightage3').val())+parseFloat($('#weightage4').val());
			if($('#weightage5').hasClass('visible')){
				x = x + parseFloat($('#weightage5').val());
			} 
			if($('#weightage6').hasClass('visible')){
				x = x + parseFloat($('#weightage6').val());
			}
			
			if(x == 100){
				return true;
			} else {
				alert('Something went wrong with weightage.');
				return false;
			}
		} else {
			alert('Something went wrong.');
			return false;
		}
	}

    var baseUrl = $('#base_url').val();
	weightage();
	score();
	
    $(document).on('change','#session',function(){
		var session_value = $(this).val();
		if(session_value != 0){
			console.log('if');
			//return false;
			var session = $("#session option:selected" ).text();
			window.location = baseUrl+'es/KRA/'+btoa(session)+'/'+btoa($('#ecode').val());
		} else {
			console.log('else');
			console.log(baseUrl+'es/KRA/'+$('#ecode').val());
			//return false;
			window.location = baseUrl+'es/KRA/'+btoa($('#ecode').val());
		}
    });
	
	
	$(document).on('blur','.weightage',function(){
		weightage();
		var id = $(this).data('id');
		$('#target'+id).val('0.0');
		$('#acheived'+id).val('0.0');
		calculation(id);
	});
	
	
	$(document).on('keyup','.score',function(){
		score();
	});
	
	
	function weightage(){
		if(typeof $('#weightage1').val() === 'undefined') { var w1 = '0'; } else { if($('#weightage1').val() == ''){ var w1 = '0' } else { var w1 = $('#weightage1').val() } }
		if(typeof $('#weightage2').val() === 'undefined') { var w2 = '0'; } else { if($('#weightage2').val() == ''){ var w2 = '0' } else { var w2 = $('#weightage2').val() } }
		if(typeof $('#weightage3').val() === 'undefined') { var w3 = '0'; } else { if($('#weightage3').val() == ''){ var w3 = '0' } else { var w3 = $('#weightage3').val() } }
		if(typeof $('#weightage4').val() === 'undefined') { var w4 = '0'; } else { if($('#weightage4').val() == ''){ var w4 = '0' } else { var w4 = $('#weightage4').val() } }
		if(typeof $('#weightage5').val() === 'undefined') { var w5 = '0'; } else { if($('#weightage5').val() == ''){ var w5 = '0' } else { var w5 = $('#weightage5').val() } }
		if(typeof $('#weightage6').val() === 'undefined') { var w6 = '0'; } else { if($('#weightage6').val() == ''){ var w6 = '0' } else { var w6 = $('#weightage6').val() } }
		var x = parseFloat(w1)+parseFloat(w2)+parseFloat(w3)+parseFloat(w4);
		if(parseFloat(x) == 100){
			console.log(x+':598');
			console.log('599');
			//section 5 disabled
			$('#weightage5').val('');
			$('#target5').val('');
			//$('#section5_toggle').closest('tr').hide();
			$('#section5_toggle').hide();
			$('#weightage5').val('');
			$('#weightage5,#target5,#acheived5,#score5').removeClass('visible');
			$('#section5,#section5_cancel,#section6_toggle').hide();
			
			//section 6 disabled
			$('#weightage6').val('');
			$('#target6').val('');
			//$('#section6_toggle').closest('tr').hide();
			$('#section6_toggle,#section5_cancel').hide();
			$('#weightage6,#target6,#acheived6,#score6').removeClass('visible');
			$('#section6,#section6_cancel').hide();	
			$('#weightage_total').html(x);		
			
			$('#submit').prop('disabled', false);
			return true;
		} else {		
			if($('#weightage5').hasClass('visible')){
				console.log('603');
				x = x + parseFloat(w5);
				if(parseFloat(x) == 100){
					console.log('606');
					$('#weightage6').val('0');
					$('#target6').val('0');
					//$('#section6_toggle').closest('tr').show();
					$('#section6_toggle,#section5_cancel').show();
					$('#weightage6,#target6,#acheived6,#score6').removeClass('visible');
					$('#section6,#section6_cancel').hide();
				}
			} 
			
			if($('#weightage6').hasClass('visible')){
				x = x + parseFloat(w6);
			}
			
			
			if(parseFloat(x) > 100){ 
				$('#submit').prop('disabled', true);
				$('#section5_toggle').hide();
				$('#section6_toggle').hide();
				return false;
				$('#weightage_total').html('<span class="text-danger">'+x+'</span>');
			} else {
				if(parseFloat(x) == 100){
					$('#submit').prop('disabled', false);
					$('#weightage_total').html(x);
					$('#section5_toggle').hide();
					$('#section6_toggle').hide();
				} else {
					if($('#weightage5').hasClass('visible') && !$('#weightage6').hasClass('visible')){
						$('#section6_toggle').show();
					} else if(!$('#weightage5').hasClass('visible') && !$('#weightage6').hasClass('visible')){
						$('#section5_toggle').show();		
					}
					$('#submit').prop('disabled', true);
					$('#weightage_total').html('<span class="text-success">It should be 100 </span>: '+ x);
				}
				return true;
			}
		}
	}
	
	$(document).on('keyup blur','.acheived',function(event){
		var id = $(this).data('id');

		if($('#target'+id).val() == '') {
			var target = 0; 
			$('#target'+id+'_errors').show().html('Fill target first.');
			$('#target'+id).focus();
			event.preventDefault();
			return false;
		} else {
			var target = $('#target'+id).val();
			$('#target'+id+'_errors').hide().html('');
		}
		
		if($('#acheived'+id).val() == '') {
			var acheived = 0; 
		} else {
			var acheived = $('#acheived'+id).val();
		}
		if( parseFloat(acheived) > parseFloat(target) ){
			$(this).focus();
			$('#submit').prop('disabled', true);
			$('#acheived'+id+'_errors').show().html('Achieved not greater than Target.');
		} else {
			$('#submit').prop('disabled', false);
			$('#acheived'+id+'_errors').hide().html('');
			calculation(id);
		}
	});


	$(document).on('keyup blur','.target',function(event){
		var id = $(this).data('id');
		
		// if($(this).val() > 100){
			// $('#target'+id+'_errors').show().html('Target not grater then 100');
			// $('#target'+id).focus();
		// }

		if($('#weightage'+id).val() == '') {
			var weightage = 0; 
			$('#weightage'+id+'_errors').show().html('Fill weightage first.');
			$('#weightage'+id).focus();
			event.preventDefault();
			return false;
		}
		calculation(id);
	});

	$(document).on('keyup blur','.weightage',function(){
		var id = $(this).data('id');
		if(parseFloat($(this).val()) > 100){
			$('#weightage'+id+'_errors').show().html('Not greater than 100%');
			$(this).focus();
		} else {
			$('#weightage'+id+'_errors').hide().html('');
		}
		if(weightage()){
			if(parseFloat($('#weightage_total').text()) !== '100'){
			}
		} else {
			$('#weightage'+id+'_errors').show().html('Over-all weightage not more then 100%');
			$('#weightage_total').html('<span class="text-danger">Over-all weightage not more then 100</span>');
			$(this).focus();
		}
		calculation(id);
	});
	
	function calculation(id){
		if(isNaN(($('#acheived'+id).val()/$('#target'+id).val()) * $('#weightage'+id).val())) {
			$('#score'+id).val(0);
		} else {
			var x = (($('#acheived'+id).val()/$('#target'+id).val()) * $('#weightage'+id).val()).toFixed(2);
			$('#score'+id).val(x);
		}
		score();
	}
	
	function score(){
		if(typeof $('#score1').val() === 'undefined') { var w1 = '0'; } else { if($('#score1').val() == ''){ var w1 = '0' } else { var w1 = $('#score1').val() } }
		if(typeof $('#score2').val() === 'undefined') { var w2 = '0'; } else { if($('#score2').val() == ''){ var w2 = '0' } else { var w2 = $('#score2').val() } }
		if(typeof $('#score3').val() === 'undefined') { var w3 = '0'; } else { if($('#score3').val() == ''){ var w3 = '0' } else { var w3 = $('#score3').val() } }
		if(typeof $('#score4').val() === 'undefined') { var w4 = '0'; } else { if($('#score4').val() == ''){ var w4 = '0' } else { var w4 = $('#score4').val() } }
		if(typeof $('#score5').val() === 'undefined') { var w5 = '0'; } else { if($('#score5').val() == ''){ var w5 = '0' } else { var w5 = $('#score5').val() } }
		if(typeof $('#score6').val() === 'undefined') { var w6 = '0'; } else { if($('#score6').val() == ''){ var w6 = '0' } else { var w6 = $('#score6').val() } }
		var x = (parseFloat(w1)+parseFloat(w2)+parseFloat(w3)+parseFloat(w4)+parseFloat(w5)+parseFloat(w6)).toFixed(2);
		if(x > 100){ 
			$('#score_total').html('<span class="text-danger">'+x+'</span>');
		} else {
			$('#score_total').html(x);
		}
	}

	

	$(".target,.weightage,.acheived").on("keypress keyup blur",function (event) {
     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
     });
	 
	 ///////////////////////new requirments//////////////////
	 $(document).on('click','#section5_toggle',function(){
		$('#section5,#section5_cancel,#section6_toggle').show();		
		$('#weightage5,#target5,#acheived5,#score5').addClass('visible');
		//$(this).closest('tr').hide();
		$('#section5_toggle').hide();
	 });
	 
	 $(document).on('click','#section5_cancel',function(){		
		$('#weightage5').val('0');
		$('#target5').val('0');
		//$('#section5_toggle').closest('tr').show();
		$('#section5_toggle').show();
		$('#weightage5').val('');
		$('#weightage5,#target5,#acheived5,#score5').removeClass('visible');
		$('#section5,#section5_cancel,#section6_toggle').hide();
		weightage();
	 });
	 
	 $(document).on('click','#section6_toggle',function(){
		$('#section6,#section6_cancel').show();		
		$('#weightage6,#target6,#acheived6,#score6').addClass('visible');
		//$(this).closest('tr').hide();
		$('#section6_toggle,#section5_cancel').hide();
	 });
	 
	 $(document).on('click','#section6_cancel',function(){		
		$('#weightage6').val('0');
		$('#target6').val('0');
		//$('#section6_toggle').closest('tr').show();
		$('#section6_toggle,#section5_cancel').show();
		$('#weightage6,#target6,#acheived6,#score6').removeClass('visible');
		$('#section6,#section6_cancel').hide();
		weightage();
	 });
    </script>
    </body>
</html>
