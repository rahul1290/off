  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">BROADCAST OUTPUT</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">BROADCAST OUTPUT</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <!--<div class="content">-->
      <div class="container-fluid">
		<div class="offset-md-1 col-md-10 mb-3">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">BROADCAST OUTPUT</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>DATE</td>
							<td>
								<input type="text" name="date" id="date" class="form-control datepicker" value="<?php echo date('d/m/Y'); ?>" />
							</td>
						</tr>
						<tr>
							<td>Time </td>
							<td>
								<select class="form-control" name="" id="sloat">
									<option value="0">Choose Time Slot</option>
									<option value="1">00:00 - 00:30</option>
									<option value="2">00:30 - 01:00</option>
									<option value="3">01:00 - 01:30</option>
									<option value="4">01:30 - 02:00</option>
									<option value="5">02:00 - 02:30</option>
									<option value="6">02:30 - 03:00</option>
									<option value="7">03:00 - 03:30</option>
									<option value="8">03:30 - 04:00</option>
									<option value="9">04:00 - 04:30</option>
									<option value="10">04:30 - 05:00</option>
									<option value="11">05:00 - 05:30</option>
									<option value="12">05:30 - 06:00</option>
									<option value="13">06:00 - 06:30</option>
									<option value="14">06:30 - 07:00</option>
									<option value="15">07:00 - 07:30</option>
									<option value="16">07:30 - 08:00</option>
									<option value="17">08:00 - 08:30</option>
									<option value="18">08:30 - 09:00</option>
									<option value="19">09:00 - 09:30</option>
									<option value="20">09:30 - 10:00</option>
									<option value="21">10:00 - 10:30</option>
									<option value="22">10:30 - 11:00</option>
									<option value="23">11:00 - 11:30</option>
									<option value="24">11:30 - 12:00</option>
									<option value="25">12:00 - 12:30</option>
									<option value="26">12:30 - 13:00</option>
									<option value="27">13:00 - 13:30</option>
									<option value="28">13:30 - 14:00</option>
									<option value="29">14:00 - 14:30</option>
									<option value="30">14:30 - 15:00</option>
									<option value="31">15:00 - 15:30</option>
									<option value="32">15:30 - 16:00</option>
									<option value="33">16:00 - 16:30</option>
									<option value="34">16:30 - 17:00</option>
									<option value="35">17:00 - 17:30</option>
									<option value="36">17:30 - 18:00</option>
									<option value="37">18:00 - 18:30</option>
									<option value="38">18:30 - 19:00</option>
									<option value="39">19:00 - 19:30</option>
									<option value="40">19:30 - 20:00</option>
									<option value="41">20:00 - 20:30</option>
									<option value="42">20:30 - 21:00</option>
									<option value="43">21:00 - 21:30</option>
									<option value="44">21:30 - 22:00</option>
									<option value="45">22:00 - 22:30</option>
									<option value="46">22:30 - 23:00</option>
									<option value="47">23:00 - 23:30</option>
									<option value="48">23:30 - 24:00</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
              </div>
            </div>
				<div class="text-center">
					<input type="button" id="search" value="Preview" class="btn btn-warning">
					<input type="button" value="Cancel" class="btn btn-secondary">
				</div>
          </div>
		  <hr/>
		  
		  <div class="offset-md-1 col-md-10">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">BROADCAST PREVIEW</h3>
              </div>
              <div class="card-body text-center">
				
				<video id="broadcast_preview" class="col-md-12" autoplay
					src="" 
					poster="" 
					height="100%" controls="" style="background-color:#000000;">
				</video>
				
				<a id="broadcast_download" class="btn btn-lg btn-primary" href="#">Download</a>
              </div>
            </div>
          </div>
		  
		  
		
      </div><!-- /.container-fluid -->
    <!--</div>-->
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
	
	$(document).on('click','#search',function(){
		$.ajax({
			type: 'POST',
			url: baseUrl+'output/Output_ctrl/get_files',
			data: { 
				'date' : $('#date').val(),
				'sloat' : $('#sloat').val()
			},
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				if(response.status == 200){
					console.log(response);
					$('#broadcast_preview').attr('src','http://192.168.25.231/recordnew/mp4/'+response.data[0].file_name);
					$('#broadcast_download').attr('href','http://192.168.25.231/recordnew/mp4/'+response.data[0].file_name);
				} else {
					$('#broadcast_preview').attr('src','http://192.168.25.231/recordnew/mp4/');
					$('#broadcast_download').attr('href','http://192.168.25.231/recordnew/mp4/');
				}
			}
		});
	});
	
});
</script>
</body>