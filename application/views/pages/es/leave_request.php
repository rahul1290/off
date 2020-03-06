  
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
      <?php
//       $diff = date_diff(date_create($this->my_library->mydate('08/03/2020')),date_create($this->my_library->mydate('20/03/2020')));
//       echo $diff->format("%a");
        ?>
		<div class="offset-md-1 col-md-10">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">LEAVE REQUEST</h3>
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
								<input type="text" id="from_date" name="from_date" class="form-control datepicker">
									<b>TO</b>
								<input type="text" id="to_date" name="to_date" class="form-control datepicker">
								<span id='date_range' style="display: none;"></span>
							</td>
						</tr>
						<tr id="leave_adjust" style="display: none;">
							<td><b>LEAVE ADJUSTMENT WITH</b></td>
							<td>
								<?php if(count($coffs)>0){ ?>
								<b>COMP OFF:</b> <ul style="list-style: none;"><?php foreach($coffs as $coff){ ?>
													<li><input type="checkbox" name="coffs[]" class="coffs" data-value="<?php echo $coff['refrence_no']; ?>" value="<?php echo $coff['refrence_no']; ?>" /><?php echo $coff['date']; ?></li>											        
										    <?php } ?> </ul>
								<?php }?>
                              			
                              	<?php if(count($nhfhs)>0){ ?>
                              	<br/><b>NH/FH:</b> <ul style="list-style: none;"><?php foreach($nhfhs as $nhfh){ ?>
													<li><input type="checkbox" name="nhfhs[]" class="nhfhs" data-value="<?php echo $nhfh['refrence_no']; ?>" value="<?php echo $nhfh['refrence_no']; ?>" /><?php echo $nhfh['date']; ?></li>											        
										    <?php } ?> </ul>
								<?php } ?>
                               <hr/><br/>Total PL Deduct: <span id="pl_deduct"></span>
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR LEAVE</b></td>
							<td>
								<textarea id="reason" name="reason" class="form-control"></textarea>
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
							</td>
						</tr>
					</table>
				</div>
				
              </div>
            </div>
            	<div class="text-center">
					<input type="button" value="Submit" class="btn btn-warning" id="submit" />
					<input type="button" value="Cancel" class="btn btn-secondary" />
				</div>
          </div>
		  
		  
		  <div class="offset-md-1 col-md-10" style="display:none;">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">LEAVE ADJUSTMENT SECTION</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>LOSS OF PAY (LOP)</td>
							<td>
								<input type="radio" name="lop" class="ml-1" value="YES">YES
								<input type="radio" name="lop" class="ml-1" value="NO">NO
								</br><span>No of Days</span> : <input type="text" name="lop_days" placeholder="No of days">
							</td>
						</tr>
						<tr>
							<td><b>WORK ON WEEK OFF / HOLIDAY DATES</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR WORKING ON A HOLIDAY / WEEK OFF</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
					</table>
				</div>
              </div>
            </div>
				<div class="text-center">
					<input type="button" value="Send" class="btn btn-warning">
					<input type="button" value="Cancel" class="btn btn-secondary">
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


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){

	function date_convert(date){
		v = date.split('/');
		return v[1]+'/'+v[0]+'/'+v[2];
	}

	$(document).on('change','#from_date,#to_date',function(){
		pl_deduct();
	});

	$(document).on('click','.coffs,.nhfhs',function(){
		pl_deduct();
	});

	function pl_deduct(){
		var date1 = new Date(date_convert($('#from_date').val()));
		var date2 = new Date(date_convert($('#to_date').val()));
		var Difference_In_Time = date2.getTime() - date1.getTime();
		Difference_In_Days = ((Difference_In_Time / (1000 * 3600 * 24))+1);
		if(Difference_In_Days > 0) {
			$('#leave_adjust').show();	
			$('#date_range').text(Difference_In_Days +' Days').show();
			coff = $('.coffs:checkbox:checked').length;
			nhfh = $('.nhfhs:checkbox:checked').length;
			$('#pl_deduct').text(parseInt(Difference_In_Days) - parseInt(coff) - parseInt(nhfh));
		} else {
			$('#date_range').text('').hide();
			$('#leave_adjust').hide();
		}
	}

	$(document).on('click','#submit',function(){	
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var coff = [];
		var nhfh = [];

		$.each($("input[name='wod']:checked"), function(){
            wod = $(this).val();
        });
        
		$. each($(".coffs:checked"), function(){
			coff.push($(this).val());
		});
		
		$. each($(".nhfhs:checked"), function(){
			nhfh.push($(this).val());
		});


		$.ajax({
			type: 'POST',
			url: baseUrl + 'Emp_ctrl/leave_request/',
			data: { 
				'from_date' : from_date,
				'to_date' : to_date,
				'coff' : coff,
				'nhfh' : nhfh,
				'wod' : wod,
				'reason' : $('#reason').val(),
				'pl' : $('#pl_deduct').text()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
				} else {
				}
			}
		});
		
	});

});
</script>
</body>