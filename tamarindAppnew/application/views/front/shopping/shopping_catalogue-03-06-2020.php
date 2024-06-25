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
	/*   */
 ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/menu-bg.jpg')" >
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>Menu</h2>
				</div>
			</div>
		</div>
		<div class="custom-body menu-body">
			<div class="nav-head">	<span class="border-top-shap"></span>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<?php 
					$tab=1;
					$cssClass=1;
				
					// var_dump($Merchandize_category);
					foreach ($Merchandize_category as $MerchandizeCat)
					{
						if(($Merchandize_category_id==$MerchandizeCat->Merchandize_category_id) ){
							$activeClass='class="active"';
						} else { 
							$activeClass='';
						}
						
						
						/* 
							#panel-<?php echo $MerchandizeCat->Merchandize_category_id;?>
							 onclick="window.location.href='<?php echo base_url()?>index.php/Shopping?Tabclicked=<?php echo $MerchandizeCat->Merchandize_category_id;?>' "
						*/
						
						
						?>
							<li class="nav-item" role="presentation" style="left: 55px;position: relative;">
								<a  <?php echo $activeClass; ?> id="tab-<?php echo $MerchandizeCat->Merchandize_category_id;?>" data-toggle="tab" href="JavaScript:void(0)" role="tab" aria-controls="panel-<?php echo $MerchandizeCat->Merchandize_category_id;?>" aria-selected="true" onclick="window.location.href='<?php echo base_url()?>index.php/Shopping?Merchandize_category_id=<?php echo $MerchandizeCat->Merchandize_category_id;?>' ">	<span>
									<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0)">
									<path d="M28.8906 15.1121H7.40902C6.14005 15.1121 5.10742 16.1447 5.10742 17.4137V18.948C5.10742 24.4228 8.13172 29.3881 12.9988 31.906C13.3748 32.0994 13.8381 31.9536 14.033 31.5761C14.2264 31.2002 14.0806 30.7368 13.7031 30.5419C9.34848 28.2894 6.6418 23.8474 6.6418 18.948V17.4136C6.6418 16.9901 6.98553 16.6464 7.40902 16.6464H28.8906C29.3141 16.6464 29.6579 16.9901 29.6579 17.4136V18.948C29.6579 23.8473 26.9512 28.2894 22.5951 30.5403C22.2176 30.7352 22.0718 31.1986 22.2651 31.5745C22.4017 31.8384 22.6702 31.9903 22.9479 31.9903C23.0676 31.9903 23.1873 31.9627 23.2993 31.9044C28.1679 29.388 31.1922 24.4242 31.1922 18.9479V17.4135C31.1922 16.1447 30.1595 15.1121 28.8906 15.1121Z" fill="#F8E0A4"/>
									<path d="M35.7389 30.9287C35.6192 30.6418 35.34 30.4546 35.03 30.4546H1.27326C0.963335 30.4546 0.68405 30.6418 0.564367 30.9287C0.444683 31.2156 0.510639 31.5455 0.730082 31.765L2.45017 33.4866C3.46597 34.5008 4.81312 35.0594 6.24781 35.0594H30.0525C31.4872 35.0594 32.8359 34.5009 33.8532 33.4866L35.5733 31.765C35.7927 31.5455 35.8586 31.2156 35.7389 30.9287ZM32.7668 32.4017C32.0426 33.126 31.0775 33.5249 30.0541 33.5249H6.24781C5.22439 33.5249 4.25923 33.126 3.53501 32.4017L3.12382 31.9905H33.178L32.7668 32.4017Z" fill="#F8E0A4"/>
									<path d="M35.8459 18.7349C33.779 17.4061 30.477 18.8485 30.1072 19.0157C29.722 19.1921 29.5502 19.6463 29.7266 20.033C29.9031 20.4197 30.3557 20.59 30.7439 20.4136C31.4835 20.0775 33.8557 19.2812 35.0157 20.0284C35.539 20.3644 35.7952 21.0166 35.7952 22.017C35.7952 25.0888 29.5992 26.9455 27.2071 27.4027L26.6639 27.5101C26.2481 27.5915 25.978 27.9949 26.0594 28.4108C26.1315 28.776 26.4522 29.0292 26.8112 29.0292C26.8603 29.0292 26.9094 29.0246 26.96 29.0138L27.4986 28.908C27.9006 28.8312 37.3295 26.9823 37.3295 22.017C37.3296 20.4734 36.8294 19.3701 35.8459 18.7349Z" fill="#F8E0A4"/>
									<path d="M24.1234 8.68607C25.3709 7.12709 25.3709 4.68589 24.1234 3.12691C23.8579 2.79548 23.3777 2.74025 23.0447 3.00723C22.7133 3.27271 22.6596 3.75446 22.9251 4.08589C23.7153 5.07249 23.7153 6.74043 22.9236 7.73011C21.6746 9.28909 21.6746 11.7303 22.9236 13.2893C23.0755 13.4795 23.2979 13.5778 23.5235 13.5778C23.6907 13.5778 23.861 13.5225 24.0022 13.409C24.3336 13.1435 24.3874 12.6601 24.1219 12.3303C23.3301 11.3436 23.3301 9.67576 24.1234 8.68607Z" fill="#F8E0A4"/>
									<path d="M19.5139 8.68617C20.7628 7.12719 20.7628 4.68599 19.5139 3.12701C19.25 2.79558 18.7666 2.74185 18.4352 3.00733C18.1038 3.2728 18.0501 3.75614 18.3155 4.08599C19.1073 5.07258 19.1073 6.74052 18.314 7.73021C17.0666 9.28919 17.0666 11.7304 18.314 13.2894C18.4659 13.4796 18.6884 13.5779 18.9139 13.5779C19.0812 13.5779 19.25 13.5226 19.3927 13.409C19.7241 13.1436 19.7778 12.6618 19.5124 12.3304C18.7221 11.3437 18.7221 9.67585 19.5139 8.68617Z" fill="#F8E0A4"/>
									<path d="M14.9169 8.68753C16.1643 7.12856 16.1643 4.68735 14.9169 3.12838C14.653 2.79695 14.1711 2.74171 13.8382 3.0087C13.5083 3.27259 13.4546 3.75592 13.7185 4.08584C14.5088 5.07244 14.5088 6.74038 13.717 7.73007C12.468 9.28904 12.468 11.7302 13.717 13.2892C13.8689 13.4795 14.0914 13.5777 14.3169 13.5777C14.4842 13.5777 14.6545 13.5225 14.7957 13.4105C15.1271 13.145 15.1808 12.6617 14.9154 12.3318C14.1236 11.3436 14.1236 9.67722 14.9169 8.68753Z" fill="#F8E0A4"/>
									</g>
									<defs>
									<clipPath id="clip0">
									<rect x="0.505371" y="0.536133" width="36.8247" height="36.8247" fill="white"/>
									</clipPath>
									</defs>
									</svg>
									</span>
									<?php echo $MerchandizeCat->Merchandize_category_name; ?></a>
							</li>
						<?php 
						$tab++;
						$cssClass++;
					} 
					?>
					
				</ul>	<span class="border-bottom-shap"></span>
			</div>
			<div class="tab-content">
				<?php 
					$tab1=1;
					$cssClass1=1;
					foreach ($Merchandize_category as $MerchandizeCat1)
					{
						if($cssClass1==1){
							$activeClass1='show active';
						} else { 
							$activeClass1='';
						}
						?>
						<div class="tab-pane fade <?php echo $activeClass1; ?>" id="panel-<?php echo $MerchandizeCat1->Merchandize_category_id; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $MerchandizeCat1->Merchandize_category_id; ?>">
							<!------25-05-2020 Item Starts--------------->
							<?php	
								$p = 0;
								// var_dump($Redemption_Items);
								if($Redemption_Items != NULL)
								{ 
							
									foreach ($Redemption_Items as $product)
									{
										
										$p++;
										$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];						
										$Count_item_offer = $this->Shopping_model->get_count_item_offers($product["Company_merchandise_item_id"],$product['Company_id']);
										
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
									
										<div class="menu-box">
										
										
											<div class="img">
												<img src="<?php echo $product['Thumbnail_image1']; ?>" alt="" />
											</div>
											<div class="dtc">
												
												<?php 
													if($product['Combo_meal_flag'] == 1 ) {
									
														$MerchandizeIteName = explode('+', $product['Merchandize_item_name']);
														$itemName= $MerchandizeIteName[0];
													} else {
														
														$itemName= $product['Merchandize_item_name'];
													}
												?>
											
												<h2><?php echo substr($itemName, 0, 20).""; ?></h2>
												<a href="#" class="add_extra_btn" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo $Merchandize_item_name; ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>','<?php echo $Merchandize_item_name; ?>');" >+ Add Extras</a>
											</div>
											<div id="alert_div_<?php echo $product["Company_merchandise_item_id"];?>" style="float: right;margin: 0 auto;font-size:9px;"></div>
											<div class="kes_wrap">
												<h3><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo $Billing_price; ?></h3>
												
												<?php								
													$item_name= preg_replace('#[^\w()/.%\-&]#',' ',$product["Merchandize_item_name"]);
													$Merchandize_item_name = garbagereplace($item_name);
													
													/* onclick="plus()"  */
												?>
												
												<div id="input_div" class="prodinput">
													<input class="minus" type="button" value="-" onclick="minus()">
													<input class="productqty" type="text" size="25" value="1" id="count">
													<input class="plus" type="button" value="+"  onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo $Merchandize_item_name; ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>','<?php echo $Merchandize_item_name; ?>');">
												</div>
											</div>
										</div>
									
							<?php  
									} 
								} 
							?>
						</div>
						
						<!------25-05-2020 Item Ends--------------->
						
				<?php 
						$tab1++;
						$cssClass1++;
				} 
				?>
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
			</div>
		</div>
		
		
		
		
		
	<?php $this->load->view('front/header/footer');  ?>
	
	<div class="col-md-6 col-md-offset-3" id="popup">
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
	<script type="text/javascript">
	$('#popup').hide();
	// $('#popup').css('display','none');
		var count = 1;
		var countEl = document.getElementById("count");
		function plus(){
			count++;
			countEl.value = count;
		}
		function minus(){
		  if (count > 1) {
			count--;
			countEl.value = count;
		  }  
		}
		
		var count2 = 1;
		var countE2 = document.getElementById("count2");
		function plus2(){
			count2++;
			countE2.value = count2;
		}
		function minus2(){
		  if (count2 > 1) {
			count2--;
			countE2.value = count2;
		  }  
		}

		var count3 = 1;
		var countE3 = document.getElementById("count3");
		function plus3(){
			count3++;
			countE3.value = count3;
		}
		function minus3(){
		  if (count3 > 1) {
			count3--;
			countE3.value = count3;
		  }  
		}
		
		
		
		/* Add to Cart */
		
			function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Company_merchandize_item_code,Item_image1,Item_name)
			{
				/* var input = $('#cart_count');
				input.val(parseInt(input.val()) + 1);
				
				setTimeout(function() 
				{
					$('#myModal').modal('show');	
				}, 0);
				setTimeout(function() 
				{ 
					$('#myModal').modal('hide');	
				},2000);
				 */
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
							$("#footer_cart").load(location.href + " #footer_cart");
							ShowPopup(Item_name + ' is added to cart successfuly.');

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
		
	</script>
	
	<style>
	.dtc{
		min-width: 100px;
	}
	
	</style>