<?php if(!isset($pls[0]['balance'])){ 
	$pls[0]['balance'] = 0;
}?>
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
						<li class="breadcrumb-item active">Employee section</li>
						<li class="breadcrumb-item active">Leave request</li>
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
                <span class="float-right">Current Remaining Pl's : <?php echo $pls[0]['balance']; ?></span>
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
								<input type="text" id="from_date" name="from_date" class="form-control datepicker" autocomplete="off" value="<?php echo set_value('from_date'); ?>">
								<?php echo form_error('from_date'); ?>
									<b>TO</b>
								<input type="text" id="to_date" name="to_date" class="form-control datepicker" autocomplete="off" value="<?php echo set_value('to_date'); ?>">
								<?php echo form_error('to_date'); ?>
								<span id='date_range' class="ml-2" style="display: none;"></span>
							</td>
						</tr>
						<?php 
						$x = set_value('coff'); 
						if(!is_array($x)){
							if(!strlen($x)){
								unset($x);
							}
						}
						$y = set_value('nhfh'); 
						if(!is_array($y)){
							if(!strlen($y)){
								unset($y);
							}
						}
						?>
						<tr id="leave_adjust" style="display: <?php if(isset($x) || isset($y)){ echo ""; } else { echo "none"; }?>;">
							<td><b>LEAVE ADJUSTMENT</b></td>
							<td>
								<?php if(count($coffs)>0){ ?>
								<b>COMP OFF:</b> <ul style="list-style: none;">
											<?php foreach($coffs as $coff){ ?>
													<li>
														<input <?php if(isset($x)){if(in_array($coff['refrence_id'],$x)){ echo "checked"; }} ?> type="checkbox" name="coff[]" class="leave coffs" data-value="<?php echo $coff['refrence_id']; ?>" value="<?php echo $coff['refrence_id']; ?>" /> <?php echo $this->my_library->sql_datepicker($coff['date_from']); ?>
													</li>											        
										    <?php } ?> 
											</ul>
								<?php }?>
                              			
                              	<?php if(count($nhfhs)>0){ ?>
                              	<br/><b>NH/FH:</b> <ul style="list-style: none;"><?php foreach($nhfhs as $nhfh){ ?>
													<li><input <?php if(isset($y)){if(in_array($nhfh['refrence_id'],$y)){ echo "checked"; }} ?> type="checkbox" name="nhfh[]" class="leave nhfhs" data-value="<?php echo $nhfh['refrence_id']; ?>" value="<?php echo $nhfh['refrence_id']; ?>" /> <?php echo $this->my_library->sql_datepicker($nhfh['date_from']); ?></li>											        
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
								<textarea id="reason" name="reason" class="form-control"><?php echo set_value('reason'); ?></textarea>
								<?php echo form_error('reason'); ?>
							</td>
						</tr>
						<tr>
							<?php echo set_value('wod'); ?>
							<td><b>WEEK OFF DAY</b></td>
							<td>
								<input type="radio" name="wod" value="1" class="wo ml-1" <?php if(set_value('wod') == 1){ echo "checked"; } ?>> SUN
								<input type="radio" name="wod" value="2" class="wo ml-1" <?php if(set_value('wod') == 2){ echo "checked"; } ?>> MON
								<input type="radio" name="wod" value="3" class="wo ml-1" <?php if(set_value('wod') == 3){ echo "checked"; } ?>> TUE	
								<input type="radio" name="wod" value="4" class="wo ml-1" <?php if(set_value('wod') == 4){ echo "checked"; } ?>> WED
								<input type="radio" name="wod" value="5" class="wo ml-1" <?php if(set_value('wod') == 5){ echo "checked"; } ?>> THU
								<input type="radio" name="wod" value="6" class="wo ml-1" <?php if(set_value('wod') == 6){ echo "checked"; } ?>> FRI
								<input type="radio" name="wod" value="7" class="wo ml-1" <?php if(set_value('wod') == 7){ echo "checked"; } ?>> SAT
								<?php echo form_error('wod'); ?>
							</td>
						</tr>
					</table>
				</div>
				
              </div>
            </div>
            	<div class="text-center">
					<input type="submit" value="Submit" class="btn btn-warning" id="submit"/>
					<input type="reset" value="Cancel" class="btn btn-secondary" />
				</div>
			</form>
			<hr/>
          
          <?php /*if(isset($requests)){ if(count($requests)>0) { ?>
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
									<th>REASON</th>
        							<th>PL TAKEN</th>
        							<th>LEAVE ADJUSTMENT</th>
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
                                            <td><?php echo $this->my_library->day_duration($request['date_from'],$request['date_to']); ?></td>
											<td><?php echo $request['requirment']; ?></td>
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
        								    <td class="<?php if($request['hr_status'] == 'REJECTED'){ 
													echo "bg-danger"; 
											} else if($request['hr_status'] == 'PENDING'){
													echo "bg-warning";
											} else if($request['hr_status'] == 'GRANTED') {
												echo "bg-success";
											} else {
											    
											}?>"><?php echo $request['hr_status']; ?></td>
    								    </tr>
    								<?php }?>
    							</tr>
    						</tbody>
    					</table>
    				</div>
                  </div>
                </div>
                <?php } } */ ?>
               <div class="col-12">
                 <div class="card card-info">
                  <div class="card-header" style="border-radius:0px;">
                     <h3 class="card-title">LEAVE REQUESTS</h3>
                  </div>
                	<div class="card-body">
    					<div class="table-responsive">
    						<input id="search" type="text" class="float-right mb-2">
    						<label class="float-right mr-2" for="search">Search: </label>
    						<table class="table table-bordered table-striped text-center" id="leave_requests_head">
    							<thead class="bg-dark">
    								<tr>
            							<th>S.No.</th>
            							<th>REFERENCE No.</th>
            							<th>REQUEST SUBMIT DATE</th>
            							<th>LEAVE DATE</th>
            							<th>REASON</th>
            							<th>LEAVE DURATION</th>
            							<th>PL DEDUCT</th>
            							<th>LOP</th>
            							<th>LEAVE ADJUSTMENT</th>
            							<th>HOD REMARK</th>
            							<th>HOD STATUS</th>
            							<th>HR REMARK</th>
    									<th>HR STATUS</th>
            						</tr>
    							</thead>
    							<tbody id="leave_requests_body"></tbody>
    						</table>
    						<nav aria-label="Page navigation example" id="leave_requests_links"></nav>
    					</div>
    				</div>
    			</div>
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
	console.log('ready');
	$('#example').DataTable();

	Difference_In_Days = 0;
	leave_adjustment = 0;
	
	daycalculator();

	$(document).on('click','#submit',function(){
		$('#exampleModalCenter').modal({show:true});
	});
	
	function date_convert(date){
		v = date.split('/');
		return v[1]+'/'+v[0]+'/'+v[2];
	}

	$(document).on('change','#from_date,#to_date',function(){
		daycalculator();
		leaveLop();
	});


	function daycalculator(){
		var date1 = new Date(date_convert($('#from_date').val()));
		var date2 = new Date(date_convert($('#to_date').val()));
		var Difference_In_Time = date2.getTime() - date1.getTime();
		Difference_In_Days = ((Difference_In_Time / (1000 * 3600 * 24))+1);
		 
		pl_deduct();
		
		$('.leave').prop("checked", false);

		var cpl = $('#current_pl').val();
		if(cpl >= 0){
			
		} else {
			cpl = 0;
		}
		
		if(Difference_In_Days > cpl){ 
			$('#pl_deduct').text(cpl);
			$('#f1_pl').val(cpl);
		} else {
			$('#pl_deduct').text(Difference_In_Days);
			if(isNaN(Difference_In_Days)){
				$('#f1_pl').val(0);
			} else {
				$('#f1_pl').val(Difference_In_Days);
			}
		}
	}

	
	function pl_deduct(){
		if(Difference_In_Days > 0) {
			$('#leave_adjust').show();	
			$('#date_range').text(Difference_In_Days +' Days').show();
			debugger;
			coff = $('.coffs:checkbox:checked').length;
			nhfh = $('.nhfhs:checkbox:checked').length;
			console.log(coff);
			console.log(nhfh);
			var plDeduct = parseInt(Difference_In_Days) - (parseInt(coff) + parseInt(nhfh));
			debugger; 
			//if(plDeduct > 0) {
				var cpl = $('#current_pl').val();
				if(cpl >= 0){
					
				} else {
					cpl = 0;
				}
				
				if(plDeduct > cpl){
					$('#pl_deduct').text(cpl);
					$('#f1_pl').val(cpl);
				} else {
					$('#pl_deduct').text(plDeduct);
					$('#f1_pl').val(plDeduct);
				}
				if(plDeduct - cpl > 0) {
					$('#lop').text(plDeduct - $('#f1_pl').val());
					$('#f1_lop').val(plDeduct - $('#f1_pl').val());
				} else {
					$('#lop').text(0);
					$('#f1_lop').val(0);
				}
// 			}
// 			else { 
// 				$('#pl_deduct').text(0);
// 			}	
			$('#submit').prop('disabled', false);
		} else {
			$('#submit').prop('disabled', true);
			$('#date_range').text('').hide();
			$('#leave_adjust').hide();
		}
	}

	$('#from_date,#to_date').keypress(function(e) {
	    e.preventDefault();
	}); 
	
	$(document).on('click','.leave',function(){
		leaveLop();
	});

	function leaveLop(){
		
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
				if(parseInt(leave_adjustment) > 0 ){
					leave_adjustment = parseInt(parseInt(leave_adjustment) - 1); 
				} else {
					leave_adjustment = 0;
				}
//				leave_adjustment = parseInt(parseInt(leave_adjustment) - 1);
				console.log('387 '+leave_adjustment);
			}
		}
	}
	

	ajax_test(0);	//load requests
	
	$(document).on('keyup','#search',function(){
		ajax_test(0);
	});
	
	function ajax_test(page){
		var str = $('#search').val();
        $.ajax({
        	type: 'GET',
        	url: baseUrl+'Emp_ctrl/leave_request_ajax/'+ page +'/'+ str,
        	data: {},
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
        		if(response.status == 200){
        			var x = '';
        			var c = parseInt(parseInt(page)+1);
        			$.each(response.data.final_array,function(key,value){
            			x = x + '<tr>'+
            						'<td>'+ parseInt(c++) +'</td>'+
            						'<td>'+ value.refrence_id +'</td>'+
            						'<td>'+ value.created_at +'</td>'+
            						'<td>'+ value.date_from +'</td>'+
            						//'<td>'+ value.date_to +'</td>'+
            						'<td>'+ value.requirment +'</td>'+
            						'<td>'+ value.duration +'</td>'+
            						'<td>'+ parseInt(value.pl) +'</td>'+
            						'<td>'+ parseInt(value.lop) +'</td>'+
            						'<td>COFF\'s:</br>'+ value.COFF +'</br>NH/FH\'s:</br>'+ value.NHFH +'</td>'+
            						'<td>'+ value.hod_remark +'</td>';
            						var bgcolor = '';
            						if(value.hod_status == 'REJECTED'){
            							bgcolor = 'bg-danger';
                					} else if(value.hod_status == 'GRANTED'){
                						bgcolor = 'bg-success';
                    				}else if(value.hod_status == 'PENDING'){
                						bgcolor = 'bg-warning';
                    				}
                    				
            						x = x+'<td class="'+ bgcolor +'">'+ value.hod_status +'</td>'+
            							  '<td>'+ value.hod_remark +'</td>';
                					var bgcolor = '';
            						if(value.hr_status == 'REJECTED'){
            							bgcolor = 'bg-danger';
                					} else if(value.hr_status == 'GRANTED'){
                						bgcolor = 'bg-success';
                    				}else if(value.hr_status == 'PENDING'){
                						bgcolor = 'bg-warning';
                    				}
                    				
            						x = x+'<td class="'+ bgcolor +'">'+ value.hr_status +'</td>';  	
            					'</tr>';
            		});         	
            		$('#leave_requests_body').html(x);
            		$('#leave_requests_links').html(response.data.links);
        		}
        	}
        });
	}

	$(document).on('click','.myLinks',function(){
		var page = $(this).attr('href');
		var x = page.split('/');
		if(x[1] == undefined){
			x[1] = 0;
		}
		ajax_test(x[1]);	
	});
});
</script>
</body>