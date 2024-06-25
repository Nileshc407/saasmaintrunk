<?php $this->load->view('front/header/header');
	$session_data = $this->session->userdata('cust_logged_in');
	$data['Walking_customer'] = $session_data['Walking_customer'];
	$ci_object = &get_instance(); 
	$ci_object->load->model('Igain_model');
	$ci_object->load->model('shopping/Shopping_model');
	$ci_object->load->helper(array('encryption_val'));
	
	if($Ecommerce_flag==1) {						
		$cart_check = $this->cart->contents();
		if(!empty($cart_check)) {
			$cart = $this->cart->contents(); 
			$grand_total = 0; 
			$item_count = COUNT($cart);  
		}
	}
	if($item_count <= 0 ) {
		$item_count=0;
	}
	else {
		$item_count = $item_count;
	}		
	if($Ecommerce_flag==1)
	{
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {				
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		} 
	}
	if($item_count2 <= 0 ) {
		$item_count2=0;
	}
	else {
		
		$item_count2 = $item_count2;
	}
	/*    */
 ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/menu-smoothies.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Shopping/delivery_type_shopping"></a>
					</div>
					<h2>Menu</h2>
				</div>
			</div>
		</div>
		<div class="custom-body menu-smoothies-body">
			<div class="accordion" id="accordion">
				<!-- Accordion item 1 -->
				
				
					<?php 
					$tab1=1;
					$cssClass1=1;
					if($Merchandize_category != null){
						foreach ($Merchandize_category as $MerchandizeCat1)
						{
							if($cssClass1==1){
								$activeClass1='show';
							} else { 
								$activeClass1='';
							}
							?>
							
							
								<div class="item">
									<div class="accordion-header">
										<button class="btn" data-toggle="collapse" data-target="#collapse<?php echo $MerchandizeCat1->Merchandize_category_id; ?>" aria-expanded="false">
											<span class="border-shap-top"></span>
											<?php echo $MerchandizeCat1->Merchandize_category_name; ?>
											<span class="border-shap-bottom"></span>
										</button>
									</div>
									<div id="collapse<?php echo $MerchandizeCat1->Merchandize_category_id; ?>" class="collapse <?php echo $activeClass1; ?>" data-parent="#accordion">
										<div class="card-body">
										<?php	
											$p = 0;
											// var_dump($Redemption_Items);
											if($Redemption_Items != NULL)
											{ 
										
												foreach ($Redemption_Items as $product)
												{
													
													// echo "<br>----Merchandize_cat_id------".$MerchandizeCat1->Merchandize_category_id."---product----".$product['Merchandize_category_id']."--<br>";
													if($MerchandizeCat1->Merchandize_category_id == $product['Merchandize_category_id'])
													{
														$p++;
														$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];						
														$Count_item_offer = $this->Shopping_model->get_count_item_offers($product["Company_merchandise_item_id"],$product['Company_id']);
														
											//***allergies *********			
														$item_allergies = $this->Shopping_model->Get_Selected_item_allergy_details($product['Company_merchandize_item_code'],$product['Company_id'],18);
												//		var_dump($item_allergies);
											//************			
														$Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($product["Partner_id"]);
														$Partner_state=$Get_Partner_details->State;
														$Partner_Country=$Get_Partner_details->Country_id;
														if($product['Size_flag'] == 1) 
														{ 
															$Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
															$Billing_price = $Get_item_price->Billing_price;
															$Item_size=$Get_item_price->Item_size;
														} 
														else 
														{
															$Item_size="0";
															$Billing_price = $product['Billing_price'];	
														}
														foreach ($Branches as $Branches2)
														{
															$DBranch_code=$Branches2['Branch_code'];
															$DBranch_id=$Branches2['Branch_id'];
														}
											
														?>
												
															<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">	
													
															<?php 
																
																if($product['Combo_meal_flag'] == 1 ) {
												
																	$MerchandizeIteName = explode('+', $product['Merchandize_item_name']);
																	$itemName= $MerchandizeIteName[0];
																	
																} else {
																	
																	$itemName= $product['Merchandize_item_name'];
																}
															?>
															<?php								
																$item_name= preg_replace('#[^\w()/.%\-&]#',' ',$product["Merchandize_item_name"]);
																$Merchandize_item_name = garbagereplace($item_name);
																
																/* onclick="plus()" 
																
																	echo substr($itemName, 0, 15).""; 
																	echo substr($product["Merchandise_item_description"], 0, 20).""; 
																*/
															?>
															
															<div class="card-body">
																<div class="smoothies-item" style="padding-right:40px !IMPORTANT;">
																	<h4><?php echo $itemName; ?></h4>
																	
																	<p><?php echo $product["Merchandise_item_description"]; ?></p>
																	<p>
																	<?php
																	
																	if($item_allergies != null)
																	{
																		foreach($item_allergies as $alg)
																		{
																			$AllergyName = preg_replace('/\s+/', '_', $alg->Code_decode);
																	?>
																		<img src="<?php echo base_url(); ?>images/<?php echo $AllergyName; ?>.png" style="width:30px; height:30px;">
																	<?php
																		 }
																	} 
																	?>
																	</p>
																	
																	
																	<a href="#" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo $Merchandize_item_name; ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>','<?php echo $Merchandize_item_name; ?>');" class="smoothies-plus">
																	<br>
																		<p style="margin-left: -14px;color: #fff;"> <?php echo number_format($Billing_price, 2); ?></p>
																	</a>
																	
																	
																	
																	
																	
																	
																	<div id="alert_div_<?php echo $product["Company_merchandise_item_id"];?>" style="float: right;margin: 0 auto;font-size:9px;"></div>
																
																</div>
																
																
																
															</div>
															
															
															
													<?php  
													}													
												} 
											} 
										?>
										</div>
									</div>
								</div>
							<?php 
							$tab1++;
							$cssClass1++;
						} 
					}
					?>
				
			</div>
		</div>
		<?php 
			function garbagereplace($string) {

				$garbagearray = array('@','#','$','%','^','&','*','(',')');
				$garbagecount = count($garbagearray);
				for ($i=0; $i<$garbagecount; $i++) {
					$string = str_replace($garbagearray[$i], ' ', $string);
				}

				return $string;
			}  
		?>
	<?php $this->load->view('front/header/footer');  ?>
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#ffffff; color:#322010; border-color:#322010; width:100% !IMPORTANT;"></div>
		</div>

		<div class="modal fade" id="item_info_modal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" >
					<div class="modal-body" style="padding: 10px 0px;">
					  <div class="table-responsive" id="Show_item_info"></div>
					  
					</div>							
				</div>						  
			</div>
		</div>
	<script>
		/* Add to Cart */
		
			function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Company_merchandize_item_code,Item_image1,Item_name)
			{
				/* var input = $('#cart_count');
				input.val(parseInt(input.val()) + 1); */
				
				
				
				
				/* setTimeout(function() 
				{
					$('#myModal').modal('show');	
				}, 0);
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide');	
				},2000); */
				 
				Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
				$.ajax(
				{
					type: "POST",
					data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Company_merchandize_item_code:Company_merchandize_item_code,Item_image1:Item_image1,Item_name:Item_name},
					url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
					success: function(data)
					{		
						// console.log(data.cart_success_flag);
						if(data.cart_success_flag == 1)
						{
							// $("#footer_cart").load(location.href + " #footer_cart");
							ShowPopup(Item_name + ' is added to cart successfuly.');
							
							
							/* var inputCart = $('#cart_count').html();
							/* // alert(inputCart);
							if(inputCart==""){
								inputCart=0;
							} 						
							$('#cart_count').html((parseInt(inputCart) + 1)); */
							
							
							var input = $('#cart_count').html();
							$('#cart_count').html((parseInt(input) + 1)); 

						}
						else
						{
							/* var msg1 = 'Error adding item to Cart. Please try again';
							$('#alert_div_'+Company_merchandise_item_id).show();
							$('#alert_div_'+Company_merchandise_item_id).css("color","red");
							$('#alert_div_'+Company_merchandise_item_id).html(msg1);
							setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000); */
							
							$('#item_info_modal').modal('show');	
							$("#Show_item_info").html(data.transactionReceiptHtml);
							
						}
					}
				});
			}
		
		/* Add to Cart */
		
		
		/* Show Next */
		
			function Show_next(flag)
				{
					// console.log(flag);	
					// $("[style]").removeAttr("style");
					$(flag).css("display",""); 
					// $('#row_'+flag).removeAttr('style'); 
				}

				 var radio_count = 0;
				function Show_next_required(flag)
				{
					$(flag).css("display","");
					//$("#Click_ok").css("display","none");
					
					var Condiments_compulsary = '<?php echo $Condiments_compulsary; ?>';

					if ($("input[name^='Required_Condiments']:checked").val())
					{
						radio_count = radio_count+1;
					}
					if ($("input[name='Main_Required_Que_set']:checked").val())
					{
						radio_count = radio_count+1;
					}
					if ($("input[name='Main_Required_Condiments_set']:checked").val())
					{
						radio_count = radio_count+1;
					}
					//alert(Condiments_compulsary+"---"+radio_count);
					if(radio_count == Condiments_compulsary)
					{
						$("#Click_ok").css("display","");
					} 
					else
					{
						return false;	
					}
				}
		/* Show Next */
		
		function ShowPopup(x)
		{
			$('#popup_info').html(x);
			$('#popup_info').css('display','block');
			$('#popup_info').css('position','fixed');
			$('#popup_info').css('z-index','1');
			$('#popup_info').css('right','0');
			$('#popup_info').css('top','auto');
			$('#popup_info').css('bottom','4%');
			$('#popup').show();
			setTimeout('HidePopup()', 5000);
		}

	function HidePopup()
	{
	  $('#popup').hide();
	}
	
	
	/* BAR MESSAGE */
	
	function Add_message(message,ques){
		// alert(message+'---ques------'+ques);
		// alert(message);
		if(message == 'CHEF MESSAGE' || message == 'BAR MESSAGE' || message == 'OPEN MESSAGE')
		{
			$('#message_'+ques).css('display','block');
		}
	}
		
	/* BAR MESSAGE */
		
	</script>