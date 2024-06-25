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
	<footer>
			<ul>
				<li <?php if($fetch_class=='Cust_home' && $fetch_method=='myprofile'){ echo "class='active'"; } ?>>
					<a href="<?php echo base_url(); ?>index.php/Cust_home/myprofile">
						<svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.09146 23.4817C3.8359 24.1389 3.90892 24.869 4.31052 25.4532C4.71212 26.0373 5.33278 26.3659 6.06296 26.3659H23.8795C24.5732 26.3659 25.2303 26.0373 25.6319 25.4532C26.0335 24.869 26.1066 24.1389 25.851 23.4817C23.989 19.0276 19.7174 16.1433 14.9347 16.1433C10.152 16.1433 5.88042 19.0276 4.09146 23.4817Z" fill="#86869D"/>
							<path d="M20.7757 8.47617C20.7757 5.26335 18.1471 2.63469 14.9343 2.63469C11.7214 2.63469 9.09277 5.26335 9.09277 8.47617C9.09277 11.689 11.7214 14.3177 14.9343 14.3177C18.1471 14.3177 20.7757 11.689 20.7757 8.47617Z" fill="#86869D"/>
						</svg>

						<span>My Profile</span>
					</a>
				</li>
				<li <?php if($fetch_method=='mailbox' ||  $fetch_method=='compose' ||  $fetch_method=='readnotifications' ||  $fetch_method=='readnotifications'){ echo "class='active'"; } ?>>
					<a href="<?php echo base_url(); ?>index.php/Cust_home/mailbox">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M24.0671 18.6654C23.9763 18.556 23.8872 18.4466 23.7997 18.3411C22.5965 16.8859 21.8686 16.0076 21.8686 11.888C21.8686 9.75516 21.3584 8.00516 20.3527 6.69266C19.6111 5.72305 18.6087 4.9875 17.2875 4.44391C17.2705 4.43445 17.2553 4.42204 17.2426 4.40727C16.7674 2.81586 15.4669 1.75 14.0002 1.75C12.5335 1.75 11.2336 2.81586 10.7583 4.40562C10.7456 4.41986 10.7307 4.43187 10.714 4.44117C7.63075 5.71047 6.13231 8.1457 6.13231 11.8863C6.13231 16.0076 5.40552 16.8859 4.2013 18.3395C4.1138 18.445 4.02466 18.5522 3.93388 18.6637C3.69938 18.9466 3.5508 19.2906 3.50573 19.6552C3.46067 20.0198 3.521 20.3897 3.67958 20.7211C4.017 21.432 4.73614 21.8734 5.557 21.8734H22.4494C23.2665 21.8734 23.9807 21.4326 24.3192 20.7249C24.4785 20.3935 24.5394 20.0233 24.4947 19.6582C24.45 19.2932 24.3016 18.9487 24.0671 18.6654Z" fill="#86869D"/>
							<path d="M14.001 26.365C14.7913 26.3644 15.5666 26.1499 16.2448 25.7442C16.9231 25.3386 17.4788 24.757 17.8532 24.061C17.8709 24.0277 17.8796 23.9903 17.8785 23.9526C17.8775 23.9149 17.8667 23.8781 17.8472 23.8458C17.8277 23.8135 17.8002 23.7868 17.7673 23.7682C17.7345 23.7497 17.6974 23.74 17.6596 23.74H10.3435C10.3058 23.7399 10.2686 23.7495 10.2357 23.768C10.2027 23.7865 10.1751 23.8132 10.1556 23.8456C10.136 23.8779 10.1252 23.9147 10.1241 23.9525C10.123 23.9902 10.1317 24.0276 10.1494 24.061C10.5238 24.7569 11.0794 25.3385 11.7575 25.7441C12.4356 26.1497 13.2109 26.3643 14.001 26.365Z" fill="#86869D"/>
						</svg>

						<span>Notifications</span>
					</a>
				</li>
				<li <?php if($fetch_method=='front_home'){ echo "class='active'"; } ?>>
					<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home">
						<svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M21.4469 8.36543V8.20169C21.4469 7.43272 22.0633 6.80936 22.8355 6.80936C23.6023 6.80936 24.224 7.42489 24.224 8.20169V10.8304L26.4231 12.7824C27.2511 13.5174 27.0302 14.1132 25.9315 14.1132H24.224V24.982C24.224 25.5342 23.7664 25.9817 23.2286 25.9817H6.70558C6.15585 25.9817 5.7102 25.5356 5.7102 24.982V14.1132H3.99384C2.89435 14.1132 2.67251 13.519 3.50233 12.7824L14.2099 3.27799C14.6257 2.90896 15.2961 2.90571 15.7155 3.27799L21.4469 8.36543ZM17.7442 16.3955V23.1059H21.4469V16.3955H17.7442Z" fill="#86869D"/>
						</svg>

						<span>Dashboard</span>
					</a>
				</li>
				<li <?php if($fetch_method=='MerchantCommunication'){ echo "class='active'"; } ?>>
					<a href="<?php echo base_url(); ?>index.php/Cust_home/MerchantCommunication">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.7104 18.3537C14.4796 18.3708 14.2466 18.3794 14.0115 18.3794C13.7254 18.3794 13.4427 18.3663 13.1633 18.3416C11.7808 18.2191 10.4411 17.7992 9.23607 17.1107C8.03099 16.4222 6.98895 15.4814 6.18131 14.3527C6.16003 14.3224 6.1314 14.2979 6.0981 14.2817C6.06479 14.2655 6.0279 14.2579 5.99089 14.2598C5.95388 14.2618 5.91797 14.273 5.88651 14.2926C5.85506 14.3122 5.8291 14.3395 5.81107 14.3719L1.87357 21.4484C1.72373 21.7219 1.70021 22.05 1.85826 22.3169C1.94053 22.4492 2.05514 22.5584 2.19129 22.6342C2.32744 22.71 2.48065 22.7498 2.63646 22.75H6.90209C7.05068 22.7445 7.19804 22.7788 7.32898 22.8492C7.45991 22.9197 7.56967 23.0238 7.64693 23.1509L9.76115 26.6875C9.83852 26.8187 9.9483 26.9279 10.08 27.0045C10.2116 27.0811 10.3608 27.1226 10.5131 27.125C10.8379 27.107 11.1743 26.8959 11.3094 26.6L14.9247 18.6621C14.9404 18.6276 14.9467 18.5897 14.9433 18.552C14.9399 18.5143 14.9267 18.4781 14.9051 18.4471C14.8835 18.416 14.8542 18.391 14.8201 18.3747C14.7859 18.3583 14.7481 18.3511 14.7104 18.3537Z" fill="#86869D"/>
							<path d="M26.1204 21.4309L22.2086 14.3669C22.1905 14.3349 22.1647 14.3079 22.1334 14.2885C22.1021 14.2691 22.0665 14.2579 22.0297 14.2559C21.993 14.254 21.9563 14.2613 21.9232 14.2773C21.89 14.2932 21.8614 14.3173 21.84 14.3473C20.7642 15.8545 19.2776 17.0205 17.5574 17.7062C17.3462 17.7894 17.1754 17.9511 17.0806 18.1573L15.0648 22.5925C15.0388 22.6491 15.0254 22.7107 15.0254 22.773C15.0254 22.8352 15.0388 22.8968 15.0648 22.9534L16.7202 26.5951C16.8542 26.8909 17.1899 27.1069 17.5142 27.125C17.6667 27.1212 17.8156 27.0784 17.9468 27.0007C18.0779 26.9229 18.187 26.8128 18.2635 26.6809L20.3706 23.1492C20.5286 22.884 20.8152 22.7484 21.1242 22.75H25.4319C25.7967 22.75 26.0728 22.5597 26.1975 22.2031C26.2413 22.0765 26.2571 21.9419 26.2438 21.8085C26.2305 21.6752 26.1884 21.5464 26.1204 21.4309Z" fill="#86869D"/>
							<path d="M14.0142 11.375C15.4643 11.375 16.6398 10.1997 16.6398 8.75C16.6398 7.30025 15.4643 6.125 14.0142 6.125C12.5642 6.125 11.3887 7.30025 11.3887 8.75C11.3887 10.1997 12.5642 11.375 14.0142 11.375Z" fill="#86869D"/>
							<path d="M14.0146 0.875C9.67137 0.875 6.13965 4.40727 6.13965 8.75C6.13965 13.0927 9.67301 16.625 14.0146 16.625C18.3563 16.625 21.8897 13.0922 21.8897 8.75C21.8897 4.40781 18.3574 0.875 14.0146 0.875ZM14.0146 13.125C13.1494 13.125 12.3035 12.8684 11.584 12.3877C10.8646 11.9069 10.3038 11.2237 9.97268 10.4242C9.64154 9.62481 9.5549 8.74515 9.72371 7.89648C9.89252 7.04781 10.3092 6.26826 10.9211 5.65641C11.5329 5.04455 12.3125 4.62787 13.1611 4.45906C14.0098 4.29025 14.8895 4.37689 15.6889 4.70803C16.4883 5.03916 17.1716 5.59992 17.6523 6.31938C18.1331 7.03885 18.3897 7.88471 18.3897 8.75C18.3882 9.90988 17.9268 11.0218 17.1066 11.842C16.2865 12.6622 15.1745 13.1236 14.0146 13.125Z" fill="#86869D"/>
							</svg>

						<span>Benefits</span>
					</a>
				</li>
				
			</ul>
		</footer>
	</div>



	<!--Main jQuery-->
   <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
   <!--Bootstrap Min JS-->
   <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
   <!--custom JS-->
   <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
   
   
   
</body>
</html>