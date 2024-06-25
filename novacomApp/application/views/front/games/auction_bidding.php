<!DOCTYPE html>
<html lang="en">
<head>
<title>Auction</title>	
<?php 
	$this->load->view('front/header/header'); 
	$Login_Enroll=$Enroll_details->Enrollement_id; 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
<script>
	function countdown(days,hour,min,sec,auction_id,i) 
	{
		if(sec <= 0 && min > 0)
		{
			sec = 59;
			min -= 1;
		}
		else if(min <= 0 && sec <= 0)
		{
			min = 0;
			sec = 0;
		}
		else
		{
			sec -= 1;
		}

		if(min <= 0 && hour > 0)
		{
			min = 59;
			hour -= 1;
		}
		 
		var pat = /^[0-9]{1}$/;
		sec = (pat.test(sec) == true) ? '0'+sec : sec;
		min = (pat.test(min) == true) ? '0'+min : min;
		hour = (pat.test(hour) == true) ? '0'+hour : hour;
		days = (pat.test(days) == true) ? '0'+days : days;
		
		var auctiondiv = 'strclock_'+i;
		
		var Days = 'Days_'+i;
		var Hours = 'Hours_'+i;
		var Minutes = 'Minutes_'+i;
		var Seconds = 'Seconds_'+i;
		document.getElementById(Days).innerHTML = days+" : Days ";
		document.getElementById(Hours).innerHTML = hour+" : Hrs ";
		document.getElementById(Minutes).innerHTML = min+" : Min ";
		document.getElementById(Seconds).innerHTML = sec+" : Sec";
		if(days ==00 && hour ==00 && min ==00 && sec ==00 )
		{
			window.location='auctionbidding';
		}
		setTimeout
		(
			function()
			{ 
				countdown(days,hour,min,sec,auction_id,i);
			}, 
			1000
		);
	}
