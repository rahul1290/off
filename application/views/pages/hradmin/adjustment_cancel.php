<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">PL Adjustment Cancel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">PL Adjustment Cancel</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      		
      		<ul class="nav nav-tabs">
            	<li class="nav-item">
              		<a class="nav-link active" id="#leave_adjustment_tab" data-toggle="tab" href="#leave_adjustment_cacellation">LEAVE ADJUSTMENT CANCELLATION</a>
            	</li>
            	<li class="nav-item">
              		<a class="nav-link" id="hf_day_tab" data-toggle="tab" href="#hf_day_cancellation">HALF DAY CANCELLATION</a>
            	</li>
          	</ul>
          	
          	<div class="tab-content">
          		<div id="leave_adjustment_cacellation" class="tab-pane active"><br>
          			<label>Select Request</label>
          			<select id="_leave_request">
          				<option value="0">Select Request</option>
          			</select>
          		</div>
          		<div id="hf_day_cancellation" class="tab-pane fade"><br>
          		hgf
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
</div>


<script>
var baseUrl = $('#baseUrl').val();

	$(document).on('change','#department',function(){
		var dept_id = $(this).val();
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'Hr_ctrl/getAllEmployee_dept',
        	data: {
            	'dept_id' : dept_id
            },
        	dataType: 'json',
        	beforeSend: function() {},
        	success: function(response){
            	if(response.status == 200){
                	console.log(response);
                	var x = '<option value="0">Select Employee</option>';
                	$.each(response.data,function(key,value){
                    	x = x + '<option value="'+ value.ecode.trim() +'">'+ value.name.toUpperCase() +'</option>';
                    });
					$('#employee').html(x);
                }
        	}
		});
	});
</script>
</body>