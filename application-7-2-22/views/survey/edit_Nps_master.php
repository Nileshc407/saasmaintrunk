<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT NPS MASTER
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
					echo form_open('Survey/update_npsmaster',$attributes); ?>
						<div class="form-group">
							<label for=""><span class="required_info">* </span>Nps Type</label>
							<select class="form-control" name="Npstype" id="Npstype" data-error="Please select nps type" required="required">
							<?php
								if($NPS_Type != NULL)
								{
									foreach($NPS_Type as $row1)
									{
										$NPS_type_id = $row1->NPS_type_id;
										if($NPS_type_id == $NPS_master_details->NPS_type_id) 
										{
											$NPS_type_id=$row1->NPS_type_id;
											$NPS_type_name=$row1->NPS_type_name;
										}
									}		?>		
									<option value="<?php echo $NPS_type_id; ?>"><?php echo $NPS_type_name; ?> </option>
						<?php	
								}	?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>NPS Dictionary Name </label>
						<input class="form-control" type="text" name="NPS_dictionay_name" id="NPS_dictionay_name" placeholder="Enter nps dictionary name" data-error="Please enter nps dictionary name" value="<?php echo $NPS_master_details->NPS_dictionay_name ?>" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
					  </div> 
					
					  <div class="form-group">
						<label><span class="required_info">* </span>NPS Dictionary Keywords</label> <span class="required_info">(keywords separated by comma)</span>
						<textarea class="form-control" rows="3" name="NPS_dictionary_keywords"  id="NPS_dictionary_keywords" data-error="Please enter dictionary keywords" placeholder="Enter nps dictionary keywords" required="required" ><?php echo $NPS_master_details->NPS_dictionary_keywords ; ?></textarea>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
					  </div> 
					  <div class="form-group">
						<label><span class="required_info">* </span>Description</label>
						<textarea class="form-control" rows="3" name="description" id="description" data-error="Please enter description" placeholder="Enter description" required="required" ><?php echo $NPS_master_details->NPS_dictionary_description ; ?></textarea>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block4"></div>
					  </div>
						
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					  <input type="hidden" name="Company_id" value="<?php echo $NPS_master_details->NPS_Company_id ?>"  class="form-control"  />
						<input type="hidden" name="NPS_id" value="<?php echo $NPS_master_details->NPS_id ?>"  class="form-control"  />
					<?php echo form_close(); ?>		  
				  </div>
			  </div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   NPS Master
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>NPS Dictionary Name</th>
								<th>NPS Dictionary Keywords</th>
								<th>Description</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>NPS Dictionary Name</th>
								<th>NPS Dictionary Keywords</th>
								<th>Description</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($NPS_master != NULL)
						{
							foreach($NPS_master as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Survey/edit_nps_master/?NPS_id=<?php echo $row->NPS_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->NPS_id;?>','<?php echo $row->NPS_dictionay_name; ?>','','Survey/delete_nps_master/?NPS_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->NPS_dictionay_name;?></td>
								<td><?php echo $row->NPS_dictionary_keywords;?></td>
								<td><?php echo $row->NPS_dictionary_description;?></td>
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
	if( $('#Npstype').val() != "" && $('#NPS_dictionay_name').val() != "" && $('#NPS_dictionary_keywords').val() != "" && $('#description').val() != "" )
	{
		show_loader();
		return true;
	}
});

$('#Npstype').on('change', function() 
{
	if( $("#Npstype").val() != "")
	{
		if($("#Npstype").val() == "")
		{
			$("#Npstype").val("");	
			$("#Npstype").addClass("form-control has-error");			
			$("help-block1").html("Please select nps type");
		}
		else
		{
			var Npstype = $("#Npstype").val();
			
			var Company_id ='<?php echo $Company_details->Company_id; ?>';
			
			$.ajax({
				type: "POST",
				data: {Npstype: Npstype, Company_id: Company_id},
				url: "<?php echo base_url()?>index.php/Survey/check_nps_master_type",
				success: function(data)
				{	
					alert(data.length);
					if(data.length == 13)
					{							
						$("#Npstype").val("");
						$("#Npstype").addClass("form-control has-error");
						$("#help-block1").html("Already exist");
					}
					else
					{
						$("#Npstype").removeClass("has-error");
						$("#help-block1").html("");
					}
				}
			});
		}
	}
});
$('#NPS_dictionay_name').blur(function()
{
	if( $("#NPS_dictionay_name").val() != "")
	{
		if($("#NPS_dictionay_name").val() == "")
		{
			$("#NPS_dictionay_name").val("");
			$("#NPS_dictionay_name").addClass("form-control has-error");			
			$("help-block2").html("Please enter nps dictionary name");
		}
		else
		{
			var NPS_dictionay_name = $("#NPS_dictionay_name").val();
			
			var Company_id ='<?php echo $Company_details->Company_id; ?>';
			
			$.ajax({
				type: "POST",
				data: {NPS_dictionay_name: NPS_dictionay_name, Company_id: Company_id},
				url: "<?php echo base_url()?>index.php/Survey/check_nps_master",
				success: function(data)
				{	
					// alert(data.length);
					if(data.length == 13)
					{							
						$("#NPS_dictionay_name").val("");
						$("#NPS_dictionay_name").addClass("form-control has-error");			
						$("#help-block2").html("Already exist");
					}
					else
					{
						$("#NPS_dictionay_name").removeClass("has-error");
						$("#help-block2").html("");
					}
				}
			});
		}
	}
});
	
$('#Npstype').change(function()
{
	if( $("#Npstype").val() != "")
	{
		if($("#Npstype").val() == "")
		{
			$("#Npstype").val("");
			$("#Npstype").addClass("form-control has-error");			
			$("help-block1").html("Please select nps type");
		}
		else
		{
			var Npstype = $("#Npstype").val();
			
			var Company_id ='<?php echo $Company_details->Company_id; ?>';
			
			$.ajax({
				type: "POST",
				data: {Npstype: Npstype, Company_id: Company_id},
				url: "<?php echo base_url()?>index.php/Survey/check_nps_type",
				success: function(data)
				{	
					// alert(data.length);
					if(data.length == 13)
					{							
						$("#Npstype").val("");
						$("#Npstype").addClass("form-control has-error");
						$("#help-block1").html("Already exist");
					}
					else
					{
						$("#Npstype").removeClass("has-error");
						$("#help-block1").html("");
					}
				}
			});
		}
	}
});
	
function delete_nps_master(NPS_id,NPS_dictionay_name,NPS_Company_id)
{	
	BootstrapDialog.confirm("Are you sure to Delete the  "+NPS_dictionay_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Survey/delete_nps_master/?NPS_id='+NPS_id+'&companyID='+NPS_Company_id;
		if (result == true)
		{
			//show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		} 
	});
} 
</script>