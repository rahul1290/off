<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">EMPLOYEE'S NH/FH DAY DUTY REQUEST</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR management</li>
						<li class="breadcrumb-item active">NH/FH day duty requests</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		
			  <div class="offset-2 col-8">
			  	<div class="table-responsive">
			  		<table class="table table-condensed table-bordered table-striped">
			  			<thead class="bg-dark text-center">
			  				<tr>	
			  					<th>S.No.</th>
			  					<th>DEPARTMENT</th>
			  					<th>TOTAL</th>
			  					<th>VIEW</th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				<?php if(count($requests)>0){
			  				    $c = 1;
			  				    foreach($requests as $request){ ?>
			  				      <tr>
			  				      	<td class="pt-0 pb-0"><?php echo $c++; ?>.</td>
			  				      	<td class="pt-0 pb-0"><?php echo $request['dept_name']; ?></td>
			  				      	<td class="pt-0 pb-0 text-center"><?php echo $request['requests']; ?></td>
			  				      	<td class="pt-0 pb-0 text-center"><a href="javascript:void(0);" class="view" data-dept_id="<?php echo $request['department_id']; ?>">View</a></td>
			  				      </tr>  
			  				<?php }
			  				}?>
			  			</tbody>
			  		</table>
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
  
  
  
  
  
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="request_body" style="max-height:500px;overflow-y:scroll;">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
   </div>


<script>
var baseUrl = $('#baseUrl').val();

$(document).on('click','.view',function(){
	var dept_id = $(this).data('dept_id');
	$.ajax({
		url : baseUrl+'Hr_ctrl/nh_fh_day_duty_requestList',
		type : 'POST',
		data : {
			'dept_id' : dept_id
			},
		dataType : 'json',
		beforeSend:function(){
			$('#request_body').html('').hide();
		},
		success:function(response){
			console.log(response);
			if(response.status == 200){
				var x = '<table class="table table-condensed table-bordered table-striped"><thead class="bg-dark"><tr>'+
									'<th>S.No.</th>'+
									'<th>RequestId</th>'+
									'<th>Name</th>'+
									'<th>EmpCode</th>'+
									'<th>Department</th>'+
									'<th>Leave from</th>'+
									'<th>HOD Remark</th>'+
								'</tr></thead><tbody>';
    			$.each(response.data,function(key,value){
    				x = x + '<tr>'+
    							'<td class="pt-0 pb-0">'+ parseInt(key+1) +'.</td>'+
    							'<td class="pt-0 pb-0">'+ value.reference_id +'</td>'+
    							'<td class="pt-0 pb-0">'+ value.name +'</td>'+
    							'<td class="pt-0 pb-0">'+ value.ecode +'</td>'+
    							'<td class="pt-0 pb-0">'+ value.dept_name +'</td>'+
    							'<td class="pt-0 pb-0">'+ value.date_from +'</td>'+
    							'<td class="pt-0 pb-0">'+ value.hod_remark +'</td>'+
    						'</tr>';
    			});
    			x = x + '</tbody></table>';
    			console.log(x);
    			$('#request_body').html(x).show();
    			$('#exampleModal').modal({
    				'show':true
    			});
			}
		}

	});
});
</script>
</body>