<?php /* ?>
	<header class="header">
		<div class="container">
			<div class="row">
			  <div class="col-12">
				<input type="checkbox" class="toggle-menu" id="hamburger-checkbox" />
				<label class="hamburger-icon slide-menu__control" data-target="menu-left" data-action="toggle" for="hamburger-checkbox"> <span></span>
				</label>
				<h3 class="profile-name"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h3>
				<div class="sub-plan"><?php echo $Tier_details->Tier_name." Member"; ?></div>            
				<nav class="slide-menu" id="menu-left">
				  <ul>
					
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/front_home" id="special-link-3"><img src="<?php echo base_url(); ?>assets/img/dash.png">DASHBOARD</a></li>				
					
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/profile"><img src="<?php echo base_url(); ?>assets/img/user-sm.png">PROFILE</a> </li>
					
					<li> <a href="<?php echo base_url();?>index.php/Shopping"><img src="<?php echo base_url(); ?>assets/img/ord.png">VIEW MENU</a></li>
					
					<li> <a href="<?php echo base_url();?>index.php/Shopping/my_orders"><img src="<?php echo base_url(); ?>assets/img/state.png">MY ORDERS</a></li>
					
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/MerchantCommunication"><img src="<?php echo base_url(); ?>assets/img/voucher.png">OFFERS</a></li>
					
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/transferpointsApp"><img src="<?php echo base_url(); ?>assets/img/trans.png">TRANSFER POINTS</a></li>              
					
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/mailbox"><img src="<?php echo base_url(); ?>assets/img/noti.png">NOTIFICATION </a>
					<?php if($NotificationsCount->Open_notify > 0 ) { ?>
						<span class="badge badge-light bg-danger"><?php echo $NotificationsCount->Open_notify; ?></span>
					<?php } ?>
					</li>
					
					<li class="setting-menu"> 				
						<li> <a href="<?php echo base_url();?>index.php/Cust_home/contactus_App"><img src="<?php echo base_url(); ?>assets/img/phone.png">CONTACT US</a></li>
						<li> <a href="<?php echo base_url();?>index.php/Cust_home/settings"><img src="<?php echo base_url(); ?>assets/img/setting.png">SETTING</a></li>
						<li> <a href="<?php echo base_url();?>index.php/Cust_home/help"><img src="<?php echo base_url(); ?>assets/img/noti.png">HELP</a></li>
					</li>
				 </ul>
				  </nav>
				</div>
			</div>
		</div>
	</header>
<?php */ ?>


<?php 
$ci_object = &get_instance(); 
		$ci_object->load->model('Igain_model');
		
$session_data = $this->session->userdata('cust_logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$data['enroll'] = $session_data['enroll'];
$NotificationsCount= $ci_object->Igain_model->Fetch_Open_Notification_Count($session_data['enroll'], $session_data['Company_id']);

?>

	<div class="custom-header">
         <div class="container">
            <div class="heading-wrap">
               <div class="icon bar-icon" id="nav-menu">
                <div class="nav-icon menu-trigger">
                <span></span>
                <span></span>
                <span></span>
                </div> 
               </div>
               <h2 class="title-name"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h2>
               <div class="plan"><?php echo $Tier_details->Tier_name." Member"; ?></div>
            </div>
         </div>
	</div>
	
          <nav class="menu-wrapper" style="z-index: 1 !IMPORTANT;">
            <ul class="parent-menu">
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/front_home" id="special-link-3"><img src="<?php echo base_url(); ?>assets/img/dash.png">DASHBOARD</a></li>				
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/profile"><img src="<?php echo base_url(); ?>assets/img/user-sm.png">PROFILE</a> </li>
				
				<li> <a href="<?php echo base_url();?>index.php/Shopping/delivery_type_shopping"><img src="<?php echo base_url(); ?>assets/img/ord.png">VIEW MENU</a></li>
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/CheckoutGiftCard" onclick="ClearlocalStorage();"><img src="<?php echo base_url(); ?>assets/img/ord.png">BUY GIFT CARD</a></li>
				
				<li> <a href="<?php echo base_url();?>index.php/Shopping/my_orders"><img src="<?php echo base_url(); ?>assets/img/state.png">MY ORDERS</a></li>
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/Vouchers_giftcard"><img src="<?php echo base_url(); ?>assets/img/state.png">MY VOUCHERS & GIFT CARDS</a></li>
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/stamp_collection"><img src="<?php echo base_url(); ?>assets/img/state.png">MY STAMPS</a></li>					
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/MerchantCommunication"><img src="<?php echo base_url(); ?>assets/img/voucher.png">OFFERS</a></li>
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/transferpointsApp"><img src="<?php echo base_url(); ?>assets/img/trans.png">TRANSFER POINTS</a></li>              
				
				<li> <a href="<?php echo base_url();?>index.php/Cust_home/mailbox"><img src="<?php echo base_url(); ?>assets/img/noti.png">NOTIFICATION

				<?php if($NotificationsCount->Open_notify > 0 ) { ?>
					<span id="spanNote"><?php echo $NotificationsCount->Open_notify; ?></span>
				<?php } ?>

				</a>
				
				</li>
				
				<li> 				
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/contactus_App"><img src="<?php echo base_url(); ?>assets/img/phone.png">CONTACT US</a></li>
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/settings"><img src="<?php echo base_url(); ?>assets/img/setting.png">SETTING</a></li>
					<li> <a href="<?php echo base_url();?>index.php/Cust_home/help"><img src="<?php echo base_url(); ?>assets/img/noti.png">HELP</a></li>
				</li>
				<li style="height:200px;background: #fff;"></li>
				
             </ul>  
          </nav>
	<style>
	#spanNote{
		position: absolute;
		right: 0;
		top: 10px;
		background: #F8E0A4;
		color: var(--dark);
		line-height: 15px;
		font-size: 11px;
		padding: 0 3px;
		border-radius: 50px;
		margin: 5px;
		font-weight: 600;
	}
	</style>
	<script>
	function ClearlocalStorage()
	{
		localStorage.clear();
	}
	</script>