   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Empcode Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">EmpCode</li>
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
                  <div class="form-group" id="empcode">
                    
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
<div class="modal fade" id="empcode_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit EmpCode</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_grade_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="hidden" id="empcode_id" value="">
					<input type="text" class="form-control" id="edit_empcode_name" name="edit_empcode_name" placeholder="EmpCode Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="empcode_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Grade Edit Modal -->

<!---- Grade Add Modal -->
<div class="modal fade" id="empcode_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Empcode</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_empcode_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_empcode_name" name="add_empcode_name" placeholder="EmpCode Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="empcode_add" type="button" class="btn btn-warning">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Grade Add Modal -->


<script>
var baseUrl = $('#baseUrl').val();

$(document).ready(function(){
	
	fetch_record();
	function fetch_record(){
		$.ajax({
			type: 'GET',
			url: baseUrl+'master/empcode/list',
			data: { },
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					var x = '<div class="table-responsive"><span id="msg"></span><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								'<th>S.No.</th>'+
								'<th>Code</th>'+
								'<th>Last Update On</th>'+
								'<th>Updated By</th>'+
								'<th>Action</th>'+
							'</tr>';
					$.each(response.data,function(key,value){
						x = x +'<tr>'+
									'<td>'+ parseInt(key+1) +'</td>'+
									'<td>'+ value.ecode_name +'</td>'+
									'<td>'+ value.updated_at +'</td>'+
									'<td>'+ value.updated_by +'</td>'+
									'<td>'+
										'<a href="javascript:void(0);" class="empcode_edit" data-empcode_id="'+ value.id  +'" data-empcode_name="'+ value.ecode_name +'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>'+
										'<a href="javascript:void(0);" class="empcode_delete" data-empcode_id="'+ value.id +'"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>'+
									'</td>'+
								'</tr>';
					});
					x = x + '</table></div>';
					$('#empcode').html(x);
				} else {
					$('#empcode').html('<p class="text-center">No record to show.</p>');
				}
			},
			error: function (error) {
				$('#empcode').html('<p class="text-center">No record to show.</p>');
			}
		});	
	}
	
///////////////////////////EmpCode edit
	$(document).on('click','.empcode_edit',function(){	
		$('#empcode_id').val($(this).data('empcode_id'));
		$('#edit_empcode_name').val($(this).data('empcode_name'));
		
		$('#empcode_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#empcode_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/empcode/update',
			data: { 
				'empcode_id' : $('#empcode_id').val(),
				'name' : $('#edit_empcode_name').val(),
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
	
	
///////////////////////////EmpCode add	
	$(document).on('click','#add_more',function(){	
		$('#empcode_add_name').val('');
		$('#empcode_add_code').val('');
		
		$('#empcode_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#empcode_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/empcode/create',
			data: { 
				'name' : $('#add_empcode_name').val(),
				'code' : $('#add_empcode_code').val(),
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
	
///////////////////////////EmpCode delete	
	$(document).on('click','.empcode_delete',function(){	
		var c = confirm("Are you sure? to Delete the Code.");
		var empcode_id = $(this).data('empcode_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/empcode/delete',
				data: { 
					'empcode_id' : empcode_id
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