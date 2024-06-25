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
		
		if($fetch_method=='redeem_history' || $fetch_method=='Points_history' || $fetch_method=='select_stamp_brand'|| $fetch_method=='Get_stamps_by_brand'|| $fetch_method=='My_vouchers'|| $fetch_method=='Vouchers_history'|| $fetch_method=='Redeem_points_QRCode'){
			
			$pointscss='active';
			$homecss='';
			$usercss='';
			$noticss='';
			
		}
		if($fetch_method=='front_home' || $fetch_method=='select_brand' || $fetch_method=='set_brand'|| $fetch_method=='special_offer'|| $fetch_method=='aboutus'|| $fetch_method=='contactus_App'|| $fetch_method=='location' || $fetch_method=='works' || $fetch_method=='contactus'){
			
			$pointscss='';
			$homecss='active';
			$usercss='';
			$noticss='';
			
		}
		if($fetch_method=='myprofile' || $fetch_method=='profile' || $fetch_method=='transactions'|| $fetch_method=='settings'|| $fetch_method=='changepassword'|| $fetch_method=='terms_conditions'|| $fetch_method=='privacy_policy'  || $fetch_method=='Verify_email' || $fetch_method=='Verified_email' || $fetch_method=='Verifiy_pin'){
			
			$pointscss='';
			$homecss='';
			$usercss='active';
			$noticss='';
			
		}
		if($fetch_method=='mailbox' || $fetch_method=='compose' || $fetch_method=='readnotifications'){
			
			$pointscss='';
			$homecss='';
			$usercss='';
			$noticss='active';
			
		}
		
 ?>
 

<footer>
	<ul class="iconMenu d-flex align-items-center">
		<li><a class="home <?php echo $homecss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/front_home">&nbsp;</a></li>
		<li><a class="user <?php echo $usercss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/myprofile">&nbsp;</a></li>
		<li><a class="points <?php echo $pointscss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/redeem_history">&nbsp;</a></li>
		<li><a class="noti <?php echo $noticss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/mailbox">&nbsp;</a></li>
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
 
</body>
</html>