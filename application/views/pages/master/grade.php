   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Grade Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Grade</li>
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
                  <div class="form-group" id="grade">
                    <div class="table-responsive">
						<span id="msg"></span>
						<table class="table table-striped table-bordered text-center" id="example">
							<thead>
							<tr class="bg-dark">
								<th>S.No.</th>
								<th>Grade</th>
								<th>Last Update On</th>
								<th>Updated By</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $c = 1; foreach($results as $r){ ?>
									<tr>
										<td><?php echo $c++; ?></td>
										<td><?php echo $r['grade_name']; ?></td>
										<td><?php echo $r['updated_at']; ?></td>
										<td><?php echo $r['updated_by']; ?></td>
										<td>
											<a href="javascript:void(0);" class="grade_edit" data-grade_id="<?php echo $r['id']; ?>" data-grade_name="<?php echo $r['grade_name']; ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
											<a href="javascript:void(0);" class="grade_delete" data-grade_id="<?php echo $r['id']; ?>"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>
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


<!---- Grade Edit Modal -->
<div class="modal fade" id="grade_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_grade_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="hidden" id="grade_id" value="">
					<input type="text" class="form-control" id="edit_grade_name" name="edit_grade_name" placeholder="Grade Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="grade_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Grade Edit Modal -->

<!---- Grade Add Modal -->
<div class="modal fade" id="grade_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_grade_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_grade_name" name="edit_grade_name" placeholder="Grade Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="grade_add" type="button" class="btn btn-warning">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Grade Add Modal -->


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	$('#example').DataTable();
	// fetch_record();
	// function fetch_record(){
		// $.ajax({
			// type: 'GET',
			// url: baseUrl+'master/grade/list',
			// data: { },
			// dataType: 'json',
			// beforeSend: function() {},
			// success: function(response){
				// if(response.status == 200){
					// var x = '<div class="table-responsive"><span id="msg"></span><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								// '<th>S.No.</th>'+
								// '<th>Grade</th>'+
								// '<th>Last Update On</th>'+
								// '<th>Updated By</th>'+
								// '<th>Action</th>'+
							// '</tr>';
					// $.each(response.data,function(key,value){
						// x = x +'<tr>'+
									// '<td>'+ parseInt(key+1) +'</td>'+
									// '<td>'+ value.grade_name +'</td>'+
									// '<td>'+ value.updated_at +'</td>'+
									// '<td>'+ value.updated_by +'</td>'+
									// '<td>'+
										// '<a href="javascript:void(0);" class="grade_edit" data-grade_id="'+ value.id  +'" data-grade_name="'+ value.grade_name +'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>'+
										// '<a href="javascript:void(0);" class="grade_delete" data-grade_id="'+ value.id +'"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>'+
									// '</td>'+
								// '</tr>';
					// });
					// x = x + '</table></div>';
					// $('#grade').html(x);
				// } else {
					// $('#grade').html('<p class="text-center">No record to show.</p>');
				// }
			// },
			// error: function (error) {
				// $('#grade').html('<p class="text-center">No record to show.</p>');
			// }
		// });	
	// }
	
///////////////////////////Grade edit
	$(document).on('click','.grade_edit',function(){	
		$('#grade_id').val($(this).data('grade_id'));
		$('#edit_grade_name').val($(this).data('grade_name'));
		
		$('#grade_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#grade_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/grade/update',
			data: { 
				'grade_id' : $('#grade_id').val(),
				'name' : $('#edit_grade_name').val(),
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
		$('#grade_add_name').val('');
		$('#grade_add_code').val('');
		
		$('#grade_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#grade_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/grade/create',
			data: { 
				'name' : $('#add_grade_name').val(),
				'code' : $('#add_grade_code').val(),
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
	$(document).on('click','.grade_delete',function(){	
		var c = confirm("Are you sure? to Delete the Grade.");
		var grade_id = $(this).data('grade_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/grade/delete',
				data: { 
					'grade_id' : grade_id
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