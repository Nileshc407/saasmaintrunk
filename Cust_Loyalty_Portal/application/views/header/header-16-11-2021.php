<?php 

$session_data = $this->session->userdata('cust_logged_in');
$data['Company_id'] = $session_data['Company_id'];
$data['enroll'] = $session_data['enroll'];
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$ci_object->load->model('shopping/Shopping_model');
$Company_details = $ci_object->Igain_model->get_company_details($data['Company_id']);

$PromoCodeApply=$Company_details->Promo_code_applicable;
$AuctionBidApply=$Company_details->Auction_bidding_applicable;
$Ecommerce_flag=$Company_details->Ecommerce_flag;
$Buy_miles_flag=$Company_details->Buy_miles_flag;
$Transfer_accross_flag=$Company_details->Transfer_accross_flag;
$smartphone_flag = $session_data['smartphone_flag'];




$ci_object->load->library('cart');
$ci_object->load->library('Multicart/udp_cart');
$ci_object->wishlist = new Udp_cart("wishlist");
$Current_page = $_SERVER['REQUEST_URI'];

/*******************************AMIT REDEMPTION CATALOGUE***************************************/
error_reporting(0);
$ci_object->load->model('Redemption_Catalogue/Redemption_Model');
$Redeemtion_details = $ci_object->Redemption_Model->get_total_redeeem_points($data['enroll']);
$Total_Redeem_points=0;
//echo "dsfdsfdsf".count($Redeemtion_details);
if(count($Redeemtion_details)!=0)
{

	foreach($Redeemtion_details as $Redeemtion_details)
	{
		//echo "<br>".$Redeemtion_details["Points"];
		//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
		$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
	}
} 


//echo "dscfffffffffffff".$Total_Redeem_points;
$Redeemtion_details2 = $ci_object->Redemption_Model->get_total_redeeem_points($data['enroll']);
/************************************************************************************************/

/******************nilesh***********/
$this->load->model('shopping/Shopping_model');
$ci_object->load->library('cart');
$ci_object->load->library('Multicart/udp_cart');
$ci_object->wishlist = new Udp_cart("wishlist");
$Current_page = $_SERVER['REQUEST_URI'];
/*
 */
