<?php
		$home_controller = $this->router->fetch_class();
		$Current_controller = $this->router->fetch_method();
		$session_data = $this->session->userdata('logged_in');
		$Super_seller = $session_data['Super_seller'];
		$Logged_user_id = $session_data['userId'];
		$Enrollement_id = $session_data['enroll'];
		$data['Company_id'] = $session_data['Company_id'];
		$Allow_membershipid_once = $session_data['Allow_membershipid_once'];
		$ci_object = &get_instance();
		$ci_object->load->model('Igain_model');
		$ci_object->load->model('Menu/Menu_model');
		$Company_details = $ci_object->Igain_model->get_company_details($data['Company_id']);
		$user_details = $ci_object->Igain_model->get_enrollment_details($Enrollement_id);

		$user_company_id = $user_details->Company_id;
		$access = 1;
		if($Logged_user_id == 1)
		{
			redirect('Home/logout', '');	
		}
		if($Logged_user_id == 4 && $user_company_id == $data['Company_id'])
		{
			$access = 0;
		}
		$Partner_company_flag = $Company_details->Partner_company_flag;
		$Parent_company = $Company_details->Parent_company;


		?>
			<ul class="main-menu">
			<?php 
				if($access == 1)
				{					
					// echo "-------Logged_user_id-------".$Logged_user_id."--<br>";
					// echo "-------access-------".$access."--<br>";
					// echo "-------Partner_company_flag-------".$Partner_company_flag."--<br>";
					
					
					if(($Logged_user_id == 3 && $data['Company_id'] == 1) || ($Logged_user_id == 3 && $Partner_company_flag == 1)){
						
						// echo"<br>-----Condition--1---"; 
					?>
						<li class="selected has-sub-menu">
						  <a href="<?php echo base_url();?>">
							<div class="icon-w">
							  <div class="os-icon os-icon-layout"></div>
							</div>
							<span>Dashboard</span></a>
						 
						</li>
						<li class="has-sub-menu">
							  <a href="#">
								<div class="icon-w">
								  <div class="os-icon os-icon-layers"></div>
								</div>
								<span>Enrollment</span></a>
							  <div class="sub-menu-w">
								<div class="sub-menu-header">
								  Enrollment
								</div>
								<div class="sub-menu-icon">
								  <i class="os-icon os-icon-layers"></i>
								</div>
								<div class="sub-menu-i">
								  <ul class="sub-menu">
									<li>
									  <a href="<?php echo base_url();?>index.php/Enrollmentc/enrollment">Enroll User</a>
									</li>
									<li>
									  <a href="<?php echo base_url();?>index.php/Enrollmentc/fastenroll">Quick Enrollment</a>
									</li>
									<li>
									  <a href="<?php echo base_url();?>index.php/Enrollmentc/asign_membership">Assign Membership</a>
									</li>
								  </ul>
								</div>
							  </div>
							</li>
							<li class=" has-sub-menu">
								  <a href="#">
									<div class="icon-w">
									  <div class="os-icon os-icon-package"></div>
									</div>
									<span>Transaction</span></a>
								  <div class="sub-menu-w">
									<div class="sub-menu-header">
									  Transaction
									</div>
									<div class="sub-menu-icon">
									  <i class="os-icon os-icon-package"></i>
									</div>
									<div class="sub-menu-i">
									  <ul class="sub-menu">
										<li>
										  <a href="<?php echo base_url();?>index.php/Transactionc/loyalty_transaction">Perform Loyalty Transaction</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Transactionc/issue_bonus">Perform Credit Transaction</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Transactionc/Debit_transaction">Perform Debit Transaction</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Generate_debit_trans_invoice">Generate Debit Transaction Invoice</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Transactionc/redeem">Perform Redeem Transaction</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Transactionc/assign_giftcard">Assign Gift Card</a>
										</li>
										</ul>
										<ul class="sub-menu">
											<li>
											   <a href="<?php echo base_url();?>index.php/Transactionc/transact_giftcard">Perform Gift Card Transaction</a>
											</li>
											<li>
											   <a href="<?php echo base_url();?>index.php/Generate_Invoice">Generate Merchant Invoice</a>
											</li>
											<li>
											   <a href="<?php echo base_url();?>index.php/Settlement/Merchant_settlement">Merchant Loyalty Transaction Settlement</a>
											</li>
											<li>
											  <a href="<?php echo base_url();?>index.php/Payment_to_partner">Partner Settlement</a>
											</li>
											<li>
											  <a href="<?php echo base_url();?>index.php/Settlement/Merchant_debit_settlement">Merchant Debit Transaction Settlement</a>
											</li>
											
										</ul>
										<ul class="sub-menu">
											<li>
											   <a href="<?php echo base_url();?>index.php/Enrollement_data_transform/upload_data">Data Upload - Enrollment</a>
											</li>
											<li>
											   <a href="<?php echo base_url();?>index.php/Data_transform/upload_data">Data Upload - Transaction</a>
											</li>
											
										</ul>
									</div>
								  </div>
							</li>
							<li class=" has-sub-menu">
								<a href="<?php echo base_url();?>">
									<div class="icon-w">
									  <div class="os-icon os-icon-file-text"></div>
									</div>
									<span>Campaign & Offers </span>
								</a>
								<div class="sub-menu-w">
									<div class="sub-menu-header">
									  Campaign & Offers 
									</div>
									<div class="sub-menu-icon">
									  <i class="os-icon os-icon-file-text"></i>
									</div>
									<div class="sub-menu-i">
									  <ul class="sub-menu">
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/loyalty_rule">Create Loyalty Rule</a>
										</li>
										<li>
											<a href="<?php echo base_url();?>index.php/Administration/referral_rule">Create Referral Rule</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/create_promo_campaign">Create Promotion Rule</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/offer_rule">Create Offer Rule</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/auction">Create Auction</a>
										</li>
										</ul><ul class="sub-menu">
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/approve_auction">Approve Auction</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/communication">Draft & Send Communication</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Survey/surveysend">Send Survey to Customer</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Administration/SMS_communication">Draft & Send Offer (SMS)</a>
										</li>
									  </ul>
									</div>
								</div>
							</li>
							<li class=" has-sub-menu">
							  <a href="<?php echo base_url();?>">
								<div class="icon-w">
								  <div class="os-icon os-icon-life-buoy"></div>
								</div>
								<span>Master Setup</span></a>
							  <div class="sub-menu-w">
								<div class="sub-menu-header">
								  Master Setup
								</div>
								<div class="sub-menu-icon">
								  <i class="os-icon os-icon-life-buoy"></i>
								</div>
								<div class="sub-menu-i">
									<ul class="sub-menu">
										<li>
										  <a href="<?php echo base_url();?>index.php/Company/create_company">Company Master</a>
										</li>
										<li>
										  <a href="<?php echo base_url();?>index.php/Masterc/usertype">User Type</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Masterc/paymenttype">Payment Type</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Masterc/currency">Currency</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Menu/create_menu">Create / Edit Menu</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Menu/assign_additional_menu">Assign Additional Menus to Company</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Gamec/game_setup">Game Setup</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Company/Create_beneficiary_company">Register Loyalty Publishers</a>
										</li>
										<li>
										   <a href="<?php echo base_url();?>index.php/Menu/assign_menu">Assign Menus to Users</a>
										</li>
									</ul>
									<ul class="sub-menu">									
										<li> <a href="<?php echo base_url();?>index.php/Masterc/merchant_category">Create Merchant Category</a></li>
										<li> <a href="<?php echo base_url();?>index.php/CatalogueC/Register_Merchandize_Partners">Register Company Merchandize Partners</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/CatalogueC/Create_Merchandize_Partner_Branch">Create Branches for Merchandize Partners</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/E_commerce/create_product_group">Create / Edit Product Group</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/E_commerce/create_product_brand">Create / Edit Product Brand</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/CatalogueC/Create_Merchandize_Category">Create Merchandize Catalogue Category </a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/CatalogueC/Create_Merchandize_Items">Create Merchandize Catalogue Items</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/Gamec/company_game_configuration">Company Game Configuration</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/Gamec/company_game_campaign">Game Campaign</a> </li>									
									</ul>
									<ul class="sub-menu">									
										<li> <a href="<?php echo base_url();?>index.php/Data_transform/data_map">Data Map - Transaction</a></li>
										<li> <a href="<?php echo base_url();?>index.php/Data_transform/upload_data">Data Upload - Transaction</a></li>
										<li> <a href="<?php echo base_url();?>index.php/Survey/survey_multiple_choices">Survey Multiple Choice Structure</a> </li>
										<li> <a href="<?php echo base_url();?>index.php/Survey/surveystructure">Create / Edit Survey Structure</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/Survey/surveyquestion">Create / Edit Survey Questions</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/Masterc/CodeDecodeType">Create Code Decode Type</a> </li>									
										<li> <a href="<?php echo base_url();?>index.php/Masterc/CodeDecode">Create Code Decode</a> </li>									
																			
																			
																		
									</ul>
									
								</div>
							  </div>
							</li>
							<li class=" has-sub-menu">
								<a href="<?php echo base_url();?>">
									<div class="icon-w">
									  <div class="os-icon os-icon-file-text"></div>
									</div>
									<span>Redemption Fullfilment </span>
								</a>
								<div class="sub-menu-w">
									<div class="sub-menu-header">
									  Redemption Fullfilment 
									</div>
									<div class="sub-menu-icon">
									  <i class="os-icon os-icon-file-text"></i>
									</div>
									<div class="sub-menu-i">
									<ul class="sub-menu">
										<li> <a href="<?php echo base_url();?>index.php/CatalogueC/Validate_EVoucher">Validate e-Voucher (at Partner Branch)</a> </li>
									</ul>
									</div>
								</div>
							</li>
							<li class=" has-sub-menu">
								<a href="<?php echo base_url();?>">
									<div class="icon-w">
									  <div class="os-icon os-icon-file-text"></div>
									</div>
									<span>Reports </span>
								</a>
								<div class="sub-menu-w">
									<div class="sub-menu-header">
									  Reports 
									</div>
									<div class="sub-menu-icon">
									  <i class="os-icon os-icon-file-text"></i>
									</div>
									<div class="sub-menu-i">
										<ul class="sub-menu">									
											<li> <a href="<?php echo base_url();?>index.php/Reportc/merchant_report">Merchant Report</a></li>
											<li> <a href="<?php echo base_url();?>index.php/Reportc/customer_report">Customer Report</a></li>
											<li> <a href="<?php echo base_url();?>index.php/Reportc/inactive_users_report">Inactive Users</a> </li>
											<li> <a href="<?php echo base_url();?>index.php/Reportc/customer_visits_report">Customer Visit Report</a> </li>									
											<li> <a href="<?php echo base_url();?>index.php/Reportc/Customer_Redemption_Report">Member Redemption Report</a> </li>									
											<li> <a href="<?php echo base_url();?>index.php/Reportc/Partner_Redemption_Report">Partner Redemption Report</a> </li>									
											<li> <a href="<?php echo base_url();?>index.php/Survey/surveyanalysis">Survey Report</a> </li>
										</ul>
									</div>
								</div>
							</li>
								
						
					<?php 
					
					} else if( ($Logged_user_id == 3 && $data['Company_id'] != 1) || $Logged_user_id == 4 ){				
						
						// echo"<br>-----Condition--2---"; 
						$level_0_menu = $ci_object->Menu_model->get_company_assigned_level_0_menu($data['Company_id']);
						if($level_0_menu != NULL) {							
							foreach($level_0_menu as $level_0) {
								
								$Current_menu_href = $home_controller."/".$Current_controller;
								$results = $ci_object->Menu_model->edit_menu($level_0->Menu_id);
								$check_menu_parent = $ci_object->Menu_model->check_menu_parent($level_0->Menu_id);
								
								//echo"<br>---level_0_menu-----".$results->Menu_href;
								
								?>
								<li class="has-sub-menu">
									<a href="<?php echo $results->Menu_href; ?>">
										<div class="icon-w">
										  <div class="os-icon os-icon-layout"></div>
										</div>
										<span><?php echo $results->Menu_name; ?></span>
									</a>
									<?php
								
								
									
									// echo"<br>-----Condition--2--2-"; 	
									
									if($check_menu_parent > 0)
									{
										$level_1_menu = $ci_object->Menu_model->get_company_assigned_level_1_menu($data['Company_id'],$level_0->Menu_id);
										$Current_menu_href = $home_controller."/".$Current_controller;										
										$menu_details_from_href = $ci_object->Menu_model->get_menu_details_from_href($data['Company_id'],$Current_menu_href);
										?>
										<div class="sub-menu-w">											
											<div class="sub-menu-header">											  
												<?php echo $results->Menu_name; ?>
											</div>
											<div class="sub-menu-icon">
											  <i class="os-icon os-icon-life-buoy"></i>
											</div>
											<div class="sub-menu-i">
																							
													<?php	
														$Level_1_array_url=array();
														$Level_1_array_Menu=array();
														
														$Level_2_array_url=array();
														$Level_2_array_Menu=array();
														foreach($level_1_menu as $level_1)
														{
															$results2 = $ci_object->Menu_model->edit_menu($level_1->Menu_id);
															$check_menu_parent2 = $ci_object->Menu_model->check_menu_parent($level_1->Menu_id);
															if($check_menu_parent2 > 0)
															{
																$level_2_menu = $ci_object->Menu_model->get_company_assigned_level_2_menu($data['Company_id'],$level_1->Menu_id);
																		
																		foreach($level_2_menu as $level_2_menu)
																		{
																			$results3 = $ci_object->Menu_model->edit_menu($level_2_menu->Menu_id);
																			
																			$Level_2_array_url[]=$results3->Menu_href;
																			$Level_2_array_Menu[]=$results3->Menu_name;
																		}																	
																	
															}
															else
															{	
														
																$Level_1_array_url[]=$results2->Menu_href;
																$Level_1_array_Menu[]=$results2->Menu_name;
															}
														}
														?>														
													
													<?php 
													$New_1_2_Level_Menu_array=array();
													$New_1_2_Level_url_array=array();
													
													
													$New_1_2_Level_Menu_array=array_merge($Level_1_array_Menu,$Level_2_array_Menu);
													$New_1_2_Level_url_array=array_merge($Level_1_array_url,$Level_2_array_url);
													
													$count = 1;
													for($i=0; $i < count($New_1_2_Level_Menu_array); $i++ ){
														// echo"<br>Menu_name----".$New_1_2_Level_Menu_array[$i]."---Menu_href----".$New_1_2_Level_url_array[$i];
														if($count%10 == 1)
														{  
															 echo "<ul class=\"sub-menu\">";
														}
														echo"<li><a href=". base_url()."index.php/".$New_1_2_Level_url_array[$i]. ">
																	".$New_1_2_Level_Menu_array[$i]."
																</a></li>";																
														if ($count%10 == 0)
														{
															echo "</ul>";
														}
														$count++;
													}
													if ($count%10 != 1) echo "</ul>";												
												?>
											</div>											
										</div>
									<?php
									}
									?>
								
								
									
								
								</li>
								<?php
							}									
						}
						
					} else {
						
						// echo"<br>-----Condition--3---"; 
						
						$level_0_menu = $ci_object->Menu_model->get_assigned_level_0_menu($Enrollement_id,$data['Company_id']);				
						if($level_0_menu != NULL) {
							
							foreach($level_0_menu as $level_0) {
								
								$Current_menu_href = $home_controller."/".$Current_controller;
								$results = $ci_object->Menu_model->edit_menu($level_0->Menu_id);
								$check_menu_parent = $ci_object->Menu_model->check_menu_parent($level_0->Menu_id);
								
								// echo "---Menu_href---".$results->Menu_href."---Menu_name---".$results->Menu_name."---<br>";
								
								// echo "---Menu_name---".$results->Menu_name."---<br>";
								if($results->Menu_name=="Dashboard"){
									
									$class="icon-feather-pie-chart";
									
								} else if($results->Menu_name=="Enrollment"){
									
									$class="os-icon os-icon-users";
									
								} else if($results->Menu_name=="Transaction"){
									
									$class="os-icon os-icon-edit-32";
									
								} else if($results->Menu_name=="Campaign & Offers"){
									
									$class="os-icon os-icon-grid";
									
								} else if($results->Menu_name=="Master Setup"){
									
									$class="icon-feather-layers";
									
								} else if($results->Menu_name=="Fullfilment"){
									
									$class="icon-feather-truck";
									
								} else if($results->Menu_name=="Call Center"){
									
									$class="icon-feather-headphones";
									
								} else if($results->Menu_name=="Reports"){
									
									$class="os-icon os-icon-file-text";
								}
								
								
								// echo $results->Menu_href; 
								?>
								<li class="has-sub-menu">
									<a href="<?php echo base_url(); ?>index.php/Home">
										<div class="icon-w">
										  <div class="<?php echo $class; ?>"></div>
										</div>
										<span><?php echo $results->Menu_name; ?></span>
									</a>								 
								
									<?php
									if((isset($_SESSION["Set_Membership_id"])) && ($Allow_membershipid_once==1)){
									// echo "here 1";
										if($check_menu_parent > 0)
										{
											$level_1_menu = $ci_object->Menu_model->get_assigned_level_1_menu($Enrollement_id,$data['Company_id'],$level_0->Menu_id);				
											$menu_details_from_href = $ci_object->Menu_model->get_menu_details_from_href($data['Company_id'],$Current_menu_href);
											?>
											<div class="sub-menu-w">											
												<div class="sub-menu-header">											  
													<?php echo $results->Menu_name; ?>
												</div>
												<div class="sub-menu-icon">
												  <i class="os-icon os-icon-life-buoy"></i>
												</div>
												<div class="sub-menu-i">
																								
														<?php	
															$Level_1_array_url=array();
															$Level_1_array_Menu=array();
															
															$Level_2_array_url=array();
															$Level_2_array_Menu=array();
															foreach($level_1_menu as $level_1)
															{
																$results2 = $ci_object->Menu_model->edit_menu($level_1->Menu_id);
																$check_menu_parent2 = $ci_object->Menu_model->check_assigned_menu_parent($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																// echo"<br>---check_menu_parent2-----".$check_menu_parent2;
																if($check_menu_parent2 > 0)
																{
																	$level_2_menu = $ci_object->Menu_model->get_assigned_level_2_menu($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																			
																			foreach($level_2_menu as $level_2_menu)
																			{
																				$results3 = $ci_object->Menu_model->edit_menu($level_2_menu->Menu_id);
																				
																				$Level_2_array_url[]=$results3->Menu_href;
																				$Level_2_array_Menu[]=$results3->Menu_name;
																			}																	
																		
																}
																else
																{	
															
																	$Level_1_array_url[]=$results2->Menu_href;
																	$Level_1_array_Menu[]=$results2->Menu_name;
																}
															}
															?>														
														
													<?php 
														$New_1_2_Level_Menu_array=array();
														$New_1_2_Level_url_array=array();
														
														
														$New_1_2_Level_Menu_array=array_merge($Level_1_array_Menu,$Level_2_array_Menu);
														$New_1_2_Level_url_array=array_merge($Level_1_array_url,$Level_2_array_url);
														
														$count = 1;
														for($i=0; $i < count($New_1_2_Level_Menu_array); $i++ ){
															// echo"<br>Menu_name----".$New_1_2_Level_Menu_array[$i]."---Menu_href----".$New_1_2_Level_url_array[$i];
															if($count%10 == 1)
															{  
																 echo "<ul class=\"sub-menu\">";
															}
															echo"<li><a href=". base_url()."index.php/".$New_1_2_Level_url_array[$i]. ">
																		".$New_1_2_Level_Menu_array[$i]."
																	</a></li>";																
															if ($count%10 == 0)
															{
																echo "</ul>";
															}
															$count++;
														}
														if ($count%10 != 1) echo "</ul>";												
													?>
												</div>
												
												
											</div>
													
													
										<?php
										}
									}
									if(((!isset($_SESSION["Set_Membership_id"]))) || ($Allow_membershipid_once==0) ){
										// echo "here 2";
									
										if($check_menu_parent > 0)
										{
											$level_1_menu = $ci_object->Menu_model->get_assigned_level_1_menu($Enrollement_id,$data['Company_id'],$level_0->Menu_id);				
											$menu_details_from_href = $ci_object->Menu_model->get_menu_details_from_href($data['Company_id'],$Current_menu_href);
											?>
											<div class="sub-menu-w">											
												<div class="sub-menu-header">											  
													<?php echo $results->Menu_name; ?>
												</div>
												<div class="sub-menu-icon">
												  <i class="os-icon os-icon-life-buoy"></i>
												</div>
												<div class="sub-menu-i">
																								
														<?php	
															$Level_1_array_url=array();
															$Level_1_array_Menu=array();
															
															$Level_2_array_url=array();
															$Level_2_array_Menu=array();
															
															
															foreach($level_1_menu as $level_1)
															{
																$results2 = $ci_object->Menu_model->edit_menu($level_1->Menu_id);
																$check_menu_parent2 = $ci_object->Menu_model->check_assigned_menu_parent($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																
																// echo"---check_menu_parent2-----".$check_menu_parent2."---<br>";
																
																
																if($check_menu_parent2 > 0)
																{
																	$level_2_menu = $ci_object->Menu_model->get_assigned_level_2_menu($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																			
																		// echo"<br>---Menu_level---1--".$results2->Menu_name;	

																		$Level_1_array_url[]=$results2->Menu_href;
																		$Level_1_array_Menu[]=$results2->Menu_name;																	
																	
																	foreach($level_2_menu as $level_2_menu)
																	{
																		$results3 = $ci_object->Menu_model->edit_menu($level_2_menu->Menu_id);						

																		// echo"<br>---Menu_level---2--".$results3->Menu_name;																		
																		/* $Level_2_array_url[]=$results3->Menu_href;
																		$Level_2_array_Menu[]=$results3->Menu_name; */
																		
																		$Level_1_array_url[]=$results3->Menu_href;
																		$Level_1_array_Menu[]=$results3->Menu_name;
																	}																	
																		
																}
																else
																{	
																	
																	// echo"<br>---Menu_level---1--".$results2->Menu_name;
																	
																	$Level_1_array_url[]=$results2->Menu_href;
																	$Level_1_array_Menu[]=$results2->Menu_name;
																}
															}
															?>														
														
													<?php 
														$New_1_2_Level_Menu_array=array();
														$New_1_2_Level_url_array=array();
														
														// echo"-----Level_1_array_Menu-----<br>";
														// print_r($Level_1_array_Menu);
														// echo"-----Level_2_array_Menu-----<br>";
														// print_r($Level_2_array_Menu);
														
														// $New_1_2_Level_Menu_array=array_merge($Level_1_array_Menu,$Level_2_array_Menu);
														// $New_1_2_Level_url_array=array_merge($Level_1_array_url,$Level_2_array_url);
														
														// print_r($New_1_2_Level_Menu_array);
														
														$count = 1;
														for($i=0; $i < count($Level_1_array_url); $i++ ){
															
															// echo"<br>Menu_name----".$Level_1_array_Menu[$i]."---Menu_href----".$Level_1_array_url[$i];															
															
															// $menu_details_href = $ci_object->Menu_model->get_menu_details_from_href($New_1_2_Level_url_array[$i]);													
															// print_r($menu_details_href);
					
															if($count%12 == 1)
															{  
																 echo "<ul class=\"sub-menu\">";
															}
															if($Level_1_array_url[$i]=="#") {
																
																/* echo"<b class='text-center' style='color:red'> ".$Level_1_array_Menu[$i]."</b>"; */
																
																/* echo"<li class=\"text-center\" style\"background-color:#9c2c2c\"><a href=\"JavaScript:void(0)\" style=\"background-color:#9c2c2c;color:yellow\">
																		".$Level_1_array_Menu[$i]."
																	</a></li>";	 */
																	
																echo"<div class=\"sub-menu-header\"  style=\"padding: 5px 10px;font-size:20px;margin-bottom: 0px;\"> ".$Level_1_array_Menu[$i]." </div>";
																	
															} else {
																
																echo"<li><a href=". base_url()."index.php/".$Level_1_array_url[$i]. " style=\"padding:2px 2px 2px 33px;\">
																		".$Level_1_array_Menu[$i]."
																	</a></li>";														
																	
															}
																
																	
															if ($count%12 == 0)
															{
																echo "</ul>";
															}
															$count++;
														}
														if ($count%12 != 1) echo "</ul>";												
													?>
												</div>											
											</div>
										<?php
										}								
									}
								?>
								</li>
								<?php
							}									
						}				
						
					}
				}
			?>
		</ul>		
		
	<style>
.sub-menu-header{
	color: rgb(153, 225, 244) !important;
}	
	</style>	