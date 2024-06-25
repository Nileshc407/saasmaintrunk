<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
 $Menu_access_details = json_decode($Menu_access_data, true);
?>
<html lang="en">
 <!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard</title>	
<?php 
	$this->load->view('front/header/header');
	$ci_object = &get_instance(); 
	$ci_object->load->model('Igain_model');
?>
<?php
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
</head>
<body>  
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
	<div class="container" >
		<div class="section-header"><br>      
			<p><a href="<?php echo base_url();?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-top:0% !IMPORTANT;">Dashboard</p>
		</div>
		
		<div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
			 <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div class="pricing-details">
                            <div class="row" style="margin: auto;">
                                <div class="col-md-12" style="background: #fab900;padding:5px;">                                    
                                    <table id="myTable" align="center" class="text-left">                                     
                                             
                                            <tr>
                                                <td>
													<span id="Medium_font" ><strong>Loyalty Tier</strong></span>
												</td>
												<td>
													<span id="Value_font"><strong>:&nbsp;<?php echo $Tier_details->Tier_name;?></strong></span>
												</td>												
                                            </tr> 
											<tr>
                                                <td>
													<span id="Medium_font" ><strong>Membership Id</strong></span>
												</td>
												<td>
													<span id="Value_font"><strong>:&nbsp;<?php echo $Enroll_details->Card_id; ?></strong></span>
												</td>											
                                            </tr> 
											<tr>
                                                <td>
													<span id="Medium_font" >
														<strong>Current <?php echo $Company_Details->Currency_name; ?></strong>
													</span>
												</td>
												<td>
													<span id="Value_font"><strong>:&nbsp;<?php echo $Current_point_balance;?></strong></span>
												</td>											
                                            </tr> 
											<tr>
                                                <td>
													<span id="Medium_font" >
														<strong>Bonus <?php echo $Company_Details->Currency_name; ?></strong>
													</span>
												</td>
												<td>												
													<span id="Value_font"><strong>: &nbsp;<?php echo round($Enroll_details->Total_topup_amt); ?></strong></span>												
												</td>											
                                            </tr>                                      
                                    </table>		
                                </div>
                            </div>
                        </div>
                    <br>
                    </div>

				<!-- 1st Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
					
						<div class="pricing-details">
							<div class="row">
								<?php /* ?>
								<div class="col-md-12" style="padding-bottom:10px;" >
									<div class="row" style="margin-left:0px; margin-right:0px;" >
										<div id="application_theme_dashboard" class="col-xs-12" style="width: 100%;  border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;" >
											<span style="margin-bottom: -20px; margin-top:10px;"><strong id="Small_font1"><?php echo $Company_Details->Alise_name; ?> <?php echo $Company_Details->Currency_name; ?> Balance</strong></span>
											<address>
												<span id="Extra_large_font" style="margin-top:0% !IMPORTANT;"><?php echo round($Current_point_balance); ?></span><br>
											</address>
										</div>	
									</div>
								</div> <?php */ ?>
								<?php	
									$total_gain_points=$total_gain_points->Total_gained_points;
									
									if($total_gain_points!='')
									{
										$TotalGainPoints=$total_gain_points; 
									}
									else
									{
										$TotalGainPoints="0";
									}
									
									
									$Total_Transfer_points=$Total_transfer->Total_Transfer_points;
									
									if($Total_Transfer_points!='')
									{
										$Total_Transfer_points=$Total_transfer->Total_Transfer_points;
									}
									else
									{
										$Total_Transfer_points="0";
									}
								?>
								
								<?php /* if($Company_Details->Ecommerce_flag==1){ ?>
								<div class="col-md-12" style="padding-bottom:10px;" >
									<div class="row" style="margin-left:0px; margin-right:0px;" >
										<div id="application_theme_dashboard" class="col-xs-12" style="width: 100%;  border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;" >
											<span style="margin-bottom: -20px; margin-top:10px;"><strong id="Small_font1"> Purchase</strong></span>
											<address>
												<span id="Medium_font1"><?php echo $Currency_Symbol.' '.number_format($Enroll_details->total_purchase,2); ?></span><br>
											</address>
										</div>	
									</div>
								</div>
								<?php } */ ?>
								<div class="col-md-12" style="padding-bottom:10px;">
									<div class="row" style="margin-left:0px; margin-right:0px;">
										<div id="application_theme_dashboard" class="col-xs-12" style="width: 100%; border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;">
										<span style="margin-bottom:-15px; margin-top:10px;"><strong id="Small_font1"  style="text-align:left;"> <?php echo $Company_Details->Currency_name; ?> Earned : <?php echo $TotalGainPoints+$Enroll_details->Total_topup_amt; ?></strong></span>  
											<address style="padding: 0px 20px 0px 0px;">
												<span class="col-xs-6" style="margin:4px 75px 4px 9px; width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;"><?php echo $TotalGainPoints; ?></span>													
													<div class="circle">
														<strong style="float: right;margin:12px 4px 0 6px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/earn.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1" > Earned</p>
												</span>												
												<span class="col-xs-6" style="margin: 0 auto; width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;">		<?php echo round($Enroll_details->Total_topup_amt); ?>
													</span>
													<div class="circle">
														<strong style="float: right;margin:9px 2px 0 3px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/bonus.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1"> Bonus</p>
												</span>
											</address>
										</div>	
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom:10px;">
									<div class="row" style="margin-left:0px; margin-right:0px;">
										<div id="application_theme_dashboard" class="col-xs-12" style="width: 100%; border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;">
										<span style="margin-bottom:-15px; margin-top:10px;"><strong id="Small_font1"  style="text-align:left;"><?php echo $Company_Details->Currency_name; ?> Used : <?php echo round($Enroll_details->Total_reddems+$Total_Transfer_points+$Enroll_details->Blocked_points+$Enroll_details->Debit_points); ?> </strong></span>  
											<address style="padding: 0px 20px 0px 0px;">
												<span class="col-xs-6" style="margin:4px 75px 4px 9px; width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;"><?php echo round($Enroll_details->Total_reddems); ?></span>										
													<div class="circle">
														<strong style="float: right;margin:12px 4px 0 6px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/redeem.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1" > Redeemed</p>
												</span>
												
												<span class="col-xs-6" style="margin: 0 auto; width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;"><?php echo $Total_Transfer_points; ?></span>
													<div class="circle">
														<strong style="float: right;margin:9px 2px 0 3px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/transfer.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1"> Transferred</p>
												</span>
											</address>
											<?php /* ?>
											<address style="padding: 0px 20px 0px 0px; margin-top: 6px;">
												<span class="col-xs-6" style="margin:4px 75px 4px 9px; width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;"><?php echo round($Enroll_details->Blocked_points); ?></span>
													
													<div class="circle">
														<strong style="float: right;margin:12px 4px 0 6px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/block.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1" > Blocked</p>
												</span>									
												<span class="col-xs-6" style="margin:margin: 0 auto;   width:22.5%;">
													<span id="Medium_font1"  style="width: 100px; margin-left: -22px; text-align: center;"><?php echo round($Enroll_details->Debit_points); ?></span>
													<div class="circle">
														<strong style="float: right;margin:11px 5px 0 7px;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/debit.png" style="width:70%; border"></strong>
													</div>
													<p style="margin-left:5px;" id="Small_font1"> Debited</p>
												</span>
											</address>
											<?php  */?>
										</div>	
									</div>
								</div>
								<?php /* if($Company_Details->Ecommerce_flag==1){ ?>
								<div class="col-md-12" style="padding-bottom:10px;" >
									<div class="row" style="margin-left:0px; margin-right:0px;" >
										<div id="application_theme_dashboard" class="col-xs-12" style="width: 100%;  border-radius: 11px; border: 0.6px solid; border-color:#e7e9ed;" >
											<span style="margin-bottom: -20px; margin-top:10px;"><strong id="Small_font1"> Purchase</strong></span>
											<address>
												<span id="Medium_font1"><?php echo $Currency_Symbol.' '.number_format($Enroll_details->total_purchase,2); ?></span><br>
											</address>
										</div>	
									</div>
								</div>
								<?php } */ ?>
							</div>	
							<?php
							
								$Enrollement_id=$Enroll_details->Enrollement_id;
								$Company_id=$Enroll_details->Company_id;
								$Card_id=$Enroll_details->Card_id;
								
								$Next_Tier_name=$Next_Tier_Details->Tier_name;
								$Tier_level_id=$Next_Tier_Details->Tier_level_id;
								$Excecution_time=$Next_Tier_Details->Excecution_time;
								$Tier_criteria=$Next_Tier_Details->Tier_criteria;
								$Criteria_value=$Next_Tier_Details->Criteria_value;
								$Operator_id=$Next_Tier_Details->Operator_id;
								
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
							?>
							<div class="col-md-12" style="padding-bottom:1px;">
								<div class="container-fluid" style="margin-left:0px; margin-right:0px;">
									<ul>
									  <!--<li id="Small_font1"><span id="Value_font"> <?php //echo $Tier_value; ?></span> </li>-->
										
										<a href="<?php echo base_url();?>index.php/Cust_home/mytransaction">
											<li>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/dollar.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">View Statement</span>												
											</li>
										</a>
										<br>
										<a href="<?=base_url()?>index.php/Cust_home/Issuance_details">
											<li>
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/receipt.png" id="icon1" class="k"> &nbsp;&nbsp;<span id="Medium_font">View Transaction</span>
												
											</li>
										</a>
											
									</ul>
								</div>
							</div>					
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
	
