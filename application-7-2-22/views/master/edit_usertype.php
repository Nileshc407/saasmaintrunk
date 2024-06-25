<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT USER TYPE
			  </h6>
				<div class="element-box panel">
				  <div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					}
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
					
					<?php  $attributes = array('id' => 'formValidate');
					echo form_open('Masterc/update_usertype',$attributes); ?>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>User Type</label>
						<input class="form-control" type="text" name="User_type" id="User_type" placeholder="Enter user type" data-error="Please enter user type" value="<?php echo $results->User_type; ?>" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block"></div>
					  </div> 
					  
					  <div class="form-group">
						<label><span class="required_info">* </span>User Description</label>
						<textarea class="form-control" rows="3" name="User_description" id="User_description" placeholder="Enter user description" data-error="Please enter user description" required="required"><?php echo $results->User_description; ?></textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
						<input type="hidden" name="User_id" value="<?php echo $results->User_id; ?>" />
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
				</div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   User Type Details
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>User Type</th>
								<th>User Type Description</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>ID</th>
								<th>User Type</th>
								<th>User Type Description</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results2 != NULL)
						{
							foreach($results2 as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Masterc/edit_usertype/?usertype=<?php echo $row->User_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								<td><?php echo $row->User_id;?></td>
								<td><?php echo $row->User_type;?></td>
								<td><?php echo $row->User_description;?></td>
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
$('#Register').click(function()
{ 
	if( $('#User_type').val() != "" && $('#User_description').val() != "" )
	{
		show_loader();
		return true;
	}
});

$('#User_type').blur(function()   
{	
	if($("#User_type").val() == "")
	{
		var msg = 'Please enter user type';
		$('#help-block').show();
		$('#help-block').html(msg);
		$("#User_type").addClass("form-control has-error");
		return false;
	}
	else
	{
		var User_Type = $("#User_type").val();
		$.ajax({
			type: "POST",
			data: {User_Type: User_Type},
			url: "<?php echo base_url()?>index.php/Masterc/check_usertype",
			success: function(data)
			{
				if(data== 1)
				{
					$("#User_type").val("");
					$('#help-block').show();
					$('#help-block').html("Already exist");
					$("#User_type").addClass("form-control has-error");
				}
				else
				{
					$("#User_type").removeClass("has-error");
					$("#help-block").html("");
				}	
			}
		});
	}	
});
</script>