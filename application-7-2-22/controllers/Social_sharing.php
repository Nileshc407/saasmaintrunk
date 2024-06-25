<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_sharing extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');	
		$this->load->model('Social_sharing/Social_sharing_model');	
		$this->load->model('Igain_model');
	}
	
	public function share_notification()
	{
		if($_GET != NULL)
		{
			$Title = urldecode($_GET['Title']);
			$Content = html_entity_decode(urldecode($_GET['Content']));
			$Image_path = urldecode($_GET['Image_path']);
			$Flag = $_GET['Flag'];

			$Title1 = $_GET['Title'];
			$Content1 = $_GET['Content'];
			$Image_path1 = $_GET['Image_path'];
			$Social_icon_flag = $_GET['Social_icon_flag'];
			$Share_redirection_link = $_GET['Share_redirection_link'];
			$Enrollement_id = $_GET['Enrollement_id'];
			$Company_id = $_GET['Company_id'];
			$User_notification_id = $_GET['User_notification_id'];
			
			$Short_Share_redirection_link = $this->make_bitly_url($Share_redirection_link,'muleakshay29','R_bd6d5c29b37c40aca2abf12c318a85f8','json');
			$URL = "http://demo1.igainspark.com/index.php/Social_sharing/share_notification/?Title=".$Title1."&Content=".$Content1."&Image_path=".$Image_path."&Flag=2";
			$Short_url = $this->make_bitly_url($URL,'muleakshay29','R_bd6d5c29b37c40aca2abf12c318a85f8','json');

			$Content1 = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $Content1);
			$Content1 = str_replace("&nbsp;", "", $Content1);
			$Content1 = trim(preg_replace('/\s\s+/', ' ', $Content1));
			
			$data["Title"] = $Title;
			$data["Content"] = $Content1;
			$data["Image_path"] = $Image_path;
			$data["Flag"] = $Flag;
			$data["Social_icon_flag"] = $Social_icon_flag;
			$data["Short_Share_redirection_link"] = $Short_Share_redirection_link;
			$data["Short_url"] = $Short_url;
			$data["Enrollement_id"] = $Enrollement_id;
			$data["Company_id"] = $Company_id;
			$data["User_notification_id"] = $User_notification_id;
			
			$this->load->view("Social_sharing/share_notification",$data);
		}
		else
		{
			redirect(current_url());
		}
	}
	
	public function insert_share_notification_details()
	{
		if($_POST != NULL)
		{
			$Insert_error = 0;
			$Today_date = date("Y-m-d");
			$Company_id = $this->input->post("Company_id");
			$Enrollement_id = $this->input->post("Enrollement_id");
			$Social_icon_flag = $this->input->post("Social_icon_flag");
			$User_notification_id = $this->input->post("User_notification_id");
			$Update_date = date("Y-m-d");
			
			$Company_details = $this->Igain_model->get_company_details($Company_id);
			
			if($Social_icon_flag == 1)
			{
				$Social_share_points = $Company_details->Facebook_share_points;
				$Social_media = "Facebook";
			}
			if($Social_icon_flag == 2)
			{
				$Social_share_points = $Company_details->Twitter_share_points;
				$Social_media = "Twitter";
			}
			if($Social_icon_flag == 3)
			{
				$Social_share_points = $Company_details->Google_share_points;
				$Social_media = "Google Plus";
			}
			
			$customer_details = $this->Igain_model->get_enrollment_details($Enrollement_id);
			
			if($Company_details->Share_type == 1 || $Company_details->Share_type == 0)
			{
				$check_social_shared = $this->Social_sharing_model->check_social_shared($Enrollement_id,$Company_id,$Social_icon_flag);
			
				/*---------------------------------For Share Once--------------------------*/
					$check_social_shared2 = $this->Social_sharing_model->check_social_shared2($Enrollement_id,$Company_id,$Social_icon_flag,$User_notification_id);
				/*---------------------------------For Share Once--------------------------*/
				
				if($Company_details->Share_type == 1 && $check_social_shared2 == 1)
				{
					$Insert_error = 1;
				}
				
				if($Company_details->Share_type == 1 && $check_social_shared2 != 1)
				{
					/*---------------------------------Insert Share Count 1 for Share Once--------------------------*/
					$Share_count = '1';
					$Share_insert_array = array(
						'Enrollement_id' => $Enrollement_id,
						'Company_id' => $Company_id,
						'Share_count' => $Share_count,
						'User_notification_id' => $User_notification_id,
						'Social_media' => $Social_icon_flag
					);
					$share_notification_details = $this->Social_sharing_model->insert_share_notification_details($Share_insert_array);
					if($share_notification_details == true)
					{
						$Insert_error = 1;
						/*---------------------------------Update Customer Balance--------------------------*/
						$Current_balance = $customer_details->Current_balance;
						$New_Current_balance = $Current_balance + $Social_share_points;
						$update_member_balance = $this->Social_sharing_model->update_member_balance($Enrollement_id,$New_Current_balance);
						/*---------------------------------Update Customer Balance--------------------------*/
						
						if($update_member_balance == true)
						{
							$Insert_error = 1;
							/*---------------------------------Insert Transaction Of Share Points--------------------------*/
							$Trans_type = '15';
							$Share_transaction_array = array(
								'Company_id' => $Company_id,
								'Trans_type' => '15',
								'Trans_date' => $Today_date,
								'Create_user_id' => $Enrollement_id,
								'Enrollement_id' => $Enrollement_id,
								'Card_id' => $customer_details->Card_id,
								'Topup_amount' => $Social_share_points,
								'Remarks' => $Social_media." Sharing"
							);
							$insert_share_transaction = $this->Social_sharing_model->insert_share_transaction($Share_transaction_array);
							
							if($insert_share_transaction == true)
							{
								$Insert_error = 1;
							}
							/*---------------------------------Insert Transaction Of Share Points--------------------------*/
						}
					}
					/*---------------------------------Insert Share Count 1 for Share Once--------------------------*/
				}
				
				if($Company_details->Share_type == 0 && ($check_social_shared == $Company_details->Share_limit) )
				{
					$Insert_error = 1;
				}
				
				if($Company_details->Share_type == 0 && ($check_social_shared != $Company_details->Share_limit) )
				{
					$check_social_shared3 = $this->Social_sharing_model->check_social_shared2($Enrollement_id,$Company_id,$Social_icon_flag,$User_notification_id);
					
					if($check_social_shared3 == 1)
					{
						$Insert_error = 1;
					}
					else
					{
						/*---------------------------------Insert Share Count 1 for Share Once--------------------------*/
						$Share_count = '1';
						$Share_insert_array = array(
							'Enrollement_id' => $Enrollement_id,
							'Company_id' => $Company_id,
							'Share_count' => $Share_count,
							'User_notification_id' => $User_notification_id,
							'Social_media' => $Social_icon_flag
						);
						$share_notification_details = $this->Social_sharing_model->insert_share_notification_details($Share_insert_array);
						
						if($share_notification_details == true)
						{
							$Insert_error = 1;
							/*---------------------------------Update Customer Balance--------------------------*/
							$Current_balance = $customer_details->Current_balance;
							$New_Current_balance = $Current_balance + $Social_share_points;
							$update_member_balance = $this->Social_sharing_model->update_member_balance($Enrollement_id,$New_Current_balance);
							/*---------------------------------Update Customer Balance--------------------------*/
							
							if($update_member_balance == true)
							{
								$Insert_error = 1;
								/*---------------------------------Insert Transaction Of Share Points--------------------------*/
								$Trans_type = '15';
								$Share_transaction_array = array(
									'Company_id' => $Company_id,
									'Trans_type' => '15',
									'Trans_date' => $Today_date,
									'Create_user_id' => $Enrollement_id,
									'Enrollement_id' => $Enrollement_id,
									'Card_id' => $customer_details->Card_id,
									'Topup_amount' => $Social_share_points,
									'Remarks' => $Social_media." Sharing"
								);
								$insert_share_transaction = $this->Social_sharing_model->insert_share_transaction($Share_transaction_array);
								
								if($insert_share_transaction == true)
								{
									$Insert_error = 1;
								}
								/*---------------------------------Insert Transaction Of Share Points--------------------------*/
							}
						}
						/*---------------------------------Insert Share Count 1 for Share Once--------------------------*/
					}
				}
			}
			else
			{
				$Insert_error = 0;
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('Insert_error'=> $Insert_error)));
		}
		else
		{
			
		}
	}
	
	function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
	{		
		//create the URL
		$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
		
		//get the url
		//could also use cURL here
		$response = file_get_contents($bitly);
		
		//parse depending on desired format
		if(strtolower($format) == 'json')
		{
			$json = @json_decode($response,true);
			return $json['results'][$url]['shortUrl'];
		}
		else //xml
		{
			$xml = simplexml_load_string($response);
			return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
		}
	}
}
?>

