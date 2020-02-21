   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Location Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Location Master</li>
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
                  <div class="form-group" id="location">
                    
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
<div class="modal fade" id="location_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_grade_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="hidden" id="location_id" value="">
					<input type="text" class="form-control" id="edit_location_name" name="edit_location_name" placeholder="Location Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="location_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Grade Edit Modal -->

<!---- Grade Add Modal -->
<div class="modal fade" id="location_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_location_name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_location_name" name="add_location_name" placeholder="Location Name">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="location_add" type="button" class="btn btn-warning">Save</button>
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
			url: baseUrl+'master/location/list',
			data: { },
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					var x = '<div class="table-responsive"><span id="msg"></span><table class="table table-striped table-bordered text-center"><tr class="bg-dark">'+
								'<th>S.No.</th>'+
								'<th>Location</th>'+
								'<th>Last Update On</th>'+
								'<th>Updated By</th>'+
								'<th>Action</th>'+
							'</tr>';
					$.each(response.data,function(key,value){
						x = x +'<tr>'+
									'<td>'+ parseInt(key+1) +'</td>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+ value.updated_at +'</td>'+
									'<td>'+ value.updated_by +'</td>'+
									'<td>'+
										'<a href="javascript:void(0);" class="location_edit" data-location_id="'+ value.id  +'" data-location_name="'+ value.name +'"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>'+
										'<a href="javascript:void(0);" class="location_delete" data-location_id="'+ value.id +'"><i class="fas fa-trash-alt ml-2" aria-hidden="true"></i></a>'+
									'</td>'+
								'</tr>';
					});
					x = x + '</table></div>';
					$('#location').html(x);
				} else {
					$('#location').html('<p class="text-center">No record to show.</p>');
				}
			},
			error: function (error) {
				$('#location').html('<p class="text-center">No record to show.</p>');
			}
		});	
	}
	
///////////////////////////Location edit
	$(document).on('click','.location_edit',function(){	
		$('#location_id').val($(this).data('location_id'));
		$('#edit_location_name').val($(this).data('location_name'));
		
		$('#location_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#location_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/location/update',
			data: { 
				'location_id' : $('#location_id').val(),
				'name' : $('#edit_location_name').val(),
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
	
	
///////////////////////////Location add	
	$(document).on('click','#add_more',function(){	
		$('#location_add_name').val('');
		$('#location_add_code').val('');
		
		$('#location_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#location_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/location/create',
			data: { 
				'name' : $('#add_location_name').val()
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
	
///////////////////////////Location delete	
	$(document).on('click','.location_delete',function(){	
		var c = confirm("Are you sure? to Delete the Location.");
		var location_id = $(this).data('location_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/location/delete',
				data: { 
					'location_id' : location_id
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