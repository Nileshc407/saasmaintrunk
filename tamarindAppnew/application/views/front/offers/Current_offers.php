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
			<a href="#"><span>Current Offers</span></a>
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