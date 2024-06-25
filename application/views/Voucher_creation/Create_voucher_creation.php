<?php $this->load->view('header/header');
$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];
 ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Voucher_creation',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">CREATE VOUCHERS</h6>
					<div class="element-box">
					<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} ?>
							<div class="row">
								<div class="col-sm-6">										
								  <div class="form-group">
									<label for=""> Company Name</label>
									<select class="form-control" name="Company_id" id="Company_id" required="required">
									  <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
									</select>
								  </div>
								 <?php /* echo $VoucherType['Code_decode_id'] */ ?>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Voucher Type</label>
									<select class="form-control" name="Voucher_type" id="Voucher_type" data-error="Please select voucher type" required="required">
									<option value="">Select Voucher type</option>						
									<?php 
										$i=1;
										foreach($Voucher_type_code_decode as $VoucherType) { ?>
										<option value="<?php echo $i; ?>"><?php echo $VoucherType['Code_decode']; ?></option>
									<?php  $i++;
									}

									?>
										
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="MPartner_block1"  style="display:none;">
									<label for=""><span class="required_info">* </span>Link to Merchandize Partner</label>
									<select class="form-control" name="Merchandize_Partner_ID" id="Merchandize_Partner_ID" data-error="Please select merchandize partner">
									<option value="">Select merchandize partner</option>
									  <?php
										foreach($Partner_Records as $Partner)
										{
											echo '<option value="'.$Partner->Partner_id.'">'.$Partner->Partner_name.'</option>';
										}
										?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Voucher Code</label>
									<input type="text" class="form-control" name="Voucher_code" id="Voucher_code" data-error="Please enter voucher code" placeholder="Enter voucher code" required="required">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								  </div> 
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Voucher Name</label>
									<input type="text" class="form-control" name="Voucher_name" id="Voucher_name" data-error="Please enter Voucher name" placeholder="Enter Voucher name" required="required"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label>Voucher Information</label>
									<textarea class="form-control" rows="3" name="Voucher_description"  id="Voucher_description" placeholder="Enter Voucher description"></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>					  
								</div>	
								
								<div class="col-sm-6">
								   <div class="form-group">
								   <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="Valid_from" id="datepicker1" data-error="Please select from date" required="required"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="Valid_till" id="datepicker2" data-error="Please select till date" required="required"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								<div class="form-group" id="Voucher_issuance_type_div">
									<label for="">Voucher Issuance Type</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="Voucher_issuance_type" id="Voucher_issuance_type" onclick="Change_discount_value(1);" value="1" data-error="Please select voucher issuance type">Percentage (%)</label>
									  </div>									  
									  <div class="form-check" style="margin-left:130px;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="Voucher_issuance_type" id="Voucher_issuance_type" onclick="Change_discount_value(2);" value="2" data-error="Please select voucher issuance Type">Value</label>
									  </div> 
									</div>
									 <div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								  
								<div class="form-group"  id="Item_block" >
										<label for=""><span class="required_info" >* </span>Select POS Item</label>
										
										<select class="form-control select2" multiple="true" name="POS_item[]" id="POS_item"  data-error="Please select POS Item" >
										<!--<option value="">Select POS Item</option>-->
										  <?php
												foreach($Voucher_item as $Vitem) {
													echo'<option value="'.$Vitem['Company_merchandise_item_id'].'">'.$Vitem['Merchandize_item_name'].'</option>';
												}
											?>	
										</select>										
										<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div id="Discunt_block">
									<div class="form-group">
										<label for="">Discount (In %)</label>
										<input class="form-control"  placeholder="Enter discunt in percentage"  type="text" name="Discount_percentage" id="Discount_percentage" onkeypress="return isNumberKey2(event);" onchange="return onlyNumber(this.value)" data-error="Please enter valid discunt in percentage"/>									
										
										<div class="help-block form-text with-errors form-control-feedback" id="help-blockD"></div>
										
									</div>								
								</div>
								<div id="Price_block">
									<div class="form-group">
										<label for="">Price of Voucher</label>
										<input class="form-control"  placeholder="Enter Price of Voucher"  type="text" name="Cost_price" id="Cost_price" onkeypress="return isNumberKey2(event);" data-error="Please enter price of voucher" onchange="Get_Calculation_points(this.value)"/>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group">
										<div class="form-group">
											<label for="">Redeemable <?php echo $Company_details->Currency_name; ?></label>
											<input class="form-control" type="text" name="Points" id="Points" readonly>
										</div>
									</div>
								
								</div>
								
								 
									
								<div class="form-group">
									<label for="">Status</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="show_item" id="show_item"  value="1"  checked>Enable</label>
									  </div>									  
									  <div class="form-check" style="margin-left:90px;">
										<label class="form-check-label">
										<input class="form-check-input" type="radio" name="show_item" id="show_item" value="0">Disable</label>
									  </div> 
									</div>
								  </div>
								</div>
								
							</div>
							<fieldset class="form-group">
								<legend><span>Upload Images of Voucher  <font color="RED" align="center" size="0.8em"><i>&nbsp;&nbsp;&nbsp;&nbsp;Image Resolution should be above 800(Horizontal) X 800(Vertical)  for best product view</i></font></span></legend>
								<div class="row">
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Voucher image-1</strong></p></div>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image1" class="img-responsive" style="width: 50%;">									
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file1" id="file1" onchange="readImage(this,'#no_image1');" style="width: 100%;"/>
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
												
											</div>
										</div>
									</div>									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Voucher image-2</strong></p></div>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image2" class="img-responsive" style="width: 50%;">											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file2"  id="file2" onchange="readImage(this,'#no_image2');" style="width: 100%;" />
													<div class="help-block form-text with-errors form-control-feedback"></div>
												</div>
											</div>
										</div>
									</div>									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Voucher image-3</strong></p></div>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image3" class="img-responsive" style="width: 50%;">
											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file3" onchange="readImage(this,'#no_image3');" style="width: 100%;" />
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xs-6 col-sm-3">
										<div class="thumbnail">
											<div class="caption"><p class="text-center"><strong>Voucher image-4</strong></p></div>
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image4" class="img-responsive" style="width: 50%;">
											
											<div class="caption">
												<div class="form-group upload-btn-wrapper">
													<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
													<input type="file" name="file4" onchange="readImage(this,'#no_image4');" style="width: 100%;" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</fieldset>	
								<?php if($_SESSION['Privileges_Add_flag']==1){ ?>
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
						  </div>
						  <?php } ?>
					</div>
				</div>
				<?php echo form_close(); ?>	
				
				<!--------------Table Active Voucher------------->	
