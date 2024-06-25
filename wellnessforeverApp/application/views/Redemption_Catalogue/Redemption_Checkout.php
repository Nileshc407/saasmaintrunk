<?php
$this->load->view('front/header/header');
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$Delivery_method=0;
if($Redemption_Items !=NULL)
{
	foreach ($Redemption_Items as $item2) 
	{
		if($item2["Redemption_method"]==29)
		{
			$Delivery_method=1;
		}
	}
}
// echo"--Redemption_Items-----".count($Redemption_Items);
// echo"--Enrollement_id-----".$Enroll_details->Enrollement_id;
// die;
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
<!--
	<link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>


	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>-->

	
	
	
	<header>
		<div class="container">
			<div class="row">
				<div class="col-12">
				<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
				</div>
				<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				
					<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
					<div><h1>Redeemed Items</h1></div>
					<div class="leftRight">&nbsp;</div>
				</div>
			</div>
		</div>
	</header>
	
	<!-- Main content -->
	<section class="content">
		<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
		</div>
	</div>
        <div class="row">
				
			<?php //var_dump($Redemption_Items); ?>

			
			<?php if(empty($Redemption_Items)) { ?>
				<div class="col-md-12">
				<br>
				<br>
				<br>
				<br>
				<br>
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
					<?php if($Delivery_method==1){
						
						echo form_open('Redemption_Catalogue/Get_Shipping_details'); ?>
					<ul class="nav nav-pills nav-justified">
							<li class="active"><a href="#"><i class="fa fa-shopping-cart"></i>&nbsp; Checkout</a></li>
							<!--<li style="cursor:not-allowed;" ><a href="#" style="cursor:not-allowed;" ><i class="fa fa-map-marker"></i><br>Shipping Address</a></li>
							<li><a href="#" style="cursor:not-allowed;"><i class="fa fa-eye"></i><br>Review Redemption</a></li>-->
							
					</ul>
					
			<?php } else {
					$attri=array('id'=>"Insert_Redeem");
					echo form_open('Redemption_Catalogue/Insert_Redeem_Items',$attri);
				
				}
				?>
					
						
						
							<section class="h-100 gradient-custom">
							  <div class="container">
								<div class="row d-flex justify-content-center my-4">
								  <div class="col-md-8">
									<div class="card mb-4">
									  <div class="card-header py-3">
										<h5 class="mb-0">Cart - <?php echo count($Redemption_Items); ?> items</h5>
									  </div>
										<div class="card-body">									  
										<?php 
										$Exist_Delivery_method=0;
										if(isset($_SESSION["To_Country"]))
										{
											$To_Country=$_SESSION["To_Country"];
											$To_State=$_SESSION["To_State"];
										}
										$Sub_total2=0;
										foreach ($Redemption_Items as $item2) 
										{									
											$Sub_total2=$Sub_total2+$item2["Total_points"];
										}
										$i=0;
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

											// echo "---key---".$key."---<br>";
											// echo "---iv---".$iv."---<br>";

											// echo "----Company_merchandise_item_id---".$item['Company_merchandise_item_id']."---<br>";
											$Item_id = App_string_encrypt($item['Company_merchandise_item_id'], $key, $iv);	
											$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);

											// echo "----Company_merchandise_item_id---".$Company_merchandise_item_id."---<br>";
											// echo "----Merchandize_item_name---".$item["Merchandize_item_name"]."---<br>";
											
											
											
										?>
									  
											<!-- Single item -->
											<div class="row">
											  <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
												<!-- Image -->
												<div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
												  <img src="<?php echo $item["Thumbnail_image1"]; ?>"
													class="w-100" alt="<?php echo $item["Merchandize_item_name"]; ?>" />
												  <a href="#!">
													<div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
												  </a>
												</div>
												<!-- Image -->
											  </div>
											  <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
												<!-- Data -->
												<p><strong><?php echo $item["Merchandize_item_name"]; ?></strong></p>
												
												<?php 
												if($item["Merchandize_item_type"] == 43 || $item["Merchandize_item_type"] == 269) {													
													echo "<p>Address: '".$item["Address"]."'</p>";
												}
												?>
												
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
												
												
												
												<!-- Data -->
											  </div>

											  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
												<!-- Quantity -->
												<div class="d-flex mb-4" style="max-width: 300px">
												  <button type="button" class="redBtn text-center px-3 mr-2" style="background-image:none; border-radius: 10px;"
													onclick="Update_cart('minus','<?php echo $i; ?>','<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>')">
													-
												  </button>

												  <div class="form-outline" style="width: 100%;text-align: center;">
													<input type='tel' pattern='[0-9]*'  name="Quantity" id="Quantity<?php echo$i?>" value="<?php echo $item["Quantity"]; ?>" class="form-control" style="text-align: center;" maxlength="2" size="10"    onkeypress='return isNumberKey2(event)' onchange="Update_cart(this.value,'<?php echo $i; ?>','<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>')" class="form-control" style="text-align: center;" />
													<label class="form-label" for="form1">Quantity</label>
												  </div>

												  <button type="button" class="redBtn text-center px-3 ml-2" style="background-image:none;border-radius: 10px;"
													onclick="Update_cart('plus','<?php echo $i; ?>','<?php echo $item["Item_code"]; ?>','<?php echo $item["Branch"]; ?>','<?php echo $item["Points"]; ?>','<?php echo $item["Size"]; ?>','<?php echo $item["Redemption_method"]; ?>','<?php echo $item["Weight"]; ?>','<?php echo $item["Weight_unit_id"]; ?>')">
													+
												  </button>
												</div>
												<!-- Quantity -->

												<!-- Price -->
												<p class="text-center text-md-center">
												  <strong><?php
												//$grand_total = $grand_total + $item['subtotal'];
												echo $item["Total_points"].' '.$Company_Details->Currency_name;
												?></strong>
												</p>
												<p class="text-center text-md-center">
												  <a href="" onclick="delete_item('<?php echo $item['Item_code']; ?>','<?php echo $item['Merchandize_item_name']; ?>','<?php echo $item['Branch']; ?>','<?php echo $item['Total_points']; ?>','<?php echo $item['Size']; ?>','<?php echo $item["Redemption_method"]; ?>')">
													Remove
													</a>
												</p>
												<!-- Price -->
											  </div>
											</div>
											<!-- Single item -->
											<hr class="my-4" />


										<?php 
										$i++;
										}
										
										
										$lv_Sub_Total=array_sum($Sub_Total);
											$Total_Shipping_Points=array_sum($Total_Weighted_avg_shipping_pts);
											$Grand_total=($lv_Sub_Total+$Total_Shipping_Points);
										?>




										
									  </div>
									</div>
									<!--<div class="card mb-4">
									  <div class="card-body">
										<p><strong>Expected shipping delivery</strong></p>
										<p class="mb-0">12.10.2020 - 14.10.2020</p>
									  </div>
									</div>-->
									
								  </div>
								  <div class="col-md-4">
									<div class="card mb-4">
									  <div class="card-header py-3">
										<h5 class="mb-0">Summary</h5>
									  </div>
									  <div class="card-body">
										<ul class="list-group list-group-flush">
										  <li
											class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
											Sub Total
											<span><b><div id="Sub_total"></b>&nbsp;<?php 
										echo ($lv_Sub_Total); ?> <?php echo $Company_Details->Currency_name; ?></div></span>
										  </li>
										  <li class="list-group-item d-flex justify-content-between align-items-center px-0">
											Grand Total
											<span><b><div id="Grand_total"></b>&nbsp;<?php 
										echo $Grand_total.' '.$Company_Details->Currency_name; ?> </div></span>
										  </li>
										  <!--<li
											class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
											<div>
											  <strong>Total amount</strong>
											  <strong>
												<p class="mb-0">(including VAT)</p>
											  </strong>
											</div>
											<span><strong>$53.98</strong></span>
										  </li>-->
										</ul>

										<!--<button type="button" class="redBtn w-100 text-center mb-4" >
										  Continue Redeem
										</button>-->
										
										<a href="<?php echo base_url()?>index.php/Redemption_Catalogue" class="redBtn w-100 text-center mb-4" id="continue"> <?php echo ('Continue Redeem'); ?></a>
										
										<!--<button type="submit" name="submit"  id="proceed" class="redBtn w-100 text-center">
											Proceed
										</button>-->
										
										<?php /* ?>
										<input type="hidden" name="Current_balance" value="<?php echo $Current_point_balance;?>">
													<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
													<input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
													<input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
													<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
													<input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
													<?php */ ?>
													
													<?php if($Exist_Delivery_method==1) { ?>
													<button type="submit" class="redBtn w-100 text-center" name="submit"  id="proceed" >Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i> </button>
														
													<?php } else  { ?>
													<button type="submit" class="redBtn w-100 text-center" name="submit"  id="proceed"><?php echo ('Finish'); ?> </button>
											
													<?php } ?>
										
										
										
										
										
										
									  </div>
									  <br>
									</div>
								  </div>
								</div>
							  </div>
							</section>

						
						
						<?php /* ?>	
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
								<div class="row" >
									<div class="col-md-6 col-xs-6">
											<a href="<?php echo base_url()?>index.php/Redemption_Catalogue" class="btn btn-default" id="continue"><i class="fa fa-backward" aria-hidden="true"></i> <?php echo ('Continue Redeem'); ?></a>
									</div>
									<div class="col-md-6 col-xs-6" align="right">	
										<!--<div class="col-md-2 text-center clearfix">
											<button class="btn btn-default" type="submit"><i class="fa fa-refresh"></i> Update cart</button>
										</div>
										<div class="col-md-4 text-center clearfix" id="proceed">
											<a href="<?php echo base_url()?>index.php/Shopping/checkout" class="btn btn-template-main">
												Proceed to checkout <i class="fa fa-chevron-right"></i>
											</a>
										</div>-->
										
										<input type="hidden" name="Current_balance" value="<?php echo $Current_point_balance;?>">
										<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
										<input type="hidden" name="Sub_Total" id="Sub_Total" value="<?php echo $lv_Sub_Total;?>">
										<input type="hidden" name="Total_Shipping_Points" id="Total_Shipping_Points" value="<?php echo $Total_Shipping_Points;?>">
										<input type="hidden" name="Total_Redeem_points" id="Hidden_Grand_total" value="<?php echo $Grand_total;?>">
										<input type="hidden" name="Full_name" value="<?php echo $Enroll_details->First_name." ".$Enroll_details->Middle_name." ".$Enroll_details->Last_name;?>">
										
										<?php if($Exist_Delivery_method==1) { ?>
										<button type="submit" class="btn btn-template-main" name="submit"  id="proceed" >Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i> </button>
											
										<?php } else  { ?>
										<button type="submit" class="btn btn-template-main" name="submit"  id="proceed"><?php echo ('Finish'); ?> </button>
								
										<?php } ?>
									</div>		
								</div>	
						</div>
						<?php */ ?>	
							
			</div>
					<input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<?php echo form_close(); ?>	

				</div>
			</div>
			
			<?php } ?>
			
		</div>
	</section>
