  
	  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">NH/FH Master</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Master</li>
						<li class="breadcrumb-item active">NH/FH master</li>
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
                  <div class="form-group" id="nhfh">
						<?php if(count($nhfhs)>0){
							echo '<table class="table table-striped" id="example">'.
									'<thead>'.
										'<tr class="bg-dark">'.
											'<th>S.No.</th>'.
											'<th>Year</th>'.
											'<th>date</th>'.
											'<th>Remark</th>'.
											'<th>Last Update On</th>'.
											'<th>Updated By</th>'.
											'<th>Action</th>'.
										'</tr>'.
									'</thead><tbody>';
							$c = 1; foreach($nhfhs as $nhfh){ ?>
								<tr>
									<td><?php echo $c++; ?></td>
									<td><?php echo $nhfh['year']; ?></td>
									<td><?php echo $nhfh['nhfh_date']; ?></td>
									<td><?php echo $nhfh['remark']; ?></td>
									<td><?php echo $nhfh['updated_at']; ?></td>
									<td><?php echo $nhfh['updated_by']; ?></td>
									<td>
										<a href="javascript:void(0);" title="NH/FH Edit" class="nhfh_edit" 
													data-nhfh_id="<?php echo $nhfh['id']; ?>" 
													data-nhfh_year="<?php echo $nhfh['year']; ?>"
													data-nhfh_date="<?php echo $nhfh['nhfh_date']; ?>" 
													data-nhfh_remark="<?php echo $nhfh['remark']; ?>" 
													><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
										<a href="javascript:void(0);" title="NH/FH Delte" class="nhfh_delete" data-nhfh_id="<?php echo $nhfh['id']; ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></a> 
									</td>
								</tr>
					  <?php }
						echo '</tbody></table>';
						}?>
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


<!---- NH/FH Edit Modal -->
<div class="modal fade" id="nhfh_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit NH/FH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="edit_nhfh_date" class="col-sm-2 col-form-label">Date</label>
				<div class="col-sm-10">
					<input type="hidden" id="nhfh_id" value="">
					<input type="text" id="nhfh_date" class="form-control datepicker" value="">
				</div>
			</div>
			<div class="form-group row">
				<label for="edit_dept_code" class="col-sm-2 col-form-label">Remark</label>
				<div class="col-sm-10">
					<input text="text" id="nhfh_remark" class="form-control" value="" placeholder="Remark">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="nhfh_update" type="button" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---- Department Edit Modal -->

<!---- Department Add Modal -->
<div class="modal fade" id="nhfh_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add NH/FH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="add_dept_name" class="col-sm-2 col-form-label">Date</label>
				<div class="col-sm-10">
					<input type="text" id="add_nhfh_date" name="add_nhfh_date" class="form-control datepicker" value="<?php echo date('d/m/Y');?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="add_dept_code" class="col-sm-2 col-form-label">Remark</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add_nhfh_remark" name="add_nhfh_remark" placeholder="NH/FH Remark">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button id="nhfh_add" type="button" class="btn btn-warning">Save</button>
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
	
///////////////////////////department edit
	$(document).on('click','.nhfh_edit',function(){	
		$('#nhfh_id').val($(this).data('nhfh_id'));
		$('#nhfh_date').val($(this).data('nhfh_date'));
		$('#nhfh_remark').val($(this).data('nhfh_remark'));
		
		$('#nhfh_edit_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#nhfh_update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/nhfh/update',
			data: { 
				'id' : $('#nhfh_id').val(),
				'date' : $('#nhfh_date').val(),
				'remark' : $('#nhfh_remark').val(),
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
		
		$('#nhfh_add_modal').modal({
			keyboard: false,
			backdrop: 'static'
		})
	});
	
	$(document).on('click','#nhfh_add',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/nhfh/create',
			data: { 
				'nhfh_date' : $('#add_nhfh_date').val(),
				'remark' : $('#add_nhfh_remark').val(),
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
	$(document).on('click','.nhfh_delete',function(){	
		var c = confirm("Are you sure? to Delete the NH/FH.");
		var nhfh_id = $(this).data('nhfh_id');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/nhfh/delete',
				data: { 
					'nhfh_id' : nhfh_id
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