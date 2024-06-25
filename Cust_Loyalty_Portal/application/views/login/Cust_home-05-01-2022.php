<?php 
$this->load->view('header/header'); 
?>	
	<section class="content-header">
		<h1>Dashboard</h1>
	</section>
	<section class="content">					
		<?php
		if($Trans_details_summary !=NULL)
		{
			foreach($Trans_details_summary as $values)
			{
				$Total_gained_points=$values["Total_gained_points"];
				$Total_reddems=$values["Total_reddems"];
				$Total_purchase_amt=$values["Total_purchase_amt"];
				$Total_bonus_ponus=$values["Total_bonus_ponus"];
			}
		}
		else
		{
				$Total_gained_points=0;
				$Total_reddems=0;
				$Total_purchase_amt=0;
				$Total_bonus_ponus=0;
		}
		
		$total_gain_points=$total_gain_points->Total_gained_points;
									
		if($total_gain_points!='')
		{
			$TotalGainPoints=$total_gain_points; 
		}
		else
		{
			$TotalGainPoints="0";
		}
		
		$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
		if($Current_point_balance<0)
		{
			$Current_point_balance=0;
		}
		else
		{
			$Current_point_balance=$Current_point_balance;
		}
		
		
		
		?>
		  
		<div class="row">
		<?php  if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?> 
				<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#dd4b39 !important;">
					<div class="inner" style="padding: 5px;">
						<h4 class="text-center" style="margin: 3px;color: #fff;">   You have not been assigned Membership ID yet ...Please visit nearest outlet.         </h4>
					</div>
				</div>
				</div>
				 <?php } ?>
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color: rgb(49, 133, 156) ! important;">
					<div class="inner" style="padding: 5px;">
						<h4 class="text-center" style="margin: 3px;color: #fff;">Membership ID</h4>
						<img alt="<?php echo $Enroll_details->Card_id; ?>" class="img-responsive" style="margin: 0px auto;" src="<?php echo base_url() ?>barcode.php?codetype=Code128&size=40&text=<?php echo $Enroll_details->Card_id; ?>" />
					</div>
				</div>
			</div>
			
			<div class="col-lg-1 col-xs-6 visible-lg">&nbsp;</div>
			<div class="col-lg-2 col-xs-6">
				<div class="small-box bg" style="background-color:#76448A;color:#fff">
					<div class="inner">
						<h3 class="text-center" style="font-size: 25px;"><?php echo round($Current_point_balance); ?></h3>
						<p class="text-center">Current Balance</p>
					</div>
				</div>
            </div>
			<div class="col-lg-2 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3 class="text-center" style="font-size: 25px;"><?php echo $TotalGainPoints; ?></h3>
						<p class="text-center">Gained <?php echo $Company_Details->Currency_name; ?> </p>
					</div>
				</div>
            </div>			
            <div class="col-lg-2 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3 class="text-center" style="font-size: 25px;"><?php echo round($Enroll_details->Total_reddems); ?></h3>
						<p class="text-center">Redeemed <?php echo $Company_Details->Currency_name; ?> </p>
					</div>
				</div>
            </div>			
            <div class="col-lg-2 col-xs-6">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3 class="text-center" style="font-size: 25px;"><?php echo round($Enroll_details->Total_topup_amt); ?></h3>
						<p class="text-center">Bonus <?php echo $Company_Details->Currency_name; ?> </p>
					</div>
				</div>
            </div>			
            <div class="col-lg-2 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3 class="text-center" style="font-size: 25px;"><?php echo round($Enroll_details->Blocked_points); ?></h3>
						<p class="text-center">Blocked <?php echo $Company_Details->Currency_name; ?> </p>
					</div>
				</div>
            </div>
			
			<div class="col-lg-1 col-xs-6 visible-lg">&nbsp;</div>
		</div>
		  		  
		<div class="row">			 
		
			<div class="col-md-8">
			
				<div class="row">	
						<!--------------------	Recent view items-------------------------------->
					<?php
						if($Cust_Recently_viewed_items!=NULL){
					?>
						<div class="col-md-12">	
							<div class="box box-danger">
							
								<div class="box-header with-border">
									<h3 class="box-title">My Recently Viewed Items</h3>
								</div>
							
								<div class="box-body" style="min-height: 200px;">
									<div id="myCarousel2" class="carousel slide" data-ride="carousel">

										<div class="carousel-inner" role="listbox">										

											<?php
											$count = 0;
											
												// echo "----iv---".$iv."---<br>";
												// echo "----key---".$key."---<br>";
						
											// echo "<br>";
											//print_r($Cust_Recently_viewed_items);
											
											$ci_object = &get_instance();
											$ci_object->load->model('Redemption_Model');
											foreach ($Cust_Recently_viewed_items as $Item_id)
											{
												
												$Redemption_Items = $ci_object->Redemption_Model->Get_Merchandize_Item_details($Item_id->Item_id);
												// echo "----count---".$count."---<br>";
												if($count == 1)
												{
													$class='active';
												}
												else{
													
													$class='';
												}

												
													foreach ($Redemption_Items as $product)
													{
													
														$itemCode = $product->Company_merchandize_item_code;
														$Company_merchandise_item_id = $product->Company_merchandise_item_id;
														$Merchandize_item_name = $product->Merchandize_item_name;
														$Merchandise_item_description = $product->Merchandise_item_description;
														$Item_image1 = $product->Item_image1;
														
														
														$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
														$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
														
														//echo "----Company_merchandise_item_id---".$Company_merchandise_item_id."---<br>";
														?>						
															<div class="item <?php echo $class; ?>">
																<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
																<div class="row">
																	<div class="col-md-6 text-center">
																		<img src="<?php echo $Item_image1; ?>" alt="<?php echo $Merchandize_item_name; ?>" class="img-responsive img-rounded" style="width:200px;height:200px;">
																	</div>																	
																	<div class="col-md-6">
																		<h3><?php echo $Merchandize_item_name; ?></h3></a>
																		<p><?php echo $Merchandise_item_description; ?></p>
																	</div>
																</div>				
															</div>					
														<?php
														$count++;
													}
												}
											
											?>									  
										</div>										
									</div>
								</div>								
								<div class="box-footer text-center">
									<!-- Controls -->									
									<div class="controls">
										<a class="left btn btn-template-main" href="#myCarousel2" data-slide="prev">
											<i class="fa fa-chevron-left"></i>
										</a>
										<a class="right btn btn-template-main" href="#myCarousel2" data-slide="next">
											<i class="fa fa-chevron-right"></i>
										</a>
									</div>
								</div>
								
							</div>
						</div>
						<!--------------------------------------------------------------------------->
					<?php
						}
					if($Laest_merchandize_items != NULL)
					{
					?>						
						<!-- --------------------------------Product Slider---------------------------------- -->	<div class="col-md-12">	
							<div class="box box-danger">							
								<div class="box-header with-border">
									<h3 class="box-title">Merchandize Items </h3>
								</div>							
								<div class="box-body" style="min-height: 200px;">
									<div id="myCarousel" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner" role="listbox">
											<?php
											$count = 0;
											foreach ($Laest_merchandize_items as $prod)
											{												
												$count++;
												if($count == 1)
												{
													$class='active';
												}
												else{
													
													$class='';
												}
													$Company_merchandise_item_id = $prod['Company_merchandise_item_id'];
													
													$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
													$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
												?>							
													<div class="item <?php echo $class; ?>">
													<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
														<div class="row">
															<div class="col-md-6 text-center">
																<img src="<?php echo $prod['Thumbnail_image1']; ?>" alt="<?php echo $prod['Thumbnail_image1']; ?>" class="img-responsive img-rounded" >
															</div>
															
															<div class="col-md-5">
																<h3><?php echo $prod['Merchandize_item_name']; ?></h3> </a>
																<p><?php echo $prod['Merchandise_item_description']; ?></p>
															</div>
														</div>					
													</div>					
												<?php
											}
											?>									  
										</div>										
									</div>
								</div>								
								<div class="box-footer text-center">
									<!-- Controls -->									
									<div class="controls">
										<a class="left btn btn-template-main" href="#myCarousel" data-slide="prev">
											<i class="fa fa-chevron-left"></i>
										</a>
										<a class="right btn btn-template-main" href="#myCarousel" data-slide="next">
											<i class="fa fa-chevron-right"></i>
										</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- --------------------------------Product Slider---------------------------------- -->
					<?php
					}
					?>
				
				<?php 
				$count=count($Seller_details);
				if($count > 0 )
				{
				?>
				<div class="col-md-12" >
				
					<div class="box box-danger">
					
						
						
						<div class="box-header with-border">
							<h3 class="box-title">Our Merchants</h3>
						</div>						
						<div class="box-body" style="min-height: 200px;">
							
							<div class="row">
							
								<?php 
								$i = 0;	$counter = 1;
								
								
								foreach ($Seller_details as $row) 
								{						
									$Enroll = $row['Enrollement_id'];
									$Photograph = $row['Photograph'];
									if($Photograph=="")
									{
										$Photograph='images/no_image.jpeg';
									}
									$Merchant_name=$row['First_name'].' '.$row['Last_name'];
									if($Merchant_name=="")
									{
										$Merchant_name='-';
									}
									
									if ($counter % 5 == 0)
									{
										$class = 'style="clear: both;"';
									}
									else
									{
										$class = "";
									}
									?>
										<a href="<?php echo base_url()?>index.php/Cust_home/merchant_list">
											<div class="col-md-3" <?php echo $class; ?> >											
												<div class="panel panel-default">
													<div class="panel-body text-center">
														<img src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="<?php echo $Merchant_name ; ?>" class="img-responsive img-rounded" style="width: 65%; margin: 0 auto;">
													</div>													
													<div class="panel-footer text-center"><?php echo $Merchant_name ; ?></div>
												</div>											
											</div>
										</a>					
									<?php 
									$i++;
									$counter++;
								}				
								?>
							
							</div>				
						</div>	
						<div class="box-footer text-center">
							<!-- Controls -->									
							<div class="controls">
								<a href="<?php echo base_url()?>index.php/Cust_home/merchant_list" class="left btn btn-template-main">
									View All Merchants
								</a>										
							</div>
						</div>						
					</div>
				</div>
				<?php 
				}
				?>			
							
						<?php /* ?><div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Our Merchants </h3>
								<div class="box-tools pull-right">
									<?php 
									$i = 0;
									foreach ($Seller_details as $row) 
									{
										$i++;
									}
									?>
								</div>
							</div>
							
							<div class="box-body no-padding">
								<ul class="users-list clearfix">
									<?php 
									$i = 0;
									foreach ($Seller_details as $row) 
									{						
										$Enroll = $row['Enrollement_id'];
										$Photograph = $row['Photograph'];
										if($Photograph=="")
										{
											$Photograph='images/no_image.jpeg';
										}
										$Merchant_name=$row['First_name'].' '.$row['Last_name'];
										if($Merchant_name=="")
										{
											$Merchant_name='-';
										}
										$i++;
									?>		
										<li style="float: left;">
											<a href="<?php echo base_url()?>index.php/Cust_home/merchant_list">							
												<img src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="User Image" width="128" height="128"> 
												<?php echo $Merchant_name ; ?>
											</a>
										</li>	
									<?php 
									}				
									?>						
								</ul>
							</div>
							
							<div class="box-footer text-center">
								<a href="<?php echo base_url()?>index.php/Cust_home/merchant_list" class="uppercase">View All Merchants</a>
							</div>
						</div><?php  */ ?>
					
					 
					
					<div class="col-md-12">
						<div class="box box-solid bg-light-blue-gradient">
							<div class="box-header ui-sortable-handle">
								<i class="fa fa-map-marker"></i>
								<h3 class="box-title">Merchant Outlets</h3>
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
					
					<script>
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
							foreach( $locations as $location )
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
										content: '<p style="color:black"><?php echo $name.'-'.$addr ?></p>'
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
					
				</div>		 
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Last Transaction</h3>
								<div class="box-tools pull-right">						
							  </div>
							</div>
							
							<div class="box-body">
								<div class="table-responsive">
									<table class="table no-margin table-bordered table-hover">
										<thead>
											<tr>
												<th>Transaction Date</th>
												<th>Merchant Name</th>
												<th>Transaction Type</th>
												<th><?php echo $Company_Details->Currency_name; ?>  Used</th>
												<th><?php echo $Company_Details->Currency_name; ?>  Gained</th>
											
											</tr>
										</thead>
										
										<tbody>
											<?php
											foreach($Trans_details as $Trans)
											{
												$Merchant_name= $Trans['Seller_name'];
												$Bill_no= $Trans['Bill_no'];
												$Purchase_amount= $Trans['Purchase_amount'];
												$Loyalty_pts= $Trans['Loyalty_pts'];
												$Redeem_points= $Trans['Redeem_points'];
												$Bonus_points= $Trans['Topup_amount'];
												$Transfer_points= $Trans['Transfer_points'];
												$Quantity= $Trans['Quantity'];
												if($Merchant_name=="")
												{
													$Merchant_name='-';
												}
												if($Bill_no=="" || $Bill_no=="0")
												{
													$Bill_no='-';
												}
												if($Purchase_amount=="0")
												{
													$Purchase_amount='-';
												}
												if($Loyalty_pts=="0")
												{
													$Loyalty_pts='-';
												}
												if($Redeem_points=="0")
												{
													$Redeem_points='-';
												}
												if($Bonus_points=="0")
												{
													$Bonus_points='-';
												}
												if($Trans['Trans_type_id']=="10")
												{
													$Redeem_points=($Redeem_points*$Quantity);
												}
														
											?>
											
												<tr>
													<td><?php echo $Trans['Trans_date']; ?></td>
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Merchant_name; ?></div></td>
													<td><span class="label label-success"><?php echo $Trans['Trans_type']; ?></span></td>
													
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo ($Redeem_points+$Transfer_points); ?></div></td>        
													
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo ($Loyalty_pts+$Bonus_points); ?></div></td>
													                         
												</tr>
											
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="box-footer clearfix">                 
								<a href="<?php echo base_url()?>index.php/Cust_home/mystatement" class="btn btn-sm btn-default btn-flat pull-right">Get All Transactions</a>
							</div>				
						</div>
							
				
	
			
					</div>
				</div>
            </div>
			<?php 
			// echo"Profile_complete_flag--------".$Profile_complete_flag."<br>";
			// echo"Profile_complete_points--------".$Profile_complete_points."<br>";
			if($Profile_complete_flag==1 && $Profile_complete_points > 0 && $Enroll_details->Profile_complete_flag == '0' ) 
			{
				// $Profile_complete_points='200';
				// $Profile_complete_status='85%';
				
				?>
				<div class="col-md-4">
					<script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/progress-circle.js"></script>	
					<link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/circle.css" rel="stylesheet">
						<div id="circle"></div>        
						<script>
						( function( $ ){
							$( '#circle' ).progressCircle();
							<!-- $( '#submit' ).click( function() { -->
								var nPercent        = <?php echo $Customer_profile_status; ?>;
								var showPercentText = 1;
								var thickness       = 10;
								var circleSize      =100;

								$( '#circle' ).progressCircle({
									nPercent        : nPercent,
									showPercentText : showPercentText,
									thickness       : thickness,
									circleSize      : circleSize
								});
							<!-- }) -->
						})( jQuery );
						</script> 				
						<div class="alert alert-success">
							<h4 class="text-center">Complete Profile Status 100% and Get <?php echo round($Profile_complete_points); ?> <?php echo $Company_Details->Currency_name; ?> </h4>
						</div>
										
				</div>
				<?php
			}
			?>
			
			
			
			<div class="col-md-4">
				<div class="alert alert-info">
                    <h4 class="text-center">Offers Zone</h4>
				</div>
				
				<?php 
				$offer='0';
				$offer_flag='0';
				foreach($SellerOffers as $row)
				{
					if($row)
					{
						$offer_flag = 1;
						$offer_description = substr($row[0]['description'], 0, 255);
						$offer_description .= "......";
						// $offer_description=str_replace("464","100",$offer_description);
						if($offer=='0')
						{	
							$offer='1';
						?>
							
							<div class="box box-success box-solid" id="offer_block">
								<div class="box-header with-border text-center">
									<h3 class="box-title text-center">Merchant - <?php echo $row[0]['First_name'].' '.$row[0]['Last_name']; ?></h3>
								</div>
								<div class="box-body">
									<p class="text-center" style="border-bottom: 1px solid rgb(204, 204, 204);">
										<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">
											<strong><?php echo $row[0]['communication_plan']; ?></strong>
										</a>
									</p>
									<p> <?php echo $offer_description; ?></p>
								</div>
								<div class="clearfix"></div>
								<div class="box-footer"><a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">Read More...</a></div>
							</div>
							
						<?php
						}
						else if($offer=='1')
						{
							$offer='2';
						?>
							
							<div class="box box-warning box-solid"  id="offer_block">
								<div class="box-header with-border text-center">
									<h3 class="box-title text-center">Merchant - <?php echo $row[0]['First_name'].' '.$row[0]['Last_name']; ?></h3>
								</div>
								<div class="box-body">
									<p class="text-center" style="border-bottom: 1px solid rgb(204, 204, 204);">
										<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">
											<strong><?php echo $row[0]['communication_plan']; ?></strong>
										</a>
									</p>
									<p><?php echo $offer_description; ?></p>
								</div>
								<div class="clearfix"></div>
								<div class="box-footer"><a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">Read More...</a></div>
							</div>
							
						<?php
						}
						else if($offer=='2')
						{
							$offer='3';
						?>
							
							<div class="box box-danger box-solid"  id="offer_block">
								<div class="box-header with-border text-center">
									<h3 class="box-title text-center">Merchant - <?php echo $row[0]['First_name'].' '.$row[0]['Last_name']; ?></h3>
								</div>
								<div class="box-body">
									<p class="text-center" style="border-bottom: 1px solid rgb(204, 204, 204);">
										<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">
											<strong><?php echo $row[0]['communication_plan']; ?></strong>
										</a>
									</p>
									<p><?php echo $offer_description; ?></p>
								</div>
								<div class="clearfix"></div>
								<div class="box-footer"><a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">Read More...</a></div>
							</div>
							
						<?php
						}
						else if($offer=='3')
						{
							$offer='0';
						?>
							
							<div class="box box-info box-solid"  id="offer_block">
								<div class="box-header with-border text-center">
									<h3 class="box-title text-center">Merchant - <?php echo $row[0]['First_name'].' '.$row[0]['Last_name']; ?></h3>
								</div>
								<div class="box-body">
									<p class="text-center" style="border-bottom: 1px solid rgb(204, 204, 204);">
										<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">
											<strong><?php echo $row[0]['communication_plan']; ?></strong>
										</a>
									</p>
									<p><?php echo $offer_description; ?></p>
								</div>
								<div class="clearfix"></div>
								<div class="box-footer"><a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">Read More...</a></div>
							</div>
							
						<?php
						}
					}
				}
				
				if($offer_flag == 0)
				{
				?>
				
					<div class="box box-info box-solid">
						<div class="box-body">
							<p class="text-center">
								<strong>Currently there are no Offers..!!</strong>
							</p>
						</div>
					</div>
				
				<?php
				}
				?>				
			</div>
			
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border text-center">
						<h3 class="box-title">Latest Auction</h3>
					</div>
					
					<div class="box-body">
						<ul class="products-list product-list-in-box">
							
							<?php
							$today=date('Y-m-d');
							$color_flag='0';
							$Auction_flag='0';
							$count=count($Company_TOP3_Auction);
							if($count > '0' )
							{
								foreach($Company_TOP3_Auction as $TOP3Auction)
								{
									$Auction_flag='1';
									$base_url = base_url();
									$str = str_replace('Company_'.$TOP3Auction['Company_id'], "", $base_url);
									$filepath = substr($str, 0, -2);
									
									if($today >= date('Y-m-d',strtotime($TOP3Auction['From_date'])) && $today <= date('Y-m-d',strtotime($TOP3Auction['To_date'] )))
									{
									?>

										<li class="item">
											<div class="product-img">
												<a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding">
													<img src="<?php echo $this->config->item('base_url2')?><?php echo $TOP3Auction['Prize_image'];?>" width="50" height="50" alt="<?php echo $TOP3Auction['Auction_name']; ?>">
												</a>
											</div>
											<div class="product-info">
												<a href="javascript::;" class="product-title">
													<a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding">
														<?php echo $TOP3Auction['Auction_name']; ?> 
													</a>
												</a>
												<span class="product-description">
													<?php echo $TOP3Auction['Prize_description']; ?>
												</span>
												<br>
												<p><span class="label label-danger">End Date <?php echo date('j F, Y', strtotime($TOP3Auction['To_date']));?></span></p>
											</div>
										</li>
									
									<?php
									}
									else
									{
									?>
									
										<li class="item">
											<div class="product-info" style="margin: 0px;">
												<h4 class="text-center">Currently there are No Auctions</h4>
											</div>
										</li>
									
									<?php
									}
								}
							}
							?>
							
						</ul>
					</div>
					 
					<?php if($Auction_flag=='1'){ ?>
					<div class="box-footer text-center">
						<a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding" class="uppercase">View All Auctions</a>
					</div>
					<?php } ?>
				</div>
			</div>
			
		</div>
        

	</section>
 
<?php $this->load->view('header/footer');?>  

<style>
div #offer_block img {
    width: 100%;
    height: auto;
}
#google-map {
    height: 50% !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
}
</style>
<!------------------------------------------Google Map---------------------------------------------->
<script type='text/javascript' src='<?php echo base_url();?>assets/jquery-migrate.js'></script>
<script src="https://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/gmaps.js'></script>
<!------------------------------------------Google Map---------------------------------------------->