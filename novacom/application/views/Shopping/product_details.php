<?php
$this->load->view('header/header');

$Sharing_Content = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $Product_details->Merchandise_item_description);
$Sharing_Content = str_replace("&nbsp;", "", $Sharing_Content);
$Sharing_Content = trim($Sharing_Content);			
$Sharing_Title = urlencode($Product_details->Merchandize_item_name);
$Sharing_Content = urlencode($Sharing_Content);
$Image_path = urlencode($Product_details->Item_image1);
$Share_redirection_link = base_url();
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$ci_object->load->model('Igain_model');
?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		
<section class="content-header">
	<h1 class="text-center"></h1>
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color: #422d02 !important;"></div>
		</div>
	</div>
</section>		
	<?php 
	  // print_r($Product_details);
			foreach($Product_details as $Item_details){
				$Branches = $Redemption_Items_branches[$Item_details->Company_merchandize_item_code];
				print_r($Branches);
			} 
			// echo 'Company_merchandize_item_code---'.$Item_details->Company_merchandize_item_code;?>
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">	
			<div class="col-md-12">
				<div class="row" id="productMain">
					<div class="col-sm-6">
						<?php 
							$ci_object = &get_instance();
							$ci_object->load->model('shopping/Shopping_model');
							$Count_item_offer = $ci_object->Shopping_model->get_count_item_offers($Product_details->Company_merchandise_item_id,$Product_details->Company_id);
														
							if($Count_item_offer >= 1 )
							{
							?>
							<div class="row" id="thumbs">
								<div class="col-xs-3">
									<img src="<?php echo $this->config->item('base_url2')?>images/special-offers1.png" style="height:70px;">
								</div>	
								<div style="float: right;width: 67%;color:#02a6dc;">						
								<?php
									if($Product_details->Offer_flag==1)
									{
										foreach($Product_offers as $offers)
										{
											$ci_object = &get_instance();
											$ci_object->load->model('shopping/Shopping_model');
											$Offer_item_details= $ci_object->Shopping_model->Get_Merchandize_Item_details($offers["Free_item_id"]);?>
											
												<div><i class="fa fa-gift" aria-hidden="true"></i></div>  
												<div style="margin-left:19px;margin-top:-18px;">Buy <?php echo $offers['Buy_item'];?> Get <?php echo $offers['Free_item'] ?>  <?php echo $Offer_item_details->Merchandize_item_name; ?> free
												</div>
											<?php 								
										}
									}
								?>
								</div>
							</div>
						<?php } ?>
						<br>
						<div id="mainImage">
							<img src="<?php echo $Product_details->Item_image1; ?>" alt="" class="img-responsive" style="margin: 0px auto;max-width:60%;">
						</div>
						
						<br>
						<div class="row" id="thumbs">
							<div class="col-xs-3">
								<a href="<?php echo $Product_details->Item_image1; ?>" class="thumb">
									<img src="<?php echo $Product_details->Item_image1; ?>" alt="" class="img-responsive" style="margin: 0px auto;">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="<?php echo $Product_details->Item_image2; ?>" class="thumb">
									<img src="<?php echo $Product_details->Item_image2; ?>" alt="" class="img-responsive" style="margin: 0px auto;">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="<?php echo $Product_details->Item_image3; ?>" class="thumb">
									<img src="<?php echo $Product_details->Item_image3; ?>" alt="" class="img-responsive" style="margin: 0px auto;">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="<?php echo $Product_details->Item_image4; ?>" class="thumb">
									<img src="<?php echo $Product_details->Item_image4; ?>" alt="" class="img-responsive" style="margin: 0px auto;">
								</a>
							</div>
						</div>
						<br>
						<!-------------Item_details-------Product Details----------------->
					<?php 
					// echo"----Colour_flag----->".$Product_details->Colour_flag ."<br>";
					/*if($Product_details->Brand_flag ==1 || $Product_details->Colour_flag ==1 || $Product_details->Weight_flag ==1 || $Product_details->Dimension_flag ==1 || $Product_details->Manufacturer_flag ==1) 
					{ 
					?>
						<div class="box" id="Specifications">
							<label for="exampleInputEmail1"><h4> <b>Product Specifications</b></h4></label>
							<table class="table table-bordered table-hover">	
							<tbody>
								<?php if($Product_details->Brand_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5><b>Brand </b></h5></label>
									</td>
									<td>
									<p style="font-size: 14px; margin-top: 8px;"> <?php echo $Product_details->Item_Brand; ?> </p>
									</td>
								</tr>
								<?php } ?>
								
								<?php if($Product_details->Colour_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5><b>Colour</b></h5></label>
									</td>
									<td>
									
										<div class="square" style="margin-top: 8px;">
											<img/>
										</div>
									</td>
								</tr>
								<?php } ?>
								<?php if($Product_details->Weight_flag == 1) {
									$Get_Code_decode = $ci_object->Igain_model->Get_codedecode_row($Product_details->Weight_unit_id);
								?>
								<tr>
									<td>
											<label for="exampleInputEmail1"><h5><b>Weight</b></h5></label>
									</td>
									<td>
										<p id="Weight" style="font-size: 14px; margin-top: 8px;"> <?php echo $Product_details->Item_Weight; ?> </p>
										&nbsp;<div style="font-size: 14px; margin-top: -55px;margin-left:40px;"><?php echo $Get_Code_decode->Code_decode; ?> </div>
									</td>
								</tr>
									<?php } ?>
									
									<?php if($Product_details->Manufacturer_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5 ><b>Manufacturer By</b></h5></label>
									</td>
									<td>
										<p style="font-size: 14px; margin-top: 8px;">	<?php echo $Product_details->Item_Manufacturer; ?> <p>	
									</td>
								</tr>
									<?php } 
									?>
									
									<?php if($Product_details->Dimension_flag ==1) { ?>
								<tr>
									<td>
											<label for="exampleInputEmail1"><h5><b>Dimension</b></h5></label> 
									</td>
									<td> 
										<p id="Dimension" style="font-size:14px; margin-top: 8px;">	<?php echo $Product_details->Item_Dimension."<p style='margin: -10px 0px 0px 0px; color:red; font-size:10px;'>(Lenght X Width X Height)</p>"; ?>	
										</p>	
									</td>
								</tr>
									<?php } ?>	
							</tbody>
						</table>
						</div>
					<?php
					} */
					?>
					<!--------------------Product Details----------------->	
					</div>
										
					<div class="col-sm-6">
						<?php
							$Small=0;
							$Medium=0;
							$Large=0;
							$ExtraLarge=0;
							$Get_Partner_details = $ci_object->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
							$Partner_state=$Get_Partner_details->State;
							$Partner_Country=$Get_Partner_details->Country_id;
							
							$Branch_code = $ci_object->Igain_model->get_partner_branch($Company_id,$Product_details->Company_merchandize_item_code);	
							$DBranch_code=$Branch_code->Branch_code;
						?>
							<?php if($Product_details->Size_flag == 1) 
							{ ?>
								<br>
								<label for="exampleInputEmail1"><h5 style="margin:-20px 0 0 0px;"><b>Select Size : </b></h5></label><?php if($Product_details->Size_chart == 1) { ?><a style="margin:-1px 0px 0px 250px;" href="#" data-toggle="modal" data-target="#Size_chart">Size Chart </a> <?php } ?> <br>
								<?php						 
								$Get_item_price1 = $ci_object->Redemption_Model->Get_item_details1($Company_id,$Product_details->Company_merchandize_item_code);
								
								foreach($Get_item_price1 as $Item_pricesz)
								{
									// echo $Item_pricesz->Billing_price;	
									if($Item_pricesz->Item_size == 1)
									{
										$Size = "S";
										$Small=1;
									}
									elseif($Item_pricesz->Item_size == 2)
									{
										$Size = "M";
										$Medium=2;
									}
									elseif($Item_pricesz->Item_size == 3)
									{
										$Size="L";
										$Large=3;
									}
									elseif($Item_pricesz->Item_size == 4)
									{
										$Size="XL";
										$ExtraLarge=4;
									}
									?>
									<a href="javascript:Change_points_by_size('<?php echo $Item_pricesz->Billing_price;?>','<?php echo $Item_pricesz->Item_size; ?>','<?php echo $Item_pricesz->Item_weight; ?>','<?php echo $Item_pricesz->Item_Dimension; ?>');"><div id="<?php echo $Item_pricesz->Item_size; ?>" class="circle"> <h5 id="SizeText" style="text-align:center; margin:inherit; margin-top:7px; color:white;"> <?php echo $Size; ?> </h5></div></a>
							<?php	}	
							} 
							if($Product_details->Size_flag == 1) 
							{ ?>
								<br> <br>
					<?php   } ?> <?php /*
							<?php if($Product_details->Merchant_flag ==1) 
							{
								$get_enrollment = $ci_object->Igain_model->get_enrollment_details($Product_details->Seller_id);	
								$Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;	
								// echo $get_enrollment->First_name.' '.$get_enrollment->Last_name;?>					
							<h5 style="margin-top:11px;"><b> Outlet Name : </b> <?php
								?>
								<h4 class="box"><?php echo $Merchent_name; ?></h4>
							<?php } ?> </h5> */ ?>
							
						
						<div class="box">
							<form>
								<div class="sizes">
									<?php $M_item_name = (explode("+",$Product_details->Merchandize_item_name)); 
									
									if($Product_details->Combo_meal_flag == 1)
									{
										$M_item_name = $M_item_name['0'];
									}
									else
									{
										$M_item_name = $Product_details->Merchandize_item_name;
									}  
								?>
									<h3><?php echo $M_item_name;  ?></h3>
								</div>

								<p class="price" ><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<b id="size_points" ><?php echo $Product_details->Billing_price; ?></b></p>
								
								<input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">	
								
								<p class="text-center">
									<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>',29,29,<?php echo $Product_details->Company_merchandise_item_id; ?>,'<?php echo $Item_pricesz->Item_size; ?>',<?php echo $Product_details->Item_Weight; ?>,<?php echo $Product_details->Weight_unit_id; ?>,<?php echo $Product_details->Partner_id; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $Product_details->Seller_id; ?>,<?php echo $Product_details->Merchant_flag; ?>,'<?php echo $Product_details->Cost_price; ?>','<?php echo $Product_details->VAT; ?>','<?php echo $Product_details->Merchandize_category_id; ?>','<?php echo $Product_details->Company_merchandize_item_code; ?>','<?php echo $M_item_name; ?>');">
										<i class="fa fa-shopping-cart"></i> Add to cart
									</button>
									<?php /*
									<button type="button" class="btn btn-template-main" onclick="add_to_wishlist('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>');" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
										<i class="fa fa-heart-o"></i>&nbsp;
									</button>  */ ?>
								</p>
							</form>						
						</div>
						<div class="box" id="details">
							<p>
								<h4>Menu Item Description</h4>
								<p><?php echo $Product_details->Merchandise_item_description; ?></p>
						</div>

						<!--<div class="box social" id="product-social">
							<h4>Show it to your friends</h4>
							<p>
								<a href="<?php //echo $this->config->item('base_url2')."share_notification.php?Title=".$Sharing_Title."&Content=".$Sharing_Content."&Image_path=".$Image_path."&Social_icon_flag=1&Share_redirection_link=".$Share_redirection_link."&Flag=1"; ?>" class="external facebook" data-animate-hover="pulse"  data-animate-hover="pulse" data-placement="top" data-toggle="tooltip" title="Share on Facebook">
									<i class="fa fa-facebook"></i>
								</a>
								
								<a href="<?php //echo $this->config->item('base_url2')."share_notification.php?Title=".$Sharing_Title."&Content=".$Sharing_Content."&Image_path=".$Image_path."&Social_icon_flag=2&Share_redirection_link=".$Share_redirection_link."&Flag=1"; ?>" class="external twitter" data-animate-hover="pulse"  data-animate-hover="pulse" data-placement="top" data-toggle="tooltip" title="Share on Twitter">
									<i class="fa fa-twitter"></i>
								</a>
								
								<a href="<?php //echo $this->config->item('base_url2')."share_notification.php?Title=".$Sharing_Title."&Content=".$Sharing_Content."&Image_path=".$Image_path."&Social_icon_flag=3&Share_redirection_link=".$Share_redirection_link."&Flag=1"; ?>" class="external gplus" data-animate-hover="pulse" data-placement="top" data-toggle="tooltip" title="Share on Google+">
									<i class="fa fa-google-plus"></i>
								</a>
							</p>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
