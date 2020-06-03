<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
	<!--.navbar -->
	<?php 
		$topNav = isset($top_nav) ? $top_nav : ''; 
		print_r($topNav);
	?>  
  <!-- /.navbar -->

  <!-- aside -->
	<?php 
		$aSide = isset($aside) ? $aside : ''; 
		print_r($aSide);
	?>  
  <!-- /aside -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!--h1 class="m-0 text-dark">Starter Page</h1-->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-info">
					<div class="inner">
						<h3>LEAVE</h3>
						<p>MANAGEMENT</p>
					</div>
					<div class="icon">
						<i class="fas fa-calendar-check"></i>
					</div>
					<a href="<?php echo base_url('es/Attendance-Record'); ?>" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-success">
					<div class="inner">
						<h3>IT</h3>
						<p>POLICIES</p>
					</div>
					<div class="icon">
						<i class="fa fa-desktop" aria-hidden="true"></i>
					</div>
					<a href="<?php echo base_url('es/IT-Policies'); ?>" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-warning">
					<div class="inner">
						<h3>CAB</h3>
						<p>MANAGEMENT</p>
					</div>
					<div class="icon">
						<i class="fa fa-car" aria-hidden="true"></i>
					</div>
					<a href="<?php echo base_url('es/cab'); ?>" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h3>HR</h3>
						<p>POLICIES</p>
					</div>
					<div class="icon">
						<i class="fa fa-user" aria-hidden="true"></i>
					</div>
					<a href="<?php echo base_url('es/HR-Policies');?>" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h3>STATIONARY</h3>
						<p>DEPT</p>
					</div>
					<div class="icon">
						<i class="fas fa-pencil-alt" aria-hidden="true"></i>
					</div>
					<a href="#" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-info">
					<div class="inner">
						<h3>KRA</h3>
						<p>2020</p>
					</div>
					<div class="icon">
						<i class="fas fa-pencil-alt" aria-hidden="true"></i>
					</div>
					<a href="#" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			
			<div class="col-sm-2">
				<!-- small card -->
				<div class="small-box bg-secondary">
					<div class="inner">
						<h3>PCR</h3>
						<p>MANAGEMENT</p>
					</div>
					<div class="icon">
						<i class="fas fa-pencil-alt" aria-hidden="true"></i>
					</div>
					<a href="http://192.168.25.34/EmployeePortal/PCR/Message.aspx?emp_id=<?php echo $this->session->userdata('ecode'); ?>" class="small-box-footer">
						More info <i class="fas fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			
			<!-- ./col -->
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
</body>