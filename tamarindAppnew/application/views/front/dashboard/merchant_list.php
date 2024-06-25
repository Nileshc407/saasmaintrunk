<!DOCTYPE html>
<html lang="en">
<head>
<title>Outlet List</title>	
<?php $this->load->view('front/header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
 $Menu_access_details = json_decode($Menu_access_data, true); ?> 
</head>
<body> 
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
	<div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url();?>index.php/Cust_home/dashboard" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font"  style="margin-left: -3%;">Outlet List</p>
		</div>
		<div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
					<div class="pricing-details">
					
						<?php 
						foreach($All_Merchants_details as $Merchant)
						{
							// $Enroll = $Merchant['Enrollement_id'];
							$Photograph = $Merchant['Photograph'];
							if($Photograph=="")
							{
								$Photograph='images/no_image.jpeg';
							}
							
							$Transaction_count = $ci_object->Igain_model->Check_transaction_count($Merchant['Enrollement_id'],$Merchant['Company_id'],$enroll); 
						?>	
						<div class="row" >
							<div class="col-md-12">
								<div class="row" id="Lulu">
									
									<div class="col-xs-4" style="padding: 10px;">
										<img src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
									</div>											
									<div class="col-xs-8 text-left" id="detail">
									<?php /*
										if($Transaction_count == NULL) { ?>			
										<img src="<?php echo $this->config->item('base_url2')?>images/Not_registered_us.png" style="height:60px; margin-bottom:-12px; z-index: 1; margin-top: -20px; margin-left:110px;">
										<?php } else { ?>
										<img src="<?php echo $this->config->item('base_url2')?>images/Registered_us.png" style="height:60px; margin-bottom:-12px; z-index: 1; margin-top: -20px; margin-left:110px;">
										<?php } */?>
										
										<strong id="Large_font"><?php echo $Merchant['First_name'].' '.$Merchant['Last_name']; ?></strong><br />							
										<span id="Medium_font"><strong><?php echo $Merchant['Current_address']; ?>
										
										<br><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/phone.png" id="arrow" style="margin-top: 5px;" width="13">&nbsp;
										<?php echo $Merchant['Phone_no']; ?><br/>
										<?php 
										if($Transaction_count == NULL) { ?> 
										<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/welcome-hand.png" id="arrow" style="margin-top: 1px; margin-left: -80px; width:13%;">&nbsp;
										<span id="Seller_Note" style="margin-left: -57px;">Come and avail our offer</span> 
										<?php } else { ?>
										<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/hand-up.png" id="arrow" style="margin-top: 1px; margin-left: -80px; width:13%;">&nbsp;
										<span id="Seller_Note" style="margin-left: -57px;">You transacted last on <?php echo date('M-d-Y', strtotime($Transaction_count->Trans_date))?> </span>
										<?php } ?>
										 </strong></span>	
																				
									</div>
								</div>
							</div>
						</div><hr>
					<?php } ?>	
					<?php /* ?>	
						
						<div class="row" >
							<div class="col-md-12">
								<div class="box box-solid bg-light-blue-gradient">
									<div class="box-header ui-sortable-handle">
										<i class="fa fa-map-marker"></i>
										<span id="Large_font">Outlets</span>
									</div>
									<div class="box-body">
										<article class="entry">
											<div class="entry-content">
												<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
													<div id="google-map" class="google-map"></div>
												</div>
												
												<?php
												
												$locations = array();
												foreach ($Seller_details as $row) 
												{
													$Latitude=$row['Latitude'];
													$Longitude=$row['Longitude'];
													$Current_address=$row['Current_address'];
													$name=$row['First_name'].' '.$row['Last_name'];
													
													$locations[] = array
													(
														'google_map' => array(
															'lat' => $Latitude,
															'lng' => $Longitude,
														),
														'location_address' => $Current_address,
														'location_name'    => $name,
													);
												}
												$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
												$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
												?>
                                               <script  src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>												<script>
													jQuery( document ).ready( function($) 
													{

														var is_touch_device = 'ontouchstart' in document.documentElement;
														var map = new GMaps(
														{
															el: '#google-map',
															lat: '<?php echo $map_area_lat; ?>',
															lng: '<?php echo $map_area_lng; ?>',
															scrollwheel: false,
															draggable: ! is_touch_device
														});
														var bounds = [];

														<?php
														foreach($locations as $location )
														{												
															$name = trim($location['location_name']);
															$addr = trim($location['location_address']);
															$map_lat = $location['google_map']['lat'];
															$map_lng = $location['google_map']['lng'];
															
														?>
															
															var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
															bounds.push(latlng);													
															map.addMarker(
															{
																lat: <?php echo $map_lat; ?>,
																lng: <?php echo $map_lng; ?>,
																title: '<?php echo $name; ?>',
																infoWindow: 
																{
																	content: '<p style="color:black"><?php echo $name.'<br>'.$addr ?></p>'
																}
															});
														<?php } ?>

														map.fitLatLngBounds(bounds);
														var $window = $(window);
														function mapWidth()
														{
															var size = $('.google-map-wrap').width();
															$('.google-map').css({width: size + 'px', height: (size/2) + 'px'});
														}
														mapWidth();
														$(window).resize(mapWidth);
													});
												</script>
											</div>
										</article>							  
									</div>
								</div>
							</div>
						</div><hr>
						<?php */ ?>
					</div>
				</div>
			</div>
		</div><br/><br/>	
	</div>
</div>

<?php $this->load->view('front/header/footer'); ?> 
<!------------------------------------------Google Map---------------------------------------------->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-migrate.js'></script>
<script src="https://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/gmaps.js'></script>
<!------------------------------------------Google Map---------------------------------------------->
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}
	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
		font-size:13px;
	}
		
	#img{
		float: right;
		width: 10%;
		margin: -18px -15px auto;
	}
		
	#detail {
		line-height: 160%;
		width: 63%;
		margin-top: 10px;
	}
	
	#pink_txt{
		margin-left: 0px;
	}
	#Seller_Note
	{
		color:#808080;
		font-size:12px;
	}	
</style>