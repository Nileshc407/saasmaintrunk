<?php 
$this->load->view('header/header');
$Conversion_INR = $this->Saas_model->convert_currency('INR');
// echo $Conversion_INR;
// $Conversion_INR= $oxr_latest->rates->INR;
// You can now access the rates inside the parsed object, like so:
/* printf(
    "1 %s equals %s INR at %s",
    $oxr_latest->base,
    $oxr_latest->rates->INR,
    date('H:i jS F, Y', $oxr_latest->timestamp)
); */
// -> eg. "1 USD equals: 0.656741 GBP at 11:11, 11th December 2015"
	// die;s
if($Records->Country_id==101)//India
{
	$Monthly_Price = $Indian_monthly_price;
}
// echo $Company_License_type.'<br>';
if($Company_License_type==121)//Basic
{
	$_SESSION["Expiry_license"]=date('Y-m-d');
}
// echo $Conversion_INR;
// echo $_SESSION["Expiry_license"];
 ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Billing Information</h6>
                    <div class="element-box">
					<!--
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
-->
                        <?php 
                          $attributes = array('id' => 'formValidate');
                          echo form_open_multipart('Register_saas_company/License_billing', $attributes); 
                        ?>
						<input type="hidden" id="Conversion_INR" name="Conversion_INR" value="<?php echo $Conversion_INR ;?>">
						<input type="hidden" id="Bill_amount" name="Bill_amount" value="0">
						<input type="hidden" id="Period" name="Period" value="0">
						<input type="hidden" id="Pyament_expiry_date" name="Pyament_expiry_date" value="0">
						<input type="hidden" id="NewCompany_License_type" name="NewCompany_License_type" value="<?php echo $NewCompany_License_type ;?>">
						<input type="hidden" id="Session_Company_License_type" name="Session_Company_License_type" value="<?php echo $_SESSION['Session_Company_License_type'] ;?>">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> First Name</label>
									<input class="form-control"  type="text" name="First_name" id="First_name" value="<?php echo $Records->First_name;?>" required  >
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">*</span> User Email id</label>
									<input class="form-control" type="text" name="Email" id="Email" value="<?php echo App_string_decrypt($Records->User_email_id);?>" required>
									
								</div>
								
								
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Country</label>
									<select class="form-control " name="Country_name" required>
									
									 <?php
										if($Country_array != NULL)
										{
											foreach($Country_array as $Country)
											{if($Records->Country_id == $Country['id']){
											?>											
												<option value="<?php echo $Country['name'];?>"><?php echo $Country['name'];?></option>											
											<?php
											}}
										}
										?>
									</select>
								
								</div>
								
								<?php if($Records->Country_id == 101){?>
								<div class="form-group" id="Show_Cities">
									<label for=""> City</label>
									<select class="form-control " name="city" id="city">
									<option value="">Select City</option>
									 <?php
										if($City_array != NULL)
										{
											foreach($City_array as $rec)
											{
												?>											
													<option value="<?php echo $rec->id;?>" <?php if($Records->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>									
												<?php
											}
										}
										?>
									</select>								
									
								</div>
									<div class="form-group">
									<label for="">  Business GST No.</label>
									<input class="form-control"  type="text" name="Business_GST_No" id="Business_GST_No" placeholder="Please enter Business GST No." >
								</div>
									<?php } ?>							
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Last Name</label>
									<input class="form-control"   type="text" name="Last_name" id="Last_name" value="<?php echo $Records->Last_name;?>" required>
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Phone No.</label>
									<input class="form-control"  type="text" name="Phone_no" id="Phone_no" value="<?php echo $phnumber;?>" required  onkeyup="this.value=this.value.replace(/\D/g,'')">
								
								</div>	
								<?php if($Records->Country_id == 101){?>
								<div class="form-group" id="Show_States">
									<label for=""> <span class="required_info">*</span> State</label>
									<select class="form-control " name="State_name" id="state" data-error="Please select state" onchange="Get_cities(this.value);" >
									<option value="">Select State</option>
									 <?php
										if($States_array != NULL)
										{
											foreach($States_array as $rec)
											{
											?>											
												<option value="<?php echo $rec->name;?>" <?php if($Records->State == $rec->id){echo "selected";} ?> id="<?php echo $rec->id;?>" class='<?php echo $rec->GST_CODE;?>' ><?php echo $rec->name;?></option>											
											<?php
											}
										}
										?>
									</select>
								</div>
								<?php } ?>
							<div class="form-group">
									<label for=""> <span class="required_info">*</span> Billing Address</label>
									<textarea class="form-control" rows="3" name="Business_address"  id="Current_address" data-error="Please enter address" required><?php echo App_string_decrypt($Records->Current_address); ?></textarea>
								</div>						
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 form-group">
							<br>	<br>	
								<label for="">Choose Payment Option:</label>
							</div>
							<div class="col-sm-3">
								<label for="">Monthly <?php if($Records->Country_id == 101){echo "(INR)";}else{echo "($)";} ?></label>
								<br>
									<a class="badge badge-primary-inverted paymode" id="30"><?php echo $Monthly_Price; ?></a>
							</div>
							<div class="col-sm-3">
								<label for="">Quarterly <?php if($Records->Country_id == 101){echo "(INR)";}else{echo "($)";} ?></label>
								<br>
									<a class="badge badge-primary-inverted  paymode"  id="90"><?php echo number_format(($Monthly_Price*3),2); ?></a>
									
							</div>
							<div class="col-sm-3">
								<label for="">Bi-Annually <?php if($Records->Country_id == 101){echo "(INR)";}else{echo "($)";} ?></label>
								<br>
									<a class="badge badge-primary-inverted  paymode"  id="180"><?php echo number_format(($Monthly_Price*6),2); ?></a>
									
							</div>
							<div class="col-sm-3">
								<label for="">Annually <?php if($Records->Country_id == 101){echo "(INR)";}else{echo "($)";} ?></label>
								<br>
									<a class="badge badge-primary-inverted  paymode"  id="365"><?php echo number_format(($Monthly_Price*12)-(($Monthly_Price*12*$License_Discount)/100),2); ?></a>
								<p style="color:red;"><?php echo "Includes $License_Discount% discount"; ?> 	</p>
							</div>
							
							<div id="period_date" style="color:red;"></div>	
						</div>
						
						<div class="form-buttons-w" align="center">
						<?php if($Records->Country_id == 101){ $currency="INR"; } else { $currency="USD"; } ?>
						<input type="hidden"  name="currency" value="<?php echo $currency;?>">
							<button class="btn btn-primary" id="submit" type="submit" disabled > PROCEED</button>
						</div>
					</div>
						
						<?php echo form_close(); ?>
                    </div>
					
					<div class="element-wrapper">											
						<div class="element-box">
						  <h6 class="form-header">
						Payment History
						  </h6>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Invoice No.</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Reference Id</th>
										<th>Email Sent</th>
									</tr>
								</thead>						
								<tfoot>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Invoice No.</th>
										<th>Currency</th>
										<th>Amount</th>
										<th>Reference Id</th>
										<th>Email Sent</th>		   
									</tr>
								</tfoot>
								<tbody>
								<?php
									
										if($Payment_record != NULL)
										{
											foreach($Payment_record as $row)
											{ 
											if($row->Country_name == "India")
											{
												$Currency = "INR";
											}
											else
											{
												$Currency = "USD";
											}
											
											if($row->Email_sent == 1)
											{
												$Email_sent = "Yes";
											}
											else
											{
												$Email_sent = "No";
											}
											?>
												<tr>
												<td>
													<a href="<?php echo base_url()?>index.php/Saas_invoice/Download/?Company_id=<?php echo $row->Company_id; ?>&Payment_id=<?php echo $row->Payment_id; ?>">
													<i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Download Invoice"></i>	
													</a>
												</td>
												<td><?php $date2=date_create($row->Bill_date);
													$Bill_date = date_format($date2,"d M Y");  
													echo $Bill_date;?></td>
												<td><?php echo $row->Bill_no;?></td>
												<td><?php echo $Currency;?></td>
												<td><?php echo $row->Bill_amount;?></td>
												<td><?php echo $row->Razorpay_payment_id;?></td>
												<td><?php echo $Email_sent;?></td>
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
                </div>
            </div>
        </div>
    </div>	
<?php $this->load->view('header/footer'); ?>
<style>
.paymode
{
	font-size:30px;
	cursor: pointer;
}
</style>
<script>
$("#Business_GST_No").prop('maxlength','15');
$('.paymode').click(function()
{
		$('.paymode').css("background-color", "#cce4ff");
		$('.paymode').css("color", "#3e4b5b");
		
		var price = $(this).html();
		var period = $(this).attr('id');
		
		$(this).css("background-color", "green");
		$(this).css("color", "white");
		
		
		// alert('<?php echo $_SESSION["Expiry_license"]; ?>')
		
		 $('#submit').prop('disabled', false);
		 
		if(period==30)
		{	
			<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+30 day'));?> 
			var Expdate = '<?php echo $val;?>'
			// alert(Expdate);
		}
		else if(period==90) 
		{	
			<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+90 day'));?> 
			var Expdate = '<?php echo $val;?>'
		}
		else if(period==180) 
		{	
			<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+180 day'));?> 
			var Expdate = '<?php echo $val;?>'
		}
		else
		{	
			<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+365 day'));?> 
			var Expdate = '<?php echo $val;?>'
			
		}
		$('#period_date').html('<br>License Expiry date will be '+Expdate);
		$('#Bill_amount').val(price);
		$('#Period').val(period);
		$('#Pyament_expiry_date').val(Expdate);
});
$('#submit').click(function()
{
	var price = $('#Bill_amount').val();
	var First_name = $('#First_name').val();
	var Last_name = $('#Last_name').val();
	var Email = $('#Email').val();
	var Phone_no = $('#Phone_no').val();
	var Current_address = $('#Current_address').val();
	 // alert(price);     
	if(First_name !=0 && Last_name !=0 && Email !=0 && Phone_no !=0 &&  Current_address !=0 &&  price !=0 )
	{
		show_loader();
	} 
	else
	{
		$('#submit').prop('disabled', false); 
	}
});
function Get_states(Country_id)
{
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Company/Get_states",
		success: function(data)
		{
			$("#Show_States").html(data.States_data);
		}
	});
}
function Get_cities(State_name)
{
	// alert(State_name);
	var State_id = $('#state').children(":selected").attr("id");
	var GST_CODE = $('#state').children(":selected").attr("class");
	$('#Business_GST_No').val(GST_CODE);
	// alert(GST_CODE);
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Company/Get_cities",
		success: function(data)
		{
			$("#Show_Cities").html(data.City_data);	
		}
	});
}
</script>