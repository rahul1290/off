	  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Cab request</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Cab request</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <!--<div class="content">-->
      <div class="container-fluid">
      	<form name="f1" method="POST" action="<?php echo base_url('Cab_ctrl'); ?>">
    		<div class="col-md-12 mb-3">
    			<?php echo $this->session->flashdata('msg'); ?>
                <div class="card card-info">
                  <div class="card-header" style="border-radius:0px;">
                    <h3 class="card-title">CAB REQUEST FORM</h3>
                  </div>
                  <div class="card-body">
            			<div class="table-responsive">
            				<table class="table table-bordered">
            					<tr>
            						<td>Date</td>
            						<td>
            							<input type="text" id="from_date" name="from_date" class="form-control datepicker" autocomplete="off" value="<?php echo set_value('from_date'); ?>">
            							<?php echo form_error('from_date'); ?>
            								<b>TO</b>
            							<input type="text" id="to_date" name="to_date" class="form-control datepicker" autocomplete="off" value="<?php echo set_value('to_date'); ?>">
            							<?php echo form_error('to_date'); ?>
            							<span id='date_range' class="ml-2" style="display: none;"></span>
            						</td>
            					</tr>
            					<tr>
            						<td>Select Pickup/Droping</td>
            						<td>
            							<select class="form-control" name="pickdrop" id="pickdrop">
            								<option value=''>Select pick/drop</option>
            								<option value="pickup" <?php if(set_value('pickdrop') =='pickup'){ echo "selected"; } ?>>Pickup</option>
            								<option value="drop" <?php if(set_value('pickdrop') =='drop'){ echo "selected"; } ?>>Drop</option>
            							</select>
            							<?php echo form_error('pickdrop'); ?>
            						</td>
            					</tr>
            					<tr>
            						<td>Time</td>
            						<td>
            							<select name="time" id="time" class="form-control">
            								<option value="0">Select time</option>
            								<?php if(isset($cabTime)){
            								    foreach ($cabTime as $cabt) { ?>
            								        <option value="<?php echo $cabt['id'];?>" <?php if(set_value('time') == $cabt['id']){ echo "selected"; }?>><?php echo $cabt['time']; ?></option>
            								<?php } 
            								} ?>
            							</select>
            							<?php echo form_error('time'); ?>
            						</td>
            					</tr>
            					<tr>
            						<td>Zone</td>
            						<td>
            							<select class="form-control" name="zone" id="zone">
            								<option value="0">Select zone</option>
            								<?php if(isset($cabZone)){
            								    foreach ($cabZone as $cabz) { ?>
            								        <option value="<?php echo $cabz['id'];?>" <?php if(set_value('zone') == $cabz['id']){ echo "selected"; }?>><?php echo $cabz['location_name']; ?></option>
            								<?php } 
            								} ?>
            							</select>
            							<?php echo form_error('zone'); ?>
            						</td>
            					</tr>
            					<tr>
            						<td>Location</td>
            						<td>
            							<select class="form-control" name="location" id="location">
            								<option value="0">Select location</option>
            								<?php if(isset($cabLocation)){
            								    foreach ($cabLocation as $cabl) { ?>
            								        <option value="<?php echo $cabl['id'];?>" <?php if(set_value('location') == $cabl['id']){ echo "selected"; }?>><?php echo $cabl['location_name']; ?></option>
            								<?php } 
            								} ?>
            							</select>
            							<?php echo form_error('location'); ?>
            						</td>
            					</tr>
            					<tr>
            						<td>Pick up/Dropping Address</td>
            						<td>
            							<textarea class="form-control" name="address" id="address">address</textarea>
            							<?php echo form_error('address'); ?>
            						</td>
            					</tr>
            					<tr>
            						<td>Week Of</td>
            						<td>
            							<input name="wod" type="radio" value="1" checked>SUN
            							<input name="wod" type="radio" value="2">MON
            							<input name="wod" type="radio" value="3">TUE
            							<input name="wod" type="radio" value="4">WED
            							<input name="wod" type="radio" value="5">THU 
            							<input name="wod" type="radio" value="6">FRI 
            							<input name="wod" type="radio" value="7">SAT
            						</td>
            					</tr>
            				</table>
            			</div>
                  </div>
                </div>
    				<div class="text-center">
    					<input type="submit" value="Submit" class="btn btn-warning">
    					<input type="reset" value="Cancel" class="btn btn-secondary">
    				</div>
              </div>
          </form>
		  <hr/>
		  
		  <?php if(isset($cab_requests)){
		      if(count($cab_requests)>0){  ?>
		     	<div class="table-responsive">
        		  	<table class="table table-bordered">
        		  		<thead>
            		  		<tr class="bg-dark text-center">
            		  			<th>S.No.</th>
            		  			<th>Request Id</th>
            		  			<th>Type</th>
            		  			<th>From Date</th>
            		  			<th>To Date</th>
            		  			<th>Time</th>
            		  			<th>Area</th>
            		  			<th>Cab Status</th>
            		  		</tr>
        		  		</thead>
        		  		<tbody>
        		  			<?php $c=1; foreach($cab_requests as $request){ ?>
        		  				<tr class="text-center">
        		  					<td><?php echo $c++; ?>.</td>
                		  			<td><?php echo $request['reqest_id']; ?></td>
                		  			<td><?php echo strtoupper($request['type']); ?></td>
                		  			<td><?php echo date('d/m/Y',strtotime($request['from_date'])); ?></td>
                		  			<td><?php echo date('d/m/Y',strtotime($request['to_date'])); ?></td>
                		  			<td><?php echo $request['time']; ?></td>
                		  			<td><?php echo $request['area']; ?></td>
                		  			<td><?php echo $request['cab_status']; ?></td>
                		  		</tr>
        		  			<?php } ?>
        		  		</tbody>
        		  	</table>
        		  </div>     
		 <?php }
		  }?>
      </div><!-- /.container-fluid -->
    <!--</div>-->
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
	Difference_In_Days = 0;
	maxallowdays = 7;

	
	function date_convert(date){
		v = date.split('/');
		return v[1]+'/'+v[0]+'/'+v[2];
	}
	
	$(document).on('change','#from_date,#to_date',function(){
		var date1 = new Date(date_convert($('#from_date').val()));
		var date2 = new Date(date_convert($('#to_date').val()));
		var Difference_In_Time = date2.getTime() - date1.getTime();
		Difference_In_Days = ((Difference_In_Time / (1000 * 3600 * 24))+1);
		if(Difference_In_Days == 1){
			$('#date_range').html(Difference_In_Days + ' day').show();
		} else if(Difference_In_Days > 1 && Difference_In_Days < (maxallowdays + 1)){
			$('#date_range').html(Difference_In_Days + ' days').show();
		} else if(Difference_In_Days > maxallowdays){
			$('#date_range').html('<span class="text-danger">Maximum '+ maxallowdays +' days allowed</span>').show();
		}
	});

	$(document).on('change','#time',function(){
		getZone();
	});

	$(document).on('change','#pickdrop',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Cab_ctrl/cab_timing',
			data: { 
				'method' : $('#pickdrop').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				var x = '<option value="0">Select time</option>';
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x = x + '<option value="'+ value.id +'">'+ value.time +'</option>';
					});
				}
				$('#time').html(x); 
			}
		});
	});


	$(document).on('change','#zone',function(){
		if($('#zone').val() != '0'){
    		$.ajax({
    			type: 'POST',
    			url: baseUrl+'Cab_ctrl/get_location',
    			data: {
    				'zone' : $('#zone').val()
    			},
    			dataType: 'json',
    			beforeSend: function() {},
    			success: function(response){
    				var x = '<option value="0">Select location</option>';
    				if(response.status == 200){
    					$.each(response.data,function(key,value){
    						x = x + '<option value="'+ value.id +'">'+ value.location_name +'</option>';
    					});
    				}
    				$('#location').html(x);
    			}
    		});
		} else {
			$('#location').html('<option value="0">Select location</option>');
		}
	});	

	
	function getZone(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Cab_ctrl/cab_zone',
			data: {},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				var x = '<option value="0">Select zone</option>';
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x = x + '<option value="'+ value.id +'">'+ value.location_name +'</option>';
					});
				}
				$('#zone').html(x); 
			}
		});
	}


	
});
</script>
</body>