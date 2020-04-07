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
				<span style="font-size:3vw;" class="offset-sm-3 text-center text-light">SUPERIOR RATING</span>
				<nav class="navbar navbar-expand-lg">
				  <div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
					<?php if($this->my_library->reporting_to(base64_decode($this->uri->segment('2'))) > 0){ ?>		
					  <li class="nav-item float-right mr-2" style="background-color: red; border-radius: 11px;">
						<a class="nav-link text-light" href="<?php echo base_url('es/KRA/');?><?php echo $this->uri->segment('2'); ?>">KRA</a>
					  </li>
					  <li class="nav-item float-right" style="background-color: red; border-radius: 11px;">
						<a class="nav-link text-light" href="<?php echo base_url();?>HOD/<?php echo $this->uri->segment('2'); ?>/KRA">Superior Rating</a>
					  </li>
					<?php } ?>
					<?php if(in_array($user_detail[0]['ecode'], $this->config->item('hr_list'))){ ?>
							<li class="nov-item float-right" style="background-color: red; border-radius: 11px;">
								<a class="nav-link text-light" href="<?php echo base_url();?>HR/KRA/<?php echo base64_encode($user_detail[0]['ecode']); ?>/<?php
								if($this->uri->segment('4') == ''){
									echo base64_encode($this->my_library->get_current_session());
								}
								?>">HR</a>
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
              </div>
              <div class="card-body">
              	<div class="row">
					<div class="col-2">
						<img class="" src="https://employee.ibc24.in/2019OLAppraisal/EmpImage/<?php if(isset($user_detail[0]['img'])){ echo $user_detail[0]['img']; } ?>" style="width: auto; height:200px; margin: 20px 10px 10px 10px;" />
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
              				<tr>
              					<td><b>Session</b></td>
              					<td><?php echo $this->uri->segment(4); ?></td>
              				</tr>
              			</table>
              		</div>
              	</div>
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
					EMPLOYEE APPRAISAL FORM <b>[ <?php echo $this->uri->segment(3);?> ]</b>
				</span>
              </div>
              <form id="f1" method="POST" action="<?php echo base_url('HOD/score/').$this->uri->segment(2).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5); ?>" onsubmit="return form_submit()">
              <div class="card-body">
              	<div class="row">
              		<div class="table-responsive">
                  		<table class="table table-bordered text-center">
                  			<thead>
                  				<tr>
                  					<th>S.No.</th>
                  					<th>Key Result Area(s)</th>
                  					<th>Key Performance Indicator(s)</th>
                  					<th>Weightage (%)</th>
                  					<th>Target (In Nos.)</th>
                  					<th>Acheived (In Nos.)</th>
                  					<th>Weighted Score (Out of 100)</th>
                  					<th>Appraiser Score</th>
                  				</tr>
                  			</thead>
                  			<tbody>
                  				<tr>
                  					<td>1.</td>
                  					<td><?php echo $kra_feeds[0]['key_result_area1']; ?></td>
                  					<td><?php echo $kra_feeds[0]['key_performance_indicator1']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weightage1']; ?> %</td>
                  					<td><?php echo $kra_feeds[0]['target1']; ?></td>
                  					<td><?php echo $kra_feeds[0]['acheived1']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weighted_score1']; ?></td>
                  					<td>
                  						<input type="text" name="appraiser_score1" id="appraiser_score1" data-id="1" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score1_hod']; ?>">
                  						<div id="appraiser_score1_error" class="text-danger" style="display: none;"></div>
                  					</td>
                  				</tr>
                  				<tr>
                  					<td>2.</td>
                  					<td><?php echo $kra_feeds[0]['key_result_area2']; ?></td>
                  					<td><?php echo $kra_feeds[0]['key_performance_indicator2']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weightage2']; ?> %</td>
                  					<td><?php echo $kra_feeds[0]['target2']; ?></td>
                  					<td><?php echo $kra_feeds[0]['acheived2']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weighted_score2']; ?></td>
                  					<td>
                  						<input type="text" name="appraiser_score2" id="appraiser_score2" data-id="2" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score2_hod']; ?>">
                  						<div id="appraiser_score2_error" class="text-danger" style="display: none;"></div>
                  					</td>
                  					
                  				</tr>
                  				<tr>
                  					<td>3.</td>
                  					<td><?php echo $kra_feeds[0]['key_result_area3']; ?></td>
                  					<td><?php echo $kra_feeds[0]['key_performance_indicator3']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weightage3']; ?> %</td>
                  					<td><?php echo $kra_feeds[0]['target3']; ?></td>
                  					<td><?php echo $kra_feeds[0]['acheived3']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weighted_score3']; ?></td>
                  					<td>
                  						<input type="text" name="appraiser_score3" id="appraiser_score3" data-id="3" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score3_hod']; ?>">
                  						<div id="appraiser_score3_error" class="text-danger" style="display: none;"></div>
                  					</td>
                  				</tr>
                  				<tr>
                  					<td>4.</td>
                  					<td><?php echo $kra_feeds[0]['key_result_area4']; ?></td>
                  					<td><?php echo $kra_feeds[0]['key_performance_indicator4']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weightage4']; ?> %</td>
                  					<td><?php echo $kra_feeds[0]['target4']; ?></td>
                  					<td><?php echo $kra_feeds[0]['acheived4']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weighted_score4']; ?></td>
                  					<td>
                  						<input type="text" name="appraiser_score4" id="appraiser_score4" data-id="4" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score4_hod']; ?>">
                  						<div id="appraiser_score4_error" class="text-danger" style="display: none;"></div>
                  					</td>
                  				</tr>
                  				<tr>
                  					<td>5.</td>
                  					<td><?php echo $kra_feeds[0]['key_result_area5']; ?></td>
                  					<td><?php echo $kra_feeds[0]['key_performance_indicator5']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weightage5']; ?> %</td>
                  					<td><?php echo $kra_feeds[0]['target5']; ?></td>
                  					<td><?php echo $kra_feeds[0]['acheived5']; ?></td>
                  					<td><?php echo $kra_feeds[0]['weighted_score5']; ?></td>
                  					<td>
                  						<input type="text" name="appraiser_score5" id="appraiser_score5" data-id="5" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score5_hod']; ?>">
                  						<div id="appraiser_score5_error" class="text-danger" style="display: none;"></div>
                  					</td>
                  				</tr>
                  				<?php if($this->uri->segment('4') != '2018-19') { ?>
                      				<tr>
                      					<td>6.</td>
                      					<td><?php echo $kra_feeds[0]['key_result_area6']; ?></td>
                      					<td><?php echo $kra_feeds[0]['key_performance_indicator6']; ?></td>
                      					<td><?php echo $kra_feeds[0]['weightage6']; ?> %</td>
                      					<td><?php echo $kra_feeds[0]['target6']; ?></td>
                      					<td><?php echo $kra_feeds[0]['acheived6']; ?></td>
                      					<td><?php echo $kra_feeds[0]['weighted_score6']; ?></td>
                      					<td>
                      						<input type="text" name="appraiser_score6" id="appraiser_score6" data-id="6" class="form-control appraiser_score" value="<?php echo $kra_feeds[0]['appraiser_score6_hod']; ?>">
                      						<div id="appraiser_score6_error" class="text-danger" style="display: none;"></div>
                      					</td>
                      				</tr>
								<?php } ?>
								<tr>
									<td colspan="3" class="text-center"><b>Total</b></td>
									<td class=""><b><span>
										<?php
										  if($this->uri->segment('4') != '2018-19'){
										      echo $kra_feeds[0]['weightage1'] + $kra_feeds[0]['weightage2'] + $kra_feeds[0]['weightage3'] + $kra_feeds[0]['weightage4'] + $kra_feeds[0]['weightage5'] + $kra_feeds[0]['weightage6'];
										  } else {
										      echo $kra_feeds[0]['weightage1'] + $kra_feeds[0]['weightage2'] + $kra_feeds[0]['weightage3'] + $kra_feeds[0]['weightage4'] + $kra_feeds[0]['weightage5'];
										  } ?>
									</span>%</b></td>
									<td colspan="2"></td>
									<td class=""><b><span>
										<?php
										  if($this->uri->segment('4') != '2018-19'){
										      echo $kra_feeds[0]['weighted_score1'] + $kra_feeds[0]['weighted_score2'] + $kra_feeds[0]['weighted_score3'] + $kra_feeds[0]['weighted_score4'] + $kra_feeds[0]['weighted_score5'] + $kra_feeds[0]['weighted_score6'];
										  } else {
										      echo $kra_feeds[0]['weighted_score1'] + $kra_feeds[0]['weighted_score2'] + $kra_feeds[0]['weighted_score3'] + $kra_feeds[0]['weighted_score4'] + $kra_feeds[0]['weighted_score5'];
										  } ?>
									</b>
									</td>
									<td><b><span id="appraiser_score_total"></span></b></td>
								</tr>
                  			</tbody>
                  		</table>
						</div>
                  		<hr/>
                  		<div class="col-12 mb-2">
                  			<label>APPRAISEE COMMENTS:</label>
                  			<?php echo $kra_feeds[0]['appraisee_comments']; ?>
                  		</div>
                  		<hr/>
                  		<div class="col-12">
                  			<label class="bg-dark col-12"><h4>INDIVIDUAL DEVELOPMENT PLAN</h4></label>
                  			<br/><label>DEVELOPMENTAL NEEDS</label><br/>
                  				1. <?php echo $kra_feeds[0]['develop_need1']; ?><br/>
                  				2. <?php echo $kra_feeds[0]['develop_need2']; ?><br/>
                  			
                  			<label>DEVELOPMENT PLAN</label>
                  				<br/><?php echo $kra_feeds[0]['develop_plan']; ?>
                  			
                  			<div>
                  				<label>APPRAISER COMMENTS:</label>
                  				<textarea id="appraisal_comment" rows="" cols="" class="form-control" name="appraiser_score_comment"><?php echo $kra_feeds[0]['appraiser_comment_hod']; ?></textarea>
                  				<div id="appraisal_comment_error" class="text-danger" style="display: none;"></div>
                  			</div>
							<div class="text-center mt-3">
								<input type="submit" name="submit" class="btn btn-success" value="UPDATE" <?php if($this->my_library->get_current_session() != $this->uri->segment('4')) { echo 'disabled'; }?>>
								<input type="reset" name="reset" class="btn btn-warning" value="Cancel" <?php if($this->my_library->get_current_session() != $this->uri->segment('4')) { echo 'disabled'; }?>>
							</div>
                  		</div>
              	</div>
              </div>
              </form>
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
		$(".appraiser_score").each(function(){
			var id = $(this).data('id');
			if(!parseFloat($('#appraiser_score'+id).val()) > '0'){
				counter = counter + 1;
				$('#appraiser_score'+id+'_error').html('not to be zero').show();
			} 
		});

		if(!$('#appraisal_comment').val().length){
			counter = counter + 1;
			$('#appraisal_comment_error').html('Appraisal Comment is required.').show();
		} else {
			$('#appraisal_comment_error').html('').hide();
		}
		
		if(parseFloat($('#appraiser_score_total').text()) > '100.00'){
			counter = counter + 1;
		}
		
		if(!counter){
			return true;
		} else {
			return false;
		}
	}
    
    var baseUrl = $('#base_url').val();
    score();

    $(document).on('keyup blur','.appraiser_score',function(){
    	score();
    });
	
	
	function score(){
		if(typeof $('#appraiser_score1').val() === 'undefined') { var w1 = '0'; } else { if($('#appraiser_score1').val() == ''){ var w1 = '0' } else { var w1 = $('#appraiser_score1').val() } }
		if(typeof $('#appraiser_score2').val() === 'undefined') { var w2 = '0'; } else { if($('#appraiser_score2').val() == ''){ var w2 = '0' } else { var w2 = $('#appraiser_score2').val() } }
		if(typeof $('#appraiser_score3').val() === 'undefined') { var w3 = '0'; } else { if($('#appraiser_score3').val() == ''){ var w3 = '0' } else { var w3 = $('#appraiser_score3').val() } }
		if(typeof $('#appraiser_score4').val() === 'undefined') { var w4 = '0'; } else { if($('#appraiser_score4').val() == ''){ var w4 = '0' } else { var w4 = $('#appraiser_score4').val() } }
		if(typeof $('#appraiser_score5').val() === 'undefined') { var w5 = '0'; } else { if($('#appraiser_score5').val() == ''){ var w5 = '0' } else { var w5 = $('#appraiser_score5').val() } }
		if(typeof $('#appraiser_score6').val() === 'undefined') { var w6 = '0'; } else { if($('#appraiser_score6').val() == ''){ var w6 = '0' } else { var w6 = $('#appraiser_score6').val() } }
		var x = (parseFloat(w1)+parseFloat(w2)+parseFloat(w3)+parseFloat(w4)+parseFloat(w5)+parseFloat(w6)).toFixed(2);
		$('#appraiser_score_total').html(x);
	}


	$(".appraiser_score").on("keypress keyup blur",function (event) {
     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
		var id = $(this).data('id');
		if(parseFloat($(this).val()) > '100.00'){
			$('#appraiser_score'+id+'_error').html('Value not be greater than 100').show();
		} else {
			$('#appraiser_score'+id+'_error').html('').hide();
		}
		if(parseFloat($('#appraiser_score_total').text()) > '100.00'){
			$('#appraiser_score_total').html('<b class="text-danger">Appraiser total should not more than 100.</b>');
		}
     });
	
    </script>
    </body>
</html>