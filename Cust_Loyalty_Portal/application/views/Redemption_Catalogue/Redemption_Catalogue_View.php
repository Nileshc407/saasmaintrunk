<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
//$Company_id =32;

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

$data['Company_id'] = $session_data['Company_id'];
$data['enroll'] = $session_data['enroll'];
$ci_object->load->model('Redemption_Catalogue/Redemption_Model');
$Redeemtion_details = $ci_object->Redemption_Model->get_total_redeeem_points($data['enroll']);
$Total_Redeem_points=0;
//echo "dsfdsfdsf".count($Redeemtion_details);
// if(is_countable($Redeemtion_details)  && count($Redeemtion_details)!=0)
if(count($Redeemtion_details)!=0)
{

	foreach($Redeemtion_details as $Redeemtion_details)
	{
		//echo "<br>".$Redeemtion_details["Points"];
		//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
		$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
	}
}


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
			<h3><?php echo ('Redemption Catalogue'); ?></h3>
		</div> 
		<div class="col-md-3 col-xs-3"> 
			<button type="button" class="btn btn-info btn-lg" data-toggle="control-sidebar" data-placement="top" title="Filter" style="margin-top:10px;background: #bf0268 none repeat scroll 0 0;border-color: #bf0268; float: right;">
				<i class="fa fa-filter" aria-hidden="true"></i>
			</button>
		</div>	
	</div>
