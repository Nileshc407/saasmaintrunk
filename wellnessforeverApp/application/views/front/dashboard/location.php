<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');  
$ci_object = &get_instance();
$ci_object->load->helper('encryption_val');
?>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/jquery-migrate.js'></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/map_assets/shop_time.css">
<?php /* === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== */ ?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD4U1mKm6UducB3tZ3-Fo9NvLxzbkIPk1Y" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/gmaps.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/map_assets/moment-timezone-with-data.js'></script>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
				<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $_SESSION['brndID']; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Location</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>

<main class="padTop1">
	<div class="container">
		<div class="row">
			<div class="col-12 locationWrapper px-0">
                <div class="locationSearch">
                    <input type="text" placeholder="Search.." class="typeahead form-control" name="search" id="search" >
                </div>
                <div class="locationHldr scrollbarMain">
                    <ul class="addressHldr" id="addressHldr">
                        <?php 
						
							//print_r($Sub_Seller_details);
							$count=count($Sub_Seller_details);
						
							if($Sub_Seller_details) {
								
								foreach($Sub_Seller_details as $seller)
								{
									
								
								?>
								
								<li class="d-flex align-items-center">
									<div class="addImg">
										<img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png">
									</div>
									<div class="addressMain">
										<p><?php echo $seller['First_name'].' '.$seller['Last_name']; ?></p>
										<!--<p><?php //echo App_string_decrypt($seller['Phone_no']); ?></p>
										<p><?php //echo App_string_decrypt($seller['User_email_id']); ?></p>-->
									</div>
								</li>
							<?php } 
						} ?>
                    </ul>
                </div>
				<div class="map">
				
						<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
							<div id="google-map" class="google-map"></div><!-- #google-map -->
						</div>
						
						
								<?php
									// echo count($Sub_Seller_details);
									
									
									$Working_details = array();
									$locations = array();
									$Current_time = date("H:i:s");
									$Current_day = date("l");
									$day_of_week = date('N', strtotime($Current_day));
									$Outlet_status_flag=0;
									
									foreach ($Sub_Seller_details as $row) 
									{
										$name = $row['First_name'].' '.$row['Last_name'];
										$Phone_no = App_string_decrypt($row['Phone_no']);
										$User_email_id = App_string_decrypt($row['User_email_id']);
										$Current_address = App_string_decrypt($row['Current_address']);
										$timezone = $row['timezone_entry'];	
										$Table_no_flag = $row['Table_no_flag'];	
										$Photograph = $row['Photograph'];	
										$Enrollement_id = $row['Enrollement_id'];	
										$Latitude = $row['Latitude'];	
										$Longitude = $row['Longitude'];	
										
										



										
										/* $Count_Working_HRS = $ci_object->Igain_model->Count_seller_Working_HRS($Enrollement_id);
										
										// echo"--Count_Working_HRS--".$Count_Working_HRS."--<br>";
										
										$Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($Enrollement_id,$day_of_week);
											
										// echo"---Get_outlet_working_hours---".$Get_outlet_working_hours."---<br>";
										$Outlet_status_flag=$Get_outlet_working_hours;
										if($Count_Working_HRS > 0 )
										{
											
											$seller_Working_HRS = $ci_object->Igain_model->Get_seller_Working_HRS($Enrollement_id);
												//var_dump($seller_Working_HRS);
												//echo"--seller_Working_HRS--".$seller_Working_HRS."--<br>";
											
											
											
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
										} */
										
										$Working_details = "";
										
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
															'User_email_id' => $User_email_id,
															'timezone' => $timezone,
															'Working_details' => $Working_details,
															"Outlet_status_flag" =>$Outlet_status_flag,
															"Table_no_flag" =>$Table_no_flag
														);
											// echo"--Working_details--".print_r($Working_details)."--<br>";			
																
									}
									// echo"--Working_details--".print_r($Working_details)."--<br>";
															
														
									// echo"--locations--".print_r($locations)."--<br>";						
									/* Set Default Map Area Using First Location */
									$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
									$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
															
									
															
								?>
														
                    <!--
					<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $BrandAddress; ?>&output=embed"></iframe>
					
					<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d31910.647698778248!2d36.775130202624126!3d-1.2746981354358287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sjava%20house%20near%20ABC%20Place%2C%20Nairobi%2C%20Kenya!5e0!3m2!1sen!2sin!4v1630038326592!5m2!1sen!2sin"  style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->
                </div>
			</div>
		</div>
	</div>
</main>
	

<!-- <footer>
	<ul class="iconMenu d-flex align-items-center">
		<li><a class="home active" href="#">&nbsp;</a></li>
		<li><a class="user" href="#">&nbsp;</a></li>
		<li><a class="points" href="#">&nbsp;</a></li>
		<li><a class="noti" href="#">&nbsp;</a></li>
	</ul>
</footer> -->

	
<script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</body>
</html>

