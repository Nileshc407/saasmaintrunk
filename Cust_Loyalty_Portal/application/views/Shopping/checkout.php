<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
 $ci_object->load->model('Igain_model');
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
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
							<li class="active"><a href="<?php echo base_url()?>index.php/Shopping/checkout"><i class="fa fa-map-marker"></i>&nbsp; Shipping Details</a></li>
							
							<!--<li class="disabled"><a href="#"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-credit-card"></i><br>Your Card Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>-->
							
						</ul>

						<div class="content">
						
							<div class="row">
							
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="radio-inline">
                                             <input type="radio" checked name="shipping_address" <?php if($ShippingType == 1){echo 'checked="checked"';} ?> id="current_address" value="1" >Your Current Address
											</label>
										</div>
									</div>
									
									<div class="col-sm-6 ">
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
												
												<select class="form-control" name="city" id="city1"  readonly>
									
												<?php 
													foreach($City_array as $rec)
													{
														if($Enroll_details->City == $rec->id){
														?>
														<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
														<?php } }
												?>	
											</select>
											</div>
										</div>
										
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="state">State</label>
												<select class="form-control" name="state" id="state1"  onchange="Get_cities(this.value);"readonly>
									
									<?php 
											foreach($States_array as $rec)
											{
												if($Enroll_details->State == $rec->id){
												?>
												<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
											<?php } }
										?>	
									</select>
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="country">Country</label>
												<select class="form-control" name="country" id="country1"  onchange="Get_states(this.value);" readonly>
									
												<?php 
														foreach($Country_array as $Country)
														{
															if($Enroll_details->Country == $Country['id']){
															?>
															<option value="<?php echo $Country['id'];?>" <?php if($Enroll_details->Country == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>
														<?php } }
													?>
												</select>
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="zip">ZIP</label>
												<input type="text" class="form-control" readonly name="zip" id="zip" value="<?php echo $Enroll_details->Zipcode ?>">
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
                                               <input type="text" class="form-control" name="firstname1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['firstname1'];} ?>" id="firstname1" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" >
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Last Name</label>
                                               <input type="text" class="form-control" name="lastname1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['lastname1'];} ?>" id="lastname1" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" >
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
											
									<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;Country</label>
									<select class="form-control" name="country1" id="country"  onchange="Get_states(this.value);">
									<?php 
										if(isset($_SESSION["To_Country"]))
										{ 
											foreach($Country_array as $Country)
											{
									?>
											<option value="<?php echo $Country['id'];?>" <?php if($_SESSION["To_Country"]==$Country['id']){echo 'selected';}?>><?php echo $Country['name'];?></option>
									<?php	}}
									else{
									?>
									<option value="">Select Country</option>
									<option value="101">India</option>
										<?php 
											foreach($Country_array as $Country)
											{
												echo "<option value=".$Country['id'].">".$Country['name']."</option>";
											}
										?>
									<?php } ?>	
									</select>	
										</div>
										<div class="col-sm-6 col-md-3">
										<?php 
													if(isset($_SESSION["To_State"]))
													{ ?>
													<div class="form-group"  id="Show_States">
								
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;State</label>
												<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);">
												<?php 
													
														$States_array2 = $ci_object->Igain_model->Get_states($_SESSION["To_Country"]);
														foreach($States_array2 as $State)
														{
												?>
														<option value="<?php echo $State->id;?>" <?php if($_SESSION["To_State"]==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
													<?php	}  ?></select></div>
													<?php
													}else{
												?>
												<div class="form-group" id="Show_States">
								
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;State</label>
												<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);">
												
												<option value="">Select Country first</option>
												</select>	
												</div>
												<?php } ?>		
											
											
										</div>
										<div class="col-sm-6 col-md-3">
										
										<?php 
													if(isset($_SESSION["To_State"]))
													{ ?>
											<div class="form-group" id="Show_Cities">
								
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;City</label>
												<select class="form-control" name="city" id="city"  >
												
												<?php 
													
														$City_array2 = $ci_object->Igain_model->Get_cities($_SESSION["To_State"]);
														foreach($City_array2 as $City)
														{
												?>
														<option value="<?php echo $City->id;?>" <?php if($_SESSION["City_id"]==$City->id){echo 'selected';}?>><?php echo $City->name;?></option>
													<?php	} ?>
													</select>							
											</div>
													<?php }
												else{
												?>
												<div class="form-group" id="Show_Cities">
								
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;City</label>
												<select class="form-control" name="city" id="city"  >
												<option value="">Select State first</option>
													
												</select>							
											</div>
												<?php } ?>	
												
													
												
												
												
											
											
											
											
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="zip">ZIP</label>
												<input type="text" class="form-control" name="zip1" id="zip1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['zip1'];} ?>">
											</div>
										</div>
										

										<div class="col-sm-6">
											<div class="form-group">
												<label for="phone">Telephone</label>
												<input type="text" class="form-control" name="phone1" id="phone1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['phone1'];} ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" class="form-control" name="email1" id="email1" value="<?php if($New_shipping_details != ""){echo $New_shipping_details['email1'];} ?>">
											</div>
										</div>

									</div>
								</div>
					<!-- ----------------------------------------------New Addres------------------------------------ -->
								
							</div>

						</div>

						
						
						
						
						
						
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Cart
									</a>
								</div>
								<div class="col-md-6 col-xs-6" align="right">
									<button type="submit" class="btn btn-template-main" id="ContinuetoCart" >
										Cart Details &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
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
$('#change_address').click(function()
{
	$( "#New_address" ).show();
	$( "#Current_address" ).hide();
	
	$("#firstname1").attr("required","required");
	$("#lastname1").attr("required","required");
	$("#address1").attr("required","required");
	$("#city").attr("required","required");
	$("#zip1").attr("required","required");
	$("#state").attr("required","required");
	$("#country").attr("required","required");
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
	$("#city").removeAttr("required");
	$("#zip1").removeAttr("required");
	$("#state").removeAttr("required");
	$("#country").removeAttr("required");
	$("#phone1").removeAttr("required");
	$("#email1").removeAttr("required");
});

$('#ContinuetoCart').click(function()
{
	var shiptype1 = $("input[type=radio]:checked").val(); 
	var shiptype ='<?php echo $ShippingType; ?>';
	if(shiptype1 == 2)
	{
		var email = $("#email1").val()	
		var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  
		if (filter.test(email))
		{
			return true;
		}
		else 
		{
			var Title = "Application Information";
			var msg = 'Please enter valid email id';
			runjs(Title,msg);
			return false;
		}
	}
	else if( shiptype1 == 1)
	{   
		if( $("#firstname").val() =="" || $("#lastname").val() =="" || $("#email").val() == "" || $("#address").val() == "" ||  $("#city1").val() == "" || $("#state1").val() == "" || $("#country1").val() == "" ||  $("#phone").val() == "" ||  $("#zip").val() == "" )
		{
			msg= 'Please Complete your address details from profile';
			var Title = "Application Information";	
			runjs(Title,msg);
			return false;
		}
		else
		{
		   return true; 
		}
	}
	else
	{
		return true;
	}
});
/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	 // alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo $this->config->item('base_url2')?>index.php/Company/Get_states",
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
		url: "<?php echo $this->config->item('base_url2')?>index.php/Company/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			
		}
	});
}
/************************************************************************/	
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