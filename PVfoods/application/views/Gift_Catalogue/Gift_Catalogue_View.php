<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
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

$Redemptionratio=$Company_Details->Redemptionratio;
?>	
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<!-------------------------------------Filter---------------------------->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.skinNice.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/bootstrap-slider/slider.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/all.css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/select2/select2.min.css">	
<!--------------------------------------Filter------------------------------>	
<section class="content-header">
	<div class="row">	
		<div class="col-md-9 col-xs-9 ">
			<h3><?php echo ('eVoucher Gift Card'); ?></h3>
		</div> 	
	</div>
</section>		
<div class="col-md-4 ">
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'Company work in progress... Will be up soon...Sorry for the inconvenience!',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
<?php } 
	if(@$this->session->flashdata('Redeem_flash'))
	{
	?>
		<script>
			var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('Redeem_flash'); ?>';
			runjs(Title,msg);						
		</script>					
	<?php
	}
	if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
	<?php } ?>
	</div>
	<div class="row"></div>
<!-- Main content -->
<section class="content">
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#31859C !IMPORTANT"></div>
		</div>
	</div>
	<div id="content">
		<div class="row products cd-container" id="FilterResult">
	<?php
			if($voucher_result != NULL)
			{			
				foreach($voucher_result as $value1) { 
					foreach($value1['denominations'] as $denominations_value)
					{
						$discount=$denominations_value['discount'];
						$smallest=$denominations_value['min'];
						$smallest_price=$denominations_value['min'];
						$max_price=$denominations_value['max'];
					} 
					if($smallest >= 1)
					{ ?>				
					<div class="col-md-3 "><br>
						<div class="product" style="height:450px;">
							<div class="image">
								<a href="JavaScript:void(0);">
									<img src="<?php echo $value1['image_url']; ?>" alt=""  style="height:150px;">
								</a><br><br>
								<p><?php echo $value1['name']; ?></p>
								<p>
								<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_DS_<?php echo $value1['id'];?>">| Description |</a>
								<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_TC_<?php echo $value1['id'];?>"> T & C |</a>
								
								<?php if($value1['terms_and_conditions']) { ?>
								<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_HTU_<?php echo $value1['id'];?>"> How to Use |</a>
								<?php } ?>
								
								<!-- Modal DS -->
									<div id="myModal_DS_<?php echo $value1['id'];?>" class="modal fade" role="dialog">
									  <div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Description</h4>
										  </div>
										  <div class="modal-body text-left">
											<p><?php echo html_entity_decode($value1['details']); ?></p>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										  </div>
										</div>

									  </div>
									</div>
									<!-- Modal TC -->	
									<div id="myModal_TC_<?php echo $value1['id'];?>" class="modal fade" role="dialog">
											<div class="modal-dialog">

												<!-- Modal content-->
												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Terms & Conditions</h4>
												  </div>
												  <div class="modal-body text-left">
													<p><?php echo html_entity_decode($value1['terms_and_conditions']); ?></p>
												  </div>
												  <div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												  </div>
												</div>
											</div>
									</div>
									<?php if($value1['how_to_use']) { ?>
									<!-- Modal myModal_HTU_ -->
									<div id="myModal_HTU_<?php echo $value1['id'];?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Redemption Instructions</h4>
												</div>
												<div class="modal-body text-left">
													<p><?php echo html_entity_decode($value1['how_to_use']); ?></p>
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
									$length = 0;
									$priceValue = array();
									
									if($smallest_price != $max_price)
									{
										$increase_by = $smallest_price;
											
										$smallest_price1 = $smallest_price;
										
										while($smallest_price1<$max_price)
										{  
											$price_value = $smallest_price+=$increase_by;
											
											array_push($priceValue, $price_value);			
											
											$smallest_price1+=$increase_by;
										}
									}
									
									$length = count($priceValue); 
								?>
									<select class="form-control" name="Price_value_<?php echo $value1['id'];?>" id="Price_value_<?php echo $value1['id'];?>" required onchange="Change_price(this.value,<?php echo $value1['id'];?>);">
									
									<?php if($smallest == $max_price) { ?>
											<option value="<?php echo $smallest; ?>"><?php echo $value1['currency']." ".$smallest; ?></option>		
								<?php   }
										else 
										{ ?>
											<option value="<?php echo $smallest; ?>"><?php echo $value1['currency']." ".$smallest; ?></option>
									<?php
											for($i=0;$i<$length;$i++) { ?>
												<option value="<?php echo $priceValue[$i]; ?>"><?php echo $value1['currency']." ".$priceValue[$i]; ?></option>
										<?php } 
												
										} ?>												
									</select>
								<br>
								<p class="text-center">
									<div class="qty mt-5">	
										<button type="submit" class="btn btn-template-main" onclick="RemoveQty(<?php echo $value1['id'];?>);" style="    background: #05083b;border-color: #05083b;">
											<span class="minus bg-dark">-</span>
										</button>
										
											<input type="text" class="count form-control text-center" name="qty_<?php echo $value1['id'];?>" id="qty_<?php echo $value1['id'];?>" value="1" readonly style="width:110px;display:inline">
											
										<button type="submit" class="btn btn-template-main" onclick="AddQty(<?php echo $value1['id'];?>);" style="    background: #05083b;border-color: #05083b;">
											<span class="plus bg-dark">+</span>
										</button>
									</div>
								</p>
							<?php 
								$Billing_price_in_points = $smallest * $Redemptionratio;
								
								$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
								?>
								<p class="text-center">
								<?php if($Billing_price_in_points != $Billing_price_in_points_tier)
								{
									$Billing_price_in_points = $Billing_price_in_points_tier;
									
									?>
									<del>Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['id'];?>"><?php 
									
									echo ($smallest * $Redemptionratio); 
									?></b></del> 
									<br>
									Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points1_<?php echo $value1['id'];?>"><?php echo ($Billing_price_in_points_tier); ?></b> 
								<?php   
								} 
								else
								{ ?>
									Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['id'];?>">
									<?php 
								
									echo ($smallest * $Redemptionratio); 
									?></b>
							<?php 
								}?>	
									<input type="hidden" name="Billing_price_in_points_<?php echo $value1['id'];?>" id="Billing_price_in_points_<?php echo $value1['id'];?>" value="<?php echo ($Billing_price_in_points); ?>" >
								</p>	
							</div>	
							<div class="text">
									<p class="price"></p>												
									<div class="text">
										<input type="hidden" name="Company_merchandize_item_code_<?php echo $value1['id'];?>" value="XOXODAY<?php echo $value1['id'];?>">
									
										<button type="submit" class="btn btn-template-main" onclick="Redeem_done('<?php echo $value1['image_url'];?>','<?php echo $value1['name'];?>','<?php echo $value1['id'];?>',28,'<?php echo $value1['name']; ?>','<?php echo $value1['id'];?>','<?php echo $value1['currency'];?>');" style="margin-left: -6px;">
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
			?>	
		</div>
	</div>			
</section>
<?php $this->load->view('header/loader');?>
<?php $this->load->view('header/footer');?>
 
<div id="loadingDiv" style="display:none;">
	<div>
		<h7>Please wait...</h7>
	</div>
</div>
<script>				
	function AddQty(pId)
	{	
		var Currency_name='<?php echo $Company_Details->Currency_name; ?>';
		var Gift_payment_balance = <?php echo $Company_Details->Gift_payment_balance; ?>;
		var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
		var Redemptionratio_tier = <?php echo $Tier_redemption_ratio; ?>;
		var Price_value= document.getElementById('Price_value_'+pId).value;
		var current_qty= document.getElementById('qty_'+pId).value;
		var newQty= parseInt(current_qty) + parseInt(1);
		
		var Gift_point_balance = parseInt(Redemptionratio*Gift_payment_balance);
		
		var Price_value1=parseInt(Price_value*newQty);
		var New_points = parseInt(Redemptionratio*Price_value1);
		// var New_points1 = parseInt(Redemptionratio_tier*Price_value1);AMIT 4-10-2022
		var New_points1 = parseInt(Redemptionratio_tier*New_points);
		
		if(Price_value1 <= Gift_payment_balance){		
		
			document.getElementById('qty_'+pId).value=newQty;
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;			
			document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points1;			
			return false;
			
		} else {
			
			ShowPopup("Company work in progress... Will be up soon...Sorry for the inconvenience");
		}
	}
	function RemoveQty(pId)
	{
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
		// var New_points1 = parseInt(Redemptionratio_tier*Price_value1);AMIT 4-10-2022
		var New_points1 = parseInt(Redemptionratio_tier*New_points);
		document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
		document.getElementById("Billing_price_in_points_"+pId).value=New_points;
		
		document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;
		document.getElementById("Billing_price_in_points_"+pId).value=New_points1;	
	}
	
	function Change_price(price,pId)
	{
		var Currency_name='<?php echo $Company_Details->Currency_name; ?>';
		var Gift_payment_balance = <?php echo $Company_Details->Gift_payment_balance; ?>;
		
		var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
		var Redemptionratio_tier = <?php echo $Tier_redemption_ratio; ?>;
		var current_qty= document.getElementById('qty_'+pId).value;
		var Price_value1=parseInt(price*current_qty);			
		var New_points = parseInt(Redemptionratio*Price_value1);
		// var New_points1 = parseInt(Redemptionratio_tier*Price_value1);New_points
		var New_points1 = parseInt(Redemptionratio_tier*New_points);
	
		var Gift_point_balance = parseInt(Redemptionratio*Gift_payment_balance);
		// alert(New_points);
		// console.log("---New_points1---)"+New_points1);
		if(Price_value1 <= Gift_payment_balance)
		{		
			document.getElementById('qty_'+pId).value=current_qty;
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
			document.getElementById("new_changed_points1_"+pId).innerHTML=New_points1;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points1;				
			return false;
			
		} else {
			
			ShowPopup("Company work in progress... Will be up soon...Sorry for the inconvenience");
		}
	}
</script>
<style>
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
<?php if($smartphone_flag == 1) { ?>
@media only screen and (min-width: 320px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:200px;
	}
	.modal-content
	{
	    width: 60%;		
		
	}
}
@media only screen and (min-width: 375px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:210px;
	}
	.modal-content
	{
	    width: 60%;		
		
	}
}
@media only screen and (min-width: 425px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:230px;
	}
	.modal-content
	{
	    width: 60%;		
	}
}
@media only screen and (min-width: 768px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:250px;
	}
	.modal-content
	{
	    width: 60%;		
		
	}
}
@media only screen and (min-width: 1024px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:330px;
	}
	.modal-content
	{
	    width: 60%;			
	}
}
@media only screen and (min-width: 1440px) {
   .navbar-custom-menu
	{
		position:fixed;
		margin-left:540px;
	}
	.modal-content
	{
	    width: 60%;		
	}
}