<!------------------Size_chart modal--------------------->
<div id="Size_chart" class="modal fade" >
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
		 <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h5 class="modal-title">Size Chart</h5>
		  <?php if($Product_details->Size_chart == 1) 
		  { ?>
			<img src="<?php echo $Product_details->Size_chart_image; ?>" class="img-responsive">
		<?php } ?>
		<?php //echo $Item_details->Size_chart_image; ?>
		</div>
	</div>
  </div>
</div>
<!------------------Size_chart modal--------------------->
<!-- Modal -->
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
	
</section>
<?php if($Product_details->Size_flag == 1) { ?>
<!--<input type="hidden" id="Itemsize" value="1">-->
<input type="hidden" id="Itemsize" value="1">
<?php } else { ?>
<input type="hidden" id="Itemsize" value="0">
<?php } ?>

<?php $this->load->view('header/footer');?>

<style>
#popup 
{
	display:none;
}
div.square 
{
  border: solid 13px <?php echo $Product_details->Item_Colour; ?>;
  width: 0.5px;
  height: 0.5px;
  
  outline-color:gray;
  outline:1px solid;
  
}
.circle 
{
	color:white;
	height: 30px;
	margin: 9px;
	width: 30px;
     -webkit-border-radius: 25px;
     -moz-border-radius: 25px;
     border-radius: 25px;
     background: #fab900;
	 float: left;
}
#b1
{
	margin-top:10px;
}
</style>
<script>
	// var blink_speed = 700; 
	// var t = setInterval(function () { var ele = document.getElementById('blinker'); ele.style.visibility = (ele.style.visibility == 'hidden' ? '' : 'hidden'); }, blink_speed);