/****Login Masking*************************/
$_SESSION['Login_masking']=1;
// $_SESSION['current_url']=base_url().'index.php/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
$_SESSION['current_url'] =$_SERVER[REQUEST_URI];
// echo $_SESSION['current_url'];
/****Login Masking*********XXX****************/

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}



		function string_encrypt($string, $key, $iv)
		{			
				$version = phpversion();
					//echo "-------version----".$version."---------------<br>";
					$new_version=  substr($version, 0, 1);				
					//echo "-------new_version----".$new_version."---------------<br>";
					if($new_version >= 7) {							
							$first_key = base64_decode($key);
							$second_key = base64_decode($key); 
							$method = "aes-256-cbc";    
							$iv_length = openssl_cipher_iv_length($method);
							$iv = openssl_random_pseudo_bytes($iv_length);
							$first_encrypted = openssl_encrypt($string,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
							$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
							$output = base64_encode($iv.$second_encrypted.$first_encrypted);    
							// echo "--input---output--".$output."------<br><br>";							
							return $output;
							
					} else {
							
							$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
							$padding = $block - (strlen($string) % $block);
							$string .= str_repeat(chr($padding), $padding);
							$crypted_text = mcrypt_encrypt
								(
									MCRYPT_RIJNDAEL_256, 
									$key, 
									$string, 
									MCRYPT_MODE_CBC, $iv
								);
					return base64_encode($crypted_text);
			}
		}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>iGainSpark</title>
	
	<!----------------------Safari form validation----------------------------------------------->
 <script src="<?php  echo $this->config->item('base_url2')?>assets/js/js-webshim/minified/polyfiller.js"></script>
    <script> 
        webshim.activeLang('en');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
 <!--------------------------------------------------------------------------------------->
	
	<link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" type="image/x-icon">
    <link href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>dist/css/AdminLTE.min.css" rel="stylesheet" />
	<link href="<?php echo base_url()?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/iCheck/flat/blue.css"> 
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	
	<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>			
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/common.js"></script>	
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	
	
	
	
	<script type="text/javascript">
        $(document).ready(function ()
		{  
            $('.dropdown-toggle').dropdown(); 
			
			$(".launch-modal").click(function()
			{
				$("#myModal").modal({
					backdrop: 'static'
				});
			});
        });		
	</script>
	
<script>
	/************************AMIT************************************/
	$('#submit').click(function()
	{
		// var Total_Redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
		var Total_Redeem_points=document.getElementById("Total_Redeem_points").value;
		if(Total_Redeem_points!= "")
		{
			show_loader();
		}
			
		
	});
	function Proceed_catalogue()
	{
		
		// var Total_Redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
		var Total_Redeem_points=document.getElementById("Total_Redeem_points").value;
		// var Total_Redeem_points=pts;
		// alert(Total_Redeem_points);
		if(Total_Redeem_points=="")
		{
			ShowPopup("Add to Cart atleast one Merchandize Item !!!");
		}
		else
		{
			window.location='<?php echo base_url(); ?>index.php/Redemption_Catalogue/Proceed_Redemption_Catalogue/?Total_Redeem_points='+encodeURIComponent(Total_Redeem_points);
		}
		
		
	}
	/*********************************************************************/
</script>
	
	<style>
	.control-sidebar
	{
		/* position: fixed; */
	}
	</style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div class="wrapper">
		<div id="header" class="navbar navbar-default navbar-fixed-top">
		<header class="main-header">
		
			<!-- Logo -->
			<a href="<?php echo base_url()?>index.php/Cust_home/home" class="logo">
				<span class="logo-mini" style="color:#fff;font-size: 30px; font-style: italic; font-family: FontAwesome;"><b>i</b></span>
				<img src="<?php echo $this->config->item('base_url2')?>images/logo.png" class="img-responsive" style="height: 35px; margin: 7px auto;"/>
			</a>
			<!-- Logo -->
			
			<nav class="navbar navbar-fixed-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			  


				<div class="navbar-custom-menu" style="margin-left: 0% !IMPORTANT;">
				
					<ul class="nav navbar-nav">			

						<?php 
						if($Ecommerce_flag==1)
						{						
							$cart_check = $ci_object->cart->contents();
							// var_dump
							if(!empty($cart_check)) 
							{
								$cart = $ci_object->cart->contents(); 
								$grand_total = 0; 
								$item_count = COUNT($cart); 
							?>						
								<li class="dropdown messages-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-cart-plus"></i>
										<span  class="label pull-right bg-red"><?php echo $item_count; ?></span>
									</a>
									
									<ul class="dropdown-menu">
										<li class="header">
											<div class="row">
												<div class="col-md-12 text-center">
												<span> <b> Purchase Cart </b> </br> </span>
													<span>Total &nbsp; : &nbsp; 
														<?php 
														foreach ($cart as $item) 
														{
															$grand_total = $grand_total + $item['subtotal'];
														}
														echo "<b>".$Symbol_of_currency." ".number_format((float)$grand_total, 2)."</b>"; ?>
													</span>
												</div>
											</div>
										</li>
										
										<li>
											<!-- inner menu: contains the actual data -->
											<ul class="menu">
												<?php 
												// foreach ($cart as $item) 
												// var_dump($this->cart->contents());
												foreach ($this->cart->contents() as $item) 
												{ 
													$Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
												?>
												
												<li>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>">
														<div class="pull-left">
															<img src="<?php echo $Product_details->Thumbnail_image1; ?>" class="img-responsive img-circle">
														</div>
														<p style="white-space: normal;">
															<?php echo $Product_details->Merchandize_item_name; ?>
															<small class="pull-right">Quantity : <?php echo $item['qty']; ?></small>
														</p>
														<p style="margin-top: 10px;width: 200px;">
															<span class="label label-success"><?php echo $Symbol_of_currency; ?>&nbsp;<?php 
															echo $item['price'];
															// echo number_format((float)$Product_details->Billing_price, 2); 
															
															?></span>
														</p>
													</a>
												</li>
												
												<?php } ?>
											</ul>
										</li>
										
										 <li class="footer">
											<a href="<?php echo base_url()?>index.php/Shopping/view_cart">View Purchase Cart</a>
										</li>
									</ul>
								</li>
							
						<?php }
						}
						?>
						<!---AMIT------START------------------------------------------------------------------------------------>
					
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-shopping-cart"></i>
							<?php 
							// echo "-------key----".$key."---------------<br>";
							// echo "-------iv----".$iv."---------------<br>";
								$Total_Redeem_points1 = string_encrypt($Total_Redeem_points, $key, $iv);	
								$Total_Redeem_pointEn = preg_replace("/[^(\x20-\x7f)]*/s", "", $Total_Redeem_points1);
								// echo "----Total_Redeem_pointEn---".$Total_Redeem_pointEn."---<br>";
							?>
							<span  class="label pull-right bg-red"><span id="Total_Redeem_points12"><?php echo $Total_Redeem_points; ?></span></span>
							<input type="hidden" id="Total_Redeem_points" name="Total_Redeem_points" value="<?php echo $Total_Redeem_pointEn; ?>" >
						</a>						
						<ul class="dropdown-menu">
							<li class="header">
								<div class="row">
									<div class="col-md-12 text-center">
									<span> <b> Redemption Cart </b> <br> </span>
										<span>Total : <span id="Total_Redeem_points2"><?php echo $Total_Redeem_points; ?></span> 
										</span>
									</div>
								</div>

							
							</li>
							
							<li id="item_list">
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<?php  foreach ($Redeemtion_details2 as $item) { 
									//echo "Merchandize_item_name ".$item->Merchandize_item_name;
									
									$Company_merchandise_item_id1 = string_encrypt($item['Company_merchandise_item_id'], $key, $iv);	
									$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Company_merchandise_item_id1);
									?>
									
									<li>
										<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
											<div class="pull-left">
												<img src="<?php echo $item["Thumbnail_image1"]; ?>" class="img-circle">
											</div>
											<p style="margin-top: 10px;width: 200px;">
											<h4>
												<?php echo $item["Merchandize_item_name"]; ?>												
											</h4>											
											<small>Quantity : <?php echo $item["Quantity"]; ?></small>
												<span class="label label-info"><?php echo $item["Total_points"]; ?></span>
											</p>
										</a>
										
									</li>
									
									<?php }  ?>
									
								</ul>
								<?php   //if($Total_Redeem_points!=0){ ?>
									<br>
									
									 <li class="footer">
										<a href="javascript:void(0)" onclick="Proceed_catalogue();" >View Redemption Cart</a>
									</li>
									<!--<button type="submit" class="btn btn-default" name="submit"  id="submit"  onclick="Proceed_catalogue()" >Proceed to Checkout <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></button>-->
									
									<?php //} ?>
							</li>
						</ul>
					</li>
					
					<!---AMIT-END--------------------------->
						
						<?php						
						if($Ecommerce_flag==1)
						{
							$wishlist = $ci_object->wishlist->get_content();
							if(!empty($wishlist)) 
							{	
								$wishlist = $ci_object->wishlist->get_content();
								$item_count2 = COUNT($wishlist); 
							?>
							
								<li class="dropdown messages-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-heart"></i>
										<span  class="label pull-right bg-red"><?php echo $item_count2; ?></span>
									</a>
									
									<ul class="dropdown-menu">
										<li class="header">
											<div class="row">
												<div class="col-md-12 text-center">
													<span><b>My Wishlist</b></span>
												</div>
											</div>
										</li>										
										<li>
											<ul class="menu">
												<?php foreach ($wishlist as $item2) {
													
												$Product_details2 = $ci_object->Shopping_model->get_products_details($item2['id']);
												?>
												
												<li>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details2->Company_merchandise_item_id; ?>">
														<div class="pull-left">
															<img src="<?php echo $Product_details2->Thumbnail_image1; ?>" class="img-responsive img-circle">
														</div>
														<p style="white-space: normal;">
															<?php echo $Product_details2->Merchandize_item_name; ?>
														</p>
														<p style="margin-top: 10px;width: 200px;">
															<span class="label label-success"><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format((float)$Product_details2->Billing_price, 2); ?></span>
														</p>
													</a>
												</li>
												
												<?php } ?>
											</ul>
										</li>
										
										 <li class="footer"><a href="<?php echo base_url()?>index.php/Shopping/view_wishlist">View My Wishlist</a></li>
									</ul>
								</li>
							
							<?php 
							} 
						}
						?>
					
						<li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<?php if($NotificationsCount->Open_notify > '0') { ?>
								<span  class="label pull-right bg-red"><?php echo $NotificationsCount->Open_notify; ?></span>
								<?php } ?>
							</a>
							
							<ul class="dropdown-menu">
								<li class="header">You have <?php echo $NotificationsCount->Open_notify; ?> new messages</li>
								<li>
									<ul class="menu">
										<li>
											<?php
											foreach($NotificationsDetails as $note)
											{ 
											
												$date1 = date('Y-m-d',strtotime($note['Date']));
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
												$years = floor($diff / (365*60*60*24));
												$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
												$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
												if($years=='0')	{ $years=''; }
												else{	$years=$years.' Year-'; }
												if($months=='0'){ $months=''; }
												else{ $months=$months.' Months-'; }
												if($days=='0'){$days='';}
												else{ $days=$days.' Days ago'; }
												
												?>
											
												<a href="<?php echo base_url()?>index.php/Cust_home/mailbox" style="color:#3c8dbc;">
													<div class="pull-left">
														<i class="fa fa-envelope"></i>														
													</div>
													
													<h4>
														<small><i class="fa fa-clock-o"></i>
														<?php 
														if( $years=="" && $months =="" &&  $days== "")
														{
															echo 'Just Now';
														}
														else
														{
															echo $years, $months, $days;
														}
														
														?></small>
													</h4>													
													<p>
														<?php
														$result = substr($note['Offer'], 0, 25);
														echo $result; 
														?>
													</p>
												</a>
											<?php 
											}
											?>									
										</li>
									</ul>
							  
									<li class="footer"><a href="<?php echo base_url()?>index.php/Cust_home/mailbox">See All Messages</a></li>
								</li>
							</ul>							
						</li>
					
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php 
								if($Enroll_details->Photograph == "")
								{
								?>
								
									<img src="<?php echo $this->config->item('base_url2')?>images/no_image.jpeg" class="user-image" alt="<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>">
									<span class="hidden-xs"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></span>
								
								<?php 
								}
								else
								{
								?>
								
									<img src="<?php echo $this->config->item('base_url2')?><?php echo $Enroll_details->Photograph; ?>" class="user-image" alt="<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>">
									<span class="hidden-xs"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></span>
								
								<?php
								}
								?>
							</a>
							
							<ul class="dropdown-menu">
								<li class="user-header" style="height: auto;">
								
									<?php 
									if($Enroll_details->Photograph == "")
									{
									?>
									
										<img src="<?php echo $this->config->item('base_url2')?>images/no_image.jpeg" class="img-circle" alt="<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>">
									
									<?php 
									}
									else
									{
									?>
									
										<img src="<?php echo $this->config->item('base_url2')?><?php echo $Enroll_details->Photograph; ?>" class="img-circle" alt="<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>">
									
									<?php
									}
									?>
								
									<p style="margin-top:0px">
										<?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?>
									</p>
									
									<p style="margin-top:0px">
										Current Balance:<b> <?php echo $Current_point_balance;?></b>
									</p>
									
									<p style="margin-top:0px">
										Membership Id : <b> <?php echo $Enroll_details->Card_id;?></b>
									</p>
								</li>
								
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?php echo base_url()?>index.php/Cust_home/profile" class="btn btn-default btn-flat">Profile</a>
									</div>
									
									<div class="pull-right">
										<?php 
										if($smartphone_flag == 2) {
											?>
											<a href="<?php echo base_url()?>index.php/Cust_home/logout" class="btn btn-default btn-flat">Sign out</a>
										<?php 
										}
										?>
									</div>
								</li>
							</ul>
						</li>
						
						<?php /* <li>
							<?php if($smartphone_flag == 2) { ?>
								<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears">&nbsp;Theme Color</i></a>
							<?php } ?>
						</li> */ ?>
					</ul>
				</div>
			</nav>
		</header>
		</div>
	
	
		<aside class="main-sidebar" style="position:fixed;">
			<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="header">Menu</li>
					<li class="treeview" <?php if($this->router->fetch_method()=="home"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url(); ?>index.php/Cust_home/home">
							<i class="fa fa-home"></i>
							<span>Home</span></i>
						</a>
					</li>
					<li class="treeview" <?php if($this->router->fetch_method()=="profile"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url(); ?>index.php/Cust_home/profile">
							<i class="fa fa-user"></i>
							<span>My Profile</span></i>
						</a>
					</li>
					
					<li class="treeview" <?php if($this->router->fetch_method()=="merchantoffers"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url(); ?>index.php/Cust_home/merchantoffers">
							<i class="fa fa-gift"></i>
							<span>Merchant Offers</span></i>
						</a>
					</li>
					<?php  if($Transfer_accross_flag==1) { ?>
					<li class="treeview">
						<a href="">
							<i class="fa fa-share-square-o"></i>
							<span>Membership</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							<li <?php if($this->router->fetch_method()=="Add_Beneficiary_Category"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category">
									<i class="fa fa-plus-square"></i>
									<span>Add Loyalty Programs </span>
								</a>
							</li>
							<li <?php if($this->router->fetch_method()=="Added_Beneficiary_accounts"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url(); ?>index.php/Beneficiary/Added_Beneficiary_accounts">
									<i class="fa fa-share-square"></i>
									<span>My Loyalty Programs </span>
								</a>
							</li>
						</ul>
						
						<?php if($this->router->fetch_method()=="Add_Beneficiary_Category" || $this->router->fetch_method()=="Added_Beneficiary_accounts"){ ?>
						<ul style="margin-right:15px;line-height:2.3;">
							<li <?php if($this->router->fetch_method()=="Add_Beneficiary_Category"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category">
									<i class="fa fa-plus-square"></i>
									<span>Add Loyalty Programs</span>
								</a>
							</li>
							<li <?php if($this->router->fetch_method()=="Added_Beneficiary_accounts"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url(); ?>index.php/Beneficiary/Added_Beneficiary_accounts">
									<i class="fa fa-share-square"></i>
									<span>My Loyalty Programs </span>
								</a>
							</li>
						</ul>
						<?php } ?>
						
					</li>			
				<?php 
				} 
				 
					if($Buy_miles_flag==1)
					{ 
				?>
					<li class="treeview" <?php if($this->router->fetch_method()=="Load_buy_miles"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url()?>index.php/Beneficiary/Load_buy_miles">
							<i class="fa fa-gift"></i>
							<span>Buy</span></i>
						</a>
					</li>
					<?php } ?>
					
					
					<?php if($Ecommerce_flag==1)
					{ ?>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-cart-arrow-down"></i>
							<span>Gain <?php echo $Company_details->Currency_name; ?></span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							
							<?php 
								if($Ecommerce_flag==1)
								{	
								?>
									<li>
										<a href="<?php echo base_url()?>index.php/Shopping">
											<i class="fa fa-cart-plus"></i>
											<span>Online Shopping</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url()?>index.php/Shopping/my_orders">
											<i class="fa fa-list-alt"></i>
											<span>Purchase Details</span>
										</a>
									</li>
							<?php 
								}
								?>
						</ul>
						<?php if( $this->router->fetch_class()=="Shopping" || $this->router->fetch_method()=="my_orders"){ ?>
						<ul style="margin-right:15px;line-height:2.3;">
							
							<?php 
								if($Ecommerce_flag==1)
								{	
								?>
							<li <?php if($this->router->fetch_class()=="Shopping" && $this->router->fetch_method()!="my_orders"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Shopping">
									<i class="fa fa-cart-plus"></i>
									<span>Online Shopping</span>
								</a>
							</li>
							<li <?php if($this->router->fetch_class()=="Shopping" && $this->router->fetch_method()=="my_orders"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Shopping/my_orders">
									<i class="fa fa-list-alt"></i>
									<span>Purchase Details</span>
								</a>
							</li>
							<?php 
								}
								?>
						</ul>
						<?php } ?>
						
					</li>
					<?php } ?>
					
					<li class="treeview">
						<a href="#">
							<i class="fa fa-shopping-cart "></i>
							<span>Redeem <?php echo $Company_details->Currency_name; ?></span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							<li>
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/">
									<i class="fa fa-shopping-cart"></i>
									<span>Rewards Catalogue</span></i>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/eVoucher_catalogue">
									<i class="fa fa-shopping-cart"></i>
									<span>eVoucher Gift Card</span></i>
								</a>
							</li>
							
						</ul>
						<?php if($this->router->fetch_class()=="Redemption_Catalogue" || $this->router->fetch_method()=="eVoucher_catalogue"){ ?>
						<ul style="margin-right:15px;line-height:2.3;">
							<li <?php if($this->router->fetch_class()=="Redemption_Catalogue" && $this->router->fetch_method()!="eVoucher_catalogue" ){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue">
									<i class="fa fa-shopping-cart"></i>
									<span>Rewards Catalogue</span>
								</a>
							</li>
							<li <?php if($this->router->fetch_class()=="Redemption_Catalogue" && $this->router->fetch_method()=="eVoucher_catalogue" ){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/eVoucher_catalogue">
									<i class="fa fa-shopping-cart"></i>
									<span>eVoucher Gift Card</span>
								</a>
							</li>
							
						</ul>
						<?php } ?>
						
					</li>
					
					
					<li class="treeview">
						<a href="#">
							<i class="fa fa-share"></i>
							<span>Transfer <?php echo $Company_details->Currency_name; ?> Within</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							<li>
									<a href="<?php echo base_url()?>index.php/Cust_home/transferpoints">
									<i class="fa fa-share"></i>
									<span>To Other Members</span></i>
								</a>
								</li>
						</ul>
							
						<?php if($this->router->fetch_class()=="transferpoints"){ ?>
						<ul style="margin-right:15px;line-height:2.3;">
							<li <?php if($this->router->fetch_class()=="transferpoints"){ echo "style='background: #376172;'";} ?> >
								<a href="<?php echo base_url()?>index.php/Cust_home/transferpoints">
									<i class="fa fa-share"></i>
									<span>-To Other Members</span></i>
								</a>
							</li>
							
						</ul>
						<?php } ?>
						
					</li>
					
					
					<?php  if($Transfer_accross_flag==1) { ?>
					<li class="treeview">
						<a href="">
							<i class="fa fa-share-square-o"></i>
							<span>Transfer Points Across</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							<!--<li <?php //if($this->router->fetch_method()=="Add_publisher_menu"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php //echo base_url()?>index.php/Beneficiary/Add_publisher_menu">
									<i class="fa fa-plus-square"></i>
									<span>Add Beneficiary</span>
								</a>
							</li> -->
							<li <?php if($this->router->fetch_method()=="From_publisher"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Transfer_publisher/From_publisher">
									<i class="fa fa-share-square"></i>
									<span>Transfer Now</span>
								</a>
							</li>
						</ul>
						
						<?php if($this->router->fetch_method()=="Add_publisher_menu" || $this->router->fetch_method()=="From_publisher"){ ?>
						<ul style="margin-right:15px;line-height:2.3;">
							<!--<li <?php //if($this->router->fetch_method()=="Add_publisher_menu"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php //echo base_url()?>index.php/Beneficiary/Add_publisher_menu">
									<i class="fa fa-plus-square"></i>
									<span>Add Beneficiary</span>
								</a>
							</li> -->
							<li <?php if($this->router->fetch_method()=="From_publisher"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Transfer_publisher/From_publisher">
									<i class="fa fa-share-square"></i>
									<span>Transfer Now</span>
								</a>
							</li>
						</ul>
						<?php } ?>
						
					</li>			
				<?php }  ?>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-gamepad" ></i>
							<span>Play Games</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						
						<ul class="treeview-menu">
							<?php if($PromoCodeApply=='1') { ?>
								<li <?php if($this->router->fetch_method()=="promocode"){ echo "style='background: #376172;'";} ?>>
									<a href="<?php echo base_url()?>index.php/Cust_home/promocode">
										<i class="fa fa-barcode"></i>
										<span>Submit Promo Code</span></i>
									</a>
								</li>
								<?php } ?>
							<?php if($AuctionBidApply=='1') { ?>
								<li <?php if($this->router->fetch_method()=="auctionbidding"){ echo "style='background: #376172;'";} ?>>
									<a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding">
										<i class="fa fa-legal"></i>
										<span>Bid for Auction</span></i>
									</a>
								</li>
								<?php } ?>
							<li <?php if($this->router->fetch_method()=="game_to_play"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Cust_home/game_to_play">
									<i class="fa fa-gamepad"></i>
									<span>More Games</span></i>
								</a>
								</li> 	
						</ul>
						<?php 
						if($this->router->fetch_method()=="promocode" || $this->router->fetch_method()=="auctionbidding" || $this->router->fetch_method()=="game_to_play") 
						{ ?>
						
						<ul style="margin-right:15px;line-height:2.3;">
							<?php if($PromoCodeApply=='1') { ?>
								<li <?php if($this->router->fetch_method()=="promocode"){ echo "style='background: #376172;'";} ?>>
									<a href="<?php echo base_url()?>index.php/Cust_home/promocode">
										<i class="fa fa-barcode"></i>
										<span>Submit Promo Code</span></i>
									</a>
								</li>
								<?php } ?>
							<?php if($AuctionBidApply=='1') { ?>
								<li <?php if($this->router->fetch_method()=="auctionbidding"){ echo "style='background: #376172;'";} ?>>
									<a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding">
										<i class="fa fa-legal"></i>
										<span>Bid for Auction</span></i>
									</a>
								</li>
								<?php } ?>
							<li <?php if($this->router->fetch_method()=="game_to_play"){ echo "style='background: #376172;'";} ?>>
								<a href="<?php echo base_url()?>index.php/Cust_home/game_to_play">
									<i class="fa fa-gamepad"></i>
									<span>More Games</span></i>
								</a>
								</li> 	
						</ul>
						<?php } ?>
						
					</li>
					
					
					
					<li class="treeview" <?php if($this->router->fetch_method()=="getsurvey"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url()?>index.php/Cust_home/getsurvey">
							<i class="fa fa-pencil-square-o"></i>
							<span>Take Survey</span></i>
						</a>
					</li>
											
					<li <?php if($this->router->fetch_method()=="mailbox"){ echo "style='background: #376172;'"; } ?>>
						<a href="<?php echo base_url()?>index.php/Cust_home/mailbox">
							<i class="fa fa-envelope"></i> <span>Notification</span>
							<?php if($NotificationsCount->Open_notify > '0') { ?>
							<small class="label pull-right bg-red"><?php echo $NotificationsCount->Open_notify;?></small>
							<?php } ?>
						</a>
					</li>
					
					<li class="treeview" <?php if($this->router->fetch_method()=="mystatement"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url()?>index.php/Cust_home/mystatement">
							<i class="fa fa-file"></i>
							<span>My Statement</span></i>
						</a>
					</li>
					
					<li class="treeview" <?php if($this->router->fetch_method()=="contactus"){ echo "style='background: #376172;'";} ?>>
						<a href="<?php echo base_url()?>index.php/Cust_home/contactus">
							<i class="fa fa-phone"></i>
							<span>Contact Us</span></i>
						</a>
					</li>
				
								
				</ul>
			</section>
		</aside>
<div class="content-wrapper" style="margin-top: 50px;">		