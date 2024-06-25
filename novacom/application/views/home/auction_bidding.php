<?php
$this->load->view('header/header');
echo form_open_multipart('Cust_home/auctionbidding'); 
$Login_Enroll=$Enroll_details->Enrollement_id; 
?>

<section class="content-header">
  <h1>Auction Bidding</h1>  
</section>

<section class="content">
	<div class="row">
		 
		<?php if($this->session->flashdata('msg')){ ?>
			<p><?php echo $this->session->flashdata('msg'); ?></p>
		<?php } ?>
		
				<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
				<script>
						BootstrapDialog.show({
						closable: false,
						title: 'Application Information',
						message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
						buttons: [{
							label: 'OK',
							action: function(dialog) {
								window.location='<?php echo base_url()?>index.php/Cust_home/home';
							}
						}]
					});
					runjs(Title,msg);
				</script>
			<?php } ?>

		
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
	
		<?php	
		foreach($Seller_details as $seller)
		{
			 $timezone= $seller["timezone_entry"];
		}	
		// echo "timezone---->".$timezone."<br>";
		$i=1;
		// $today=date('Y-m-d H:i:s');
		

		
		// $current_time = date('H:i:s');
		
		
		$count=count($CompanyAuction);
		if($count > '0' )
		{
			foreach($CompanyAuction as $auction)
			{
					$Auction_id= $auction['Auction_id'];
					$From_date=date('Y-m-d H:i:s',strtotime($auction['From_date']));
					$To_date=date('Y-m-d H:i:s',strtotime($auction['To_date']));
					$End_time=date('H:i:s',strtotime($auction['End_time']));
					
					// echo "Auction_id---->".$Auction_id."<br>";
					// echo "End_time---->".$End_time."<br>";
					
				
				
					
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
				
					// echo "hours2---->".$hours2."<br>";
					
					// echo "minutes2---->".$minutes2."<br>";
					// echo "seconds2---->".$seconds2."<br>";
				
				// echo"<br>if(($today >= $From_date ) && ($today <=$combinedDT  ))";
				if(($today >= $From_date ) && ($today <=$combinedDT  ))
				{
		
						

						
		
					foreach($Auction_Max_Bid_val[$auction['Auction_id']] as $bid)
					{
						// echo "days---->".$days."<br>";
						// echo "hours---->".$hours."<br>";
						
						
						
					?>
				
						<div class="col-md-4">
							<div class="box box-widget widget-user-2" style="min-height: 350px;">
								<div class="widget-user-header bg-yellow">
									<div class="widget-user-image">
										<img class="img-rounded img-responsive" src="<?php echo $this->config->item('base_url2')?><?php echo $auction['Prize_image'];?>" width="128" height="128" alt="<?php echo $auction['Auction_name']; ?>">
									</div>
									<h5 class="text-center"><strong><?php echo $auction['Auction_name']; ?></strong></h5>
									<h5 class="widget-user-desc">&nbsp;</h5>
								</div>						
								<div class="box-footer no-padding">
									<div class="row">
										<div class="col-md-12">
											<div class="description-block">
												<p class="text-center">
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
																	<h5 class="description-header">
																		<strong>You are Highest Bidder</strong>
																	</h5>														
																<?php 
																} 
																else 
																{													
																?>
																	<h5 class="description-header">
																		<strong>You are No Longer Highest Bidder</strong>
																	</h5>
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
														<h5 class="description-header">
															<strong>Become First Bidder</strong>
														</h5>
													<?php
													}
													?>	
												</p>
											</div>
										</div>
										
										<div class="col-md-12">
											<div class="description-block">
												<span class="label label-info" id="Days_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info" id="Hours_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info" id="Minutes_<?php echo $i; ?>"></span>&nbsp;
												<span class="label label-info" id="Seconds_<?php echo $i; ?>"></span>
												
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
											</div>
										</div>										
										<div class="col-md-12">
											<div class="description-block">
												<p>
													<h5 class="description-header">
														Minium Bid Value:&nbsp;&nbsp;
														<strong>
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
													</h5>
												</p>
											</div>
										</div>										
										<div class="col-md-12">
											<ul class="nav nav-stacked">
												<li>
													<a href="javascript:void(0)" style="text-decoration:none;cursor:default;">
														<form action="" method="post">
															<div class="input-group  has-feedback" >
																<input  value="" type="text" name="Bid_val" id="<?php echo $i.'Bid_val'; ?>" onchange="Validate_bid_value(this.value,'<?php echo $i.'Bid_val'; ?>')" placeholder="Enter Bid Value" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')">
																
																<span class="input-group-btn">
																	<button type="button" class="btn btn-primary btn-flat"  Onclick="insert_bidding('<?php echo $i; ?>','<?php echo $auction['Auction_id'];?>','<?php echo $Min_BId_Value; ?>','<?php echo $bid['Bid_value']; ?>','<?php echo $auction['Prize']; ?>','<?php echo $auction['Auction_name']; ?>');"   >Bid Now</button>
																</span>
															</div>	
														</form>
													</a>
												</li>
												
												<li>
													<a href="javascript:void(0)" style="text-decoration:none;cursor:default;">
														<?php echo $auction['Prize_description']; ?>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
						  </div>
						</div>
					
				<?php
					}				
					$i++;
				}
			}
		}
		else
		{ 
		?>		
			<div class="box-footer text-center">
				<a href="#" class="uppercase">Currently No Auction</a>
			</div>
		<?php }	?>
    </div>
	
