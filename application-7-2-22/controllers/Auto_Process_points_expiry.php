<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Auto_Process_points_expiry extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Report/Report_model');
		$this->load->model('Auto_Process/Auto_process_model');
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("m-d");
		
		foreach($Company_details as $Company_Records)
		{
			if($Company_Records["Cron_points_expiry_flag"]==1)
			{
			echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."<--->Points_expiry_period --->".$Company_Records["Points_expiry_period"]."<--->Deduct_points_expiry --->".$Company_Records["Deduct_points_expiry"]."</b>";
			
			$Trans_Records1 = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
			foreach($Trans_Records1 as $Cust_Record)
			{
			$Trans_Records = $this->Auto_process_model->get_cust_last_points_used($Company_Records["Company_id"],$Cust_Record["Card_id"]);
			
			//print_r($data["Trans_Records"]);
			if($Trans_Records !=NULL && $Company_Records["Deduct_points_expiry"]!=0.00 && $Company_Records["Points_expiry_period"]!=0)
			{				
				/******************Calculate Days*********************************************/
				$Transaction_date=date("m-d-Y",strtotime($Trans_Records->Trans_date));
				$tUnixTime = time();
				list($month, $day, $year) = EXPLODE('-', $Transaction_date);
				$timeStamp = mktime(0, 0, 0, $month, $day, $year);
				$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
				////*************************************************************************/
				$Full_name=$Trans_Records->First_name." ".$Trans_Records->Last_name;
				$Enrollement_id=$Trans_Records->Enrollement_id;
				$Company_id=$Company_Records["Company_id"];
				$Company_website=$Company_Records["Website"];
				$Current_balance=$Trans_Records->Current_balance;
				$Total_Current_balance=($Trans_Records->Current_balance-$Trans_Records->Blocked_points);
				
				echo "<br><br><b>***************Inside**********************</b><br>Last date->".$Trans_Records->Trans_date."*--*Trans_id-->".$Trans_Records->Trans_id."*-*Redeem_points-->".$Trans_Records->Redeem_points."*-*Trans_type-->".$Trans_Records->Trans_type."*-*Card_id-->".$Cust_Record["Card_id"]."*--*num_days-->".$num_days."*--*Current_balance-->".$Current_balance."*--*Total_Current_balance-->".$Total_Current_balance."<br><br>";
				
				$Deduct_balance=round(($Total_Current_balance*$Company_Records["Deduct_points_expiry"])/100);
				if($Deduct_balance==0)
				{
					$Deduct_balance=1;
				}
				$Days=$Company_Records["Points_expiry_period"]-$num_days;	
				
				if(($num_days==$Company_Records["Points_expiry_period"]-30) || ($num_days==$Company_Records["Points_expiry_period"]-60) || ($num_days==$Company_Records["Points_expiry_period"]-90))
				{
					$Email_content = array(
						'Days' => $Days,
						'Deduct_balance' => $Deduct_balance,
						'Notification_type' => 'Points Expiry '.$Days.' days Reminder Notification',
						'Template_type' => 'Points_Expiry'
					);
					
					$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id);
					
				}
				if($num_days>=$Company_Records["Points_expiry_period"] && $Total_Current_balance > 0) 
				{
					$Deducted_Current_balance=($Current_balance-$Deduct_balance);
					
					/******************Update Customer Balance*******************************/
						$result2 = $this->Auto_process_model->Update_Customer_Balance($Enrollement_id,$Deducted_Current_balance);
					/****************************************************************/
					/******************Insert in transaction*******************************/
						$result21 = $this->Auto_process_model->Insert_points_expiry_trans($Company_id,$Enrollement_id,$Deduct_balance,$Cust_Record["Card_id"]);
					/****************************************************************/
					
					$Availabel_Current_balance=($Deducted_Current_balance-$Trans_Records->Blocked_points);
					
					$Email_content = array(
						'Days' => $Days,
						'Deduct_balance' => $Deduct_balance,
						'Availabel_Current_balance' => $Availabel_Current_balance,
						'Notification_type' => 'Points Expiry Notification',
						'Template_type' => 'Points_Expiry'
					);
					
					$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id);
					
					
				}
				
			}
		}
		
	} }
}
}	
?>
<style>

</style>
	
