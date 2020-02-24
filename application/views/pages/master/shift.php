   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Shift Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Shift</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="col-md-12">
            
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="">
					SHIFT MASTER
				</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  
				  <div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Select Department</label>
					<div class="col-sm-10">
					  <select class="form-control" name="department" id="department">
							<option value="0">Select Department</option>
						<?php foreach($departments as $department){ ?>
							<option value="<?php echo $department['id']; ?>"><?php echo $department['dept_name'];?></option>
						<?php } ?>
					  </select>
					</div>
				  </div>

				 <div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Month</label>
					<div class="col-sm-10">
					  <select name="month" class="form-control" id="month">
							<option value="p"><?php echo date("F", strtotime("first day of previous month")); ?></option>
							<option value="c" selected><?php echo date('F'); ?></option>
					  </select>
					</div>
				  </div>
				 
				  <div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Select Employee</label>
					<div class="col-sm-10">
					  <select name="employee" class="form-control" id="employee">
							<option value="0">Select Employee</option>
					  </select>
					</div>
				  </div>
				  
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			<div id="attendance"></div>
			<div id="all_emp_attendance"></div>	
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
</div>


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	$('#example').DataTable();
	
	
	fetch_employees();
	function fetch_employees(){
		var dept = $('#department').val();
		if(dept != 0){
			$.ajax({
				type: 'GET',
				url: baseUrl+'master/department_ctrl/department_employees/'+ dept,
				data: { },
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						var x = '<option value="0">Select Employee</option>';
						$.each(response.data,function(key,value){
							x = x + '<option value="'+ value.ecode +'">'+ value.name +'</option>';
						});
						$('#employee').html(x);
					} else {
						var x = '<option value="0">Select Employee</option>';
						$('#employee').html(x);
					}
				}
			});
		} else {
			var x = '<option value="0">Select Employee</option>';
			$('#employee').html(x);
		}
	}
	
	$(document).on('change','#department',function(){
		fetch_employees();
		get_all_employee();
	});
	
	$(document).on('change','#month',function(){
		get_all_employee();
		$("#employee").trigger("change");
	});
	
	$(document).on('change','#employee',function(){
		var ecode = $(this).val();
		if(ecode != '0'){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/Shift_ctrl/get_attendance/',
			data: { 
				'ecode' : ecode,
				'month' : $('#month').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					var res = response.data[0].shift.split(",");
					var nofdays = response.nofdays;
					var x = '<div class="card card-info">'+
								'<div class="card-header" style="border-radius:0px;">'+
									'<span class="card-title"></span>'+
									'<span class="">'+
										'EMPLOYEE SHIFT DETAIL'+
									'</span>'+
							'</div>'+
							'<div class="card-body">'+
								'<div class="table-responsive">'+
								'<table class="table table-bordered">'+
									'<tr class="bg-dark">'+
										'<td>Name/Day\'s</td>';
										for(i=1;i<=nofdays;i++){
											x = x + '<td>'+ i +'</td>';
										}	
									x = x + '<tr>'+
									'<tr>'+
										'<td>'+ response.data[0].uname +'</td>';
										for(i=1;i <= nofdays;i++){
											x = x + '<td>'+ response.saviour[i-1].IN1 +'<select class="shift" data-id="'+i+'"><option value="0">Shift</option>';
													if(res[i-1] == "A")
														x = x + '<option value="A" selected>A</option>';
													else
														x = x +'<option value="A">A</option>';
													
													if(res[i-1] == "B")
														x = x + '<option value="B" selected>B</option>';
													else
														x = x +'<option value="B">B</option>';
													
													if(res[i-1] == "C")
														x = x + '<option value="C" selected>C</option>';
													else
														x = x +'<option value="C">C</option>';
													
													if(res[i-1] == "D")
														x = x + '<option value="D" selected>D</option>';
													else
														x = x +'<option value="D">D</option>';
													
													if(res[i-1] == "E")
														x = x + '<option value="E" selected>E</option>';
													else
														x = x +'<option value="E">E</option>';
													
													if(res[i-1] == "F")
														x = x + '<option value="F" selected>F</option>';
													else
														x = x +'<option value="F">F</option>';		
													
													if(res[i-1] == "G")
														x = x + '<option value="G" selected>G</option>';
													else
														x = x +'<option value="G">G</option>';
													
													if(res[i-1] == "H")
														x = x + '<option value="H" selected>H</option>';
													else
														x = x +'<option value="H">H</option>';
													
													if(res[i-1] == "I")
														x = x + '<option value="I" selected>I</option>';
													else
														x = x +'<option value="I">I</option>';
													
													if(res[i-1] == "J")
														x = x + '<option value="J" selected>J</option>';
													else
														x = x +'<option value="J">J</option>';
													
													if(res[i-1] == "K")
														x = x + '<option value="K" selected>K</option>';
													else
														x = x +'<option value="K">K</option>';
													
													if(res[i-1] == "L")
														x = x + '<option value="L" selected>L</option>';
													else
														x = x +'<option value="L">L</option>';
													
													if(res[i-1] == "M")
														x = x + '<option value="M" selected>M</option>';
													else
														x = x +'<option value="M">M</option>';
													
													if(res[i-1] == "N")
														x = x + '<option value="N" selected>N</option>';
													else
														x = x +'<option value="N">N</option>';
													
													if(res[i-1] == "LEV")
														x = x + '<option value="LEV" selected>LEV</option>';
													else
														x = x +'<option value="LEV">LEV</option>';
													
													if(res[i-1] == "HF")
														x = x + '<option value="HF" selected>HF</option>';
													else
														x = x +'<option value="HF">HF</option>';
													
													if(res[i-1] == "NH")
														x = x + '<option value="NH" selected>NH</option>';
													else
														x = x +'<option value="NH">NH</option>';
													
													if(res[i-1] == "FH")
														x = x + '<option value="FH" selected>FH</option>';
													else
														x = x +'<option value="FH">FH</option>';
													
													if(res[i-1] == "TR")
														x = x + '<option value="TR" selected>TR</option>';
													else
														x = x +'<option value="TR">TR</option>';
													
											x = x + '</select>'+ response.saviour[i-1].OUT2 +'</td>';
										}
									x = x + '</tr>'+
								'</table>'+
								'</div>'+
							'</div>'+
						'</div>';
					
					$('#attendance').html(x);
				} else {
					var x = '<div class="card card-info">'+
								'<div class="card-header" style="border-radius:0px;">'+
									'<span class="card-title"></span>'+
									'<span class="">'+
										'EMPLOYEE SHIFT DETAIL'+
									'</span>'+
							'</div>'+
							'<div class="card-body">'+
								'<div class="table-responsive">'+
								'<table class="table table-bordered">'+
									'<tr class="bg-dark">'+
										'<td>Name/Day\'s</td>';
										for(i=1;i<=parseInt(response.nofdays);i++){
											x = x + '<td>'+ i +'</td>';
										}
									x = x + '<tr>'+
									'<tr><td>'+ $("#employee option:selected").text() +'</td>';
										for(i=1;i<=parseInt(response.nofdays);i++){
											x = x + '<td>'+ response.saviour[i-1].IN1 +
														'<select class="shift" data-id="'+i+'">'+
															'<option value="0">Shift</option>'+
															'<option value="A">A</option>'+
															'<option value="B">B</option>'+
															'<option value="C">C</option>'+
															'<option value="D">D</option>'+
															'<option value="E">E</option>'+
															'<option value="F">F</option>'+
															'<option value="G">G</option>'+
															'<option value="H">H</option>'+
															'<option value="I">I</option>'+
															'<option value="J">J</option>'+
															'<option value="K">K</option>'+
															'<option value="L">L</option>'+
															'<option value="M">M</option>'+
															'<option value="N">N</option>'+
															'<option value="LEV">LEV</option>'+
															'<option value="HF">HF</option>'+
															'<option value="NH">NH</option>'+
															'<option value="FH">FH</option>'+
															'<option value="TR">TR</option>'+
														'</select>'+
														response.saviour[i-1].OUT2 +
													'</td>';
										}
									x = x + '</tr>'+
								'</table>'+
								'</div>'+
							'</div>'+
						'</div>';
					
					$('#attendance').html(x);
				}
			}
		});
		}
	});
	
	
	function get_all_employee(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/Shift_ctrl/get_department_attendance',
			data: { 
				'dept_id' : $('#department').val(),
				'month' : $('#month').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				var x = '<div class="card card-info">'+
								'<div class="card-header" style="border-radius:0px;">'+
									'<span class="card-title"></span>'+
									'<span class="">'+
										'ALL EMPLOYEE SHIFT'+
									'</span>'+
							'</div>'+
							'<div class="card-body">'+
								'<div class="table-responsive"><table class="table table-bordered">'+
									'<tr class="bg-dark">'+
										'<td>Name/Day\'s</td>';
										for(i=1;i<=parseInt(response.nofdays);i++){
											x = x + '<td>'+i+'</td>';
										}
							x = x +	'</tr>';
								$.each(response.data,function(key,value){
									x = x + '<tr><td>'+ value.uname +'</td>';
									var res = value.shift.split(",");
									for(i=1;i<=parseInt(response.nofdays);i++){
										if(typeof res[i-1] == 'undefined'){
											x = x + '<td> </td>';
										} else {
											color = '';
											if(res[i-1] == 'LEV')
												color = 'bg-danger';
											else if(res[i-1] == 'HF')
												color = 'bg-secondary';
											else if(res[i-1] == 'NH')
												color = 'bg-warning';
											else if(res[i-1] == 'FH')
												color = 'bg-warning';
											else if(res[i-1] == 'TR')
												color = 'bg-success';
											x = x + '<td class="'+ color +'">'+res[i-1]+'</td>';
										}
									}
									x = x + '</tr>';
								});
							x = x + '</table></div>'+
							'</div>'+
						'</div>'+
					'</div>';
			$('#all_emp_attendance').html(x);
			}
		});
	}
	
	$(document).on('change','.shift',function(){
		var day = $(this).data('id');
		var ecode = $('#employee').val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/Shift_ctrl/attendance_submit',
			data: { 
				'dept_id' : $('#department').val(),
				'month' : $('#month').val(),
				'day' : day,
				'ecode' : ecode,
				'shift' : $(this).val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					get_all_employee();
				}
			}
		});
	});
});
</script>
</body>