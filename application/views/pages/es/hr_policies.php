  <div class="content-wrapper bg-white" style="background-image: url(<?php echo base_url('assets/dist/img/logoo_trans.png');?>);
    background-repeat: no-repeat;
	z-index:-999;
    background-position: right bottom;">
	
<div class="content-header bg-light mb-3">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">HR POLICIES</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
					<li class="breadcrumb-item active">HR POLICIES</li>
				</ol>
			</div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

	
    <!-- Main content -->
    <div class="content bg">
      <div class="container-fluid">
		<div class="col-12">
				<?php if(count($policies)>0){
					$c = 1;
					foreach($policies as $policy){
						if($c == 1){
							echo '<div class="row">';
						}
						echo '<div class="info-box col" style="padding:50px; max-width: 450px;">'.
								'<span class="info-box-icon bg-warning"><i class="far fa-file-pdf"></i></span>'.
								'<div class="info-box-content ml-4">'.
									'<a target="_blank" href="'.base_url().'policies/'.$policy['file_name'].'"><span class="info-box-text">'.$policy['title'].'</span>'.
									'<i class="fas fa-download"></i></a>'.
								'</div>'.
							'</div>';
						if($c%3 == 0){
							echo '</div>';
							if($c < count($policies)){
								echo '<div class="row">';
							}
						}
						if($c == count($policies)){
							echo '</div>';
						}
					$c++;
					}
				}?>
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