<script type="text/javascript">
		
    $('input.typeahead').typeahead({
		
        source:  function (query, process) {
			
			return $.get('<?php echo base_url(); ?>index.php/Cust_home/search_outlet', { query: query }, function (data) {
                // console.log(data);
               /*  data = $.parseJSON(data);
				// console.log(data);
				$("#addressHldr").empty();
				// var addressHldr = $("#addressHldr");
				var html="";
				$.each(data, function(i, order){
					// addressHldr.append("<li class='d-flex align-items-center'>" + data[i].Current_address + "</li>")
					
							html="<li class='d-flex align-items-center'> <div class='addImg'> <img src='<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png'> </div> <div class='addressMain'> <p>"+data[i].First_name+" "+data[i].Last_name+"</p><p>"+data[i].Phone_no+"</p><p>"+data[i].User_email_id+"</p></div></li>";
					// html=""
					
					
				});  
				// console.log(html);
				$("#addressHldr").append(html);
                // return process(data); */
				
				
				$('#addressHldr').html('');
				$("#addressHldr").html(data);
            });
			
        }
    });
	
	
	
	 var timer, delay = 5000; //10 minutes counted in milliseconds.
	// var TotalQty=<?php echo $TotalQty;?>;
		timer = setInterval(function(){
			
			var datalength=0;
			var search= $('#search').val();
			var count= <?php echo $count; ?>;
			// alert(search);
			if(search == null || search == undefined || search == ""){
				
				$.ajax({
				  type: 'POST',
				  data: {brndID:<?php echo $_SESSION['brndID']; ?>},
				  url: '<?php echo base_url(); ?>index.php/Cust_home/brandoutlet',
				  success: function(data){
					
					
					/* datalength=data.length;
					// console.log("--datalength---"+datalength);
					// console.log("--count---"+count);
					
					data = $.parseJSON(data);
						// console.log(data);
						$("#addressHldr").empty();
						// var addressHldr = $("#addressHldr");
						var html="";
						$.each(data, function(i, order){
							// addressHldr.append("<li class='d-flex align-items-center'>" + data[i].Current_address + "</li>")
							
									html="<li class='d-flex align-items-center'> <div class='addImg'> <img src='<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png'> </div> <div class='addressMain'> <p>"+data[i].First_name+" "+data[i].Last_name+"</p><p>"+data[i].Phone_no+"</p><p>"+data[i].User_email_id+"</p></div></li>";
							// html=""
							$("#addressHldr").append(html);
						
						
					});  */ 
					
					
					$('#addressHldr').html('');
					$("#addressHldr").html(data);
									
				  }
				}); 
			}
			
		}, delay); 
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
var mapStyles = [
					{
		"featureType": "administrative",
		"elementType": "geometry",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "administrative.land_parcel",
		"elementType": "labels",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "labels.text",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "labels.icon",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "road.arterial",
		"elementType": "labels",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  
	  {
		"featureType": "road.local",
		"elementType": "labels",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "transit",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  }
					
				
				];
	var map = new GMaps(
    {
        el: '#google-map',
        lat: '<?php echo $map_area_lat; ?>',
        lng: '<?php echo $map_area_lng; ?>',
        scrollwheel: true,
		mapTypeControl: false,
		styles: mapStyles
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
    $User_email_id = $location['User_email_id'];
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
                icon: "<?php echo base_url(); ?>assets/images/map_icon.png",
                infoWindow: 
                {
						
                        content: "<p style='font-weight: bold; color: #512C1D;cursor: help;'><a href='javascript:void(0);' onclick='javascript:passData("+Enrollement_id+","+d+","+add+","+Table_no_flag+")'>"+Outlet_name+"</a></p> <p style='color: #512C1D;'><b><?php echo $addr; ?></b></p><!--<p><img src='<?php echo $this->config->item('base_url')?>assets/img/phone-icon.svg' style='height: 20px;'><b>&nbsp;Phone No.:&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p><p><img src='<?php echo $this->config->item('base_url')?>assets/img/email-icon.svg' style='height: 20px;'><b>&nbsp;Email:nbsp;&nbsp;<?php echo $User_email_id; ?></b></p>-->"+trHtml	//
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
                icon: "<?php echo base_url(); ?>assets/images/map_icon.png",
                infoWindow: 
                {
						
                        content: '<p style="font-weight: bold; color: #512C1D;"><?php echo $name; ?></p> <p style="color: #512C1D;"><b><?php echo $addr; ?></b></p><!--<p><img src="<?php echo $this->config->item('base_url')?>assets/img/phone-icon.svg" style="height: 20px;"><b>&nbsp;Phone No.:&nbsp;&nbsp;<?php echo $Phone_no; ?></b></p><p><img src="<?php echo $this->config->item('base_url')?>assets/img/email-icon.svg" style="height: 20px;"><b>&nbsp;Email:&nbsp;&nbsp;<?php echo $User_email_id; ?></b></p>-->'+trHtml	//
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
    $('.google-map').css({width: size + 'px', height: '340px'});
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
		
		/* if(<?php echo $_SESSION['delivery_type']; ?> ==107){
			
			
			if(Table_no_flag == 0 ){			
				
				Go_next(9999,delivery_type,Enrollement_id)
			}
			$('#TableNoModal').modal('show');
			$('#TableNo').val();
			$('#delivery_type').val(<?php echo $_SESSION['delivery_type']; ?>);
			$('#delivery_outlet').val(Enrollid);
						
		} else {
			
			window.location.href='<?php echo base_url();?>index.php/Shopping/select_address?delivery_type='+delivery_type+'&delivery_outlet='+Enrollid+'&TableNo=9999';	
			
			
		} */
		
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