<?php //$this->load->view('header/loader');?> 		
<?php $this->load->view('front/header/footer');?>	  
<style>
#popup 
{
	display:none;
}
</style>
<script type="text/javascript" charset="utf-8">

$('#continue').click(function()
{
	
	// show_loader();
	
});
$('#continue').click(function()
{
	
	// show_loader();
	
});

var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
var Redeemtion_limit = <?php echo $Redeemtion_limit; ?>;
var Tier_name = '<?php echo $Tier_name; ?>';
var Total_balance=<?php echo $Current_point_balance;?>;

/* alert("Redeemtion_limit "+Redeemtion_limit);
alert("Total_balance "+Total_balance);
alert("Tier_name "+Tier_name); */


 /*  $("#Insert_Redeem").submit(function(evt){
	  alert("on alert");
	  $('#proceed').prop('disabled', true);
		$('#proceed').html('Processing Data....');
  } */


$('#proceed').click(function()
{
	
	
	
	
	if(Total_balance >= Redeemtion_limit)
	{
		
			// show_loader();
			
		// $(':input[type="submit"]').prop('disabled', true);
		// $('#proceed').prop('disabled', true);
		$('#proceed').css('padding','0px !IMPORTANT;');
		$('#proceed').css('padding','0px');
		$('#proceed').html('Processing Please Wait...');
		$(':input[type="submit"]').html('Processing Please Wait...');
		return true;
		
	}
	else
	{
		var Title = "Application Information";
		var msg = '<?php echo ('Sorry ! You can not redeem as your Current Balance is less than Minimum required for your Tier'); ?> '+Tier_name+' ! <?php echo ('You need atleast'); ?>  '+Redeemtion_limit+'  <?php echo ('Current balance to Redeem'); ?>';
		
		runjs(Title,msg);
		return false;
	}
});

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
		// show_loader();
		// var Grand_total2=document.getElementById("Total_Redeem_points").innerHTML;
		var Grand_total2=document.getElementById("Total_Redeem_points").value;
		var Total_Redeem_points=(Grand_total2-Total_points);
		$.ajax({
			type:"POST",
			dataType: 'json',
			data:{Item_code:Item_code, Branch:Branch, Total_Redeem_points:Total_Redeem_points,Size:Size,Redemption_method:Redemption_method},
			url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
			success: function(data)
			{
				$('.txt_csrfname').val(response.token);
				// show_loader();
				/* show_loader();
				var url2=<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue
				window.location = url2; */
				setTimeout('location.reload(true)', 3000);
			}				
		});
	
}
function Update_cart(Qty,number,Item_code,Branch,Points,Size,Redemption_method,Item_Weight,Weight_unit_id)
{
	
	var csrfName = $('.txt_csrfname').attr('name'); 
	var csrfHash = $('.txt_csrfname').val();
	
	// alert("Qty:"+Qty);
	var TotalQty=document.getElementById("Quantity"+number).value;
	// alert("TotalQty:"+TotalQty);
	
	if(Qty=='plus'){
		Qty=parseInt(TotalQty)+1;
	} else if(Qty=='minus'){
		Qty=parseInt(TotalQty)-1;
	} else {
		Qty=Qty;
	}
	
	if(Qty==0){
		Qty=1;
	}
	// alert("Final Qty : "+Qty);
	// return false;
	/* alert("Qty:"+Qty);
	alert("Item_code :"+Item_code);
	alert("Branch: "+Branch);
	alert("Points: "+Points); 
	alert("Grand_total2:"+Grand_total2); 
	alert("Size :"+Size); 
	alert("Redemption_method: "+Redemption_method); 
	alert("Item_Weight: "+Item_Weight); 
	alert("Weight_unit_id: "+Weight_unit_id); 
	alert('<?php echo $key; ?>'); 
	alert('<?php echo $iv; ?>'); */
	
	
	// var Grand_total2=document.getElementById("Total_Redeem_points").value;
	// alert("Grand_total2:"+Grand_total2); 
	// return false;
	var url = '<?php echo base_url()?>index.php/Redemption_Catalogue/Update_Merchandize_Cart/?Item_code='+Item_code+'&Qty='+Qty+'&Branch='+Branch+'&Points='+Points+'&Total_Redeem_points='+encodeURIComponent(Grand_total2)+'&Size='+Size+'&Redemption_method='+Redemption_method+'&Item_Weight='+Item_Weight+'&Weight_unit_id='+Weight_unit_id+'&csrfName='+csrfHash;
	// show_loader();
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