</script>
<body> 
    <form  name="auction" method="POST" action="<?php echo base_url()?>index.php/Cust_home/update_promocode_App" enctype="multipart/form-data">	
	<?php	
		foreach($Seller_details as $seller)
		{
			 $timezone= $seller["timezone_entry"];
		}	
		 // echo "timezone---->".$timezone."<br>";
		$i=1;
		// $today=date('Y-m-d H:i:s');
		// $current_time = date('H:i:s');
		
	?>
    <div id="application_theme" class="section pricing-section">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url();?>index.php/Cust_home/Load_playGame_App" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Auction</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
	<?php			
	$count=count($CompanyAuction);
		if($count > '0' )
		{
			foreach($CompanyAuction as $auction)
			{
					$Auction_id= $auction['Auction_id'];
					$From_date=date('Y-m-d H:i:s',strtotime($auction['From_date']));
					$To_date=date('Y-m-d H:i:s',strtotime($auction['To_date']));
					$End_time=date('H:i:s',strtotime($auction['End_time']));

					$datetime2 = $auction['To_date'];
					$datetime3 = $auction['End_time'];						
					$combinedDT = date('Y-m-d H:i:s', strtotime("$datetime2 $datetime3"));
					$datetime3 = new DateTime(); //Current Date time						
					$datetime3->setTimezone(new DateTimeZone($timezone));
					$datetime4 = new DateTime($combinedDT); // Combined Date Time						
					$interval = $datetime3->diff($datetime4);			
					$Auction_id = $auction['Auction_id'];						
					$days = $interval->format('%a');
					$hours = $interval->format('%H');
					$minutes = $interval->format('%i');
					$seconds = $interval->format('%S');	
					$today=$datetime3->format('Y-m-d H:i:s');
					$current_time=$datetime3->format('H:i:s');
					$current_hours=$datetime3->format('H');
					$current_minute=$datetime3->format('i');
					$current_second=$datetime3->format('s');
					$end_hours = date('H', strtotime($datetime3));
					
					$hours2= date('H', strtotime($auction['End_time']));
					$minutes2= date('i', strtotime($auction['End_time']));
					$seconds2= date('s', strtotime($auction['End_time']));
				
				if(($today >= $From_date ) && ($today <=$combinedDT  ))
				{	
					foreach($Auction_Max_Bid_val[$auction['Auction_id']] as $bid)
					{
					?>
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
					
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">	
												<div class="col-xs-12" style="padding: 10px;">
													<img src="<?php echo $this->config->item('base_url2')?><?php echo $auction['Prize_image'];?>" alt="" class="img-rounded img-responsive" width="50%;">
												</div>
												<strong id="Large_font" ><?php echo $auction['Auction_name']; ?></strong><br>
											<?php
													if($Top5_Auction_Bidder[$auction['Auction_id']] != "")
													{	
														$j = 0;
														$len = count($Top5_Auction_Bidder[$auction['Auction_id']]);									
														foreach($Top5_Auction_Bidder[$auction['Auction_id']] as $Top5)
														{										
															 if ($j == 0) 
															 {										 
																$highest_bidder= $Top5['Enrollment_id'];											
																if($Login_Enroll==$highest_bidder)
																{
																?>
																<br><strong id="Medium_font" style="color:#41ad41;">You are Highest Bidder</strong>
																<?php 
																} 
																else 
																{													
																?>
																<br><strong id="Medium_font" style="color:#FF0000;">You are No Longer Highest Bidder</strong>	
																<?php
																}
															} 
															else if ($j == $len - 1) 
															{
																// $button_flag='1';
															}								
															$j++;
														}
													}
													else
													{							
													?>
														
															<br><strong id="Medium_font">Become First Bidder</strong>
														
													<?php
													}
													?>
											
											<address>
											<div id="desc1">											
												<span class="label label-info button" id="Days_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info button" id="Hours_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info button" id="Minutes_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info button" id="Seconds_<?php echo $i; ?>"></span>
												
												
												<script>
													var days = '<?php echo $days; ?>';
													var hour = '<?php echo $hours; ?>';
													var min = '<?php echo $minutes; ?>';
													var sec = '<?php echo $seconds; ?>';
													var auction_id = '<?php echo $Auction_id; ?>';						
													var count = '<?php echo $count; ?>';
													var i = '<?php echo $i; ?>';
													countdown(days,hour,min,sec,auction_id,i);
												</script>
												</br></br>
													<span style="color: #ff3399;margin-bottom: 0; font-size: 12px;"><strong>Minimum Bid Value: 	<strong>
													<?php
													if($bid['Bid_value']=='')
													{
														echo $Min_BId_Value = $auction['Min_bid_value'] ; 
													}
													else
													{
														echo $Min_BId_Value = $bid['Bid_value'] + $auction['Min_increment']; 
													}
													?>
																</strong>
															</strong>
													</span><br>
												<a href="javascript:void(0)" style="text-decoration:none;cursor:default;">
													<form action="" method="post">
														<span id="address" >  
															<input type="tel" name="Bid_val" id="<?php echo $i.'Bid_val'; ?>" placeholder="Enter Bid Value" class="txt" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Validate_bid_value(this.value,'<?php echo $i.'Bid_val'; ?>')">
														</span>	
														<span class="input-group-btn" style="margin-left: -9%;">
															<button type="button" style="padding: 16% 4px; margin-top: 20%; border-radius: 0px; background: #d9e7e7;" class="btn btn-default"  Onclick="insert_bidding('<?php echo $i; ?>','<?php echo $auction['Auction_id'];?>','<?php echo $Min_BId_Value; ?>','<?php echo $bid['Bid_value']; ?>','<?php echo $auction['Prize']; ?>','<?php echo $auction['Auction_name']; ?>');"   >Bid Now</button>
														</span>	
														<div class="help-block" style="float: center;"></div>
														<div class="help-block1" style="float: center;"></div>
													</form>
												</a> 
													<br>
													<span style="color: #a8a8a8; float:left; font-size: 10px; margin-left:2%;">
													<strong id="Value_font"><?php echo $auction['Prize_description']; ?></strong>
													</span>
												</div>
											</address>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	<br>	
		<?php
					}				
					$i++;
				}
			}
		}	
		else
		{ 
		?>
		<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
			<div class="pricing-details">
				<div class="row">
					<div class="col-md-12">
						<div class="row ">
							<div class="col-xs-12 " style="width: 100%;">	
								<a href="#" class="uppercase">Currently No Auction</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php 	}	?>						
				</div>
			</div>
		</div>
    </div>
	
<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;">
					 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
<!-- Loader -->
	</form>
   <?php $this->load->view('front/header/footer'); ?> 
 </body>
