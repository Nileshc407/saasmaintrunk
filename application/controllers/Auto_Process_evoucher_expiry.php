<?php 
 
class Auto_Process_evoucher_expiry extends CI_Controller 
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
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Auto_Process/Auto_process_model');
	}
	
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$start_date="1970-01-01";
		$end_date=date("Y-m-d"); 
		$transaction_type_id=10; //Redemption
		$Single_cust_membership_id=0;
		$Single_cust_membership_id=0;
		$Voucher_status=0;
		
		foreach($Company_details as $Company_Records)
		{
			if($Company_Records["Cron_evoucher_expiry_flag"]==1)
			{	
			$Company_id = $Company_Records["Company_id"];
			$Cust_apk_link = $Company_Records["Cust_apk_link"];
			$Cust_ios_link = $Company_Records["Cust_ios_link"];
			$Company_name = $Company_Records["Company_name"];
			$Company_website = base_url()."Company_".$Company_id."/index.php";
			
			
			echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]." <---->Evoucher_expiry_period --->".$Company_Records["Evoucher_expiry_period"]."</b>";
			$Trans_Records = $this->Report_model->get_cust_redemption_details($Company_Records["Company_id"],$start_date,$end_date,$transaction_type_id,$Single_cust_membership_id,'Issued',0,0,0,0,0,0);
			//print_r($data["Trans_Records"]);
			if($Trans_Records !=NULL)
			{				
				foreach($Trans_Records as $Cust_Record)
				{
					/******************Calculate Days*********************************************/
					$Transaction_date=date("m-d-Y",strtotime($Cust_Record->Trans_date));
					$tUnixTime = time();
					list($month, $day, $year) = EXPLODE('-', $Transaction_date);
					$timeStamp = mktime(0, 0, 0, $month, $day, $year);
					$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
					////*************************************************************************/
					
					if($Cust_Record->Voucher_status=="Issued" && $Cust_Record->Delivery_method== 28 && $Company_Records["Evoucher_expiry_period"]!=0)
					{
						$Remaining_days=($Company_Records["Evoucher_expiry_period"]-$num_days);						
						$Full_name = $Cust_Record->First_name." ".$Cust_Record->Last_name;						
						$Company_id = $Cust_Record->Company_id;
						$evoucher = $Cust_Record->Voucher_no;
						$Enrollement_id = $Cust_Record->Enrollement_id;
						
						/******************Get Cust Details********************/
						$result3 = $this->Igain_model->get_enrollment_details($Enrollement_id);
						$Enrollement_id = $result3->Enrollement_id;
						$MembershipID = $result3->Card_id;
						$Current_Balance=$result3->Current_balance;
						$Total_Redeem_Points=($Cust_Record->Redeem_points_per_Item*$Cust_Record->Quantity);
						$Credit_balance=($Current_Balance+$Total_Redeem_Points);
						$Avaialble_balance=($Credit_balance-$result3->Blocked_points);
						/**********************************************************/
						 
						echo "<br><br>Membership ID-->".$Cust_Record->Card_id."<-->Current_balance-->".$Current_Balance."<-->Blocked_points-->".$Cust_Record->Blocked_points."<-->Voucher Name-->".$Cust_Record->Voucher_no."<----->Voucher Status-->".$Cust_Record->Voucher_status."<----->Trans_date-->".$Cust_Record->Trans_date."<----->num_days-->".$num_days."<----->Total_Redeem_Points-->".$Total_Redeem_Points;						
						
						/**************************Sending notification After/Before 5 days create********************************/
						if($num_days==5 || $num_days==($Company_Records["Evoucher_expiry_period"]-5))
						{	
							$Email_content = array(
								'Trans_date' => $Cust_Record->Trans_date,
								'Item_name' => $Cust_Record->Merchandize_item_name,
								'Voucher_no' => $Cust_Record->Voucher_no,
								'Total_Redeem_Points' => $Total_Redeem_Points,
								'Quantity' => $Cust_Record->Quantity,
								'Voucher_status' => $Cust_Record->Voucher_status,
								'Branch_name' => $Cust_Record->Branch_name,
								'Branch_Address' => $Cust_Record->Address,
								'Days' => $Remaining_days,
								'Avaialble_balance' => $Avaialble_balance,
								'Notification_type' => 'e-Voucher Notification',
								'Template_type' => 'e-Voucher Notification'
							);
							
							$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id); 
						}
						/**************************Sending notification After 5 days create end****/
						/**************************Sending notification expiry********************************/
						if($num_days==$Company_Records["Evoucher_expiry_period"])//$Company_Records["Evoucher_expiry_period"]
						{

							/******************Update vVoucher Status*******************************/
							$result = $this->Catelogue_model->Update_eVoucher_Status($MembershipID,$Company_id,$evoucher,0,"Expired");
							
							$Email_content = array(
									'Trans_date' => $Cust_Record->Trans_date,
									'Item_name' => $Cust_Record->Merchandize_item_name,
									'Voucher_no' => $Cust_Record->Voucher_no,
									'Total_Redeem_Points' => $Total_Redeem_Points,
									'Quantity' => $Cust_Record->Quantity,
									'Voucher_status' => 'Expired',
									'Branch_name' => $Cust_Record->Branch_name,
									'Branch_Address' => $Cust_Record->Address,
									'Avaialble_balance' => $Avaialble_balance,
									'Days' => 0,
									'Notification_type' => 'e-Voucher Notification',
									'Template_type' => 'e-Voucher Notification'
								);
								
								$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id); 
								
							if($Total_Redeem_Points!=0)
							{	
								/******************Update Customer Balance*******************************/
								$result2 = $this->Auto_process_model->Update_Customer_Balance($Enrollement_id,$Credit_balance);
								
								/**************Insert transaction**********************/
								$Insert_data = array(
									'Trans_type' => 18,//Evoucher Expiry
									'Trans_date' => date('Y-m-d H:i:s'),
									'Item_code' => $Cust_Record->Item_code,
									'Voucher_no' => $Cust_Record->Voucher_no,
									'Topup_amount' => $Total_Redeem_Points,
									'Quantity' => $Cust_Record->Quantity,
									'Voucher_status' => 'Expired',
									'Enrollement_id' => $Enrollement_id,
									'Card_id' => $MembershipID,
									'Company_id' => $Company_id,
									'Remarks' => 'e-Voucher Expired Points Return'
									);
							
								$InsertCredit=$this->Catelogue_model->Insert_purchase_return_trans($Insert_data);
								
								
							}
							
							
						}
						
						
						
					}
				}
			}
		}
} }
}	
	?>
