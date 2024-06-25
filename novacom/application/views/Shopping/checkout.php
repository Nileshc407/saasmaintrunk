<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
$ci_object->load->model('Igain_model');
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$Address_type_details=$ci_object->Igain_model->Fetch_selected_customer_addresses($enroll);
$Outlet_cites = $ci_object->Igain_model->Fetch_outlet_cites($Company_id);
?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>	
	
<section class="content-header">
	<h1>Checkout - Address</h1>
</section>				
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
		<?php if(empty($cart_check)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center">Your Shopping Cart is Empty. Please click on Continue ordering to Add items to Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Continue Ordering
						</a>
					</p>
				</div>
		<?php } ?>
			<?php
			  /* if (@$this->session->flashdata('error_code')) {
				?>
				<script>
				  var Title = "Application Information";
				  var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
				  runjs(Title, msg);
				</script>
				<?php
				} */
			?>
			
			<?php if ($cart = $this->cart->contents()) { ?>
				<div class="col-md-12 clearfix" id="checkout">
				<div class="box">
					<form method="POST" action="<?php echo base_url()?>index.php/Shopping/checkout_cart_details">
						<div class="row">
							<div class="col-sm-12">
								<ul class="nav nav-pills nav-justified">
									<li class="active"><a href="#"><i class="fa fa-map-marker"></i>&nbsp; Select Delivery Address</a></li>
								</ul>
							</div>
						</div>	
						<div class="row">							
							<div class="col-md-3">
									<p class="text-center"><font style="font-weight: bold;font-size:18px;"> Current Address</font></p>
									<div class="card">
										<article class="card-body">
										<?php
											$Customer_current_address1 = (explode(",", App_string_decrypt($Customer_current_address->Address))); 
										 
											$address_line1 = $Customer_current_address1['0'];
											$address_line2 = $Customer_current_address1['1'];
											$address_line3 = $Customer_current_address1['2'];
											$address_line4 = $Customer_current_address1['3'];
											?>
											<div style="min-height: 115px;">
												<p class="card-text"><?php echo $Customer_current_address->Contact_person; ?> </p>
												<?php /*<p class="card-text"><?php echo $Customer_current_address->Address ?></p> */ ?>
												<p class="card-text"><?php echo $address_line1.','; ?></p>
												<p class="card-text"><?php echo $address_line2.','; ?></p>
												<p class="card-text"><?php echo $address_line3.','; ?></p>
												<p class="card-text"><?php if($address_line4!=Null) { echo $address_line4.','; } ?></p>
												<p class="card-text"><?php echo $Customer_current_address->city_name.', '; ?> <?php echo $Customer_current_address->country_name; ?>.
												</p> 
											</div>	
																								
												<div class="form-group">
													<!--<button type="submit" name="submit" value="Current_Address" class="btn btn-primary btn-block" id="ContinuetoCart"> Deliver to this Address  </button>
													-->
													<input type="submit" name="Current_Address" value="Deliver to this Address" class="btn btn-primary btn-block" onclick="javascript:document.getElementById('address_flag').value=0" <?php if($Address_type_details->Address_type==0){echo 'style="background-color:green;"';}?>>
												</div>
													
											<!-- 
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<button type="button" class="btn btn-template-main btn-block"  data-toggle="modal" data-target="#CurrentAddress"> Edit  </button>
													</div> <!-- form-group// 
												</div>
												<div class="col-md-6 text-right">
													<button type="button" class="btn btn-template-main btn-block" onclick="javascript:delete_address(<?php echo $Customer_current_address->Address_id; ?>);"> Delete  </button>
												</div>                                            
											</div>
											-->
										</article>
									</div>
							</div>
							<div class="col-md-1">
							</div>						 
							<div class="col-md-3">
								<p class="text-center"><font style="font-weight: bold;font-size:18px;"> Work Address</font></p>
									<?php if($Customer_work_address ) { ?>
									<div class="card">
									<?php 
										$Customer_work_address1 = (explode(",", App_string_decrypt($Customer_work_address->Address))); 
									 
										$work_address_line1 = $Customer_work_address1['0'];
										$work_address_line2 = $Customer_work_address1['1'];
										$work_address_line3 = $Customer_work_address1['2'];
										$work_address_line4 = $Customer_work_address1['3']; 
									?>
										<article class="card-body" style=" min-height: 150px;">
											<div style="min-height: 115px;">
												<p class="card-text"><?php echo $Customer_work_address->Contact_person; ?> </p>
												<?php /*<p class="card-text"><?php echo $Customer_work_address->Address ?> */ ?>
												<p class="card-text"><?php echo $work_address_line1.','; ?>
												<p class="card-text"><?php echo $work_address_line2.','; ?>
												<p class="card-text"><?php echo $work_address_line3.','; ?>
												<p class="card-text"><?php if($work_address_line4!=Null) { echo $work_address_line4.','; } ?>
												<p class="card-text"><?php echo $Customer_work_address->city_name.', '; ?><?php echo $Customer_work_address->country_name; ?>.
												</p>												
											</div>												
											<div class="form-group">
												<!--<button type="submit" name="submit" value="Work_Address" class="btn btn-primary btn-block" id="ContinuetoCart"> Deliver to this Address  </button>-->
												
												<input type="submit" name="Work_Address" value="Deliver to this Address" class="btn btn-primary btn-block"  onclick="javascript:document.getElementById('address_flag').value=1" <?php if($Address_type_details->Address_type==1){echo 'style="background-color:green;"';}?>>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<button type="button" class="btn btn-template-main btn-block" data-toggle="modal" data-target="#WorkAddress"> Edit  </button>
													</div> <!-- form-group// -->
												</div>
												<div class="col-md-6 text-right">
													<button type="button" class="btn btn-template-main btn-block" onclick="javascript:delete_address(<?php echo $Customer_work_address->Address_id ?>);"> Delete  </button>
												</div>                                            
											</div>
										</article>
									</div>
									<?php } else { ?>
											<div class="card">							
												<div class="form-group">
													<button type="button" class="btn btn-primary btn-block"  data-toggle="modal" data-target="#WorkAddress"> Add new Address </button>
												</div>
											</div>
									<?php } ?>
							</div>
							<div class="col-md-1">
							</div>
							<div class="col-md-3">
								<p class="text-center"><font style="font-weight: bold;font-size:18px;"> New Address</font></p>
								<?php if($Customer_other_address ) { ?>
									<div class="card">
									<?php 
										$Customer_other_address1 = (explode(",", App_string_decrypt($Customer_other_address->Address))); 
									 
										$other_address_line1 = $Customer_other_address1['0'];
										$other_address_line2 = $Customer_other_address1['1'];
										$other_address_line3 = $Customer_other_address1['2'];
										$other_address_line4 = $Customer_other_address1['3']; 
									?>
										<article class="card-body">
											<div style="min-height: 115px;">
												<p class="card-text"><?php echo $Customer_other_address->Contact_person; ?> </p>
												<?php /*<p class="card-text"><?php echo $Customer_other_address->Address ?> */ ?>
												<p class="card-text"><?php echo $other_address_line1.','; ?>
												<p class="card-text"><?php echo $other_address_line2.','; ?>
												<p class="card-text"><?php echo $other_address_line3.','; ?>
												<p class="card-text"><?php if($other_address_line4!=Null) { echo $other_address_line4.','; }?>
												
												<p class="card-text"><?php echo $Customer_other_address->city_name.', '; ?><?php echo $Customer_other_address->country_name; ?>.
												</p>
											</div>														
												<div class="form-group">
												
												<input type="submit" name="Other_Address" value="Deliver to this Address" class="btn btn-primary btn-block"  onclick="javascript:document.getElementById('address_flag').value=2" <?php if($Address_type_details->Address_type==2){echo 'style="background-color:green;"';}?>>
												
													<!--<button type="submit" name="submit" value="Other_Address" class="btn btn-primary btn-block" id="ContinuetoCart"> Deliver to this Address  </button>-->
												</div>													
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<button type="button" class="btn btn-template-main btn-block" data-toggle="modal" data-target="#OtherAddress"> Edit  </button>
													</div> <!-- form-group// -->
												</div>
												<div class="col-md-6 text-right">
													<button type="button" class="btn btn-template-main btn-block" onclick="javascript:delete_address(<?php echo $Customer_other_address->Address_id; ?>);"> Delete  </button>
												</div>                                            
											</div>
										</article>
									</div>
									<?php } else { ?>
											<div class="card">								
												<div class="form-group">
													<button type="button" class="btn btn-primary btn-block"  data-toggle="modal" data-target="#OtherAddress" > Add new Address </button>
												</div>	
											</div>
									<?php } ?>
						  </div>
						</div>
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-default" style="font-weight: 700;font-family: 'Roboto', Helvetica, Arial, sans-serif;text-transform: uppercase;letter-spacing: 0.08em;padding: 6px 12px;font-size: 13px;line-height: 1.42857143;border-radius: 0;: 0px;">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; View Cart
									</a>
								</div>
							</div>
						</div><br>
						
					<?php	/* <!--<hr>
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
							
						</div>-->
						
						<!--<input type="text" name="form_checkout" value="1">
						<input type="text" name="delivery_type" value="<?php echo $delivery_type; ?>">
						<input type="text" name="DeliveryType" 	value="<?php echo $delivery_type; ?>">
						<input type="text" name="delivery_outlet" value="<?php echo $delivery_outlet; ?>">
						<input type="text" name="DeliveryOutlet" value="<?php echo $delivery_outlet; ?>">-->  */ ?>
						
						<input type="hidden" name="address_flag"  id="address_flag" value="" >
					</form>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
	
	<!---------------- Current Address Modal ---------------------->
		<div id="CurrentAddress" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<form action="<?php echo base_url(); ?>index.php/Shopping/customer_address" method="POST">
					<div class="modal-header">				
						<h4 class="modal-title">Enter Current Address</h4>
					</div>
						<div class="row">
							<div class="col-md-6">
								<div class="modal-body">						
									<div class="form-group">
										<label for="email">Contact Person:</label>
										<input type="text" class="form-control" id="Contact_person" name="Contact_person" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" value="<?php if($Customer_current_address->Contact_person != ""){echo  $Customer_current_address->Contact_person;} ?>"  required>
									</div>
									<div class="form-group">
										<label for="email">Address:</label>
										<textarea type="text" class="form-control" id="Address" name="Address"  required><?php if($Customer_current_address->Address != ""){echo  $Customer_current_address->Address;} ?></textarea>
									</div>
									<div class="form-group">
										<label for="pwd">Zipcode:</label>
										<input type="text" class="form-control" id="Zipcode" name="Zipcode" maxlength="6" value="<?php if($Customer_current_address->Zipcode != ""){echo  $Customer_current_address->Zipcode;} ?>" required>
									</div>
									<div class="form-group">
										<label for="pwd">Phone No.:</label>
										<input type="text" class="form-control" id="Phone_no" name="Phone_no" maxlength="10" value="<?php if($Customer_current_address->Phone_no != ""){echo  $Customer_current_address->Phone_no;} ?>" onkeypress="return isNumber(event)"  required>
									</div>													  
								</div>
							</div>
							<div class="col-md-6">
								<div class="modal-body">
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;Country</label>
										<select class="form-control" name="country" id="country"  onchange="Get_states(this.value);" required>
										<?php 
											if($Customer_current_address->Country_id != "")
											{ 
												foreach($Country_array as $Country)
												{
										?>
												<option value="<?php echo $Country['id'];?>" <?php if($Customer_current_address->Country_id==$Country['id']){echo 'selected';}?>><?php echo $Country['name'];?></option>
										<?php	}
										
										}
										else{
										?>
										<option value="">Select Country</option>
										
											<?php 
												foreach($Country_array as $Country)
												{
													echo "<option value=".$Country['id'].">".$Country['name']."</option>";
												}
											?>
										<?php } ?>	
										</select>
									</div>	
									<div class="form-group">
										<?php 
											if($Customer_current_address->State_id != "")
											{ ?>
											<div class="form-group"  id="Show_States">
						
													<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;State</label>
													<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);">
													<?php 
														
															$States_array2 = $ci_object->Igain_model->Get_states($Customer_current_address->Country_id);
															foreach($States_array2 as $State)
															{
													?>
															<option value="<?php echo $State->id;?>" <?php if($Customer_current_address->State_id==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
														<?php	}  ?></select>
											
											</div>
											<?php
											} else {
										?>
										<div class="form-group" id="Show_States">
										<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;State</label>
										<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);" required>
											<option value="">Select Country first</option>
										</select>	
										</div>
										<?php } ?>	
									</div>
									<div class="form-group">
									<?php 
										if($Customer_current_address->City_id != "")
										{ ?>
											<div class="form-group" id="Show_Cities">
								
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;City</label>
												<select class="form-control" name="city" id="city">
												<?php 
														$City_array2 = $ci_object->Igain_model->Get_cities($Customer_current_address->State_id);
														foreach($City_array2 as $City)
														{ ?>
															<option value="<?php echo $City->id;?>" <?php if($Customer_current_address->City_id ==$City->id){echo 'selected';}?>><?php echo $City->name;?></option>
												<?php	} ?>
													</select>							
											</div>
								<?php	}
										else 	
										{	?>
											<div class="form-group" id="Show_Cities">
												<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;City</label>
												<select class="form-control" name="city" id="city"  >
												<option value="">Select State first</option>
												</select>							
											</div>
								<?php 	} ?>	
									</div>		  
								</div>
							</div>
						</div>
					<div class="modal-footer">
					<input type="hidden" class="form-control" id="Address_type" name="Address_type" value="0">
					 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-template-main text-right">Save Address</button>
				</form>
			  </div>
			</div>
		  </div>
		</div>
		<!---------------- Current Address Modal ---------------------->
		<!---------------- Work Address Modal ---------------------->
		<div id="WorkAddress" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<form action="<?php echo base_url(); ?>index.php/Shopping/customer_address" method="POST">
					<div class="modal-header">				
						<h4 class="modal-title">Enter Work Address</h4> 
					</div>
						<div class="row">
							<div class="col-md-6">
								<div class="modal-body">						
									<div class="form-group has-feedback">
										<label for="email"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Contact Person:</label>
										<input type="text" class="form-control" id="Contact_person" name="Contact_person" placeholder=" Contact person" value="<?php if($Customer_work_address->Contact_person != ""){echo  $Customer_work_address->Contact_person;} ?>" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" required>
									</div> <?php /*
									<div class="form-group">
										<label for="email">Address:</label>
										<textarea type="text" class="form-control" id="Address" name="Address"  required><?php if($Customer_work_address->Address != ""){echo  $Customer_work_address->Address;} ?></textarea>
									</div> */ ?>
									<?php $work_address = (explode(",", App_string_decrypt($Customer_work_address->Address))); ?> 
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Estate / Building Name</label>
										<input type="text" name="Building_name" class="form-control" id="Building_name" value="<?php echo $work_address['0'];?>" placeholder=" Estate / Building Name" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;House Number / Floor</label>
										<input type="text" name="House_no" class="form-control" id="House_no" value="<?php echo $work_address['1'];?>" placeholder=" House Number / Floor" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Street / Road</label>
										<input type="text" name="Street_road" class="form-control" id="Street_road" value="<?php echo $work_address['2'];?>" placeholder=" Street / Road" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1">&nbsp; Additional</label>
										<input type="text" name="Additional" class="form-control" id="Additional" value="<?php echo $work_address['3'];?>" placeholder=" Additional" maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>											  
								</div>
							</div>
							<div class="col-md-6">
								<div class="modal-body">
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Country</label>
										<select class="form-control" name="country" id="country2"  onchange="Get_states(this.value);" required>
											<?php 
												foreach($Country_array as $Country)
												{
													if($Country['id'] == $cust_Country_id)
													{
														echo "<option value=".$Country['id'].">".$Country['name']."</option>";
													}
												}
											?>
										</select>
									</div>	
									<?php /*
									<div class="form-group">
										<div class="form-group" >
											<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;State</label>
											<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);">
											<?php 
												
													$States_array2 = $ci_object->Igain_model->Get_states($cust_Country_id);
													foreach($States_array2 as $State)
													{
											?>
													<option value="<?php echo $State->id;?>" <?php if($cust_State==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
												<?php	}  ?></select>
										</div>
									</div> */ ?>
									<input type="hidden" name="state" id="state" value="<?php echo $cust_State ;?>">
									<div class="form-group">
										<div class="form-group">
											<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;City</label>
											<select class="form-control" name="city" id="city">
											<?php 
													$City_array2 = $ci_object->Igain_model->Get_cities($cust_State);
													
													foreach($City_array2 as $City1)
													{
														foreach($Outlet_cites as $cites) 
														{ 
															if($cites->City == $City1->id)  
															{ 		?>
																<option value="<?php echo $City1->id;?>" <?php if($Customer_work_address->City_id ==$City1->id){echo 'selected';}?>><?php echo $City1->name;?></option>
													<?php	}
														}
													}	?>
												</select>							
										</div>
									</div> 
									<?php /*
									<div class="form-group">
										<label for="pwd"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Zipcode:</label>
										<input type="text" class="form-control" id="Zipcode" name="Zipcode" maxlength="6" placeholder="Zipcode" value="<?php if($Customer_work_address->Zipcode != ""){echo  $Customer_work_address->Zipcode;} ?>" required>
									</div> */?>
									
									<div class="form-group">
										<label for="pwd"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Phone No.</label>
										<input type="text" class="form-control" id="Phone_no" name="Phone_no" placeholder="Phone no." maxlength="10" value="<?php if($Customer_work_address->Phone_no != ""){echo App_string_decrypt($Customer_work_address->Phone_no);} ?>" onkeypress="return isNumber(event)"  required>
									</div>		  
								</div>
							</div>
						</div>
					<div class="modal-footer">
					<input type="hidden" class="form-control" id="Address_type" name="Address_type" value="1">
					<input type="hidden" name="delivery_type" 	value="<?php echo $delivery_type; ?>">
						<input type="hidden" name="delivery_outlet" value="<?php echo $delivery_outlet; ?>">
					 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-template-main text-right">Save Address</button>
					 </div>
				</form>
			</div>
		  </div>
		</div>
		<!---------------- Work Address Modal ---------------------->
		<!---------------- Other Address Modal ---------------------->
		<div id="OtherAddress" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<form action="<?php echo base_url(); ?>index.php/Shopping/customer_address" method="POST">
					<div class="modal-header">				
						<h4 class="modal-title">Enter Other Address</h4>
					</div>
						<div class="row">
							<div class="col-md-6">
								<div class="modal-body">						
									<div class="form-group">
										<label for="email"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Contact Person:</label>
										<input type="text" class="form-control" id="Contact_person" name="Contact_person" placeholder="Contact person" onkeyup="this.value=this.value.replace(/[^a-z A-Z ]/g,'');" value="<?php if($Customer_other_address->Contact_person != ""){echo  $Customer_other_address->Contact_person;} ?>" required>
									</div>  
									<?php /*
									<div class="form-group">
										<label for="email">Address:</label>
										<textarea type="text" class="form-control" id="Address" name="Address"  required> <?php if($Customer_other_address->Address != ""){echo  $Customer_other_address->Address;} ?> </textarea>
									</div>  */ ?>
									<?php $other_address = (explode(",", App_string_decrypt($Customer_other_address->Address))); ?>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Estate / Building Name</label>
										<input type="text" name="Building_name" class="form-control" id="Building_name" value="<?php echo $other_address['0'];?>" placeholder=" Estate / Building Name" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;House Number / Floor</label>
										<input type="text" name="House_no" class="form-control" id="House_no" value="<?php echo $other_address['1'];?>" placeholder=" House Number / Floor" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Street / Road</label>
										<input type="text" name="Street_road" class="form-control" id="Street_road" value="<?php echo $other_address['2'];?>" placeholder=" Street / Road" required maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>
									<div class="form-group has-feedback">
										 <label for="exampleInputEmail1">&nbsp; Additional</label>
										<input type="text" name="Additional" class="form-control" id="Additional" value="<?php echo $other_address['3'];?>" placeholder=" Additional" maxlength="32" onkeypress="return IsAlphaNumeric(event);">
									</div>											  
								</div>
							</div>
							<div class="col-md-6">
								<div class="modal-body">
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Country</label>
										<select class="form-control" name="country" id="country2"  onchange="Get_states(this.value);" required>
											<?php 
												foreach($Country_array as $Country)
												{
													if($Country['id'] == $cust_Country_id)
													{
													echo "<option value=".$Country['id'].">".$Country['name']."</option>";
													}
												}
											?>
										</select>
									</div>
									<?php /*
									<div class="form-group">
										<div class="form-group"  >
											<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;State</label>
											<select class="form-control" name="state" id="state"  onchange="Get_cities(this.value);">
											<?php 
												
													$States_array2 = $ci_object->Igain_model->Get_states($cust_Country_id);
													foreach($States_array2 as $State)
													{
											?>
													<option value="<?php echo $State->id;?>" <?php if($cust_State==$State->id){echo 'selected';}?>><?php echo $State->name;?></option>
												<?php	}  ?></select>
										</div>
									</div> */ ?>
									<input type="hidden" name="state" id="state" value="<?php echo $cust_State ;?>">
								
									<div class="form-group">
										<div class="form-group">
											<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;City</label>
											<select class="form-control" name="city" id="city">
											<?php 
												$City_array2 = $ci_object->Igain_model->Get_cities($cust_State);
													
													foreach($City_array2 as $City1)
													{
														foreach($Outlet_cites as $cites) 
														{ 
															if($cites->City == $City1->id)  
															{	?>	
																<option value="<?php echo $City1->id;?>" <?php if($Customer_other_address->City_id==$City1->id){echo 'selected';}?>><?php echo $City1->name;?></option>
												<?php		} 
														}
													} ?>
												</select>							
										</div>
									</div> 
									<?php /*
									<div class="form-group">
										<label for="pwd"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Zipcode:</label>
										<input type="text" class="form-control" id="Zipcode" name="Zipcode" placeholder="Zip code" maxlength="6" value="<?php if($Customer_other_address->Zipcode != ""){echo  $Customer_other_address->Zipcode;} ?>" required>
									</div> */?>
									<div class="form-group">
										<label for="pwd"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Phone No.</label>
										<input type="text" class="form-control" id="Phone_no" name="Phone_no" placeholder="Phone No." maxlength="10" value="<?php if($Customer_other_address->Phone_no != ""){echo App_string_decrypt($Customer_other_address->Phone_no);} ?>" onkeypress="return isNumber(event)" required>
									</div>		  
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" class="form-control" id="Address_type" name="Address_type" value="2">
							<input type="hidden" name="delivery_type" value="<?php echo $delivery_type; ?>">
							<input type="hidden" name="delivery_outlet" value="<?php echo $delivery_outlet; ?>">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-template-main text-right">Save Address</button>
						</div>
				</form>
			</div>
		  </div>
		</div>
		<!---------------- Other Address Modal ---------------------->
