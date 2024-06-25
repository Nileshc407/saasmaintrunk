<?php 
$this->load->view('header/header');
$todays = date("Y-m-d");
 ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				CREATE MERCHANDISE PARTNER BRANCH
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
				<?php $this->session->unset_userdata('success_code'); $this->session->unset_userdata('data_code');
				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('error_code');
						$this->session->unset_userdata('data_code');
				} ?>
				
				
				<?php  $attributes = array('id' => 'formValidate');
					echo form_open_multipart('CatalogueC/Create_Merchandize_Partner_Branch',$attributes); ?>
				<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Partner Name </label>
						<select class="form-control" name="Partner_id"  id="Partner_id" required="required">

							<option value="">Select Partner</option>
							<?php
								foreach($Partner_Records as $Partners)
								{
									if($Partners->Partner_type!=4)//Not Shipping Partner
									{
										echo '<option value="'.$Partners->Partner_id.'">'. $Partners->Partner_name.'</option>';
									}
									
								}
							?>
						</select>
						</div>		  		

						<div class="form-group">
							<label for=""><span class="required_info">* </span> Branch Code</label>
							<input type="text" class="form-control" name="Branch_code" id="Branch_code" data-error="Please enter branch code" placeholder="Enter Contact Branch Code" required="required">
							<div class="help-block form-text with-errors form-control-feedback" id="brCode"></div>
						</div>
						<div class="form-group">
							<label for=""><span class="required_info">* </span> Branch Name</label>
							<input type="text" class="form-control" name="Branch_name" id="Branch_name" data-error="Please enter branch name" placeholder="Enter Contact Branch Name" required="required">
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					   <div class="form-group">
						<label for=""> <span class="required_info">*</span> Branch Address </label>								
						<textarea class="form-control"  name="Branch_address" id="Branch_address"  placeholder="Enter Branch Address"  required="required" data-error="Please enter address"></textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div> 

					</div>
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""><span class="required_info">* </span>Country</label>
						<select class="form-control" name="country" id="country" required="required" onchange="Get_states(this.value);" data-error="Please select country">
						<option value="">Select Country</option>
						<option value="101">India</option>
						  <?php
							foreach($Country_array as $Country)
							{
								echo "<option value=".$Country['id'].">".$Country['name']."</option>";
							}
							?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
				  
					  <div class="form-group" id="Show_States">
						<label for="">State</label>
						<select class="form-control" name="state"  id="state" onchange="Get_cities(this.value);">
							<option value="">Select Country first</option>				
						</select>
						
					  </div> 

					  <div class="form-group" id="Show_Cities">
						<label for="">City</label>
						<select class="form-control" name="city" id="city">
						<option value="">Select State first</option>
						</select>

					  </div> 
					  
						<div class="form-group">
							<label for=""> Zip/Postal Code/P.O Box</label>
							<input type="text" class="form-control" name="zip" id="zip" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" placeholder="Enter Contact Branch Code" data-error="Please enter Zip/Postal code">
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					</div>
				</div>
					<div class="form-buttons-w" align="center">
					<input type="hidden" name="Create_user_id" value="<?php echo $enroll;?>">
					<input type="hidden" name="Create_date" value="<?php echo date("Y-m-d H:i:s");?>">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
					</div>
					<?php echo form_close(); ?>		  
			</div>			
			</div>
			
			<!-------------------- START - Data Table -------------------->
	           
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Merchandise Partner Branches
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Partner Name</th>
							<th class="text-center">Branch Code</th>
							<th class="text-center">Branch Name</th>
							<th class="text-center">Branch Address</th>		
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Partner Name</th>
							<th class="text-center">Branch Code</th>
							<th class="text-center">Branch Name</th>
							<th class="text-center">Branch Address</th>
							</tr>
						</tfoot>		

						<tbody>
					<?php
						if($Partner_Branch_Records != NULL)
						{
							foreach($Partner_Branch_Records as $row)
							{
							?>
								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/CatalogueC/Edit_Merchandize_Partner_Branch/?Branch_id=<?php echo $row->Branch_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Branch_id;?>','<?php echo $row->Branch_name; ?>','Please note that there Merchandise Items linked to one or more Merchandise Partner branches. Well, if The Merchandise Item is linked to just one branch then that Merchandise Item will be Inactive ( when the Partner branch is deleted) . But if a Merchandise Item is linked to multiple Partner branches then only Merchandise Item linked to that Branch which is deleted will not be available in future.','CatalogueC/Delete_Merchandize_Partners_Branch/?Branch_id');" data-target="#deleteModal" data-toggle="modal" title="Delete">
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									<td><?php echo $row->Partner_name; ?></td>
									<td class="text-center"><?php echo $row->Branch_code; ?></td>
									
									<td><?php echo $row->Branch_name; ?></td>
									<td><?php echo $row->Address; ?></td>
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
<script>

$('#Register').click(function()
{
	
	if( $('#Partner_id').val() != "" && $('#Branch_code').val() != "" && $('#Branch_name').val() != "" && $('#Branch_address').val() != ""  && $('#country').val() != "" && $("#zip").val() != "" )
	{
		show_loader();
	}
});

function isNumberKey2(evt)
{
	
  var charCode = (evt.which) ? evt.which : event.keyCode
// alert(charCode);
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

	$('#Branch_code').blur(function()
	{
		//alert();
		if( $("#Branch_code").val()  == "" )
		{
			$('#brCode').show();
			$('#brCode').html("Please enter branch code");
		}
		else
		{
			var Branch_code = $("#Branch_code").val();
			var Company_id = '<?php echo $Company_id; ?>';
			//alert(Branch_code);
			$.ajax({
				  type: "POST",
				  data: {Branch_code: Branch_code, Company_id: Company_id},
				  url: "<?php echo base_url()?>index.php/CatalogueC/Check_Branch_Code",
				  success: function(data)
				  {
					  //alert(data.length);
						if(data.length == 13)
						{
							$('#Branch_code').val('');

							$("#Branch_code").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#brCode').show();
							$('#brCode').html(msg1);
						}
						else
						{
							$('#brCode').html("");
							$("#Branch_code").removeClass("has-error");	
						}
					
						
				  }
			});
		}
	});
		
/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	 //alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Company/Get_states",
		success: function(data)
		{
			// alert(data.States_data);
			$("#Show_States").html(data.States_data);	
			
		}
	});
}
function Get_cities(State_id)
{
	
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Company/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			
		}
	});
}
/************************************************************************/
</script>