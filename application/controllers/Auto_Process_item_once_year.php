<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_Process_item_once_year extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
	}
	
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("Y-m-d H:i:s");
		$Month_date=date("m-d"); 
		
		
		foreach($Company_details as $Company_Records)
		{
			if($Company_Records["Cron_freebies_once_flag"]==1)
			{	
				$Company_id = $Company_Records["Company_id"];
				$Cust_apk_link = $Company_Records["Cust_apk_link"];
				$Cust_ios_link = $Company_Records["Cust_ios_link"];
				$Company_name = $Company_Records["Company_name"];
				$Company_website = base_url()."Company_".$Company_id."/index.php";
				
				
				//echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]." <---->Evoucher_expiry_period --->".$Company_Records["Evoucher_expiry_period"]."</b>";
				$Get_Cust_Records = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
				if($Get_Cust_Records !=NULL)
				{				
					foreach($Get_Cust_Records as $Cust_Record)
					{
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];						
						$Enrollement_id = $Cust_Record["Enrollement_id"];
						$Card_id = $Cust_Record["Card_id"];
						$joined_date = $Cust_Record["joined_date"];
						echo "Card_id-->".$Card_id."*****---->joined_date ".date("m-d",strtotime($joined_date));
						 if($Month_date==date("m-d",strtotime($joined_date)))
						{	
							$Get_items = $this->Catelogue_model->Get_Merchandize_Items_once_year($Company_Records["Company_id"]);
							//print_r($data["Get_items"]);
							if($Get_items !=NULL)
							{				
								foreach($Get_items as $Item_details)
								{
										
										$Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
										foreach($Get_Partner_Branches as $Branch)
										{
											$Branch_code=$Branch->Branch_code;
										}
										
										$characters = 'A123B56C89';
										$string = '';
										$Voucher_no="";
										for ($i = 0; $i < 16; $i++) 
										{
											$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
										}
										$Voucher_status="Issued";
										
										
										/******************insert*****************************************/
										 $insert_data = array(
										'Company_id' => $Company_id,
										'Trans_type' => 10,
										'Redeem_points' => $Item_details->Billing_price_in_points,
										'Quantity' => 1,
										'Trans_date' => $Todays_date,
										'Enrollement_id' => $Enrollement_id,
										'Card_id' => $Card_id,
										'Item_code' => $Item_details->Company_merchandize_item_code,
										'Voucher_no' => $Voucher_no,
										'Voucher_status' => $Voucher_status,
										'Merchandize_Partner_id' => $Item_details->Partner_id,
										'Remarks' => 'Once Year Freebies',
										'Merchandize_Partner_branch' => $Branch_code);
										 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
										/***********************************************************/
										
										
										$Email_content =  array(
															'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
															'Merchandize_item_name' => $Item_details->Merchandize_item_name,
															'Item_image' => $Item_details->Item_image1,
															'Voucher_no' => $Voucher_no,
															'Voucher_status' => $Voucher_status,
															'Notification_type' => 'Freebies',
															'Template_type' => 'Freebies',
															'Customer_name' => $Full_name,
															'Todays_date' => $Todays_date
													);
										
										$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id); 
										$Bill_no++;
								}
							}
						}
					}
				}
			}
} }
}	
	?>
