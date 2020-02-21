  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper bg-white" style="background-image: url(<?php echo base_url('assets/dist/img/logoo_trans.png');?>);
    background-repeat: no-repeat;
	z-index:-999;
    background-position: right bottom;">
	
<div class="content-header bg-light mb-3">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">IT POLICIES</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
					<li class="breadcrumb-item active">IT POLICIES</li>
				</ol>
			</div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

	
    <!-- Main content -->
    <div class="content bg">
      <div class="container-fluid">
		<div class="col-md-10 col-xs-12">
            <!-- general form elements disabled -->
            <!--div class="card card-info">
              <div class="card-header" style="border-radius:0px;">
                <h3 class="card-title">IT POLICIES</h3>
              </div>
              <!-- /.card-header -->
              <!--div class="card-body"-->
				<div class="row">
					<div class="info-box col-md-3 col-xs-12" style="margin-left: 10px;">
						<span class="info-box-icon bg-success"><i class="fas fa-desktop"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">IT POLICIES</span>
							<a target="_blank" href="<?php echo base_url($this->config->item('it_policies').'IT_POLICY.pdf');?>"><i class="fas fa-download"></i></a>
						</div>
					</div>

					<div class="info-box col-md-3 col-xs-12" style="margin-left: 10px;">
						<span class="info-box-icon bg-warning"><i class="fas fa-laptop"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">PC/LAPTOP POLICIES</span>
							<a target="_blank" href="<?php echo base_url($this->config->item('it_policies').'PCLAPTOPPOLICY.pdf');?>"><i class="fas fa-download"></i></a>
						</div>
					</div>

					<div class="info-box col-md-3 col-xs-12" style="margin-left: 10px;">
						<span class="info-box-icon bg-info"><i class="fab fa-facebook-square"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">SOCIAL MEDIA POLICIES</span>
							<a target="_blank" href="<?php echo base_url($this->config->item('it_policies').'SOCIALMEDIAPOLICY.pdf');?>"><i class="fas fa-download"></i></a>
						</div>
					</div>
				</div>
              <!--/div-->
              <!-- /.card-body -->
            <!--/div-->
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