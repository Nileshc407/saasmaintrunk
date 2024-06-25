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
					/* echo "-------Logged_user_id-------".$Logged_user_id."--<br>";
					echo "-------access-------".$access."--<br>";
					echo "-------Partner_company_flag-------".$Partner_company_flag."--<br>"; */
					
					if(($Logged_user_id == 3 && $data['Company_id'] == 1) || ($Logged_user_id == 3 && $Partner_company_flag == 1)){
						
						
					}
					else if( ($Logged_user_id == 3 && $data['Company_id'] != 1) || $Logged_user_id == 4 ){				
						
						
						
					} else {
						
						// echo "-------Logged_user_id-------".$Logged_user_id."--<br>";
						
						$level_0_menu = $ci_object->Menu_model->get_assigned_level_0_menu($Enrollement_id,$data['Company_id']);
						// print_r($level_0_menu);
						if($level_0_menu != NULL) {
							
							foreach($level_0_menu as $level_0) {
								
								$Current_menu_href = $home_controller."/".$Current_controller;
								$results = $ci_object->Menu_model->edit_menu($level_0->Menu_id);
								$check_menu_parent = $ci_object->Menu_model->check_menu_parent($level_0->Menu_id);
								
								//echo"<br>---level_0_menu-----".$results->Menu_name;
								
								?>
								<li class="has-sub-menu">
									<a href="<?php echo $results->Menu_href; ?>">
										<div class="icon-w">
										  <div class="os-icon os-icon-layout"></div>
										</div>
										<span><?php echo $results->Menu_name; ?></span>
									</a>								 
								
								<?php
								if((isset($_SESSION["Set_Membership_id"])) && ($Allow_membershipid_once==1)){
									// echo "here 1";
									if($check_menu_parent > 0) {
										
										$level_1_menu = $ci_object->Menu_model->get_assigned_level_1_menu($Enrollement_id,$data['Company_id'],$level_0->Menu_id);				
										$menu_details_from_href = $ci_object->Menu_model->get_menu_details_from_href($data['Company_id'],$Current_menu_href);
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
												<ul class="sub-menu">
													<li>											
													<?php
													
														foreach($level_1_menu as $level_1)
														{
															$results2 = $ci_object->Menu_model->edit_menu($level_1->Menu_id);
															$check_menu_parent2 = $ci_object->Menu_model->check_assigned_menu_parent($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
															// echo"<br>---check_menu_parent2-----".$check_menu_parent2;
															if($check_menu_parent2 > 0)
															{
																$level_2_menu = $ci_object->Menu_model->get_assigned_level_2_menu($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																
																?>	
																	
																	
																	<?php
																	
																		
																		/* foreach($level_2_menu as $level_2_menu)
																		{
																			$results3 = $ci_object->Menu_model->edit_menu($level_2_menu->Menu_id);
																			?>
																			 
																				<a href="<?php echo base_url()?>index.php/<?php echo $results3->Menu_href; ?>"><?php echo $results3->Menu_name; ?></a>
																				
																			<?php 
																		} */
																	
																	?>
															<?php
															}
															else
															{	
																?>
																
																<a href="<?php echo base_url()?>index.php/<?php echo $results2->Menu_href; ?>">
																	<?php echo $results2->Menu_name; ?>
																</a>	
																	
																<?php
															}
														}
														?>
													</li>
												</ul>
												<ul class="sub-menu">
													<li>
														<?php
													
														foreach($level_1_menu as $level_1)
														{
															$results2 = $ci_object->Menu_model->edit_menu($level_1->Menu_id);
															$check_menu_parent2 = $ci_object->Menu_model->check_assigned_menu_parent($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
															// echo"<br>---check_menu_parent2-----".$check_menu_parent2;
															if($check_menu_parent2 > 0)
															{
																$level_2_menu = $ci_object->Menu_model->get_assigned_level_2_menu($Enrollement_id,$data['Company_id'],$level_1->Menu_id);
																
															?>	
																		
																	<?php
																	
																		
																		foreach($level_2_menu as $level_2_menu)
																		{
																			$results3 = $ci_object->Menu_model->edit_menu($level_2_menu->Menu_id);
																			$Level2_array_url[]=$results3->Menu_href;
																			$Level2_array_Menu[]=$results3->Menu_name;
																			
																			?>
																			 
																				<a href="<?php echo base_url()?>index.php/<?php echo $results3->Menu_href; ?>"><?php echo $results3->Menu_name; ?></a>
																				
																			<?php 
																		}																	
																	?>
															<?php
															}
															/* else
															{	
																?>
																
																<a href="<?php echo base_url()?>index.php/<?php echo $results2->Menu_href; ?>">
																	<?php echo $results2->Menu_name; ?>
																</a>	
																	
																<?php
															} */
														}
														?>														
													</li>
													
												</ul>
											</div>
										</div>
												
												
									<?php
									}
									else
									{
									
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