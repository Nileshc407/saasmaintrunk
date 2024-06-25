<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
//echo "<pre>";
//var_dump($_SESSION);
?>
	
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		
<section class="content-header">
	<h1>Checkout - Payment Method</h1>
</section>		
		
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
                    
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
					<p class="text-muted lead text-center">Your Shopping Cart is Empty. Please click on Continue shopping to Add items to Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Continue shopping
						</a>
					</p>
				</div>
			<?php } ?>
			
			<?php if ($cart = $this->cart->contents()) { ?>
		
			<div class="col-md-12 clearfix" id="checkout">
				
				<div class="box">
				
					<form method="post" action="<?php echo base_url()?>index.php/Shopping/Card_details">

						<ul class="nav nav-pills nav-justified">
							<!--<li><a href="<?php //echo base_url()?>index.php/Shopping/checkout"><i class="fa fa-map-marker"></i><br>Shipping Details</a></li>
							<li><a href="<?php //echo base_url()?>index.php/Shopping/checkout_cart_details"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>-->
							
							<li class="active"><a href="#"><i class="fa fa-money"></i>Payment Method</a></li>
							
							<!--<li class="disabled"><a href="#"><i class="fa fa-credit-card"></i><br>Card Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>-->
						</ul>

						<div class="content">
							<div class="row">
								<div class="col-sm-6">
									<div class="box payment-method">

										<h4>Braintree</h4>
										
										<p><img src="<?php echo $this->config->item('base_url2'); ?>images/braintree.png" width="390" alt="Paypal" class="img-responsive" style="margin: 0px auto;"></p>

										<div class="box-footer text-center">
											<input type="radio" name="payment_method" id="payment_method" value="1"  <<?php  if($grand_total == 0){?> disabled <?php }?>>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="box payment-method">

										<h4>Cash on delivery</h4>

										<p>You pay when you get it.</p>	
										<p style="margin: 0px auto;">&nbsp;</p>
										
										<img src="<?php echo $this->config->item('base_url2'); ?>images/cod.png" alt="Cash On Delivery" class="img-responsive" style="margin: 0px auto;">

										<div class="box-footer text-center">
											<input type="radio" name="payment_method" id="payment_method1" value="2" checked="checked" >
										</div>
									</div>
								</div>
							</div>
                                                    
                                                        <?php /* <div class="row">
								<div class="col-sm-6">
									<div class="box payment-method">

										<h4>Paypal</h4>

										<p>We like it all.</p>
										
										<p><img src="<?php echo $this->config->item('base_url2'); ?>images/paypal2.png" alt="Paypal" class="img-responsive" style="margin: 0px auto;"></p>

										<div class="box-footer text-center">
											<input type="radio" name="payment_method" id="paypal" value="3">
										</div>
									</div>
								</div>
							</div> */ ?>
						</div>

						<!--<div class="box-footer">
							<div class="pull-left">
								
                                                            
                                   <a href="<?php //echo base_url()?>index.php/Shopping/checkout_cart_details" class="btn btn-default">
									<i class="fa fa-chevron-left"></i>&nbsp;Back to Cart Details
								</a>
							</div>							
							<div class="pull-right" id="Enable_cod" style="display:none">
								<a href="<?php //echo base_url()?>index.php/Shopping/shipping_details" class="btn btn-template-main">
									Continue to Shipping Address &nbsp;<i class="fa fa-chevron-right"></i>
								</a>
							</div>
							
							<div class="pull-right" id="Enable_paypal">
								
                                 <button type="submit" class="btn btn-template-main" id="CardSubmit" >
									Continue to Card Details &nbsp;<i class="fa fa-chevron-right"></i>
								</button>
							</div>
						</div> -->
						
						
						
						
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">	
										<a href="<?php echo base_url()?>index.php/Shopping/checkout_cart_details" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Cart Details
									</a>
								</div>
								<div class="col-md-6 col-xs-6" align="right" id="Enable_paypal">
									<button type="submit" class="btn btn-template-main" id="CardSubmit" >
										Card Details &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>				
										
								</div>
							</div>
							
						</div>
						
					</form>
					
				</div>
			
			</div>
			
			<?php } ?>
			
		</div>
	</div>
</section>

<?php $this->load->view('header/footer');?>

<script>
/*$('#cod').click(function()
{
	$( "#Enable_cod" ).show();
	$( "#Enable_paypal" ).hide();
});

$('#paypal').click(function()
{
	$( "#Enable_paypal" ).show();
	$( "#Enable_cod" ).hide();
});*/
    
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