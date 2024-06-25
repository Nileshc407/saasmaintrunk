<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_Process_daily_points_consumption extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->library('Send_notification');
		$this->load->library('user_agent');
		$this->load->model('Igain_model');

	}
	public function index()
	{
		$Company_details = $this->Auto_process_model->Fetch_daily_consumption_Company();
		$Todays_date=date("m-d");
		if ($this->agent->is_browser())
		{
				$agent = $this->agent->browser().' '.$this->agent->version();
				echo $agent;
				die;
		}
		foreach($Company_details as $Company_Records)
		{
			
				echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
				$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_Records["Company_id"]);
				$Seller_id = $Super_Seller->Enrollement_id;
				$Seller_name = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
				$tp_db = $Super_Seller->Topup_Bill_no;
				$len = strlen($tp_db);
				$str = substr($tp_db, 0, 5);
				$bill = substr($tp_db, 5, $len);
								
				$Cust_records = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
				
				
								
				if($Cust_records !=NULL)
				{
					foreach($Cust_records as $Cust_Record)
					{
						
						// if($Cust_Record["Enrollement_id"]!=350){continue;}
						
						$Daily_limit = $this->Auto_process_model->Get_Company_Tier_daily_limit($Cust_Record["Tier_id"],$Company_Records["Company_id"]);
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];	
						$Current_Balance=$Cust_Record["Current_balance"];
						
						
						 if($Daily_limit > 0  && $Current_Balance > 0)
						{
							
							$Total_reddems=$Cust_Record["Total_reddems"];
							
							$Last_Used_redeems = $this->Auto_process_model->Get_TierCust_expiry_points($Company_Records["Company_id"],$Cust_Record["Enrollement_id"]);
							
							$Expiry_points=($Daily_limit-$Last_Used_redeems);
							echo "<br><br>Card_id :: ".$Cust_Record["Card_id"]."  Full_name :: $Full_name  Current_Balance :: $Current_Balance  Daily_limit :: $Daily_limit   Expiry_points :: $Expiry_points   Last_Used_redeems :: $Last_Used_redeems ";
							if($Expiry_points > 0)
							{
								$Credit_balance=($Current_Balance-$Expiry_points);
								if($Credit_balance < 0)
								{
									$Credit_balance = 0;
									$Expiry_points = $Current_Balance;
									echo "<br><br>New Expiry_points :: $Expiry_points  ";
								}
								
								$Total_redeems_points=($Total_reddems+$Expiry_points);
								
								echo "<br><br>Credit_balance :: $Credit_balance  Total_redeems_points :: $Total_redeems_points  ";
							
								// die;
								$post_Transdata = array(
								'Trans_type' => '14',
								'Company_id' => $Company_Records["Company_id"],
								'Expired_points' => $Expiry_points,
								'Trans_date' => date('Y-m-d H:i:s'),
								'Remarks' => 'Auto Points Expiry for Consumption Limit',
								'Card_id' => $Cust_Record["Card_id"],
								'Bill_no' => $bill,
								'Manual_billno' => $bill,
								'Seller' => $Seller_id,
								'Seller_name' => $Seller_name,
								'Enrollement_id' => $Cust_Record["Enrollement_id"]
								);
								
								$result6 = $this->Auto_process_model->insert_expired_points($post_Transdata);
								echo "<br><br>post_Transdata:::";print_r($post_Transdata);
								
								
								$result2 = $this->Auto_process_model->Update_Cust_trans_details($Cust_Record["Enrollement_id"],$Credit_balance,$Total_redeems_points);
								/***************************Update Super Seller Bill No.*********/
								$bill_no = $bill + 1;
								$billno_withyear = $str . $bill_no;
								$result4 = $this->Auto_process_model->update_topup_billno($Seller_id, $billno_withyear);
								
								/******************************************************************/	
								
								$bill = $bill_no;
							}
						
						} 
					}
				}
			
		}
	}	
}
?>
<style>

</style>
	
