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
	});
	
	$(document).on('change','#employee',function(){
		var ecode = $(this).val();
		$.ajax({
			type: 'GET',
			url: baseUrl+'master/Shift_ctrl/get_attendance/'+ ecode,
			data: { },
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					console.log(response);
				} else {
					var x = '<div class="card card-info">'+
								'<div class="card-header" style="border-radius:0px;">'+
									'<span class="card-title"></span>'+
									'<span class="">'+
										'Employee SHIFT MASTER'+
									'</span>'+
							'</div>'+
							'<div class="card-body">'+
							'</div>'+
						'</div>';
					
					$('#attendance').html(x);
				}
			}
		});
	});
});
</script>
</body>