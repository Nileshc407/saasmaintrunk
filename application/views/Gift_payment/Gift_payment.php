<?php  $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">TOP UP E-Gifting Catalogue Account</h6>
                    <div class="element-box">
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code'); ?>
                            </div>
                          <?php } ?>

                        <?php 
                          $attributes = array('id' => 'formValidate');
                          echo form_open_multipart('Gift_payment/Create_order', $attributes); 
                        ?>
						<?php //echo "currency result----".$Cunverted_currency; Symbol_currency?>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<span >Current Balance : <?php echo $Symbol_currency.' '.$Gift_account_balance; ?></span>
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">*</span>Name</label>
									<input class="form-control"  type="text" name="Name" id="Name" value="<?php echo $Records->First_name.' '.$Records->Last_name;?>" required>
								</div>
								<div class="form-group">
									<label for="">Email id</label>
									<input class="form-control" type="text" name="Email" id="Email" value="<?php echo App_string_decrypt($Records->User_email_id);?>" required>
									
								</div>
								<div class="form-group">
									<label for="">Phone No.</label>
									<input class="form-control"  type="text" name="Phone_no" id="Phone_no" value="<?php echo $phnumber; ?>" required  onkeyup="this.value=this.value.replace(/\D/g,'')">
								
								</div>	
								
								<!--<div class="form-group">
									<label for=""> <span class="required_info">*</span> Enter Amount For TopUp</label>
									<input class="form-control"  type="text" name="Bill_amount" id="Bill_amount" placeholder="Please enter Amount" required onkeyup="this.value=this.value.replace(/\D/g,'')">
								</div>-->							
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<span >Equivalent Points  : <?php echo $Gift_account_point_balance; ?></span>
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
												<option value="<?php echo $rec->name;?>" <?php if($Records->State == $rec->id){echo "selected";} ?> id="<?php echo $rec->id;?>"><?php echo $rec->name;?></option>											
											<?php
											}
										}
										?>
									</select>
								
								</div>
								<?php } ?>
								
								<?php if($Records->Country_id == 101){ ?>
								<!--<div class="form-group" id="Show_Cities">
									<label for=""> <span class="required_info">*</span> City</label>
									<select class="form-control " name="city" id="city">
									<option value="">Select City</option>
									 <?php /*
										if($City_array != NULL)
										{
											foreach($City_array as $rec)
											{
												?>											
													<option value="<?php echo $rec->id;?>" <?php if($Records->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>									
												<?php
											}
										} */
										?>
									</select>								
									
								</div>-->
								<?php } ?>
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Billing Address</label>
									<textarea class="form-control" rows="3" name="Business_address"  id="Current_address" data-error="Please enter address" required><?php echo App_string_decrypt($Records->Current_address); ?></textarea>
								</div>						
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 form-group">
							<br><br> <?php 
							if($Records->Country_id == 101)
							{
								$payment_currency = "INR"; 
								$dispaly_currency = "INR"; 
								
								$Amt1 = 1000;
								$Amt2 = 5000;
								$Amt3 = 10000;
								$Amt4 = 15000;	
							} 
							else 
							{
								$payment_currency = "USD"; 
								$dispaly_currency = "$"; 
								
								$Amt1 = 100;
								$Amt2 = 500;
								$Amt3 = 1000;
								$Amt4 = 5000;	
							}	?>
							<label for="">Select TopUp Amount :</label>
							</div>
							<div class="col-sm-3">
								<label for="" style="font-size:25px;"><?php echo $dispaly_currency; ?></label>
								<a class="badge badge-primary-inverted paymode" id="1"><?php echo number_format($Amt1,2); ?></a>
							</div>
							<div class="col-sm-3">
								<label for="" style="font-size:25px;"><?php echo $dispaly_currency; ?></label>
								<a class="badge badge-primary-inverted  paymode" id="2"><?php echo number_format($Amt2,2); ?></a>
							</div>
							<div class="col-sm-3">
								<label for="" style="font-size:25px;"><?php echo $dispaly_currency; ?></label>
								<a class="badge badge-primary-inverted  paymode" id="3"><?php echo number_format($Amt3,2); ?></a>
							</div>
							<div class="col-sm-3">
								<label for="" style="font-size:25px;"><?php echo $dispaly_currency; ?></label>
								<a class="badge badge-primary-inverted  paymode" id="4"><?php echo number_format($Amt4,2); ?></a>
							</div>
						</div>
						<?php if($Symbol_currency != $payment_currency)
						{ 
							$Local_currency_amt1 = $Amt1*$Cunverted_currency;						
							$Local_currency_amt2 = $Amt2*$Cunverted_currency;						
							$Local_currency_amt3 = $Amt3*$Cunverted_currency;						
							$Local_currency_amt4 = $Amt4*$Cunverted_currency;	
						?>
						<br><br>
						<div class="row">
							<div class="col-sm-12 form-group">
								<label for="">Equivalent to (approx)</label>
							</div>
							<div class="col-sm-3">
								<div id="Equivalent1" style="font-size:20px;"><?php echo $Symbol_currency.' '.number_format($Local_currency_amt1,2); ?></div>
							</div>
							<div class="col-sm-3">
								<div id="Equivalent2" style="font-size:20px;"><?php echo $Symbol_currency.' '.number_format($Local_currency_amt2,2); ?></div>
							</div>
							<div class="col-sm-3">
								<div id="Equivalent3" style="font-size:20px;"><?php echo $Symbol_currency.' '.number_format($Local_currency_amt3,2); ?></div>
							</div>
							<div class="col-sm-3">
								<div id="Equivalent4" style="font-size:20px;"><?php echo $Symbol_currency.' '.number_format($Local_currency_amt4,2); ?></div>
							</div>
						</div>
						<?php } ?>
						<div class="form-buttons-w" align="center">
							<input type="hidden" id="Local_amount" name="Local_amount" value="0">
							<input type="hidden" id="Bill_amount" name="Bill_amount" value="0">
							<input type="hidden"  name="currency" value="<?php echo $payment_currency;?>">
							<button class="btn btn-primary" id="submit" type="submit" disabled> PROCEED for TOPUP</button>
						</div>
					</div>	
					<?php echo form_close(); ?>
                    </div>
					
					<div class="element-wrapper">											
						<div class="element-box">
						  <h6 class="form-header">
						TOPUP History
						  </h6>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Invoice No.</th>
										<th>Currency</th>
										<th>TopUp Amount</th>
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
										<th>TopUp Amount</th>
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
													<a href="<?php echo base_url()?>index.php/Gift_payment/Download/?Company_id=<?php echo $row->Company_id; ?>&Payment_id=<?php echo $row->Payment_id; ?>">
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
$('.paymode').click(function()
{
	$('#Equivalent1').css("color", "");
	$('#Equivalent2').css("color", "");
	$('#Equivalent3').css("color", "");
	$('#Equivalent4').css("color", "");
	 $('#submit').prop('disabled', false);
	 
	$('.paymode').css("background-color", "#cce4ff");
	$('.paymode').css("color", "#3e4b5b");
	
	var price = $(this).html();
	var paymodeId = $(this).attr('id');
	
	$(this).css("background-color", "green");
	$(this).css("color", "white");

	$('#submit').prop('disabled', false);
		
	$('#Bill_amount').val(price);
	
	var TopUp_amt = $('#Bill_amount').val();
	
	if(paymodeId == 1) 
	{
		var TopUp_amt = "<?php echo $Amt1; ?>";
		$('#Bill_amount').val(TopUp_amt);
		$('#Equivalent1').css("color", "#FF0000");	
	}
	else if(paymodeId == 2)
	{
		var TopUp_amt = "<?php echo $Amt2; ?>";
		$('#Bill_amount').val(TopUp_amt);
		$('#Equivalent2').css("color", "#FF0000");
	}
	else if(paymodeId == 3)
	{
		var TopUp_amt = "<?php echo $Amt3; ?>";
		$('#Bill_amount').val(TopUp_amt);
		$('#Equivalent3').css("color", "#FF0000");
	}
	else if(paymodeId == 4)
	{
		var TopUp_amt = "<?php echo $Amt4; ?>";
		$('#Bill_amount').val(TopUp_amt);
		$('#Equivalent4').css("color", "#FF0000");
	}
	
	var Symbol_currency = "<?php echo $Symbol_currency; ?>";
	var payment_currency = "<?php echo $payment_currency; ?>";
	
	if(Symbol_currency != payment_currency)
	{
		var Currency_value = "<?php echo $Cunverted_currency; ?>";
		var Local_currency_amt = TopUp_amt * Currency_value;
		var Local_amount = Local_currency_amt.toFixed(2)
		
		$('#Local_amount').val(Local_amount);
	}
	else
	{
		$('#Local_amount').val(TopUp_amt);
	}
});
$('#submit').click(function()
{
	var price = $('#Bill_amount').val();
	var First_name = $('#First_name').val();
	var Email = $('#Email').val();
	var Phone_no = $('#Phone_no').val();
	var Current_address = $('#Current_address').val();
	 // alert(price);     
	if(First_name !="" && Email !="" && Phone_no !="" &&  Current_address !="" &&  price !=0)
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
	// alert(State_id);
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