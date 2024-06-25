<?php $this->load->view('header/header');

$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   ASSIGN MENUS Privileges
			  </h6>
			  <div class="element-box">
				<?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php 	} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php 	} ?>
				
				<?php $attributes = array('id' => 'formValidate');
					echo form_open('Menu/assign_menu_privileges',$attributes); ?>
					<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Select User Type </label>
						<select class="form-control " name="user_type" id="user_type" required="required" data-error="Please select user type">
						<option value="">Select User Type</option>
						 <?php
							if($User_types != NULL)
							{
								foreach($User_types as $row1)
								{
								?>
								
								<option value="<?php echo $row1['User_id'] ?>"><?php echo $row1['User_type'] ?></option>
								
								<?php
								}
							}
							?>
							</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>		  		
						</div>		  		
						<div class="col-sm-6">					
						 <div class="form-group">
							<label for=""> <span class="required_info">* </span>Select Username </label>
							<select class="form-control " name="user_name" id="user_name" required="required" data-error="Please select user name">
								<option value="">Select Username</option>
							</select>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						  </div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12" id="assignNew">
						
						<div class="d-flex flex-row flex-wrap">
						  <div class="p-2"><h6>Menus to be Assign Privileges</h6></div>
						</div>
 
						  <div class="element-wrapper">                
							<div class="element-box">                 
							  <div class="table-responsive" id="assigned_menus">
								<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
									<tbody>
									<tr>
										<td class="text-center">
											<label>
												<!--<input type="checkbox" id="checkAll" class="checkbox1">-->
											</label>
										</td>
										<td class="text-left" colspan="2">
											<b>&nbsp;</b>
										</td>
										<td class="text-left" >
											<b>&nbsp;</b>
										</td>
										<td class="text-left" >
											<b>Privileges</b>
										</td>
									</tr>
										<?php
											if($Level_0_menu != NULL)
											{
												
												foreach($Level_0_menu as $row)
												{
													if($row->Menu_id=='1' || $row->Menu_id=='6' || $row->Menu_id=='75' ||  $row->Menu_id=='83'  ){continue;}
												?>
													<tr class="active">
														<td>
															<label>
																<input type="checkbox" value="<?php echo $row->Menu_id;?>" name="Checkbox_level_0[]" class="checkbox1">
															</label>
														</td>
														<td class="text-center"><?php echo $row->Menu_name;?></td>
														<td>&nbsp;</td>
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
																		<input type="checkbox" value="<?php echo $row1->Menu_id;?>" name="Checkbox_level_1[]" class="checkbox1">
																	</label>
																</td>
																<td>&nbsp;</td>
																<td><?php echo $row1->Menu_name;?></td>
																<td>&nbsp;</td>
																<td>
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked > Add</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> Edit</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> View</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> Delete</label>
															</td>
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
																				<input type="checkbox" value="<?php echo $row2->Menu_id;?>" name="Checkbox_level_2[]" class="checkbox1">
																			</label>
																		</td>
																		<td>&nbsp;</td>
																		<td>&nbsp;</td>
																		<td><?php echo $row2->Menu_name;?></td>				<td>
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> Add</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> Edit</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> View</label>
															&nbsp;
															<label><input type="checkbox" name="Supervisor1" id="Supervisor1"  value="1" checked> Delete</label>
															
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
											
											<tr>
												<td class="text-center" colspan="4">
													<button type="submit" name="submit" value="Assign_Menus" id="Assign_Menus" class="btn btn-primary">Submit</button>
												</td>
											</tr>			
									</tbody> 
									</table>
								  </div>
								</div>
							  </div>
						</div>
					<!--	<div class="col-sm-12" id="assigned">
							<h6>Assigned Menus</h6>
						   <div class="element-wrapper">                
							<div class="element-box">                 
							  <div class="table-responsive" id="assigned_menus">
								<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
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
										
										<tr>
											<td class="text-center">
												<button type="submit" name="submit" value="Delete_Menus" id="Delete_Menus" class="btn btn-primary">Delete Menus</button>
											</td>
											<td class="text-left" colspan="2">
												<a href="#assignNew">assign more menus<i class="os-icon os-icon-arrow-up5"></i></a>
											</td>
										</tr>
									
									</tbody> 
								</table>
							  </div>
							</div>
							</div>
						</div> -->
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>	
			 
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
	
$(document).ready(function() 
{	
	$('#user_type').change(function()
	{
		var User_type = $('#user_type').val();
		var Company_id = '<?php echo $Company_id; ?>';
		// alert(User_type);
		$.ajax({
			type:"POST",
			data:{ User_type:User_type, Company_id:Company_id },
			url: "<?php echo base_url()?>index.php/Menu/get_usernames",
			success: function(data)
			{
				$('#user_name').html(data);
			}				
		});
	});	
	$('#user_name').change(function()
	{
		var user_name = $('#user_name').val();
		// alert(user_name);
		var Company_id = '<?php echo $Company_id; ?>';		
		$.ajax({
			type:"POST",
			data:{user_name:user_name, Company_id:Company_id },
			url: "<?php echo base_url()?>index.php/Menu/get_assigned_menus_privileges",
			success: function(data)
			{
				$('#assigned_menus').html(data);
			}				
		});
	});	
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