</section>
<?php $this->load->view('header/footer');?>

<script>
document.getElementById("country2").value = <?php echo $cust_Country_id;?>;
document.getElementById("country3").value = <?php echo $cust_Country_id;?>;

Get_states(<?php echo $cust_Country_id;?>);
Get_cities(<?php echo $cust_State;?>)

function delete_address(Address_id) {

	var url = '<?php echo base_url(); ?>index.php/Shopping/delete_address/?Address_id=' + Address_id;
    //alert(url);
    show_loader();
       
    window.location = url;
    return true;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

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
	  //alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo $this->config->item('base_url2')?>index.php/Company/Get_states",
		success: function(data)
		{
			//alert(data.States_data);
			$("#Show_States").html(data.States_data);	
			$("#Show_States_work").html(data.States_data);	
			$("#Show_States_other").html(data.States_data);	
		
		}
	});
}
function Get_cities(State_id)
{
	  //alert(State_id);
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo $this->config->item('base_url2')?>index.php/Company/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			$("#Show_Cities_work").html(data.City_data);	
			$("#Show_Cities_other").html(data.City_data);	
			
		}
	});
}
function IsAlphaNumeric(e) 
{
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >=48 && k <= 57));
}
/************************************************************************/	
</script>

<style>
.list-group-item{
	border:none;
}
.btn{
	    padding: 2px;
		border-radius: 6px;
		text-transform:none;

}
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