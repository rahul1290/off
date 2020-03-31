<input id="current_pl" type="hidden" value="<?php echo $pls[0]['balance'];?>">

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
		<div class="col-12">
			<form name="f1" method="POST" action="<?php echo base_url('es/leave-request');?>">
			<input type="hidden" name="f1_pl" id="f1_pl" value="<?php echo $pls[0]['balance']; ?>" />
			<input type="hidden" name="f1_lop" id="f1_lop" value="0" />
			  
			<?php echo $this->session->flashdata('msg'); ?>
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title">LEAVE REQUEST FORM</span>
                <span class="float-right">Current Remaining Pl's : <span class="font-weight-bold"><?php echo $pls[0]['balance']; ?></span></span>
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
								<input type="text" id="from_date" name="from_date" class="form-control datepicker" autocomplete="off"><?php echo set_value('from_date'); ?>
								<?php echo form_error('from_date'); ?>
									<b>TO</b>
								<input type="text" id="to_date" name="to_date" class="form-control datepicker" autocomplete="off">
								<?php echo form_error('to_date'); ?>
								<span id='date_range' class="ml-2" style="display: none;"></span>
							</td>
						</tr>
						<tr id="leave_adjust" style="display: none;">
							<td><b>LEAVE ADJUSTMENT</b></td>
							<td>
								<?php if(count($coffs)>0){ ?>
								<b>COMP OFF:</b> <ul style="list-style: none;"><?php foreach($coffs as $coff){ ?>
													<li><input type="checkbox" name="coff[]" class="leave coffs" data-value="<?php echo $coff['refrence_id']; ?>" value="<?php echo $coff['refrence_id']; ?>" /><?php echo $this->my_library->sql_datepicker($coff['date_from']); ?></li>											        
										    <?php } ?> </ul>
								<?php }?>
                              			
                              	<?php if(count($nhfhs)>0){ ?>
                              	<br/><b>NH/FH:</b> <ul style="list-style: none;"><?php foreach($nhfhs as $nhfh){ ?>
													<li><input type="checkbox" name="nhfh[]" class="leave nhfhs" data-value="<?php echo $nhfh['refrence_id']; ?>" value="<?php echo $nhfh['refrence_id']; ?>" /><?php echo $this->my_library->sql_datepicker($nhfh['date_from']); ?></li>											        
										    <?php } ?> </ul>
								<?php } ?>
                               <hr/><br/>
                               		<span>Total PL Deduct: <span id="pl_deduct"></span></span>
                               		<span class="float-right">Loss of pay: <span id="lop">0</span></span>
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR LEAVE</b></td>
							<td>
								<textarea id="reason" name="reason" class="form-control"></textarea>
								<?php echo form_error('reason'); ?>
							</td>
						</tr>
						<tr>
							<td><b>WEEK OFF DAY</b></td>
							<td>
								<input type="radio" name="wod" value="1" class="wo ml-1">SUN
								<input type="radio" name="wod" value="2" class="wo ml-1">MON
								<input type="radio" name="wod" value="3" class="wo ml-1">TUE	
								<input type="radio" name="wod" value="4" class="wo ml-1">WED
								<input type="radio" name="wod" value="5" class="wo ml-1">THU
								<input type="radio" name="wod" value="6" class="wo ml-1">FRI
								<input type="radio" name="wod" value="7" class="wo ml-1">SAT
								<?php echo form_error('wod'); ?>
							</td>
						</tr>
					</table>
				</div>
				
              </div>
            </div>
            	<div class="text-center">
					<input type="submit" value="Submit" class="btn btn-warning" id="submit" />
					<input type="reset" value="Cancel" class="btn btn-secondary" />
				</div>
			</form>
			<hr/>
          
          <?php if(count($requests)>0) { ?>
    		  <div class="card card-info">
                  <div class="card-header" style="border-radius:0px;">
                    <h3 class="card-title">LEAVE REQUESTS</h3>
                  </div>
                  <div class="card-body">
    				<div class="table-responsive">
    					<table class="table table-bordered table-striped text-center" id="example">
    						<thead class="bg-dark">
        						<tr>
        							<th>S.No.</th>
        							<th>REFERENCE No.</th>
        							<th>REQUEST SUBMIT DATE</th>
        							<th>LEAVE FROM</th>
        							<th>LEAVE TO</th>
        							<th>LEAVE DURATION</th>
        							<th>PL TAKEN</th>
        							<th>OFF TAKEN</th>
        							<th>HOD REMARK</th>
        							<th>HOD STATUS</th>
        							<th>HR REMARK</th>
        							<th>HR STATUS</th>
        						</tr>
    						</thead>
    						<tbody>
    								<?php  $c=1; foreach($requests as $request){ ?>
    									<tr>
        								    <td><?php echo $c++; ?></td>
        								    <td><?php echo $this->my_library->remove_hyphen($request['refrence_id']); ?></td>
        								    <td><?php echo $request['created_at']; ?></td>
        								    <td><?php echo $request['date_from']; ?></td>
        								    <td><?php echo $request['date_to']; ?></td>
        								    <td><?php
            								    $date1 = date_create($this->my_library->mydate($request['date_from']));
            								    $date2 = date_create($this->my_library->mydate($request['date_to']));
            								    $diff=date_diff($date1,$date2);
            								    
            								    echo $diff->format("%a") + 1;
            								    if($diff->format("%a") > 0)
            								        echo ' days';
            								    else 
            								        echo ' day';
            								    
                                            ?></td>
                                            <td><?php echo $request['pl']; ?></td>
        								    <td>
        								    	<?php if($request['NHFH'] != ''){
        								            echo 'NH/FH\'s:<br/><ul style="list-style:none;">';
        								            foreach(explode(',',$request['NHFH']) as $r){
        								                echo "<li>".$this->my_library->sql_datepicker($r)."</li>";
        								            }
        								        echo '</ul>'; } ?>
        								        <?php if($request['COFF'] != ''){
        								            echo 'COFF\'s:<br/><ul style="list-style:none;">';
        								            foreach(explode(',',$request['COFF']) as $r){
        								                echo "<li>".$this->my_library->sql_datepicker($r)."</li>";
        								            }
        								        echo '<ul/>'; } ?>
        								    </td>
        								    <td><?php echo $request['hod_remark']; ?></td>
        								    <td class="<?php if($request['hod_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hod_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"><?php echo $request['hod_status']; ?></td>
        								    <td><?php echo $request['hr_remark']; ?></td>
        								    <td class="<?php if($request['hod_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hod_status'] == 'PENDING'){
													echo "bg-warning";
											} else {
												echo "bg-success";
											}?>"><?php echo $request['hr_status']; ?></td>
    								    </tr>
    								<?php }?>
    							</tr>
    						</tbody>
    					</table>
    				</div>
                  </div>
                </div>
                <?php } ?>
            </div>
		  
          <hr/>
		  
		  
		
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


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	$('#example').DataTable();
	Difference_In_Days = 0;
	leave_adjustment = 0;
	
	function date_convert(date){
		v = date.split('/');
		return v[1]+'/'+v[0]+'/'+v[2];
	}

	$(document).on('change','#from_date,#to_date',function(){
		var date1 = new Date(date_convert($('#from_date').val()));
		var date2 = new Date(date_convert($('#to_date').val()));
		var Difference_In_Time = date2.getTime() - date1.getTime();
		Difference_In_Days = ((Difference_In_Time / (1000 * 3600 * 24))+1);
		
		pl_deduct();
		
		$('.leave').prop("checked", false);
		if(Difference_In_Days > $('#current_pl').val()){ 
			$('#pl_deduct').text($('#current_pl').val()); 
			$('#f1_pl').val($('#current_pl').val());
		} else {
			$('#pl_deduct').text(Difference_In_Days);
			$('#f1_pl').val(Difference_In_Days);
		}
	});

	
	function pl_deduct(){
		if(Difference_In_Days > 0) {
			$('#leave_adjust').show();	
			$('#date_range').text(Difference_In_Days +' Days').show();
			coff = $('.coffs:checkbox:checked').length;
			nhfh = $('.nhfhs:checkbox:checked').length;
			
			var pl_deduct = parseInt(Difference_In_Days) - parseInt(coff) - parseInt(nhfh);
			if(pl_deduct > 0) {
				if(pl_deduct > $('#current_pl').val()){
					$('#pl_deduct').text($('#current_pl').val());
					$('#f1_pl').val($('#current_pl').val());
				} else {
					$('#pl_deduct').text(pl_deduct);
					$('#f1_pl').val(pl_deduct);
				}
				if(pl_deduct - $('#current_pl').val() > 0) {
					$('#lop').text(pl_deduct - $('#f1_pl').val());
					$('#f1_lop').val(pl_deduct - $('#f1_pl').val());
				} else {
					$('#lop').text(0);
					$('#f1_lop').val(0);
				}
			}
			else { 
				$('#pl_deduct').text(0);
			}	
		} else {
			$('#date_range').text('').hide();
			$('#leave_adjust').hide();
		}
	}

	$(document).on('click','.leave',function(){
		if(Difference_In_Days > leave_adjustment){ 
			pl_deduct();
    		if($(this).prop("checked") == true){
    			leave_adjustment = parseInt(parseInt(leave_adjustment) + 1);
    		} else {
    			leave_adjustment = parseInt(parseInt(leave_adjustment) - 1);
    		}		
		} else {
			if($(this).prop("checked") == true){
				$(this).prop("checked", false);
			} else {
				pl_deduct();
				leave_adjustment = parseInt(parseInt(leave_adjustment) - 1);
			}
		}
	});

});
</script>
</body>