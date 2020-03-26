  
  <div class="content-wrapper">	
	<div class="content-header bg-light mb-3">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">TOUR REQUEST FORM</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employee Section</li>
						<li class="breadcrumb-item active">Tour Request form</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

    <!-- Main content -->
    <!--<div class="content">-->
      <div class="container-fluid">
		<div class="col-12 mb-3">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">TOUR REQUEST FORM1</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td>DATE OF APPLICATION</td>
							<td><?php echo date('d/m/Y');?></td>
						</tr>
						<tr>
							<td>GOING TO TOUR FROM</td>
							<td>
								<input type="text" id="from" name="from" class="form-control" autocomplete="off">
								<label for="to">to</label>
								<input type="text" id="to" name="to" class="form-control" autocomplete="off">
							</td>
						</tr>
						<tr>
							<td><b>Location Name</b></td>
							<td>
								<input type="text" class="form-control" name="location" placeholder="Enter location name">
							</td>
						</tr>
						<tr>
							<td><b>REASON FOR TOUR</b></td>
							<td>
								<textarea class="form-control"></textarea>
							</td>
						</tr>
					</table>
				</div>
              </div>
            </div>
				<div class="text-center">
					<input type="button" value="Submit" class="btn btn-warning">
					<input type="button" value="Cancel" class="btn btn-secondary">
				</div>
          </div>
		  <hr/>
		  
		  <div class="col-12">
            <div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">PREVIOUS TOUR REQUEST STATUS</h3>
              </div>
              <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>	
							<tr class="bg-dark">
								<th>REQUEST ID</th>
								<th>REQUEST DATE</th>
								<th>LEAVE TAKEN DATE</th>
								<th>REASON</th>
								<th>HOD APPROVAL STATUS</th>
								<th>HR Adjust(D-Done P-Pending)</th>
								<th>HR REMARKS</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>REQUEST ID</td>
								<td>REQUEST DATE</td>
								<td>LEAVE TAKEN DATE</td>
								<td>REASON</td>
								<td>HOD APPROVAL STATUS</td>
								<td>HR Adjust(D-Done P-Pending)</td>
								<td>HR REMARKS</td>
							</tr>
						</tbody>
					</table>
				</div>
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
	
	$( function() {
     var dateFormat = "mm/dd/yy",
    //var dateFormat = "dd/mm/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
		  // dateFormat:"dd/mm/yy",
		  // altFormat: "dd/mm/yy",
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
	    // dateFormat:"dd/mm/yy",
		// altFormat: "dd/mm/yy",
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
	
});
</script>
</body>