</section>		
<div class="col-md-4 ">

				
	<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
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
<?php } ?>
<!------------------------------------------------------------------------------------------------------->

	<?php
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
		?>
		
	<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
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
			<div class="btn btn-template-main" role="alert" id="popup_info" style="background-color:#fd1090 !IMPORTANT"></div>
		</div>
	</div>
	<div id="content">
			 <!--<div class="row products">-->
			 <div class="row products cd-container" id="FilterResult">
				<?php
				function string_decrypt($encrypted_string, $key, $iv)
				{	
					$version = phpversion();
				// echo "-------version----".$version."---------------<br>";
					$new_version=  substr($version, 0, 1);
				
				// echo "-------new_version----".$new_version."---------------<br>";
					if($new_version >= 7) {
							
										
							$first_key = base64_decode($key);
							$second_key = base64_decode($key);            
							$mix = base64_decode($encrypted_string);

							$method = "aes-256-cbc";    
							$iv_length = openssl_cipher_iv_length($method);

							$iv = substr($mix,0,$iv_length);
							$second_encrypted = substr($mix,$iv_length,64);
							$first_encrypted = substr($mix,$iv_length+64);

							$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);


							// echo "--Output-data--".$data."------<br><br>";

							return $data;
							
					} else {
							
						return mcrypt_decrypt
							(
								MCRYPT_RIJNDAEL_256, 
								$key, 
								base64_decode($encrypted_string), 
								MCRYPT_MODE_CBC, $iv
							);
							
					}
				}
				if($Redemption_Items != NULL)
				{
					foreach ($Redemption_Items as $product)
					{	
						$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];
					
					?>
						<?php 
							foreach ($Branches as $Branches2)
							{
								$DBranch_code=$Branches2['Branch_code'];
							}
						?>
						<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">
						
						<?php if($product['Merchandize_item_type']== 43 || $product['Merchandize_item_type']== 269 ) 
						{
							$Company_merchandise_item_id = $product['Company_merchandise_item_id'];													
							$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
							$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
						?>
								<div class="col-md-3 "><br>
									<div class="product" style="height:450px;">
										<div class="image">
											<a href="#">
												<img src="<?php echo $product['Thumbnail_image1']; ?>" alt=""  style="height:150px;">
											</a>
										</div>
											
										<div class="text">
											<h5 style="line-height: 1.5em; height: 3em;       
												overflow: hidden;">
													<a href="#"> <?php echo $product['Merchandize_item_name']; ?> </a> </h5>
												<p class="price"><?php  
												if($product['Size_flag'] == 1) 
												{ 
													$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
													$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
													echo $Get_item_price->Billing_price_in_points.' '.$Company_Details->Currency_name;
													$Item_size=$Get_item_price->Item_size;
												} 
												else 
												{
													$Item_size="0";
													$Billing_price_in_points = $product['Billing_price_in_points'];
													
													$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
													
													if($Billing_price_in_points != $Billing_price_in_points_tier)
													{
														$Billing_price_in_points = $Billing_price_in_points_tier;
														
														echo "<del>".$product['Billing_price_in_points'].' '.$Company_Details->Currency_name."</del><br>";
														echo $Billing_price_in_points.' '.$Company_Details->Currency_name;
													}
													else
													{
														echo $product['Billing_price_in_points'].' '.$Company_Details->Currency_name;
													}
													
												}
												?></p>
												<?php  if($product['Delivery_method']==0){ ?>	
												<div class="form-group">
													<label class="radio-inline">
														<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" checked>Attend At
													</label>
													<!--<label class="radio-inline">
													<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>Delivery
													</label>-->
												</div>
												<!--style="display:none;"-->
												<div class="form-group"  id="<?php echo $product['Company_merchandise_item_id']; ?>">
													<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
													
													<select class="form-control" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
														<option value=""><?php echo ('Select'); ?></option>
														<?php foreach ($Branches as $Branches3){?>
														<option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
														<?php } ?>
													</select>							
												</div>	
												<?php }elseif($product['Delivery_method']==28){ ?>
													<div class="form-group">
													<label class="radio-inline">
														<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" checked>Pick-up
													</label>
													</div>
													<div class="form-group" id="<?php echo $product['Company_merchandise_item_id']; ?>">
													<label for="exampleInputEmail1"><h5><?php echo ('Partner Location'); ?> : </h5></label>
													
													<select class="form-control" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
														<option value=""><?php echo ('Select'); ?></option>
														<?php foreach ($Branches as $Branches4){?>
														<option value="<?php echo $Branches4['Branch_code']; ?>"><?php echo $Branches4['Branch_name']; ?></option>
														<?php } ?>
													</select>	
													
												</div>	
												<?php } else { ?>
												
												<div class="form-group">
													
													<label class="radio-inline">
													<input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>Delivery
													</label>
													<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="0">
												</div>
												<?php } ?>
												
											<div class="text">
													<button type="submit" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);get_item_list();" style="margin-left: -6px;">
														<i class="fa fa-shopping-cart"></i> <?php echo ('Add to cart'); ?>
													</button>		
											</div>	
										</div>	
									</div>	
								</div>
										
						<?php } else { // Coupons and Gift Card Itms 
							
								$Company_merchandise_item_id = $product['Company_merchandise_item_id'];													
								$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
								$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
							?>	
									<div class="col-md-3 ">
										<br>
											<div class="product" style="height:450px;">
												<div class="image">
													<a href="#">
														<img src="<?php echo $product['Thumbnail_image1']; ?>" alt=""  style="height:150px;">
													</a>
												</div>
													
												<div class="text">
													<h5 style="line-height: 1.5em; height: 3em;       
														overflow: hidden;"><a href="#"> <?php echo $product['Merchandize_item_name']; ?> </a> </h5>
														<p class="price"><?php  
														if($product['Size_flag'] == 1) 
														{ 
															$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
															$Billing_price_in_points = $Get_item_price->Billing_price_in_points;
															echo $Get_item_price->Billing_price_in_points.' '.$Company_Details->Currency_name;
															$Item_size=$Get_item_price->Item_size;
														} 
														else 
														{
															$Item_size="0";
															$Billing_price_in_points = $product['Billing_price_in_points'];
															
															$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
	
															// echo $product['Billing_price_in_points'].' '.$Company_Details->Currency_name;
															
															if($Billing_price_in_points != $Billing_price_in_points_tier)
															{
																$Billing_price_in_points = $Billing_price_in_points_tier;
																
																echo "<del>".$product['Billing_price_in_points'].' '.$Company_Details->Currency_name."</del><br>";
																echo $Billing_price_in_points.' '.$Company_Details->Currency_name;
															}
															else
															{
																echo $product['Billing_price_in_points'].' '.$Company_Details->Currency_name;
															}
														}
														?></p>
												<?php 
													
												if($product['Delivery_method']==0) { ?>	
																											
												
													 <?php foreach ($Branches as $Branches3){
															$Branch_code=$Branches3['Branch_code'];
															$Branch_name= $Branches3['Branch_name']; 
														 } ?>
														<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $Branch_code; ?>" style="margin:-3%;" checked>
														<input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);" checked style="margin:-3%; display: none;">
														
												<?php } elseif($product['Delivery_method']==28) { 
												
													/* echo"---Merchandize_item_type-----".$product['Merchandize_item_type']."----<br>";
													echo"---Delivery_method-----".$product['Delivery_method']."----<br>"; */
												
												?>
													
													
													
													<?php foreach ($Branches as $Branches4){
														$Branch_code4=$Branches4['Branch_code'];
														$Branch_name4= $Branches4['Branch_name']; 
													 } ?>
													
														<input type="radio" value="28"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" checked style="display: none;">
														<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $Branch_code4; ?>" checked>													
													
													
												<?php } else { 
												?>
												
														
												
													
													 <?php foreach ($Branches as $Branches3){
														$Branch_code=$Branches3['Branch_code'];
														$Branch_name= $Branches3['Branch_name']; 
													 } ?>
													 <input type="radio" value="28"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" checked style="display: none;">
													<input type="hidden" name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo  $Branch_code; ?>">
												
												<?php } ?>
												
												
												
													<div class="text">
															<button type="submit" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Delivery_method']; ?>',location_<?php echo $product['Company_merchandise_item_id']; ?>.value,'<?php echo $product['Merchandize_item_name']; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $product['Company_merchandise_item_id']; ?>,<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>);get_item_list();">
																<i class="fa fa-shopping-cart"></i> <?php echo ('Add to cart'); ?>
															</button>		
													</div>	
												</div>	
													
													
											</div>	
									</div>	
									
						
						<?php } ?>		
										
										
										
										
					<?php
					}
				}
				?>	
			</div>
		</div>				
				
		<div class="box-footer" style="padding:0px;margin-top:0px;background: #fff;border-top:none">
			<div class="row" style="margin-right:0px; margin-left:0px;">
				<div class="col-md-6 col-xs-6">
					<?php echo $pagination; ?>
				</div>
				<div class="col-md-6 col-xs-6" align="right">
					<button type="submit" class="btn btn-primary pagination" name="submit"   id="submit2"  onclick="Proceed_catalogue()" style="margin-left: auto;margin-right: auto;"><?php echo ('Checkout'); ?>&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
				</div>
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
<!-------------------------------Filter--------------------------------->
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<!--<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/icheck.min.js"></script>-->
<!-------------------------------Filter--------------------------------->
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
<!------------------------------------New Filter---------------------------------------------->
<aside class="control-sidebar control-sidebar-dark" style="background: #05083b;">
<section class="sidebar">
    <div class="pad">
        <div class="panel panel-default sidebar-menu" style="background: transparent none repeat scroll 0% 0%; border: medium none;">
            <div class="panel-body">
                <!--<ul class="nav nav-pills nav-stacked category-menu">-->
                <ul class="sidebar-menu2">
                   <li>
                        <a href="#" data-toggle="control-sidebar" class="text-right filter_header" style="color: #fff;"><i class="fa fa-remove"></i></a>
                    </li>                  
                    <li class="treeview" style="line-height:0px;">
                        <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><?php echo ($Company_Details->Currency_name); ?></a>
                        <ul>
                            <li>
                                <input id="range_1" type="text" name="range_1">
                            </li>
                            <li>&nbsp;</li>
                        </ul>
                    </li>
                   <!-- <li><hr></li> --><!--id="sortby"-->
                    <li class="treeview" onclick="hide_sort_by();" style="line-height:0px;" >
                        <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-usd"></span> <?php echo ('Sort by '.$Company_Details->Currency_name); ?></a>
					<div id="sortby_point" style="display:none">
                        <ul>
                            <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" value="1" class="flat-red Sort_radio" id="Sort_radio_1" name="Sort_by" <?php if($Sort_by==1){echo "checked=checked";}?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                        <?php echo ($Company_Details->Currency_name.':Low-High'); ?>
                                    </label>									
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" value="2" class="flat-red Sort_radio" id="Sort_radio_2" name="Sort_by" <?php if($Sort_by==2){echo "checked=checked";}?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                        <?php echo ($Company_Details->Currency_name.':High-Low'); ?>
                                    </label>
                                </div>
                            </li>                         
                            <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" value="3" class="flat-red Sort_radio" id="Sort_radio_3" name="Sort_by" <?php if($Sort_by==3){echo "checked=checked";}?> onclick="Sort_by_points(this.value);">&nbsp;&nbsp;
                                        <?php echo ('Recently Added'); ?>
                                    </label>
                                </div>
                            </li>
                        </ul>
					</div>
                    </li>
					<!--<li><hr></li>
                    <li class="treeview" onclick="hide_merchant();" style="line-height:0px;">
                        <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-user"></span> <?php echo ('Merchants'); ?></a>
                    <div id="sortby_merchant" style="display:none">
                        <?php if($Sellers != NULL) { ?>

                        <ul <?php if( count($Sellers) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?> >
                            
                            <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" name="Sort_merchent" id="Sort_merchent" class="flat-red" value="0" <?php if($Merchant_filter == 0){echo "checked=checked";}?> onclick="Sort_by_merchants(this.value);">&nbsp;&nbsp;
                                        <?php echo ('All'); ?>
                                    </label>
                                </div>
                            </li>
                           
                            <?php foreach ($Sellers as $Sellers) { ?>							
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;"> 
										<input type="radio" name="Sort_merchent" id="Sort_merchent<?php echo $Sellers['Enrollement_id']; ?>" class="flat-red" value="<?php echo $Sellers['Enrollement_id']; ?>" <?php if($Merchant_filter == $Sellers['Enrollement_id']){echo "checked=checked";}?> onclick="Sort_by_merchants(this.value);">&nbsp;&nbsp;
										<?php echo $Sellers['First_name'].' '.$Sellers['Last_name']; ?>
									</label>
								</div>
							</li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
					</div>
                    </li> 
                    <?php 
							
						//if( count($Merchandize_item_type) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } 
							//echo "---Merchandize_item_type---1----".$Merchandize_item_type->Merchandize_item_type."---<br>";
							//echo "---Merchandize_item_type---2----".$_REQUEST["Merchandize_item_type"]."---<br>";
							//echo "---Sort_by_item_type---3----".$_REQUEST["Sort_by_item_type"]."---<br>";
					?>
						 
					<!--------------------------Sort by Item Type----------------------------
					<li class="treeview" onclick="hide_sort_Item_Type();" style="line-height:0px;">
					<a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-th-list"> </span>
					<?php echo ('Item Type');?></a>
					<div id="sortby_item_type" style="display:none">								
                        <ul>
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="M_item_type" id="M_item_type<?php $Merchandize_item_type->Merchandize_item_type;  ?>" class="flat-red" value="0" <?php if($_REQUEST["Sort_by_item_type"]==0){echo "checked=checked";}?> onclick="Sort_by_item_type(this.value);">&nbsp;&nbsp;
										<?php echo ('All'); ?>
										
									</label>
									
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="M_item_type" id="M_item_type<?php echo $Merchandize_item_type->Merchandize_item_type; ?>" class="flat-red" value="41" <?php if($_REQUEST["Sort_by_item_type"]==41){echo "checked=checked";}?> onclick="Sort_by_item_type(this.value);">&nbsp;&nbsp;
										<?php echo ('Air Miles'); ?>
									</label>
								</div>
							</li>		
							<li>		
								 <div class="form-group">	
									<label style="text-transform: capitalize;">
										<input type="radio" name="M_item_type" id="M_item_type<?php echo $Merchandize_item_type->Merchandize_item_type;  ?>" class="flat-red" value="42" <?php if($_REQUEST["Sort_by_item_type"]==42){echo "checked=checked";}?> onclick="Sort_by_item_type(this.value);">&nbsp;&nbsp;
										<?php echo ('Recharge Coupons'); ?>
										
									</label>
								</div>
							</li>
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="M_item_type" id="M_item_type<?php $Merchandize_item_type->Merchandize_item_type;  ?>" class="flat-red" value="43" <?php if($_REQUEST["Sort_by_item_type"]==43){echo "checked=checked";}?> onclick="Sort_by_item_type(this.value);">&nbsp;&nbsp;
										<?php echo ('Events Vouchers'); ?>
										
									</label>
									
                                </div>
                            </li>
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="M_item_type" id="M_item_type<?php $Merchandize_item_type->Merchandize_item_type;  ?>" class="flat-red" value="269" <?php if($_REQUEST["Sort_by_item_type"]==269){echo "checked=checked";}?> onclick="Sort_by_item_type(this.value);">&nbsp;&nbsp;
										<?php echo ('Training Vouchers'); ?>
										
									</label>
									
                                </div>
                            </li>							
                        </ul>
					</div>
                    </li>
					<!--<li><hr></li>-->
					<!--------------------------Sort by Item Type----------------------------->                  
                    <li onclick="hide_catagory();" style="line-height:0px;">
                        <a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"> <span class="glyphicon glyphicon-th-list"></span> <?php echo ('Categories'); ?></a>
                      
					  <div id="sortby_category" style="display:none">
					  
                        <?php if($Merchandize_category != NULL) { ?>

                        <ul <?php if( count($Merchandize_category) > 4 ) { echo 'style="height: 280px; overflow: auto;"'; } ?> >
                            
                            <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" name="Sort_cat" id="Sort_cat" class="flat-red" value="0" <?php if($Category_filter == 0){echo "checked=checked";}?> onclick="Sort_by_category(this.value);">&nbsp;&nbsp;
                                        <?php echo ('All'); ?>
                                    </label>
                                </div>
                            </li>
                            
                            <?php foreach ($Merchandize_category as $MerchandizeCat1) { ?>
							
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="Sort_cat" id="Sort_cat<?php echo $MerchandizeCat1->Merchandize_category_id; ?>" class="flat-red" value="<?php echo $MerchandizeCat1->Merchandize_category_id; ?>" <?php if($Category_filter == $MerchandizeCat1->Merchandize_category_id){echo "checked=checked";}?> onclick="Sort_by_category(this.value);">&nbsp;&nbsp;
										<?php echo $MerchandizeCat1->Merchandize_category_name; ?>
									</label>
								</div>
							</li>
                            <?php } ?>
                        </ul>

                        <?php } ?>
					  </div>
                    </li> 
					<!--<li><hr></li>-->
					<?php if($Item_brand != NULL) { ?>
					<li class="treeview" onclick="hide_sort_brand();" style="line-height:0px;">
					<a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-heart"></span> <?php echo ('Brand'); ?></a>
					<div id="sortby_brand" style="display:none">
                        <ul <?php if( count($Item_brand) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?>>
						 <li>
                                <div class="form-group">
                                    <label style="text-transform: capitalize;">
                                        <input type="radio" name="Sort_brand" id="Sort_brand" class="flat-red" value="0" <?php if($brand_filter == 0){echo "checked=checked";}?> onclick="Sort_by_brand(this.value);">&nbsp;&nbsp;
                                        <?php echo ('All'); ?>
                                    </label>
                                </div>
                            </li>
						<?php foreach($Item_brand as $brand) { ?>
                            <li>
                                <div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="Sort_brand" id="Sort_brand<?php echo $brand->Item_Brand; ?>" class="flat-red" value="<?php echo $brand->Item_Brand; ?>" <?php if($brand_filter == $brand->Item_Brand){echo "checked=checked";}?> onclick="Sort_by_brand(this.value);">&nbsp;&nbsp;
										<?php echo $brand->Item_Brand; ?>
									</label>
                                </div>
                            </li>
							<?php } ?>
                        </ul>
					</div>
                    </li>
					<?php } ?>
					<!--<li><hr></li>--> 
					<!--------------------------Sort by Gender_flag----------------------------
					<li class="treeview" onclick="hide_sort_gender();" style="line-height:0px;">
					<a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-user"> </span>
					<?php echo ('Gender');?></a>
					<div id="sortby_gender" style="display:none">
					
                        <ul <?php if( count($Gender_flag) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?>>
						 
						
                            <li>
                                <div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="0" <?php if($_REQUEST["Sort_by_gender_flag"]==0){echo "checked=checked";}?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;
										<?php echo ('Both'); ?>
									</label>
								</div>
							</li>		
							<li>		
								 <div class="form-group">	
									<label style="text-transform: capitalize;">
										<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="1" <?php if($_REQUEST["Sort_by_gender_flag"]==1){echo "checked=checked";}?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;
										<?php echo ('Men'); ?>
										
									</label>
								</div>
							</li>
							<li>
								<div class="form-group">
									<label style="text-transform: capitalize;">
										<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="2" <?php if($_REQUEST["Sort_by_gender_flag"]==2){echo "checked=checked";}?> onclick="Sort_by_gender(this.value);">&nbsp;&nbsp;
										<?php echo ('Women'); ?>
										
									</label>
									
                                </div>
                            </li>
							
							
                        </ul>
					</div>
                    </li>
					<!--<li><hr></li>-->
					<!--------------------------Sort by Gender----------------------------->
					
					
                </ul>
            </div>
        </div>
    </div>
	</section>
</aside>
<div class="control-sidebar-bg" style="background: #05083b;"></div>
<input type="hidden" id="SelectedCat" />
<input type="hidden" id="SelectedSort" />
<input type="hidden" id="TriggerItem" />
<input type="hidden" id="track_page" value="1" />
<input type="hidden" id="numitems" value="<?php //echo $nextpage; ?>" />
<!--------------------------------------New Filter---------------------------------------------->
<script type="text/javascript" charset="utf-8">
<?php
		//ShowPopup('Insufficient Current Balalnce !!');
		if($Redemption_Items == NULL)
		{ ?>
				ShowPopup('<?php echo ('Items Not Found !!!'); ?>');
<?php 	}
		?>
$('#submit2').click(function()
{
	// var Total_Redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
	var Total_Redeem_points=document.getElementById("Total_Redeem_points").value;
	if(Total_Redeem_points!= "")
	{
		show_loader();
	}
});

function add_to_cart(Company_merchandize_item_code,Delivery_method,location,Merchandize_item_name,Points,Item_size,Company_merchandise_item_id,Item_Weight,Weight_unit_id)
{
		var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
		if(Checked_Delivery_method==29)
		{
			location=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		} 
				
		if(location=="" && Checked_Delivery_method==28)//Pick up
		{
			// ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
			ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
		}
		else
		{
			var Total_balance = <?php echo $Current_point_balance;?>;
		
			// var Current_redeem_points=document.getElementById("Total_Redeem_points12").innerHTML;
			var Current_redeem_points=<?php echo $Total_Redeem_points; ?>;
			
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
							setTimeout('location.reload(true)', 5000);
						}
					}
					else
					{
						ShowPopup('Error adding Item '+Merchandize_item_name+' to Cart. Please try again..!!');
						$('.shoppingCart_total').html('$'+data.cart_total);
						setTimeout('location.reload(true)', 5000);
					}
				}
			});
			}
		}	
		
}
function Proceed_catalogue()
{
	// var Total_Redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
	var Total_Redeem_points=document.getElementById("Total_Redeem_points").value; 
	if(Total_Redeem_points=="")
	{
		ShowPopup("<?php echo ('Add to Cart atleast one Merchandize Item !!!'); ?>");
	}
	else
	{
		window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue/?Total_Redeem_points='+encodeURIComponent(Total_Redeem_points);
	}
}
function Sort_by_category(Merchandize_category)
{
	document.getElementById("loadingDiv").style.display="";
	var filter=0;
	var merchant=0;
	var brand =0;
	var gender =0;
	
	<?php
		if(isset($_REQUEST["Sort_by_points_flag"]))
		{ ?>
			var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_merchant_flag"]))
		{ ?>
			var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_brand_flag"]))
		{ ?>
			var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_gender_flag"]))
		{ ?>
			var gender='<?php echo $_REQUEST["Sort_by_gender_flag"];?>';
		<?php }
	?>
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender;
}	
function Sort_by_points(filter)
{
	document.getElementById("loadingDiv").style.display="";
	var Merchandize_category=0;
	var merchant=0;
	var brand=0;
	var gender=0;
	<?php
		if(isset($_REQUEST["Sort_by_category_flag"]))
		{?>
			var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_merchant_flag"]))
		{ ?>
			var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_brand_flag"]))
		{ ?>
			var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
	<?php } ?>
	<?php
		if(isset($_REQUEST["Sort_by_gender_flag"]))
		{ ?>
			var gender='<?php echo $_REQUEST["Sort_by_gender_flag"];?>';
		<?php }
	?>
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender;
}
function Sort_by_merchants(merchant)
{
	document.getElementById("loadingDiv").style.display="";
	var Merchandize_category=0;
	var filter=0;
	var brand=0;	
	var gender=0;	
	<?php
		if(isset($_REQUEST["Sort_by_category_flag"]))
		{?>
			var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_points_flag"]))
		{ ?>
			var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_brand_flag"]))
		{ ?>
			var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
	<?php } ?>
	<?php
		if(isset($_REQUEST["Sort_by_gender_flag"]))
		{ ?>
			var gender='<?php echo $_REQUEST["Sort_by_gender_flag"];?>';
		<?php }
	?>
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender;
}
function Sort_by_brand(brand)
{
	document.getElementById("loadingDiv").style.display="";
	var Merchandize_category=0;
	var filter=0;
	var merchant =0;
	var gender =0;
	<?php
		if(isset($_REQUEST["Sort_by_category_flag"]))
		{?>
			var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_points_flag"]))
		{ ?>
			var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_merchant_flag"]))
		{ ?>
			var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
	<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_gender_flag"]))
		{ ?>
			var gender='<?php echo $_REQUEST["Sort_by_gender_flag"];?>';
		<?php }
	?>
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender;
}
function Sort_by_gender(gender)
{
	document.getElementById("loadingDiv").style.display="";
	var Merchandize_category=0;
	var filter=0;
	var merchant =0;
	var brand =0;
	<?php
		if(isset($_REQUEST["Sort_by_category_flag"]))
		{?>
			var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_points_flag"]))
		{ ?>
			var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_merchant_flag"]))
		{ ?>
			var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
	<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_brand_flag"]))
		{ ?>
			var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
	<?php } ?>
	
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender; 
}
function Sort_by_item_type(item_type)
{
	document.getElementById("loadingDiv").style.display="";
	var Merchandize_category=0;
	var filter=0;
	var merchant =0;
	var brand =0;
	var gender =0;
	//var item_type =0;
	<?php
		if(isset($_REQUEST["Sort_by_category_flag"]))
		{?>
			var Merchandize_category='<?php echo $_REQUEST["Sort_by_category_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_points_flag"]))
		{ ?>
			var filter='<?php echo $_REQUEST["Sort_by_points_flag"];?>';
		<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_merchant_flag"]))
		{ ?>
			var merchant='<?php echo $_REQUEST["Sort_by_merchant_flag"];?>';
	<?php }
	?>
	<?php
		if(isset($_REQUEST["Sort_by_brand_flag"]))
		{ ?>
			var brand='<?php echo $_REQUEST["Sort_by_brand_flag"];?>';
	<?php } ?>
	<?php
		if(isset($_REQUEST["Sort_by_gender_flag"]))
		{ ?>
			var gender='<?php echo $_REQUEST["Sort_by_gender_flag"];?>';
		<?php }
	?>
	
	window.location='<?php echo base_url()?>index.php/Redemption_Catalogue/?Sort_by_points_flag='+filter+'&Sort_by_category_flag='+Merchandize_category+'&Sort_by_merchant_flag='+merchant+'&Sort_by_brand_flag='+brand+'&Sort_by_gender_flag='+gender+'&Sort_by_item_type='+item_type; 
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
	$('#popup_info').css('position','fixed');
	$('#popup_info').css('z-index','1');
	$('#popup_info').css('right','0');
	$('#popup_info').css('top','auto');
	$('#popup_info').css('bottom','50%');
	// $('#popup_info').css('background-color','#31859C !IMPORTANT');
	//$('#popup_info2').html(x);
	//$('#popup_info3').html(x);
	//$('#popup3').show();
	//$('#popup2').show();
	$('#popup').show();
	setTimeout('HidePopup()', 9000);
}
function HidePopup()
{
	$('#popup').hide();
	//$('#popup2').hide();
	//$('#popup3').hide();
}
<!---------------------------------- New filter-------------------------------->
function hide_sort_by()
{
	//$("#sortby_point").show();
	var x = document.getElementById('sortby_point');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }
}
function hide_merchant()
{
	//$("#sortby_merchant").show();
	var x = document.getElementById('sortby_merchant');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }
}
function hide_catagory()
{
	//$("#sortby_category").show();
	var x = document.getElementById('sortby_category');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }	
}
function hide_sort_size()
{
	//$("#sortby_category").show();
	var x = document.getElementById('sortby_size');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }	
}
function hide_sort_brand()
{
	//$("#sortby_category").show();
	var x = document.getElementById('sortby_brand');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }	
}
function hide_sort_gender()
{
	//$("#sortby_category").show();
	var x = document.getElementById('sortby_gender');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }	
}
function hide_sort_Item_Type()
{
	//$("#sortby_category").show();
	var x = document.getElementById('sortby_item_type');
    if (x.style.display === 'none') 
	{
        x.style.display = 'block';
    } 
	else 
	{
        x.style.display = 'none';
    }	
}

$( document ).ready(function() 
{
    var numitems = '<?php echo $numitems; ?>';
    var count4 = '<?php echo $count4; ?>';
   
    if(numitems > count4)
    {
        $('#LoadMoreDiv').show();
        //var nextpage = 2;
        //$('#numitems').val(nextpage);
    }
});

$(function () 
{ 
    $('.slider').slider();

	$("#range_1").ionRangeSlider(
	{
		
			min: '<?php echo round($Min_price->Billing_price_in_points); ?>',
            max: '<?php echo round($Max_price->Billing_price_in_points); ?>',
            from: '<?php echo round($Min_price->Billing_price_in_points); ?>',
            to: '<?php echo round($Min_price->Billing_price_in_points); ?>',
	
            type: 'double',
            //step: 20,
            prefix: "",
            prettify: false,
            hasGrid: false,
 
            onFinish: function (data)
            {
                var from = data.fromNumber;
                var to = data.toNumber;
				var SelectedSort = $('#SelectedSort').val();
                var SelectedCat = $('#SelectedCat').val();
                filter_result(SelectedSort,SelectedCat,from,to);
            }
	});
	
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck(
        {
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
	});
        
       /* $('#Sort_radio_1').on('ifChecked', function(event)
        {
            var slider = $("#range_1").val().split(";");
            var PriceFrom = slider[0];
            var PriceTo = slider[1];
			var Sort_radio_1 = $('#Sort_radio_1').val();
            $('#SelectedSort').val(Sort_radio_1);
            var SelectedCat = $('#SelectedCat').val();
            filter_result(Sort_radio_1,SelectedCat,PriceFrom,PriceTo);
        });
        
        $('#Sort_radio_2').on('ifChecked', function(event)
        {
            var slider = $("#range_1").val().split(";");
            var PriceFrom = slider[0];
            var PriceTo = slider[1];
            
            var Sort_radio_2 = $('#Sort_radio_2').val();
            $('#SelectedSort').val(Sort_radio_2);
            
            var SelectedCat = $('#SelectedCat').val();
            filter_result(Sort_radio_2,SelectedCat,PriceFrom,PriceTo);
        });
        
        $('#Sort_radio_3').on('ifChecked', function(event)
        {
            var slider = $("#range_1").val().split(";");
            var PriceFrom = slider[0];
            var PriceTo = slider[1];
            var Sort_radio_3 = $('#Sort_radio_3').val();
            $('#SelectedSort').val(Sort_radio_3);
            var SelectedCat = $('#SelectedCat').val();
            filter_result(Sort_radio_3,SelectedCat,PriceFrom,PriceTo);
        });
        
        $('#Sort_cat_0').on('ifChecked', function(event)
        {
            var slider = $("#range_1").val().split(";");
            var PriceFrom = slider[0];
            var PriceTo = slider[1];
            var Sort_cat_0 = $('#Sort_cat_0').val();
            var SelectedSort = $('#SelectedSort').val();
            filter_result(SelectedSort,Sort_cat_0,PriceFrom,PriceTo);
        });
        <?php $MerchandizeCatId= 10; ?>
        var MerchandizeCatId = <?php echo $MerchandizeCatId; ?>;
        MerchandizeCatId.forEach(array_loop);*/
});

function array_loop(item, index)
{

    $('#Sort_cat_'+item).on('ifChecked', function(event)
    {
        var slider = $("#range_1").val().split(";");
        var PriceFrom = slider[0];
        var PriceTo = slider[1];
            
        var Sort_cat = $('#Sort_cat_'+item).val();
        $('#SelectedCat').val(Sort_cat);
        
        var SelectedSort = $('#SelectedSort').val();
        filter_result(SelectedSort,Sort_cat,PriceFrom,PriceTo);
    });
}

function filter_result(Sort_by,Sort_category,PriceFrom,PriceTo)
{

    //var track_page = $('#track_page').val();
    var track_page = '1'; //$('#numitems').val();
    var Company_id = '<?php echo $Company_id; ?>';
    $.ajax(
    {
        type: "POST",
        data: { page:track_page, Sort_by:Sort_by, Company_id:Company_id, Sort_category:Sort_category, PriceFrom:PriceFrom, PriceTo:PriceTo },
        url: "<?php echo base_url()?>index.php/Redemption_Catalogue/filter_result",
        success: function(data)
        {
            //$("#FilterResult").replaceWith(data.filtered_result);
            $("#FilterResult").html(data.filtered_result);
            
            /*if(data.filtered_result == '')
            {
                //$("#load_more_button").text("You have reached end of the record!").prop("disabled", true);
                $("#load_more_button").hide();
            }
            else
            {
                if (data.currentpage < data.totalpages)
                {
                    var nextpage2 = data.currentpage + 1;
                    $('#numitems').val(nextpage2);
                }
                else if(data.currentpage == data.totalpages)
                {
                    $("#load_more_button").hide();
                }
                else
                {
                    if (data.currentpage == 1)
                    {
                        $("#load_more_button").hide();
                    }
                }
            
                $("#FilterResult").html(data.filtered_result);

                $("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 800);

                $('.animation_image').hide();
            }*/
        }
    });
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
<!----------------------------------New filter-------------------------------->
</script>
<style>
.navbar-custom-menu{
    margin-left: 75% !IMPORTANT;
}
#popup_info{
    color: #fff !IMPORTANT;
    background-color: #fd1090 !IMPORTANT;
    border-color: #fd1090 !IMPORTANT;
}
</style>