<?php $this->load->view('front/header/footer'); ?>	
<style>
	#application_theme_dashboard
	{				
		background:<?php echo $General_details[0]['Theme_color']; ?>;		
	}
	table{
		color:#fff;	
	}
	.pricing-table .pricing-details ul li 
	{
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
		font-weight: 600;
		background: #fab900;
	}
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: -20px !important;
		background: #fff;
	}
	
	.footer-xs
	{
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}
	.main-xs-3
	{
		width: 27%;
		padding: 0 0 0 10px;
	}
	.main-xs-6
	{
		width: 45%;
		padding: 10px 10px 0 10px;
	}
	
	
	.action
	{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	address
	{
		border: 0px solid #ffffff;
		padding: 0;
		border-radius: 50px;
		margin: 8% 8% 2% 8%;
		color: #ffffff;
	}
	/* Search Bar Css Ended*/
	#icon{
		font-size:17px;
		color: #060606;
		line-height: 30px;
	}
	.container-fluid 
	{
		position: relative;
		margin-left: auto;
		margin-right: auto;
		padding-right: 0px;
		padding-left: 0px;
	}
	.stat
	{
		width:25%;
	}

	 @media only screen and (min-width: 320px) 
	 {
		.circle 
		{
			height: 50px;
			width: 50px;
			text-align: center;
			vertical-align: middle;
			border-radius: 50%;
			background: <?php echo $General_details[0]['Header_color']; ?>;
			border: 2px solid <?php echo $General_details[0]['Header_color']; ?>;
			margin-left: 9%;
		}
	}
	@media only screen and (min-width: 768px) 
	{
		.circle {
			height: 50px;
			width: 50px;
			text-align: center;
			vertical-align: middle;
			border-radius: 50%;
			background: <?php echo $General_details[0]['Header_color']; ?>;
			border: 2px solid <?php echo $General_details[0]['Header_color']; ?>;
			margin-left: 29%;
		}
	}	
	p 
	{
		margin-top: 0;
		margin-left: 0%;
		margin-bottom: 0rem;
	}
</style>