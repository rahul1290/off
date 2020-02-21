<script src="<?php echo base_url('assets/plugins/jquery/');?>jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/');?>bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/dist/js/');?>adminlte.min.js"></script>
<script src="<?php echo base_url('assets/dist/js/');?>jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="http://192.168.25.237/it-operation.in/assest/js/wickedpicker.js"></script>


<script>
		$(function() {
			$( ".datepicker" ).datepicker({
			   //appendText:"(yy-mm-dd)",
			   dateFormat:"dd/mm/yy",
			   altField: "#datepicker-4",
			   altFormat: "dd/mm/yy"
			});
		});
	</script>