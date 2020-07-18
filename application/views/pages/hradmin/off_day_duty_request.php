<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">EMPLOYEE'S OFF DAY DUTY REQUESTS</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR Management</li>
						<li class="breadcrumb-item active">Off day duty request</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       		
      		<div class="offset-2 col-8">
				<table class="table table-bordered table-striped">
					<thead>
					<tr class="bg-dark text-center">
						<th>Department</th>
						<th>Total</th>
						<th>View</th>
					</tr>
					</thead>
					<tbody class="text-center">
					<?php
					if(isset($pending_requests) && count($pending_requests)>0){ 
					    foreach($pending_requests as $pending_request){?>
						<tr>
							<td><?php echo $pending_request['dept_name']; ?></td>
							<td><?php echo $pending_request['requests']; ?></td>
							<td><a href="javascript:void(0);" class="view" data-dept_id="<?php echo $pending_request['id']; ?>">View</a></td>
						<tr>
					<?php } 
					} else { ?>
					    <td colspan="3">No record found.</td>
					<?php }?>
					</tbody>
				</table>
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

$(document).ready(function(){
	$(document).on('click','.view',function(){
		var dept_id = $(this).data('dept_id');
		$.ajax({
        	type: 'POST',
        	url: baseUrl+'hr/off_day_duty_ctrl/request_list/',
        	data: {
            	'dept_id' : dept_id
            },
        	dataType: 'json',
        	beforeSend: function() {
            	$('#request_body').html('').hide();
            },
        	success: function(response){
            	if(response.status == 200){
                	var x = '<table class="table table-bordered table-striped"><thead class="bg-dark text-center">'+
								'<tr>'+
									'<th>S.No.</th>'+
									'<th>Request Id</th>'+
									'<th>Department</th>'+
									'<th>Name</th>'+
									'<th>EmpCode</th>'+
									'<th>Date</th>'+
									'<th>HOD Remark</th>'+
								'</tr>'+
							'</thead>'+
							'<tbody>';
                	$.each(response.data,function(key,value){
                    	x = x + '<tr>'+
                    				'<td>'+ parseInt(key+1) +'.</td>'+
                    				'<td>'+ value.reference_id +'</td>'+
                    				'<td>'+ value.dept_name +'</td>'+
                    				'<td>'+ value.name +'</td>'+
                    				'<td>'+ value.ecode +'</td>'+
        							'<td>'+ value.date_from +'</td>'+
        							'<td>'+ value.hod_remark +'</td>'+
                    			'</tr>';
                    });
                	x = x + '</tbody></table>';
                	$('#request_body').html(x).show();
        			$('#exampleModal').modal({
        				'show':true
        			});
                }
        	} 
		});
	});
	
});
</script>
</body>