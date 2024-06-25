<?php $ci_object = &get_instance();
$ci_object->load->model('Redemption_Catalogue/Redemption_Model');
$ci_object->load->model('Igain_model');
?>

<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>css_slider/etalage.css">
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.etalage.min.js"></script>

<script>
jQuery(document).ready(function($){
	$('#etalage').etalage({
		thumb_image_width: 250,
		thumb_image_height: 350,
		source_image_width: 900,
		source_image_height: 900,
		show_hint: true,
		click_callback: function(image_anchor, instance_id){
			alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
		}
	}); 
});
</script>

<?php	
if($Product_details!=NULL)	
{ 	 
	$Company_id = $Product_details->Company_id;
	$Branch_code = $ci_object->Igain_model->get_partner_branch($Company_id,$Product_details->Company_merchandize_item_code);	
	$DBranch_code=$Branch_code->Branch_code;
 ?>	
	<div class="modal-content">
		<div class="modal-body"  style="margin-top:0%;">
			<div class="modal-header">
			<button type="button" class="close" aria-label="Close" id="close_modal">
			  <i ng-click="CloseModal()" class="glyphicon glyphicon-remove icon-arrow-right pull-right"></i>
			</button>
			  <h4 class="modal-title">Order again</h4>
			</div>
			<div class="col-md-12 top-in-single" > <!--style="height: 450px !important;"-->
				<section class="content-header" style="display:none;" id="error_display">
					<h1 class="text-center"></h1>
					<div class="row">	
						<div class="col-md-6 col-md-offset-3" id="popup">
							<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
						</div>
					</div>
				</section>
				
				<input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">	
				<!--Rotated Img-->
				<div class="col-md-5 single-top">				
					<ul id="etalage" style="margin-top: 35px;height:500px !important;width:500px !important;">
						<li>
							<img class="etalage_source_image img-responsive" id="image1" src="<?php echo $Product_details->Item_image1; ?>" alt="">
							<img class="etalage_source_image img-responsive"  id="image2"  src="<?php echo $Product_details->Item_image1; ?>" alt="" >
						</li>							
						<li>
							<img class="etalage_thumb_image img-responsive" src="<?php echo $Product_details->Item_image2; ?>" alt="" >
							<img class="etalage_source_image img-responsive" src="<?php echo $Product_details->Item_image2; ?>" alt="" >
						</li>							
						<li>
							<img class="etalage_thumb_image img-responsive" src="<?php echo $Product_details->Item_image3; ?>" alt=""  >
							<img class="etalage_source_image img-responsive" src="<?php echo $Product_details->Item_image3; ?>" alt="" >
						</li>							
						<li>
							<img class="etalage_thumb_image img-responsive" src="<?php echo $Product_details->Item_image4; ?>"  alt="" >
							<img class="etalage_source_image img-responsive" src="<?php echo $Product_details->Item_image4; ?>" alt="" >
						</li>
					</ul>
				</div>	
				<!--Roated Img ended-->
				<?php 
					$Small=0;
					$Medium=0;
					$Large=0;
					$ExtraLarge=0;
				?>
				
				<div class="col-md-7 single-right-left simpleCart_shelfItem">					
					<div class="single-para">			
						<h3><?php echo $Product_details->Merchandize_item_name; ?></h3>
						<input type="hidden" id="size_points1" value="<?php echo $Product_details->Billing_price; ?>">
						<h2 style="margin-right:300px;" id="size_points" ><?php echo $Symbol_of_currency.' '.$Product_details->Billing_price; ?> </h2>
					<?php  
						if($Product_details->Merchant_flag ==1) 
						{
							$get_enrollment = $ci_object->Igain_model->get_enrollment_details($Product_details->Seller_id);			
							$Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
						 ?>
							<div style="margin-top:10px;"><b>Outlet Name : </b>  <?php echo $Merchent_name; 
						} ?></div>	<br>
							<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2">
								<fieldset>
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" />
									<input type="hidden" name="item_name" value="<?php echo $Product_details->Merchandize_item_name; ?>" />
									<input type="hidden" name="Company_merchandise_item_id"  value="<?php echo $Product_details->Company_merchandise_item_id; ?>" />
									<input type="hidden" name="amount" id="amount_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $Product_details->Billing_price_in_points; ?>" />
									<?php if($Product_details->Size_flag == 1) 
									{ 
										$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$Product_details->Company_merchandize_item_code);	
								?>
									<input type="hidden" id="Itemsize_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $Get_item_price->Item_size; ?>">
									<?php } else { ?>
									<input type="hidden" id="Itemsize_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="0">
									<?php } ?>
									
									<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>',29,29,<?php echo $Product_details->Company_merchandise_item_id; ?>,'<?php echo $Item_pricesz->Item_size; ?>',<?php echo $Product_details->Item_Weight; ?>,<?php echo $Product_details->Weight_unit_id; ?>,<?php echo $Product_details->Partner_id; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $Product_details->Seller_id; ?>,<?php echo $Product_details->Merchant_flag; ?>,'<?php echo $Product_details->Cost_price; ?>','<?php echo $Product_details->VAT; ?>','<?php echo $Product_details->Merchandize_category_id; ?>');">
									<i class="fa fa-shopping-cart"></i> Add to cart
									</button>
								</fieldset>				
							</div><br>							
							<h4 style="margin-left:5.5px">Description</h4>
							<p style="margin-left:5.5px"><?php echo $Product_details->Merchandise_item_description; ?></p>
					</div>					
				</div>
			</div>
			<div class="modal-footer" >
				<button type="button" id="close_modal2" class="btn btn-primary" >Close</button>
			</div>
		</div>
	</div>
