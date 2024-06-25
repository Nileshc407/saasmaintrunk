<?php $ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$ci_object->load->model('Igain_model');
$Company_id = $this->session->userdata('Company_id'); 
?>
<!--<link href="<?php echo $this->config->item('base_url2')?>css_slider/bootstrap.css" rel="stylesheet" type="text/css" media="all" />-->
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.min.js"></script>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!--
<script type="text/javascript" src="http://localhost:81/amit/A11 Demo/js/move-top.js"></script>
<script type="text/javascript" src="http://localhost:81/amit/A11 Demo/js/easing.js"></script>-->

				<script type="text/javascript">
					jQuery(document).ready(function($) {
						$(".scroll").click(function(event){		
							event.preventDefault();
							$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
						});
					}); 
				</script>

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
<script>$(document).ready(function(c) {
	$('.alert-close').on('click', function(c){
		$('.message').fadeOut('slow', function(c){
	  		$('.message').remove();
		});
	});	  
});
</script>
<script>$(document).ready(function(c) {
	$('.alert-close1').on('click', function(c){
		$('.message1').fadeOut('slow', function(c){
	  		$('.message1').remove();
		});
	});	  
});
</script>
  <?php
		
        foreach($Item_details as $Item_details){
			$Branches = $Redemption_Items_branches[$Item_details->Company_merchandize_item_code];
			//print_r($Branches);
			} 
			$Company_id=$Item_details->Company_id; 
	?>
			
	<!---->
	<style>
	/*.etalage_small_thumbs
	{
		top:270px !important;
		right:-410px;
	}*/
	.etalage_icon
	{
		display:none !important;
	}
	@media screen and (max-width: 360px)
	{
		#partner_branch{
			width:100% !important;
		}
		#image1{
			width:100% !important;
		}
		.etalage_thumb_image {
			width:50% !important;
			height:50% !important;
		}
		.etalage_thumb {
			background: rgba(0, 0, 0, 0) url("../images/loadings.gif")  !important;
			border: 3px solid #eee !important;
		}
		.para-grid {
			height:50% !important;
		}
	}
	div.square 
	{
	  border: solid 13px <?php echo $Item_details->Item_Colour; ?>;
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
	.specific
	{
		color: #747272;
		font-size: 0.9em;
		line-height: 2.8em;
		padding: 1.5em 0;
	}
	
	</style>
		<div class="modal-content">
		
			<div class="modal-body"  style="margin-top:0%;">
			
				<div class="col-md-12 top-in-single" ><!--style="height: 450px !important;"-->
				<button type="button" class="close" aria-label="Close" id="close_modal">
				  <i ng-click="CloseModal()" class="glyphicon glyphicon-remove icon-arrow-right pull-right"></i>
				</button>
					<section class="content-header" style="display:none;" id="error_display">
						<h1 class="text-center"></h1>
						<div class="row">	
							<div class="col-md-6 col-md-offset-3" id="popup">
								<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
							</div>
						</div>
					</section>
					<!--Rotated Img-->
					<div class="col-md-5 single-top">				
						<ul id="etalage" style="margin-top: 35px;height:500px;">
							<li>
								<img class="etalage_source_image img-responsive" id="image1" src="<?php echo $Item_details->Item_image1; ?>" alt="">
								<img class="etalage_source_image img-responsive"  id="image2"  src="<?php echo $Item_details->Item_image1; ?>" alt="" >
							</li>							
							<li>
								<img class="etalage_thumb_image img-responsive" src="<?php echo $Item_details->Item_image2; ?>" alt="" >
								<img class="etalage_source_image img-responsive" src="<?php echo $Item_details->Item_image2; ?>" alt="" >
							</li>							
							<li>
								<img class="etalage_thumb_image img-responsive" src="<?php echo $Item_details->Item_image3; ?>" alt=""  >
								<img class="etalage_source_image img-responsive" src="<?php echo $Item_details->Item_image3; ?>" alt="" >
							</li>							
						    <li>
								<img class="etalage_thumb_image img-responsive" src="<?php echo $Item_details->Item_image4; ?>"  alt="" >
								<img class="etalage_source_image img-responsive" src="<?php echo $Item_details->Item_image4; ?>" alt="" >
							</li>
						</ul>

					</div>	
					<?php
						$Small=0;
						$Medium=0;
						$Large=0;
						$ExtraLarge=0;
					?>
					<!--Roated Img ended-->
					
					<!--Img info-->
					<div class="col-md-7 single-top-in">					
						<div class="single-para" style="margin-left:88.5px">							
							
						<h4><?php echo $Item_details->Merchandize_item_name; ?></h4>
						<?php if($Item_details->Size_flag == 1) 
						{ ?>						
							<label for="exampleInputEmail1" style="margin:-20px 0 0 0px;"><b><?php echo $this->lang->line('Select Size'); ?> : </b></label>
							<?php } if($Item_details->Size_chart == 1) { ?><a style="margin:-1px 0px 0px 250px;" href="#" data-toggle="modal" data-target="#Size_chart">Size Chart</a> <?php } ?><br>
						<?php
						if($Item_details->Size_flag == 1)
						{						
							$Get_item_price1 = $ci_object->Redemption_Model->Get_item_details1($Company_id,$Item_details->Company_merchandize_item_code);
							
							foreach($Get_item_price1 as $Item_pricesz)
							{
								//echo $Item_pricesz->Billing_price_in_points;	
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
									$Size= "L";
									$Large=3;
								}
								elseif($Item_pricesz->Item_size == 4)
								{
									$Size= "XL";
									$ExtraLarge=4;
								}
								?>
								<a href="javascript:Change_points_by_size('<?php echo $Item_pricesz->Billing_price_in_points;?>','<?php echo $Item_pricesz->Item_size; ?>','<?php echo $Item_pricesz->Item_weight; ?>','<?php echo $Item_pricesz->Item_Dimension; ?>');"><div id="<?php echo $Item_pricesz->Item_size; ?>" class="circle"> <h5 style="text-align:center; margin:inherit; margin-top: 7px; color:white;"> <?php echo $Size; ?> </h5> </div></a>
					<?php	}	
						} ?> 
						<?php
								if($Item_details->Size_flag == 1) 
								{ 
									$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$Item_details->Company_merchandize_item_code);	
									$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
								} 
								else 
								{ 
								$Billing_price_in_points = $Item_details->Billing_price_in_points;	
								}
								if($Item_details->Size_flag == 1)
								{ ?><br><br>
								<?php
								}
								?>
								<span id="size_points" class="add-to" style="margin-left:5.5px"><?php echo $Billing_price_in_points; ?> </span>&nbsp; <span class="add-to" style="margin-left:5.5px;"> <?php echo $this->lang->line('Points'); ?> </span>
							<?php if($Item_details->Merchant_flag ==1) 
							{
								$get_enrollment = $ci_object->Igain_model->get_enrollment_details($Item_details->Seller_id);			
								$Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
							?><br><br> 					
							<b> <?php echo $this->lang->line('Merchant Name'); ?> : </b>  
							<?php
								echo $Merchent_name; 
							} ?>							
							<p>
							<h5 style="margin-top:-27px;"><?php echo $this->lang->line('Partner Location'); ?> : </h5>							
							<select class="form-control" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="partner_branch" required style="width:300px;white-space: normal !important; word-wrap: break-word !important;" >
								<option value=""><?php echo $this->lang->line('Select'); ?></option>
								<?php foreach ($Branches as $Branches){?>
								<option value="<?php echo $Branches['Branch_code']; ?>"><?php echo $Branches['Branch_name']."-".$Branches['Address']; ?></option>
								<?php } ?>
							</select>							
							</p>
								
							<div class="text">
								<button type="submit" class="btn btn-template-main" onclick="add_to_cart('<?php echo $Item_details->Company_merchandize_item_code; ?>','<?php echo $Item_details->Merchandize_item_name; ?>',partner_branch.value,'<?php echo $Item_details->Company_merchandise_item_id; ?>','<?php echo $Item_details->Item_image1; ?>');">
								<i class="fa fa-shopping-cart"></i> <?php echo $this->lang->line('Add to cart'); ?>
								</button>										
							</div>
							<h4 style="margin-left:5.5px"><?php echo $this->lang->line('Description'); ?></h4>
							<p style="margin-left:5.5px"><?php echo $Item_details->Merchandise_item_description; ?></p>
							
							<!--------------------Product Details----------------->
						<?php if($Item_details->Brand_flag ==1 || $Item_details->Colour_flag ==1 || $Item_details->Weight_flag ==1 || $Item_details->Dimension_flag ==1 || $Item_details->Manufacturer_flag ==1) { ?>

						<label for="exampleInputEmail1"><h4>  <?php echo $this->lang->line('Product Specifications'); ?> </h4></label> 
						<table class="table table-bordered table-hover">	
						<tbody>
						
								<?php if($Item_details->Brand_flag ==1) { ?>
								<tr>
								<td>
								<label for="exampleInputEmail1"><h5>  <?php echo $this->lang->line('Brand'); ?></h5></label> 
								</td>
								<td style="height:0.1px">
								<span class="specific"><?php echo $Item_details->Item_Brand; ?> </span>	
								</td>
								</tr>
								<?php } ?>									
								<?php if($Item_details->Colour_flag ==1) { ?>
								<tr>
								<td>
								<label for="exampleInputEmail1"><h5> <?php echo $this->lang->line('Colour'); ?></h5></label> 
								</td>
								<td>
								<div class="square" style="margin-top: 8px;">
									<img/>
								</div>	
								</td>
								</tr>
								<?php } ?>
								<?php if($Item_details->Weight_flag ==1) { ?>
								<tr>
								<td>
									<label for="exampleInputEmail1"><h5><?php echo $this->lang->line('Weight'); ?></h5></label>
								</td>
								<td>
								<span class="specific" id="Weight"><?php echo $Item_details->Item_Weight; ?> </span>
								</td>
								</tr>
							<?php } ?>
								<?php if($Item_details->Manufacturer_flag ==1) { ?>
								<tr>
								<td>								
									<label for="exampleInputEmail1"><h5> <?php echo $this->lang->line('Manufacturer By'); ?></h5> </label>
								</td>
								<td>
								<span class="specific"> <?php echo $Item_details->Item_Manufacturer; ?> </span>	
								</td>
								</tr>
							<?php } ?>
							<?php if($Item_details->Dimension_flag ==1) { ?>	
								<tr>	
								<td>
									<label for="exampleInputEmail1"><h5> <?php echo $this->lang->line('Dimension'); ?></h5></label> 
								</td>
								<td>
								<span class="specific" id="Dimension"><?php echo $Item_details->Item_Dimension."</span><p style='margin: -20px 0px 0px 0px; color:red; font-size:10px;'>(Lenght X Width X Height)</p>"; ?>
								</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
							<?php	} ?>
						
					<!--------------------Product Details----------------->				
						</div>					
					</div>				
				</div>
				<div class="modal-footer" >
			<button type="button" id="close_modal2" class="btn btn-primary" ><?php echo $this->lang->line('Close'); ?></button>
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
			  <?php if($Item_details->Size_chart == 1) { ?> 
				<img src=" <?php echo $Item_details->Size_chart_image; ?>" class="img-responsive">
				<?php //echo $Item_details->Size_chart_image; ?>				
			<?php } ?>
			</div>
		</div>
	  </div>
	</div>
		<!---------------------Size Chart------------------->
<?php if($Item_details->Size_flag == 1) 
{ ?>
<!--<input type="hidden" id="Itemsize" value="1">-->
<input type="hidden" id="Itemsize" value="<?php echo $Get_item_price->Item_size; ?>">
<?php } else { ?>
<input type="hidden" id="Itemsize" value="0">
<?php } ?>
		
<script>
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
	document.getElementById("size_points").innerHTML=Points;
	document.getElementById("Itemsize").value=Size;
	<?php 
	if($Item_details->Weight_flag == 1)
	{ ?>
		document.getElementById("Weight").innerHTML=Weight;
<?php }
	if($Item_details->Dimension_flag == 1)
	{ ?>
		document.getElementById("Dimension").innerHTML=Dimension;
<?php } ?>
}	
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
</script>		
 <script>
 /**amit 11-07-2017*/

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
function add_to_cart(Company_merchandize_item_code,Merchandize_item_name,location,Company_merchandise_item_id,Item_image1)
{
	var Points=document.getElementById("size_points").innerHTML;
	var Size = $("#Itemsize").val();
	var partner_branch1 = document.getElementById("partner_branch");
	var partner_branch = partner_branch1.options[partner_branch1.selectedIndex].text;

	// alert("Company_merchandize_item_code "+Company_merchandize_item_code);
	 // alert("location "+location);
	// alert("Points "+Points);
	// alert("Merchandize_item_name "+Merchandize_item_name);	
	if(location=="")
	{
		ShowPopup('<?php echo $this->lang->line('Please Select Partner Location'); ?>');
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { Company_merchandize_item_code:Company_merchandize_item_code, Points:Points, Merchandize_item_name:Merchandize_item_name,location:location,Company_merchandise_item_id:Company_merchandise_item_id,Item_image1:Item_image1,partner_branch:partner_branch,Size:Size},
			url: "<?php echo base_url()?>index.php/Redemption_Catalogue/CI_add_to_cart",
			success: function(data)
			{
				// alert(data);
				ShowPopup('<?php echo $this->lang->line('Item added to Cart Successfuly !!!'); ?>');
				document.getElementById("lblCartCount").innerHTML=data;
				// window.location='<?php echo base_url()?>index.php';				
			}
		});
	}		
}
 </script>