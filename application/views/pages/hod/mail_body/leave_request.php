<h6>Approval Status of Leave Request</h6>

<table>
	<tr>
		<td>Leave Request By</td>
		<td>: <?php echo $leave_detail[0]['name']; ?></td>
	</tr>
	<tr>
		<td>Request No.</td>
		<td>: <b><span><?php echo $this->my_library->remove_hyphen($leave_detail[0]['reference_id']); ?></span></b></td>
	</tr>
	<tr>
		<td>Leave From</td>
		<td>: <?php echo date('d/m/Y',strtotime($leave_detail[0]['date_from'])); ?> To <?php echo date('d/m/Y',strtotime($leave_detail[0]['date_to'])); ?></td>
	</tr>
	<tr>
		<td>Total No of Days For Leave</td>
		<td>: <?php echo $this->my_library->day_duration($leave_detail[0]['date_from'],$leave_detail[0]['date_to']); ?></td>
	</tr>
	<tr>
		<td>HOD Remarks</td>
		<td>: <?php echo $leave_detail[0]['hod_remark']; ?></td>
	</tr>
	<tr>
		<td>HOD Approval Status</td>
		<td>: <b><?php echo $app_status; ?></b></td>
	</tr>
</table>
For more detail Log on to : <a href="<?php echo base_url();?>"><?php echo base_url();?></a> .