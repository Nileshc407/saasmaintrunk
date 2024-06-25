<?php $this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$ci_object->load->model('Igain_model'); 


$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}

?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<section class="content-header">
	<h1 class="text-center"></h1>
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#31859C !IMPORTANT"></div>
		</div>
	</div>
</section>		
		<?php foreach($Item_details as $Item_details){
			$Branches = $Redemption_Items_branches[$Item_details->Company_merchandize_item_code];
			//print_r($Branches);
			} ?>
			<?php foreach ($Branches as $Branches2){
					
					$DBranch_code=$Branches2['Branch_code'];
			} ?>
						<input type="hidden" name="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">		
			<div class="col-md-12">			
				<div class="row" id="productMain">
					<div class="col-sm-6">
						<div id="mainImage">
							<img src="<?php echo $Item_details->Thumbnail_image1; ?>" alt="" class="img-responsive" style="margin: 0px auto;">
						</div>						
						<br>
						<div class="row" id="thumbs">
							<div class="col-xs-4">
								<a href="<?php echo $Item_details->Thumbnail_image2; ?>" class="thumb">
									<img src="<?php echo $Item_details->Thumbnail_image2; ?>" alt="" class="img-responsive">
								</a>
							</div>
							<div class="col-xs-4">
								<a href="<?php echo $Item_details->Thumbnail_image3; ?>" class="thumb">
									<img src="<?php echo $Item_details->Thumbnail_image3; ?>" alt="" class="img-responsive">
								</a>
							</div>
							<div class="col-xs-4">
								<a href="<?php echo $Item_details->Thumbnail_image4; ?>" class="thumb">
									<img src="<?php echo $Item_details->Thumbnail_image4; ?>" alt="" class="img-responsive">
								</a>
							</div>
						</div>
						<br>
					
						<!--------------------Product Details----------------->
						<?php if($Item_details->Brand_flag ==1 || $Item_details->Colour_flag ==1 || $Item_details->Weight_flag ==1 || $Item_details->Dimension_flag ==1 || $Item_details->Manufacturer_flag ==1) { ?>
						<div class="box" id="Specifications">
						<label for="exampleInputEmail1"><h4> <b> <?php echo ('Product Specifications'); ?> </b></h4></label>
						<table class="table table-bordered table-hover">	
							<tbody>
								<?php if($Item_details->Brand_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5> <b>  <?php echo ('Brand'); ?> </b></h5></label>
									</td>
									<td>
									<p style="font-size: 14px; margin-top: 8px;"> <?php echo $Item_details->Item_Brand; ?> </p>
									</td>
								</tr>
								<?php } ?>
								
								<?php if($Item_details->Colour_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5> <b><?php echo ('Colour'); ?></b></h5></label>
									</td>
									<td>
									
										<div class="square" style="margin-top: 8px;">
											<img/>
										</div>
									</td>
								</tr>
								<?php } ?>
								<?php if($Item_details->Weight_flag ==1) {
									$Get_Code_decode = $ci_object->Igain_model->Get_codedecode_row($Item_details->Weight_unit_id);	
								?>
								<tr>
									<td>
											<label for="exampleInputEmail1"><h5> <b><?php echo ('Weight'); ?></b></h5></label>
									</td>
									<td>
										<div id="Weight" style="font-size: 14px; margin-top: 8px;"> <?php echo $Item_details->Item_Weight; ?> </div>&nbsp;<div style="font-size: 14px; margin-top: -45px;margin-left:40px;"><?php echo $Get_Code_decode->Code_decode; ?> </div>
										<input type="hidden" id="hidden_weight" value="<?php echo $Item_details->Item_Weight; ?>">
										<input type="hidden" id="hidden_weight_unit_id" value="<?php echo $Item_details->Weight_unit_id; ?>">
									</td>
								</tr>
									<?php } ?>
									
									<?php if($Item_details->Manufacturer_flag ==1) { ?>
								<tr>
									<td>
										<label for="exampleInputEmail1"><h5 ><b> <?php echo ('Manufacturer By'); ?></b></h5></label>
									</td>
									<td>
										<p style="font-size: 14px; margin-top: 8px;">	<?php echo $Item_details->Item_Manufacturer; ?> <p>	
									</td>
								</tr>
									<?php } 
									?>
									
									<?php if($Item_details->Dimension_flag ==1) { ?>
								<tr>
									<td>
											<label for="exampleInputEmail1"><h5><b><?php echo ('Dimension'); ?></b></h5></label> 
									</td>
									<td>
										<p id="Dimension" style="font-size:14px; margin-top: 8px;">	<?php echo $Item_details->Item_Dimension."<p style='margin: -10px 0px 0px 0px; color:red; font-size:10px;'>(Lenght X Width X Height)</p>"; ?>	
										</p>	
									</td>
								</tr>
									<?php } ?>	
							</tbody>
						</table>
						</div>
							<?php
							} ?>
						
					<!--------------------Product Details----------------->	
					</div>
					<div class="col-sm-6">
					<!--------------AMIT 29-11-2017**************-->
					
					<?php if($Item_details->Merchandize_item_type == 43 ) {
							if($Item_details->Delivery_method==0){ ?>	
								<div class="form-group">
									<label class="radio-inline">
										<input type="radio" name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="28" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,1);">Pick-up
									</label>
									<label class="radio-inline">
									<input type="radio" value="29"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,0);" checked>Delivery
									</label>
								</div>
								<div class="form-group" style="display:none;" id="<?php echo $Item_details->Company_merchandise_item_id; ?>">
									<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
									
									<select class="form-control" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" required>
										<option value=""><?php echo ('Select'); ?></option>
										<?php foreach ($Branches as $Branches3){?>
										<option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
										<?php } ?>
									</select>							
								</div>	
								<?php }elseif($Item_details->Delivery_method==28){ ?>
									<div class="form-group">
									<label class="radio-inline">
										<input type="radio" name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="28" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,1);" checked>Pick-up
									</label>
									</div>
									<div class="form-group" id="<?php echo $Item_details->Company_merchandise_item_id; ?>">
									<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
									
									<select class="form-control" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" required>
										<option value=""><?php echo ('Select'); ?></option>
										<?php foreach ($Branches as $Branches4){?>
										<option value="<?php echo $Branches4['Branch_code']; ?>"><?php echo $Branches4['Branch_name']; ?></option>
										<?php } ?>
									</select>							
								</div>	
								<?php }else{ ?>
								<div class="form-group">
									
									<label class="radio-inline">
									<input type="radio" value="29"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,0);" checked>Delivery
									</label>
									<input type="hidden" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="0">
								</div>
								<?php } ?>
								
							<?php }  else { 
													
												if($Item_details->Delivery_method==0) { ?>	
																											
												
													 <?php foreach ($Branches as $Branches3){
															$Branch_code=$Branches3['Branch_code'];
															$Branch_name= $Branches3['Branch_name']; 
														 } ?>
														<input type="hidden" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo $Branch_code; ?>" style="margin:-3%;" checked>
														<input type="radio" name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="28" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,1);" checked style="margin:-3%; display: none;">
														
												<?php } elseif($Item_details->Delivery_method==28) { 
												
													/* echo"---Merchandize_item_type-----".$product['Merchandize_item_type']."----<br>";
													echo"---Delivery_method-----".$product['Delivery_method']."----<br>"; */
												
												?>
													
													
													
													<?php foreach ($Branches as $Branches4){
														$Branch_code4=$Branches4['Branch_code'];
														$Branch_name4= $Branches4['Branch_name']; 
													 } ?>
													
														<input type="radio" value="28"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" checked style="display: none;">
														<input type="hidden" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo $Branch_code4; ?>" checked>													
													
													
												<?php } else { 
												?>
												
														
												
													
													 <?php foreach ($Branches as $Branches3){
														$Branch_code=$Branches3['Branch_code'];
														$Branch_name= $Branches3['Branch_name']; 
													 } ?>
													 <input type="radio" value="28"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" checked style="display: none;">
													<input type="hidden" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo  $Branch_code; ?>">
												
												<?php } ?>
												
												
												
							<?php } ?>
					<!--------------AMIT 29-11-2017*********XXX*****-->
					
					<!--<div class="form-group">
							<label for="exampleInputEmail1"><h5><b><?php echo ('Partner Location'); ?> : </b></h5></label>							
							<select class="form-control" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" required>
								<option value=""><?php echo ('Select'); ?></option>
								<?php foreach ($Branches as $Branches){?>
								<option value="<?php echo $Branches['Branch_code']; ?>"><?php echo $Branches['Branch_name']; ?></option>
								<?php } ?>
							</select>								
					</div>-->
						<?php
						$Small=0;
						$Medium=0;
						$Large=0;
						$ExtraLarge=0;
					?>
					<?php if($Item_details->Size_flag == 1) 
						{ ?>
						<br>
					<label for="exampleInputEmail1"><h5 style="margin:-20px 0 0 0px;"><b> <?php echo ('Select Size'); ?> : </b></h5></label> <?php } if($Item_details->Size_chart == 1) { ?><a style="margin:-1px 0px 0px 250px;" href="#" data-toggle="modal" data-target="#Size_chart">Size Chart</a> <?php } ?> <br>
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
									$Size="L";
									$Large=3;
								}
								elseif($Item_pricesz->Item_size == 4)
								{
									$Size="XL";
									$ExtraLarge=4;
								}
								?>
								<a href="javascript:Change_points_by_size('<?php echo $Item_pricesz->Billing_price_in_points;?>','<?php echo $Item_pricesz->Item_size; ?>','<?php echo $Item_pricesz->Item_weight; ?>','<?php echo $Item_pricesz->Item_Dimension; ?>');"><div id="<?php echo $Item_pricesz->Item_size; ?>" class="circle"> <h5 id="SizeText" style="text-align:center; margin:inherit; margin-top:7px; color:white;"> <?php echo $Size; ?> </h5></div></a>
						<?php	}	
						} 
						if($Item_details->Size_flag == 1) 
						{ ?>
						<br> <br>
						<?php } ?>
						<?php if($Item_details->Merchant_flag ==1) 
						{
							$get_enrollment = $ci_object->Igain_model->get_enrollment_details($Item_details->Seller_id);	
							$Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;	
							// echo $get_enrollment->First_name.' '.$get_enrollment->Last_name;?>					
						<h5 style="margin-top:11px;"><b> <?php echo ('Merchant Name'); ?> : </b> <?php
							echo $Merchent_name;
						} ?></h5>
						
						<div class="box" id="b1">
							<form>
								<div class="sizes">

									<h3><?php echo $Item_details->Merchandize_item_name; ?></h3>

								</div>
								<?php
								if($Item_details->Size_flag == 1) 
								{ 
									$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$Item_details->Company_merchandize_item_code);	
									$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
									$Item_size=$Get_item_price->Item_size;
								} 
								else 
								{ 
									$Item_size="0";
									$Billing_price_in_points = $Item_details->Billing_price_in_points;	
								}
								?>
								<p class="price" id="size_points" style="color:#c00704;"><?php echo $Billing_price_in_points.' '.$Company_Details->Currency_name; ?></p>
								<input type="hidden" id="Change_size_points" value="<?php echo $Billing_price_in_points; ?>">
								
								<p class="price"> <!--class="text-left"-->
									<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $Item_details->Company_merchandize_item_code; ?>','<?php echo $Item_details->Delivery_method; ?>',location_<?php echo $Item_details->Company_merchandise_item_id; ?>.value,'<?php echo $Item_details->Merchandize_item_name; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $Item_details->Company_merchandise_item_id; ?>);get_item_list();">
											<i class="fa fa-shopping-cart"></i> <?php echo ('Add to cart'); ?>
									</button>
								<br>	
								</p>
								
							</form>						
						</div>						
						<div class="box" id="details">
						
								<h4><b><?php echo ('Description'); ?></b></h4>
								<p><?php echo $Item_details->Merchandise_item_description; ?></p>
						</div>
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
			  <?php if($Item_details->Size_chart == 1) 
			  { ?>
				<img src="<?php echo $Item_details->Size_chart_image; ?>" class="img-responsive">
			<?php } ?>
			<?php //echo $Item_details->Size_chart_image; ?>
			</div>
		</div>
	  </div>
	</div>
	<!------------------Size_chart modal--------------------->
