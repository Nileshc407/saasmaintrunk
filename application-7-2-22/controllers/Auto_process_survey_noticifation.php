<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

C:\xampp\htdocs\amit\CI_iGainSpark\application\models\igain_model.php..get_all_customers()..345
*/
class Auto_process_survey_noticifation extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('survey/Survey_model');
		$this->load->library('Send_notification');
	} 
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$todays = date("Y-m-d");	
		// echo "todays ------".$todays."<br>";		
		foreach($Company_details as $Company_Records)
		{
			if($Company_Records["Cron_survey_flag"]==1)
			{
				 echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
				$data['survey_details'] = $this->Survey_model->Fatech_survey_details($Company_Records["Company_id"]);
				$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_Records["Company_id"]);
				
				// var_dump($Super_Seller);
				// die;
				if($data['survey_details'] !=NULL)
				{				
					foreach($data['survey_details'] as $Survey)
					{
						 echo "Survey ID ------".$Survey['Survey_id']."<br>";
						echo "Survey Name ------".$Survey['Survey_name']."<br>";
						echo "Survey Start Date ------".$Survey['Start_date']."<br>";
						echo "Survey End Date ------".$Survey['End_date']."<br>";  					
						 
						if(($todays >= $Survey['Start_date']) && ($todays <= $Survey['End_date']))
						{
							$after_5_day = strtotime($Survey['Start_date'] .' +'.$Survey['Reminder_days_after'].' days');
							$after_5_day = date('Y-m-d', $after_5_day);
							
							$befor_5_day = strtotime($Survey['End_date'] .' -'.$Survey['Reminder_days_before'].' days');
							$befor_5_day = date('Y-m-d', $befor_5_day);
							
							 // echo "Survey ID ------".$Survey['Survey_id']."<br>";
							// echo "Survey ID ------".$Survey['Survey_name']."<br>";
							echo "Reminder_days_after ------".$Survey['Reminder_days_after']."<br>";
							echo "Reminder_days_before  ------".$Survey['Reminder_days_before']."<br>";
							
							echo "After days  ------".$after_5_day."<br>";
							 echo "Before days ------".$befor_5_day."<br>";
							
							if($todays == $after_5_day)
							{
								 echo "After days  start survey notification<br>";
								$data['send_survey_details'] = $this->Survey_model->fetch_send_survey_details($Survey['Survey_id'],$Company_Records["Company_id"]);
								// print_r($data['send_survey_details']);
								// echo "<br>";
								
								foreach($data['send_survey_details'] as $sendenroll)
								{
										 // echo "Enrollment_id  ------".$sendenroll['Enrollment_id']."<br>";
										// $sendenroll['Enrollment_id'];
									
											$Email_content = array(
												'Survey_name' => $Survey['Survey_name'],
												'Survey_id' =>$Survey['Survey_id'],
												'Notification_type' => 'Survey Reminder Notification',
												'Template_type' => 'Survey_start_end_notification',
												'Survey_start' => $Survey['Reminder_days_after'],
												'Start_date' => $Survey['Start_date'],
												'End_date' =>$Survey['End_date'],
												'Survey_start_flag' =>1,
												'Todays_date' => $todays
											);									
											$this->send_notification->send_Notification_email($sendenroll['Enrollment_id'],$Email_content,$Super_Seller->Enrollement_id,$Company_Records["Company_id"]);
								
								}
							}
							if($todays == $befor_5_day)
							{	
								
								// echo "before end survey notification<br>";
								$data['send_survey_details12'] = $this->Survey_model->fetch_send_survey_details($Survey['Survey_id'],$Company_Records["Company_id"]);
								// print_r($data['send_survey_details']);
								// echo "<br>";
								
								foreach($data['send_survey_details12'] as $sendenroll12)
								{
										// echo "Enrollment_id  ------".$sendenroll12['Enrollment_id']."<br>";
										// $sendenroll['Enrollment_id'];
									
											$Email_content = array(
												'Survey_name' => $Survey['Survey_name'],
												'Survey_id' =>$Survey['Survey_id'],
												'Notification_type' => 'Survey Reminder Notification',
												'Template_type' => 'Survey_start_end_notification',
												'Survey_end' => $Survey['Reminder_days_before'],
												'Start_date' => $Survey['Start_date'],
												'End_date' =>$Survey['End_date'],
												'Survey_end_flag' =>1,
												'Todays_date' => $todays
											);									
											$this->send_notification->send_Notification_email($sendenroll12['Enrollment_id'],$Email_content,$Super_Seller->Enrollement_id,$Company_Records["Company_id"]);
								
								}
							}			
							
						}
			
					}
				}
			}
		}
	}
}	
?>
	
