<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>
	<?php 
		$pageTitle = isset($title) ? $title : 'Emp-Portal'; 
		print_r($pageTitle);
	?>
</title>
<link rel="stylesheet" href="<?php echo base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets');?>/dist/css/adminlte.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets');?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets');?>/dist/css/adminlte.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets');?>/dist/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
<link rel="stylesheet" href="http://ericjgagnon.github.io/wickedpicker/wickedpicker/wickedpicker.min.css"> 
<link rel="stylesheet" href="<?php echo base_url('assets');?>/dist/css/select2-bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets');?>/dist/css/select2.min.css">
	  
<style>
	.main-sidebar {
		#background-color: #c7262b;
		background-color: #012f6a;
	}
	
	.main-header {
		background-color: #c7262b;
		#background-color: #012f6a;
	}
	.error {
		border-color : crimson !important;
	}
	
	.success {
		border-color : darkseagreen !important;
	}
	
	
</style>