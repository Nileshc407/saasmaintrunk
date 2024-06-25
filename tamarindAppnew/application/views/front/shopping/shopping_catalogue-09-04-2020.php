<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title?></title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 	
</head>
<body>
	<?php 
	$session_data = $this->session->userdata('cust_logged_in');
	// $data['Walking_customer'] = $session_data['Walking_customer'];
	// var_dump($session_data['Walking_customer']);
	// var_dump($_SESSION['Walking_customer']);
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
	?> 
	 <?php $this->load->view('front/header/menu'); ?>
	<div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<!----category list---->
		<?php if($Enroll_details->Current_address != "" && $Enroll_details->City != ""  && $Enroll_details->Country != ""  ) { ?>
			<form id="category_items" method="POST" action="<?php echo base_url(); ?>index.php/Shopping/filters" enctype="multipart/form-data">
			
			<div class="container">
				
					
					
						<div class="section-header" style="margin-bottom:10px;">    
							<?php if($session_data['Walking_customer'] == 0) { ?>
									<!--<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php //echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p> -->
							<?php } else { ?>
									
							<?php } ?>	
								<p id="Extra_large_font" style="margin-left: -3%;">Online Order</p>
						</div>
				<hr>
				<?php if($Merchandize_category) { 
						
					?>
					<div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
						 
						  <div class="carousel-inner">	
					<?php
						$increment = 3;
						$p = 1;
							
							$opt = "";
							foreach($Merchandize_category as $key=>$MerchandizeCat)
							{
								//	echo "------".$key;
								if($Category_filter == $MerchandizeCat->Merchandize_category_id)
									{ 
								
										$searchedCategory=$MerchandizeCat->Merchandize_category_name;
										
										$opt .= "<li><a 
									 onclick='show_category_items(".$MerchandizeCat->Merchandize_category_id.");'><button type='button' class='btn activeMe' style='background: #322010;padding:3px 10px;white-space: pre-wrap; height:52px;width:90px;font-size: 10px;'>".$MerchandizeCat->Merchandize_category_name."</button></a></li>";

									 }else{
								
								$opt .= "<li><a 
									 onclick='show_category_items(".$MerchandizeCat->Merchandize_category_id.");'><button type='button' class='btn btn-default' style='background: #322010;padding:3px 10px;white-space: pre-wrap; height:52px;width:90px;font-size: 10px;'>".$MerchandizeCat->Merchandize_category_name."</button></a></li>";
									 }
								if( $key > 0 && $key%$increment == 0)
								{	

									if($p == 1)
									{
										echo '<div class="carousel-item active"><ul class="pagination">';
									}
									else{
										echo '<div class="carousel-item"><ul class="pagination">';
									}
							?>
								

							<?php echo $opt; ?>
								
								</div></ul>
						<?php
									$opt = "";
									$p++;
								}
							
							} 
						?>	
					  							 
						  </div>
						 <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev" style="left:-24px;">
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							<!--<span class="carousel-control-prev-icon" aria-hidden="true" style="margin-right:2px;"></span>-->
							<span><i class="fa fa-angle-left" aria-hidden="true" style="margin-right:4px;color:black" ></i></span>
							<span class="sr-only">Previous</span>

						  </a>
						  <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next" style="right:-24px;">
							<!--<span class="carousel-control-next-icon" aria-hidden="true" ></span>-->
							<span><i class="fa fa-angle-right" aria-hidden="true" style="margin-left:4px;color:black"></i></span>
							<span class="sr-only">Next</span>
						  </a>
					</div>
				<?php 
						}
					?>
				<hr>
			</div>

			
			

			
			<input type="hidden" name="Sort_cat" id="Sort_cat">
			</form>
		<!----category list---->	
	<br>				
	<form name="Search_items" method="POST" action="<?php echo base_url()?>index.php/Shopping/Search_items" enctype="multipart/form-data">

		<div class="container">
			<?php if($searchedCategory !="") { ?> <span id="Medium_font" class="text-left" ><strong><?php echo $searchedCategory; ?></strong></span><?php } ?>
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
							
								/* if($p == 1) {
									
									echo "<br><br><div class='d-inline-flex ml-auto'>";	
								} */	
								?>	
						
						<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">	
					<div class="row m-1">
					  <div class="card border border-dark p-1" style="width:100%; height:auto;">
						<div class="card-body">
						  
							
						  

						  <!--<p class="card-text"><small>Item Description</small></p>-->
						  <?php /***** Hide cahnge Ravi--24-09-2019------ <img class="card-img-top" src="<?php echo $product['Thumbnail_image1']; ?>" alt="Card image" style="width:70px; height:70px;"> <?php */ ?>
							
							<div class="row m-0">
							
							<div class="col-xs-6 justify-content-start" >
							<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>">
							
							<?php
								// echo"<br>---Combo_meal_flag----".$product['Combo_meal_flag'];							
								if($product['Combo_meal_flag'] == 1 ) {
									
									$MerchandizeIteName = explode('+', $product['Merchandize_item_name']);
									$itemName= $MerchandizeIteName[0];
								} else {
									
									$itemName= $product['Merchandize_item_name'];
								}
							?>
								<strong id="Medium_font" style="height: 15px;display: block;"><?php echo substr($itemName, 0, 20).""; ?></strong>
								<?php /* if($product['Combo_meal_flag'] ==1 ) { ?>
									<strong id="Value_font" style="height: 15px;display: block;"><?php //echo substr($product['Merchandise_item_description'], 0, 50)."..."; ?></strong>
								<?php } else { ?> 
								
								<strong id="Small_font" style="height: 15px;display: block;"></strong>
								
								<?php } */ ?>								
							
							</a>
							</div>
							<div id="alert_div_<?php echo $product["Company_merchandise_item_id"];?>" style="float: right;margin: 0 auto;font-size:9px;"></div>&nbsp;&nbsp;
								
								<div class="col-xs-4 justify-content-end">
									<span id="Small_font"><small><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo $Billing_price; ?></small></span>	
								</div>
								&nbsp;&nbsp;
								<div class="col-xs-2 justify-content-end">
									<button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>','<?php echo $product["Merchandize_item_name"]; ?>');"> + Add </button>
								</div>
							</div>
								
							
								
							
						</div>
					  </div>
					</div>
				
				<?php 
						/* if($p == 2){
								echo "</div>";
									$p = 0;
								} */
							
							}
						}
						else
						{ ?>
									
								<div class="col-xs-8 text-left" style="width: 100%;">
									<address style="text-align:center;border:none;">
										<strong id="Medium_font">No Item Found</strong><br>
									</address>	
								</div>
					
						<?php
						}
						?>	
			

		</div>	
		<br>
		
	</form>	
	
	
	<?php } else {  ?>
					<br>
					<div class="pricing-details">
						<div class="row">
							<div class="col-md-12 text-center">
							
								
								<strong id="Large_font">Please update your primary address in profile.</b> <br>
								
							</div>
						</div>
					</div>
					<br>						
					<div class="pricing-details ">
						<div class="row">
							<div class="col-md-12 text-center" >
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_profile();" > Go to Profile</button>
							</div>
							
							
						</div>
					</div>
				
				
				<?php }  ?>
	</div>	

