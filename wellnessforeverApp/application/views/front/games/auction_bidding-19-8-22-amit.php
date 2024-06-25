<?php $this->load->view('front/header/header'); 
$Login_Enroll=$Enroll_details->Enrollement_id; 
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?>
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


<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Auction</h1></div>
				<div class="leftRight"><button></button></div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom passChanWrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
                <!--<h1 class="text-center pb-4">Change password</h1>-->
                <p class="text-center">Bid Now and become a Winner for the below coveted Prize!!</p>
				 <?php 
				// $data = array('onsubmit' => "return Change_pin('old_pin.value,new_pin.value,confirm_pin.value');");  
				echo form_open_multipart('Cust_home/update_promocode_App');?>
				
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
										
										
											
												
													
														
															
																	<p class="text-center">
																	<img src="<?php echo $this->config->item('base_url2')?><?php echo $auction['Prize_image'];?>" alt="" class="img-rounded img-responsive" >
																	</p>
																	<br>
																	<p class="text-center"><?php echo $auction['Auction_name']; ?></p><br>
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
																					// echo"<br>---highest_bidder--".$highest_bidder;									
																					// echo"<br>---Login_Enroll--".$Login_Enroll;									
																					if($Login_Enroll==$highest_bidder)
																					{
																					?>
																					<br><strong style="color:#41ad41;">You are Highest Bidder</strong>
																					<?php 
																					} 
																					else 
																					{													
																					?>
																					<br><strong style="color:#FF0000;">You are No Longer Highest Bidder</strong>	
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
																			
																				<br><strong>Become First Bidder</strong>
																			
																		<?php
																		}
																		?>
																
																
																<div id="desc1" class="mt-3">											
																	<strong class="font-weight-bold" id="Days_<?php echo $i; ?>"></strong>&nbsp;
																	<strong class="font-weight-bold" id="Hours_<?php echo $i; ?>"></strong>&nbsp;
																	<strong class="font-weight-bold" id="Minutes_<?php echo $i; ?>"></strong>&nbsp;
																	<strong class="font-weight-bold" id="Seconds_<?php echo $i; ?>"></strong>
																	
																	
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
																		<strong>Minimum Bid Value: 
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
																		<br>
																		
																			<form action="" method="post">
																				<div class="form-group mt-3"> 
																					<input type="tel" class="form-control" name="Bid_val" id="<?php echo $i.'Bid_val'; ?>" placeholder="Enter Bid Value" class="txt" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Validate_bid_value(this.value,'<?php echo $i.'Bid_val'; ?>')">
																				
																					<button type="button" class="redBtn w-100 text-center mt-3"  Onclick="insert_bidding('<?php echo $i; ?>','<?php echo $auction['Auction_id'];?>','<?php echo $Min_BId_Value; ?>','<?php echo $bid['Bid_value']; ?>','<?php echo $auction['Prize']; ?>','<?php echo $auction['Auction_name']; ?>');"   >Bid Now</button>
																				</div>	
																				<div class="help-block" style="float: center;"></div>
																				<div class="help-block1" style="float: center;"></div>
																			</form>
																		
																		
																		
																		<p ><?php echo $auction['Prize_description']; ?></p>
																		
																	</div>
																
															
														
													
												
											
										
										<br>	
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
				
				
                   
			  <?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>
<!-- Loader --> 
    <div class="container" >
		 <!-- Modal -->
		  <div class="modal fade" id="myModalac" role="dialog" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog" style="margin-top: 65%;">
			
			  <!-- Modal content-->
			  <div class="modal-content" style="background-color: transparent;border:none;box-shadow: none;">
				<div class="modal-header">
				  
				  <h4 class="modal-title">Application Information</h4>
				</div>
				<div class="modal-body">
				  <p>Company work in progress... Will be up soon...Sorry for the inconvenience</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="redBtn w-100 text-center" data-dismiss="modal" onClick="window.location.href='<?php echo base_url()?>index.php/Cust_home/front_home';">OK</button>
				</div>
			  </div>
			  
			</div>
		  </div>
		  <!-- Modal -->     
    </div>
<!-- Loader -->

<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model" style="background-color: transparent;border:none;box-shadow: none;">
				   <div class="modal-body" style="padding: 10px 0px;">
					 <img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
<!-- Loader -->
<!-- Loader --> 
    <div class="container" >
		 <div class="modal fade" id="myModal2" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;background-color:#d0112b;">
					 <div class="help-block1" style="color:#fff;padding:5px;"> </div>
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
		 </div>       
    </div>
<!-- Loader -->
<?php $this->load->view('front/header/footer');  ?>

<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
		$('#myModalac').modal('show');		
	</script>
<?php } ?>
<!------------------------------------------------------------------------------------------------------->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css" rel="stylesheet"/>
 <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>


<!--Click to Show/Hide Input Password JS-->
	<script type="text/javascript">
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
			},3000);
			
			$.ajax(
			{
				type: "POST",
				data: {custEnrollId: custEnrollId,compid:compid,auctionID:auctionID,bidval:bidval,Current_balance:Current_balance,Prize:Prize},
				dataType: 'json',
				url: "<?php echo base_url()?>index.php/Cust_home/insertauctionbidding",
				success: function(data)
				{
					
					setTimeout(function() 
					{ 
						$('#myModal').modal('hide'); 
					},1000);
					
					
					if(data.res == 1) 
					{	
				
						var msg='Congrats! Your Bid For Auction is Successful!';
						$('#myModal').modal('hide');
						$('.help-block1').show();
						$('.help-block1').css("color","white");
						$('.help-block1').html(msg);
						
						/* setTimeout(function(){$('.help-block1').hide();  }, 5000); */
						
						setTimeout(function() 
						{
							$('#myModal2').modal('show'); 
						}, 0);
						setTimeout(function() 
						{ 
							$('#myModal2').modal('hide'); 
							location.reload();
							
						},3000);
				
						
			
						
						
						
					}
					else
					{
						$('#myModal').modal('hide');
						
						var msg='Your Bid For Auction is Un-Successful!';
			
						$('.help-block1').show();
						$('.help-block1').css("color","white");
						$('.help-block1').html(msg);
						// setTimeout(function(){ $('.help-block1').hide(); }, 10000);
						
						setTimeout(function() 
						{
							$('#myModal2').modal('show'); 
						}, 0);
						setTimeout(function() 
						{ 
							$('#myModal2').modal('hide'); 
							location.reload();
							
						},3000);
						
						
						
						
					}			
				}
			});
			return true;
		}
	}
</script>