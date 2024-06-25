<?php 
// $session_data = $this->session->userdata('cust_logged_in');
// $smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('front/header/header');
$this->load->view('front/header/menu');   
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
//$Company_id =32;

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}

$Tier_redemption_ratio = $Tier_details->Tier_redemption_ratio;
?>	
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Application Information</h4>
        </div>
        <div class="modal-body">
          <p>Company work in progress... Will be up soon...Sorry for the inconvenience</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="redBtn w-100 text-center" data-dismiss="modal" onClick="window.location.href='<?php echo base_url()?>index.php/Cust_home/front_home';">OK</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->
<header>
	<div class="container">
		<div class="row">
			<div class="col-12">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>eVoucher Gift Card</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>

<div class="col-md-4 ">	
</div>
<div class="row"></div>
<!-- Main content -->
<section class="content">
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#06d7bc !IMPORTANT;color:#fff;"></div>
		</div>
	</div>
	<div id="content">
			 <!--<div class="row products">-->
			
				<?php
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
					foreach($voucher_result as $key1 => $value)
					{				
						// if(is_array($value)){
						foreach($value as $key2 => $value2)
							
							foreach($value2 as $key3 => $value22){
								
							foreach($value22 as $key1 => $value1) {	
								// echo"--max_price---".$value[0]['max_price']."--<br>";
								
								// echo"--productId--".$value1['productId']."------<br>";
								// die;
								?>
								
								
									
								
							
								
											<div class="cardMain m-4">
												<br>
													<div class="CurrPoints">
														<div class="text-center dark-bg p-2">
															<a href="JavaScript:void(0);">
																<img src="<?php echo $value1['imageUrl']; ?>" alt="">
															</a>
															<br>
															<br>
															<p style="color:#000;"><?php echo $value1['name']; ?></p>
															<p>
															<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_DS_<?php echo $value1['productId'];?>" style="color:#000;">| Description |</a>
															<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_TC_<?php echo $value1['productId'];?>" style="color:#000;"> T & C |</a>
															
															<?php if($value1['redemptionInstructions']) { ?>
															<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_HTU_<?php echo $value1['productId'];?>" style="color:#000;"> How to Use |</a>
															<?php } ?>
															
																<!-- Modal DS -->
																	<div id="myModal_DS_<?php echo $value1['productId'];?>" class="modal fade" role="dialog">
																	  <div class="modal-dialog">

																		<!-- Modal content-->
																		<div class="modal-content">
																		  <div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal">&times;</button>
																			<h4 class="modal-title">Description</h4>
																		  </div>
																		  <div class="modal-body text-left">
																			<p style="color:#000;"><?php echo html_entity_decode($value1['description']); ?></p>
																		  </div>
																		  <div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		  </div>
																		</div>

																	  </div>
																	</div>
																<!-- Modal TC -->	
																<div id="myModal_TC_<?php echo $value1['productId'];?>" class="modal fade" role="dialog">
																		<div class="modal-dialog">

																			<!-- Modal content-->
																			<div class="modal-content">
																			  <div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">Description</h4>
																			  </div>
																			  <div class="modal-body text-left">
																				<p style="color:#000;"><?php echo html_entity_decode($value1['termsAndConditionsInstructions']); ?></p>
																			  </div>
																			  <div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			  </div>
																			</div>
																		</div>
																</div>
																<?php if($value1['redemptionInstructions']) { ?>
																<!-- Modal myModal_HTU_ -->
																<div id="myModal_HTU_<?php echo $value1['productId'];?>" class="modal fade" role="dialog">
																	<div class="modal-dialog">

																		<!-- Modal content-->
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">Description</h4>
																			</div>
																			<div class="modal-body text-left">
																				<p style="color:#000;"><?php echo html_entity_decode($value1['redemptionInstructions']); ?></p>
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
																	// $smallest_price= min($value1['product_denminations']); 
																	$first_price= explode(",",$value1['valueDenominations']); 
																	$smallest_price=$first_price[0];
																	/* echo $Company_Details->Redemptionratio; 
																	echo $Company_Details->Currency_name; */ 
																?>
																<select class="form-control" name="Price_value_<?php echo $value1['productId'];?>" id="Price_value_<?php echo $value1['productId'];?>" required onchange="Change_price(this.value,<?php echo $value1['productId'];?>);">
																	<option value="<?php echo $smallest_price; ?>"><?php echo $value1['countryCode']." ".$smallest_price; ?></option>		
																	<?php 
																	// print_r($value1['product_denminations']);
																	
																	$valueDenominations=explode(",",$value1['valueDenominations']);
																	foreach($valueDenominations as $key_price => $price_value){
																	?>
																	<option value="<?php echo $price_value; ?>"><?php echo $value1['countryCode']." ".$price_value; ?></option>	
																	<?php
																			// echo"---price_value----".$price_value."---<br>";
																	}
																	?>
																														
																</select>
															<br>
															<p class="text-center">

																<!--<div class="qty mt-5">
																	
																	<button type="submit" class="redBtn w-100 text-center" onclick="RemoveQty('<?php echo $value1['productId'];?>');" >
																		<span class="minus bg-dark">-</span>
																	</button>
																	
																		<input type="text" class="count form-control text-center" name="qty_<?php echo $value1['productId'];?>" id="qty_<?php echo $value1['productId'];?>" value="1" readonly style="width:110px;display:inline">
																		
																	<button type="submit" class="redBtn w-100 text-center" onclick="AddQty('<?php echo $value1['productId'];?>');">
																		<span class="plus bg-dark">+</span>
																	</button>
																	
																</div>-->
																
																
																<div class="d-flex mb-4" style="max-width: 300px">
																  <button type="button" class="redBtn text-center px-3 mr-2" style="background-image:none; border-radius: 10px;"
																	 onclick="RemoveQty('<?php echo $value1['productId'];?>');">
																	-
																  </button>

																  <div class="form-outline" style="width: 100%;text-align: center;">
																	<input type='tel' pattern='[0-9]*' name="qty_<?php echo $value1['productId'];?>" id="qty_<?php echo $value1['productId'];?>"  style="text-align: center;" maxlength="2" size="10"    onkeypress='return isNumberKey2(event)' onchange="Update_cart(this.value,'<?php echo $i; ?>','<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>')" class="count form-control text-center"  value="1" style="text-align: center;" />
																	
																	
																	
																	
																	
																	<label class="form-label" for="form1">Quantity</label>
																  </div>

																  <button type="button" class="redBtn text-center px-3 ml-2" style="background-image:none;border-radius: 10px;"
																	onclick="AddQty('<?php echo $value1['productId'];?>');">
																	+
																  </button>
																</div>
																
																
																
																
															</p>
															<?php 
															
															$Billing_price_in_points = $smallest_price * $Company_Details->Redemptionratio;
															
															$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
															?>
															<p class="text-center">
															<?php if($Billing_price_in_points != $Billing_price_in_points_tier)
															{
																$Billing_price_in_points = $Billing_price_in_points_tier;
																
																?>
																<del>Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['productId'];?>"><?php echo ($smallest_price * $Company_Details->Redemptionratio); ?></b></del> 
																<br>
																Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points1_<?php echo $value1['productId'];?>"><?php echo ($Billing_price_in_points_tier); ?></b> 
													<?php   } 
													else
													{ ?>
																Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['productId'];?>"><?php echo ($smallest_price * $Company_Details->Redemptionratio); ?></b>
												<?php 
													}?>	
																<!--<input type="hidden" name="Billing_price_in_points_<?php echo $value1['productId'];?>" id="Billing_price_in_points_<?php echo $value1['productId'];?>" value="<?php echo ($smallest_price * $Company_Details->Redemptionratio); ?>" >-->
																
																<input type="hidden" name="Billing_price_in_points_<?php echo $value1['productId'];?>" id="Billing_price_in_points_<?php echo $value1['productId'];?>" value="<?php echo ($Billing_price_in_points); ?>" >
															</p>
															
															
																
																
														</div>
															
														<div class="text">
															<h5>
																	<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id="> </a> </h5>
																<p class="price"></p>												
																<div class="text">
																	<input type="hidden" name="Company_merchandize_item_code_<?php echo $value1['productId'];?>" value="XOXODAY<?php echo $value1['productId'];?>">
																
																	
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
																	<?php /* ?>
																	<input type="hidden" name="location" id="location" value="<?php echo $Branch_code; ?>">
																	<input type="hidden" name="Item_size"  id="Item_size" value="0">
																	<input type="hidden" name="Item_Weight" id="Item_Weight" value="0">
																	<input type="hidden" name="Weight_unit_id" id="Weight_unit_id" value="0">
																	<?php */ ?>
																	
																	<input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
																	
																	<button type="submit" id="Redeem_done_btn" class="redBtn w-100 text-center" onclick="Redeem_done('<?php echo $value1['imageUrl'];?>','<?php echo $value1['name'];?>','<?php echo $value1['productId'];?>',28,'<?php echo $value1['name'];?>',<?php echo $value1['productId'];?>);get_item_list();" >
																		<i class="fa fa-shopping-cart"></i> <?php echo ('Redeem'); ?>
																	</button>		
																</div>	
														</div>	
													</div>	
												</div>
												
							<?php
								}
						}
					
						}
					}
				
				?>	
			
		</div>				
				
		
