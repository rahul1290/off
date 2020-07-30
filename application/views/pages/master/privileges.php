<?php 
$userdept = array();
foreach($user_departments as $user_department){
	array_push($userdept,$user_department['id']);
}

$supervised_emp = array();
foreach($supervised as $supervise){
	array_push($supervised_emp,$supervise['r_ecode']);
}

$ulink = array();
foreach($user_links as $user_link){
	array_push($ulink,$user_link['link_id']);
}

?>
<div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">User Privileges</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">User Privileges</li>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				<form name="f1" id="f1" method="POST" action="<?php echo base_url('master/employee/privileges/').$this->uri->segment(4);?>">
				<table class="table table-bordered">
					
					<?php if(isset($ulink)){if(count($ulink)){ ?>
					    <tr>
							<td>Default Permission</td>
    						<td>
    							<input type="checkbox" id="default_permission" data-uid="<?php echo $user_detail[0]['ecode']; ?>" checked disabled/>
    							<a href="javasript:void(0);" id="reset_privileges" data-uid="<?php echo $user_detail[0]['ecode']; ?>">Reset Privileges</a>
    						</td>
    					</tr>
					<?php } else { ?>
					    <tr>
					    	<td>Default Permission</td>
					    	<td>
					    		<input type="checkbox" id="default_permission" data-uid="<?php echo $user_detail[0]['ecode']; ?>"/>
					    	</td>
					    </tr>
					<?php }} ?> 
					    
					
					
					<tr>
						<td>Name</td>
						<td><?php echo $user_detail[0]['name']; ?></td>
					</tr>
					<tr>
						<td>Department</td>
						<td>
							<select name="departments[]" id="departments" class="select2bs4 form-control" multiple onchange="f1.submit();">
								<?php foreach($departments as $department){ ?>
									<option value="<?php echo $department['id'];?>" <?php if(in_array($department['id'],$userdept)){ echo "selected"; }?>><?php echo $department['dept_name']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Users</td>
						<td>
							<ul style="list-style-type: none;max-height: 500px;OVERFLOW: scroll;">
							<?php 
							foreach($ulists as $key => $value){ 
								echo "<li><input type='checkbox'>".$key.'<ul style="list-style-type: none;">';
								foreach($value as $v) {
									if(in_array($v['ecode'],$supervised_emp)){
										echo "<li><input type='checkbox' name='ulist[]' value='".$v['ecode']."' checked onclick='f1.submit();'>".$v['name']."</li>";
									} else {
										echo "<li><input type='checkbox' name='ulist[]' value='".$v['ecode']."' onclick='f1.submit();'>".$v['name']."</li>";
									}
								}
								echo "</ul>";
							}
							?>
							</ul>
						</td>
					</tr>
					<tr>
						<td>Links</td>
						<td>
							<ul style="list-style-type: none;max-height: 500px;OVERFLOW: scroll;">
								<?php 
								foreach($links as $l){
									$p = 1;
									if($l['parent_id'] == 0){
										if(in_array($l['id'],$ulink)){
											echo '<li><input name="ulink[]" value="'.$l['id'].'" type="checkbox" checked onclick="f1.submit();">'.$l['link_name'];
										} else {
											echo '<li><input name="ulink[]" value="'.$l['id'].'" type="checkbox" onclick="f1.submit();">'.$l['link_name'];
										}
										$c = 0;
										foreach($links as $l1){
											$p = 0;
											if($l['id'] == $l1['parent_id']){
												if($c == 0){ 
													echo '<ul style="list-style-type: none;">';
												}
												$c = $c + 1;
												if(in_array($l1['id'],$ulink)){ 
													echo '<li><input name="ulink[]" value="'.$l1['id'].'" type="checkbox" checked onclick="f1.submit();">'.$l1['link_name'].'</li>';
												} else {
													echo '<li><input name="ulink[]" value="'.$l1['id'].'" type="checkbox" onclick="f1.submit();">'.$l1['link_name'].'</li>';
												}
											}
										}
										if($c){
											echo '</ul></li>';
										}
									} else {
										continue;
									}
								} ?>
							</ul>
						</td>
					</tr>
				</table>
				<input type="submit" value="Submit">
				</form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
		
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
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
</body>

<script>
var baseUrl = $('#baseUrl').val();
//Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
	


$(document).ready(function(){
// 	$(document).on('change','#departments',function(){
// 		var dept_id = $(this).val();
// 		$.ajax({
// 			type: 'POST',
// 			url: baseUrl+'master/Employee_ctrl/department_wise_users/',
// 			data: { 
// 				'dept_id' : dept_id
// 			},
// 			dataType: 'json',
// 			beforeSend: function() {},
// 			success: function(response){
// 				console.log(response);
// 			}
// 		});
// 	});
	
// 	$(document).on('click','.ulist',function(){
// 		$uid = $(this).data('uid');
// 		$.ajax({
// 			type: 'POST',
// 			url: baseUrl+'master/pu/',
// 			data: { 
// 				'dept_id' : dept_id
// 			},
// 			dataType: 'json',
// 			beforeSend: function() {},
// 			success: function(response){
// 				console.log(response);
// 			}
// 		});
// 	});


	$(document).on('click','#default_permission',function(){
		if($(this).prop("checked") == true){
			var ecode = $(this).data('uid');
			$.ajax({
				type:'GET',
				url: baseUrl + 'master/Employee_ctrl/default_permission_grant/'+ecode,
				dataType : 'json',
				success : function(response){
					if(response.status == 200){
						location.reload();
					} else {
						alert(response.msg);
					}
				}
			});
		}
	});

	$(document).on('click','#reset_privileges',function(){
		var ecode = $(this).data('uid');
		$.ajax({
			type:'GET',
			url: baseUrl + 'master/Employee_ctrl/default_permission_revoke/'+ecode,
			dataType : 'json',
			success : function(response){
				if(response.status == 200){
					location.reload();
				} else {
					alert(response.msg);
				}
			}
		});
	});
});
</script>