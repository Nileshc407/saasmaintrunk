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
				EDIT MERCHANDISE PARTNER
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
					echo form_open_multipart('CatalogueC/Edit_Merchandize_Partners',$attributes); ?>
				<div class="row">
					<div class="col-sm-6">	
					<div class="form-group">
					<label for=""> <span class="required_info">* </span> Company Name </label>
					<select class="form-control" name="Company_id"  id="Company_id" required="required">

					 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
					</select>
					</div>		  		
								 
				  
				  <div class="form-group">
					<label for=""> <span class="required_info">*</span> Partner Name </label>								
					<input class="form-control"  name="Partner_name" id="Partner_name"  type="text" placeholder="Enter Partner Name"  required="required" data-error="Please enter partner name" value="<?php echo $Partner_Row->Partner_name;?>">
					<div class="help-block form-text with-errors form-control-feedback" id="pname"></div>
				  </div> 
				  	
					<div class="form-group">
						<label for="">Shipping Partner</label>
						<label class="radio-inline">
						<input type="radio" name="Partner_type" value="4" <?php if($Partner_Row->Partner_type==4){ echo "checked";}?> >Yes</label>
						<label class="radio-inline">
						<input type="radio" name="Partner_type" value="1"  <?php if($Partner_Row->Partner_type==1){ echo "checked";}?> >No
						</label>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
						  
				   
					   <div class="form-group">
						<label for=""> <span class="required_info">*</span> Partner Address </label>								
						<textarea class="form-control"  name="Partner_address" id="Partner_address"  placeholder="Enter Partner Address"  required="required" data-error="Please enter address"> <?php echo $Partner_Row->Partner_address;?> </textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div> 
					  
						<div class="form-group">
						<label for=""><span class="required_info">* </span>Country</label>
						<select class="form-control" name="country" id="country" required="required" onchange="Get_states(this.value);" data-error="Please select country">
						<option value="">Select Country</option>
						<option value="101">India</option>
						 <?php 
							foreach($Country_array as $Country)
							{?>
								<option value="<?php echo $Country['id'];?>" <?php if($Partner_Row->Country_id == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>
							<?php }
						?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
				  
					  <div class="form-group" id="Show_States">
						<label for="">State</label>
						<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);" data-error="Please select state">
						<?php 
							foreach($States_array as $rec)
							{?>
								<option value="<?php echo $rec->id;?>" <?php if($Partner_Row->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
							<?php }
						?>			
						</select>
						
					  </div> 

					  <div class="form-group" id="Show_Cities">
						<label for="">City</label>
						<select class="form-control" name="city" id="city" data-error="Please select city">
						<?php 
							foreach($City_array as $rec)
							{?>
								<option value="<?php echo $rec->id;?>" <?php if($Partner_Row->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
							<?php }
						?>
						</select>
					  </div> 
					</div>
					<div class="col-sm-6">	
						<div class="form-group">
								<label for=""><span class="required_info">* </span>Contact Person Name</label>
								<input type="text" class="form-control" name="Partner_contact_person_name" id="Partner_contact_person_name" data-error="Please enter name" placeholder="Enter Contact Person Name" required="required"  value="<?php echo $Partner_Row->Partner_contact_person_name;?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						<div class="form-group">
								<label for=""><span class="required_info">* </span>Phone Number</label>
								<input type="text" class="form-control" name="Partner_contact_person_phno" id="Partner_contact_person_phno" data-error="Please enter phone number" placeholder="Enter Phone Number" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Partner_Row->Partner_contact_person_phno;?>">
								<div class="help-block form-text with-errors form-control-feedback" id="phno_err"></div>
						</div>	
						<div class="form-group">
								<label for=""><span class="required_info">* </span>Email Address </label>
								<input type="email" class="form-control" name="Partner_contact_person_email" id="Partner_contact_person_email" data-error="Please enter email" placeholder="Enter Contact Person Email" required="required" value="<?php echo $Partner_Row->Partner_contact_person_email;?>">
								<div class="help-block form-text with-errors form-control-feedback" id="emailErr"></div>
						</div>
						<div class="form-group">
							<label for="">Website </label>
							<input type="text" class="form-control" name="Partner_website" id="Partner_website"  placeholder="Enter Website" value="<?php echo $Partner_Row->Partner_website;?>">
						</div>
						<div class="form-group">
						<?php 

							if($Partner_Row->Partner_logo == ""){ ?>
							<img id="blah" src="http://demo2.igainspark.com/images/no_image.jpeg" class="img-responsive left-block" alt="<?php echo $Partner_Row->Partner_name; ?> Photograph" style="width:150px; height:160px;">
						<?php } else {  ?>
							<img id="blah" src="<?php echo base_url().$Partner_Row->Partner_logo; ?>" class="img-responsive left-block" alt="<?php echo $Partner_Row->Partner_name; ?> Photograph" style="width:150px; height:160px;">
						<?php } ?>
									
						<label for="">Upload Partner Logo<br><font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font> </label>
							<div class="upload-btn-wrapper">
							<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
							<input type="file" name="file" id="file" onchange="readURL(this);" />
							</div>
						</div>
						<div class="form-group">
								<label for=""><span class="required_info">* </span>VAT</label>
								<input type="text" class="form-control" name="Partner_vat" id="Partner_vat" data-error="Please enter vat" onkeypress="return isNumberKey2(event)" placeholder="Enter VAT" required="required" value="<?php echo $Partner_Row->Partner_vat;?>"  onchange="javascript:Set_ratio();" data-content="If you Modify the VAT/Markup Percentage, it will Update the Points Value for all the Merchandizing Items of the Company !." data-toggle="popover" data-placement="top" title="Application Information">
								<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						<div class="form-group">
								<label for=""><span class="required_info" style="color:red;">* </span>Set Markup Percentage</label>
								<input type="text" class="form-control" name="Partner_markup_percentage" id="Partner_markup_percentage" data-error="Please enter partner markup percentage" onkeypress="return isNumberKey2(event)" placeholder="Enter Markup Percentage" required="required" value="<?php echo $Partner_Row->Partner_markup_percentage;?>"  onchange="javascript:Set_ratio();"
								data-content="If you Modify the VAT/Markup Percentage, it will Update the Points Value for all the Merchandizing Items of the Company !." data-toggle="popover" data-placement="top" title="Application Information">
								
								<input type="hidden" value="0" id="Vat_margin_changed_flag" name="Vat_margin_changed_flag">	
								<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>

					</div>
				</div>
					<div class="form-buttons-w" align="center">
					
					<input type="hidden" name="Update_Partner_id" value="<?php echo $Partner_Row->Partner_id;?>">
					<input type="hidden" name="Partner_id" value="<?php echo $Partner_Row->Partner_id;?>">
					<input type="hidden" name="Partner_logo" value="<?php echo $Partner_Row->Partner_logo;?>">
					<input type="hidden" name="Update_user_id" value="<?php echo $enroll;?>">
					<input type="hidden" name="Update_date" value="<?php echo date("Y-m-d H:i:s");?>">
					
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
				   Merchandise Partners
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Partner Name</th>
							<th class="text-center">Partner Address</th>
							<th class="text-center">Contact Person Name</th>
							<th class="text-center">Phone Number</th>
							<th class="text-center">Email Address</th>		
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Partner Name</th>
							<th class="text-center">Partner Address</th>
							<th class="text-center">Contact Person Name</th>
							<th class="text-center">Phone Number</th>
							<th class="text-center">Email Address</th>
							</tr>
						</tfoot>		

						<tbody>
					<?php
						$todays = date("Y-m-d");
						
						if($Partner_Records != NULL)
						{
							foreach($Partner_Records as $row)
							{
							?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/CatalogueC/Edit_Merchandize_Partners/?Partner_id=<?php echo $row->Partner_id;?>" title="Edit">
										<i class="os-icon os-icon-ui-49"></i>
									</a>
									
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Partner_id;?>','<?php echo $row->Partner_name; ?>','Please Note that Merchandise Item linked to this Partner will be made inactive','CatalogueC/Delete_Merchandize_Partners/?Partner_id');" data-target="#deleteModal" data-toggle="modal"  title="Delete">
											<i class="os-icon os-icon-ui-15"></i>
									</a>
									
								</td>
								<td class="text-center"><?php echo $row->Partner_name; ?></td>
								<td><?php echo $row->Partner_address; ?></td>
								<td><?php echo $row->Partner_contact_person_name; ?></td>
								<td><?php echo $row->Partner_contact_person_phno; ?></td>
								<td><?php echo $row->Partner_contact_person_email; ?></td>
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
	if( $('#Company_id').val() != "" && $('#Partner_contact_person_email').val() != "" && $('#Partner_contact_person_name').val() != "" && $('#Partner_contact_person_phno').val() != ""  && $('#Partner_vat').val() != ""  && $('#Partner_markup_percentage').val() != ""   && $('#Partner_address').val() != "" )
	{
		show_loader();
	}
});

$('input[type=text]').on('blur', function (e){
	if(e.target.id == "Partner_markup_percentage" || e.target.id == "Partner_vat"){
		$('[data-toggle=popover]').each(function () {
			// hide any open popovers when the anywhere else in the body is clicked
			if ($('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	}
});

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(160);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

	$('#Partner_contact_person_phno').blur(function()
{
	if( $("#Partner_contact_person_phno").val() == "" )
	{
		//var msg1 = 'Please enter phone number';
		$('#phno_err').show();
		//$('#phno_err').html(msg1);
		$("#Partner_contact_person_phno").val("");
	}
	else
	{
		var Phone_no = $("#Partner_contact_person_phno").val();
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {Phone_no: Phone_no, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/CatalogueC/check_partner_phone_email",
			  success: function(data)
			  {
				if(data == 1)
				{
					$("#Partner_contact_person_phno").val("");
					var msg1 = 'Already exist';
					$('#phno_err').show();
					$('#phno_err').html(msg1);
					$("#Partner_contact_person_phno").addClass("form-control has-error");
					// setTimeout(function(){ $('#help-block1').hide(); }, 3000);
				}
				else
				{
					$("#Partner_contact_person_phno").removeClass("has-error");
					$("#phno_err").html("");
				}
			  }
		});
	}
});

$('#Partner_contact_person_email').blur(function()
{
	if( $("#Partner_contact_person_email").val() == "")
	{
		var msg1 = 'Please enter email id';
		$('#emailErr').show();
		$('#emailErr').html(msg1);
		$("#Partner_contact_person_email").val("");
	}
	else
	{
		var userEmailId = $("#Partner_contact_person_email").val();
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {userEmailId: userEmailId, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/CatalogueC/check_partner_phone_email",
			  success: function(data)
			  {
				if(data == 1)
				{
					$("#Partner_contact_person_email").val("");
					var msg1 = 'Already exist';
					$('#emailErr').show();
					$('#emailErr').html(msg1);
					$("#Partner_contact_person_email").addClass("form-control has-error");
					// setTimeout(function(){ $('#help-block2').hide(); }, 3000);
				}
				else
				{
					$("#Partner_contact_person_email").removeClass("has-error");
					$("#emailErr").html("");
				}
			  }
		});
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
function Set_ratio()
{
	document.getElementById('Vat_margin_changed_flag').value=1;
	//$("#Partner_markup_percentage").attr("data-toggle","popover");
}
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
	 // alert(State_id);
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