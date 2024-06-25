<?php
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>	
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>	
<style>
</style>		
<section class="content-header">
	<h1>Checkout - Shipping Address</h1>
</section>				
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
			<div class="col-md-12 clearfix" id="checkout">				
				<div class="box">			
					<ul class="nav nav-pills nav-justified">
					 <!--<li><a href="<?php //echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue"><i class="fa fa-shopping-cart"></i><br>Checkout</a></li> -->
					<li  class="active"><a href="#" style="cursor:not-allowed;"><i class="fa fa-map-marker"></i>&nbsp; Shipping Address</a></li>
					<!--<li><a href="#" style="cursor:not-allowed;"><i class="fa fa-eye"></i><br>Review Redemption</a></li>-->
					
					</ul>
						
					 <?php /*	?>
						<ul class="nav nav-pills">
							<li ><a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue"><i class="fa fa-shopping-cart"></i><br>Checkout</a></li>
							<li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Shipping Address</a></li>
							<li><a href="#"><i class="fa fa-fa-eye"></i><br>Review Redemption</a></li>
						</ul>
						
					<?php */	?>
						
					<?php  echo form_open('Redemption_Catalogue/Review_Redemption'); ?>
					<?php 
							$Exist_Delivery_method=0;
							if(isset($_SESSION["To_Country"]))
							{
								$To_Country=$_SESSION["To_Country"];
								$To_State=$_SESSION["To_State"];
							}
							$Sub_total2=0;
							foreach ($Redemption_Items as $item2) 
							{									
								$Sub_total2=$Sub_total2+$item2["Total_points"];
							}
							foreach ($Redemption_Items as $item) 
							{									
								$Get_Code_decode = $ci_object->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
								$Redemption_method=$Get_Code_decode->Code_decode;
								if($item["Redemption_method"]==29)
								{
									$Exist_Delivery_method=1;
									$Get_weight_items = $ci_object->Redemption_Model->get_weight_items_same_location($item["Partner_state"],$enroll);
									$Weight_in_KG=0;
									foreach($Get_weight_items as $rec)
									{
										$Total_weight_same_location=$rec["Total_weight_same_location"];
										$lv_Weight_unit_id=$rec["Weight_unit_id"];
										/*******Total Weight convert into KG for same location****/
										$kg=1;
										switch ($lv_Weight_unit_id)
										{
											case 2://gram
											$kg=0.001;break;
											case 3://pound
											$kg=0.45359237;break;
										}
										$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
										// echo "<br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id;
									}
									/*******Single Weight convert into KG****/

									$kg2=1;
									switch ($item["Weight_unit_id"])
									{
										case 2://gram
										$kg2=0.001;break;
										case 3://pound
										$kg2=0.45359237;break;
									}
									
									/**************************/
									
									
									$Single_Item_Weight_in_KG=($item["Weight"]*$item["Quantity"]*$kg2);
									
									// echo "<br><br><b>Merchandize_item_name </b>".$item["Merchandize_item_name"]." <br><b>Weight </b>".$item["Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["Quantity"]." <br><b>Weight_unit_id </b>".$item["Weight_unit_id"]." <br><b>Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$item["Partner_state"]." <br><b>Temp_cart_id </b>".$item["Temp_cart_id"];
								}
								else
								{
									$Total_Weighted_avg_shipping_pts[]=0;
									$Weighted_avg_shipping_pts="-";
								}
								if($Shipping_charges_flag==2)
								{
									if($item["Redemption_method"]==29)
									{
										$Get_shipping_points = $ci_object->Igain_model->Get_delivery_price_master($item["Partner_Country_id"],$item["Partner_state"],$To_Country,$To_State,$Weight_in_KG,1);
										$Shipping_cost= $Get_shipping_points->Delivery_price;
										$Shipping_pts=round($Shipping_cost*$Redemptionratio);
										$Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
										$Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
										// echo "<br><b>Shipping_cost </b>".$Shipping_cost;
									}
								}
								elseif($Shipping_charges_flag==1)//Standard Charges
								{
									if($item["Redemption_method"]==29)
									{
										$Cost_Threshold_Limit2=round($Cost_Threshold_Limit*$Redemptionratio);
										if($Sub_total2 >= $Cost_Threshold_Limit2)
										{	
											$Shipping_pts=round($Standard_charges*$Redemptionratio);
											$Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
											$Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
										}
										else
										{
											$Shipping_pts=0;
											$Weighted_avg_shipping_pts=0;
											$Total_Weighted_avg_shipping_pts[]=0;
										}
										// echo "<br><b>Standard_charges </b>".$Standard_charges;
									}
								}
								else
								{
									$Shipping_pts=0;
									$Weighted_avg_shipping_pts=0;
									$Total_Weighted_avg_shipping_pts[]=0;
								}
								
								// echo "<br><b>Shipping_pts </b>".$Shipping_pts;
								// echo "<br><b>Weighted_avg_shipping_pts </b>".$Weighted_avg_shipping_pts;
								$Sub_Total[]=$item["Total_points"];
								echo '<input type="hidden" name="Hidden_Weighted_avg_shipping_pts_'.$item['Temp_cart_id'].'" id="Hidden_Weighted_avg_shipping_pts_'.$item['Temp_cart_id'].'" value="'.$Weighted_avg_shipping_pts.'">';
							}	
								$lv_Sub_Total=array_sum($Sub_Total);
								$Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
								$Grand_total=($lv_Sub_Total+$Total_Shipping_Points);
							?>
						<input type="hidden" name="Current_balance" value="<?php echo $Enroll_details->Current_balance;?>">
						<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
						<input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
						<input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
						<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
						<input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
						
						<div class="content">						
							<div class="row">							
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="radio-inline">
												<input type="radio" name="shipping_address" id="current_address" value="1" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 1){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>>Your Current Address
											</label>
										</div>
									</div>									
									<div class="col-sm-6 ">
										<div class="form-group">
											<label class="radio-inline">
												<input type="radio" name="shipping_address" id="change_address" value="2" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 2){echo 'checked="checked"';}} ?>>New Address
											</label>
										</div>
									</div>
								</div>								
								<div class="col-sm-12"><hr></div>								
							<!-- -------------------Current Addres------------------------ -->
								<div class="col-sm-12" id="Current_address" <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 2){echo 'style="display:none;"';}} ?>>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="firstname">Firstname</label>
												<input type="text" class="form-control" readonly name="firstname" id="firstname" value="<?php echo $Enroll_details->First_name ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Lastname</label>
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
												
												<select class="form-control" name="city" id="city1" readonly>
									
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
												<select class="form-control" name="state" id="state1"  onchange="Get_cities(this.value);" readonly>
									
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
						<!-------------------------Current Addres--------------->								<!---------------------------New Addres--------------------->
								<div class="col-sm-12" id="New_address"  <?php if(isset($_SESSION["shipping_address"])){if($_SESSION["shipping_address"] == 1){echo 'style="display:none;"';}}else {echo 'style="display:none;"';}  ?> >
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="firstname">Firstname</label>
												<input type="text" class="form-control" name="firstname1" id="firstname1" value="<?php if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"];} ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Lastname</label>
												<input type="text" class="form-control" name="lastname1" id="lastname1"  value="<?php if(isset($_SESSION["lastname"])){echo $_SESSION["lastname"];} ?>">
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label for="company">Address</label>
												<textarea class="form-control" name="address1" id="address1"> <?php if(isset($_SESSION["address"])){echo $_SESSION["address"];} ?></textarea>
											</div>
										</div>
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-sm-6 col-md-3">
											
									<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;Country</label>
									<select class="form-control" name="country1" id="country"  onchange="Get_states(this.value);">
									<option value="">Select Country</option>
									<?php 
										if(isset($_SESSION["To_Country"]))
										{ 
											foreach($Country_array as $Country)
											{
									?>
											<option value="<?php echo $Country['id'];?>" <?php if($_SESSION["To_Country"]==$Country['id']){echo 'selected';}?>><?php echo $Country['name'];?></option>
									<?php	}
									}
									else
									{
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
												<select class="form-control" name="city" id="city">
												
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
												<select class="form-control" name="city" id="city" >
												<option value="">Select State first</option>
													
												</select>							
											</div>
												<?php } ?>	
											
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="form-group">
												<label for="zip">ZIP</label>
												<input type="text" class="form-control" name="zip1" id="zip1"  value="<?php if(isset($_SESSION["zip"])){echo $_SESSION["zip"];} ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" >
											</div>
										</div>
										

										<div class="col-sm-6">
											<div class="form-group">
												<label for="phone">Telephone</label>
												<input type="text" class="form-control" name="phone1" id="phone1"  value="<?php if(isset($_SESSION["phone"])){echo $_SESSION["phone"];} ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" class="form-control" name="email1" id="email1"  value="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?>"> 
											</div>
										</div>

									</div>
								</div>								
							<!---------------------------New Addres--------------------->						
							</div>
						</div>
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Checkout
									</a>
								</div>
								<div class="col-md-6 col-xs-6" align="right">
									<button type="submit" class="btn btn-template-main" id="ContinuetoCart">
										Review &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>
								</div>
							</div>							
						</div>						
					</form>
				</div>	
			</div>	
		</div>
	</div>
