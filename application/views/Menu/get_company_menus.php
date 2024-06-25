<?php
$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<table width="100%" class="table table-striped table-lightfont" id="assigned_menus">						
	<tbody>
		<tr>
			<td class="text-center">
				<label>
					<input type="checkbox" id="checkAll2" class="checkbox2">
				</label>
			</td>
			<td class="text-left" colspan="2">
				<b>Select All</b>
			</td>
		</tr>
		
		<?php
		if($Level_0_menu != NULL)
		{
			foreach($Level_0_menu as $row)
			{
				$results = $this->Menu_model->edit_menu($row->Menu_id);
				$company_menu_details = $this->Menu_model->get_company_menu_details($Company_id,$row->Menu_id);
				$Parent_License_type=$results->License_type;
				if($company_menu_details != false)
				{
				?>
					<tr class="active">
						<td>
							<label>
								<input type="checkbox" name="Checkbox_level_0[]" value="<?php echo $results->Menu_id;?>" checked class="checkbox2">
							</label>
						</td>
						<td><?php echo $results->Menu_name;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					
				<?php	
				}
				else
				{
				?>
					<tr class="active">
						<td>
							<label>
								<input type="checkbox" value="<?php echo $results->Menu_id;?>" name="Checkbox_level_0[]" class="checkbox2">
							</label>
						</td>
						<td><?php echo $results->Menu_name;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				<?php
				}
				
				$Level_1_menu = $ci_object->Menu_model->get_level_1_menu($row->Menu_id);
				if($Level_1_menu != NULL)
				{
					foreach($Level_1_menu as $row1)
					{		
						$results2 = $this->Menu_model->edit_menu($row1->Menu_id);
						$company_menu_details2 = $this->Menu_model->get_company_menu_details($Company_id,$row1->Menu_id);
						$Level_1_License_type=$results2->License_type;
						if($Parent_License_type!=$Level_1_License_type)
						{
							continue;
						}
						if($company_menu_details2 != false)
						{
						?>
							<tr>
								<td>
									<label>
										<input type="checkbox" name="Checkbox_level_1[]" value="<?php echo $results2->Menu_id;?>"  checked class="checkbox2">
									</label>
								</td>
								<td>&nbsp;</td>
								<td><?php echo $results2->Menu_name;?></td>
								<td>&nbsp;</td>
							</tr>
						<?php
						}
						else
						{
						?>
							<tr>
								<td>
									<label>
										<input type="checkbox" value="<?php echo $results2->Menu_id;?>" name="Checkbox_level_1[]" class="checkbox2">
									</label>
								</td>
								<td>&nbsp;</td>
								<td><?php echo $results2->Menu_name;?></td>
								<td>&nbsp;</td>
							</tr>
						<?php
						}
						
						$Level_2_menu = $ci_object->Menu_model->get_level_2_menu($row1->Menu_id);
						if($Level_2_menu != NULL)
						{
							foreach($Level_2_menu as $row2)
							{
								$results3 = $this->Menu_model->edit_menu($row2->Menu_id);
								$company_menu_details3 = $this->Menu_model->get_company_menu_details($Company_id,$row2->Menu_id);
								$Level_2_License_type=$results3->License_type;
								if($Parent_License_type!=$Level_2_License_type)
								{
									continue;
								}
								if($company_menu_details3 != false)
								{
								?>
									<tr>
										<td>
											<label>
												<input type="checkbox" name="Checkbox_level_2[]" checked class="checkbox2" value="<?php echo $results3->Menu_id;?>">
											</label>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><?php echo $results3->Menu_name;?></td>												
									</tr>
								<?php
								}
								else
								{
								?>
									<tr>
										<td>
											<label>
												<input type="checkbox" value="<?php echo $results3->Menu_id;?>" name="Checkbox_level_2[]" class="checkbox2">
											</label>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><?php echo $results3->Menu_name;?></td>												
									</tr>
								<?php
								}
							}
						}
					}
				}
				
			}
		}
		?>
	
	</tbody> 
</table>

<script>
$(document).ready(function() 
{
	$("#checkAll2").attr("data-type", "check");
	$("#checkAll2").click(function() 
	{
		if ($("#checkAll2").attr("data-type") === "check") 
		{
			$(".checkbox2").prop("checked", true);
			$("#checkAll2").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox2").prop("checked", false);
			$("#checkAll2").attr("data-type", "check");
		}
	});
});
</script>
