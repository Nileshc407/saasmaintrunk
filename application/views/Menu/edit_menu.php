<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT MENU
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
					echo form_open('Menu/update_menu',$attributes); ?>
					<div class="col-sm-8">
					<div class="form-group">
					<label for=""><span class="required_info">*</span> Menu Level</label>
						<select class="form-control" name="menu_level" id="menu_level" required>
							<option value="<?php echo $results2->Menu_level; ?>">Menu Level-<?php echo $results2->Menu_level; ?></option>
						</select>
					</div>		  		
								  
				 <?php if($results2->Parent_menu_id != 0) { ?>
						<div class="form-group" id="ParentMenu">
							<label for=""><span class="required_info">*</span> Parent Menu</label>
							<select class="form-control" name="parent_menu_id" id="parent_menu_id" disabled>
								<option value="<?php echo $results2->Parent_menu_id; ?>"><?php echo $Parent_menu->Menu_name; ?></option>
							</select>								
						</div>
					<?php } ?>
				  
				  <div class="form-group">
					<label for=""> <span class="required_info">* </span> Menu Name </label>								
					<input class="form-control"  name="menu_name" id="menu_name"  type="text"  placeholder="Enter Menu Name" required="required" data-error="Please enter menu name" value="<?php echo $results2->Menu_name; ?>" >
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div> 
				  
				  <div class="form-group">
					<label for=""> <span class="required_info">* </span> Menu Link / HREF </label>								
					<input class="form-control" name="menu_href" id="menu_href"  type="text"  placeholder="Enter Menu Link / HREF" required="required" value="<?php echo $results2->Menu_href; ?>" data-error="Please enter menu link">
					<div class="help-block form-text with-errors form-control-feedback"></div>
				  </div> 
				  <div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> License Type</label>
						<select class="form-control" name="License_type[]" id="License_type"  required>
							
							<?php
							if($License_type != NULL)
							{
								foreach($License_type as $License_type)
								{
									 if($results2->License_type==$License_type->Code_decode_id)
									 {
								?>
								
									<option value="<?php echo $License_type->Code_decode_id;?>"  ><?php echo $License_type->Code_decode; ?></option>
								
								<?php
									 }
								}
							}
							?>
						</select>
							
				  </div> 
				  
				  <div class="form-buttons-w">
					<input type="hidden" name="Menu_id" value="<?php echo $results2->Menu_id; ?>" />
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>
				</div>
				</div>
			</div>
<!-------------------- START - Data Table -------------------->
	           
				<div class="element-wrapper">                
						<div class="element-box">
						  <h5 class="form-header">
							Menus
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">License Type</th>
										<th class="text-center">Menu Level</th>
										<th class="text-center">Menu Name</th>
										<th class="text-center">Menu Link / HREF</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">License Type</th>
										<th class="text-center">Menu Level</th>
										<th class="text-center">Menu Name</th>
										<th class="text-center">Menu Link / HREF</th>
	
									</tr>
								</tfoot>		

								<tbody>
									<?php 
									if($results != NULL)
									{
										$ci_object = &get_instance();
										$ci_object->load->model('Menu/Menu_model');
										foreach($results as $row)
										{
											
											$Get_License_type = $ci_object->Menu_model->Get_Specific_Code_decode_master($row->License_type);
											$License_type=$Get_License_type->Code_decode;
										?>
											<tr>
												<td class="row-actions">
													<a href="<?php echo base_url()?>index.php/Menu/edit_menu/?Menu_id=<?php echo $row->Menu_id;?>" title="Edit">
														<i class="os-icon os-icon-ui-49"></i>
													</a>
												
													<a href="javascript:void(0);" onclick="delete_me('<?php echo $row->Menu_id;?>','<?php echo $row->Menu_name; ?>','','Menu/delete_menu/?Menu_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
														<i class="os-icon os-icon-ui-15"></i>
													</a>
												
												</td>
												<td class="text-center"><?php echo $License_type;?></td>
												<td class="text-center"><?php echo $row->Menu_level;?></td>
												<td class="text-center"><?php echo $row->Menu_name;?></td>
												<td><?php echo $row->Menu_href;?></td>
											</tr>
										<?php
										}
									}
									?>
						</tbody>
						</table>
					  </div>
					</div>
				</div>
		
<!--------------------  END - Data Table  -------------------->
				
			 
		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>

<script type="text/javascript">
$('#Register').click(function()
{
	if( $('#parent_menu_id').val() != "" && $('#menu_level').val() != "" && $('#menu_name').val() != "" && $('#menu_href').val() != "")
	{
		show_loader();
			
	}
});
	
$(document).ready(function() 
{	
	$("#ParentMenu").hide();
	
	$('#menu_level').change(function()
	{
		if( $("#menu_level").val() == 1 || $("#menu_level").val() == 2 )
		{
			var menu_level = $("#menu_level").val();
			$("#ParentMenu").show();
			$("#parent_menu_id").attr("required","required");
			
			$.ajax({
				type:"POST",
				data:{ menu_level:menu_level },
				url: "<?php echo base_url()?>index.php/Menu/get_parent_menu",
				success: function(data)
				{
					$('#parent_menu_id').html(data);
				}				
			});
		}
		else
		{
			$("#ParentMenu").hide();
			$("#parent_menu_id").removeAttr("required");
		}
	});
});
</script>