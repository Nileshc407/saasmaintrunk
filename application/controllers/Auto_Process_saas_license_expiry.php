<?php 
 
class Auto_Process_saas_license_expiry extends CI_Controller 
{
	public function __construct()
	{ 
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('Send_notification');
		$this->load->model('Saas_model');
	}
	
	public function index()
	{
		$Company_details = $this->Saas_model->Fetch_Saas_Company();
		// print_r($Company_details);
		foreach($Company_details as $Company_Records)
		{
				
			$Company_id = $Company_Records["Company_id"];
			$Company_primary_contact_person = $Company_Records["Company_primary_contact_person"];
			
			 //--------------License Expiry Check-----------------
		 
		   $FetchedSaasCompany = $this->Saas_model->Get_saas_company_payment_details($Company_id);
		   if($FetchedSaasCompany != NULL)
		   {
			   // echo $FetchedSaasCompany->Pyament_expiry_date;die;
				$Expiry_license=$FetchedSaasCompany->Pyament_expiry_date;
				
		   }
		   /******************Calculate Days*********************************************/
					$Expiry_license2=date("m-d-Y",strtotime($Expiry_license));
					$tUnixTime = time();
					list($month, $day, $year) = EXPLODE('-', $Expiry_license2);
					$timeStamp = mktime(0, 0, 0, $month, $day, $year);
					$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
					////*************************************************************************/
			echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]." <---->Expiry_license --->".$Expiry_license."<---->num_days --->".$num_days."</b>";
			if($num_days ==5 || $num_days ==15)
			{
				$Email_content = array(
								'num_days' => $num_days,
								'Company_primary_contact_person' => $Company_primary_contact_person,
								'Notification_type' => "Reminder - Loyalty License expire in $num_days days",
								'Template_type' => 'Reminder_saas_expiry'
							);
							
							$this->send_notification->send_Notification_email(0, $Email_content, 0, $Company_id);
			}
							
		} 
	}
}	
	?>
