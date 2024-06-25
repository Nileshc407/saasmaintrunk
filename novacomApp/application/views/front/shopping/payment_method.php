<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title; ?></title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
<body>
   <?php 
	// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				// $grand_total = 0; 
				$item_count = COUNT($cart); 
			}
		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}				
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}		
		// echo"--grand_total---".$grand_total."--<br>"; 
		?>
    <div id="application_theme" class="section pricing-section" style="min-height:500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type=<?php echo $_SESSION['delivery_type']; ?>" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Payment Method</p>
			</div>
		<form method="post" action="<?php echo base_url()?>index.php/Shopping/Card_details">
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">	

						<?php if($mPiesaValidation == 1 ){ ?>	<!-- 1 card -->
							<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
								<br>
								<div class="pricing-details">
									<div class="row">
										<div class="col-md-12">
											<div class="row ">
												<a href="">
													<div class="col-xs-12 " style="width: 100%;">
														<span id="Extra_large_font"><strong>Invalid M-PESA TRANSACTION ID, Please try again</strong></span>
													</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>	<!-- 1 card -->
				
					<?php if(!empty($cart_check)) { ?>	<!-- 1 card -->
					<!-- 1st Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<div class="pricing-details">
							<div class="row">
								
									
									
									<table align="center" style="width:75%">
									
										<tr>
											<td>
												<label>
												<!--onclick="toggle_payment(this.value);"-->
												<input type="radio" name="payment_method" id="payment_method" value="6" checked>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/mpesa.jpg" alt="" class="img-rounded img-responsive" style="width:120px">
												
												 <span class="checkmark"></span>
												 </label>
											</td>
											<?php /* ?>
											<td> 
												<label>
												<input type="radio" name="payment_method" id="payment_method1" value="2" checked="checked"  onclick="toggle_payment(this.value);" >
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cod.png" alt="" class="img-rounded img-responsive" style="height: 51px;">													
													<span class="checkmark"></span>
												</label>
											</td>
											<?php  */?>
										</tr>
											
										
									</table>
										
									
								
							</div>
						</div>
					<br>
					<!-- 2nd Card -->
					
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<a href="">
											<div class="col-xs-12 " style="width: 100%;">
												

													<!--<span style="color: #ff3399;margin-bottom: 0; font-size: 12px;"><strong>CASH ON DELIVERY</strong></span>-->
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="pricing-details">
							<div class="row">
							
								<!--style="display:none;"-->
								
								<div class="table-responsive"  id="mpesa_block">
									<table class="table" align="center" style="width:100%">
									
										<tbody><tr>
											<th><strong id="Medium_font">BUY GOOD TILL NUMBER :</strong></th>
											<td> <input type="text" name="" id="" value="<?php echo $delivery_outlet_details->goods_till_number; ?>" disabled="" style="width: 110px;text-align:center;"></td>
										</tr>
											
										<tr>
											<th><strong id="Medium_font">Amount to Pay(<?php echo $Symbol_of_currency; ?>) :</strong></th>
											<td><input type="text" name="" id="total_bill_amount" value="<?php echo number_format($total_bill_amount,2); ?>" disabled=""  style="width: 110px;text-align:center;"></td>
										</tr>
										
										<tr>
											<th><strong id="Medium_font">Enter M-PESA Transaction Reference :</th>
											<td><input type="text" name="Trans_id" id="Trans_id" value="" style="width: 110px;text-align:center;" maxlength="10">
											<br><div style="color:red;font-size:12px;" id="Trans_id_error"></div>
											</td>
										</tr>
									
										<tr>
											
											<td colspan="2" align="center">
													<button type="button" onclick="Call_API();" id="verfify_button">
														Verify
													</button>
												<br><div style="color:red;font-size:12px;" id="Verify_mpesa_error"></div>
											</td>
										</tr>
										<tr id="name_block" style="display:none;">
											<th><strong id="Medium_font">Name:</strong></th>
											<td id="name"></td>
										</tr>
										<tr id="amt_block" style="display:none;">
											<th><strong id="Medium_font">Transaction Amount:</strong></th>
											<td id="BillAmount2"></td>
										</tr>
										<tr>
										<th colspan="2" id="compa_block"></th>
											
										</tr>
										<tr  id="reenter_block" style="display:none;">
									
										<td colspan="2" align="center">
												<button type="button"  id="button1"  onclick="javascript:re_enter();" >
												Re-Enter
											</button>		</td>
										</tr>
										
										
								</tbody>
								</table>
								
							</div>
							</div>
						</div>
						<div class="pricing-details">
							<div class="row">
								<div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_cart_details(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $_SESSION['delivery_outlet']; ?>,<?php echo $_SESSION['Address_type']; ?>);" >Back</button>
								</div>
								<div class="col-xs-4 main-xs-6 text-right" id="CardSubmit_div" style="width: 50%;"> 
									<button type="submit"   class="b-items__item__add-to-cart" id="CardSubmit" style="display:none">
											Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						<br>
					</div>
					<?php } ?>	
					<?php if(empty($cart_check)) { ?>
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
													
					<div class="pricing-details">
						<div class="row">
							<div class="col-md-12">			
								<address>
									<button type="button" id="button" class="b-items__item__add-to-cart" onclick="return Go_to_Shopping();">Menu</button>
								</address>
							</div>
						</div>
					</div>													
					<br>
				</div>
		<?php } ?>
						
				</div>
			</div>
			<?php //echo "----Redeem_amount---".$_SESSION["Redeem_amount"]; <?php echo $Address_type; ?>
			 <input type="hidden" name="delivery_type" value="<?php echo $_SESSION['delivery_type']; ?>" />
			 <input type="hidden" name="delivery_outlet" value="<?php echo $_SESSION['delivery_outlet']; ?>" />
			 <input type="hidden" name="Address_type" value="<?php echo $_SESSION['Address_type']; ?>" />
			 <input type="hidden" name="BillAmount" id="BillAmount" value="0">
			<input type="hidden" name="Mpesa_TransID" id="Mpesa_TransID" value="0">
		</form>
		</div>
    </div>
	
	<!-- Loader -->	
    <div class="container" >
        <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" style="margin-top: 65%;">
              <!-- Modal content-->
              <div class="modal-content" id="loader_model">
                    <div class="modal-body" style="padding: 10px 0px;;">
                      <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                    </div>							
              </div>						  
            </div>
        </div>					  
    </div>
	<!-- Loader -->	
  <?php $this->load->view('front/header/footer');?> 
<script>
$(document).keypress(
  function(event){
    if (event.which == '13') {
		
		$("#Verify_mpesa_error").html('Please verfify M-PESA Transaction ID');
		setTimeout(function() 
		{ 
			$('#Verify_mpesa_error').html('');
		},3000);		
		event.preventDefault();
    }
});
function re_enter()
{
	// $("#CardSubmit").hide();
	$("#CardSubmit").css("display","none");
	$("#name_block").hide();
	$("#amt_block").hide();
	$("#reenter_block").hide();
	
	$("#verfify_button").html('Verify');
	$("#verfify_button").attr("disabled", false);
	$('#compa_block').html('<font></font>');
				
}

function Call_API()
{
	
	var goods_till_number= '<?php echo $delivery_outlet_details->goods_till_number; ?>';
	// var Final_Grand_total= "<?php echo $_SESSION['Grand_total']; ?>"; 
	var Final_Grand_total= "<?php echo $_SESSION['Final_Grand_total']; ?>"; 
	/* var Final_Grand_total= "<?php echo $total_bill_amount; ?>"; */
	var Seller_api_url2= "<?php echo $delivery_outlet_details->Seller_api_url2; ?>ValidateB2BPayment";
	var Trans_id=$("#Trans_id").val();
	
	/* alert(Final_Grand_total);
	alert(goods_till_number);
	alert(Seller_api_url2);
	alert(Trans_id);
	return false; */
	
	$("#Trans_id_error").html('');
	
	if(Trans_id=="" || Trans_id==0)
	{
		$("#Trans_id_error").html('Please Enter M-PESA Transaction ID');
		return false;
	}
	$("#verfify_button").html('<font color="green">Verifying Data....</font>');
	$("#verfify_button").attr("disabled", true);
	$.ajax({
		type: "POST",
		data: {Final_Grand_total: Final_Grand_total, goods_till_number:goods_till_number,Trans_id:Trans_id,Seller_api_url2:Seller_api_url2},
		url: "<?php echo base_url()?>index.php/Shopping/Verify_mpesa",
		success: function(data)
		{
			console.log(data.response);			
			
			var response2 = JSON.parse(data.response);
			//response2.MpesaPaidAmount = 1190;
			$("#BillAmount").val(response2.MpesaPaidAmount); 
			$("#Mpesa_TransID").val(response2.TransID); 
			var h = CommaFormatted(parseFloat(response2.MpesaPaidAmount).toFixed(2));
			//console.log(h);
			$("#BillAmount2").html(h); //response2.MpesaPaidAmount 
			$("#name").html(response2.ResultDesc); 
			
			//$("#CardSubmit").show();
			
			$("#CardSubmit").css("display","");
			$("#name_block").show();
			$("#amt_block").show();
			$("#reenter_block").show();
			
			if(response2.ResultCode =='9999' || data.response == false)
			{
				$("#verfify_button").html('<font color="red">Veriyfication Failed..</font>');
				$("#CardSubmit").css("display","none");
				$("#reenter_block").show();
				
				
			}
			else
			{
				$("#reenter_block").hide();
				$("#verfify_button").html('<font color="green">Veriyfication Successfull..</font>');
			}
			 
			/*  alert('Final_Grand_total '+parseFloat(Final_Grand_total));
			 alert('MpesaPaidAmount '+parseFloat(MpesaPaidAmount)); */
			 
			var MpesaPaidAmount = response2.MpesaPaidAmount;		
			
			 /* console.log(parseFloat(MpesaPaidAmount));
			 console.log(parseFloat(Final_Grand_total)); */			
			if(parseFloat(Final_Grand_total) < parseFloat(MpesaPaidAmount))
			{
				$("#reenter_block").show();
				$("#CardSubmit").css("display","none");
				$("#compa_block").html('<font color="red">MPesa Paid Amount is Greater than Ordered Amount due!<br>You may need to order more Items to match Paid amount</font>'); 
				
				
			}
			if(parseFloat(Final_Grand_total) > parseFloat(MpesaPaidAmount))
			{
				$("#reenter_block").show();
				$("#CardSubmit").css("display","none");
				if(response2.ResultCode =='9999' || data.response == false)
				{
					$("#compa_block").html('<font color="red"></font>'); 
				}else {
					$("#compa_block").html('<font color="red">MPesa Paid Amount is not equal to Ordered Amount due!</font>'); 
				}
								
			}
		}
	});
}
 
function CommaFormatted(amount) {
	var delimiter = ","; // replace comma if desired
	var a = amount.split('.',2)
	var d = a[1];
	var i = parseInt(a[0]);
	if(isNaN(i)) { return ''; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3) {
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	return amount;
}
function toggle_payment(pay_val)
{
	if(pay_val==6)//mpesa
	{
		//alert($("#BillAmount").val());
		if($("#BillAmount").val() > 0)
		{
			// $("#CardSubmit").show();
			$("#CardSubmit").css("display","");
		}
		else
		{
			// $("#CardSubmit").hide();
			$("#CardSubmit").css("display","none");
		}
		
		$("#mpesa_block").show();
		
	}
	else //COD
	{
		
		$("#mpesa_block").hide();
		// $("#CardSubmit").show();
		$("#CardSubmit").css("display","");
		/* $("#name_block").hide();
		$("#amt_block").hide();
		$("#verfify_button").html('<font color="green">Veryfication Successfull..</font>'); */
	}
}



$('#CardSubmit').click(function()
{
	setTimeout(function() 
	{
			$('#myModal').modal('show');	
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide');
	},2000);
});    
function Go_to_cart_details(delivery_type,delivery_outlet,Address_type)
{ 

    setTimeout(function() 
    {
        $('#myModal').modal('show');
        window.location.href='<?php echo base_url(); ?>index.php/Shopping/checkout_cart_details?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
        //window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
		// window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
		
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
       
    },2000);
}
function Go_to_Shopping()
{ 
    setTimeout(function() 
    {
        $('#myModal').modal('show');
        window.location.href='<?php echo base_url(); ?>index.php/Shopping';
    }, 0);
    setTimeout(function() 
    { 
        $('#myModal').modal('hide');
        
    },2000);
}

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
});
</script>
<script>
/* $('#CardSubmit11').click(function()
{
	// var Payment_option = $("input[type=radio]:checked").val(); 
	if($('#payment_method').attr('checked', false) && $('#payment_method1').attr('checked', false)) 
	{
		alert('Please Select at least One Payment Method...');

		return false;
	}
}); */
</script>
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




/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 105px;
  left: 217px;
  height: 25px;
  /* width: 25px; */
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



    input[type='radio']:after {
    content: " ";
    display: inline-block;
    position: relative;  
    margin: 0 5px 4px 0;
    width: 13px;
    height: 13px;
    border-radius: 11px;
    border: 1.8px solid #ef888e;
    background-color: white;
    }
    input[type='radio']:checked:after {
       
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ef888e;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white; 
    }	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{
		font-size: 13px;
	}	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
		line-height: 10px;
	}	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}		
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0;
		outline: none;
	}
</style>