 <?php 
		$ci_object = &get_instance(); 
		$ci_object->load->model('Igain_model');
		$item_count=0;
		$cart_check = $this->cart->contents();
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart);  
			}
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}
		// echo "--item_count-".$item_count;
		
		
		$fetch_class=$this->router->fetch_class();
		$fetch_method=$this->router->fetch_method();



		$session_data = $this->session->userdata('cust_logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$data['enroll'] = $session_data['enroll'];
		
		$NotificationsCount= $ci_object->Igain_model->Fetch_Open_Notification_Count($session_data['enroll'], $session_data['Company_id']);
		 // var_dump($NotificationsCount->Open_notify);
		// echo "--fetch_class-".$fetch_class."--fetch_method-".$fetch_method;
		// die;
		
		$pointscss='';
		$homecss='';
		$usercss='';
		$noticss='';
		$noticssColor='#fd1090';
		
		if($fetch_method=='redeem_history' || $fetch_method=='Points_history' || $fetch_method=='select_stamp_brand'|| $fetch_method=='Get_stamps_by_brand'|| $fetch_method=='My_vouchers'|| $fetch_method=='Vouchers_history'|| $fetch_method=='Redeem_points_QRCode'){
			
			$pointscss='active';
			$homecss='';
			$usercss='';
			$noticss='';
			$noticssColor='#fd1090';
			
		}
		if($fetch_method=='front_home' || $fetch_method=='select_brand' || $fetch_method=='set_brand'|| $fetch_method=='special_offer'|| $fetch_method=='aboutus'|| $fetch_method=='contactus_App'|| $fetch_method=='location' || $fetch_method=='works' || $fetch_method=='contactus'){
			
			$pointscss='';
			$homecss='active';
			$usercss='';
			$noticss='';
			$noticssColor='#fd1090';
			
		}
		if($fetch_method=='myprofile' || $fetch_method=='profile' || $fetch_method=='transactions'|| $fetch_method=='settings'|| $fetch_method=='changepassword'|| $fetch_method=='terms_conditions'|| $fetch_method=='privacy_policy'  || $fetch_method=='Verify_email' || $fetch_method=='Verified_email' || $fetch_method=='Verifiy_pin'){
			
			$pointscss='';
			$homecss='';
			$usercss='active';
			$noticss='';
			$noticssColor='#fd1090';
			
		}
		if($fetch_method=='mailbox' || $fetch_method=='compose' || $fetch_method=='readnotifications'){
			
			$pointscss='';
			$homecss='';
			$usercss='';
			$noticss='active';
			$noticssColor='#fff';
			
		}
		


/* for Redemption  */


$ci_object = &get_instance();
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


/* _Notification_Count */
	$NotificationsCount = $ci_object->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
	
/* _Notification_Count */

?>

<footer>
	<ul class="iconMenu d-flex align-items-center">
		<li><a class="home <?php echo $homecss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/front_home">&nbsp;</a></li>
		<li><a class="user <?php echo $usercss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/myprofile">&nbsp;</a></li>
		<li><a class="points <?php echo $pointscss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/redeem_history">&nbsp;</a></li>
		
		<?php 
			// echo "-------key----".$key."---------------<br>";
			// echo "-------iv----".$iv."---------------<br>";
				$Total_Redeem_points1 = string_encrypt($Total_Redeem_points, $key, $iv);	
				$Total_Redeem_pointEn = preg_replace("/[^(\x20-\x7f)]*/s", "", $Total_Redeem_points1);
				// echo "----Total_Redeem_points---".$Total_Redeem_points."---<br>";
				// echo "----fetch_class---".$fetch_class."---<br>";
			?>
		
		<?php 
		if($fetch_class == 'Redemption_Catalogue'){
			$redeemcss="active";
		}
		// if($Total_Redeem_points > 0 )
		if($fetch_class == 'Redemption_Catalogue')
		{ ?> 
		<li>
						
						
		
			<!--<span  class="label pull-right bg-red"><span id="Total_Redeem_points12"><?php echo $Total_Redeem_points; ?></span></span> -->
			<input type="hidden" id="Total_Redeem_points" name="Total_Redeem_points" value="<?php echo $Total_Redeem_pointEn; ?>" >
						
			<a class="redeem <?php echo $redeemcss; ?>" href="javascript:void(0)" onclick="Proceed_catalogue();" ><span  class="label pull-right bg-red"><span id="Total_Redeem_points2"><?php echo $Total_Redeem_points; ?></span></span></a>
			
		</li>
		<?php } else { ?>  
		<li>
			<a class="noti <?php echo $noticss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/mailbox">&nbsp;
			<?php if($NotificationsCount->Open_notify> 0) { ?><span  class="label pull-right" ><span style="color:<?php echo $noticssColor; ?>;    margin-right: 10%;"><?php echo $NotificationsCount->Open_notify; ?></span></span><?php } ?>
			</a>
		</li>
		<?php }?>
		
	</ul>
</footer>
<div class="overlay"></div>	
<!--<script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script> -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
	
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
 
</body>
</html>
<script>
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