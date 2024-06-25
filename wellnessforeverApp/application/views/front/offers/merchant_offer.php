<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Offers</title>	
<?php $this->load->view('front/header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 

$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
 $Menu_access_details = json_decode($Menu_access_data, true); 
 
 
 
 
 
						$ci_object = &get_instance(); 
						$ci_object->load->model('Igain_model');
							
								$Enrollement_id=$Enroll_details->Enrollement_id;
								$Company_id=$Enroll_details->Company_id;
								$Card_id=$Enroll_details->Card_id;
								// var_dump($Next_Tier_Details);
								$Next_Tier_name=$Next_Tier_Details->Tier_name;
								$Tier_level_id=$Next_Tier_Details->Tier_level_id;
								$Excecution_time=$Next_Tier_Details->Excecution_time;
								$Tier_criteria=$Next_Tier_Details->Tier_criteria;
								$Criteria_value=$Next_Tier_Details->Criteria_value;
								$Operator_id=$Next_Tier_Details->Operator_id;
								
								
								// echo '------Next_Tier_name------'.$Next_Tier_name."---<br>"; 
								
								if($Operator_id==1)
								{
									$OperatorName="=";
								}
								else if($Operator_id==2)
								{
									$OperatorName=">";
								}
								else if($Operator_id==3)
								{
									$OperatorName=">=";
								}
								else if($Operator_id==4)
								{
									$OperatorName="<";
								}
								else if($Operator_id==5)
								{
									$OperatorName="<=";
								}
								else
								{
									$OperatorName=" ";
								}
								
								if($Tier_criteria==1)
								{
									$criteriaName='Cumulative Spend';
								
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 	
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend;
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
									}
								}
								else if($Tier_criteria==2)
								{
									$criteriaName='Cumulative Number of Transactions';
										
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 		
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										$Tier_value=" Earn <b>".$Criteria_value."</b> ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
										
										// $Tier_value=" Earn <b>".$Criteria_value."</b> Points and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
									}
								}
								else if($Tier_criteria==3)
								{
									$criteriaName='Cumulative '.$Company_Details->Currency_name.' Accumlated';
									
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										
										// echo '<br>Cumulative Points Accumlated---- '.$Total_Points; 	
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										
										// echo '<br>Cumulative Points Accumlated----- '.$Total_Points; 
									}
								}
								else if($Tier_criteria==4)
								{
									$criteriaName='Tenor - No. of Days';
									$Todays_date=date("Y-m-d");
									$From_date = strtotime($Todays_date .' -'.$Criteria_value.' days');
									$From_date=date("Y-m-d",$From_date);
									$Trans_Records2 = $this->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date);
									// $Remaning_value=$Trans_Records2->Total_Spend;
									// echo "<br><b>Total_Spend -->".$Remaning_value."</b>";
								}
								else
								{
									$criteriaName='-';
								}
								
						
						/* echo '------Tier_value------'.$Tier_value."---<br>";
						echo '------Criteria_value------'.$Criteria_value."---<br>"; */
						
						// echo '------Next_Tier_name------'.$Next_Tier_name."---<br>"; 
						// echo '------Next_TierLevelId------'.$Next_TierLevelId."---<br>"; 
 
	$Current_point_balance = ($Enroll_details->Total_balance-($Enroll_details->Debit_points + $Enroll_details->Block_points));
				
	if($Current_point_balance<0)
	{
	 $Current_point_balance=0;
	} else{
		$Current_point_balance=$Current_point_balance;
	} 
	$Tier_value_points=($Criteria_value-$Current_point_balance);
	/* echo '------Current_point_balance------'.$Current_point_balance."---<br>";
	echo '------Tier_value_points------'.$Tier_value_points."---<br>"; */
	
 ?> 	
