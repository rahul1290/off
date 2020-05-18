<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
	  
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url('dashboard');?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
	  
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
	<li class="nav-item dropdown">
		<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
			<a href="#" class="dropdown-item">
				<div class="media">
					<img width="45" src="<?php echo $this->config->item('img_url').$this->session->userdata('ecode').'.jpg'; ?>" class="img-circle elevation-4" alt="User Image">
					<div class="media-body">
						<h3 class="dropdown-item-title">
							&nbsp;&nbsp;&nbsp;<?php echo $this->session->userdata('username'); ?>
						</h3>
						<p class="text-sm">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->session->userdata('designation');?></p>
					</div>
				</div>
			</a>
			<div class="dropdown-divider"></div>
			
			<div class="dropdown-divider"></div>
			<a href="#" class="dropdown-footer">Change Profile</a>
			<div class="dropdown-divider"></div>
			<a href="#" class="dropdown-footer">Log Out</a>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>