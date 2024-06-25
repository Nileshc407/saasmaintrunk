<?php $this->load->view('front/header/header');
$session_data = $this->session->userdata('cust_logged_in');
	$data['Walking_customer'] = $session_data['Walking_customer'];
	/*  
		style="background-image:url('<?php echo base_url(); ?>assets/img/select-location.jpg')"
	*/
	$ci_object = &get_instance(); 
	$ci_object->load->model('Igain_model');
	$ci_object->load->model('shopping/Shopping_model');
	$ci_object->load->helper(array('encryption_val'));
 ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/select-location.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon"> 
						<a href="<?php echo base_url(); ?>index.php/Shopping/delivery_type_shopping"></a>
					</div>
					<h2>Select Outlet</h2>
				</div>
			</div>
		</div>
		<div class="custom-body select-location-body live_tab_show">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="active" id="live-tab" data-toggle="tab" href="#live_view" role="tab" aria-controls="live_view" aria-selected="true">List View</a>
				</li>
				<li class="nav-item" role="presentation">
					<a id="map-tab" data-toggle="tab" href="#map_view" role="tab" aria-controls="map_view" aria-selected="false">Map View</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="live_view" role="tabpanel" aria-labelledby="live-tab">
					<?php 
					
					$attributes = array('onSubmit' => 'return ValidateForm();');
					echo form_open_multipart('Shopping/set_outlet_session',$attributes); ?>
						<div class="notification-body">
							<?php
							$openClose=array();
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
							// print_r($openClose);
							?>
						</div>
						
						
						<?php if($Seller_details) { ?>
							<div class="proceed-btn-wrap">
							<!--<a href="#" class="cust-btn btn-block btn-active">PROCEED</a>  onclick="Call_loader();"-->
								<div id="Select_outlet_msg" style="text-align:center;"></div>
								<input type="hidden" name="delivery_type" value="<?php echo $_SESSION['delivery_type']; ?>">
								<button class="cust-btn btn-block btn-active" >PROCEED</button>
								
							</div>
						<?php } else { ?>
								<div class="proceed-btn-wrap">
									<a href="JAVASCRIPT:VOID(0);" class="cust-btn btn-block">No Outet Founds</a>
								</div>
						<?php } ?>
						
						<?php echo form_close(); ?>	
				</div>
			  
				<div class="tab-pane map-panel fade show active" id="map_view" role="tabpanel" aria-labelledby="map-tab">
				
				
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
												$Phone_no = $row->Phone_no;
												$timezone = $row->timezone_entry;											
												$Table_no_flag = $row->Table_no_flag;

												/* $str_arr = explode(",",$row->Current_address);
												$str_arr0 =App_string_decrypt($str_arr[0]);
												$str_arr1 =App_string_decrypt($str_arr[1]);
												$str_arr2 =App_string_decrypt($str_arr[2]);
												$str_arr3 =App_string_decrypt($str_arr[3]);
												
												$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3; */

												$Current_address=App_string_decrypt($row->Current_address);

												
												$Count_Working_HRS = $ci_object->Igain_model->Count_seller_Working_HRS($Enrollement_id);
												// $Count_Working_HRS=1;
												
												// Get_outlet_working_hours
												
												// $Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($Enrollement_id,$day_of_week);
													
												// $Get_outlet_working_hours=1;
												
												// echo"--Get_outlet_working_hours--2--".$Enrollement_id."--".$Get_outlet_working_hours."--<br>";
												
												foreach($openClose as $key =>$values){
													
													// echo"--key---".$key."---values--".$values."--<br>";
													
													if($key==$Enrollement_id){
														
														$Outlet_status_flag=$values;
													}
													
												}										
												
												// echo"--Outlet_status_flag--".$Enrollement_id."--".$Outlet_status_flag."--<br>";
												
												
												
												
												// $Outlet_status_flag=$Get_outlet_working_hours;
												if($Count_Working_HRS > 0 )
												{
													
													$seller_Working_HRS = $ci_object->Igain_model->Get_seller_Working_HRS($Enrollement_id);
													// var_dump($seller_Working_HRS);
													
													// echo"--seller_Working_HRS----22222--".$seller_Working_HRS."--<br>";
													
													
													
													
													
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
														// echo"--Day--".$Day."--<br>";	
														$Working_details[] = array
															(
																"Day" => $Day,
																"Open_time" =>$Open_time1,
																"Close_time" =>$Close_time1,
																"Enrollement_id" =>$Enrollement_id
																
															);
													}
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
											// echo"--Enrollement_id--".$Enrollement_id."--<br>";
											// echo"--Working_details---11--".print_r($Working_details)."--<br>";
											
										
											
							/* Set Default Map Area Using First Location */
							$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
							$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
							
							
							// die;q
						?>
				
					<?php /* if($Seller_details) { ?>
						<div class="proceed-btn-wrap">
							<a href="#" class="cust-btn btn-block">PROCEED</a>
						</div>
					<?php } else { ?>
							<div class="proceed-btn-wrap">
								<a href="JAVASCRIPT:VOID(0);" class="cust-btn btn-block">No Outet Founds</a>
							</div>
					<?php } */ ?>
				</div>
			</div>
		</div>
		
		
		
		
		
		<?php $this->load->view('front/header/footer');  ?>
		
		<!-- Loader Modal -->
			<div class="modal fade" id="loader-modal" data-keyboard="false" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="loaderlabel">
			  <div class="vertical-alignment-helper">
				<div class="modal-dialog modal-dialog-centered">
				  <div class="modal-content" style="height: 180px;">
					<div class="modal-header custom">
					  <div class="modal-body">
						<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		<!-- /Loader Modal -->
		
		
		<!--<table id="Selle_opening_hours">
			<tbody>
					<th class="text-center">Day</th>
					<th class="text-center">Opening Time</th>
					<th class="text-center">Closing TIme</th>
			</tbody>
		</table>-->
		
		
		<!-- TableNoModal --->
		<div id="TableNoModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>				
				</div>
				<div class="modal-body" id="TableNo_div" style="padding:0px;">
					<!--<div class="form-group text-center">
						<label for="TableNo" id="Medium_font">Enter Table No.</label>
						<input type="text" id="TableNo" name="TableNo">						
						<div style="color:red;font-size:12px;" id="TableNo_error"></div>
					</div>-->
					
					
					<div class="form-group col-12" style="margin-bottom:5px;">
													
						<input type="text" name="TableNo" id="TableNo" class="form-control" style="background:none !IMPORTANT;color: #495057 !IMPORTANT;">
						
						<label class="form-control-placeholder" for="TableNo">Enter Table No.</label>
						
						<div style="color:red;font-size:12px;" id="TableNo_error"></div>
					</div>
					
					
					
				</div>
				<div class="modal-footer" id="procced_div">
					
					<!--<input type="hidden" class="form-control" id="delivery_type" name="delivery_type"  value="<?php // echo $_SESSION['delivery_type']; ?>"> -->
					
					<input type="hidden" class="form-control" id="delivery_outlet1" name="delivery_outlet1" >
					
					<button type="button" class="cust-btn btn-block" class="b-items__item__add-to-cart" onclick="return Go_next(TableNo.value,<?php echo $_SESSION['delivery_type']; ?>,delivery_outlet1.value);">Procced</button>					
				</div>
				
				<div id="InStore_div" style="display:none">
					<div class="modal-body" style="padding:0px;">
						<div class="form-group text-center ml-2">
							<p style="color: #322210;margin-bottom: 0px !IMPORTANT;">You are placing a In-Store Order </p>					
							<p style="color: #322210;margin-bottom: 0px !IMPORTANT;">Please confirm you are at</p>
							<p style="color: #322210;margin-bottom: 0px !IMPORTANT;"><span id="Fname"></span> <span id="Lname"></span></p>
							<p style="color: #322210;margin-bottom: 0px !IMPORTANT;" id="Small_font_div">Table No.:<span id="Table"></span></p>
							<p style="color: #322210;margin-bottom: 0px !IMPORTANT;" ><span id="Address"></span></p>
							
							<input type="hidden" class="form-control" id="delivery_outlet2" name="delivery_outlet2" >
						</div>
					</div>
					<div class="modal-footer">
						<div class="col-xs-4 main-xs-6 text-left">
							<button type="button" class="cust-btn btn-block" class="b-items__item__add-to-cart"   onclick="return Go_next_next_process(TableNo.value,<?php echo $_SESSION['delivery_type']; ?>,delivery_outlet2.value);" style="padding:0px;">Yes, i am at the Restaurant</button>
						 
							<button type="button" class="cust-btn btn-block"  class="b-items__item__add-to-cart" onclick="return Go_to_cart_details();" style="padding:0px;" >
								No, I am not at the Restaurant
							</button>
						</div>
					</div>
				</div>
				
			</div>

		  </div>
		</div>
		<!-- TableNoModal -->
		
		
		
		
		
		
	   <script>
	   
		function Call_loader()
		{
			setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},200000000000);
			
			// window.location.reload();
		}
	   
	   
	   
		$(document).ready(function(){
			$("#live-tab").click(function(){
				$(".select-location-body").addClass("live_tab_show");
			})
			$("#map-tab").click(function(){
				$(".select-location-body").removeClass("live_tab_show");
			})
			
			/* 19-06-2020 */
				setTimeout(function() {
					$("#map_view").removeClass(" show active");
				}, 3000);
			/* 19-06-2020 */
			
		});
		
		$(function() {
			
			$('#TableNo').on('click', function() {
				$("#procced_div").css('display','');
				$("#InStore_div").css('display','none');
				
			});
   
		});


		function Go_to_next(delivery_type,Enrollement_id,address,Table_no_flag)
		{ 

			/* console.log('---Table_no_flag----'+Table_no_flag);
			console.log('---Enrollement_id----'+Enrollement_id); */
			// return false;
			if(Table_no_flag == 0 ){			
				Go_next(9999,delivery_type,Enrollement_id)
			}
			$('#TableNoModal').modal('show');
			$('#TableNo').val();
			// $('#delivery_type').val(delivery_type);
			// $('#delivery_outlet').val(Enrollement_id);
			// $('#delivery_outlet').val(10);
			 // $("#delivery_outlet input:text").val(10);
			 
			 
			 var $modal = $('#TableNoModal'),
				  $userName1 = $modal.find('#delivery_outlet1');
				  $userName2 = $modal.find('#delivery_outlet2');
			  $userName1.val(Enrollement_id);
			  $userName2.val(Enrollement_id);
			
			
			var myStringArray = address.split('_');
			
			$('#Fname').html(myStringArray[0]);
			$('#Lname').html(myStringArray[1]);
			$('#Address').html(myStringArray[2]);	
			
		}
		function Go_next(TableNo,delivery_type,Enrollement_id)
		{ 
			
			console.log('--- TableNo----'+TableNo);
			// console.log('--- Enrollement_id----'+Enrollement_id);
			// return false;
			
			$("#procced_div").css('display','none');
			$("#InStore_div").css('display','none');
			
			$("#TableNo_error").html('');
			
			
			
			if(TableNo == 9999 ){
				
				$("#InStore_div").css('display','');
				$("#TableNo_div").css('display','none');
				$("#Small_font_div").css('display','none');
				
			} else {
				
				// console.log('--- TableNo--2--'+TableNo);
				if(TableNo == "") {
				
					// $('#Table').html(TableNo);
					$("#TableNo_error").html('Please Enter valid table No.');
					return false;
				
				} else {
					
					$("#TableNo_div").css('display','');
					$("#TableNo_error").html('');
					$("#InStore_div").css('display','');			
					$("#Small_font_div").css('display','');			
					$('#Table').html(TableNo);			
				}
			}
			
			
		}	
		function Go_next_next_process(TableNo,delivery_type,Enrollement_id)
		{ 
				
			$("#TableNo_error").html('');
			/* console.log('-- TableNo----'+TableNo);
			console.log('-- delivery_type----'+delivery_type);
			console.log('-- Enrollement_id----'+Enrollement_id);
			return false; */
		
			if(TableNo==""){
				
				var TableNo=9999;
				
			}else{
				
				TableNo=TableNo;
			}
			
			if(TableNo == ""){
				
				//console.log('-- TableNo----'+TableNo);
				$("#TableNo_error").html('Please Enter valid table no.');
				
			} else {
				
				$("#TableNo_error").html('');
				$("#InStore_div").css('display','');
				setTimeout(function() 
				{
					window.location.href='<?php echo base_url();?>index.php/Shopping/set_outlet_session?delivery_type='+delivery_type+'&delivery_outlet='+Enrollement_id+'&TableNo='+TableNo;		
					
				}, 0);
				
				$('#TableNoModal').modal('hide');
			}
			
			
		}
		
		function Go_to_cart_details()
		{ 
			var Walking_customer= <?php echo $session_data['Walking_customer']; ?>;
			setTimeout(function() 
			{
				// $('#myModal').modal('show');
				 if(Walking_customer == 0 ) {
					 
					 window.location.href='<?php echo base_url(); ?>index.php/Shopping/delivery_type_shopping';
				 } else {
					 window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
				 }
				
				
				//window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
				// window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
				
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide');
			   
			},2000);
		}   
		function form_submit()
		{
			setTimeout(function() 
			{
					// $('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
					$('#myModal').modal('hide'); 
			},2000);

			document.Search_items.submit();
		} 
		
		function Page_refresh()
		{
			setTimeout(function() 
			{
				// $('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},2000);
			
			// window.location.reload();
		}		
	   </script>
	   
	   
	<!--------For GMAP--------->
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
											icon: "<?php echo base_url(); ?>assets/img/ord.png",
											infoWindow:
											{
												
												content: '<p style="font-weight: bold; color: #1a1413;cursor: help;"><a href="javascript:void(0);" onclick="javascript:passData('+Enrollement_id+','+nm+','+addrs+','+Table_no_flag+')"><b  style="color: black">&nbsp;&nbsp;&nbsp;&nbsp;SELECT</b><br>'+value['Name']+'</a></p> <p style="color: #1a1413;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo base_url(); ?>assets/img/ord.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
											}
										});
										
									} else {
										
										map.addMarker(
										{
											lat: value['Latitude'],
											lng: value['Longitude'],
											title: value['Name'],
											animation: google.maps.Animation.DROP,
											icon: "<?php echo base_url(); ?>assets/img/red.png",
											infoWindow:
											{
												content: '<p style="font-weight: bold; color: #1a1413;">&nbsp;&nbsp;&nbsp;&nbsp;'+value['Name']+'</p> <p style="color: #1a1413;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo base_url(); ?>assets/img/red.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
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
				<?php
					if($Photograph== "")
					{
						$Photograph1='uploads/user10.jpg';
					}
					else
					{
						$Photograph1=$Photograph;
					}	
					
					if($Working_details != "")
					{
						foreach($Working_details as $WH2)
						{
								
							if($Enrollement_id == $WH2['Enrollement_id'])
							{					
								$TodayDate2 = $WH2['Day'];
								
								?>
							
								var TodayDate2 = '<?php echo $TodayDate2; ?>';
								// var TodayDate2 = 'Friday';
								// console.log(TodayDate2);
								// console.log(Merchant_curent_day);
								if(TodayDate2 === Merchant_curent_day)
								{
									OpenTime='<?php echo $WH2['Open_time']; ?>';
									Close_time='<?php echo $WH2['Close_time']; ?>';
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
							trHtml += '<div class="Time_modal"><h2> Currently We\'re not processing online Orders!</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>"  href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
						}
						else
						{
							trHtml += '<div class="Time_modal"><h2>Open Today :  '+OpenTime+' - '+Close_time+'</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
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
							icon: "<?php echo base_url(); ?>assets/img/ord.png",
							infoWindow: 
							{
									
									content: "<p style='font-weight: bold; color:black;cursor: help;text-align: center;'><a href='javascript:void(0);' onclick='javascript:passData("+Enrollement_id+","+d+","+add+","+Table_no_flag+")' style='color:black;text-decoration:underline;'>SELECT "+Outlet_name+"</a></p> <p style='color:black;text-align: center;'><b><?php echo $addr; ?></b></p><p><img src='<?php echo base_url(); ?>assets/img/ord.png' style='height: 20px;'><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>"+trHtml	//
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
							icon: "<?php echo base_url(); ?>assets/img/red.png",
							infoWindow: 
							{
									
									content: '<p style="font-weight: bold; color: black;text-align: center;"><?php echo $name; ?></p> <p style="color:black;text-align: center;"><b><?php echo $addr; ?></b></p><p><img src="<?php echo base_url(); ?>assets/img/red.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>'+trHtml	//
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

			// map.setZoom(0);

			var $window = $(window);
			function mapWidth()
			{
				var size = $('.google-map-wrap').width();
				$('.google-map').css({width: size + 'px', height: '550px'});
				// $('.google-map').css({width:'550px', height: '550px'});
			}
			mapWidth();
			$(window).resize(mapWidth);

	


			function ViewDetails(Enrollement_id,ViewHide_flag)
			{
				/* console.log('ViewDetails'); */
				// return false;
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
				//$$('#TimeDetails_'+Enrollement_id).show();
				//$$('#HideLink_'+Enrollement_id).show();
			}

				function passData(Enrollid,outLetID,address,Table_no_flag)
				{
					
						// name,addr,Table_no_flag
						// myApp.showPreloader();
						/* console.log("----delivery_type-------"+<?php echo $_SESSION['delivery_type']; ?>);	
						console.log("----Enrollid-------"+Enrollid);
						console.log("----Outlet_name-------"+Outlet_name_obj[outLetID]);
						console.log("----Outlet_address-------"+Outlet_address_obj[address]); 
						console.log("--passData--Table_no_flag----"+Table_no_flag); */
					
						var delivery_type = <?php echo $_SESSION['delivery_type']; ?>;
						$('#Table_no_flag').val(Table_no_flag);
						$('#Fname').html(Outlet_name_obj[outLetID]);
						// $('#Lname').html(Outlet_name_obj[outLetID]);
						$('#Address').html(Outlet_address_obj[address]);
					
					
					// return false;
					/* alert(outlet_name);
					alert(outlet_addr);
					alert(Table_no_flag); */
					
					if(<?php echo $_SESSION['delivery_type']; ?> ==107){
						
						
						if(Table_no_flag == 0 ){			
							
							Go_next(9999,delivery_type,Enrollid)
						}
						
						$('#TableNoModal').modal('show');
						$('#TableNo').val();
						
						// $('#delivery_type').val(<?php echo $_SESSION['delivery_type']; ?>);
						// $('#delivery_outlet').val(Enrollid);
						
							var $modal = $('#TableNoModal'),
							$userName1 = $modal.find('#delivery_outlet1');
							$userName2 = $modal.find('#delivery_outlet2');
							$userName1.val(Enrollid);
							$userName2.val(Enrollid);
						
									
					} else {
						
						/* window.location.href='<?php echo base_url();?>index.php/Shopping/select_address?delivery_type='+delivery_type+'&delivery_outlet='+Enrollid+'&TableNo=9999'; */	
						
						window.location.href='<?php echo base_url();?>index.php/Shopping/set_outlet_session?delivery_type='+delivery_type+'&delivery_outlet='+Enrollid+'&TableNo=9999';
						
						
					}
					
				}
								
			</script>
	<!--------For GMAP--------->
	
	<script>
	
		
		function ValidateForm(){
		
			if ($("input[type=radio]:checked").length > 0) {
					
				return true;
				
				
			} else {   

				// alert(' Please select address');
				var msg = 'Please select nearest outlet';
				  $('#Select_outlet_msg').show();
				  $('#Select_outlet_msg').css("color", "red");
				  $('#Select_outlet_msg').html(msg);
				  setTimeout(function() {
						$('#Select_outlet_msg').hide();
				  }, 3000);
				return false
			}
			return true;
		}
		
	</script>
	
	<style>
 #map>div
 { 
	position:relative !IMPORTANT; }
 
 .gm-style-iw{
	max-width: 250px !IMPORTANT;
 }
 .gm-style-iw-d{
	max-width: 248px !IMPORTANT;
 }
 #address{
	width: 220px;
    height: 30px;
    padding: 10px;
    font-size: 14px;
 }
</style>