</html>
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
		text-align: center;
	}
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	address{
		font-size: 13px;
	}
	
	
	.btn 
	{
		color: <?php echo $Button_font_details[0]['Button_font_color'];?>;
		border-color: <?php echo $Button_font_details[0]['Button_border_color'];?>;
		background-color: <?php echo $Button_font_details[0]['Button_background_color'];?>;
		padding: 7px;
		font-size: 12px;
		font-weight: bold;
		border-radius: 15px;
	}
	.card-span {

		color: #1fa07f; !important;
		font-size: 12px !important;
		display: inline;
	}
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
	
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0;
		outline: none;
	}
	.txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0;
		outline: none;
	}
	
	#desc1{
		width:100%;
	}
	
	#button{
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		padding: 0 3%;
		border-radius: 15px;
		margin: 8% 1%;
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
	}
	.button{
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		padding: 0 2%;
		border-radius: 15px;
		margin: 8% 1%;
		color: <?php echo $Button_font_details[0]['Button_font_color'];?>;
	}
	
	/* Search Bar Css */
	.txt{
		border: none;
		padding: 1% 0 0 0;
		width:56%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #1fa07f;
		height: 35px;
	}
	
	#search{
		font-size:20px;
		margin-left: 6%;
		color: #1fa07f;
		
	}
	::placeholder {
	color: gray;
	}
	
	#address{
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		padding: 0;
		margin: 8% 8%;
		color: #1fa07f;
	}
	/* Search Bar Css Ended*/	
</style>
<script>
	function Validate_bid_value(bidVal,inputID)
	{
	<?php
		$Current_balance = $Enroll_details->Current_balance-($Enroll_details->Blocked_points+$Enroll_details->Debit_points);
					
		if($Current_balance<0)
		{
			$Current_balance=0;
		}
		else
		{
			$Current_balance=$Current_balance;
		} ?>
		var current_bal='<?php echo $Current_balance; ?>';
		if( Math.round(bidVal) > Math.round(current_bal))
		{
			var msg = "Insufficient Balance to Bid this Auction!";
			// var Title = "In-appropriate Data";
			// alert(msg);
			 document.getElementById(inputID).value='';
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			// runjs(Title,msg);
			return false;			
		}
	}		
	function insert_bidding(iseries,auctionID,min_value,Max_Bid_value,Prize,Auction_name)
	{
	<?php
		$Current_balance = $Enroll_details->Current_balance-($Enroll_details->Blocked_points+$Enroll_details->Debit_points);
					
		if($Current_balance<0)
		{
			$Current_balance=0;
		}
		else
		{
			$Current_balance=$Current_balance;
		} 
		?>
		
		var custEnrollId ='<?php echo $Enroll_details->Enrollement_id; ?>';
		var compid = '<?php echo $Enroll_details->Company_id; ?>';					
		var Current_balance = '<?php echo $Current_balance; ?>';		
		var bidval = document.getElementById(iseries+"Bid_val").value;	
	
		var min_value1 = min_value;	
		var Title = "In-appropriate Data";
		if(bidval == "0" || bidval == "")
		{
			var msg = "Please Enter Bid Value Greater Than 0!";
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			return false;
			
		}
		else if(Math.round(bidval * 100) < Math.round(min_value1 * 100))
		{
			var msg='Please Enter Bid Value Greater Than Min Bid Value';
			
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			return false;
			
		}
		else if(Math.round(bidval * 100) >= Math.round(min_value1 * 100))
		{
			
			setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},2000);
			
			$.ajax(
			{
				type: "POST",
				data: {custEnrollId: custEnrollId,compid:compid,auctionID:auctionID,bidval:bidval,Current_balance:Current_balance,Prize:Prize},
				dataType: 'json',
				url: "<?php echo base_url()?>index.php/Cust_home/insertauctionbidding",
				success: function(data)
				{
					
					if(data.res == 1) 
					{	
						var msg='Congrats! Your Bid For Auction is Successful!';
			
						$('.help-block1').show();
						$('.help-block1').css("color","green");
						$('.help-block1').html(msg);
						setTimeout(function(){ $('.help-block1').hide(); }, 10000);
						
						location.reload();
					}
					else
					{
						var msg='Your Bid For Auction is Un-Successful!';
			
						$('.help-block1').show();
						$('.help-block1').css("color","red");
						$('.help-block1').html(msg);
						setTimeout(function(){ $('.help-block1').hide(); }, 10000);
						
						location.reload();
					}			
				}
			});
			return true;
		}
	}
</script>