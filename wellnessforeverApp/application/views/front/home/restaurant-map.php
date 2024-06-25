<?php 
$this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}
$Photograph=$Enroll_details->Photograph;
if($Photograph=="")
{
	// $Photograph='images/No_Profile_Image.jpg';
	// $Photograph="images/dashboard_profile.png";
	$Photograph=base_url()."assets/images/profile.jpg";
	
} else {
	
	$Photograph=$this->config->item('base_url2').$Photograph;
	
}

	$ci_object = &get_instance(); 
	$ci_object->load->model('Igain_model');
	$ci_object->load->model('shopping/Shopping_model');
	$ci_object->load->helper(array('encryption_val'));
?> 
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url(); ?>index.php/Cust_home/brands"><span>Stores Location</span></a>
				</div>
			</div>
		</div>
	</header>
	
		<div class="custom-body cart_body">
			<div class="cart_link">
				<ul class="nav nav-tabs" role="tablist">
					<li class="item">
						<a class="nav-link active" data-toggle="tab" href="#panal_1">List View</a>
					</li>
					<li class="item">
						<a class="nav-link" data-toggle="tab" href="#panal_2">Map View</a>
					</li>
				</ul>
			</div>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane panal_plan fade show active" id="panal_1">
					<div class="cart_list">
						
						<?php
							$openClose=array();
							$Working_details=array();
							if($Sellerdetails){
								
								
								$Outlet_status_flag=0;
								$Current_time = date("H:i:s");
								$Current_day = date("l");
								$day_of_week = date('N', strtotime($Current_day));
																
								foreach($Sellerdetails as $row)
								{
										
									$Table_no_flag=$row['Table_no_flag'];	
										
									$Current_address=App_string_decrypt($row['Current_address']);
									$Get_city_name = $ci_object->Igain_model->Get_cities($row['State']);
									foreach($Get_city_name as $City)
									{
										if($City->id==$row['City'])
										{
											$City_name=$City->name;
										}
										
									}
									
									$Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($row['Enrollement_id'],$day_of_week);			
								
									// $Get_outlet_working_hours=1;
									
									$openClose[$row['Enrollement_id']]=$Get_outlet_working_hours;
									 
									// echo "--Get_outlet_working_hours--".$row['Enrollement_id']."---".$Get_outlet_working_hours."---<br>";
									 
									if($Get_outlet_working_hours==2)
									{
										$Outlet_status = " :- Closed";
										$Outlet_status_flag =0;								
									}
									else
									{
										$Outlet_status = " :- Open";
										$Outlet_status_flag =1;
										
									}
									
									
										if($Enroll_details->City == $row['City']) {
										?>
										
											<?php if($Outlet_status_flag == 0){?>  
												<div class="notification-check">
													<label>
														
														<span><b><?php echo $row['First_name'].' '.$row['Last_name']; ?></b> <?php //echo $Current_address; ?>-Closed</span>
													</label>
												</div>
											<?php } else { ?> 
													
													
													
													<div class="notification-check">
														<label>
															<input type="radio" id="delivery_outlet" name="delivery_outlet" value="<?php echo $row['Enrollement_id']; ?>" <?php if($_SESSION['delivery_type'] == 107) { ?> onclick="return Go_to_next(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $row['Enrollement_id']; ?>,'<?php echo $row['First_name'].'_'.$row['Last_name'].'_'.$Current_address; ?>',<?php echo $Table_no_flag; ?>);"  <?php } ?>>
															<span><b><?php echo $row['First_name'].' '.$row['Last_name']; ?></b> <?php //echo $Current_address; ?>-Open</span>
														</label>
													</div>
													
											<?php } ?>
											
										<?php } else { ?>
										
												<?php if($Outlet_status_flag == 0){?>  
													<div class="notification-check">
														<label>
															
															<span><b><?php echo $row['First_name'].' '.$row['Last_name']; ?></b> - <?php echo $Current_address; ?>-Closed</span>
														</label>
													</div>
												<?php } else { ?> 
														
														<div class="notification-check">
															<label>
																<input type="radio" id="delivery_outlet" name="delivery_outlet" value="<?php echo $row['Enrollement_id']; ?>" <?php if($_SESSION['delivery_type'] == 107) { ?> onclick="return Go_to_next(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $row['Enrollement_id']; ?>,'<?php echo $row['First_name'].'_'.$row['Last_name'].'_'.$Current_address; ?>',<?php echo $Table_no_flag; ?>);"  <?php } ?>>
																<span><b><?php echo $row['First_name'].' '.$row['Last_name']; ?></b><?php //echo $Current_address; ?> - Open</span>
															</label>
														</div>
														
												<?php } ?>
											
										<?php }
								 
								 
								}
							}
							?>
						
					</div>
				</div>
				<div class="tab-pane map_panel fade show active" id="panal_2">
					<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery.js'></script>
					<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery-migrate.js'></script>
					<link rel="stylesheet" href="<?php echo base_url()?>assets/map_assets/shop_time.css">
					
					<!------- === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== --->
						<script src="https://maps.google.com/maps/api/js?key=AIzaSyD4U1mKm6UducB3tZ3-Fo9NvLxzbkIPk1Y" type="text/javascript"></script>
						<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/gmaps.js'></script>
						<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment.js'></script>
						<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment-timezone-with-data.js'></script>
					<!------- === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== --->
					<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
						<div id="google-map" class="google-map"></div><!-- #google-map -->
					</div>
					
					<!------- === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== --->
						<?php
										// var_dump($Seller_details);
											// echo"---Seller_details-----".count($Seller_details);
											$Working_details = array();
											$locations = array();
											$Current_time = date("H:i:s");
											$Current_day = date("l");
											$day_of_week = date('N', strtotime($Current_day));
											$Outlet_status_flag=0;
											
											foreach($Seller_details as $row) 
											{
												
												$Latitude = $row->Latitude;
												$Longitude = $row->Longitude;
												// $Current_address = $row->Current_address;
												// $name = $row->First_name.' '.$row->Last_name;
												$name = $row->First_name;
												$Enrollement_id = $row->Enrollement_id;
												$Photograph = $row->Photograph;
												$Phone_no = App_string_decrypt($row->Phone_no);
												$timezone = $row->timezone_entry;											
												$Table_no_flag = $row->Table_no_flag;

												/* 
													$str_arr = explode(",",$row->Current_address);
													$str_arr0 =App_string_decrypt($str_arr[0]);
													$str_arr1 =App_string_decrypt($str_arr[1]);
													$str_arr2 =App_string_decrypt($str_arr[2]);
													$str_arr3 =App_string_decrypt($str_arr[3]);
													
													$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3; 
												*/

												$Current_address=App_string_decrypt($row->Current_address);

												
												$Count_Working_HRS = $ci_object->Igain_model->Count_seller_Working_HRS($Enrollement_id);
												// $Count_Working_HRS=1;
												
												// Get_outlet_working_hours
												
												// $Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($Enrollement_id,$day_of_week);
													
												// $Get_outlet_working_hours=1;
												
												// echo"--Get_outlet_working_hours----".$Enrollement_id."--".$Get_outlet_working_hours."-----Count_Working_HRS-----".$Count_Working_HRS."-<br>";
												
												foreach($openClose as $key =>$values){
													
													if($key==$Enrollement_id){
														
														$Outlet_status_flag=$values;
													}
													
												}										
												
												// echo"--Outlet_status_flag--".$Enrollement_id."--".$Outlet_status_flag."-Count_Working_HRS--".$Count_Working_HRS."-<br>";
												
												
												
												
												// $Outlet_status_flag=$Get_outlet_working_hours;
												if($Count_Working_HRS > 0 )
												{
													
													$seller_Working_HRS = $ci_object->Igain_model->Get_seller_Working_HRS($Enrollement_id);
													// var_dump($seller_Working_HRS);
													
													// echo"--seller_Working_HRS----".$seller_Working_HRS."--<br>";
													
													
													
													
													
													foreach($seller_Working_HRS as $WHRS)
													{
														
														
														
														if($WHRS['Day']==1){$Day='Monday';}
														if($WHRS['Day']==2){$Day='Tuesday';}
														if($WHRS['Day']==3){$Day='Wednesday';}
														if($WHRS['Day']==4){$Day='Thursday';}
														if($WHRS['Day']==5){$Day='Friday';}
														if($WHRS['Day']==6){$Day='Saturday';}
														if($WHRS['Day']==7){$Day='Sunday';}											
														$Open_time1=date("g:i a", strtotime($WHRS['Open_time']));			
														$Close_time1=date("g:i a", strtotime($WHRS['Close_time']));
														
														$Workingdetails = array
														(
															"Day" => $Day,
															"Open_time" =>$Open_time1,
															"Close_time" =>$Close_time1,
															"Enrollement_id" =>$Enrollement_id
															
														);
														
														
														$Working_details[] = $Workingdetails;
													
														
													}
													
													// echo"--Workingdetails--".print_r($Working_details)."--<br>";
												}
												else
												{
													$Working_details = "";
												}
												
												$locations[] = array
																(
																	'google_map' => array
																	(
																		'lat' => $Latitude,
																		'lng' => $Longitude,
																	),
																	'location_address' => $Current_address,
																	'location_name'    => $name,
																	'Enrollement_id' => $Enrollement_id, 
																	'Photograph' => $row->Photograph,
																	'Phone_no' => $Phone_no,
																	'timezone' => $timezone,
																	'Working_details' => $Working_details,
																	"Outlet_status_flag" =>$Outlet_status_flag,
																	"Table_no_flag" =>$Table_no_flag
																);
													// echo"--Working_details--".print_r($Working_details)."--<br>";			
												// echo"--locations--".print_r($locations)."--<br>";						
											}
											
											// echo"--Working_details--".print_r($Working_details)."--<br>";
											// echo"--Enrollement_id--".$Enrollement_id."--<br>";
											// echo"--Working_details---11--".print_r($Working_details)."--<br>";
											
										
											
							/* Set Default Map Area Using First Location */
							$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
							$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
							
							
							// die;
						?>
					
				</div>
			</div>
		</div>
		
