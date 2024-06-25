<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
?>	
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<style>
	/* HIDE RADIO */
	[type=radio] { 
	  position: absolute;
	  opacity: 0;
	  width: 0;
	  height: 0;
	}

	/* IMAGE STYLES */
	[type=radio] + img {
	  cursor: pointer;
	}

	/* CHECKED STYLES */
	[type=radio]:checked + img {
	  outline: 5px solid #fab900 ;
	}
</style>
<style>
	/* The container */

	/* Hide the browser's default radio button */


	/* Create a custom radio button */
	.checkmark {
	  position: absolute;
	  top: 95px;
	  left: 237px;
	  height: 25px;
	  width: 25px;
	  background-color: #eee;
	  border-radius: 50%;
	}

	/* When the radio button is checked, add a blue background */
	.content input:checked ~ .checkmark {
	  background-color: #2196F3;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
	  content: "";
	  position: absolute;
	  display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.content input:checked ~ .checkmark:after {
	  display: block;
	}

	/* Style the indicator (dot/circle) */
	.checkmark:after {
		top: 9px;
		left: 9px;
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: white;
	}
</style>	
<section class="content-header">
	<h1>Checkout - Payment Method</h1>
</section>		
		
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
			<?php
			if($this->session->flashdata('mpesa_code'))
			{
			?>
				<script>
					 var Title = "Application Information";
					 var msg = '<?php echo $this->session->flashdata('mpesa_code'); ?>';
					 runjs(Title,msg);
				</script>
			<?php
			}
			?>
			
			<?php
			if($this->session->flashdata('error_code'))
			{
			?>
				<script>
					// var Title = "Application Information";
					// var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
					// runjs(Title,msg);
				</script>
			<?php
			}
			?>
		
			<?php if(empty($cart_check)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center">Your Cart is Empty. Please click Continue to Add items to the Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Continue
						</a>
					</p>
				</div>
			<?php } ?>
			
			<?php if ($cart = $this->cart->contents()) { ?>
		
			<div class="col-md-12 clearfix" id="checkout"> 
				<div class="box">
					<form method="post" action="<?php echo base_url()?>index.php/Shopping/Card_details">
						<ul class="nav nav-pills nav-justified">
							<li class="active"><a href="#" style="background-color:#332005; border:none;"><i class="fa fa-money"></i>Payment Method</a></li>
						</ul>
						<div>
							<div class="row">
								<div class="col-sm-6">
									<label style="margin-top:5%">
									  <input type="radio" name="payment_method" id="payment_method" value="6" checked onclick="toggle_payment(this.value);">
									  <img src="<?php echo base_url(); ?>images/mpesa3.png" alt="Paypal" class="img-responsive">
									   <span class="checkmark" style="margin-left:-20%;"></span>
									</label>
								</div>
							</div>
								<?php /*
								<div class="col-sm-6">
									<label style="margin-top:5%">
									  <input type="radio"  name="payment_method" id="payment_method1" value="2" checked  onclick="toggle_payment(this.value);" >
									  <img src="<?php echo $this->config->item('base_url2'); ?>images/cod.png" alt="Cash On Delivery" class="img-responsive" >
									   <span class="checkmark" style="margin-left:-20%;"></span>
									</label>
								</div> */ ?>
						</div>
						<br>
						<br>
						<div class="table-responsive" id="mpesa_block">
							<table class="table" style="width:50%">
									<tr>
										<th>BUY GOOD TILL NUMBER :</th>
										<td> <input type="text" name="" id="" value="<?php echo $goods_till_number; ?>" disabled class="form-control"style="width: 210px;text-align:center;"></td>
									</tr>
										
									<tr>
										<th>Amount to Pay(<?php echo $Symbol_of_currency; ?>) :</th>
										<td><input type="text" name="" id="" value="<?php  echo number_format($total_bill_amount,2); ?>" disabled class="form-control" style="width: 210px;text-align:center;"></td>
									</tr>
									
									<tr>
										<th>Enter M-PESA Transaction Reference :</th>
										<td><input type="text" name="Trans_id" id="Trans_id" value=""  class="form-control" style="width: 210px;text-align:center;" maxlength="10">
										<br><div style="color:red;font-size:12px;" id="Trans_id_error"></div>
										</td>
									</tr>
								
									<tr>
										
										<td colspan="2" align="center">
										<button type="button" class="btn btn-template-main"  onclick="Call_API();"  id="verfify_button">
										Verify
										</button>		
										</td>
									</tr>
									<tr id="name_block" style="display:none;">
										<th>Name:</th>
										<td  id="name"></td>
									</tr>
									<tr  id="amt_block" style="display:none;">
										<th>Transaction Amount:</th>
										<td id="BillAmount2"></td>
									</tr>
									<tr >
									<th colspan="2"  id="compa_block"></th>
										
									</tr>
									<tr  id="reenter_block" style="display:none;">
									
										<td colspan="2" align="center">
										<button type="button" class="btn btn-template-main"  onclick="javascript:re_enter();;" >
										Re-Enter
									</button>		</td>
									</tr>
							</table>
						</div>
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">	
										<a href="<?php echo base_url()?>index.php/Shopping/checkout_cart_details/?address_flag=<?php echo $delivery_address_type; ?>" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Cart Details
									</a>
								</div>
								<input type="hidden" name="address_flag" value="<?php echo $delivery_address_type; ?>">
								
								<div class="col-md-6 col-xs-6" align="right" id="Enable_paypal" style="display:none;">
								<!--<div class="col-md-6 col-xs-6" align="right" id="Enable_paypal" style="display:none;">-->
									<button type="submit" class="btn btn-template-main" id="CardSubmit">
										Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						<br>
						<input type="hidden" name="Address_type" value="<?php echo $Address_type; ?>">
						<input type="hidden" name="DeliveryType" value="<?php echo $DeliveryType; ?>">
						<input type="hidden" name="DeliveryOutlet" value="<?php echo $DeliveryOutlet; ?>">
						<input type="hidden" name="BillAmount" id="BillAmount" value="0">
						<input type="hidden" name="Mpesa_TransID" id="Mpesa_TransID" value="0">
					</form>
				</div>
			</div>			
			<?php } ?>
		</div>
	</div>
</section>
<?php $this->load->view('header/footer');?>
<script>
$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
function re_enter()
{
	$("#CardSubmit").hide();
	$("#name_block").hide();
	$("#amt_block").hide();
	$("#compa_block").hide();
	$("#reenter_block").hide();
	
	$("#verfify_button").html('Verify');
	$("#verfify_button").attr("disabled", false);
}
function Call_API()
{	
	var goods_till_number= '<?php echo $goods_till_number; ?>';
	var Final_Grand_total= "<?php echo $total_bill_amount; ?>";
	var Seller_api_url2= "<?php echo $Seller_api_url2; ?>ValidateB2BPayment";
	var Trans_id=$("#Trans_id").val();
	
	/* alert(Final_Grand_total);
	alert(goods_till_number);
	alert(Trans_id); */
	$("#Trans_id_error").html('');
	
	if(Trans_id=="" || Trans_id==0)
	{
		$("#Trans_id_error").html('Please Enter M-PESA Transaction ID');
		return false;
	}
	$("#verfify_button").html('<font color="green">Verifying Data...</font>');
	$("#verfify_button").attr("disabled", true);
	$.ajax({
		type: "POST",
		data: {Final_Grand_total: Final_Grand_total, goods_till_number:goods_till_number,Trans_id:Trans_id,Seller_api_url2:Seller_api_url2},
		url: "<?php echo base_url()?>index.php/Shopping/Verify_mpesa",
		success: function(data)
		{
			//alert(data.response);
			 var response2 = JSON.parse(data.response);
			$("#BillAmount").val(response2.MpesaPaidAmount);
			$("#Mpesa_TransID").val(response2.TransID); 
			$("#BillAmount2").html(response2.MpesaPaidAmount); 
			$("#name").html(response2.ResultDesc); 
			
			$("#CardSubmit").show();
			$("#name_block").show();
			$("#amt_block").show();
			$("#reenter_block").show();
			
			var MpesaPaidAmount = response2.MpesaPaidAmount;
			
			if(response2.ResultCode=='0000')
			{
				$("#reenter_block").hide();
				$("#compa_block").hide();
				$("#verfify_button").html('<font color="green">Verification Successfull</font>');
				$("#Enable_paypal").css("display","");
				
				if(parseInt(Final_Grand_total) != parseInt(MpesaPaidAmount))
				{
					//alert('Final_Grand_total '+parseInt(Final_Grand_total));
					//alert('MpesaPaidAmount '+parseInt(MpesaPaidAmount)); 
					$("#CardSubmit").hide();
					$("#compa_block").html('<font color="red">MPesa Paid Amount is Not equal to Ordered Amount!</font>'); 
					$("#compa_block").show();
					$("#reenter_block").show();
					
					if(parseInt(Final_Grand_total) < parseInt(MpesaPaidAmount))
					{
					//alert('Final_Grand_total '+parseInt(Final_Grand_total));
					//alert('MpesaPaidAmount '+parseInt(MpesaPaidAmount));
					$("#CardSubmit").hide();
					$("#compa_block").html('<font color="red">MPesa Paid Amount is Greater than Ordered Amount due!<br>You may need to order more Items to match Paid amount</font>');
					$("#compa_block").show();
					}
				}				
			}
			else
			{
				$("#verfify_button").html('<font color="red">Verification Failed</font>');
				$("#compa_block").hide();
			}
			// var MpesaPaidAmount = response2.MpesaPaidAmount;
			// alert(parseInt(MpesaPaidAmount));
			if(!MpesaPaidAmount || parseInt(MpesaPaidAmount) == 0)
			{
				$("#CardSubmit").hide();
				$("#reenter_block").show();
			}
			//alert('Final_Grand_total '+parseInt(Final_Grand_total));
			 //alert('MpesaPaidAmount '+parseInt(MpesaPaidAmount)); 
			
			/*if(parseInt(Final_Grand_total) != parseInt(MpesaPaidAmount))
			{
				//alert('Final_Grand_total '+parseInt(Final_Grand_total));
				//alert('MpesaPaidAmount '+parseInt(MpesaPaidAmount)); 
				$("#CardSubmit").hide();
				$("#compa_block").html('<font color="red">MPesa Paid Amount is Not equal to Ordered Amount!</font>'); 
				$("#compa_block").show();
				
				if(parseInt(Final_Grand_total) < parseInt(MpesaPaidAmount))
				{
				//alert('Final_Grand_total '+parseInt(Final_Grand_total));
				//alert('MpesaPaidAmount '+parseInt(MpesaPaidAmount));
				$("#CardSubmit").hide();
				$("#compa_block").html('<font color="red">MPesa Paid Amount is Greater than Ordered Amount due!<br>You may need to order more Items to match Paid amount</font>');
				$("#compa_block").show();
				}
			} */
		}
	});
}
function toggle_payment(pay_val)
{
	if(pay_val==6)//mpesa
	{
		//alert($("#BillAmount").val());
		if($("#BillAmount").val() > 0)
		{
			$("#CardSubmit").show();
		}
		else
		{
			$("#CardSubmit").hide();
		}
		
		$("#mpesa_block").show();
	}
	else //COD
	{
		
		$("#mpesa_block").hide();
		$("#CardSubmit").show();
		/* $("#name_block").hide();
		$("#amt_block").hide();
		$("#verfify_button").html('<font color="green">Veryfication Successfull..</font>'); */
	}
}
  /*  
$('#cod').click(function()
{
    $( "#CardSubmit" ).attr("disabled",false);
});

$('#braintree').click(function()
{
    $( "#CardSubmit" ).attr("disabled",false);
});

$('#paypal').click(function()
{
    $( "#CardSubmit" ).attr("disabled",false);
});*/
</script>

<script>
$('#CardSubmit11').click(function()
{
	// var Payment_option = $("input[type=radio]:checked").val();
	if($('#payment_method').attr('checked', false) && $('#payment_method1').attr('checked', false)) 
	{
		var Title = "Application Information";
		var msg = 'Please Select at least One Payment Method...';
		runjs(Title,msg);
		return false;
	}
	
	/*if($('#payment_method1').attr('checked', true))   
	  {
			var Title = "Application Information";
			var msg = 'Please Select at least One Payment Method';
			runjs(Title,msg);
			return false;
	  }
	 /* else
	  {
	    return true;
	  }*/

});
</script>
<style>
<?php if($smartphone_flag == 1) { ?>
@media only screen and (min-width: 320px) {
  #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 375px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 425px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 768px) {
  #checkout .nav li {
    height: 9%; 
	}
}
@media only screen and (min-width: 1024px) {
   #checkout .nav li {
    height: 10%; 
	}
}
@media only screen and (min-width: 1440px) {
   #checkout .nav li {
    height: 10%; 
	}
}

@media only screen and (min-width: 368px){
	#checkout .nav li {
    height: 14%;
	}
}
<?php } ?>
</style>