</section>
<?php $this->load->view('header/footer');?>
<script>
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
	if(shiptype1 == 2)
	{
		var email = $("#email1").val()
		var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if($("#firstname1").val() == "")
		{	
			msg= 'Please enter First Name';
			var Title = "Application Information";	
			runjs(Title,msg);
			return false;			
		}
		else if($("#lastname1").val() == "")
		{	
			msg= 'Please enter Last Name';
			var Title = "Application Information";	
			runjs(Title,msg);
			return false;			
		}
		else if(filter.test(email) == false)
		{			
			msg= 'Please enter valid email id';
			var Title = "Application Information";	
			runjs(Title,msg);
			return false;
		}
		else if($("#address1").val() == "")
		{	
			msg= 'Please enter Address';
			var Title = "Application Information";	
			runjs(Title,msg);			
			return false;			
		}
		else if($("#country1").val() == "")
		{
			msg= 'Please Select Country';
			var Title = "Application Information";	
			runjs(Title,msg);
			return false;			
		}
		else if($("#state1").val() == "")
		{	
			msg= 'Please Select State';
			var Title = "Application Information";	
			runjs(Title,msg);				
			return false;			
		}
		else if($("#city1").val() == "")
		{	
			msg= 'Please Select City';
			var Title = "Application Information";	
			runjs(Title,msg);			
			return false;			
		}
		else if($("#zip1").val() == "")
		{	
			msg= 'Please enter Zipcode';
			var Title = "Application Information";	
			runjs(Title,msg);
			
			return false;			
		}
		else if($("#phone1").val() == "")
		{	
			msg= 'Please enter Phone Number';
			var Title = "Application Information";	
			runjs(Title,msg);
			
			return false;			
		}
		else
		{
			return true;
		}
	}
	else if( shiptype1 == 1)
	{   
		if( $("#firstname").val() =="" || $("#lastname").val() =="" || $("#email").val() == "" || $("#address").val() == "" ||  $("#city1").val() == "" || $("#state1").val() == "" || $("#country1").val() == "" ||  $("#phone").val() == "" ||  $("#zip").val() == "" )
		{
			msg= 'Please update your address details from profile';
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
	return false;
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