</head>
<body>
<div id="application_theme" class="section pricing-section" style="min-height: 530px;">
    <div class="container" id="top_container">
        <div class="section-header">          
			<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Benefits & Offers</p>
		</div>
		
        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
					<div class="pricing-details">
						<strong>
							 
							
							<span id="ud" class="Medium_font mr-5">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/merchantoffers">Benefits</a>
							</span>|
							<span class="Medium_font mr-5">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/MerchantReferralOffers">Referral</a>
							</span>|
							<span class="Medium_font">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/MerchantCommunication">Offers</a>
							</span>
						</strong>
						
						<br>					
                            <div class="row" style="margin: auto;">
                                <div class="col-md-12" style="margin: auto;" >                                    
                                     <table id="myTable" align="center" class="text-left">                               
                                             
                                            <tr>
                                                <td colspan="2"  class="text-center">													
													<img src="<?php echo $this->config->item('base_url2')."images/dashboard_profile.png"; ?>" alt="" class="rounded-circle" width="100" height="90">
												</td>												
                                            </tr> 
											<tr>                                               
												<td colspan="2"  class="text-center"  style="line-height: 10px;">
													<span id="Value_font"><strong><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name;?></strong></span><br>
												<?php /***** Hide cahnge Ravi--24-09-2019------ */ ?>
													<span id="Value_font"><strong><?php echo $Tier_details->Tier_name." Member";?></strong></span>
													
													<?php /*----------Hide cahnge Ravi--24-09-2019-------********/ ?>
													
												</td>												
                                            </tr> 
											 
											<?php /***** Hide cahnge Ravi--24-09-2019------ */ ?>
											<tr>
												
												<td style="line-height: 10px;">
													<span id="Medium_font" ><strong>Membership Id</strong></span>
													<span id="Value_font"><strong>:&nbsp;<?php echo $Enroll_details->Card_id; ?></strong></span><br>
													<span id="Medium_font" >
														<strong>Current <?php echo $Company_Details->Currency_name; ?></strong>
													</span>
													<span id="Value_font"><strong>:&nbsp;<?php echo $Current_point_balance;?></strong></span>
												</td>										
                                            </tr>
											<?php /*----------Hide cahnge Ravi--24-09-2019-------********/ ?>
											                                        
                                    </table>		
                                </div>
                            </div>
                       
						<?php 
						
							$LTY_Offers_flag=0;
							foreach($SellerLoyaltyOffers as $LTY_Offers)
							{
								if($LTY_Offers)
								{
									$LTY_Offers_flag=1;
								}
							}						
							// echo"LTY_Offers_flag-----------".$LTY_Offers_flag;	
								
								if($LTY_Offers_flag==1)
								{
								
									foreach($SellerLoyaltyOffers as $LTY_Offers) 
									{
										if($LTY_Offers)
										{
											$Photograph = $LTY_Offers->Photograph;
											if($Photograph=="")
											{
												$Photograph='images/no_image.jpeg';
											}
											
										$str = substr($LTY_Offers->Loyalty_name,0,2);
										if($str=='BA')
										{
											$str1='Paid Amount';
										}
										if($str=='PA')	
										{
											$str1='Purchase Amount';
										}
										
										
										$Transaction_count = $ci_object->Igain_model->Check_transaction_count($LTY_Offers->Enrollement_id,$LTY_Offers->Company_id,$enroll); 
										
										if($Enroll_details->Tier_id >= $LTY_Offers->Loyalty_Tier_id) {
										
										?>
												<div class="row" > 
													<div class="col-md-12">
														<a href="<?=base_url()?>index.php/Cust_home/Loyalty_Offers_Detail?LoyaltyId=<?php echo $LTY_Offers->Loyalty_id;?>&Company_id=<?php echo $LTY_Offers->Company_id;?>">
															<div class="row" id="Lulu">
																<div class="col-xs-4" style="padding: 10px;" >
																	<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
																</div>											
																<div class="col-xs-8 text-left" id="detail">
																
																	<strong id="Large_font"><?php echo $LTY_Offers->First_name.' '.$LTY_Offers->Last_name; ?></strong><br />
																							
																	<span id="Medium_font" ><strong><?php echo substr($LTY_Offers->Loyalty_name,3); ?></strong></span><br />
													
																	<span id="Value_font"><strong><?php 
																	
																	
																	if($LTY_Offers->Loyalty_at_transaction!= '0.00') 
																	{
																			?>
																	<?php echo $LTY_Offers->Loyalty_at_transaction ." %  On Every Transaction"; } 
																	
																	else { 
																	
																	echo "Get ". $LTY_Offers->discount." %  discount on  ". $LTY_Offers->Loyalty_at_value; } 
																	
																	?> <?php echo '\'s ';?> &nbsp;<?php echo $str1;?> </strong></span><br />
																	
																
																	<?php if($Enroll_details->Tier_id == $LTY_Offers->Loyalty_Tier_id) {?>
																	<strong id="Medium_font"><font style="font-size: 10px;color:green">Applicable for you</strong><br />	
																	<?php } ?>
																</div>
															</div>
														</a>
													</div>
												</div>
												
											<?php 
											}
										}
									}
								}
								else
								{ ?>
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">	
										<br/>
											<span id="Medium_font" class="uppercase">Currently No Any Offer Available</span>
										</div>
									</div>
						<?php }   ?>	
					<br>
					<?php if($Next_Tier_name != "" && $Criteria_value != "" && $Tier_value_points > 0) { ?>
						<div class="row" style="margin: auto;" > 
							<span id="Medium_font" class="text-left" ><strong>Next Level</strong></span>
							 <div class="col-md-12" style="background:#a3cbe8;    padding: 8px;">    
								
								<table id="myTable" align="left" class="text-left">										 
									<tr>
										<td>
											<span id="Value_font"><strong><?php echo $Next_Tier_name;?></strong></span>
											<br>										
											<span id="Value_font"><strong><?php echo $Criteria_value;?>&nbsp;<?php echo $Company_Details->Currency_name?> Required</strong></span>
											<br>										
											<span id="Value_font"><strong><?php echo $Tier_value_points;?>&nbsp; to go</strong></span>
										</td>											
										<button type="button"  style="background:#0060a9;color:#fff;border: none;width: 50%;padding:5px;float:right;margin-top: 51px;" id="button"  data-toggle="collapse" data-target="#demo" >View Benefits</button>												
									</tr> 
								</table>	
									
									
									
							</div>
							
						</div>
						
						<div id="demo" class="collapse">
							<?php 
								$LTY_Offers_flag=0;
								foreach($SellerLoyaltyOffers as $LTY_Offers11)
								{
									if($LTY_Offers11)
									{
										$LTY_Offers_flag=1;
									}
								}						
								// echo"LTY_Offers_flag-----------".$LTY_Offers_flag;	
									
									if($LTY_Offers_flag==1)
									{
									
										foreach($SellerLoyaltyOffers as $LTY_Offers11) 
										{
											if($LTY_Offers11)
											{
												$Photograph = $LTY_Offers11->Photograph;
												if($Photograph=="")
												{
													$Photograph='images/no_image.jpeg';
												}
												
												$str = substr($LTY_Offers11->Loyalty_name,0,2);
												if($str=='BA')
												{
													$str1='Paid Amount';
												}
												if($str=='PA')	
												{
													$str1='Purchase Amount';
												}
												
												$Transaction_count = $ci_object->Igain_model->Check_transaction_count($LTY_Offers11->Enrollement_id,$LTY_Offers11->Company_id,$enroll); 	
												
												// echo"Next_Tier_id-----------".$Next_Tier_id."--Loyalty_Tier_id---".$LTY_Offers11->Loyalty_Tier_id."-";	
												if($Next_Tier_id == $LTY_Offers11->Loyalty_Tier_id) { 
											
													?>
														<div class="row" > 
															<div class="col-md-12">
																<a href="<?=base_url()?>index.php/Cust_home/Loyalty_Offers_Detail?LoyaltyId=<?php echo $LTY_Offers11->Loyalty_id;?>&Company_id=<?php echo $LTY_Offers11->Company_id;?>">
																	<div class="row" id="Lulu">
																		<div class="col-xs-4" style="padding: 10px;" >
																			<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
																		</div>											
																		<div class="col-xs-8 text-left" id="detail">
																		
																			<strong id="Large_font"><?php echo $LTY_Offers11->First_name.' '.$LTY_Offers11->Last_name; ?></strong><br />
																									
																			<span id="Medium_font" ><strong><?php echo substr($LTY_Offers->Loyalty_name,3); ?></strong></span><br />
															
																			<span id="Value_font"><strong>
																			
																			<?php if($LTY_Offers11->Loyalty_at_transaction!= '0.00') { ?><?php echo $LTY_Offers11->Loyalty_at_transaction ." %  On Every Transaction"; } else { echo "Get ". $LTY_Offers11->discount." %  discount on  ". $LTY_Offers11->Loyalty_at_value; } ?>
																			<?php echo '\'s ';?> &nbsp;<?php echo $str1;?>
																			
																			</strong></span><br />
																			
																		
																			
																			
																			
																		</div>
																	</div>
																</a>
															</div>
														</div>														
														<?php 
													}
												}
											}
										}
										else
										{ ?>
											<div class="row ">
												<div class="col-xs-12 " style="width: 100%;">	
												<br/>
													<span id="Medium_font" class="uppercase">Currently No Any Offer Available</span>
												</div>
											</div>
									<?php } ?>	
						</div>
						<?php }   ?>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php $this->load->view('front/header/footer'); ?> 
<style>
button:focus{
	background-color: #0060a9 !IMPORTANT;
}
	#ud
	{
		border-bottom: 1px solid #d8d5d5;
	}
	a
	{
		color: #7d7c7c;
	}
	#icon {
    width: 4%;
	}
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
</style>
