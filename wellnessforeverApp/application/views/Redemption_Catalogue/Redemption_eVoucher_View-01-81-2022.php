<?php $this->load->view('front/header/header'); 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>eVoucher Gift Card</h1></div>
				<div class="leftRight"><button></button></div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom passChanWrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
					if(@$this->session->flashdata('Redeem_flash'))
					{
					?>
						<div class="alert bg-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('Redeem_flash'); ?></h6>
						</div>
					<?php
					}
				?>
				
				
				
				<?php
				//print_r($Redemption_Items_branches);echo "<br><br>";	

				function string_decrypt($encrypted_string, $key, $iv)
				{
						
								
						// echo "-------encrypted_string----".$encrypted_string."---------------<br>";
						// echo "-------key----".$key."---------------<br>";
						// echo "-------iv----".$iv."---------------<br>"; 

								$version = phpversion();
							// echo "-------version----".$version."---------------<br>";
								$new_version=  substr($version, 0, 1);
							
							// echo "-------new_version----".$new_version."---------------<br>";
								if($new_version >= 7) {
										
													
										$first_key = base64_decode($key);
										$second_key = base64_decode($key);            
										$mix = base64_decode($encrypted_string);

										$method = "aes-256-cbc";    
										$iv_length = openssl_cipher_iv_length($method);

										$iv = substr($mix,0,$iv_length);
										$second_encrypted = substr($mix,$iv_length,64);
										$first_encrypted = substr($mix,$iv_length+64);

										$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);


										// echo "--Output-data--".$data."------<br><br>";

										return $data;
										
								} else {
										
												return mcrypt_decrypt
													(
														MCRYPT_RIJNDAEL_256, 
														$key, 
														base64_decode($encrypted_string), 
														MCRYPT_MODE_CBC, $iv
													);
										
								}
					}


				if($voucher_result != NULL)
				{
					// $i;
					foreach($voucher_result as $key => $value)
					{				
						if(is_array($value)){
							
							foreach($value as $key1 => $value1) {
								
								
								// echo"--max_price---".$value[0]['max_price']."--<br>";
						?>
				
				
								
										<br>
											<div class="product">
												<div class="image">
													<p class="text-center">
														<img src="<?php echo $value1['product_image']; ?>" alt="<?php echo $value1['product_name']; ?>" >
													</p>
													<br>
													<br>
													<p><?php echo $value1['product_name']; ?></p>
													<p>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_DS_<?php echo $value1['product_id'];?>">| Description |</a>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_TC_<?php echo $value1['product_id'];?>"> T & C |</a>
													
													<?php if($value1['product_how_to_use']) { ?>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_HTU_<?php echo $value1['product_id'];?>"> How to Use |</a>
													<?php } ?>
													
														<!-- Modal DS -->
															<div id="myModal_DS_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
															  <div class="modal-dialog">

																<!-- Modal content-->
																<div class="modal-content">
																  <div class="modal-header"  style="background-color:#d0112b;color: #fff;">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Description</h4>
																  </div>
																  <div class="modal-body text-left">
																	<p><?php echo html_entity_decode($value1['product_description']); ?></p>
																  </div>
																  <div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																  </div>
																</div>

															  </div>
															</div>
														<!-- Modal TC -->	
														<div id="myModal_TC_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
																<div class="modal-dialog">

																	<!-- Modal content-->
																	<div class="modal-content">
																	  <div class="modal-header" style="background-color:#d0112b;color: #fff;">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Description</h4>
																	  </div>
																	  <div class="modal-body text-left">
																		<p><?php echo html_entity_decode($value1['product_terms_conditions']); ?></p>
																	  </div>
																	  <div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	  </div>
																	</div>
																</div>
														</div>
														<?php if($value1['product_how_to_use']) { ?>
														<!-- Modal myModal_HTU_ -->
														<div id="myModal_HTU_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
															<div class="modal-dialog">

																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header"  style="background-color:#d0112b;color: #fff;">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Description</h4>
																	</div>
																	<div class="modal-body text-left">
																		<p><?php echo html_entity_decode($value1['product_how_to_use']); ?></p>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																</div>

															</div>
														</div>
														<?php } ?>
													</p>
														
														<?php 
															$smallest_price= min($value1['product_denminations']); 
															
															/* echo $Company_Details->Redemptionratio; 
															echo $Company_Details->Currency_name; */ 
														?>
														<select class="form-control h-100" name="Price_value_<?php echo $value1['product_id'];?>" id="Price_value_<?php echo $value1['product_id'];?>" required onchange="Change_price(this.value,<?php echo $value1['product_id'];?>);" style="height: 50px;">
															<option value="<?php echo $smallest_price; ?>"><?php echo $value1['currency_code']." ".$smallest_price; ?></option>		
															<?php 
															// print_r($value1['product_denminations']);
															foreach($value1['product_denminations'] as $key_price => $price_value){
															?>
															<option value="<?php echo $price_value; ?>"><?php echo $value1['currency_code']." ".$price_value; ?></option>	
															<?php
																	// echo"---price_value----".$price_value."---<br>";
															}
															?>
																												
														</select>
													<br>
													<p class="text-center">

														<div class="row">
															<div class="col-4">
																<button type="submit" class="text-center" onclick="RemoveQty(<?php echo $value1['product_id'];?>);" style="background-image:none;line-height: 0px;padding:0px;width: 100%;height: 40px;background-color: #d0112b;color:#fff;border: none;">
																<!--<span class="minus bg-dark">-</span>-->
																<i class="fa fa-minus"  aria-hidden="true" style="font-size: 17px;" ></i>
															</button>
															</div>
															<div class="col-4">
															<input type="text" class="form-control" name="qty_<?php echo $value1['product_id'];?>" id="qty_<?php echo $value1['product_id'];?>" value="1" readonly style="width:100%;display:inline;font-size: 30px;height: 40px;text-align: center;border: none;background-color: #fff;">
															</div>
															<div class="col-4">
															<button type="submit"  class="text-center" onclick="AddQty(<?php echo $value1['product_id'];?>);" style="background-image:none;line-height: 0px;padding:0px;width: 100%;height: 40px;background-color: #d0112b;color:#fff;border: none;">
																<!--<span class="plus bg-dark">+</span>-->
																<i class="fa fa-plus"  aria-hidden="true" style="font-size: 17px;" ></i>
															</button>
															</div>
														</div>
														
															<?php /* ?>
															<button type="submit" class="text-center" onclick="RemoveQty(<?php echo $value1['product_id'];?>);" style="background-image:none;line-height: 0px;padding:0px;width: 25%;height: 40px;background-color: #d0112b;">
																<!--<span class="minus bg-dark">-</span>-->
																<i class="fa fa-minus"  aria-hidden="true" style="font-size: 17px;" ></i>
															</button>
															
																<input type="text" class="form-control" name="qty_<?php echo $value1['product_id'];?>" id="qty_<?php echo $value1['product_id'];?>" value="1" readonly style="width:34%;display:inline;font-size: 30px;height: 40px;text-align: center;">
																
															<button type="submit"  class="text-center" onclick="AddQty(<?php echo $value1['product_id'];?>);" style="background-image:none;line-height: 0px;padding:0px;width: 25%;height: 40px;background-color: #d0112b;">
																<!--<span class="plus bg-dark">+</span>-->
																<i class="fa fa-plus"  aria-hidden="true" style="font-size: 17px;" ></i>
															</button>
															<?php */ ?>
															
														
													</p>
													<p class="text-center">
														Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['product_id'];?>"><?php echo ($smallest_price * $Company_Details->Redemptionratio); ?></b> 
														<input type="hidden" name="Billing_price_in_points_<?php echo $value1['product_id'];?>" id="Billing_price_in_points_<?php echo $value1['product_id'];?>" value="<?php echo ($smallest_price * $Company_Details->Redemptionratio); ?>" >
													</p>
													
													
														
														
												</div>
													
												<div class="text">
																								
														<div class="text">
															<input type="hidden" name="Company_merchandize_item_code_<?php echo $value1['product_id'];?>" value="XOXODAY<?php echo $value1['product_id'];?>">
														
															
															<input type="hidden" name="Delivery_method" value="28">
															
															<?php 
															
															foreach ($Redemption_Items as $product)
															{
																
																$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];															
															
																	foreach ($Branches as $Branches3){
																		
																	$Branch_code=$Branches3['Branch_code'];
																	$Branch_name= $Branches3['Branch_name']; 
																 }
															}
															?>
															<input type="hidden" name="location" id="location" value="<?php echo $Branch_code; ?>">
															<input type="hidden" name="Item_size"  id="Item_size" value="0">
															<input type="hidden" name="Item_Weight" id="Item_Weight" value="0">
															<input type="hidden" name="Weight_unit_id" id="Weight_unit_id" value="0">
															
															<button type="submit" class="redBtn w-100 text-center mt-3" onclick="Redeem_done('<?php echo $value1['product_image'];?>','<?php echo $value1['product_name'];?>','XOXODAY<?php echo $value1['product_id'];?>',28,'<?php echo $product['Merchandize_item_name']; ?>',<?php echo $value1['product_id'];?>);" style="margin-left: -6px;">
																<i class="fa fa-shopping-cart"></i> Redeem
															</button>		
														</div>	
												</div>	
												<br>
												<br>
											</div>	
								
								<br>
					

						
				
				   <?php
							}
						
							}
						}
					}
					?>
			  <?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>


