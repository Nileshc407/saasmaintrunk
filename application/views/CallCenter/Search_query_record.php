 <?php 
$ci_object = &get_instance();
$ci_object->load->model('CallCenter_model'); 
$ci_object->load->model('Igain_model');

		
if($Memberquery != NULL)
{
?>
<div class="content-panel"   id="Search_query">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Member Query Records
			  </h5> 
<div class="table-responsive">
	<table class="table table-striped table-lightfont">
		<thead>
		<tr>
			<th class="text-center">Ticket</th>
			<th class="text-center">Query Type</th>
			<th class="text-center">Priority</th>
			<th class="text-center">Query Status</th>
			<th class="text-center">Interactions</th>
		</tr>
	</thead>	
		<tbody>
		<?php
		$todays = date("Y-m-d");
		
		
			foreach($Memberquery as $row)
			{							
				
			?>
			<tr>		
				<td class="text-center"><?php echo $row->Querylog_ticket;?>
				</td>
				<?php $QueryName = $ci_object->CallCenter_model->get_query_details($row->Query_type_id,$Company_id); ?>
				<td><?php echo $QueryName->Query_type_name; ?></td>	
				<?php $PriorityName = $ci_object->CallCenter_model->Get_Priority_level_detail($row->Resolution_priority_levels,$Company_id); ?>
				<td class="text-center">
				
					<?php if($PriorityName->Resolution_priority_levels==1){ echo '<a class="badge badge-success-inverted" href="">'.$PriorityName->Level_name.'</a>';} ?>
					<?php if($PriorityName->Resolution_priority_levels==2){ echo '<a class="badge badge-danger-inverted" href="">'.$PriorityName->Level_name.'</a>';} ?>
					<?php if($PriorityName->Resolution_priority_levels==3){ echo '<a class="badge badge-danger-inverted" href="" style="background-color: #ffb3b3 !important;">'.$PriorityName->Level_name.'</a>';} ?>
					<?php if($PriorityName->Resolution_priority_levels==4){ echo '<a class="badge badge-primary-inverted" href="">'.$PriorityName->Level_name.'</a>';} ?>
					
					
				</td>
				<td class="text-center">
				<?php
				if($row->Query_status=='Forward'){ echo '<div class="status-pill green" title="Forward" data-placement="top"  data-toggle="tooltip"></div>';} 
				
				 if($row->Query_status=='Closed'){ echo '<div class="status-pill red" title="Closed" data-placement="top"  data-toggle="tooltip"></div>';} ?>
				
				
				</td>
				<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Create_User_id); ?>
				<!--<td class="text-center">
				<a href="#" onclick="wopen('callcenter_interaction.php?log_compid=<?php //echo $gv_log_compid; ?>&membership_id=<?php //echo $lv_member_id; ?>&ticket_number=<?php //echo $rows['Querylog_ticket']; ?>','popup'); ">
				<b><u><font color="blue">Details</font></u></b> 
				</a>								
				</td>-->
				<td class="text-center">
				<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details1('<?php echo $row->Querylog_ticket; ?>');" title="Details">
					<i class="os-icon os-icon-grid-10" ></i>
					</a>								
				</td>
			</tr>
			<?php
			}
		
		?>	
		</tbody>
	</table>
	
</div>
</div>
</div>
</div>
<?php	}else {echo '<div class="panel-heading" align="center"><h4>No Matching Records Found !!!</h4></div>';}
	?>
				