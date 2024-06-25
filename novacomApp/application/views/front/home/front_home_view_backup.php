<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>	
<?php $this->load->view('front/header/header'); 
	
	$Photograph = $Enroll_details->Photograph;
	
	//$Photograph='qr_code_profiles/'.$enroll.'profile.png';
	
	if($Photograph=="")
	{
		$Photograph='images/No_Profile_Image.jpg';
	}

						$Current_point_balance = ($Enroll_details->Total_balance- ($Enroll_details->Debit_points + $Enroll_details->Block_Points));
				
						if($Current_point_balance<0)
						{
							$Current_point_balance=0;
						}
						else
						{
							$Current_point_balance=$Current_point_balance;
						}
						
						
						
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
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 		
									}
								}
								else if($Tier_criteria==3)
								{
									$criteriaName='Cumulative Points Accumlated';
									
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="Your points gained is <b>".$Total_Points."</b> If you purchase further more and gain points you will easily have a <b> points gained ".$OperatorName.' '.$Criteria_value."</b> and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
										
										// echo '<br>Cumulative Points Accumlated--- '.$Total_Points; 
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
										
										$Tier_value="Your points gained is <b>".$Total_Points."</b> If you purchase further more and gain points you will easily have a <b> points gained ".$OperatorName.' '.$Criteria_value."</b> and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Cumulative Points Accumlated---- '.$Total_Points; 
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
										
										$Tier_value="Your points gained is <b>".$Total_Points."</b> If you purchase further more and gain points you will easily have a <b> points gained ".$OperatorName.' '.$Criteria_value."</b> and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
										
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
										
										$Tier_value="Your points gained is <b>".$Total_Points."</b> If you purchase further more and gain points you will easily have a <b> points gained ".$OperatorName.' '.$Criteria_value."</b> and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
										
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
						
						// echo '------Tier_value------'.$Tier_value."---<br>"; 
					
?> 	
<!----Profile Completion Progress Bar---->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/profile-progress.css">
<style>
	.progress
	{
		background-image: url('<?php echo $this->config->item('base_url2').$Photograph; ?>');
	}
	
</style>
<!----Profile Completion Progress Bar---->
</head>
<body>
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container mt-3" id="top_container">
        <?php /* ?><div class="section-header">    
			<p><a href="<?php echo base_url(); ?>index.php/Cust_home/home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Profile</p>        </div> <?php */ ?>
			
        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12"  style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="min-height: 175px;" >
				<!----Profile Completion Progress Bar---->					
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="progress">
								<span class="progress-left">
									<span class="progress-bar"></span>
								</span>
								<span class="progress-right">
									<span class="progress-bar"></span>
								</span>									
							</div>
							<h2 id="Large_font">Welcome Back <?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name;?></h2> 
						</div>
						<div class="col-md-4">
							<button type="submit"  class="b-items__item__add-to-cart" id="ContinuetoCart" style="margin-top: 10px;">
								 <a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span id="mail_button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/all.png" style="width: 17px"> View Menu</span></a>
							</button>	
								<button type="submit"  class="b-items__item__add-to-cart" id="ContinuetoCart" style="margin-top: 31px;">
								 <a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span id="mail_button">New Trends Items</span></a>
							</button>	
							<button type="submit"  class="b-items__item__add-to-cart" id="ContinuetoCart" style="margin-top: 31px;">
								 <a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span id="mail_button">Top Offers for You</span></a>
							</button>
						</div>
						<!----Profile Completion Progress Bar---->
								
					</div>
				</div>
				 <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">						
                       						
                        <div class="pricing-details">
                            <div class="row">
                                   <div class="col-md-12" style="padding-bottom:10px;">
									<div class="row" style="margin-left:0px; margin-right:0px;width: 100%; border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;padding:2px;">
										<div id="application_theme_dashboard" class="col-xs-12">
										<span style="margin-bottom:-15px; margin-top:10px;"><strong id="Small_font1"  style="text-align:left;"><?php echo $Tier_details->Tier_name.' Tier';?> </strong></span>  
											<br>
											<div class="col-md-4">
												<button type="submit"  class="b-items__item__add-to-cart mt-3" id="ContinuetoCart" style="margin-top: 10px;">
													 <a href="<?php echo base_url();?>index.php/Cust_home/home"><span id="mail_button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/all.png" style="width: 17px"> View Benefits</span></a>
												</button>													
											</div>
											<span class="col-md-4" style="float: right;">													
												<div class="circle">
													<p style="margin: 22px auto;display: block;"><?php echo round($Current_point_balance); ?></p>
												</div>													
											</span>
										</div>	
										<br>
										<br>
										<h2 id="Medium_font" class="text-justify"><?php echo $Tier_value;?></h2>
										
										
									</div>
									<div class="row" style="margin-left:0px; margin-right:0px;width: 100%; border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;padding:2px;">
										<div id="application_theme_dashboard" class="col-xs-12">
											<div class="col-md-4">
												<button type="submit"  class="b-items__item__add-to-cart mt-3" id="ContinuetoCart" style="margin-top: 10px;">
													 <a href="<?php echo base_url();?>index.php/Cust_home/home"><span id="mail_button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/earn.png" style="width: 17px"> Earn Points on POS</span></a>
												</button>													
											</div>
											<div class="col-md-4">
												<button type="submit"  class="b-items__item__add-to-cart mt-3" id="ContinuetoCart" style="margin-top: 10px;">
													 <a href="<?php echo base_url();?>index.php/Cust_home/home"><span id="mail_button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/earn.png" style="width: 17px"> Earn Points Online</span></a>
												</button>													
											</div>
										</div>
									</div>
								</div>
								
                            </div>
                        </div>
                        <br>
                    </div>
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">    <div class="pricing-details">
                            <span><strong id="Small_font1"  style="text-align:center;">Top offers for you </strong></span>				
							<div class="row">	

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
							<div class="col-md-12">
								<div class="card">								 
								  <div class="card-body">									
									<p class="card-text"> <?php echo $offer_description; ?></p>									
								  </div>
								   <div class="card-footer">
										<?php echo $row[0]['communication_plan']; ?>
								  </div>
								</div>
							</div>	
							<?php
						}
						else if($offer=='1')
						{
							$offer='2';
						?>
							
						<?php
						}
						else if($offer=='2')
						{
							$offer='3';
						?>
						<?php
						}
						else if($offer=='3')
						{
							$offer='0';
						?>
						
						<?php
						}
					}
				}
				
				if($offer_flag == 0)
				{
				?>
						<div class="col-md-12">
							<span><strong id="Small_font1">Currently there are no Offers..!! </strong></span>
						</div>
				<?php
				}
				?>
					</div>
									
                        </div>
                    </div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer'); ?> 
<style>
.card-body>p>img{
	width: 280px;
    height: 280px;
	
}
.circle{
	    width: 75px;
		height: 75px;
		margin-left: 18px;

}
.progress{
	
	    width: 75px;
		height: 75px;
		
	
}
.pricing-table{padding: 10px 10px 10px 10px;}
.col-md-12 { padding:10px;	}
.col-md-6 { width: 55%; float:left; }
.col-md-4 { width: 45%; float:left; }
	#icon
	{
		width: 21px;
		margin-top: 0%;
	}
	#ud
	{
		border-bottom: 1px solid #d8d5d5;
	}
	a
	{
		color: #7d7c7c;
	}
</style>