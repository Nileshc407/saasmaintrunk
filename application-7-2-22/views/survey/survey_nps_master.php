<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			SURVEY NPS MASTER
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
					} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
					<?php 	} ?>
					
					
					<?php
					$attributes = array('id' => 'formValidate');
					echo form_open('Survey/surveynpsmaster',$attributes); ?>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>NPS Type Name </label>
						<input class="form-control" type="text" name="nps_type_name" id="nps_type_name" placeholder="Enter nps type name" data-error="Please enter nps type name" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
					
					  <div class="form-group">
						<label><span class="required_info">* </span>Description</label>
						<textarea class="form-control" rows="3" name="description"  id="description" placeholder="Enter description" data-error="Please enter description" required="required" ></textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
						
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
						<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>"  class="form-control" />
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
			  </div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Survey NPS Type Details
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>NPS Type Name</th>
								<th>NPS Type Description</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>NPS Type Name</th>
								<th>NPS Type Description</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($Survey_NPS != NULL)
						{
							foreach($Survey_NPS as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Survey/edit_nps_survey/?NPS_type_id=<?php echo $row->NPS_type_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->NPS_type_id;?>','<?php echo $row->NPS_type_name; ?>','','Survey/delete_survey_nps_master/?Survey_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->NPS_type_name;?></td>
								<td><?php echo $row->NPS_type_description;?></td>
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
	if( $('#nps_type_name').val() != "" && $('#description').val() != "" )
	{
		show_loader();
		return true;
	}
});
$('#nps_type_name').blur(function()
{
	if( $("#nps_type_name").val() != "")
	{
		if($("#nps_type_name").val() == "")
		{
			$("#nps_type_name").val("");
			$("help-block1").html("Please enter nps type name");
			$("#nps_type_name").addClass("form-control has-error");
		}
		else
		{
			var nps_type_name = $("#nps_type_name").val();
			var Company_id ='<?php echo $Company_details->Company_id; ?>';
			$.ajax({
				type: "POST",
				data: {npstype_name: nps_type_name, Company_id: Company_id},
				url: "<?php echo base_url()?>index.php/Survey/check_survey_nps",
				success: function(data)
				{	
					if(data.length == 13)
					{							
						$("#nps_type_name").val("");
						$("#help-block1").html("Already exist");
						$("#nps_type_name").addClass("form-control has-error");
					}
					else
					{
						$("#nps_type_name").removeClass("has-error");
						$("#help-block1").html("");
					}
				}
			});
		}
	}
});	

/*
function delete_survey_nps_master(NPS_type_id,NPS_type_name,NPS_company_id)
{	
	BootstrapDialog.confirm("Are you sure to Delete the  "+NPS_type_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Survey/delete_survey_nps_master/?Survey_id='+NPS_type_id+'&companyID='+NPS_company_id;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		} 
	});
} */
</script>