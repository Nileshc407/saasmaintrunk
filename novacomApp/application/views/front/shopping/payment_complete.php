<?php $this->load->view('front/header/header'); 
		// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
			// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
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
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
		
	/* style="background-image:url('img/notification-bg.jpg')" 

		style="background-image:url('<?php echo base_url(); ?>assets/img/menu-bg.jpg')"
	
	*/
?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/notification-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>Order Confirmation</h2>
				</div>
			</div>
		</div>
		<div class="custom-body msg-box-body">
			<div class="msg-box confirmation">
				<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" class="close-icon"></a>
				<div class="confirm-icon text-center">
					<img src="<?php echo base_url(); ?>assets/img/confirm.png" class="img-fluid w-80">
					<p>Thank you for ordering!</p>
				</div>
				
				
				<?php /* if($session_data['Walking_customer'] == 0) { ?>
					<strong id="Large_font" style="color:#41ad41;">Order Done</strong><br>
					<strong id="Large_font">Thank you for your Purchase.  A Confirmation Email has been sent to <?php echo $User_email_id; ?><br> The Online Order No. is <b><?php echo $Bill_no; ?></b> <br>
					<?php if( $Manual_billno != "" ){ ?> The POS Bill No. is <?php echo $Manual_billno; } ?> </strong>
					
				<?php } else { ?>
						<strong id="Large_font" style="color:#41ad41;">Order Done</strong><br>
						<strong id="Large_font">Thank you for your Purchase.<br> The Online Order No. is <b><?php echo $Bill_no; ?></b> <br>
						<?php if( $Manual_billno != "" ){ ?> The POS Bill No. is <?php echo $Manual_billno; } ?> </strong> 
						<br>
						<br>
						<strong id="Large_font">Note: Present this confirmation to collect your Order. </strong>
				<?php } */ ?>
				
				
				<?php 
					
										$str_arr2 = explode(",",$Outlet_address);
										$str_arr20 =$str_arr2[0];
										$str_arr21 =$str_arr2[1];
										$str_arr22= $str_arr2[2];
										$str_arr23=$str_arr2[3];
				?>
				
				<div class="text">
					<h2>Collect your order from:</h2>
					<p><span class="value">Outlet Name:</span> <?php echo $Outlet_name; ?> </p>
					<p><span class="value">Building:</span> <?php echo $str_arr20; ?> </p>
					<p><span class="value">Street/Road:</span> <?php echo $str_arr21; ?> </p>
					<p><span class="value">City:</span> <?php echo $Outlet_city_name; ?> </p>
					
					<p><span class="value">Online Order No.:</span> <b><?php echo $Bill_no; ?></b> </p>
					<?php if( $Manual_billno != "" ){ ?> 
						<p><span class="value">POS Bill No.:</span>  <b><?php echo $Manual_billno;?> </b> </p>
					<?php } ?>
				</div>
			</div>
		</div>
<?php $this->load->view('front/header/footer'); ?>
<script>
	 localStorage.clear();
</script>