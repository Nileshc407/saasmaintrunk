<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Auto_Process_Tier_Upgarde_Downgrade

class Auto_Process_Tier_Upgarde_Downgrade extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->model('TierM/Tier_model');
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("Y-m-d");
		
		//$Company_details[] == 3;
		 
		foreach($Company_details as $Company_Records)
		{
							
			if($Company_Records["Cron_tier_flag"]==1 && $Company_Records["Company_id"] == 3)
			{
				/*****************Create Tier Auto Process Child********************/
				$lv_Create_Customer_Tier_Child = $this->Auto_process_model->Create_Customer_Tier_auto_process_child();
				/*********************************************************************/
				echo "<br><br><br><b>*****************************Company Name --->".$Company_Records["Company_name"]."</b>";
				$Trans_Records = $this->Auto_process_model->Tier_list($Company_Records["Company_id"]);
			
				if($Trans_Records !=NULL)
				{
					foreach($Trans_Records as $Tiers_Record)
					{
						/*
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];
						
						$Enrollement_id = $Cust_Record["Enrollement_id"];
						$Card_id = $Cust_Record["Card_id"];
						$Tier_id = $Cust_Record["Tier_id"]; 
						$Trans_Records2 = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
						*/
						$Todays_date=date("Y-m-d");
						$Company_id = $Company_Records["Company_id"];
						$Tier_name = $Tiers_Record->Tier_name; 
						$Tier_id = $Tiers_Record->Tier_id; 
						$New_Tier_level_id = $Tiers_Record->Tier_level_id; 
						$Excecution_time = $Tiers_Record->Excecution_time; 
						$Tier_criteria = $Tiers_Record->Tier_criteria; 
						$Criteria_value = $Tiers_Record->Criteria_value; 
						$Operator_id = $Tiers_Record->Operator_id; 
						
						if($Excecution_time=="Monthly")
						{
							$From_date = strtotime($Todays_date .' -1 months');
							$From_date=date("Y-m-d",$From_date);
						}
						if($Excecution_time=="Quaterly")
						{
							$From_date = strtotime($Todays_date .' -3 months');
							$From_date=date("Y-m-d",$From_date);
						}
						if($Excecution_time=="Bi-Annualy")
						{
							$From_date = strtotime($Todays_date .' -6 months');
							$From_date=date("Y-m-d",$From_date);
						}
						if($Excecution_time=="Yearly")
						{
							$From_date = strtotime($Todays_date .' -12 months');
							$From_date=date("Y-m-d",$From_date);
						}
						
						
						if($Tier_criteria==1)//Cumulative Spend
						{
							$Trans_Records31 = $this->Auto_process_model->Get_Cumulative_spend_transactions($Company_id,$From_date,$Todays_date);
							
						}
						if($Tier_criteria==2)//Cumulative Number of Transactions
						{
							$Trans_Records31 = $this->Auto_process_model->Get_Cumulative_Total_transactions($Company_id,$From_date,$Todays_date);
						}
						if($Tier_criteria==3)//Cumulative Points Accumlated
						{
							$Trans_Records31 = $this->Auto_process_model->Get_Cumulative_Points_Accumlated($Company_id,$From_date,$Todays_date);
						}
						if($Tier_criteria==4)//Tenor - No. of Days
						{
							$From_date = strtotime($Todays_date .' -'.$Criteria_value.' days');
							$From_date=date("Y-m-d",$From_date);
							$Trans_Records2 = $this->Auto_process_model->Get_Cumulative_spend_transactions($Company_id,$From_date,$Todays_date);
							$Criteria=$Trans_Records2->Total_Spend;
							$Enrollement_id=$Trans_Records2->Enrollement_id;
							echo "<br><b>Total_Spend -->".$Criteria."</b>";
						}
						
						echo "<br><br>Tier_name-->".$Tier_name."<-->Tier_id-->".$Tier_id."<-->Excecution_time-->".$Excecution_time."<-->From_date-->".$From_date."<-->New_Tier_level_id-->".$New_Tier_level_id."<-->Tier_criteria-->".$Tier_criteria."<-->Criteria_value-->".$Criteria_value."<-->Operator_id-->".$Operator_id;
						
						foreach($Trans_Records31 as $Trans_Records3)
						{
							
							$Old_Tier_level_id=$Trans_Records3->Tier_level_id;
							$Old_Tier_name=$Trans_Records3->Tier_name;
							$Full_name=$Trans_Records3->First_name." ".$Trans_Records3->Last_name;
							
							if($Tier_criteria==1)//Cumulative Spend
							{
								$Criteria=$Trans_Records3->Total_Spend;
								$Enrollement_id=$Trans_Records3->Enrollement_id;
								echo "<br><br><b>Total_Spend -->".$Criteria."-->Enrollement_id.".$Enrollement_id."-->Current_Tier_name.".$Old_Tier_name."</b>";
							}
							if($Tier_criteria==2)//Cumulative Number of Transactions
							{
								$Criteria=$Trans_Records3->Total_Transactions;
								$Enrollement_id=$Trans_Records3->Enrollement_id;
								echo "<br><br><b>Total_Transactions -->".$Criteria."-->Enrollement_id.".$Enrollement_id."-->Current_Tier_name.".$Old_Tier_name."</b>";
							}
							if($Tier_criteria==3)//Cumulative Points Accumlated
							{
								$Criteria=$Trans_Records3->Total_Points;
								$Enrollement_id=$Trans_Records3->Enrollement_id;
								echo "<br><br><b>Total_Points -->".$Criteria."-->Enrollement_id.".$Enrollement_id."-->Current_Tier_name.".$Old_Tier_name."</b>";
							}
					
							$Criteria_value2 = 0;
							$Check_operator = $this->Auto_process_model->Check_operator($Operator_id,$Criteria,$Criteria_value,$Criteria_value2);
							
							
							echo "<br><b>Check_operator -->".$Check_operator."</b>";
							
							if($Check_operator == 1)//&& $Old_Tier_level_id != $New_Tier_level_id
							{
								if($Old_Tier_level_id < $New_Tier_level_id)
								{
									$Process="Upgrade";
								}
								elseif($Old_Tier_level_id == $New_Tier_level_id)
								{
									$Process="Retention";
								}
								else
								{
									$Process="Downgrade";
								}
								echo "<br><b>Process -->".$Process."</b>";
								/*****************Insert Tier Auto Process Child********************/
								$lv_Insert_Customer_Tier = $this->Auto_process_model->Insert_Customer_Tier_auto_process($Enrollement_id,$Tier_id,$Process,$Old_Tier_level_id,$New_Tier_level_id,$Old_Tier_name,$Tier_name);
								/*********************************************************************/
							}
						}
					}
					echo "<br><br>*****************<br>";
					/*****************Get Tier Auto Process Child********************/
					$lv_Get_Customer_Tier = $this->Auto_process_model->Get_Customer_Tier_auto_process();
					if($lv_Get_Customer_Tier !=NULL)
					{	
						foreach($lv_Get_Customer_Tier as $Rec_tier)
						{
							if($Rec_tier->Process!="Retention")
							{
								/*****************Update_Customer_Tier********************************/
								$lv_Update_Customer_Tier = $this->Auto_process_model->Update_Customer_Tier($Rec_tier->Enrollement_id,$Rec_tier->Tier_id);
								/********************************************************************/
								/*****************Insert Tier Auto Process lOG********************/
								$lv_Insert_Customer_TierLOG = $this->Auto_process_model->Insert_Customer_Tier_auto_process_log($Company_id,$Rec_tier->Enrollement_id,$Rec_tier->Tier_id,$Rec_tier->Process,$Rec_tier->Old_Tier_level_id,$Rec_tier->New_Tier_level_id,$Rec_tier->Old_Tier_name,$Rec_tier->Tier_name);
								/*********************************************************************/
								
									echo "<br><b>Tier_id -->".$Rec_tier->Tier_id."<-->Old_Tier_name -->".$Rec_tier->Old_Tier_name."<-->New Tier_name -->".$Rec_tier->Tier_name."<-->Enrollement_id -->".$Rec_tier->Enrollement_id."<-->Process -->".$Rec_tier->Process."</b>";
									
								$Email_content = array(
										'Old_Tier_name' => $Rec_tier->Old_Tier_name,
										'New_Tier_name' => $Rec_tier->Tier_name,
										'Process' => $Rec_tier->Process,
										'Notification_type' =>  'Tier '.$Rec_tier->Process.' Notification',
										'Template_type' => 'Tier_notification'
										);
										
									$this->send_notification->send_Notification_email($Rec_tier->Enrollement_id,$Email_content,'1',$Company_id);
							}
						}
					}
					/*********************************************************************/
				}
			}
	}
}	
}
	?>
