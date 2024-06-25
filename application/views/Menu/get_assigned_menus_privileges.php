<?php
$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<table  width="100%" class="table table-striped table-lightfont" id="assigned_menus">						
	<tbody>
		<tr>
			<td class="text-center">
				&nbsp;
			</td>
			<td class="text-left" colspan="2">
				<b><b><input type="checkbox" id="checkAll2" class="checkbox13"> Select All</b></b>
			</td>
			<td class="text-left" >
											<b>&nbsp;</b>
										</td>
										<td class="text-left" >
											<b><input type="checkbox" id="checkAll" class="checkbox123"> Select All Privileges</b>
										</td>
		</tr>
		
		
		
		<?php
		$Error_flag=0;
		$Level_1_menu = NULL;
		$Level_2_menu = NULL;
		if($Level_0_menu != NULL)
		{
			// print_r($Level_0_menu); echo "<br><br>";
			
			foreach($Level_0_menu as $row)
			{
				// if($row->Menu_id=='1' || $row->Menu_id=='17' || $row->Menu_id=='55' ||  $row->Menu_id=='82'  ||  $row->Menu_id=='103'   ||  $row->Menu_id=='113'  ){continue;}
				$Error_flag=1;
			?>
				<tr class="active">
					<td>
						<label>
							<input type="checkbox" class="checkbox12"  value="<?php echo $row->Menu_id;?>" name="Checkbox_level_0[]"  <?php if($user_assigned_all_menus != false && in_array($row->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> readonly >
						</label>
					</td>
					<td class="text-center"><?php echo $row->Menu_name;?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			<?php										
				// $Level_1_menu = $ci_object->Menu_model->get_level_1_menu($row->Menu_id);
				$Level_1_menu = $ci_object->Menu_model->get_user_assigned_level_1_menu($Company_id,$Enrollment_id,$row->Menu_id);
				// print_r($Level_1_menu);
				if($Level_1_menu != NULL)
				{							
					foreach($Level_1_menu as $row1)
					{
							// if( $row1->Menu_id=='82' ||  $row1->Menu_id=='103'  ||  $row1->Menu_id=='100' ){continue;}
							
							$Priv1 = $ci_object->Menu_model->Get_member_assign_privileges($Company_id,$row1->Menu_id,$Enrollment_id);
							// print_r($Priv1);
							// echo "<br>".$Priv1->Add_flag;die;
							$Add_flag=0;
							$Edit_flag=0;
							$View_flag=0;
							$Delete_flag=0;
							if($Priv1 != NULL)
							{
								$Add_flag=$Priv1->Add_flag;
								$Edit_flag=$Priv1->Edit_flag;
								$View_flag=$Priv1->View_flag;
								$Delete_flag=$Priv1->Delete_flag;
							}
							
							
					?>
						<tr>
							<td>
								<label>
									<input type="checkbox" class="checkbox12"   value="<?php echo $row1->Menu_id;?>" name="Checkbox_level_1[]" <?php if($user_assigned_all_menus != false && in_array($row1->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> readonly>
								</label>
							</td>
							<td>&nbsp;</td>
							<td><?php echo $row1->Menu_name;?></td>
							<td>&nbsp;</td>
							<td>
								<?php if( $row1->Menu_id!='3' && $row1->Menu_id!='8' && $row1->Menu_id!='11' && $row1->Menu_id!='15' && $row1->Menu_id!='36' && $row1->Menu_id!='41' && $row1->Menu_id!='43' && $row1->Menu_id!='61' && $row1->Menu_id!='65' && $row1->Menu_id!='72' && $row1->Menu_id!='78' &&  $row1->Menu_id!='88' &&  $row1->Menu_id!='93' ){ ?>
								<label><input type="checkbox" class="checkbox1" name="<?php echo "Add_".$row1->Menu_id; ?>" id="<?php echo "Add_".$row1->Menu_id; ?>"  value="1" <?php if($Add_flag==1){echo 'checked';} ?> > Add</label>
								&nbsp;
								<label><input type="checkbox" class="checkbox1" name="<?php echo "Edit_".$row1->Menu_id; ?>" id="<?php echo "Edit_".$row1->Menu_id; ?>"  value="1"  <?php if($Edit_flag==1){echo 'checked';} ?> > Edit</label>
								&nbsp;
								<label><input type="checkbox" class="checkbox1" name="<?php echo "View_".$row1->Menu_id; ?>" id="<?php echo "View_".$row1->Menu_id; ?>"  value="1"  <?php if($View_flag==1){echo 'checked';} ?> > View</label>
								&nbsp;
								<label><input type="checkbox" class="checkbox1" name="<?php echo "Delete_".$row1->Menu_id; ?>" id="<?php echo "Delete_".$row1->Menu_id; ?>"  value="1"  <?php if($Delete_flag==1){echo 'checked';} ?> > Delete</label>
								<?php } ?>
							</td>
						</tr>
					<?php
						$Level_2_menu = $ci_object->Menu_model->get_user_assigned_level_2_menu($Company_id,$Enrollment_id,$row1->Menu_id);
						if($Level_2_menu != NULL)
						{
							foreach($Level_2_menu as $row2)
							{
								$Priv11 = $ci_object->Menu_model->Get_member_assign_privileges($Company_id,$row2->Menu_id,$Enrollment_id);
								// print_r($Priv1);
								// echo "<br>".$Priv1->Add_flag;die;
								$Add_flag2=0;
								$Edit_flag2=0;
								$View_flag2=0;
								$Delete_flag2=0;
								if($Priv11 != NULL)
								{
									$Add_flag2=$Priv11->Add_flag;
									$Edit_flag2=$Priv11->Edit_flag;
									$View_flag2=$Priv11->View_flag;
									$Delete_flag2=$Priv11->Delete_flag;
								}
							?>
								<tr>
									<td>
										<label>
											<input type="checkbox" class="checkbox12"  value="<?php echo $row2->Menu_id;?>" name="Checkbox_level_2[]"  <?php if($user_assigned_all_menus != false && in_array($row2->Menu_id,$user_assigned_all_menus) ){ echo "checked"; }?> readonly>
										</label>
									</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td><?php echo $row2->Menu_name;?></td>
									<td>
										<label><input type="checkbox" class="checkbox1" name="<?php echo "Add_".$row2->Menu_id; ?>" id="<?php echo "Add_".$row2->Menu_id; ?>"  value="1" <?php if($Add_flag2==1){echo 'checked';} ?> > Add</label>
										&nbsp;
										<label><input type="checkbox" class="checkbox1" name="<?php echo "Edit_".$row2->Menu_id; ?>" id="<?php echo "Edit_".$row2->Menu_id; ?>"  value="1"  <?php if($Edit_flag2==1){echo 'checked';} ?> > Edit</label>
										&nbsp;
										<label><input type="checkbox" class="checkbox1" name="<?php echo "View_".$row2->Menu_id; ?>" id="<?php echo "View_".$row2->Menu_id; ?>"  value="1"  <?php if($View_flag2==1){echo 'checked';} ?> > View</label>
										&nbsp;
										<label><input type="checkbox" class="checkbox1" name="<?php echo "Delete_".$row2->Menu_id; ?>" id="<?php echo "Delete_".$row2->Menu_id; ?>"  value="1"  <?php if($Delete_flag2==1){echo 'checked';} ?> > Delete</label>
							</td>											
								</tr>
							<?php
							}
						}
					}
				}
			}
		}
		?>
		<?php if($Level_0_menu != NULL || $Level_1_menu != NULL || $Level_2_menu != NULL )
		{ ?>  
		<tr>
			<td class="text-center" colspan="6">
				<button type="submit" name="submit" value="Assign_Menus" id="Assign_Menus" class="btn btn-primary">Submit</button>
			</td>
		</tr>
		<?php
		}else{echo '<td class="text-center" colspan="6">
					<font color="red" size="4px">Please Assign menus to User first !!!</font>
			</td>';}
		?>	
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
	
	// $("#checkAll").attr("data-type", "check");
	// $("#checkAll2").attr("data-type", "check");
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
	
	$("#checkAll2").click(function() 
	{
		if ($("#checkAll2").attr("data-type") === "check") 
		{
			$(".checkbox12").prop("checked", true);
			$("#checkAll2").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox12").prop("checked", false);
			$("#checkAll2").attr("data-type", "check");
		}
	});
	
});
</script>
