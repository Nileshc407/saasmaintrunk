 <?php 
		$ci_object = &get_instance(); 
		$ci_object->load->model('Igain_model');
		
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
 ?>
		<div class="custom-footer">
         <div class="container">
            <ul class="icon-menu">
               <li <?php if($fetch_class=='Cust_home' && $fetch_method=='myprofile'){ echo "class='active'"; } ?> >
                  <a href="<?php echo base_url();?>index.php/Cust_home/myprofile">
                     <svg width="27" height="32" viewBox="0 0 27 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M26.2943 27.1999L24.9676 31.4305C24.848 31.7778 24.5178 32.0056 24.1534 31.9999H2.8467C2.48229 32.0056 2.15204 31.7778 2.03246 31.4305L0.705779 27.1942C-0.01735 24.9166 0.233183 22.8668 1.42891 21.2327C3.33637 18.6192 7.51003 17.2469 13.5 17.2469C19.4901 17.2469 23.6637 18.6305 25.5712 21.2327C26.7669 22.8498 27.0174 24.9337 26.2943 27.1999ZM13.5 15.2825C17.7192 15.2882 21.1413 11.8662 21.147 7.64696C21.1527 3.42775 17.7306 0.00570103 13.5114 7.09527e-06C9.29223 -0.00568683 5.87017 3.41637 5.86448 7.63557V7.64126C5.87017 11.8605 9.28084 15.2768 13.5 15.2825Z" fill="white"/>
                     </svg>
                  </a>
               </li>
               <li <?php if($fetch_class=='Shopping' && $fetch_method !='view_cart'){ echo "class='active'"; } ?>>
                  <a href="<?php echo base_url();?>index.php/Shopping">
                     <svg width="33" height="24" viewBox="0 0 33 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.5 21.4284H32.5V23.6316H0.5V21.4284ZM17.5788 3.75694C21.1952 4.03045 24.4468 5.5955 26.8628 8.01146C30.0537 11.2023 31.1629 14.8187 31.1629 19.2251H1.79155C1.79155 14.8187 2.90076 11.2023 6.09164 8.01146C8.5076 5.5955 11.7593 4.03045 15.3756 3.75694V2.57176H13.3547V0.36853H19.5845V2.57176H17.5636L17.5788 3.75694ZM14.8742 8.11782L14.2816 5.99056L13.9473 6.08173C11.4706 6.76549 9.61681 7.6012 7.76306 9.40937C5.90931 11.2175 4.99763 13.0409 4.25309 15.4872L4.14672 15.8367L6.25878 16.4901L6.36515 16.1406C7.00332 14.0589 7.71747 12.5243 9.29772 10.9896C10.8932 9.45495 12.4278 8.78638 14.5247 8.20899L14.8742 8.11782Z" fill="white"/>
                        </svg>

                  </a>
               </li>
               <li <?php if($fetch_class=='Cust_home' && $fetch_method=='front_home'){ echo "class='active'"; } ?>>
                  <a href="<?php echo base_url();?>index.php/Cust_home/front_home">
						<svg width="33" height="30" viewBox="0 0 33 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M31.9205 12.5164L18.5977 1.43537C17.4127 0.41054 15.6193 0.41054 14.4343 1.43537L13.3134 2.36412C9.24611 5.75888 5.17881 9.15363 1.11151 12.5164C0.695174 12.8366 0.470992 13.349 0.503018 13.8615C0.503018 14.502 0.503018 15.1425 0.503018 15.815C0.503018 16.5837 0.7272 16.8078 1.49582 16.7758C2.42458 16.7758 3.3213 16.7758 4.25006 16.7758C4.69842 16.7758 4.76247 16.8719 4.76247 17.3203V22.3804C4.76247 23.9817 4.76247 25.5509 4.76247 27.1202C4.76247 28.4973 5.59515 29.33 6.97227 29.33C8.76572 29.33 10.5272 29.33 12.3206 29.33C12.4487 29.33 12.5768 29.33 12.7049 29.298V22.1242H20.2951V29.298C20.4232 29.33 20.5193 29.33 20.6474 29.33C22.4728 29.33 24.2663 29.33 26.0918 29.33C27.2127 29.394 28.1735 28.5293 28.2375 27.4084C28.2375 27.3124 28.2375 27.2483 28.2375 27.1522V17.3203C28.2375 16.8399 28.3016 16.7758 28.782 16.7758C29.7427 16.7758 30.7355 16.7758 31.6963 16.7758C32.0806 16.8399 32.4649 16.5837 32.497 16.1673C32.497 16.1033 32.497 16.0072 32.497 15.9431C32.497 15.2386 32.497 14.502 32.497 13.7974C32.529 13.285 32.3048 12.8366 31.9205 12.5164Z" fill="white"/>
                        </svg>

                  </a>
               </li>
               <li <?php if($fetch_class=='Cust_home' && $fetch_method=='mailbox'){ echo "class='active'"; } ?>>
                  <a href="<?php echo base_url();?>index.php/Cust_home/mailbox">
					<?php if($NotificationsCount->Open_notify > 0) { ?>
					<span><?php echo $NotificationsCount->Open_notify; ?></span><?php } ?>
                     <svg width="27" height="32" viewBox="0 0 27 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.1565 21.8517C22.7241 19.0325 24.4507 15.2563 23.2983 9.09159C22.5008 4.90068 18.2501 3.44922 15.6103 2.95078V2.1134C15.6103 0.945047 14.6653 0 13.4969 0C12.3286 0 11.3835 0.945047 11.3835 2.1134C11.3835 2.1134 11.3835 2.1134 11.3835 2.11738V2.95477C8.74376 3.4572 4.48507 4.90866 3.69952 9.09558C2.54712 15.2444 4.27772 19.0245 1.84133 21.8557C-0.595057 24.6869 0.369928 24.9939 0.369928 24.9939H26.6319C26.6319 24.9899 27.5929 24.6669 25.1565 21.8517Z" fill="white"/>
                        <path d="M13.5049 32C16.0848 32 18.1783 29.9065 18.1783 27.3266H8.8275C8.8275 29.9065 10.921 32 13.5009 32C13.5049 32 13.5049 32 13.5049 32Z" fill="white"/>
                     </svg>

                  </a>
               </li>
               <li <?php if($fetch_class=='Shopping' && $fetch_method=='view_cart'){ echo "class='active'"; } ?> >
                  <a href="<?php echo base_url();?>index.php/Shopping/view_cart">
					<?php //if($item_count) { ?>
					<span id="cart_count"><?php echo $item_count; ?></span><?php //} ?>
                    <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32.4669 9.09609L29.3662 21.5025C29.1198 22.4846 28.2407 23.1724 27.2255 23.1724H8.10276C6.98092 23.1724 6.03931 22.3338 5.91057 21.223L3.67793 3.31034H2.15517C1.23931 3.31034 0.5 2.57103 0.5 1.65517C0.5 0.73931 1.23931 0 2.15517 0H5.11977C5.94736 0 6.64621 0.610575 6.76023 1.4308L7.62092 7.72414H31.3966C32.1138 7.72414 32.6398 8.40092 32.4669 9.09609Z" fill="white"/>
                        <path d="M7.12069 28.6897C7.12069 30.514 8.60667 32 10.431 32C12.2554 32 13.7414 30.514 13.7414 28.6897C13.7414 26.8653 12.2554 25.3793 10.431 25.3793C8.60667 25.3793 7.12069 26.8653 7.12069 28.6897Z" fill="white"/>
                        <path d="M26.9828 28.6897C26.9828 26.8653 25.4968 25.3793 23.6724 25.3793C21.848 25.3793 20.3621 26.8653 20.3621 28.6897C20.3621 30.514 21.848 32 23.6724 32C25.4968 32 26.9828 30.514 26.9828 28.6897Z" fill="white"/>
                    </svg>
                  </a>
               </li>
            </ul>
         </div>
      </div>
		
	</div>
	<!--Main jQuery-->
	 <?php /* ?>
   <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
   <!--Bootstrap Min JS-->
   <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
   <!--custom JS-->
   <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/validation.js"></script>
   <?php */ ?>
   
   
   
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
   <!--Bootstrap Min JS-->
   <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
   <!--custom JS-->
   <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/jquery.menu.js"></script>
   <!--Menu Function Call -->
    <script>
    $(function() {
        $( '#nav-menu' ).dlmenu();
      });
    </script>
   
   
   
