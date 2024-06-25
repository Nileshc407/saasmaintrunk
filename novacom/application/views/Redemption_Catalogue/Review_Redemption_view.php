<?php
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>
<!--
	<link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
-->

	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1><?php echo ('Redeemed Items'); ?></h1>	 
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
		</div>
	</div>
        <div class="row">
				
				
			<?php if(empty($Redemption_Items)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center"><?php echo ('Your Redemption Cart is Empty. Please click on Continue redeem to Add items to Cart'); ?>.</p>
					<div class="col-md-6 text-center clearfix">
									<a href="<?php echo base_url()?>index.php/Redemption_Catalogue" class="btn btn-default"><i class="fa fa-chevron-left"></i> <?php echo ('Continue Redeem'); ?></a>
					</div>
				</div>
			<?php }else{ ?>
			
			<div class="col-md-12">
				<p class="text-muted lead text-center"><?php echo ('You have currently item(s) in cart'); ?>.</p>
			</div>
			
			<div class="col-md-12 clearfix" id="basket">
				<div class="box">
						<ul class="nav nav-pills nav-justified">
							<!--<li><a href="<?php //echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue"><i class="fa fa-shopping-cart"></i><br>Checkout</a></li>
							<li><a href="<?php //echo base_url()?>index.php/Redemption_Catalogue/Get_Shipping_details"><i class="fa fa-map-marker"></i><br>Shipping Address</a></li>-->
							<li class="active"><a href="#"><i class="fa fa-eye"></i>&nbsp; Review Redemption</a></li>
						</ul>
					<?php  echo form_open('Redemption_Catalogue/Insert_Redeem_Items'); ?>

						<div class="table-responsive">
							<table class="table"  style="border: 3px solid #ddd;">
								<thead>
									<tr>
										<th colspan="2"><?php echo ('Item Name'); ?></th>
										<th><?php echo ('Quantity'); ?></th>
										<th>Delivery Method</th>
										<th><?php echo ('Partner Location'); ?></th>
										<th> <?php echo ('Merchant Name'); ?></th>
										<th><?php echo ('Item size'); ?></th>
										<th><?php echo ('Total '.$Company_Details->Currency_name); ?></th>
										<th>Shipping <?php echo $Company_Details->Currency_name; ?> </th>
									</tr>
								</thead>
								
								<tbody>
								
									<?php 
									$Exist_Delivery_method=0;
									$Sub_total2=0;
									foreach ($Redemption_Items as $item2) 
									{									
										$Sub_total2=$Sub_total2+$item2["Total_points"];
									}
									foreach ($Redemption_Items as $item) 
									{									
									
										// echo "---Merchandize_item_type-------".$item["Merchandize_item_type"]."---<br>";
										$Get_Code_decode = $ci_object->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
										$Redemption_method=$Get_Code_decode->Code_decode;
										if($item["Redemption_method"]==29)
										{
											$Exist_Delivery_method=1;
											$Get_weight_items = $ci_object->Redemption_Model->get_weight_items_same_location($item["Partner_state"],$enroll);
											$Weight_in_KG=0;
											foreach($Get_weight_items as $rec)
											{
												$Total_weight_same_location=$rec["Total_weight_same_location"];
												$lv_Weight_unit_id=$rec["Weight_unit_id"];
												/*******Total Weight convert into KG for same location****/
												$kg=1;
												switch ($lv_Weight_unit_id)
												{
													case 2://gram
													$kg=0.001;break;
													case 3://pound
													$kg=0.45359237;break;
												}
												$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
												// echo "<br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id;
											}
											/*******Single Weight convert into KG****/

											$kg2=1;
											switch ($item["Weight_unit_id"])
											{
												case 2://gram
												$kg2=0.001;break;
												case 3://pound
												$kg2=0.45359237;break;
											}
											
											/**************************/
											
											
											$Single_Item_Weight_in_KG=($item["Weight"]*$item["Quantity"]*$kg2);
											
											 // echo "<br><br><b>Merchandize_item_name </b>".$item["Merchandize_item_name"]." <br><b>Weight </b>".$item["Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["Quantity"]." <br><b>Weight_unit_id </b>".$item["Weight_unit_id"]." <br><b>Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$item["Partner_state"]." <br><b>Temp_cart_id </b>".$item["Temp_cart_id"];
										}
										else
										{
											$Total_Weighted_avg_shipping_pts[]=0;
											$Weighted_avg_shipping_pts="-";
										}
										if($Shipping_charges_flag==2)
										{
											if($item["Redemption_method"]==29)
											{
												$Get_shipping_points = $ci_object->Igain_model->Get_delivery_price_master($item["Partner_Country_id"],$item["Partner_state"],$To_Country,$To_State,$Weight_in_KG,1);
												$Shipping_cost= $Get_shipping_points->Delivery_price;
												$Shipping_pts=round($Shipping_cost*$Redemptionratio);
												$Weighted_avg_shipping_pts=(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
												$Weighted_avg_shipping_pts=number_format((float)$Weighted_avg_shipping_pts, 2);
												$Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
												// echo "<br><b>Shipping_cost </b>".$Shipping_cost;
											}
										}
										elseif($Shipping_charges_flag==1)//Standard Charges
										{
											if($item["Redemption_method"]==29)
											{
												$Cost_Threshold_Limit2=round($Cost_Threshold_Limit*$Redemptionratio);
												if($Sub_total2 >= $Cost_Threshold_Limit2)
												{	
													$Shipping_pts=round($Standard_charges*$Redemptionratio);
													$Weighted_avg_shipping_pts=round(($Shipping_pts/$Weight_in_KG)*$Single_Item_Weight_in_KG);
													$Total_Weighted_avg_shipping_pts[]=$Weighted_avg_shipping_pts;
												}
												else
												{
													$Shipping_pts=0;
													$Weighted_avg_shipping_pts=0;
													$Total_Weighted_avg_shipping_pts[]=0;
												}
												// echo "<br><b>Standard_charges </b>".$Standard_charges;
											}
										}
										else
										{
											$Shipping_pts=0;
											$Weighted_avg_shipping_pts=0;
											$Total_Weighted_avg_shipping_pts[]=0;
										}
										
										// echo "<br><b>Shipping_pts </b>".$Shipping_pts;
										// echo "<br><b>Weighted_avg_shipping_pts </b>".$Weighted_avg_shipping_pts;
										$Sub_Total[]=$item["Total_points"];
										
										
										// echo "<br><b>key </b>".$key;
										// echo "<br><b>iv </b>".$iv;
										$Company_merchandise_item_id1 = string_encrypt($item['Company_merchandise_item_id'], $key, $iv);	
										$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Company_merchandise_item_id1);
										
										?>
								
										<tr>
											<td>
												<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
													<img src="<?php echo $item["Thumbnail_image1"]; ?>"  style="width:50px;height:50px;" >
												</a>
											</td>
											
											<td>
												
												
												<?php if($item["Merchandize_item_type"] == 43 ) {	?>
													<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>"><?php echo $item["Merchandize_item_name"]; ?></a>													
												<?php } else {?>													
													<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>"><?php echo $item["Merchandize_item_name"]; ?></a>
												<?php } ?>
												
												
											</td>
											<td><?php echo $item["Quantity"]; ?></td>
																					
											<td><?php 
												if($item["Merchandize_item_type"] == 43 ) {													
													echo $Redemption_method;
												} else {
													echo "-";
												}
												?></td>
											<td><b><?php //echo $Symbol_of_currency; ?></b>&nbsp;<?php 
												if($item["Merchandize_item_type"] == 43 ) {													
													echo $item["Address"];
												} else {
													echo "-";
												}
												?></td>
											<?php if($item['Merchant_flag'] ==1) 
											{
											$get_enrollment = $ci_object->Igain_model->get_enrollment_details($item['Seller_id']);
											$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
											}
											else
											{
											$merchant_name = "-";
											}
											?>						
											<td> 
											<?php
												echo $merchant_name;
											 ?>
											</td>
											<td><b></b>&nbsp;<?php if($item["Size"] == 1) { $item_Size="Small"; } elseif($item["Size"] == 2) { $item_Size ="Medium"; } elseif($item["Size"] == 3) { $item_Size ="Large"; } elseif($item["Size"] == 4) { $item_Size ="Extra Large"; } elseif($item["Size"] == 0) { $item_Size = "-";}
											echo $item_Size;?></td>
											
											<td><b><?php //echo $Symbol_of_currency; ?></b>&nbsp;
												<?php
												//$grand_total = $grand_total + $item['subtotal'];
												echo $item["Total_points"];
												?>
											</td>
											<td><b><?php //echo $Symbol_of_currency; ?></b>&nbsp;
												<?php
												//$grand_total = $grand_total + $item['subtotal'];
												echo $Weighted_avg_shipping_pts;
												?>
												<input type="hidden" name="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" id="Hidden_Weighted_avg_shipping_pts_<?php echo $item['Temp_cart_id']; ?>" value="<?php echo $Weighted_avg_shipping_pts;?>">
											</td>
											
										</tr>
									
									<?php }
											$lv_Sub_Total=array_sum($Sub_Total);
											$Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
											$Grand_total=($lv_Sub_Total+$Total_Shipping_Points);
									?>
									
								</tbody>
							
									<tr>
									<td  colspan="2"><b>Shipping Information</b></td>
									</tr>
									<tr>
										<td colspan="3"><?php echo $firstname." ".$lastname; ?></td>
										
										<td align="right" colspan="5"><b>Total Shipping <?php echo $Company_Details->Currency_name; ?> </b></td>
										<td><div id="Total_Shipping_Points">&nbsp;<?php echo $Total_Shipping_Points; ?> <?php echo $Company_Details->Currency_name; ?> </div></td>
										
									</tr>
							
									<tr>
									<td colspan="3"><?php echo $address; ?></td>
										<td align="right" colspan="5"><b>Sub Total</b></td>
										<td><b><div id="Sub_total"></b>&nbsp;<?php 
										echo ($lv_Sub_Total); ?> <?php echo $Company_Details->Currency_name; ?> </div></td>
									</tr>
							
									<tr>
										<td colspan="3"><?php echo $phone; ?></td>
										<td align="right" colspan="5"><b><?php echo ('Grand Total'); ?></b></td>
										<td><b><div id="Grand_total"></b>&nbsp;<?php 
										echo $Grand_total; ?> </div></td>
									</tr>
							
								<tr><td colspan="3">
								<?php if($Pin_no_applicable==1){?>
						<div class="form-group has-feedback"  id="pin_feedback">
							<label for="exampleInputEmail1" ><?php echo ('Member Pin'); ?></label>
							<input type="password" name="input_cust_pin"  id="input_cust_pin" value="" class="form-control" placeholder="Enter Pin No." required  style="width:100%;padding-right:0px !important;text-align:left;"/><span class="glyphicon" id="pin_glyphicon" aria-hidden="true"></span>						
							<div class="help-block" id="pin_help"></div>									
						</div>
						<?php } ?>
						</td></tr>
						
						<tr><td colspan="10" align="center" style="color:red;">
								<?php if($Enroll_details->Total_balance<=$Grand_total){?>
								Insufficient Current Balance !!!
						<?php } ?>
						</td></tr>
						
							</table>

						</div>
						<!-- /.table-responsive -->
				
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
						
							
							<div class="row" >
								
								<div class="col-md-6 col-xs-6" >
									<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Get_Shipping_details" class="btn btn-default" id="continue"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Shipping Details</a>
								</div>
								<div class="col-md-6 col-xs-6" align="right">
									<input type="hidden" name="Current_balance" value="<?php echo $Enroll_details->Current_balance;?>">
									<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
									<input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
									<input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
									<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
									<input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
									<input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
									<input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
									<input type="hidden" name="address" value="<?php echo $address; ?>">
									<input type="hidden" name="city" value="<?php echo $city; ?>">
									<input type="hidden" name="zip" value="<?php echo $zip; ?>">
									<input type="hidden" name="state" value="<?php echo $state; ?>">
									<input type="hidden" name="country" value="<?php echo $country; ?>">
									<input type="hidden" name="phone" value="<?php echo $phone; ?>">
									<input type="hidden" name="email" value="<?php echo $email; ?>">
									<?php if($Exist_Delivery_method==1){
										if($Enroll_details->Total_balance>=$Grand_total){
										?>
											<button type="submit" class="btn btn-template-main" name="submit"  id="proceed"  > Complete </button>
										
												<?php } } else {?>
												<button type="submit" class="btn btn-default" name="submit"  id="proceed"  ><?php echo ('Finish'); ?> </button>
										
									<?php } ?>
								</div>
							</div>	
						</div>	
				</div>
							
			</div>

					<?php echo form_close(); ?>	

				</div>
			</div>
			
			<?php } ?>
			
		</div>
	</section>