</section>

<?php echo form_close(); ?>
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>

<style> 
.direct-chat-img 
{
	border-radius: 50%;
	float: left;
	height: 90%;
	width: 100%;
}

.direct-chat-img
{    
    height: 45%;
    width: 60%;
}

.direct-chat-messages
{
	min-height: 300px;
}

.label
{
	font-size:100%;
}
</style>
	
<script>
	function Validate_bid_value(bidVal,inputID)
	{
		var current_bal='<?php echo $Current_balance=$Enroll_details->Total_balance; ?>';
		if( Math.round(bidVal) > Math.round(current_bal))
		{
			var msg = "Insufficient Balance to Bid this Auction!";
			var Title = "In-appropriate Data";
			document.getElementById(inputID).value='';
			runjs(Title,msg);
			return false;			
		}
	}		
	function insert_bidding(iseries,auctionID,min_value,Max_Bid_value,Prize,Auction_name)
	{		
		var custEnrollId ='<?php echo $Enroll_details->Enrollement_id; ?>';
		var compid = '<?php echo $Enroll_details->Company_id; ?>';					
		var Current_balance = '<?php echo $Enroll_details->Current_balance; ?>';		
		var bidval = document.getElementById(iseries+"Bid_val").value;			
		var min_value1 = min_value;	
		var Title = "In-appropriate Data";
		if(bidval == "0" || bidval == "")
		{
			var msg = "Please Enter Bid Value Greater Than 0!";
			runjs(Title,msg);
			return false;
		}
		else if(Math.round(bidval * 100) < Math.round(min_value1 * 100))
		{
			var msg='Please Enter Bid Value Greater Than Min Amount Value';
			runjs(Title,msg);
			return false;
		}
		else if(Math.round(bidval * 100) >= Math.round(min_value1 * 100))
		{
			show_loader();
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
						BootstrapDialog.show({
							closable: false,
							title: 'Congrats! Your Bid For Auction is Successful!',
							message: 'Do you wish to place another Bid?',
							buttons: [{
								label: 'Yes',
								action: function(dialog) {
									window.location='<?php echo base_url()?>index.php/Cust_home/auctionbidding';
								}
							},{
								label: 'Home',
								action: function(dialog) {
									window.location='<?php echo base_url()?>index.php/Cust_home/home';
								}								
							}]
						});
					}
					else
					{
						BootstrapDialog.show({
							closable: false,
							title: 'Your Bid For Auction is Un-Successful!',
							message: 'Do you wish to place another Bid?',
							buttons: [{
								label: 'Yes',
								action: function(dialog) {
									window.location='<?php echo base_url()?>index.php/Cust_home/auctionbidding';
								}
							},{
								label: 'Home',
								action: function(dialog) {
									window.location='<?php echo base_url()?>index.php/Cust_home/home';
								}								
							}]
						});
					}				
				}
			});
			return true;
		}
	}
</script>
	<style>
	
	</style>
	
