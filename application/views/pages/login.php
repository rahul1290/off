<!DOCTYPE html>
<html lang="en">
	<head>
		<?php 
			$headerLinks = isset($head) ? $head : 'Head not included'; 
			print_r($headerLinks);
			
			$footerLinks = isset($footer) ? $footer : 'Footer not included'; 
			print_r($footerLinks);
		?>
		
	</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
	<a href="https://www.ibc24.in">
		<img src="<?php echo base_url('assets')?>/dist/img/logoo.png" />
	</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login to Employee Portal123</p>
	  <?php echo $this->session->flashdata('msg');	?>
      <form action="<?php echo base_url('Auth/login');?>" method="POST" class="mb-2">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Identity" name="identity" value="SBMMPL-0">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
		<?php echo form_error('identity'); ?>
		
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<?php echo form_error('password'); ?>
		
        <div class="row">
          <!-- /.col -->
          <div class="col-4 float-right">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>
</html>