</section>
<?php $this->load->view('front/header/footer');?>
<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.js"></script>
<style>
p {
    color: #000 !IMPORTANT;
}
#popup 
{
	display:none;
}
#popup2 
{
	display:none;
}
#loadingDiv{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  background-image:url('<?php echo $this->config->item('base_url2') ?>images/loading.gif');
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */ 
}
ul 
{
  list-style-type: none;
}
.sidebar-menu2>li>a
{
	padding:12px 5px 12px 0px;display:block;
	
	border-left-color: #3c8dbc;
}
sidebar-menu2>li>a:hover
{
	background:#f4f4f5;
}
ol, ul {
    margin-top: 0;
    margin-bottom: 10px;
    margin-left: -21px;
}
</style>

<script type="text/javascript">				
		function AddQty(pId){
			
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Redemptionratio_tier = <?php echo $Tier_redemption_ratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			var newQty= parseInt(current_qty) + parseInt(1);
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			var New_points1 = parseInt(Redemptionratio_tier*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
		
			document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points1;
			// alert(current_qty);
			
		}
		function RemoveQty(pId){
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Redemptionratio_tier = <?php echo $Tier_redemption_ratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			
			var newQty= parseInt(current_qty) - parseInt(1);
			if(newQty < 1){
				newQty=1;
			}			
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			var New_points1 = parseInt(Redemptionratio_tier*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
			
			document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points1;
			
		}
		
		function Change_price(price,pId){
			var csrfName = $('.txt_csrfname').attr('name'); 
			var csrfHash = $('.txt_csrfname').val(); 
			
			/* Set Price_value1 */
				$.ajax({
					
					type: "POST",
					dataType: 'json',
					data: {fghyjkuiolbfgerfddscsdswwesxkoplmswerv:price,[csrfName]:csrfHash},
					url: "<?php echo base_url()?>index.php/Redemption_Catalogue/oxoidpirwesopj",
					success: function(response)
					{
						$('.txt_csrfname').val(response.token);	
					}
				});
			/* Set Price_value1 */
			
		
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Redemptionratio_tier = <?php echo $Tier_redemption_ratio; ?>;
			var current_qty= document.getElementById('qty_'+pId).value;
			var Price_value1=parseInt(price*current_qty);			
			var New_points = parseInt(Redemptionratio*Price_value1);
			var New_points1 = parseInt(Redemptionratio_tier*Price_value1);
			// alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
			document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points1;		
		
		}
		
function Redeem_done(product_image,product_name,Company_merchandize_item_code,Delivery_method,Merchandize_item_name,pId){
	
	var csrfName = $('.txt_csrfname').attr('name');
	var csrfHash = $('.txt_csrfname').val(); 
	
	// var location=document.getElementById("location").value;		
	var location=0;		
	// var Billing_price_in_points=document.getElementById("Billing_price_in_points_"+230).value;	
	var Billing_price_in_points=0;	
	// var Item_size=document.getElementById("Item_size").value;	
	var Item_size=0;	
	// var Item_Weight=document.getElementById("Item_Weight").value;	
	var Item_Weight=0;	
	// var Weight_unit_id=document.getElementById("Weight_unit_id").value;	
	var Weight_unit_id=0;
	var Voucher_price=document.getElementById("Price_value_"+pId).value;	
	var qty=document.getElementById("qty_"+pId).value;	
	var Total_balance = <?php echo $Current_point_balance;?>;
	
	Voucher_price=parseInt(Voucher_price*qty);
	var Voucher_price_new=document.getElementById("Price_value_"+pId).value;
	
	
		/* Set pID Session */
			$.ajax({
				
				type: "POST",
				dataType: 'json',
				data: {ofgkdfndfhryhdbfdglfdgiujsfnmsdfhjdsfbnfd:pId,ofgkdfndfhryhdbfdglfdgiuhrdeshikhgtyzs:Voucher_price,ofgkdfndfhryhdbfdglfdgiujwgfhlkrtiorenmdfhj:qty,ofgkdfndfhryhdbfdglfdgiujwtyhnjkuiuo:Voucher_price_new,[csrfName]:csrfHash},
				url: "<?php echo base_url()?>index.php/Redemption_Catalogue/oxoidpi",
				success: function(response)
				{
					$('.txt_csrfname').val(response.token);
				}
			});
		/* Set pID Session */
	
	
		var csrfName = $('.txt_csrfname').attr('name');
		var csrfHash = $('.txt_csrfname').val(); 
		
		/* BootstrapDialog.confirm("Are you sure to Redeem "+product_name+" eVoucher?", function(result)
		{
			
			if (result == true)
			{ */
					// document.getElementById("loadingDiv").style.display="";	
					if(Billing_price_in_points > Total_balance)
					{
						//alert('Insufficient Current Balance !!!');
						// document.getElementById("loadingDiv").style.display="none";
						ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
						return false;
					}
					else
						{
							
							$('#Redeem_done_btn').css('padding','0px !IMPORTANT;');
							$('#Redeem_done_btn').css('padding','0px');
							
							// $('#popup_info').css('position','fixed');

							// Redeem_done_btn
							  $(':button[type="submit"]').prop('disabled', true);
							  $(':button[type="submit"]').html('Processing Please Wait...');
							// return false;
					
							
						
							$.ajax({
							type: "POST",
							data: {pId:pId,product_image:product_image,product_name:product_name,Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Delivery_method, location:location, Points:Billing_price_in_points,Current_redeem_points:Billing_price_in_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Voucher_price:Voucher_price,qty:qty,[csrfName]:csrfHash},
							url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Redemption_done",
							success: function(data)
							{
								 //alert(data.cart_success_flag);		
								// document.getElementById("loadingDiv").style.display="none";
								if(data.cart_success_flag == 1)
								{
									
									// Redeem_done_btn
									  $(':button[type="submit"]').prop('disabled', false);
									  $(':button[type="submit"]').html('Redeem');
									// return false;
									
									//$('.shoppingCart_total').html('$'+data.cart_total);
									if(parseInt(data.cart_total)>Total_balance)
									{
										ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
										return false;
									}
									else
									{
										
										ShowPopup('<?php echo ('Vouchers Redeemed Successfuly !!!'); ?>');	
										
										setTimeout('location.reload()',
										
										1000);
									}
									
									
								}
								else
								{
									ShowPopup('Error Vouchers Redeeming '+Merchandize_item_name+' to Cart. Please try again..!!');
									
									// Redeem_done_btn
									  $(':button[type="submit"]').prop('disabled', false);
									  $(':button[type="submit"]').html('Redeem');
									// return false;
									
								}
							}
							
						});
						}
			/* }
			else
			{
				return false;
			}
		}); */
	
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


function get_item_list()
{
	var Company_id = '<?php echo $Company_id; ?>';
	
	$.ajax({
		type: "POST",
		data: {Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Redemption_Catalogue/view_cart",
		success: function(data)
		{	
			$('#item_list').html(data);
		}
	}); 
	
}	
function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup_info').css('position','fixed');
	$('#popup_info').css('z-index','1');
	$('#popup_info').css('right','0');
	$('#popup_info').css('top','auto');
	$('#popup_info').css('bottom','50%');
	// $('#popup_info').css('background-color','#31859C !IMPORTANT');
	//$('#popup_info2').html(x);
	//$('#popup_info3').html(x);
	//$('#popup3').show();
	//$('#popup2').show();
	$('#popup').show();
	setTimeout('HidePopup()', 9000);
}
function HidePopup()
{
	$('#popup').hide();
	//$('#popup2').hide();
	//$('#popup3').hide();
}


</script>



<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
		$('#myModal').modal('show');		
	</script>
<?php } ?>
<!------------------------------------------------------------------------------------------------------->