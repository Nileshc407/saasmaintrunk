<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
/*echo "<pre>";
var_dump($_SESSION);
echo "</pre>";*/
?>
	
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		
<section class="content-header">
	<h1>Checkout - Address</h1>
</section>		
		
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
		
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
				
					<?php /* <form method="post" action="<?php echo base_url()?>index.php/Shopping/Card_details"> */ ?>
					<form method="post" action="<?php echo base_url()?>index.php/Shopping/checkout_cart_details">

						<ul class="nav nav-pills nav-justified">
							<li class="active"><a href="<?php echo base_url()?>index.php/Shopping/checkout"><i class="fa fa-map-marker"></i><br>Shipping Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>
                                                        <li class="disabled"><a href="#"><i class="fa fa-credit-card"></i><br>Your Card Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>
						</ul>

						<div class="content">
						
							<div class="row">
							
								<div class="col-sm-12">
									<div class="col-sm-6 text-center">
										<div class="form-group">
											<label class="radio-inline">
                                                                                                <input type="radio" checked name="shipping_address" <?php if($ShippingType == 1){echo 'checked="checked"';} ?> id="current_address" value="1" >Your Current Address
											</label>
										</div>
									</div>
									
									<div class="col-sm-6 text-center">
										<div class="form-group">
											<label class="radio-inline">
												<input type="radio" name="shipping_address" <?php if($ShippingType == 2){echo 'checked="checked"';} ?> id="change_address" value="2" >New Address
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-12"><hr></div>
								
						<!-- -------------------------------------------Current Addres----------------------------------- -->
								<div class="col-sm-12" id="Current_address" <?php if($ShippingType == 2){echo 'style="display:none;"';} ?> >
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="firstname">First Name</label>
												<input type="text" class="form-control" readonly name="firstname" id="firstname" value="<?php echo $Enroll_details->First_name ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Last Name</label>
												<input type="text" class="form-control" readonly name="lastname" id="lastname" value="<?php echo $Enroll_details->Last_name ?>">
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label for="company">Address</label>
												<textarea class="form-control" readonly name="address" id="address"><?php echo $Enroll_details->Current_address ?></textarea>
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="city">City</label>
												<input type="text" class="form-control" readonly name="city" id="city" value="<?php echo $Enroll_details->City ?>">
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="zip">ZIP</label>
												<input type="text" class="form-control" readonly name="zip" id="zip" value="<?php echo $Enroll_details->Zipcode ?>">
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="state">State</label>
												<input type="text" class="form-control" readonly name="state" id="state" value="<?php echo $Enroll_details->State ?>">
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="country">Country</label>
												<input type="text" class="form-control" readonly name="country" id="country" value="<?php echo $Enroll_details->State ?>">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="phone">Telephone</label>
												<input type="text" class="form-control" readonly name="phone" id="phone" value="<?php echo $Enroll_details->Phone_no ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" class="form-control" readonly name="email" id="email" value="<?php echo $Enroll_details->User_email_id ?>">
											</div>
										</div>

									</div>
								</div>
						<!-- -------------------------------------------Current Addres----------------------------------- -->
								
								
						<!-- ----------------------------------------------New Addres------------------------------------ -->
								<div class="col-sm-12" id="New_address" <?php if($ShippingType == 1){echo 'style="display:none;"';} ?>>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="firstname">First Name</label>
                                                                                                <input type="text" class="form-control" name="firstname1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['firstname1'];} ?>" id="firstname1" >
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Last Name</label>
                                                                                                <input type="text" class="form-control" name="lastname1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['lastname1'];} ?>" id="lastname1" >
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label for="company">Address</label>
                                                                                                <textarea class="form-control" name="address1" id="address1" ><?php if($New_shipping_details != ""){echo $New_shipping_details['address1'];} ?></textarea>
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="city">City</label>
                                                                                                <input type="text" class="form-control" name="city1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['city1'];} ?>" id="city1" >
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="zip">ZIP</label>
                                                                                                <input type="text" class="form-control" name="zip1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['zip1'];} ?>" id="zip1" onkeyup="this.value=this.value.replace(/\D/g,'')" >
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="state">State</label>
                                                                                                <input type="text" class="form-control" name="state1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['state1'];} ?>" id="state1" >
											</div>
										</div>
										<!--<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="country">Country</label>
                                                                                                <input type="text" class="form-control" name="country1" value="<?php //if($New_shipping_details != ""){echo $New_shipping_details['country1'];} ?>" id="country1" >
											</div>
										</div>-->

										<div class="col-sm-6">
											<div class="form-group">
												<label for="phone">Telephone</label>
                                                                                                <input type="text" class="form-control" name="phone1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['phone1'];} ?>" id="phone1" onkeyup="this.value=this.value.replace(/\D/g,'')">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email">Email</label>
                                                                                                <input type="text" class="form-control" name="email1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['email1'];} ?>" id="email1" >
											</div>
										</div>

									</div>
								</div>
					<!-- ----------------------------------------------New Addres------------------------------------ -->
								
							</div>

						</div>

						<div class="box-footer">
							<div class="pull-left">
								<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-default">
									<i class="fa fa-chevron-left"></i>&nbsp;Back to Cart
								</a>
							</div>
							<div class="pull-right">
								<?php /* <a href="<?php echo base_url()?>index.php/Shopping/Card_details" class="btn btn-template-main">
									Continue to Card Details &nbsp;<i class="fa fa-chevron-right"></i>
								</a>
								
								<button type="submit" class="btn btn-template-main">
									Continue to Card Details &nbsp;<i class="fa fa-chevron-right"></i>
								</button> */ ?>
                                                            
                                                                <button type="submit" class="btn btn-template-main">
									Continue to Cart Details&nbsp;<i class="fa fa-chevron-right"></i>
								</button>
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
$('#change_address').click(function()
{
	$( "#New_address" ).show();
	$( "#Current_address" ).hide();
	
	$("#firstname1").attr("required","required");
	$("#lastname1").attr("required","required");
	$("#address1").attr("required","required");
	$("#city1").attr("required","required");
	$("#zip1").attr("required","required");
	$("#state1").attr("required","required");
	$("#country1").attr("required","required");
	$("#phone1").attr("required","required");
	$("#email1").attr("required","required");
});

$('#current_address').click(function()
{
	$( "#Current_address" ).show();
	$( "#New_address" ).hide();
	
	$("#firstname1").removeAttr("required");
	$("#lastname1").removeAttr("required");
	$("#address1").removeAttr("required");
	$("#city1").removeAttr("required");
	$("#zip1").removeAttr("required");
	$("#state1").removeAttr("required");
	$("#country1").removeAttr("required");
	$("#phone1").removeAttr("required");
	$("#email1").removeAttr("required");
});
</script>