<!---------------------Size Chart------------------->
<div id="Size_chart" class="modal fade" >
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
		 <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h5 class="modal-title">Size Chart</h5>
		  <?php if($Product_details->Size_chart == 1) { ?> 
			<img src=" <?php echo $Product_details->Size_chart_image; ?>" class="img-responsive">
			<?php //echo $Item_details->Size_chart_image; ?>				
		<?php } ?>
		</div>
	</div>
  </div>
</div>
<?php if($Product_details->Size_flag == 1) { ?>
<!--<input type="hidden" id="Itemsize" value="1">-->
<input type="hidden" id="Itemsize" value="1">
<?php } else { ?>
<input type="hidden" id="Itemsize" value="0">
<?php } ?>

<?php } else { ?>
<script>
	var Title = "Application Information";
	var msg = "The item is currently unavailable";
	runjs(Title,msg);
</script>
<?php } ?>
<!---------------------Size Chart------------------->	
<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#item_info_modal').hide();
		$("#item_info_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	$( "#close_modal2" ).click(function(e)
	{
		$('#item_info_modal').hide();
		$("#item_info_modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});	
});
 
function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	$('#error_display').show();
	setTimeout('HidePopup()', 9000);
}
function HidePopup()
{
	$('#popup').hide();
	$('#error_display').hide();
}

function Show_branch(Company_merchandise_item_id,flag)
{
	if(flag==1)
	{
		document.getElementById('Brnach2_'+Company_merchandise_item_id).style.display="";
	}
	else
	{
		document.getElementById('Brnach2_'+Company_merchandise_item_id).style.display="none";
	}
}

function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id)
{
	show_loader();
	Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
	
	// var price=document.getElementById("size_points").innerHTML;
	var price = $("#size_points1").val();
	var Item_size = $("#Itemsize").val();
	// alert('2Item_size'+Item_size);
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id},
		url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
				$('.shoppingCart_total').html('$'+data.cart_total);
				location.reload(true);
			}
			else
			{
				ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
				$('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
function Change_points_by_size(Points,Size,Weight,Dimension)
{
	var small_item=<?php echo $Small;?>; 
	var medium_item=<?php echo $Medium;?>;
	var large_item=<?php echo $Large;?>;
	var ExtraLarge_item=<?php echo $ExtraLarge;?>;
	
		if(Size!=small_item && small_item!=0)
		{		
			document.getElementById(small_item).style.backgroundColor = "#45aed6";
		}
	
		if(Size!=medium_item && medium_item!=0)
		{		
		document.getElementById(medium_item).style.backgroundColor = "#45aed6";
		}
		
		if(Size!=large_item && large_item!=0)
		{		
			document.getElementById(large_item).style.backgroundColor = "#45aed6";
		}
		if(Size!=ExtraLarge_item && ExtraLarge_item!=0)
		{		
			document.getElementById(ExtraLarge_item).style.backgroundColor = "#45aed6";
		}
	
	document.getElementById(Size).style.backgroundColor = "#A9A9A9";
	
	document.getElementById("size_points1").innerHTML=Points;
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
     background: #45aed6;
	 float: left;
}
#b1
{
	margin-top:10px;
}
 </style>