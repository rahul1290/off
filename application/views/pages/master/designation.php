   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Designation Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Designation</li>
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
                  <div class="form-group" id="designation">
                    <div class="table-responsive">
						<span id="msg"></span>
						<table class="table table-striped table-bordered text-center" id="example">
							<thead>
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>Designation</th>
									<th>Last Update On</th>
									<th>Updated By</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $c= 0; foreach($results as $r){ ?>
									<tr>
										<td><?php echo $c++; ?></td>
										<td><?php echo $r['desg_name']; ?></td>
										<td><?php echo $r['updated_at']; ?></td>
										<td><?php echo $r['updated_by']; ?></td>
										<td>
											<a href="javascript:void(0);" class="desg_edit" data-desg_id="<?php echo $r['id']; ?>" data-desg_name="<?php echo $r['desg_name']; ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
											<a href="javascript:void(0);" class="desg_delete" data-desg_id="<?php echo $r['id']; ?>"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                  </div>
                </form>
              </div>
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


<!---- Designation Edit Modal -->
<div class="modal fade" id="desg_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Designation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_desg_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="hidden" id="desg_id" value="">
					<input type="text" class="form-control" id="edit_desg_name" name="edit_desg_name" placeholder="Designation Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="desg_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Designation Edit Modal -->

<!---- Designation Add Modal -->
<div class="modal fade" id="desg_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Designation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_desg_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_desg_name" name="edit_desg_name" placeholder="Designation Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="desg_add" type="button" class="btn btn-warning">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Designation Add Modal -->


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	
	$('#example').DataTable();
	
	// fetch_record();
	// function fetch_record(){
		// $.ajax({
			// type: 'GET',
			// url: baseUrl+'master/designation/list',
			// data: { },
			// dataType: 'json',
			// beforeSend: function() {},
			// success: function(response){
				// if(response.status == 200){
					// var x = '<div class="table-responsive"><span id="msg"></span><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								// '<th>S.No.</th>'+
								// '<th>Designation</th>'+
								// '<th>Last Update On</th>'+
								// '<th>Updated By</th>'+
								// '<th>Action</th>'+
							// '</tr>';
					// $.each(response.data,function(key,value){
						// x = x +'<tr>'+
									// '<td>'+ parseInt(key+1) +'</td>'+
									// '<td>'+ value.desg_name +'</td>'+
									// '<td>'+ value.updated_at +'</td>'+
									// '<td>'+ value.updated_by +'</td>'+
									// '<td>'+
										// '<a href="javascript:void(0);" class="desg_edit" data-desg_id="'+ value.id  +'" data-desg_name="'+ value.desg_name +'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>'+
										// '<a href="javascript:void(0);" class="desg_delete" data-desg_id="'+ value.id +'"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>'+
									// '</td>'+
								// '</tr>';
					// });
					// x = x + '</table></div>';
					// $('#designation').html(x);
				// } else {
					// $('#designation').html('<p class="text-center">No record to show.</p>');
				// }
			// },
			// error: function (error) {
				// $('#designation').html('<p class="text-center">No record to show.</p>');
			// }
		// });	
	// }
	
///////////////////////////Designation edit
	$(document).on('click','.desg_edit',function(){	
		$('#desg_id').val($(this).data('desg_id'));
		$('#edit_desg_name').val($(this).data('desg_name'));
		
		$('#desg_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#desg_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/designation/update',
			data: { 
				'desg_id' : $('#desg_id').val(),
				'name' : $('#edit_desg_name').val(),
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
	
	
///////////////////////////Designation add	
	$(document).on('click','#add_more',function(){	
		$('#desg_add_name').val('');
		$('#desg_add_code').val('');
		
		$('#desg_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#desg_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/designation/create',
			data: { 
				'name' : $('#add_desg_name').val(),
				'code' : $('#add_desg_code').val(),
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
	
///////////////////////////Designation delete	
	$(document).on('click','.desg_delete',function(){	
		var c = confirm("Are you sure? to Delete the designation.");
		var desg_id = $(this).data('desg_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/designation/delete',
				data: { 
					'desg_id' : desg_id
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