<?php $this->load->view('front/header/footer');  ?>
<style>
	.cart_link{
		z-index: 1 !IMPORTANT;
	}
</style>
	<!--------For GMAP--------->
	
	<script>
	
		$(document).ready(function(){
			
				setTimeout(function() {
					// alert('here...');
					$("#panal_2").removeClass(" show active");
				}, 3000);
			
			
		});
	</script>
		<script>
  
			var Outlet_name_obj = [];
			var Outlet_address_obj = [];
			 
			 
			var now = new Date();  
			var weekday = new Array(7);
			weekday[0] = "Sunday";
			weekday[1] = "Monday";
			weekday[2] = "Tuesday";
			weekday[3] = "Wednesday";
			weekday[4] = "Thursday";
			weekday[5] = "Friday";
			weekday[6] = "Saturday";
			var today = weekday[now.getDay()];

				// console.log(weekday);

				/* Do not drag on mobile. */

				var is_touch_device = 'ontouchstart' in document.documentElement;

				var map = new GMaps(
				{
					el: '#google-map',
					lat: '<?php echo $map_area_lat; ?>',
					lng: '<?php echo $map_area_lng; ?>',
					scrollwheel: true,
					mapTypeControl: false
				});
				//draggable: ! is_touch_device
				// $("#address").change(function( event )
				$("#searchOutlet").click(function( event )
				{
					
					
					
					var New_bounds = [];    
					var Address = $('#address').val().trim();
					/* console.log('address---'+Address); */
					if(Address == ""){
						
							var msg1 = 'Please enter name or address';
							$('.help-block_currentAddress3').show();
							$('.help-block_currentAddress3').css("color","#5e4103");
							$('.help-block_currentAddress3').css("text-align","left");
							$('.help-block_currentAddress3').css("margin-left","15px");
							$('.help-block_currentAddress3').css("font-size","17px");
							$('.help-block_currentAddress3').html(msg1);
							setTimeout(function(){ $('.help-block_currentAddress3').hide(); }, 3000);
							$( "#address" ).focus();				
							return false;
							
					}
					$('#myModal').modal('show');
					var nm=0;
					var addrs=0;
					$.ajax(
					{
						type: "POST",
						data: { autocomplete:Address, Company_id:'<?php echo $Company_id; ?>' },
						dataType: "json", 
						url: "<?php echo base_url()?>index.php/Cust_home/Get_seller_autocomplete",
						success: function(json)
						{
							$('#myModal').modal('hide');
							
							var Seller_details = json['Seller_details'];
							/* console.log(Seller_details); */
							if(Seller_details != 0)
							{
								var Center_Latitude = json['Center_Latitude'];
								var Center_Longitude = json['Center_Longitude'];
								var Seller_count = json['Seller_count'];				
								nm++;
								addrs++;
								$.each(Seller_details, function( index, value ) 
								{ 			
									var trHtml2 = "";   var WorkingDay2 = new Array();
									var Photograph = value['Photograph'];
									var Phone_no = value['Phone_no'];
									var Outlet_statusflag = value['Outlet_status_flag'];
									var address1 = value['Current_address'];
									var Outlet_name1 = value['Name'];
									var Working_details = value['Working_details'];
									/* console.log("----Outlet_statusflag------"+Outlet_statusflag); */
									if(Photograph=="")
									{
											Photograph1='uploads/user10.jpg';
									}
									else
									{
											Photograph1=Photograph;
									}
									
									// var d = '<?php echo $b; ?>';
									// var add = '<?php echo $add; ?>';
									Outlet_name_obj[nm] = Outlet_name1;		
									Outlet_address_obj[addrs] = address1;	
									
									if(Working_details != "")
									{
										// console.log($Working_details);
										$.each(Working_details, function (index, value2) 
										{        
											var TodayDate2 = value2['Day'];
											if(TodayDate2 === today)
											{
												OpenTime2 = value2['Open_time'];
												Close_time2 = value2['Close_time'];
											}
											WorkingDay2.push(TodayDate2);
										});
										
										
										if(Outlet_statusflag==2)
										{
											/* console.log('Condition 1'); */
											trHtml2 += '<div class="Time_modal"><h2> Currently We\'re not processing online Orders!</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_'+value['Enrollement_id']+'"  href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',1);">+ View Details</a><a style="display:none;" id="HideLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',2);">- View Details</a></p></div>';
										}
										else
										{
											/* console.log('Condition 2'); */
											trHtml2 += '<div class="Time_modal"><h2>Open Today :  '+OpenTime2+' - '+Close_time2+'</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',1);">+ View Details</a><a style="display:none;" id="HideLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',2);">- View Details</a></p></div>';
										}
										
										
										
										//trHtml2 += '<div class="Time_modal"><h2>We are Open On</h2>';
										trHtml2 += '<div class="Time_modal" id="TimeDetails_'+value['Enrollement_id']+'" style="display:none;">';
										$.each(Working_details, function (index, value) 
										{        
											var TodayDate2 = value['Day'];
											var Append_class2 = "";
											if(TodayDate2 == today){Append_class2="today";}
											trHtml2 += '<div class="dateTime"><div class="day '+Append_class2+'">'+value['Day']+'</div><div class="time '+Append_class2+'">'+value['Open_time']+' - '+value['Close_time']+'</div></div><br>';
										});
										trHtml2 += '</div>';
									}
									var Enrollement_id = value['Enrollement_id'];
									/* Set Bound Marker */
									var latlng = new google.maps.LatLng(value['Latitude'], value['Longitude']);
									New_bounds.push(latlng);
									/* Add Marker */
									map.setCenter(Center_Latitude, Center_Longitude);
									/* console.log("----Outlet_statusflag------"+Outlet_statusflag); */
									if(Outlet_statusflag==1) { 
									
										map.addMarker(
										{
											lat: value['Latitude'],
											lng: value['Longitude'],
											title: value['Name'],
											animation: google.maps.Animation.DROP,
											icon: "<?php echo base_url(); ?>assets/images/talisker.png",
											infoWindow:
											{
												
												content: '<p style="font-weight: bold; color: #1a1413;cursor: help;"><a href="javascript:void(0);"><b  style="color: black">&nbsp;&nbsp;&nbsp;&nbsp;SELECT</b><br>'+value['Name']+'</a></p> <p style="color: #1a1413;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo base_url(); ?>assets/images/talisker.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
											}
										});
										
									} else {
										
										map.addMarker(
										{
											lat: value['Latitude'],
											lng: value['Longitude'],
											title: value['Name'],
											animation: google.maps.Animation.DROP,
											icon: "<?php echo base_url(); ?>assets/images/talisker.png",
											infoWindow:
											{
												content: '<p style="font-weight: bold; color: #1a1413;">&nbsp;&nbsp;&nbsp;&nbsp;'+value['Name']+'</p> <p style="color: #1a1413;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo base_url(); ?>assets/images/talisker.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
											}
										});
									}
									
									
								});
								
								if(Seller_count == 1)
								{
									map.setZoom(17);
									// map.setZoom(17);
								}
								
								
								map.fitLatLngBounds(New_bounds);
							}
							else
							{
								alert('No Store Found!');
							}
						}
					});
				});
				
				
				
				
				/* Map Bound */
				var bounds = [];
				
				
			<?php 
			$b = 0;
			$add = 0;
			/* For Each Location Create a Marker. */
			// var_dump($locations);
			foreach($locations as $location )
			{
				$b++;
				$add++;
				$name = $location['location_name'];
				$Photograph = $location['Photograph'];
				$Phone_no = $location['Phone_no'];
				$addr = addslashes($location['location_address']);
				$Enrollement_id = addslashes($location['Enrollement_id']);
				$map_lat = $location['google_map']['lat'];
				$map_lng = $location['google_map']['lng'];
				$Working_details = $location['Working_details'];
				$timezone = $location['timezone'];
				$Outlet_status_flag = $location['Outlet_status_flag'];
				$Table_no_flag = $location['Table_no_flag'];
				?>
				
				var trHtml = "";    
				var OpenTime = "";     
				var CloseTime = "";   
				var Open_close_flag = 0; 
				var WorkingDay = new Array();
				var Merchant_date = moment().tz("<?php echo $timezone; ?>").day();
				var Merchant_curent_day = weekday[Merchant_date];
				var Outlet_status_flag=<?php echo $Outlet_status_flag; ?>;
				var Table_no_flag=<?php echo $Table_no_flag; ?>;
				var name="<?php echo $name; ?>";
				var addr="<?php echo $addr; ?>";
				 // console.log(name);
				// console.log(addr);
				// console.log("--Table_no_flag---"+Table_no_flag); 
				// var Enrollid=<?php echo $Enrollement_id; ?>;
				// console.log("--Enrollid---"+Enrollid); 
				<?php
					if($Photograph== "")
					{
						$Photograph1='uploads/user10.jpg';
					}
					else
					{
						$Photograph1=$Photograph;
					}	
					// var_dump($Working_details);
					if($Working_details != "")
					{
						foreach($Working_details as $WH2)
						{
							
							// echo "----Enrollement_id----".$Enrollement_id."-----Enrollement_id--WH---".$WH2['Enrollement_id']."--------<br>";							
								
							if($Enrollement_id == $WH2['Enrollement_id'])
							{					
								$TodayDate2 = $WH2['Day'];
								
								?>
								
							
								var TodayDate2 = '<?php echo $TodayDate2; ?>';
								// console.log("----TodayDate2----"+TodayDate2);
								// var TodayDate2 = 'Friday';
								// console.log(TodayDate2);
								// console.log(Merchant_curent_day);
								if(TodayDate2 === Merchant_curent_day)
								{
									OpenTime='<?php echo $WH2['Open_time']; ?>';
									CloseTime='<?php echo $WH2['Close_time']; ?>';
								}
								
								// console.log("----OpenTime----"+OpenTime);
								WorkingDay.push(TodayDate2);
								
						<?php
							}
						}
					?>
						// console.log(WorkingDay);
						// console.log(Merchant_curent_day);
						//console.log(WorkingDay.indexOf(Merchant_curent_day));
						// if(WorkingDay.indexOf(Merchant_curent_day) == -1)
						if(Outlet_status_flag==2)
						{
							trHtml += '<div class="Time_modal"><h2> Currently closed !</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>"  href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
						}
						else
						{
							trHtml += '<div class="Time_modal"><h2>Open Today :  '+OpenTime+' - '+CloseTime+'</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
						}
						
						trHtml += '<div class="Time_modal" id="TimeDetails_<?php echo $Enrollement_id; ?>" style="display:none;">';
						
						<?php
						foreach($Working_details as $WH1)
						{
							// echo"--Day----".$WH1['Day']."---<br>";
							if($Enrollement_id == $WH1['Enrollement_id'])
							{
								$TodayDate = $WH1['Day'];
								
								?>
							
									var TodayDate = '<?php echo $TodayDate; ?>';
									// console.log("--TodayDate--"+TodayDate);
									// console.log("--Merchant_curent_day--"+Merchant_curent_day);
									var Append_class = "";
									if(TodayDate == Merchant_curent_day)
									{
										Append_class="today";
									}
									
									trHtml += '<div class="dateTime"><div class="day '+Append_class+'"><?php echo $WH1['Day']; ?></div><div class="time '+Append_class+'"><?php echo $WH1['Open_time']; ?> - <?php echo $WH1['Close_time']; ?></div></div><br>';
						
								<?php
							}
						}
						?>
						
						trHtml += '</div>';
						
					<?php
					}
				?>		
					
					var Enrollement_id = '<?php echo $Enrollement_id; ?>';
					var Working_details = '<?php echo $Working_details; ?>';
					/* Set Bound Marker */
					var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
					bounds.push(latlng);
					/* Add Marker */
					// alert('Add Marker');
					var Outlet_name="<?php echo $name; ?>";
					// var Outlet_name=$("#EnrollementID_"+Enrollement_id).val();
					// var Outlet_name=$("#EnrollementID_4"+Enrollement_id).val();
					
					 // console.log("--Enrollement_id---"+Enrollement_id);
					 // console.log("--Outlet_name---"+Outlet_name);
					/*  console.log("--addr---"+addr);
					 console.log("--Table_no_flag---"+Table_no_flag); */
					
					var d = '<?php echo $b; ?>';
					var add = '<?php echo $add; ?>';
					Outlet_name_obj[d] = Outlet_name;		
					Outlet_address_obj[add] = addr;		
					// console.log(Outlet_name_obj);
					// console.log(Outlet_address_obj);
						
					streetViewControl:false;
					if(Outlet_status_flag == 1) {
						
						map.addMarker(
						{
							lat: <?php echo $map_lat; ?>,
							lng: <?php echo $map_lng; ?>,
							title: '<?php echo $name; ?>',
							animation: google.maps.Animation.DROP,
							icon: "<?php echo base_url(); ?>assets/images/talisker.png",
							infoWindow: 
							{
									
									content: "<p style='font-weight: bold; color:black;cursor: help;text-align: center;'><a href='javascript:void(0);' style='color:black;text-decoration:underline;'>SELECT "+Outlet_name+"</a></p> <p style='color:black;text-align: center;'><b><?php echo $addr; ?></b></p><p><img src='<?php echo base_url(); ?>assets/images/talisker.png' style='height: 20px;'><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>"+trHtml	//
							},
							click: function(e)
							{
								$('#TimeDetails_'+Enrollement_id).hide();
							}
						});
					
					} else {
						
						 map.addMarker(
						{
							lat: <?php echo $map_lat; ?>,
							lng: <?php echo $map_lng; ?>,
							title: '<?php echo $name; ?>',
							animation: google.maps.Animation.DROP,
							icon: "<?php echo base_url(); ?>assets/images/talisker.png",
							infoWindow: 
							{
									
									content: '<p style="font-weight: bold; color: black;text-align: center;"><?php echo $name; ?></p> <p style="color:black;text-align: center;"><b><?php echo $addr; ?></b></p><p><img src="<?php echo base_url(); ?>assets/images/talisker.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>'+trHtml	//
							},
							click: function(e)
							{
								$('#TimeDetails_'+Enrollement_id).hide();
							}
						});
					}
					// Outlet_name="";
			<?php
			}
			?>

			/* Fit All Marker to map */
			map.fitLatLngBounds(bounds);

			/* Make Map Responsive */

			var $window = $(window);
			function mapWidth()
			{
				var size = $('.google-map-wrap').width();
				$('.google-map').css({width: size + 'px', height: '550px'});
				
			}
			mapWidth();
			$(window).resize(mapWidth);

	


			function ViewDetails(Enrollement_id,ViewHide_flag)
			{
				if(ViewHide_flag == 1)
				{
					$('#TimeDetails_'+Enrollement_id).show();
					$('#HideLink_'+Enrollement_id).show();
					$('#ViewLink_'+Enrollement_id).hide();
				}
				else
				{
					$('#TimeDetails_'+Enrollement_id).hide();
					$('#HideLink_'+Enrollement_id).hide();
					$('#ViewLink_'+Enrollement_id).show();
				}
				
			}								
			</script>
	<!--------For GMAP--------->
	
	<style>
		.notification-check label > span:before{
			content: none !IMPORTANT;
		}
		.notification-check label > span{
			padding: 12px 15px 12px 10px !IMPORTANT;
		}
	</style>