<?php $this->load->view('header/loader');?> 		
<?php $this->load->view('header/footer');?>	  
<style>
#popup 
{
	display:none;
}
</style>
<script type="text/javascript" charset="utf-8">

$('#continue').click(function()
{
	
	show_loader();
	
});

var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
var Redeemtion_limit = <?php echo $Redeemtion_limit; ?>;
var Tier_name = '<?php echo $Tier_name; ?>';
var Total_balance=<?php echo $Enroll_details->Total_balance;?>;

/* alert("Redeemtion_limit "+Redeemtion_limit);
alert("Total_balance "+Total_balance);
alert("Tier_name "+Tier_name); */

$('#proceed').click(function()
{
	if(Pin_no_applicable == 1)
	{	
			
			var Customer_pin = '<?php echo $Cust_Pin; ?>';
			//alert(Customer_pin);
			var Entered_pin = $('#input_cust_pin').val();
			
			if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
			{
				$('#input_cust_pin').val("");
				has_error("#pin_feedback","#pin_glyphicon","#pin_help","<?php echo ('Please Enter Valid Pin Number'); ?>");
				
			}
			else
			{
				has_success("#pin_feedback","#pin_glyphicon","#pin_help","<?php echo ('Valid Pin'); ?>");
				
			}
	
	}
	if(Total_balance >= Redeemtion_limit)
	{
		if(Pin_no_applicable == 1)
		{
			if( $('#input_cust_pin').val() != "")
			{
				show_loader();
			}
			else
			{
				var Title = "Application Information";
				var msg = '<?php echo ('Please Enter Member Pin !!!'); ?>';
				runjs(Title,msg);
				return false;
			}
		}
		else
		{
			show_loader();
		}
	}
	else
	{
		var Title = "Application Information";
		var msg = '<?php echo ('Sorry ! You can not redeem as your Current Balance is less than Minimum required for your Tier'); ?> '+Tier_name+' ! <?php echo ('You need atleast'); ?>  '+Redeemtion_limit+'  <?php echo ('Current balance to Redeem'); ?>';
		
		runjs(Title,msg);
		return false;
	}
});
if(Pin_no_applicable == 1)
	{	
		$("#input_cust_pin").attr("required","required");	
		$('#input_cust_pin').blur(function()
		{	
			var Customer_pin = '<?php echo $Cust_Pin; ?>';
			//alert(Customer_pin);
			var Entered_pin = $('#input_cust_pin').val();
			
			if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
			{
				$('#input_cust_pin').val("");
				has_error("#pin_feedback","#pin_glyphicon","#pin_help","<?php echo ('Please Enter Valid Pin Number'); ?>");
				
			}
			else
			{
				has_success("#pin_feedback","#pin_glyphicon","#pin_help","<?php echo ('Valid Pin'); ?>");
				
			}
		});
	}
	else
	{
		$("#input_cust_pin").removeAttr("required");	
	}