</body>
</html>
<style>
	/* ===[ Loading Animations ]=== */

		.modal-header{
			border-bottom: 1px solid #dee2e6 !IMPORTANT; 
		}
		.loadingSpinner, .loadingSpinnerKit {
			text-align: center;
			vertical-align: middle;
			padding: 10px;
		}
		p.loadingSpinner.big {
			font-size: 18px;
			text-align: center;
		}
		.spinner-wave {
			margin: 0 auto 5px;
			width: 90px;
			height: 30px;
			text-align: center;
		}
		.spinner-wave-med {
			margin: 0 auto 5px;
			width: 110px;
			height: 40px;
			text-align: center;
		}
		.spinner-wave-big {
			margin: 0 auto 5px;
			width: 130px;
			height: 50px;
			text-align: center;
		}
		.spinner-wave-med>div, .spinner-wave>div {
			background-color: #E11937;
			height: 100%;
			width: 8px;
			margin-right: 8px;
			display: inline-block;
			-webkit-animation: wave 1.2s infinite ease-in-out;
			animation: wave 1.2s infinite ease-in-out;
		}
		.spinner-wave-big>div {
			background-color: #E11937;
			height: 100%;
			width: 12px;
			margin-right: 10px;
			display: inline-block;
			-webkit-animation: wave 1.2s infinite ease-in-out;
			animation: wave 1.2s infinite ease-in-out;
		}
		.spinner-wave div:nth-child(2), .spinner-wave-med div:nth-child(2), .spinner-wave-big div:nth-child(2) {
			-webkit-animation-delay: -1.1s;
			animation-delay: -1.1s;
		}
		.spinner-wave div:nth-child(3), .spinner-wave-med div:nth-child(3), .spinner-wave-big div:nth-child(3) {
			-webkit-animation-delay: -1s;
			animation-delay: -1s;
		}
		.spinner-wave div:nth-child(4), .spinner-wave-med div:nth-child(4), .spinner-wave-big div:nth-child(4) {
			-webkit-animation-delay: -.9s;
			animation-delay: -.9s;
		}
		.spinner-wave div:nth-child(5), .spinner-wave-med div:nth-child(5), .spinner-wave-big div:nth-child(5) {
			-webkit-animation-delay: -.8s;
			animation-delay: -.8s;
			margin-right: 0;
		}
		@-webkit-keyframes wave {
			0%, 40%, 100% {
				-webkit-transform: scaleY(0.4);
			}
			20% {
				-webkit-transform: scaleY(1.0);
			}
		}
		@keyframes wave {
			0%, 40%, 100% {
				transform: scaleY(0.4);
				-webkit-transform: scaleY(0.4);
			}
			20% {
				transform: scaleY(1.0);
				-webkit-transform: scaleY(1.0);
			}
		}
</style>