</section>
<?php if($Item_details->Size_flag == 1) { ?>
<!--<input type="hidden" id="Itemsize" value="1">-->
<input type="hidden" id="Itemsize" value="<?php echo $Get_item_price->Item_size; ?>">
<?php } else { ?>
<input type="hidden" id="Itemsize" value="0">
<?php } ?>
<?php $this->load->view('header/loader');?>
<?php $this->load->view('header/footer');?>
<style>
#popup 
{
	display:none;
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
#b1
{
	margin-top:10px;
}
</style>
<script type="text/javascript" charset="utf-8">
function add_to_cart(Company_merchandize_item_code,Delivery_method,location,Merchandize_item_name,Points,Item_size,Company_merchandise_item_id)
{
		var Points=document.getElementById("Change_size_points").value;
		var Item_size=document.getElementById("Itemsize").value;
		var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
		var Item_Weight=document.getElementById("hidden_weight").value;
		var Weight_unit_id=document.getElementById("hidden_weight_unit_id").value;
		 if(Checked_Delivery_method==29)
		{
			location=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		} 
		/* alert('Company_merchandize_item_code: '+Company_merchandize_item_code);
		alert('Delivery_method: '+Delivery_method);
		alert('location: '+location);
		alert('Merchandize_item_name: '+Merchandize_item_name);
		alert('Points: '+Points);
		alert('Item_size: '+Item_size);
		alert('Company_merchandise_item_id: '+Company_merchandise_item_id);  
		alert('Item_Weight: '+Item_Weight);  
		alert('Weight_unit_id: '+Weight_unit_id);   */
		// return false;
		if(location=="" && Checked_Delivery_method==28)//Pick up
		{
			ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
		}
		else
		{
			var Total_balance = <?php echo $Current_point_balance;?>;
			// var Current_redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
			var Current_redeem_points=document.getElementById("Total_Redeem_points12").innerHTML;
			// alert('--Current_redeem_points---'+Current_redeem_points);
			 Current_redeem_points=(parseInt(Current_redeem_points)+parseInt(Points));
			if(Current_redeem_points > Total_balance)
			{
				ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
				return false;
			}
			else
			{	
			
				$.ajax({
				type: "POST",
				data: { Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Checked_Delivery_method, location:location, Points:Points,Current_redeem_points:Current_redeem_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id },
				url: "<?php echo base_url()?>index.php/Redemption_Catalogue/add_to_cart",
				success: function(data)
				{
					// alert(data.cart_success_flag);		
					if(data.cart_success_flag == 1)
					{
							
						//$('.shoppingCart_total').html('$'+data.cart_total);
						if(parseInt(data.cart_total)>Total_balance)
						{
							ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
							return false;
						}
						else
						{
							ShowPopup('<?php echo ('Item added to Cart Successfuly !!!'); ?>');	
							document.getElementById("Total_Redeem_points").innerHTML=data.cart_total;
							document.getElementById("Total_Redeem_points2").innerHTML=data.cart_total;
						}
						
						
					}
					else
					{
						ShowPopup('Error adding Item '+Merchandize_item_name+' to Cart. Please try again..!!');
						$('.shoppingCart_total').html('$'+data.cart_total);
					}
				}
			});
			}
		}	
		
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
	
	document.getElementById("size_points").innerHTML=Points;
	document.getElementById("Change_size_points").value=Points;
	document.getElementById("Itemsize").value=Size;
	<?php 
	if($Item_details->Weight_flag == 1)
	{ ?>
		document.getElementById("Weight").innerHTML=Weight;
		document.getElementById("hidden_weight").value=Weight;
		
<?php }
	if($Item_details->Dimension_flag == 1)
	{ ?>
		document.getElementById("Dimension").innerHTML=Dimension;
<?php } ?>
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
	$('#popup').show();
	$('#popup_info').css('position','fixed');
	$('#popup_info').css('z-index','1');
	$('#popup_info').css('right','0');
	$('#popup_info').css('top','auto');
	$('#popup_info').css('bottom','50%');
	setTimeout('HidePopup()', 9000);
}

function HidePopup()
{
	$('#popup').hide();
}
function Show_branch(Company_merchandise_item_id,flag)
{
	if(flag==1)
	{
		document.getElementById(Company_merchandise_item_id).style.display="";
	}
	else
	{
		document.getElementById(Company_merchandise_item_id).style.display="none";
	}
	
}
</script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.cookie.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/waypoints.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.counterup.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.parallax-1.1.3.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/front.js"></script>