<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model" style="background-color: transparent;border:none;box-shadow: none;">
				   <div class="modal-body" style="padding: 10px 0px;">
					 <img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
<!-- Loader -->
<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal1" role="dialog" align="center">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model" style="background-color:#d0112b;color:#fff;padding:5px;">
				   <div class="modal-body" style="padding: 10px 0px;">
					 <div id="msg" style="background-color:#d0112b;color:#fff;padding:5px;"> </div>
					 
					 
					 
					 
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
<!-- Loader -->

<div class="col-md-6 col-md-offset-3" id="popup" style="width: 35%;font-size: 13px; margin-left: 30%;height:10%;display:none;">
	<div class="alert alert-success text-center" role="alert" id="popup_info">Cart Updated Successfully !!!</div>
</div>
<div id="loadingDiv" style="display:none;">
	<div>
		<h6>Please wait...</h6>
	</div>
</div>

<?php $this->load->view('front/header/footer');  ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">



<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>

<!--Click to Show/Hide Input Password JS-->
	<script type="text/javascript">
	
		function AddQty(pId){
			
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			var newQty= parseInt(current_qty) + parseInt(1);
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
		
		
			// alert(current_qty);
			
		}
		function RemoveQty(pId){
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			
			var newQty= parseInt(current_qty) - parseInt(1);
			if(newQty < 1){
				newQty=1;
			}			
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
			
		}
		
		function Change_price(price,pId){
		
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var current_qty= document.getElementById('qty_'+pId).value;
			var Price_value1=parseInt(price*current_qty);			
			var New_points = parseInt(Redemptionratio*Price_value1);
			// alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;		
		
		}
		
		
		