<!-- Modal 
<div id="item_info_modal" class="modal fade" role="dialog" style="overflow:auto;">
	<div class="modal-dialog" style="width: 70%;" id="Show_item_info">
		<div class="modal-content" >
			<div class="modal-header">
				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info"></div>
				</div>
			</div>
	
		</div>
	</div>
</div>
<!-- Modal -->


	<div class="modal fade" id="item_info_modal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" >
				<div class="modal-body" style="padding: 10px 0px;">
				  <div class="table-responsive" id="Show_item_info"></div>
				  
				</div>							
			</div>						  
		</div>
	</div>					  

		
<?php $this->load->view('front/header/footer');?> 

<script>
$('.carousel').carousel({
    interval: false
}); 


	function Go_to_profile()
	{ 

		setTimeout(function() 
		{
			$('#myModal').modal('show');
				window.location.href='<?php echo base_url(); ?>index.php/Cust_home/Edit_profile';		
			
		}, 0);
		setTimeout(function() 
		{
			$('#myModal').modal('hide');
		   
		},5000);
	}

	function show_category_items(Cat_id){
		document.querySelector("#Sort_cat").value = Cat_id;
		//document.forms["category_items"].submit();
		document.getElementById("category_items").submit();
		//alert(Cat_id);
	}
	
	function form_submit()
	{
		setTimeout(function() 
		{
				$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
				$('#myModal').modal('hide'); 
		},2000);

		document.Search_items.submit();
	} 
	
	function Page_refresh()
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// window.location.reload();
	}
	function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Company_merchandize_item_code,Item_image1,Item_name)
	{
		var input = $('#cart_count');
		input.val(parseInt(input.val()) + 1);
		
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
		
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
					var msg1 = 'Item added to Cart Successfuly';
					$('#alert_div_'+Company_merchandise_item_id).show();
					$('#alert_div_'+Company_merchandise_item_id).css("color","green");
					$('#alert_div_'+Company_merchandise_item_id).html(msg1);
					setTimeout(function(){$('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
					// location.reload(true);
					window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
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
	function add_to_wishlist(serial,name,price)
	{
		var input1 = $('#wishlist_count');
		input1.val(parseInt(input1.val()) + 1);
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
		
		$.ajax(
		{
			type: "POST",
			data: { id:serial, name:name, price:price },
			url: "<?php echo base_url()?>index.php/Shopping/add_to_wishlist",
			success: function(data)
			{
				if(data.cart_success_flag == 1)
				{	
					var msg1 = 'Product '+name+' is added to Wishlist';
					$('#alert_div_'+serial).show();
					$('#alert_div_'+serial).css("color","green");
					$('#alert_div_'+serial).html(msg1);
					setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				}
				else
				{
					var msg1 = 'Product '+name+' is added to Wishlist. Please try again!!';
					$('#alert_div_'+serial).show();
					$('#alert_div_'+serial).css("color","red");
					$('#alert_div_'+serial).html(msg1);
					setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				}
			}
		});
	}
</script>
<style>
	ul>li>a{
		/* margin: 30%; 
		text-decoration: underline; */
	}
	address 
	{
		
		padding: 0;
		border-radius: 50px;
		margin: 4% 2%;
		/* color: #ffffff; */
	}
	#txt 
	{
		border: none;
		padding: 1% 0 0 0;
		width: 56%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #ffffff;
		height: 29px;
	}
	.main-xs-6
	{
		width: 50%;
		padding: 10px 10px 0 10px;
	}
	#button5{		
		padding: 0 2%;
		border-radius: 2px;
		margin: 15% 3%;
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
	}
	
	.scrolling-wrapper-flexbox {
			  display: flex;
			  flex-wrap: nowrap;
			  overflow-x: auto;
			  .card {
				flex: 0 0 auto;
			  }
		}
		
	#front_head{
		margin-top:40px !important;
	}
	/* sandeep css */
	#button
	{
		/* color: #ffffff;
		font-family: ;
		font-size: 12px;
		background: #5e4103;
		border-radius: 7px;
		margin: 0px;
		border: none; */
		width: 60px;
	}

	.activeMe {

	  color: black;
	  background-color:white !important;
	  border:1px solid black;
	}
	a:hover {
	  text-decoration: underline;
	}
	
	/* visited link 
	a:visited {
	  color: #a3cbe8;
	}
	*/
</style>
<script>
// Show_next('<?php echo '#'.$i; ?>');


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
</script>

<?php 

$page=$_REQUEST['page'];
// echo"---page----".$page."---<br>";

// die;

?>


		
<script>
var page="<?php echo $_REQUEST['page']; ?>";
// console.log(page);
/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */
var tour = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'hopscotch-title',
      title: 'Click Here For Menu Options',
      // content: 'Click Here For Menu Options',
      placement: 'right',
      arrowOffset:0,	  
	   yOffset: -20
    },    
    {
      target: 'menu-icon',
      placement: 'top',
      title: 'View our menu and place your orders',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-80,
	   yOffset: 20,
	   "onNext": function() {
			
			window.location.href = "<?php echo base_url(); ?>index.php/Shopping";
		
      },
      "multipage": true
    },
	{
      target: 'Mcategory',
      placement: 'bottom',
      title: 'Swipe  here to view Categories',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:80,
	   yOffset:0,
	    "onNext": function() {
			if(page=='front_home'){
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/front_home";
			} else{
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/help";
			}
			
		
      },
      "multipage": true,
	  "onPrev": function() {
		  
        if(page=='front_home'){
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/front_home";
			} else{
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/help";
			}
		
      }
    },    
    {
      target: 'offer-icon',
      placement: 'top',
      title: 'Get updated on our Latest Offers',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-90,
	   yOffset:15
    }
  ],
  showPrevButton: true,
  scrollTopMargin: 100
},

/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},
init = function() {
  var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();
	  
	
		
		if (state && state.indexOf('hello-hopscotch:') === 0) {
			// Already started the tour at some point!
			hopscotch.startTour(tour);
		  } else {
			// Looking at the page for the first(?) time.
			/* setTimeout(function() {
			  mgr.createCallout({
				id: calloutId,
				target: startBtnId,
				placement: 'bottom',
				title: 'Take an tour',
				content: 'Start by clicking an tour to see in action!',
				yOffset: -10,
				arrowOffset: 20,
				width: 240
			  });
			}, 100); */
		  }
	
  addClickListener(document.getElementById(startBtnId), function() {
    if (!hopscotch.isActive) {
      mgr.removeAllCallouts();
      hopscotch.startTour(tour);
    }
  });
};
init();	
</script>


