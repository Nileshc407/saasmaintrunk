<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu'); 

$ci_object = &get_instance(); 
$ci_object->load->model('Igain_model');

$Enrollement_id=$Enroll_details->Enrollement_id;
$Company_id=$Enroll_details->Company_id;
$Card_id=$Enroll_details->Card_id;

$Current_point_balance = ($Enroll_details->Total_balance-($Enroll_details->Debit_points + $Enroll_details->Block_points));				
if($Current_point_balance<0)
{
 $Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}

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
?>
<header>
	<div class="container">
		<div class="d-flex align-items-center">
			<button class="toggle-menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<div class="only-link">
			<a href="#"><span> Member Benefits</span></a>
			</div>
		</div>
	</div>
</header>
	<div class="custom-body">
			
				<div class="cart_list">
						<div class="item benefits-item">
							<h3>10% Discount On Food</h3>
							<p>Try some new food with a special 10% discount on all the food in our menu.</p>
							
						</div>
						<div class="item benefits-item">
							<h3>Free Birthday Cake</h3>
							<p>Let us wish you a happy birthday with a free Birthday Cake delivery. </p>
							
						</div>
						<div class="item benefits-item">
							<h3>Offers And Special Promotions</h3>
							<p>Try some new food with a special 10% discount on all the food in our menu.</p>
							
						</div>
						<div class="item benefits-item">
							<h3>10% Discount On Food</h3>
							<p>Try some new food with a special 10% discount on all the food in our menu.</p>
							
						</div>
						
						
					</div>
			
		</div>
<?php $this->load->view('front/header/footer');  ?>		

<?php /*
<body>
<div id="application_theme" class="section pricing-section" style="min-height: 500px;">
    <div class="container" id="top_container">
       <div class="section-header">          
			<!--<p><a href="<?=base_url()?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>-->
			<p id="Extra_large_font" style="margin-left: -3%;">My Offers</p>
		</div>
        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
					<div class="pricing-details">
						<!--<strong>
							
							
							<span  class="Medium_font mr-5">
								<a id="Small_font" href="<?php //echo base_url();?>index.php/Cust_home/merchantoffers">Benefits</a>
							</span> |
							<span class="Medium_font mr-5">
								<a id="Small_font" href="<?php //echo base_url();?>index.php/Cust_home/MerchantReferralOffers">Referral</a>
							</span> |
							<span id="ud" class="Medium_font">
								<a id="Small_font" href="<?php //echo base_url();?>index.php/Cust_home/MerchantCommunication" >Offers</a>
							</span>
							
							
						</strong>-->
						<br>					
                          
						 <div class="row pricing-tables" id="front_head">
							<div class="col-xs-12">
								<!------------Trending Items--------------------->
								<!--<div class="col-md-12" style=" padding: 2px;  margin: 0;">
									<img src="<?php echo $this->config->item('base_url2')."images/image2.png"; ?>" width="340" height="200">
									<strong id="Large_font">Enjoy our Cocktail Happy Hour Everyday 4pm to 7pm </strong>
								</div>-->
								
								<div class="col-md-12" style="padding:0; margin:0;">
									<div style="border-style:groove; border-color:#F8F8F8; padding:5; margin:5;">
										<img src="<?php echo $this->config->item('base_url2')."images/image3.png"; ?>" width="340" height="200">
										<p id="Value_font" style="font-size: 15px;">Special Offer on Cakes Buy 1 and Get 1 Free</p>
									</div>
								</div>
								
							</div>
						</div>
						
						<?php
						$MerchantCommunication="";
						$COMM_Offers_flag=0; 
						foreach($MerchantCommunication as $COMM_Offers) 
						{
							if($COMM_Offers)
							{	
								$COMM_Offers_flag=1;
							}
						}
						if($COMM_Offers_flag==1)
						{ 
							foreach($MerchantCommunication as $COMM_Offers) 
							{
								$Photograph=$COMM_Offers->Photograph;
								if($Photograph=="")
								{
									$Photograph='images/no_image.jpeg';
								}
								if($COMM_Offers)
								{	// $result_offer= mb_substr($COMM_Offers->communication_plan, 0, 20);	
								?>
								<div class="row" >
									<div class="col-md-12">
									 
									 <a href="<?=base_url()?>index.php/Cust_home/Merchant_Communication_Detail?Communication_id=<?php echo $COMM_Offers->Communication_id;?>&Company_id=<?php echo $COMM_Offers->Company_id;?>"> 
									 
									 <div class="col-xs-4" style="padding: 10px;">
												<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
											</div>	
											<strong id="Large_font"><?php echo $COMM_Offers->First_name.' '.$COMM_Offers->Last_name; ?></strong>
												<br />	
									 
									
										<div class="row">
																					
											<div class="col-xs-8 text-center">
																		
												<span id="Medium_font"><strong><?php echo $COMM_Offers->communication_plan;  ?></strong>
												</span>
												<span id="Medium_font"><strong><?php echo $COMM_Offers->description;  ?></strong>
												</span>
												
											</div>
										</div>
									</a> 
									</div>
								</div><hr>
							<?php
								}
							} 	
						}
						else
						{ ?>
							<div class="row ">
								<div class="col-xs-12" style="width: 100%;">	
								
									<!--<span id="Medium_font" class="uppercase">No Offers Available</span> -->
								</div>
							</div>
			<?php		}	?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div> */ ?>