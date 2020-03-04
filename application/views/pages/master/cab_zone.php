   <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">CAB ZONE MASTER</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Shift</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<div class="row">
		<div class="col-md-6"> 
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="">
					SHIFT MASTER
				</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
				  <div class="form-group row">
					<label for="location" class="col-sm-2 col-form-label">Location Name</label>
					<div class="col-sm-10">
					  <input type="hidden" name="location_id" id="location_id" placeholder="Location ID">
					  <input type="text" name="" class="form-control" name="location" id="location" />
					</div>
				  </div>

				 <div class="form-group row">
					<label for="parent" class="col-sm-2 col-form-label">Parent</label>
					<div class="col-sm-10">
					  <select name="parent" class="form-control" id="parent">
							<option value="0">Parent Location</option>
							<?php foreach($zones as $zone){ ?>
								<option value="<?php echo $zone['id']; ?>"><?php echo $zone['location_name']; ?></option>
							<?php } ?>
					  </select>
					</div>
				  </div> 

				  <div class="text-center">
					<input id="submit" type="button" value="Submit" class="btn btn-success" style="display:inline;">
					<input id="update" type="button" value="Update" class="btn btn-warning" style="display:none;">
					<input id="refresh" type="button" value="Refresh" class="btn btn-secondary">
				  </div>
                </form>
              </div>
            </div>
		</div>



		<div class="col-md-6">
			<div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="">
					All ZONE LOCATIONS
				</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
						<ul>
						<?php foreach($locations as $location){ 
								if($location['parent_id'] == '0'){
									echo "<li>".$location['location_name']." <a data-lid='".$location['id']."' data-lname='".$location['location_name']."' data-pid='".$location['parent_id']."' class='location_edit' href='javascript:void(0);'><i title='Edit' class='fas fa-pencil-alt'></i></a> <a data-lid='".$location['id']."' class='location_delete' href='javascript:void(0);'><i title='Delete' class='fas fa-trash-alt'></i></a><ul>";
									foreach($locations as $l){
										if($l['parent_id'] == $location['id']){
											echo "<li>". $l['location_name'] ." <a data-lid='".$l['id']."' data-lname='".$l['location_name']."' data-pid='".$l['parent_id']."' class='location_edit' href='javascript:void(0);'><i title='Edit' class='fas fa-pencil-alt'></i></a> <a data-lid='".$l['id']."' class='location_delete' href='javascript:void(0);'><i title='Delete' class='fas fa-trash-alt'></i></a></li>";
										}
									}
								echo "</ul></li>";
								}
						} ?>
						</ul>
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

	$(document).on('click','.location_edit',function(){
		$('#location_id').val($(this).data('lid'));
		$('#location').val($(this).data('lname'));
		$('#parent').val($(this).data('pid'));
		$('#submit').hide();
		$('#update').show();
	});

	$(document).on('click','#refresh',function(){
		location.reload();
	});

	$(document).on('click','#submit',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/Cab_ctrl/location_submit',
			data: { 
				'location' : $('#location').val(),
				'parent' : $('#parent').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					location.reload();
				}
			}
		});
	});

	$(document).on('click','#update',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'master/Cab_ctrl/location_update',
			data: { 
				'id' : $('#location_id').val(),
				'location' : $('#location').val(),
				'parent' : $('#parent').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					location.reload();
				}
			}
		});
	});

	$(document).on('click','.location_delete',function(){
		var lid = $(this).data('lid');
		var c = confirm('Are you sure.');
		if(c){
			$.ajax({
				type: 'POST',
				url: baseUrl+'master/Cab_ctrl/location_delete',
				data: { 
					'id' : lid
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