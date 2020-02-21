  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Department Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Department</li>
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
				<span class="float-right">
					<input type="button" id="add_more" value="Add More" class="btn btn-success">
				</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  
                    <div class="table-responsive">
						<span id="msg"></span>
						<table class="table table-striped table-bordered text-center" id="example">
							<thead>
							<tr class="bg-dark">
								<th>S.No.</th>
								<th>Department</th>
								<th>Department Code</th>
								<th>Last Update On</th>
								<th>Updated By</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody id="departments">
								<?php $c=1; foreach($results as $r){ ?>
									<tr>
										<td><?php echo $c++; ?>.</td>
										<td><?php echo $r['dept_name']; ?></td>
										<td><?php echo $r['dept_code']; ?></td>
										<td><?php echo $r['updated_at']; ?></td>
										<td><?php echo $r['updated_by']; ?></td>
										<td>
											<a href="javascript:void(0);" class="dept_edit" data-dept_id="<?php echo $r['id']; ?>" data-dept_name="<?php echo $r['dept_name']; ?>" data-dept_code="<?php echo $r['dept_code']; ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
											<a href="javascript:void(0);" class="dept_delete" data-dept_id="<?php echo $r['id']; ?>"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						</div>
                  </div>
                </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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


<!---- Department Edit Modal -->
<div class="modal fade" id="dept_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_dept_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="hidden" id="dep_id" value="">
					<input type="text" class="form-control" id="edit_dept_name" name="edit_dept_name" placeholder="Department Name">
				</div>
			</div>
			<div class="form-group row">
				<label for="edit_dept_code" class="col-sm-2 col-form-label">Code</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="edit_dept_code" name="edit_dept_code" placeholder="Department Code">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="dept_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Department Edit Modal -->

<!---- Department Add Modal -->
<div class="modal fade" id="dept_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_dept_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_dept_name" name="edit_dept_name" placeholder="Department Name">
				</div>
			</div>
			<div class="form-group row">
				<label for="add_dept_code" class="col-sm-2 col-form-label">Code</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_dept_code" name="edit_dept_code" placeholder="Department Code">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="dept_add" type="button" class="btn btn-warning">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Department Add Modal -->


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	
	$('#example').DataTable();
	
	//fetch_record();
	// function fetch_record(){
		// $.ajax({
			// type: 'GET',
			// url: baseUrl+'master/department/list',
			// data: { },
			// dataType: 'json',
			// beforeSend: function() {},
			// success: function(response){
				// if(response.status == 200){
					// var x = '<div class="table-responsive"><span id="msg"></span><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								// '<th>S.No.</th>'+
								// '<th>Department</th>'+
								// '<th>Department Code</th>'+
								// '<th>Last Update On</th>'+
								// '<th>Updated By</th>'+
								// '<th>Action</th>'+
							// '</tr>';
					// $.each(response.data,function(key,value){
						// x = x +'<tr>'+
									// '<td>'+ parseInt(key+1) +'</td>'+
									// '<td>'+ value.dept_name +'</td>'+
									// '<td>'+ value.dept_code +'</td>'+
									// '<td>'+ value.updated_at +'</td>'+
									// '<td>'+ value.updated_by +'</td>'+
									// '<td>'+
										// '<a href="javascript:void(0);" class="dept_edit" data-dept_id="'+ value.id  +'" data-dept_name="'+ value.dept_name +'" data-dept_code="'+ value.dept_code +'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>'+
										// '<a href="javascript:void(0);" class="dept_delete" data-dept_id="'+ value.id +'"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>'+
									// '</td>'+
								// '</tr>';
					// });
					// x = x + '</table></div>';
					// $('#departments').html(x);
				// } else {
					// $('#departments').html('<p class="text-center">No record to show.</p>');
				// }
			// },
			// error: function (error) {
				// $('#departments').html('<p class="text-center">No record to show.</p>');
			// }
		// });	
	// }
	
///////////////////////////department edit
	$(document).on('click','.dept_edit',function(){	
		$('#dep_id').val($(this).data('dept_id'));
		$('#edit_dept_name').val($(this).data('dept_name'));
		$('#edit_dept_code').val($(this).data('dept_code'));
		
		$('#dept_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#dept_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/department/update',
			data: { 
				'dept_id' : $('#dep_id').val(),
				'name' : $('#edit_dept_name').val(),
				'code' : $('#edit_dept_code').val(),
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					location.reload();	
				} else {
					alert(response.msg);
				}
			}
		});
	});
	
	
///////////////////////////department add	
	$(document).on('click','#add_more',function(){	
		$('#dept_add_name').val('');
		$('#dept_add_code').val('');
		
		$('#dept_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#dept_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/department/create',
			data: { 
				'name' : $('#add_dept_name').val(),
				'code' : $('#add_dept_code').val(),
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					location.reload();	
				} else {
					alert(response.msg);
				}
			}
		});
	});
	
///////////////////////////department delete	
	$(document).on('click','.dept_delete',function(){	
		var c = confirm("Are you sure? to Delete the department.");
		var dep_id = $(this).data('dept_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/department/delete',
				data: { 
					'dept_id' : dep_id
				},
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						location.reload();	
					} else {
						alert(response.msg);
					}
				}
			});
		}
	});
	
});
</script>
</body>