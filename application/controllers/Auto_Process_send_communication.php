<?php 
	
	class Auto_Process_send_communication extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();		
			$this->load->library('form_validation');		
			$this->load->database();
			$this->load->helper('url');
			$this->load->model('Igain_model');
			$this->load->model('administration/Administration_model');
			$this->load->library('Send_notification');
		} 
		public function index()
		{
			$Company_details = $this->Igain_model->FetchCompany();
			$todays = date("Y-m-d");	
			// echo "todays ------".$todays."<br>";		
			foreach($Company_details as $Company_Records)
			{
				if($Company_Records["Cron_communication_flag"]==1)
				{
					// echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
					 
					$Scheduled_communications = $this->Administration_model->Fetch_schedule_communications($Company_Records["Company_id"]);
					$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_Records["Company_id"]);
					// var_dump($Scheduled_communications);
					// die;
					if($Scheduled_communications !=NULL)
					{			
									
						foreach($Scheduled_communications as $comm)
						{							
							if($comm->Facebook==0)
							{
								$comm->Facebook="";
							}
							if($comm->Twitter==0)
							{
								$comm->Twitter="";
							}
							if($comm->Google==0)
							{
								$comm->Google="";
							}
							if($todays==$comm->Schedule_date)
							{									
								$Scheduled_communications = $this->Administration_model->Update_schedule_communications($comm->Schedule_id);
								
								// echo "---todays----".$todays."--Schedule--date-".$comm->Schedule_date."--User_email_id---".$comm->User_email_id."--Enrollment_id--".$comm->Enrollment_id."-<br>";
								// echo "<br>";								
								// $comm->communication_plan			
																
								$Email_content = array(
										'Communication_id' => $comm->Comm_id,
										'Offer' => $comm->communication_plan,
										'Start_date' => date("d-M-Y",strtotime($comm->From_date)),
										'End_date' => date("d-M-Y",strtotime($comm->Till_date)),
										'Offer_description' =>$comm->description,
										'facebook' =>$comm->Facebook,
										'twitter' =>$comm->Twitter,
										'googleplus' =>$comm->Google,
										'Template_type' => 'Communication'
										);
																
										$send_notification = $this->send_notification->send_Notification_email($comm->Enrollment_id,$Email_content,$comm->seller_id,$Company_Records["Company_id"]);
							}
						}
					}
				}
			}
		}
	}	
?>