function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	$('#error_display').show();
	setTimeout('HidePopup()', 6000);
}

function HidePopup()
{
	$('#popup').hide();
	//$('#popup2').hide();
	//$('#popup3').hide();
}
	
function Redeem_done(product_image,product_name,Company_merchandize_item_code,Delivery_method,Merchandize_item_name,pId){
	
	var location=document.getElementById("location").value;		
	var Billing_price_in_points=document.getElementById("Billing_price_in_points_"+pId).value;	
	var Item_size=document.getElementById("Item_size").value;	
	var Item_Weight=document.getElementById("Item_Weight").value;	
	var Weight_unit_id=document.getElementById("Weight_unit_id").value;	
	var Voucher_price=document.getElementById("Price_value_"+pId).value;	
	var qty=document.getElementById("qty_"+pId).value;	
	var Total_balance = <?php echo $Current_point_balance;?>;
	
	Voucher_price=parseInt(Voucher_price*qty);
	
	
	/* alert(Company_merchandize_item_code);
	alert(Delivery_method);
	// alert(branch);
	alert(Merchandize_item_name);
	alert(Billing_price_in_points);	
	alert(Item_size);
	alert(Item_Weight);
	alert(Weight_unit_id);
	alert(Voucher_price);
	alert(Total_balance); */
	// alert("--qty---"+qty);
	// alert("--Voucher_price---"+Voucher_price);
	
	// style
		
		BootstrapDialog.confirm("Are you sure to Redeem "+product_name+" eVoucher?", function(result)
		{
			
			
			
			
			setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},3000);
			
			
			
			if (result == true)
			{
				
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide'); 
				},1000);
				
				$('#myModal').modal('hide'); 
				$('#myModal').hide();
				
					document.getElementById("loadingDiv").style.display="";	
					if(Billing_price_in_points > Total_balance)
					{
						//alert('Insufficient Current Balance !!!');
						// document.getElementById("loadingDiv").style.display="none";
						// ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
						// alert('<?php echo ('Insufficient Current Balance !!!'); ?>');
						
						$('#myModal').modal('hide'); 
						$('#myModal').hide(); 
						setTimeout(function() 
						{
							
							
							$('#msg').html('Insufficient Current Balance !!!');
							$('#myModal1').modal('show'); 
							
						}, 1000);
						setTimeout(function() 
						{ 
							$('#myModal1').modal('hide'); 
							
						},3000);
						
						
						return false;
					}
					else
						{	
					
							
						
							$.ajax({
							type: "POST",
							data: {pId:pId,product_image:product_image,product_name:product_name,Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Delivery_method, location:location, Points:Billing_price_in_points,Current_redeem_points:Billing_price_in_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Voucher_price:Voucher_price,qty:qty },
							url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Redemption_done",
							success: function(data)
							{
								 //alert(data.cart_success_flag);		
								document.getElementById("loadingDiv").style.display="none";
								if(data.cart_success_flag == 1)
								{
										
									//$('.shoppingCart_total').html('$'+data.cart_total);
									if(parseInt(data.cart_total)>Total_balance)
									{
										// ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
										// alert('<?php echo ('Insufficient Current Balance !!!'); ?>');
										$('#myModal').modal('hide'); 
										$('#myModal').hide(); 
										setTimeout(function() 
										{
											$('#msg').html('Insufficient Current Balance !!!');
											$('#myModal1').modal('show');
										}, 1000);
										setTimeout(function() 
										{ 
											$('#myModal1').modal('hide'); 
										},3000);
										
										
										return false;
									}
									else
									{
										$('#myModal').modal('hide'); 
										$('#myModal').hide(); 
										// ShowPopup('<?php echo ('Vouchers Redeemed Successfuly !!!'); ?>');	
										// alert('<?php echo ('Vouchers Redeemed Successfuly !!!'); ?>');	
										
										setTimeout(function() 
										{
											$('#msg').html('Vouchers Redeemed Successfuly !!!');
											$('#myModal1').modal('show'); 
										}, 1000);
										setTimeout(function() 
										{ 
											// $('#myModal1').modal('hide'); 
										},3000);
										
										
										
										// setTimeout('location.reload()',2000);
									}
									
									
								}
								else
								{
									// ShowPopup('Error Vouchers Redeeming '+Merchandize_item_name+' to Cart. Please try again..!!');
									// alert('Error Vouchers Redeeming '+Merchandize_item_name+' to Cart. Please try again..!!');
									
									$('#myModal').modal('hide'); 
									$('#myModal').hide(); 
										setTimeout(function() 
										{
											$('#msg').html('Error Vouchers Redeeming '+Merchandize_item_name+' to Cart. Please try again..!!');
											$('#myModal1').modal('show'); 
										}, 1000);
										setTimeout(function() 
										{ 
											$('#myModal1').modal('hide'); 
										},3000);
									
									
								}
							}
							
						});
						}
			}
			else
			{
				return false;
			}
		});
	
	// return false;
	/* alert(Company_merchandize_item_code);
	alert(Delivery_method);
	alert(branch);
	alert(Merchandize_item_name);
	alert(Billing_price_in_points);	
	alert(Item_size);
	alert(Item_Weight);
	alert(Weight_unit_id);
	alert(Voucher_price);
	alert(Total_balance); */	

// alert(Voucher_price);

	
	
}

	
</script>
<style>


.lds-ring {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #fff;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}



	.modal-header, .btn-primary{
		background-color: #d0112b !IMPORTANT;
		border-color: #d0112b !IMPORTANT;
	}
</style>