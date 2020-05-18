<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">POLICIES</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>">Home</a></li>
						<li class="breadcrumb-item active">HR MANAGEMENT</li>
						<li class="breadcrumb-item active">POLICIES</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
			 <?php echo $this->session->flashdata('msg'); ?>
			 <div class="col-md-12" id="add_update">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<h3 class="card-title">ADD/UPDATE POLICIES</h3>
				  </div>
				  <div class="card-body">
					<form name="f1" method="POST" enctype="multipart/form-data" action="<?php echo base_url('hr/Policies');?>">
					  <div class="form-group row">
						<input type="hidden" name="policy_id" id="policy_id">
						<label for="staticEmail" class="col-sm-2 col-form-label">DEPARTMENT</label>
						<div class="col-sm-10">
						  <select class="form-control" name="department" id="department">
							<option value="1">HR POLICIES</option>
							<option value="2">IT POLICIES</option>
						  </select>
						  <?php echo form_error('department'); ?>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">Title</label>
						<div class="col-sm-10">
						  <input type="text" name="title" id="title" class="form-control" placeholder="File Title">
						  <?php echo form_error('title'); ?>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">Sort</label>
						<div class="col-sm-10">
						  <input type="number" name="order" id="order" class="form-control">
						  <?php echo form_error('order'); ?>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">File</label>
						<div class="col-sm-10">
						  <input type="file" name="userfile" id="userfile" class="form-control" accept="application/pdf" >
						  <?php echo form_error('userfile'); ?>
						</div>
					  </div>
					  <div class="form-group row">
						<div class="col-sm-10 offset-2">
						  <input type="submit" name="button" value="submit" id="submit" class="btn btn-success">
						  <input type="submit" name="button" value="update" id="update" class="btn btn-warning" style="display:none;">
						  <input type="button" value="Reset" class="btn btn-default" onclick="location.reload();" />
						</div>
					  </div>
					</form>	
					
				  </div>
				</div>
			 </div>
			 
			  <div class="col-md-12">
				<div class="card card-info">
				  <div class="card-header" style="border-radius:0px;">
					<span class="card-title">POLICIES</span>
					<span class="float-right">
						<a href="javascript:void(0);" id="add_more">+ Add More<a/></span>
				  </div>
				  <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="example">
							<thead>	
								<tr class="bg-dark">
									<th>S.No.</th>
									<th>DEPARTMENT</th>
									<th>TITLE</th>
									<th>SORT</th>
									<th>DOWNLOAD</th>
									<th>UPLOADED BY</th>
									<th>CREATED AT</th>
									<th>OPERATIONS</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($policies)>0){
									$c = 1;
									foreach($policies as $policy){ ?>
										<tr>
											<td><?php echo $c; ?>.</td>
											<td><?php echo $policy['parent']; ?></td>
											<td><?php echo $policy['child']; ?></td>
											<td><?php echo $policy['sort']; ?></td>
											<td><a href="<?php echo base_url()?>policies/<?php echo $policy['file_name']; ?>">Download</a></td>
											<td><?php echo $policy['created_by']; ?></td>
											<td><?php echo $policy['created_at']; ?></td>
											<td>
												<a class="edit" data-id="<?php echo $policy['id']; ?>" href="javascript:void(0);">Edit</a>
												<a class="delete" data-id="<?php echo $policy['id']; ?>" href="javascript:void(0);">Delete</a>
											</td>
										</tr>
								<?php $c++; }
								}?>
							</tbody>
						</table>
					</div>
				  </div>
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

$(document).ready(function(){
	$('#example').DataTable();	
	
	$(document).on('click','.edit',function(){
		$('#department').focus();
		var id = $(this).data('id');
		$('#policy_id').val(id);
		$('#submit').hide();
		$('#update').show();
		$.ajax({
			type: 'POST',
			url: baseUrl+'/Hr_ctrl/policy_detail',
			data: {
				'id' : id
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					$('#department').val(parseInt(response.data[0]['parent_id']));
					$('#title').val(response.data[0]['title']);
					$('#order').val(response.data[0]['sort']);
				}
			}
		});	
	});
	
	$(document).on('click','.delete',function(){
		var id = $(this).data('id');
		var c = confirm('Are you sure.');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'/Hr_ctrl/policy_delete',
				data: {
					'id' : id
				},
				dataType: 'json',
				beforeSend: function() {},
				success: function(response){
					if(response.status == 200){
						location.reload();
					}
				}
			});
		}
	});
});
</script>
</body>