@media only screen and (min-width: 368px){
	.navbar-custom-menu
	{
		position:fixed;
		margin-left:500px;
	}
	.modal-content{
	    width:60%;
		
		margin-left:7%;
	}
}
<?php } ?>
</style>
<!--------------------------------------New Filter---------------------------------------------->
<script type="text/javascript" charset="utf-8">
<?php
	if($voucher_result['code'] == 404)
	{ ?>
		ShowPopup('<?php echo ('Items Not Found !!!'); ?>');
<?php } ?>
function Redeem_done(product_image,product_name,Company_merchandize_item_code,Delivery_method,Merchandize_item_name,pId,currency)
{
	var Billing_price_in_points=0;	
	var Voucher_price=document.getElementById("Price_value_"+pId).value;	
	var Voucher_price1=document.getElementById("Price_value_"+pId).value;	
	var qty=document.getElementById("qty_"+pId).value;	
	var Total_balance = <?php echo $Current_point_balance;?>;
	
	Voucher_price=parseInt(Voucher_price*qty);
	var Voucher_price_new=document.getElementById("Price_value_"+pId).value;
	var Redemptionratio = <?php echo $Redemptionratio; ?>;
	var Tier_redemption_ratio = <?php echo $Tier_redemption_ratio; ?>;
	
	var Billing_price_in_points = Voucher_price*Redemptionratio;
	var Tier_billing_price_in_points = Voucher_price*Tier_redemption_ratio;
	
	if(Billing_price_in_points != Tier_billing_price_in_points)
	{
		var Billing_price_in_points  = Tier_billing_price_in_points;
	}
	
	BootstrapDialog.confirm("Are you sure to Redeem "+product_name+" eVoucher?", function(result)
	{
		if (result == true)
		{
			document.getElementById("loadingDiv").style.display="";	
			if(Billing_price_in_points > Total_balance)
			{
				document.getElementById("loadingDiv").style.display="none";
				ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
				return false;
			}
			else
			{	
				$.ajax({
				type: "POST",
				data: {pId:pId,product_image:product_image,product_name:product_name,Company_merchandize_item_code:Company_merchandize_item_code, Points:Billing_price_in_points,Current_redeem_points:Billing_price_in_points,Total_balance:Total_balance,Voucher_price:Voucher_price1,qty:qty,currency:currency},
				url: "<?php echo base_url()?>index.php/Gift_Catalogue/Redemption_done",
				success: function(result)
				{		
					document.getElementById("loadingDiv").style.display="none";
					if(result.cart_success_flag == 1)
					{	
						if(parseInt(result.cart_total)>Total_balance)
						{
							ShowPopup('<?php echo ('Insufficient Current Balance.'); ?>');
							return false;
						}
						else
						{
							ShowPopup('<?php echo ('Vouchers Redeemed Successfully.'); ?>');	
							
							setTimeout('location.reload()',3000);
						}
					}
					else
					{
						ShowPopup('Unable to process '+product_name+' . Please try again.');	
					}
				}
				});
			}
		}
		else
		{
			return false;
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
	
	$('#popup').show();
	setTimeout('HidePopup()', 9000);
}
function HidePopup()
{
	$('#popup').hide();
}
</script>
<style>
.bootstrap-dialog.type-primary .modal-header{
	    background-color: #ffffff !IMPORTANT;
}
.bootstrap-dialog .bootstrap-dialog-title{
	 color: #020315 !IMPORTANT;
}
.modal-header {

    border-top-color: #06d7bc !IMPORTANT;
    border-bottom-color: #06d7bc !IMPORTANT;
}
.btn-default {
    background-color: #fd1090 !IMPORTANT;
    color: #fff !IMPORTANT;
    border-color: #fd1090 !IMPORTANT;
}

.navbar-custom-menu{
    margin-left: 75% !IMPORTANT;
}
.product .text{
	padding: 5px !IMPORTANT;
}
/* .control-sidebar{
	     display: none !IMPORTANT;
} */
</style>