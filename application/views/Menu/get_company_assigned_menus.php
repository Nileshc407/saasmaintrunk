<?php
$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<table width="100%" class="table table-striped table-lightfont" id="delete_menus">						
	<tbody>
		<tr>
			<td class="text-center">
				<label>
					<input type="checkbox" id="checkAll3" class="checkbox3">
				</label>
			</td>
			<td class="text-left" colspan="2">
				<b>Select All</b>
			</td>
		</tr>
		
		<?php
		if($Level_0_company_menu != NULL)
		{
			foreach($Level_0_company_menu as $results)
			{
				?>
					<tr class="active">
						<td class="text-center">
							<label>
								<input type="checkbox" value="<?php echo $results->Menu_id;?>" name="Del_Checkbox_level_0[]" class="checkbox3">
							</label>
						</td>
						<td class="text-center"><?php echo $results->Menu_name;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					
				<?php			
				$Level_1_company_menu = $ci_object->Menu_model->get_company_assigned_level_1_menu($Company_id,$results->Menu_id);
				if($Level_1_company_menu != NULL)
				{
					foreach($Level_1_company_menu as $results2)
					{
						?>
							<tr>
								<td class="text-center">
									<label>
										<input type="checkbox" value="<?php echo $results2->Menu_id;?>" name="Del_Checkbox_level_1[]" class="checkbox3">
									</label>
								</td>
								<td>&nbsp;</td>
								<td><?php echo $results2->Menu_name;?></td>
								<td>&nbsp;</td>
							</tr>
						<?php
						$Level_2_company_menu = $ci_object->Menu_model->get_company_assigned_level_2_menu($Company_id,$results2->Menu_id);
						if($Level_2_company_menu != NULL)
						{
							foreach($Level_2_company_menu as $results3)
							{
							?>
								<tr>
									<td>
										<label>
											<input type="checkbox" value="<?php echo $results3->Menu_id;?>" name="Del_Checkbox_level_2[]" class="checkbox1">
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
		?>
	
	</tbody> 
</table>

<script>
$(document).ready(function() 
{
	$("#checkAll3").attr("data-type", "check");
	$("#checkAll3").click(function() 
	{
		if ($("#checkAll3").attr("data-type") === "check") 
		{
			$(".checkbox3").prop("checked", true);
			$("#checkAll3").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox3").prop("checked", false);
			$("#checkAll3").attr("data-type", "check");
		}
	});
});
</script>
