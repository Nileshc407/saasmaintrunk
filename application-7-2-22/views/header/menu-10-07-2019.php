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
	
	
	
	
	
	
	
	
	
	
	
	
	
												<div class="sub-menu-w">
													<div class="sub-menu-header">
													  <?php echo $results->Menu_name; ?>
													</div>
													<div class="sub-menu-icon">
													  <i class="os-icon os-icon-layers"></i>
													</div>
													<div class="sub-menu-i">	
														
														<ul class="sub-menu">															
															<li>
															  <a href="layouts_menu_side_full.html">Side Menu Light</a>
															</li>
															<li>
															  <a href="layouts_menu_side_full_dark.html">Side Menu Dark</a>
															</li>
															<li>
															  <a href="layouts_menu_side_transparent.html">Side Menu Transparent <strong class="badge badge-danger">New</strong></a>
															</li>
															<li>
																<div class="sub-menu-header">
																  Menu 1
																</div>
															</li>
															<li>
															  <a href="apps_projects.html">Side &amp; Top</a>
															</li>
															<li>
															  <a href="layouts_menu_side_mini.html">Mini Side Menu</a>
															</li>
														</ul>
														
														<ul class="sub-menu">														
															<li>
															  <a href="layouts_menu_side_full.html">Side Menu Light</a>
															</li>
															<li>
															  <a href="layouts_menu_side_full_dark.html">Side Menu Dark</a>
															</li>
															<li>
															  <a href="layouts_menu_side_transparent.html">Side Menu Transparent <strong class="badge badge-danger">New</strong></a>
															</li>
															<li>
															  <div class="sub-menu-header">
																  Menu 2
																</div>
															</li>
															<li>
															  <a href="apps_projects.html">Side &amp; Top</a>
															</li>
															<li>
															  <a href="layouts_menu_side_mini.html">Mini Side Menu</a>
															</li>
														</ul>														
													</div>
												</div>