</script>
<script type="text/javascript" charset="utf-8">
function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Item_code,Item_name)
{
	// show_loader();
	Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
	// var price=document.getElementById("size_points").innerHTML;
	// var Item_size = $("#Itemsize").val();
	
	$.ajax({
		type: "POST",
		data: {id:serial,name:name,price:price,Delivery_method:29,Branch:Branch,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Item_code:Item_code,Item_name:Item_name},
		url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+Item_name+' is added to Cart Successfuly..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				// ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);				
				// location.reload(true);
				$("#Show_item_info").html(data.transactionReceiptHtml);	
				$('#item_info_modal').show();
				$("#item_info_modal").addClass( "in" );
			}
		}
	});
}

function add_to_wishlist(serial,name,price)
{
	var Size = $("#Itemsize").val();
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price,Size:Size },
		url: "<?php echo base_url()?>index.php/Shopping/add_to_wishlist",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is added to Wishlist..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				ShowPopup('Error adding Product '+name+' to Wishlist. Please try again..!!');
				$('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}

function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	setTimeout('HidePopup()', 9000);
}

function HidePopup()
{
	$('#popup').hide();
}
function Change_points_by_size(Points,Size,Weight,Dimension)
{
	var small_item=<?php echo $Small;?>;
	var medium_item=<?php echo $Medium;?>;
	var large_item=<?php echo $Large;?>;
	var ExtraLarge_item=<?php echo $ExtraLarge;?>;
	
		if(Size!=small_item && small_item!=0)
		{		
			document.getElementById(small_item).style.backgroundColor = "#fab900";
		}
	
		if(Size!=medium_item && medium_item!=0)
		{		
		document.getElementById(medium_item).style.backgroundColor = "#fab900";
		}
		
		if(Size!=large_item && large_item!=0)
		{		
			document.getElementById(large_item).style.backgroundColor = "#fab900";
		}
		if(Size!=ExtraLarge_item && ExtraLarge_item!=0)
		{		
			document.getElementById(ExtraLarge_item).style.backgroundColor = "#fab900";
		}
	
	document.getElementById(Size).style.backgroundColor = "#A9A9A9";
	
	document.getElementById("size_points").innerHTML=Points;
	document.getElementById("Itemsize").value=Size;
	
	<?php 
	if($Product_details->Weight_flag == 1)
 { ?>
	document.getElementById("Weight").innerHTML=Weight;
<?php }
 if($Product_details->Dimension_flag == 1)
 { ?>
	document.getElementById("Dimension").innerHTML=Dimension;
<?php } ?>
	// document.getElementById("Weight").innerHTML=Weight;
	// document.getElementById("Dimension").innerHTML=Dimension;
	
}
</script>

<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.cookie.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/waypoints.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.counterup.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.parallax-1.1.3.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/front.js"></script>