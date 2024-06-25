<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_Process_meal_topup extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->library('Send_notification');
		$this->load->library('user_agent');

	}
	public function index()
	{
		$Company_details = $this->Auto_process_model->Fetch_Meal_Company();
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
						$MealTopUp = $this->Auto_process_model->Get_Company_Tier_meal_topup($Cust_Record["Tier_id"],$Company_Records["Company_id"]);
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];	
						
						
						
						 if($MealTopUp > 0)
						{
							$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];
							
							$Current_Balance=$Cust_Record["Current_balance"];
							$Total_topup_amt=$Cust_Record["Total_topup_amt"];
							$Credit_balance=($Current_Balance+$MealTopUp);
							$Credit_Total_topup_amt=($Total_topup_amt+$MealTopUp);
							
							echo "<br><br>Card_id :: ".$Cust_Record["Card_id"]."  Full_name :: $Full_name  Current_Balance :: $Current_Balance  Credit_balance :: $Credit_balance  MealTopUp :: ".$MealTopUp;
						
							// die;
							$post_Transdata = array(
							'Trans_type' => '1',
							'Company_id' => $Company_Records["Company_id"],
							'Topup_amount' => $MealTopUp,
							'Trans_date' => date('Y-m-d H:i:s'),
							'Remarks' => 'Meal TopUp',
							'Card_id' => $Cust_Record["Card_id"],
							'Bill_no' => $bill,
							'Manual_billno' => $bill,
							'Seller' => $Seller_id,
							'Seller_name' => $Seller_name,
							'Remarks' => 'Auto Meal TopUp',
							'Enrollement_id' => $Cust_Record["Enrollement_id"]
							);
							
							$result6 = $this->Auto_process_model->insert_topup_details($post_Transdata);
							echo "<br><br>post_Transdata:::";print_r($post_Transdata);
							$Email_content = array(
								'Notification_type' => 'Congrates,You have recieved Meal Top Up!!!',
								'MealTopUp' => $MealTopUp,
								'Current_Meal_balance' => $Credit_balance,
								'Template_type' => 'Meal_Top_Up'
							);
								
							$Notification=$this->send_notification->send_Notification_email($Cust_Record["Enrollement_id"],$Email_content,'1',$Company_Records["Company_id"]);
								
							$result2 = $this->Auto_process_model->Update_Customer_details($Cust_Record["Enrollement_id"],$Credit_balance,$Credit_Total_topup_amt);
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
?>
<style>

</style>
	