var Grand_total2=document.getElementById("Hidden_Grand_total").value;
document.getElementById("Grand_total").innerHTML=Grand_total2+" <?php echo $Company_Details->Currency_name; ?>";



if(Grand_total2 > Total_balance)
{
	ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
	
	document.getElementById("proceed").style.display="none";
}
function delete_item(Item_code,Merchandize_item_name,Branch,Total_points,Size,Redemption_method)
{	
 /*alert("Item_code "+Item_code);
alert("Merchandize_item_name "+Merchandize_item_name);
alert("Branch "+Branch);
alert("Total_points "+Total_points); 
alert("Redemption_method "+Redemption_method); 
alert("Size "+Size); */
		/*var Grand_total2=document.getElementById("Total_Redeem_points").innerHTML;
		var Total_Redeem_points=(Grand_total2-Total_points);
		var url = '<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue/?Item_code='+Item_code+'&Branch='+Branch+'&Total_Redeem_points='+Total_Redeem_points;
		alert("url "+url);
		window.location = url;
		//show_loader();
		return true;*/
		show_loader();
		var Grand_total2=document.getElementById("Total_Redeem_points").innerHTML;
		var Total_Redeem_points=(Grand_total2-Total_points);
		$.ajax({
			type:"POST",
			data:{Item_code:Item_code, Branch:Branch, Total_Redeem_points:Total_Redeem_points,Size:Size,Redemption_method:Redemption_method},
			url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
			success: function(data)
			{
				show_loader();
				/* show_loader();
				var url2=<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue
				window.location = url2; */
			}				
		});
	
}
function Update_cart(Qty,Item_code,Branch,Points,Size,Redemption_method,Item_Weight,Weight_unit_id)
{
/* 	alert("Qty "+Qty);
	alert("Item_code "+Item_code);
	alert("Branch "+Branch);
	alert("Points "+Points); */
	
	var url = '<?php echo base_url()?>index.php/Redemption_Catalogue/Update_Merchandize_Cart/?Item_code='+Item_code+'&Qty='+Qty+'&Branch='+Branch+'&Points='+Points+'&Total_Redeem_points='+Grand_total2+'&Size='+Size+'&Redemption_method='+Redemption_method+'&Item_Weight='+Item_Weight+'&Weight_unit_id='+Weight_unit_id;
	show_loader();
	window.location = url;
	return true;
	
}

function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
 
  if (charCode == 46 || charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	setTimeout('HidePopup()', 10000);
}

function HidePopup()
{
	$('#popup').hide();
}
</script>