<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Auto_Process_redeem_request_expiry extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('Auto_Process/Auto_process_model');
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("Y-m-d H:i:s");
		$Cron_redeem_request_flag = 1;
		$data1 = array(
						'Confirmation_flag' => 2 // Expired flag
						);

		foreach($Company_details as $Company_Records)
		{
			if($Cron_redeem_request_flag ==1) 
			{
				echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
					
				$Validity1 = $Company_Records["Redeem_request_validity"]; 
				if($Validity1 != Null)
				{
					$Validity = explode(":",$Validity1);
			
					$H = $Validity[0];
					$M = $Validity[1];
					$S = $Validity[2];
					
					$RequestResult = $this->Auto_process_model->Fetch_active_redeem_request($Company_Records["Company_id"],$Todays_date);
					
					if($RequestResult !=NULL)
					{				
						foreach($RequestResult as $request)
						{
							$requestid = $request->id; 
							$startTimeRequest = $request->Creation_date; 
							
							$cenvertedTime = date("Y-m-d H:i:s",strtotime("+$H hour +$M minutes",strtotime($startTimeRequest)));
							
							$currentTime = date("Y-m-d H:i:s");
							
							if($currentTime > $cenvertedTime)
							{
								$Result = $this->Auto_process_model->Update_redeem_request($Company_Records["Company_id"],$requestid,$data1);
							}
						}
					}
				}
			}
		}
	}	
}
?>