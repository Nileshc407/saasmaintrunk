<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT SURVEY MULTIPLE CHOICE STRUCTURE
			  </h6>
				<div class="element-box">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
				<?php 		
					} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
					<?php 	} 
					
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Survey/update_survey_multiple_choices',$attributes); 
				if($MultipleChoice_details)
				{
				   foreach($MultipleChoice_details as $MultiChoie )
				   {
						$Option_values=$MultiChoie['Option_values'];
						$Name_of_option=$MultiChoie['Name_of_option'];
						$Number_of_option=$MultiChoie['Number_of_option'];
						$Choice_id=$MultiChoie['Choice_id'];
				   }
				} ?>
				<div class="col-sm-8">
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Name Of Multiple Choice Set</label>
						<input class="form-control" type="text" name="multiple_choice_name" id="multiple_choice_name" placeholder="Enter name of multiple choice set" data-error="Please enter name of multiple choice set" value="<?php echo $Name_of_option; ?>" readonly required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
					
					  <div class="form-group"> 
						<label for=""><span class="required_info">* </span> Enter Number of Options</label>
						<input class="form-control" type="text" class="form-control" name="no_of_options" id="no_of_options"  value="<?php echo $Number_of_option; ?>" placeholder="Enter number of options" data-error="Please enter number of options" readonly required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					  </div>
				</div>
				
				<div class="col-sm-12">						
					<fieldset class="form-group">
						<legend><span>Options Description</span></legend>						
						<div class="row">
					<?php		
						if($Company_details->Survey_analysis== '1') 
						{
							$column="col-sm-3";	
						}
						else
						{
							$column="col-sm-3";	
						}				
						
						if($MultipleChoice_details != "")
						{
							foreach($MultipleChoice_details as $MultiChoie )
							{
								$Value_id=$MultiChoie['Value_id'];
								$Option_values=$MultiChoie['Option_values'];
								$Name_of_option=$MultiChoie['Name_of_option'];
								$Number_of_option=$MultiChoie['Number_of_option'];					
								$NPS_type_id=$MultiChoie['NPS_type_id'];					
								$Option_image=$MultiChoie['Option_image'];					
								?>
								<div class="<?php echo $column; ?>">
									<div class="form-group">
										<label for=""><span class="required_info">* </span>Option Value</label>
										<input type="text" class="form-control" name="Option_values_<?php echo $Value_id; ?>" value="<?php echo $Option_values; ?>" placeholder="Enter options value" data-error="Please enter options value" required="required"/>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								</div>
								<?php 
								if($Company_details->Survey_analysis== '1') 
								{	?>	
									<div class="<?php echo $column; ?>">
										<div class="form-group">
											<label for=""><span class="required_info">* </span>NPS Type</label>
											<select id="nps_value[]" name="nps_value[]" class="form-control" data-error="Please select nps type" required="required">
												<option value=""> Select nps type </option>
												<?php foreach($Survey_nps_type as $nps) { ?>
												<option value="<?php echo $nps['NPS_type_id']; ?>"<?php if($NPS_type_id == $nps['NPS_type_id'] ) { ?> selected <?php  } ?>> <?php echo $nps['NPS_type_name']; ?> 
												</option>        
												<?php } ?>
											</select>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>					
									</div>						
								<?php
								}
								?>
								<div class="<?php echo $column; ?>">
									<div class="form-group upload-btn-wrapper">
										<label for="exampleInputEmail1">Select Option Image</label><br/>
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="file_<?php echo $Value_id ?>" class="form-control" value="<?php echo base_url(); ?><?php echo $Option_image; ?>" style="padding: 0px;" onchange="readImage(this,'#no_image_<?php echo $Value_id ?>');"/>
										
										<input type="hidden" name="Option_image_<?php echo $Value_id ?>" value="<?php echo $Option_image; ?>" class="form-control" />
									</div>									
								</div>
								<div class="<?php echo $column; ?>">
									<div class="form-group">						
										<img src="<?php echo base_url()?><?php echo $Option_image; ?>" id="no_image_<?php echo $Value_id ?>" style="width: 40%;padding: 10px;">						
									</div>									
								</div>
								<input type="hidden" name="Value_id[]" value="<?php echo $Value_id; ?>" class="form-control"  required="required"/>
								<?php 
							}
						}							  
						else
						{
					   ?>  
						<div class="form-group">
							<label for=""><span class="required_info">* </span>Name Of Multiple Choice Structure</label>
							<input type="text" name="multiple_choice_name" id="multiple_choice_name" class="form-control" placeholder="Enter name of multiple choice structure" data-error="Please enter name of multiple choice" readonly required="required" />
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						<div class="form-group">
							<label for=""><span class="required_info">* </span>Enter Number of Options</label>
							<input type="text" name="no_of_options"  id="no_of_options" class="form-control" placeholder="Number of Options " readonly required="required"/>
						</div>
						<div class="form-group">
							<label for=""><span class="required_info">* </span>Option Value</label>
							<input type="text" name="Option_value" id="Option_value" class="form-control" placeholder="Enter option value" data-error="Please enter name of multiple choice" required="required"/>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>					   
					  <?php 
					  }						  
					?>
						</div>
					</fieldset>
				</div>
			
				<div class="form-buttons-w">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
					<input type="hidden" name="Choice_id" value="<?php echo $Choice_id; ?>" />
				</div>
				<?php echo form_close(); ?>	
			  </div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Multiple Choice Structure Details
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Name Of Multiple Choice Structure</th>
								<th>Number Of Options</th>
							</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Name Of Multiple Choice Structure</th>
								<th>Number Of Options</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results != NULL)
						{
							foreach($results as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Survey/edit_multiple_choice/?Choice_id=<?php echo $row->Choice_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Choice_id;?>','<?php echo $row->Name_of_option; ?>','','Survey/delete_multi_choice/?choiceId');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->Name_of_option;?></td>
								<td><?php echo $row->Number_of_option;?></td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<!--------------Table--------------->
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$("#Register").click(function ()  
{
	
});
function readImage(input,div_id) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result)
				.height(100);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>