<?php if($_SESSION['Privileges_View_flag']==1){ ?>				
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Active Voucher
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Voucher Type</th>
									<th>Voucher Code</th>
									<th>Voucher Name</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Voucher Type</th>
									<th>Voucher Code</th>
									<th>Voucher Name</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
					
							if($ActiveVoucher_Records != NULL)
							{
								foreach($ActiveVoucher_Records as $row)
								{
									$Todays_date=date("Y-m-d");
									$Color="";
									$Status="<font color='red'>Disable</font>";
									
									if($Todays_date >= $row['Valid_from'] && $Todays_date <= $row['Valid_till'])
									{
										$Color="green";
									}
									if($row['Active_flag']==1)
									{
										$Status="<font color='green'>Enable</font>";
									}
									
									if($row['Voucher_type']==1){
										$Voucher_type='Revenue Voucher';
									} else if($row['Voucher_type']==2){
										$Voucher_type='Product Voucher';
									} else if($row['Voucher_type']==3){
										$Voucher_type='Discount Voucher';
									}
									
									
							?>
								<tr>
									<td class="row-actions">
										<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Voucher_creation/Edit_voucher/?Voucher_id=<?php echo $row['Voucher_id'];?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row['Voucher_id'];?>','<?php echo $row['Voucher_name']; ?>','','Voucher_creation/InActive_voucher/?Voucher_id');"  data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $Voucher_type; ?></td>
									<td><?php echo $row['Voucher_code']; ?></td>
									<td><?php echo $row['Voucher_name'];?></td>
									<td><?php echo "<font color=".$Color.">".date('d M,Y H:i:s A',strtotime($row['Valid_from'])).' - '.date('d M,Y H:i:s A',strtotime($row['Valid_till']))."</font>"; ?></td>
									<td><?php echo $Status;?></td>
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table Active Voucher--------------->
				
				<!--------------Table In Active Voucher------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  In Active Voucher
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Voucher Type</th>
									<th>Voucher Code</th>
									<th>Voucher Name</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Voucher Type</th>
									<th>Voucher Code</th>
									<th>Voucher Name</th>
									<th>Validity</th>
									<th>Status</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($InActiveVoucher_Records != NULL)
							{
								foreach($InActiveVoucher_Records as $inrow)
								{
									$Todays_date=date("Y-m-d");
									$Color="";
									$Status="<font color='red'>Disable</font>";
									
									if($Todays_date >= $inrow['Valid_from'] && $Todays_date <= $inrow['Valid_till'])
									{
										$Color="green";
									}
									if($inrow['Active_flag']==1)
									{
										$Status="<font color='green'>Enable</font>";
									}
									
									if($inrow['Voucher_type']==1){
										$Voucher_type='Revenue Voucher';
									} else if($inrow['Voucher_type']==2){
										$Voucher_type='Product Voucher';
									} else if($inrow['Voucher_type']==3){
										$Voucher_type='Discount Voucher';
									}
									
									
							?>
								<tr>
									<td class="row-actions">
									<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Voucher_creation/Edit_voucher/?Voucher_id=<?php echo $inrow['Voucher_id'];?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $inrow['Voucher_id'];?>','<?php echo $inrow['Voucher_name']; ?>','','Voucher_creation/InActive_voucher/?Voucher_id');"  data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $Voucher_type; ?></td>
									<td><?php echo $inrow['Voucher_code']; ?></td>
									<td><?php echo $inrow['Voucher_name'];?></td>
									<td><?php echo "<font color=".$Color.">".date('d M,Y H:i:s A',strtotime($inrow['Valid_from'])).' - '.date('d M,Y H:i:s A',strtotime($inrow['Valid_till']))."</font>"; ?></td>
									<td><?php echo $Status;?></td>
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div> 
				<?php } ?>
				<!--------------Table In Active Voucher--------------->
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
$(document).ready(function() {
	$('table#dataTable2').DataTable();
});
/**********Get Partner details***********************/
	var Company_id = '<?php echo $Company_id; ?>';

	$('#Voucher_type').change(function()
	{
		var Voucher_type= $('#Voucher_type').val();
		
		if(Voucher_type==1)
		{
			$("#Cost_price").attr("required","required");	
			$("#POS_item").removeAttr("required"); 	
			$("#Discount_percentage").removeAttr("required"); 	
			$("#Voucher_issuance_type").removeAttr("required");
			$("#Merchandize_Partner_ID").attr("required","required");		
			
		} 
		else if(Voucher_type==2)
		{
			$("#Cost_price").attr("required","required");	
			$("#POS_item").attr("required","required");
			$("#Discount_percentage").removeAttr("required"); 	
			$("#Voucher_issuance_type").removeAttr("required"); 
			$("#Merchandize_Partner_ID").removeAttr("required");
		} 
		else if(Voucher_type==3)
		{
			$("#Voucher_issuance_type").attr("required","required");
			$("#Discount_percentage").attr("required","required");
			$("#Cost_price").removeAttr("required"); 
			$("#POS_item").removeAttr("required"); 
			$("#Merchandize_Partner_ID").removeAttr("required");
		}		
		
		if(Voucher_type==1)
		{			
			$("#Price_block").css("display","");
			$("#Item_block").css("display","none");
			$("#Discunt_block").css("display","none");
			$("#Voucher_issuance_type_div").css("display","none");
			$("#MPartner_block1").show();
		} 
		else if(Voucher_type==2) 
		{
			$("#Price_block").css("display","");
			$("#Item_block").css("display","");
			$("#Discunt_block").css("display","none");
			$("#Voucher_issuance_type_div").css("display","none");
			$("#MPartner_block1").hide();
		}
		else if(Voucher_type==3) 
		{
			$("#Voucher_issuance_type_div").css("display","");
			$("#Discunt_block").css("display","");
			$("#Item_block").css("display","none");
			$("#Price_block").css("display","");
			$("#MPartner_block1").hide();
		}
	});
	function Change_discount_value(InputType){
		
		// console.log("---InputType---"+InputType);
		
		
		if(InputType==1){			
			
			$("#Cost_price").removeAttr("required"); 	
			$("#Discount_percentage").attr("required","required");
		} else if(InputType==2) {
			
			$("#Cost_price").attr("required","required");	
			$("#Discount_percentage").removeAttr("required"); 	
		}		
		if(InputType==1){			
			
			$("#Price_block").css("display","none");
			$("#Discunt_block").css("display","");
			
		} else if(InputType==2) {
			
			$("#Price_block").css("display","");			
			$("#Discunt_block").css("display","none"); 
			
		}
	}
	
	
	/*
	$('#Register').click(function()
	{         
		
	
		 if( $('#Company_id').val() != "" && $('#Voucher_type').val() != "" && $('#Voucher_code').val() != "" && $('#Voucher_name').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $('#show_item').val() != ""){
			
			show_loader();
			return true;
		} else {
			alert('All fields should not be blank');
			return false;
		}  
		// return false;
		
		
	}); */
	
	/* function formValidate(){
		var Voucher_type= $('#Voucher_type').val();
		// console.log("---Voucher_type-----"+Voucher_type);
		
		return true;
	} */

	
	function isNumberKey2(evt)
	{
	  var charCode = (evt.which) ? evt.which : event.keyCode
	// alert(charCode);
	  if (charCode != 46 && charCode > 31 
		&& (charCode < 48 || charCode > 57))
		 return false;

	  return true;
	}
	function onlyNumber(input)
	{
		
		var inputDis= parseFloat(input);
		console.log(inputDis);
	  if( (inputDis <= 0 ) || (inputDis > 100 ) ){
		  
		  $("#Discount_percentage").val("");					
			$("#help-blockD").html("Please enter valid discount in percentage");
			$("#Discount_percentage").addClass("form-control has-error");
			 return false;
	  }
		

	  return true;
	}	
	function Get_Calculation_points(cost)
	{
		var Redemptionratio = '<?php echo $Redemptionratio; ?>';
		/* alert(cost);
		alert(Redemptionratio);
		alert(Redemptionratio * cost); */
		var total1 =(parseFloat(Redemptionratio) * parseFloat(cost)).toFixed(0);
		// alert(total1);
		var total12 =Math.round(total1);
		$("#Points").val(total12);
	}

	
	
	
	
	
	
	
	$('#Voucher_code').blur(function()
	{
		if( $("#Voucher_code").val()  == "" )
		{
			$("#Voucher_code").val("");					
			$("#help-block1").html("Please enter voucher code");
			$("#Voucher_code").addClass("form-control has-error");
		}
		else
		{
			var Voucher_code = $("#Voucher_code").val();
			var Company_id = '<?php echo $Company_id; ?>';
			//alert(Branch_code);
			$.ajax({
				  type: "POST",
				  data: {Voucher_code: Voucher_code, Company_id: Company_id},
				  url: "<?php echo base_url()?>index.php/Voucher_creation/Check_voucher_code",
				  success: function(data)
				  {
						console.log(data);
						if(data == 1)
						{
												
							$("#Voucher_code").val("");					
							$("#help-block1").html("Already exist");
							$("#Voucher_code").addClass("form-control has-error");
						}
						else
						{
							$("#Voucher_code").removeClass("has-error");
							$("#help-block1").html("");
							
						}
				  }
			});
		}
	});
	
	

		
/**********calender*********/
	$(function() 
	{
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+2",
			changeYear: true
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+2",
			changeYear: true
		});
			
	});
/*********calender*********/
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
<style>
.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
.thumbnail>img 
{
    margin-right: auto;
    margin-left: auto;
}
.img-responsive, .thumbnail>img {
    display: block;
    max-width: 100%;
    height: auto;
}
</style>