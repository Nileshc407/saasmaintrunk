<?php
$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<table  width="100%" class="table table-striped table-lightfont" id="assigned_menus">						
	<tbody>
		<tr>
			<td class="text-center">
				<label>
					<input type="checkbox" id="checkAll" class="checkbox1">
				</label>
			</td>
			<td class="text-left" colspan="2">
				<b>Select All</b>
			</td>
		</tr>
		
		<?php
		
		if($Level_0_menu != NULL)
		{
			//print_r($user_assigned_all_menus); echo "<br><br>";
			
			foreach($Level_0_menu as $row)
			{
			?>
				<tr class="active">
					<td>
						<label>
							<input type="checkbox" value="<?php echo $row->Menu_id;?>" name="Checkbox_level_0[]" class="checkbox1" <?php if($user_assigned_all_menus != false && in_array($row->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> >
						</label>
					</td>
					<td class="text-center"><?php echo $row->Menu_name;?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			<?php										
				// $Level_1_menu = $ci_object->Menu_model->get_level_1_menu($row->Menu_id);
				$Level_1_menu = $ci_object->Menu_model->get_company_assigned_level_1_menu($Company_id,$row->Menu_id);
				if($Level_1_menu != NULL)
				{							
					foreach($Level_1_menu as $row1)
					{									
					?>
						<tr>
							<td>
								<label>
									<input type="checkbox" value="<?php echo $row1->Menu_id;?>" name="Checkbox_level_1[]" class="checkbox1" <?php if($user_assigned_all_menus != false && in_array($row1->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> >
								</label>
							</td>
							<td>&nbsp;</td>
							<td><?php echo $row1->Menu_name;?></td>
							<td>&nbsp;</td>
						</tr>
					<?php
						$Level_2_menu = $ci_object->Menu_model->get_company_assigned_level_2_menu($Company_id,$row1->Menu_id);
						if($Level_2_menu != NULL)
						{
							foreach($Level_2_menu as $row2)
							{
							?>
								<tr>
									<td>
										<label>
											<input type="checkbox" value="<?php echo $row2->Menu_id;?>" name="Checkbox_level_2[]" class="checkbox1" <?php if($user_assigned_all_menus != false && in_array($row2->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> >
										</label>
									</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td><?php echo $row2->Menu_name;?></td>												
								</tr>
							<?php
							}
						}
					}
				}
			}
		}
		?>
		
		<tr>
			<td class="text-center" colspan="4">
				<button type="submit" name="submit" value="Assign_Menus" id="Assign_Menus" class="btn btn-primary">Submit</button>
			</td>
		</tr>
	
	</tbody> 
</table>

<script>

	$('#Assign_Menus').click(function()
	{
		var User_type = $('#user_type').val();
		var user_name = $('#user_name').val();
		
		if(User_type > 0 && user_name > 0){
			show_loader();
		}
	});

$(document).ready(function() 
{
	
	$("#checkAll").attr("data-type", "check");
	$("#checkAll").click(function() 
	{
		if ($("#checkAll").attr("data-type") === "check") 
		{
			$(".checkbox1").prop("checked", true);
			$("#checkAll").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox1").prop("checked", false);
			$("#checkAll").attr("data-type", "check");
		}
	});
	
});
</script>
