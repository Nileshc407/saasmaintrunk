<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
// $this->load->view('header/header');
$this->load->view('front/header/header'); 
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
		<?php /* ?>	<div class="col-md-3 col-xs-3"> 
			<button type="button" class="btn btn-info btn-lg" data-toggle="control-sidebar" data-placement="top" title="Filter" style="margin-top:10px;background: #31859c none repeat scroll 0 0;border-color: #31859c; float: right;">
				<i class="fa fa-filter" aria-hidden="true"></i>
			</button>
		</div> <?php */ ?>		
	</div>
</section>		
		<div class="col-md-4 ">
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
		<div class="row">		
		</div>
<!-- Main content -->
<section class="content">
	<div class="row">	
		<div class="col-md-6 col-md-offset-3" id="popup" style="display:none;">
			<div class="alert alert-success text-center" role="alert" id="popup_info" style="background-color:#31859C !IMPORTANT"></div>
		</div>
	</div>
	<div id="content">
		
			 <!--<div class="row products">-->
			 <div class="row products cd-container" id="FilterResult">
				<?php
				//print_r($Redemption_Items_branches);echo "<br><br>";	

				function string_decrypt($encrypted_string, $key, $iv)
				{
						
								
						// echo "-------encrypted_string----".$encrypted_string."---------------<br>";
						// echo "-------key----".$key."---------------<br>";
						// echo "-------iv----".$iv."---------------<br>"; 

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


				if($voucher_result != NULL)
				{
					// $i;
					foreach($voucher_result as $key => $value)
					{				
						if(is_array($value)){
							
							foreach($value as $key1 => $value1) {
								
								
								// echo"--max_price---".$value[0]['max_price']."--<br>";
						?>
						
						
							
						
					
						
										<div class="col-md-3 ">
										<br>
											<div class="product" style="height:450px;">
												<div class="image">
													<a href="JavaScript:void(0);">
														<img src="<?php echo $value1['product_image']; ?>" alt=""  style="height:150px;">
													</a>
													<br>
													<br>
													<p><?php echo $value1['product_name']; ?></p>
													<p>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_DS_<?php echo $value1['product_id'];?>">| Description |</a>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_TC_<?php echo $value1['product_id'];?>"> T & C |</a>
													
													<?php if($value1['product_how_to_use']) { ?>
													<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_HTU_<?php echo $value1['product_id'];?>"> How to Use |</a>
													<?php } ?>
													
														<!-- Modal DS -->
															<div id="myModal_DS_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
															  <div class="modal-dialog">

																<!-- Modal content-->
																<div class="modal-content">
																  <div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Description</h4>
																  </div>
																  <div class="modal-body text-left">
																	<p><?php echo html_entity_decode($value1['product_description']); ?></p>
																  </div>
																  <div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																  </div>
																</div>

															  </div>
															</div>
														<!-- Modal TC -->	
														<div id="myModal_TC_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
																<div class="modal-dialog">

																	<!-- Modal content-->
																	<div class="modal-content">
																	  <div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Description</h4>
																	  </div>
																	  <div class="modal-body text-left">
																		<p><?php echo html_entity_decode($value1['product_terms_conditions']); ?></p>
																	  </div>
																	  <div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	  </div>
																	</div>
																</div>
														</div>
														<?php if($value1['product_how_to_use']) { ?>
														<!-- Modal myModal_HTU_ -->
														<div id="myModal_HTU_<?php echo $value1['product_id'];?>" class="modal fade" role="dialog">
															<div class="modal-dialog">

																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Description</h4>
																	</div>
																	<div class="modal-body text-left">
																		<p><?php echo html_entity_decode($value1['product_how_to_use']); ?></p>
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
															$smallest_price= min($value1['product_denminations']); 
															
															/* echo $Company_Details->Redemptionratio; 
															echo $Company_Details->Currency_name; */ 
														?>
														<select class="form-control" name="Price_value_<?php echo $value1['product_id'];?>" id="Price_value_<?php echo $value1['product_id'];?>" required onchange="Change_price(this.value,<?php echo $value1['product_id'];?>);">
															<option value="<?php echo $smallest_price; ?>"><?php echo $value1['currency_code']." ".$smallest_price; ?></option>		
															<?php 
															// print_r($value1['product_denminations']);
															foreach($value1['product_denminations'] as $key_price => $price_value){
															?>
															<option value="<?php echo $price_value; ?>"><?php echo $value1['currency_code']." ".$price_value; ?></option>	
															<?php
																	// echo"---price_value----".$price_value."---<br>";
															}
															?>
																												
														</select>
													<br>
													<p class="text-center">

														<div class="qty mt-5">
															
															<button type="submit" class="btn btn-template-main" onclick="RemoveQty(<?php echo $value1['product_id'];?>);" >
																<span class="minus bg-dark">-</span>
															</button>
															
																<input type="text" class="count form-control text-center" name="qty_<?php echo $value1['product_id'];?>" id="qty_<?php echo $value1['product_id'];?>" value="1" readonly style="width:110px;display:inline">
																
															<button type="submit" class="btn btn-template-main" onclick="AddQty(<?php echo $value1['product_id'];?>);">
																<span class="plus bg-dark">+</span>
															</button>
															
														</div>
													</p>
													<p class="text-center">
														Equivalent <?php echo $Company_Details->Currency_name; ?> : <b id="new_changed_points_<?php echo $value1['product_id'];?>"><?php echo ($smallest_price * $Company_Details->Redemptionratio); ?></b> 
														<input type="hidden" name="Billing_price_in_points_<?php echo $value1['product_id'];?>" id="Billing_price_in_points_<?php echo $value1['product_id'];?>" value="<?php echo ($smallest_price * $Company_Details->Redemptionratio); ?>" >
													</p>
													
													
														
														
												</div>
													
												<div class="text">
													<h5>
															<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id="> </a> </h5>
														<p class="price"></p>												
														<div class="text">
															<input type="hidden" name="Company_merchandize_item_code_<?php echo $value1['product_id'];?>" value="XOXODAY<?php echo $value1['product_id'];?>">
														
															
															<input type="hidden" name="Delivery_method" value="28">
															
															<?php 
															
															foreach ($Redemption_Items as $product)
															{
																
																$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];															
															
																	foreach ($Branches as $Branches3){
																		
																	$Branch_code=$Branches3['Branch_code'];
																	$Branch_name= $Branches3['Branch_name']; 
																 }
															}
															?>
															<input type="hidden" name="location" id="location" value="<?php echo $Branch_code; ?>">
															<input type="hidden" name="Item_size"  id="Item_size" value="0">
															<input type="hidden" name="Item_Weight" id="Item_Weight" value="0">
															<input type="hidden" name="Weight_unit_id" id="Weight_unit_id" value="0">
															
															<button type="submit" class="btn btn-template-main" onclick="Redeem_done('<?php echo $value1['product_image'];?>','<?php echo $value1['product_name'];?>','XOXODAY<?php echo $value1['product_id'];?>',28,'<?php echo $product['Merchandize_item_name']; ?>',<?php echo $value1['product_id'];?>);get_item_list();" style="margin-left: -6px;">
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
				}
				?>	
			</div>
		</div>
			
			
								
				<?php /* ?>	
				<div class="box-footer" style="padding:0px;margin-top:0px;background: #fff;border-top:none">
					<div class="row" style="margin-right:0px; margin-left:0px;">
						<div class="col-md-6 col-xs-6">
							<?php //echo $pagination; ?>
						</div>
						<div class="col-md-6 col-xs-6" align="right">
							<button type="submit" class="btn btn-default pagination" name="submit"   id="submit2"  onclick="Proceed_catalogue()" style="margin-left: auto;margin-right: auto;"><?php echo ('Checkout'); ?>&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
						</div>
					</div>
					
				</div>
				<?php */ ?>				
				
				
				
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
<script>				
		function AddQty(pId){
			
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			var newQty= parseInt(current_qty) + parseInt(1);
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
		
		
			// alert(current_qty);
			
		}
		function RemoveQty(pId){
			
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var Price_value= document.getElementById('Price_value_'+pId).value;
			var current_qty= document.getElementById('qty_'+pId).value;
			
			var newQty= parseInt(current_qty) - parseInt(1);
			if(newQty < 1){
				newQty=1;
			}			
			document.getElementById('qty_'+pId).value=newQty;
			
			
			var Price_value1=parseInt(Price_value*newQty);
			
			var New_points = parseInt(Redemptionratio*Price_value1);
			//alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;
			
		}
		
		function Change_price(price,pId){
		
			var Redemptionratio = <?php echo $Company_Details->Redemptionratio; ?>;
			var current_qty= document.getElementById('qty_'+pId).value;
			var Price_value1=parseInt(price*current_qty);			
			var New_points = parseInt(Redemptionratio*Price_value1);
			// alert("---pId---"+pId+"---price----"+price+"--New_points--"+New_points);		
			document.getElementById("new_changed_points_"+pId).innerHTML=New_points;		
			document.getElementById("Billing_price_in_points_"+pId).value=New_points;		
		
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
<!------------------------------------New Filter---------------------------------------------->
<aside class="control-sidebar control-sidebar-dark">
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
					<!--<li><hr></li>-->
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
						 
					<!--------------------------Sort by Item Type----------------------------->
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
										<?php echo ('Gift Card'); ?>
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
										<?php echo ('Catalogue'); ?>
										
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

                        <ul <?php if( count($Merchandize_category) > 4 ) { echo 'style="height: 180px; overflow: auto;"'; } ?> >
                            
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
					<li class="treeview" onclick="hide_sort_brand();" style="line-height:0px;">
					<a href="javascript:void(0);" class="filter_header" style="color: #b8c7ce; text-transform: capitalize;"><span class="glyphicon glyphicon-heart"></span> <?php echo ('Brand'); ?></a>
					<div id="sortby_brand" style="display:none">
					<?php if($Item_brand != NULL) { ?>
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
							<?php } 
								}?>
                        </ul>
					</div>
                    </li>
					<!--<li><hr></li>--> 
					<!--------------------------Sort by Gender_flag----------------------------->
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
<div class="control-sidebar-bg"></div>
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

function Redeem_done(product_image,product_name,Company_merchandize_item_code,Delivery_method,Merchandize_item_name,pId){
	
	var location=document.getElementById("location").value;		
	var Billing_price_in_points=document.getElementById("Billing_price_in_points_"+pId).value;	
	var Item_size=document.getElementById("Item_size").value;	
	var Item_Weight=document.getElementById("Item_Weight").value;	
	var Weight_unit_id=document.getElementById("Weight_unit_id").value;	
	var Voucher_price=document.getElementById("Price_value_"+pId).value;	
	var qty=document.getElementById("qty_"+pId).value;	
	var Total_balance = <?php echo $Current_point_balance;?>;
	
	Voucher_price=parseInt(Voucher_price*qty);
	
	
	
		
		BootstrapDialog.confirm("Are you sure to Redeem "+product_name+" eVoucher?", function(result)
		{
			
			if (result == true)
			{
					document.getElementById("loadingDiv").style.display="";	
					if(Billing_price_in_points > Total_balance)
					{
						//alert('Insufficient Current Balance !!!');
						document.getElementById("loadingDiv").style.display="none";
						ShowPopup('<?php echo ('Insufficient Current Balance !!!'); ?>');
						return false;
					}
					else
						{	
					
							
						
							$.ajax({
							type: "POST",
							data: {pId:pId,product_image:product_image,product_name:product_name,Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Delivery_method, location:location, Points:Billing_price_in_points,Current_redeem_points:Billing_price_in_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Voucher_price:Voucher_price,qty:qty },
							url: "<?php echo base_url()?>index.php/Redemption_Catalogue/Redemption_done",
							success: function(data)
							{
								 //alert(data.cart_success_flag);		
								document.getElementById("loadingDiv").style.display="none";
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
										
										ShowPopup('<?php echo ('Vouchers Redeemed Successfuly !!!'); ?>');	
										
										setTimeout('location.reload()',
										
										1000);
									}
									
									
								}
								else
								{
									ShowPopup('Error Vouchers Redeeming '+Merchandize_item_name+' to Cart. Please try again..!!');
									
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
	
	// return false;
	/* alert(Company_merchandize_item_code);
	alert(Delivery_method);
	alert(branch);
	alert(Merchandize_item_name);
	alert(Billing_price_in_points);	
	alert(Item_size);
	alert(Item_Weight);
	alert(Weight_unit_id);
	alert(Voucher_price);
	alert(Total_balance); */	

// alert(Voucher_price);

	
	
}

function add_to_cart(Company_merchandize_item_code,Delivery_method,location,Merchandize_item_name,Points,Item_size,Company_merchandise_item_id,Item_Weight,Weight_unit_id)
{
		var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
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
		alert('Weight_unit_id: '+Weight_unit_id); 
		return false; */
		
				
		if(location=="" && Checked_Delivery_method==28)//Pick up
		{
			// ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
			ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
		}
		else
		{
			var Total_balance = <?php echo $Current_point_balance;?>;
			// var Current_redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
			var Current_redeem_points=document.getElementById("Total_Redeem_points12").innerHTML;
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
.product .text{
	padding: 5px !IMPORTANT;
}
.control-sidebar{
	     display: none !IMPORTANT;
}
</style>