<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_Process_birthday_notification extends CI_Controller 
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
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("m-d");
		
		foreach($Company_details as $Company_Records)
		{
			if($Company_Records["Cron_birthday_flag"]==1) 
			{
			echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
			$Communication = $this->Igain_model->Get_birthday_communication($Company_Records["Company_id"]);
			$Trans_Records = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
			$Birthday_Communication=0;
			if($Communication !=NULL)
			{				
				foreach($Communication as $comm)
				{
					$Birthday_Communication= $comm->description;
				}
			}
			if($Trans_Records !=NULL)
			{				
				foreach($Trans_Records as $Cust_Record)
				{
					$Birth_date = date("m-d",strtotime($Cust_Record["Date_of_birth"]));
					$Date_of_birth = date("Y-m-d",strtotime($Cust_Record["Date_of_birth"]));
					
					echo "<br><br>Membership ID-->".$Cust_Record["Card_id"]."<-->Date_of_birth -->".$Date_of_birth."<-->Birth_date -->".$Birth_date;
						
					if(($Date_of_birth!=NULL) && ($Date_of_birth!="") && ($Date_of_birth!="1970-01-01") && ($Date_of_birth!="0000-00-00") && ($Date_of_birth!="0000-00-00") && ($Birth_date==$Todays_date))
					{
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];						
						$Company_id = $Company_Records["Company_id"];
						$Enrollement_id = $Cust_Record["Enrollement_id"];
						
						$Email_content = array(
							'Notification_type' => 'Wish you a very Happy Birthday !!!',
							'Birthday_Communication' => $Birthday_Communication,
							'Template_type' => 'Birthday_Reminder'
						);
							
						$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id);
						
					
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
	
