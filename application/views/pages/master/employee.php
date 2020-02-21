 <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Master</h1>
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
			<p class="bg-success"><?php echo $this->session->flashdata('msg');?></p>
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <span class="card-title"></span>
				<span class="float-right">
					<a class="btn btn-success" href="<?php echo base_url('master/employee/create');?>">Add Employee</a>
				</span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  <div class="form-group">
                    <table class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Employee Code</th>
								<th>Employee Name</th>
								<th>Gender</th>
								<th>Department</th>
								<th>Designation</th>
								<th>Grade</th>
								<th>Join Date</th>
								<th>View</th>
							</tr>
						</thead>
						<tbody>
							<?php $c=1; foreach($employees as $employee){ ?>
									<tr>
										<td><?php echo $c;?>.</td>
										<td><?php echo $employee['ecode']; ?></td>
										<td><?php echo ucfirst($employee['name']); ?></td>
										<td><?php echo $employee['gender']; ?></td>
										<td><?php echo $employee['dept_name']; ?></td>
										<td><?php echo $employee['desg_name']; ?></td>
										<td><?php echo $employee['grade_name']; ?></td>
										<td><?php echo $employee['jdate']; ?></td>
										<th><a title="View Employee" class="employee_view" data-emp_code="<?php echo $employee['ecode']; ?>" href="javascript:void(0);"><i class="fa fa-eye"></i></a>
											<a title="Edit Employee" href="javascript:void(0);"<i class="fas fa-pencil-alt"></i></a>
										</th>
									</tr>
							<?php $c++; } ?>
						</tbody>
					</table>
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
  

<!-- Modal -->
<!--div class="modal fade bd-example-modal-lg" id="employee_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"-->
<div class="modal fade bd-example-modal-lg" id="employee_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Employee Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="employee_view"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  
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
	
	$(document).on('click','.employee_view',function(){
		var ecode = $(this).data('emp_code');
		$.ajax({
			type: 'GET',
			url: baseUrl+'master/employee/' + ecode,
			data: { },
			dataType: 'json',
			beforeSend: function() {},
			success: function(response){
				console.log(response);
				if(response.status == 200){
					var x = '';
						x = x + '<div>'+
									'<div class="row">'+
										'<div class="col-sm-3">'+
											'<div class="col-sm-12"><img width="100%" height="250px;" src="https://employee.ibc24.in/OLAppraisal/EmpImage/'+ response.data[0].ecode +'.jpg" style="padding:1px;"></div>'+
											'<div class="col-sm-12">'+
												'<table class="table table-bordered">'+
													'<tr>'+
														'<td><b>E-Code</b></td>'+
														'<td>: '+ response.data[0].ecode +'</td>'+
													'</tr>'+
													'<tr>'+
														'<td><b>Gender</b></td>'+
														'<td>: '+ response.data[0].gender +'</td>'+
													'</tr>'+
													'<tr>'+
														'<td><b>Name</b></td>'+
														'<td>: '+ response.data[0].name +'</td>'+
													'</tr>'+
													'<tr>'+
														'<td><b>DOB</b></td>'+
														'<td>: '+ response.data[0].dob +'</td>'+
													'</tr>'+
												'</table>'+
											'</div>'+
										'</div>'+
										'<div class="col-sm-9">'+
											'<table class="table table-bordered">'+
												'<tr>'+
													'<td><b>Department</b></td>'+
													'<td>: '+ response.data[0].dept_name +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Designation / Grade</b></td>'+
													'<td>: '+ response.data[0].desg_name +' / '+ response.data[0].grade_name +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Joining Date</b></td>'+
													'<td>: '+ response.data[0].jdate +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Address</b></td>'+
													'<td>: '+ response.data[0].address +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Contact No. / Alternet No.</b></td>'+
													'<td>: '+ response.data[0].contact_no +' / '+ response.data[0].alternet_no +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Father Name / DOB</b></td>'+
													'<td>: '+ response.data[0].father_name +' / '+ response.data[0].fdob +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Mother Name / DOB</b></td>'+
													'<td>: '+ response.data[0].mother_name +' / '+ response.data[0].mdob +'</td>'+
												'</tr>'+
												'<tr>'+
													'<td><b>Marital Status</b></td>'+
													'<td>: '+ response.data[0].marital_status +'</td>'+
												'</tr>';
												if(response.data[0].marital_status == 'YES'){
													x = x + '<tr>'+
																'<td><b>Spouse Name</b></td>'+
																'<td>'+ response.data[0].spouse_name +'</td>'+
															'</tr>'+
															'<tr>'+
																'<td><b>Anniversary</b></td>'+
																'<td>'+ response.data[0].anniversary +'</td>'+
															'</tr>'+
															'<tr>'+
																'<td><b>No of Child</b></td>'+
																'<td>';
																if(response.data[0].children > 0){ 
																	x = x + '<table>'+
																				'<tr>'+
																					'<th>S.No.</th>'+
																					'<th>Name</th>'+
																					'<th>Gender</th>'+
																					'<th>DOB</th>'+
																				'</tr>'+
																				'<tr>'+
																					'<td>1.</td>'+
																					'<td>'+ response.data[0].child1_name +'</td>'+
																					'<td>'+ response.data[0].child1_gender +'</td>'+
																					'<td>'+ response.data[0].child1_dob +'</td>'+
																				'</tr>';
																				if(response.data[0].children > 1){
																				x = x +	'<tr>'+
																						'<td>2.</td>'+
																						'<td>'+ response.data[0].child2_name +'</td>'+
																						'<td>'+ response.data[0].child2_gender +'</td>'+
																						'<td>'+ response.data[0].child2_dob +'</td>'+
																					'</tr>';	
																				}
																				if(response.data[0].children > 2){
																				x = x +	'<tr>'+
																						'<td>3.</td>'+
																						'<td>'+ response.data[0].child3_name +'</td>'+
																						'<td>'+ response.data[0].child3_gender +'</td>'+
																						'<td>'+ response.data[0].child3_dob +'</td>'+
																					'</tr>';	
																				}
																			'</table>';
																}
															x = x +'</tr>';
												}
											x = x + '</table>'+
										'</div>'+
									'</div>'+
								'</div>';
					$('#employee_view').html(x);
				}
			}
		});
		
		$('#employee_detail').modal({
			keyboard: false
		});
	});
});
</script>
</body>