<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title; ?></title>	
<?php 
$this->load->view('front/header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');	
$ci_object->load->model('Shopping_model');	
$ci_object->load->helper(array('encryption_val'));

if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }

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
	
?> 

<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery-migrate.js'></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/map_assets/shop_time.css">

<?php /* === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== */ ?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD4U1mKm6UducB3tZ3-Fo9NvLxzbkIPk1Y" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/gmaps.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment-timezone-with-data.js'></script>
</head>
<body>        
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
      <div class="container">
            <div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Shopping/delivery_type" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Select Outlet</p>
            </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head"> 		
					
					<div class="pricing-details">
						<div class="row">
							<div class="col-xs-4 main-xs-6 text-center" style="width: 100%;">
									<div class="pages navbar-through toolbar-through">
										<div data-page="form" class="page">
											<form data-search-list=".list-block-search" data-search-in=".item-title" class="searchbar searchbar-init">
												<div class="searchbar-input">
													<input type="search" id="address" placeholder="Search address" autocomplete="off"><a href="#" class="searchbar-clear" ></a>
													<a href="JavaScript:void(0);">
														<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="searchOutlet">
													</a>
													<div class="help-block_currentAddress3" style="float: center;"></div>
												</div>
												<br>
											</form>
											<div class="searchbar-overlay"></div>											
											<div class="page-content">
												<div class="list-block inset" style="margin-left: 0px; margin-right: 0px; margin-top: 0px;">
													<ul>
														<?php /* === THIS IS WHERE WE WILL ADD OUR MAP USING JS ==== */ ?>
														<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
															<div id="google-map" class="google-map"></div><!-- #google-map -->
														</div>
														
														<?php
															// echo count($Seller_details);
															$Working_details = array();
															$locations = array();
															$Current_time = date("H:i:s");
															$Current_day = date("l");
															$day_of_week = date('N', strtotime($Current_day));
															$Outlet_status_flag=0;
															
															foreach ($Seller_details as $row) 
															{
																$Latitude = $row->Latitude;
																$Longitude = $row->Longitude;
																// $Current_address = $row->Current_address;
																$name = $row->First_name.' '.$row->Last_name;
																$Enrollement_id = $row->Enrollement_id;
																$Photograph = $row->Photograph;
																$Phone_no = $row->Phone_no;
																$timezone = $row->timezone_entry;											
																$Table_no_flag = $row->Table_no_flag;

																$str_arr = explode(",",$row->Current_address);
																$str_arr0 =App_string_decrypt($str_arr[0]);
																$str_arr1 =App_string_decrypt($str_arr[1]);
																$str_arr2 =App_string_decrypt($str_arr[2]);
																$str_arr3 =App_string_decrypt($str_arr[3]);
																
																$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3;



																
																$Count_Working_HRS = $ci_object->Igain_model->Count_seller_Working_HRS($Enrollement_id);
																
																// echo"--Count_Working_HRS--".$Count_Working_HRS."--<br>";
																
																$Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($Enrollement_id,$day_of_week);
																	
																// echo"---Get_outlet_working_hours---".$Get_outlet_working_hours."---<br>";
																$Outlet_status_flag=$Get_outlet_working_hours;
																if($Count_Working_HRS > 0 )
																{
																	
																	$seller_Working_HRS = $ci_object->Igain_model->Get_seller_Working_HRS($Enrollement_id);
																	// var_dump($seller_Working_HRS);
																	// echo"--seller_Working_HRS--".$seller_Working_HRS."--<br>";
																	
																	
																	
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
															// echo"--Working_details--".print_r($Working_details)."--<br>";
															
														
															
									/* Set Default Map Area Using First Location */
									$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
									$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
															?>

											
													</ul>
												</div>

											</div>

										</div>

									</div>
							</div>
						</div>
					</div>
					<div class="pricing-details">
							<div class="row">
								<div class="col-xs-4 main-xs-6 text-center" style="width: 100%;">
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_cart_details();" >Back</button>
								</div>
								<!--<div class="col-xs-4 main-xs-6 text-right" id="CardSubmit_div" style="width: 50%;"> 
									<button type="submit"   class="b-items__item__add-to-cart" id="CardSubmit">
											Proceed &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>
								</div>-->
							</div>
					</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Pricing Table Section-->
	
	<!-- Loader --> 
	<div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
	</div>
	<!-- Loader -->
	
	
	
	<!-- TableNoModal -->
		<div id="TableNoModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>				
				</div>
				<div class="modal-body" id="TableNo_div">
					<div class="form-group text-center">
						<label for="TableNo" id="Medium_font">Enter Table No.</label>
						<input type="text" id="TableNo" name="TableNo">						
						<div style="color:red;font-size:12px;" id="TableNo_error"></div>
					</div>
				</div>
				<div class="modal-footer" id="procced_div">		
					<input type="hidden" class="form-control" id="Table_no_flag" name="Table_no_flag" >
					<input type="hidden" class="form-control" id="delivery_type" name="delivery_type" >
					<input type="hidden" class="form-control" id="delivery_outlet" name="delivery_outlet" >
					<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_next(TableNo.value,delivery_type.value,delivery_outlet.value);">Procced</button>					
				</div>
				
				<div id="InStore_div" style="display:none">
					<div class="modal-body">
						<div class="form-group text-center">
							<label for="TableNo" id="Medium_font">You are placing a In-Store Order </label><br>					
							<label for="TableNo" id="Small_font">Please confirm you are at</label><br>
							<label for="TableNo" id="Small_font"><span id="Fname"></span></label>	
							<!-- <label for="TableNo" id="Small_font"><span id="Lname"></span></label> -->
							<br>	
							<div id="tableNo_showHide">
								<label for="TableNo" id="Small_font">Table No.:<span id="Table"></span></label><br>
							</div>
							<label for="TableNo" id="Small_font"><span id="Address"></span></label>
						</div>
					</div>
					<div class="modal-footer">
						<div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
							<button type="button" id="button1" class="b-items__item__add-to-cart"   onclick="return Go_next_next_process(TableNo.value,delivery_type.value,delivery_outlet.value);">I am at the Restaurant</button>
						</div>
						<div class="col-xs-4 main-xs-6 text-right" style="width: 50%;"> 
							<button type="button" id="button1"  class="b-items__item__add-to-cart" onclick="return Go_to_cart_details();" >
									Cancel In-Store Order
							</button>
						</div>
					</div>
				</div>
				
			</div>

		  </div>
		</div>

	<!-- TableNoModal -->
	
	
	<!-- Loader --> 
	<div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
	</div>
	<!-- Loader -->
	
	
   <?php $this->load->view('front/header/footer'); ?> 
   
<style>
 #map>div
 { position:relative !IMPORTANT; }
 
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
<table id="Selle_opening_hours">
	<tbody>
			<th class="text-center">Day</th>
			<th class="text-center">Opening Time</th>
			<th class="text-center">Closing TIme</th>
	</tbody>
    </table>
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
							
							/* if( WorkingDay2.indexOf(today) == -1)
							{
								trHtml2 += '<div class="Time_modal"><h2>We\'re Closed Today.</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_'+value['Enrollement_id']+'"  href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',1);">+ View Details</a><a style="display:none;" id="HideLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',2);">- View Details</a></p></div>';
							}
							else
							{
								trHtml2 += '<div class="Time_modal"><h2>Open Today :  '+OpenTime2+' - '+Close_time2+'</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',1);">+ View Details</a><a style="display:none;" id="HideLink_'+value['Enrollement_id']+'" href="javascript:void(0);" onclick="ViewDetails('+value['Enrollement_id']+',2);">- View Details</a></p></div>';
							} */
							
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
								icon: "<?php echo base_url(); ?>assets/icons/map_icon.png",
								infoWindow:
								{
									
									content: '<p style="font-weight: bold; color: #512C1D;cursor: help;"><a href="javascript:void(0);" onclick="javascript:passData('+Enrollement_id+','+nm+','+addrs+','+Table_no_flag+')">&nbsp;&nbsp;&nbsp;&nbsp;'+value['Name']+'</a></p> <p style="color: #512C1D;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo $this->config->item('base_url2')?>images/phone.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
								}
							});
							
						} else {
							
							map.addMarker(
							{
								lat: value['Latitude'],
								lng: value['Longitude'],
								title: value['Name'],
								animation: google.maps.Animation.DROP,
								icon: "<?php echo base_url(); ?>assets/icons/map_icon.png",
								infoWindow:
								{
									content: '<p style="font-weight: bold; color: #512C1D;">&nbsp;&nbsp;&nbsp;&nbsp;'+value['Name']+'</p> <p style="color: #512C1D;"><b>'+value['Current_address']+'</b></p><p><img src="<?php echo $this->config->item('base_url2')?>images/phone.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<b>'+Phone_no+'</b></p>'+trHtml2
								}
							});
						}
						
						
					});
					
					if(Seller_count == 1)
					{
						map.setZoom(17);
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
    /* console.log(name);
    console.log(addr);
    console.log("--Table_no_flag---"+Table_no_flag); */
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
				/* console.log('Condition 1'); */
                //trHtml += '<div class="Time_modal"><h2>Open Today :  '+OpenTime+' - '+Close_time+'</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
                trHtml += '<div class="Time_modal"><h2> Currently We\'re not processing online Orders!</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>"  href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
            }
            else
            {
				/* console.log('Condition 2'); */
                //trHtml += '<div class="Time_modal"><h2>We\'re Closed Today.</h2><p style="margin: 0px; text-align: right; font-size: 11px; text-decoration: underline;"><a id="ViewLink_<?php echo $Enrollement_id; ?>"  href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,1);">+ View Details</a><a style="display:none;" id="HideLink_<?php echo $Enrollement_id; ?>" href="javascript:void(0);" onclick="ViewDetails(<?php echo $Enrollement_id; ?>,2);">- View Details</a></p></div>';
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
                icon: "<?php echo base_url(); ?>assets/icons/map_icon.png",
                infoWindow: 
                {
						
                        content: "<p style='font-weight: bold; color: #512C1D;cursor: help;'><a href='javascript:void(0);' onclick='javascript:passData("+Enrollement_id+","+d+","+add+","+Table_no_flag+")'>"+Outlet_name+"</a></p> <p style='color: #512C1D;'><b><?php echo $addr; ?></b></p><p><img src='<?php echo $this->config->item('base_url2')?>images/phone.png' style='height: 20px;'><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>"+trHtml	//
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
                icon: "<?php echo base_url(); ?>assets/icons/map_icon.png",
                infoWindow: 
                {
						
                        content: '<p style="font-weight: bold; color: #512C1D;"><?php echo $name; ?></p> <p style="color: #512C1D;"><b><?php echo $addr; ?></b></p><p><img src="<?php echo $this->config->item('base_url2')?>images/phone.png" style="height: 20px;"><b>&nbsp;Phone No.&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p>'+trHtml	//
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
		
			$('#Table_no_flag').val(Table_no_flag);
			$('#Fname').html(Outlet_name_obj[outLetID]);
			$('#Lname').html(Outlet_name_obj[outLetID]);
			$('#Address').html(Outlet_address_obj[address]);
		
		
		// return false;
		/* alert(outlet_name);
		alert(outlet_addr);
		alert(Table_no_flag); */
		
		if(<?php echo $_SESSION['delivery_type']; ?> ==107){
			
			
			if(Table_no_flag == 0 ){			
				
				Go_next(9999,delivery_type,Enrollement_id)
			}
			$('#TableNoModal').modal('show');
			$('#TableNo').val();
			$('#delivery_type').val(<?php echo $_SESSION['delivery_type']; ?>);
			$('#delivery_outlet').val(Enrollid);
						
		} else {
			
			window.location.href='<?php echo base_url();?>index.php/Shopping/select_address?delivery_type='+delivery_type+'&delivery_outlet='+Enrollid+'&TableNo=9999';	
			
			
		}
		
	}
	function Go_next(TableNo,delivery_type,Enrollement_id)
	{ 
		
		// console.log('---Go_next TableNo----'+TableNo);
		
		$("#procced_div").css('display','none');
		$("#InStore_div").css('display','none');
		$("#tableNo_showHide").css('display','');
		
		$("#TableNo_error").html('');
		
		if(TableNo == 9999 ){
			
			$("#TableNo_div").css('display','none');
			$("#Small_font_div").css('display','none');
			$("#tableNo_showHide").css('display','none');
			$("#InStore_div").css('display','');
			
		} else {
			
			// console.log('---Go_next TableNo--2--'+TableNo);
			if(TableNo == "") {
			
				// $('#Table').html(TableNo);
				$("#TableNo_error").html('Please Enter valid table No.');
				$("#procced_div").css('display','');
			
			} else {
				
				$("#TableNo_div").css('display','');
				$("#TableNo_error").html('');
				$("#InStore_div").css('display','');			
				$("#Small_font_div").css('display','');			
				$('#Table').html(TableNo);			
			}
		}
	}
	/* function Go_to_next(delivery_type,Enrollement_id,address)
	{ 

		$('#TableNoModal').modal('show');
		$('#TableNo').val();
		$('#delivery_type').val(delivery_type);
		$('#delivery_outlet').val(Enrollement_id);
		
		
		var myStringArray = address.split('_');
		
		$('#Fname').html(myStringArray[0]);
		$('#Lname').html(myStringArray[1]);
		$('#Address').html(myStringArray[2]);
	} */	
	function Go_next_next_process(TableNo,delivery_type,Enrollement_id)
	{ 
			
		$("#TableNo_error").html('');
		var Table_no_flag= $("#Table_no_flag").val();
		/* console.log('---Go_next_next_process TableNo----'+TableNo);
		console.log('---Go_next_next_process Table_no_flag----'+Table_no_flag); */
		if(Table_no_flag==1 && TableNo == ""  ){
			$("#TableNo_error").html('Please Enter valid table no.');
			return false;
		}
		if(TableNo==""){
			
			var TableNo=9999;
			
		}else{
			
			TableNo=TableNo;
		}
		
		if(TableNo == ""  ){
			
			//console.log('---Go_next_next_process TableNo----'+TableNo);
			$("#TableNo_error").html('Please Enter valid table no.');
			return false;
			
		} else {
			
			$("#TableNo_error").html('');
			$("#InStore_div").css('display','');
			setTimeout(function() 
			{
				window.location.href='<?php echo base_url();?>index.php/Shopping/select_address?delivery_type='+delivery_type+'&delivery_outlet='+Enrollement_id+'&TableNo='+TableNo;		
				
			}, 0);
			
			// $('#TableNoModal').modal('hide');
		}
		
		
	}

	function Go_to_cart_details()
	{ 

		setTimeout(function() 
		{
			$('#myModal').modal('show');
			window.location.href='<?php echo base_url(); ?>index.php/Shopping/delivery_type';
			//window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type;
			// window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
			
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');
		   
		},2000);
	}
	
	
	
</script>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2'); ?>assets/css/jquery-ui.css">
<script src="<?php echo $this->config->item('base_url2'); ?>assets/js/jquery-ui.js"></script>
<script>
	
		$("#address").autocomplete({
			source:"<?php echo base_url(); ?>index.php/Cust_home/autocomplete_customer_names", // path to the get_birds method
			change: function (event, ui)
			{
				// console.log("--value---"+this.value);
				if (!ui.item) { this.value = ''; }
			}
		});
</script>
<style>
.ui-autocomplete{
	width:220px !IMPORTANT;
}
.ui-menu .ui-menu-item{
	border-bottom: solid 1px #5e4103;
}
</style>

