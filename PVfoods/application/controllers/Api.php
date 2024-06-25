<?php
error_reporting(0);
class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('Survey_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('Send_notification');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->helper('security');
	}
	function bc1fadea() 
	{
		error_reporting(0);
	
		$Survey_data = json_decode(base64_decode($_REQUEST['vvTFsNBjgNhi']));
		$Suy_variables = get_object_vars($Survey_data);
	
		$survey_id = strip_tags($Suy_variables['Survey_id']);
		$gv_log_compid = strip_tags($Suy_variables['Company_id']);
		$Enrollment_id = strip_tags($Suy_variables['Enroll_id']);
		$Card_id = strip_tags($Suy_variables['Card_id']);
			
		$smartphone_flag = 2;
		if($survey_id !="") 
		{
			$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
			if($data['Survey_details'] != NULL)
			{
				$data['From_survey_mail'] = 2;
				$survey_id = $survey_id;
				$gv_log_compid = $gv_log_compid;
				$Enrollment_id = $Enrollment_id;
				$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id,'Card_id'=>$Card_id);
				$data['Survey_data'] = base64_encode(json_encode($myData1));
				
				$data['smartphone_flag']=$smartphone_flag;
				
				$data['Survey_response_count'] = $this->Survey_model->fetch_survey_count($survey_id,$gv_log_compid,$Enrollment_id);
				$flag=$this->input->post('flag');
				$Company_details= $this->Igain_model->get_company_details($gv_log_compid);
				$SurveyTemplate= $this->Survey_model->get_survey_template($survey_id);
				$Company_survey_analysis=$Company_details->Survey_analysis;
				$Survey_name=$SurveyTemplate->Survey_name;
				
				if($SurveyTemplate->Survey_template==1)
				{
					$this->load->view('home/survey_template_app1/index', $data);
				}
				else if($SurveyTemplate->Survey_template==2)
				{
					$this->load->view('home/survey_template_app2/index', $data);
				}
				else if($SurveyTemplate->Survey_template==3)
				{
					$this->load->view('home/survey_template_app3/index', $data);
				}
			}
			else
			{
				echo "no survey found!";
				exit;
			}
		}
		else
		{
			echo "no survey found!";
			exit;
		}	
	}
	function getsurveyquestionapi() 
	{
		$gv_log_compid = $_REQUEST['Company_id'];
		$Enrollment_id = $_REQUEST['Enroll_id'];
		$Card_id = $_REQUEST['Card_id'];
			
		$Survey_data = App_string_decrypt($_REQUEST['Survey_id']);
		$survey_id = App_string_decrypt($_REQUEST['Survey_id']);
		$smartphone_flag = App_string_decrypt($_REQUEST['smartphone_flag']);
		$From_survey_mail = App_string_decrypt($_REQUEST['From_survey_mail']);
		
		if($Survey_data !="") //from Email
		{
			$smartphone_flag = 2;
			$From_survey_mail = 1;
			$survey_id = $survey_id;
			$gv_log_compid = $gv_log_compid;
			$Enrollment_id = $Enrollment_id;
			$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id,'Card_id'=>$Card_id);
			$data['Survey_data'] = base64_encode(json_encode($myData1));
		}
		
		$data['smartphone_flag']=$smartphone_flag;
		
		$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
		$data['Survey_response_count'] = $this->Survey_model->fetch_survey_count($survey_id,$gv_log_compid,$Enrollment_id);
		$flag=$this->input->post('flag');
		$Company_details= $this->Igain_model->get_company_details($gv_log_compid);
		$SurveyTemplate= $this->Survey_model->get_survey_template($survey_id);
		$Company_survey_analysis=$Company_details->Survey_analysis;
		$Survey_name=$SurveyTemplate->Survey_name;
		
		if($_POST == NULL)
		{
			if($SurveyTemplate->Survey_template==1)
			{
				$this->load->view('home/survey_template_app1/index', $data);
			}
			else if($SurveyTemplate->Survey_template==2)
			{
				$this->load->view('home/survey_template_app2/index', $data);
			}
			else if($SurveyTemplate->Survey_template==3)
			{
				$this->load->view('home/survey_template_app3/index', $data);
			}
		}
		else
		{
			if($data['Survey_response_count'] == 0)
			{	
				$Enrollment_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$data['Card_id']=$Enrollment_details->Card_id;
				$data['timezone_entry']=$Enrollment_details->timezone_entry;
				$logtimezone = $data['timezone_entry'];
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time=$date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');
				$data['Survey_details1'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
				foreach($data['Survey_details1'] as $surdtls1)
				{
					$Multiple_selection=$surdtls1['Multiple_selection'];
					$Question=$surdtls1['Question'];
					$Question_id=$surdtls1['Question_id'];
					$Response_type=$surdtls1['Response_type'];
					$Choice_id=$ch_val['Choice_id'];
					$Option_values=$ch_val['Option_values'];

					if($Response_type == 2 ) //Text Based Question
					{
						$get_flag=0;
						$response = $this->input->post($Question_id);
						$Cust_response = strtolower($response);
						if($Company_survey_analysis == 1)
						{
							$get_promoters_dictionary_keywords = $this->Survey_model->get_nps_promoters_keywords($gv_log_compid);
							foreach($get_promoters_dictionary_keywords as $NPS_promo)
							{

								$dictionary_keywords=strtolower($NPS_promo['NPS_dictionary_keywords']);
								$Get_promo_keywords=explode(",",$dictionary_keywords);
								$NPS_type_id=$NPS_promo['NPS_type_id'];
							
								for($i=0;$i<count($Get_promo_keywords); $i++)
								{
									
									$pos = strpos($Cust_response, $Get_promo_keywords[$i]);
									
									if(is_int($pos) == true)
									{
										$get_flag=1;
										$NPS_type_id=$NPS_promo['NPS_type_id'];
										break;
									}
								}
							
								if($get_flag==1)
								{
									$post_data = array(
									'Enrollment_id' => $Enrollment_id,
									'Company_id' => $gv_log_compid,
									'Survey_id' => $survey_id,
									'Question_id' =>$Question_id,
									'Response1' =>$Cust_response,
									'NPS_type_id' =>$NPS_type_id
									);
									$response_flag=0;
									$insert_response = $this->Survey_model->insert_survey_response($post_data);
									if($insert_response == true)
									{
										$response_flag=1;
									}
									else
									{
										$response_flag=0;
									}
									break;
								}
							}
							if($get_flag==0)
							{
								$NPS_type_id=2;
								$post_data = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response1' =>$Cust_response,
								'NPS_type_id' =>$NPS_type_id
								);
								$response_flag=0;
								$insert_response = $this->Survey_model->insert_survey_response($post_data);
								if($insert_response == true)
								{
									$response_flag=1;
								}
								else
								{
									$response_flag=0;
								}
							}
						}
						else
						{
							$post_data = array(
							'Enrollment_id' => $Enrollment_id,
							'Company_id' => $gv_log_compid,
							'Survey_id' => $survey_id,
							'Question_id' =>$Question_id,
							'Response1' =>$this->input->post($Question_id),
							'NPS_type_id' =>'0'
							);
							$response_flag=0;
							$insert_response = $this->Survey_model->insert_survey_response($post_data);
							if($insert_response == true)
							{
								$response_flag=1;

							}
							else
							{
								$response_flag=0;
							}
						}
					}
					else if($Multiple_selection)//Multiple Selection based Question i.e. Check box Based
					{
						$multiple_sel=$this->input->post($Question_id);
						foreach($multiple_sel as $mulsel)
						{
							$array_mul = explode('_',$mulsel);
							$Mul_response2=$array_mul[0];
							$Mul_Choice_id=$array_mul[1];

							if($Company_survey_analysis == 1)
							{
								$Survey_nps_type_id = $this->Survey_model->get_survey_nps_type($Mul_response2);
								$Survey_nps_type=$Survey_nps_type_id->NPS_type_id;
							}
							
							if($Survey_nps_type ==1 )
							{
								$Promo_nps[]=$Survey_nps_type;
							}
							else if($Survey_nps_type ==2 )
							{
								$Passive_nps[]=$Survey_nps_type;
							}
							else
							{
								$Dectractive_nps[]=$Survey_nps_type;
							}
						}

						if(count($Promo_nps) > 0 || count($Passive_nps) > 0 || count($Dectractive_nps) > 0 )
						{
							if(count($Promo_nps) == count($Dectractive_nps))
							{
								$Survey_nps_type=2;
							}
							else if(count($Promo_nps) > count($Dectractive_nps) && count($Promo_nps) > count($Passive_nps))
							{
								$Survey_nps_type=1;
							}
							else if(count($Passive_nps) >= count($Dectractive_nps))
							{
								$Survey_nps_type=1;
							}
							else
							{
								$Survey_nps_type=3;
							}
						}
						else
						{
							$Survey_nps_type=2;
						}

						if($Survey_nps_type != "")
						{
							$NPS_type_id12 = $Survey_nps_type;
						}
						else
						{
							$NPS_type_id12 =2;
						}
						if($Mul_response2 != "")
						{
							$Mul_response2=$Mul_response2;
						}
						else
						{
							$Mul_response2=0;
						}
						if($Mul_Choice_id != "")
						{
							$Mul_Choice_id=$Mul_Choice_id;
						}
						else
						{
							$Mul_Choice_id=0;
						}

						$post_data1 = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response2' => $Mul_response2,
								'Choice_id' => $Mul_Choice_id,
								'NPS_type_id' => $NPS_type_id12
								);
							
						$response_flag=0;
						$insert_response = $this->Survey_model->insert_survey_response($post_data1);
						if($insert_response == true)
						{
							$response_flag=1;

						}
						else
						{
							$response_flag=0;
						}


						unset($Promo_nps);
						unset($Passive_nps);
						unset($Dectractive_nps);

					}
					else //MCQ based Question i.e. Radio Based
					{
						$array = explode('_',$this->input->post($Question_id));
					
						$Response2=$array[0];
						$Choice_id=$array[1];
						
						if($Company_survey_analysis == 1)
						{
							$Survey_nps_type_id = $this->Survey_model->get_survey_nps_type($Response2);
							$Survey_nps_type=$Survey_nps_type_id->NPS_type_id;
						}
					
						if($Survey_nps_type != "")
						{
							$NPS_type_id12 = $Survey_nps_type;
						}
						else
						{
							$NPS_type_id12 = 2;
						}
						if($Response2 != "")
						{
							$Response2=$Response2;
						}
						else
						{
							$Response2=0;
						}
						if($Choice_id != "")
						{
							$Choice_id=$Choice_id;
						}
						else
						{
							$Choice_id=0;
						}
						$post_data = array(
							'Enrollment_id' => $Enrollment_id,
							'Company_id' => $gv_log_compid,
							'Survey_id' => $survey_id,
							'Question_id' =>$Question_id,
							'Response2' => $Response2,
							'Choice_id' => $Choice_id,
							'NPS_type_id' => $NPS_type_id12
							);
					
						$response_flag=0;
						$insert_response = $this->Survey_model->insert_survey_response($post_data);
						if($insert_response == true)
						{
							$response_flag=1;

						}
						else
						{
							$response_flag=0;
						}
					}
				}
				if($response_flag=1)
				{
					$Survey_details=$this->Survey_model->get_survey_details($survey_id,$gv_log_compid);
					 $Survey_name=$Survey_details->Survey_name;
					 $Start_date=$Survey_details->Start_date;
					 $End_date=$Survey_details->End_date;
					 $Survey_reward_points=$Survey_details->Survey_reward_points;
					 $Survey_rewarded=$Survey_details->Survey_rewarded;

					if(($Survey_rewarded == 1) && ( $Todays_date >= $Start_date && $Todays_date <= $End_date ))
					{
						$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
						$Card_id=$Enroll_details->Card_id;
						$Current_balance=$Enroll_details->Current_balance;
						$Total_topup_amt=$Enroll_details->Total_topup_amt;
						$Blocked_points =$Enroll_details->Blocked_points;

						$post_data1 = array(
							'Company_id' => $gv_log_compid,
							'Trans_type' => 13,
							'Topup_amount' => $Survey_reward_points,
							'Trans_date' => $lv_date_time,
							'Enrollement_id' => $Enrollment_id,
							'Card_id' => $Card_id,
							'Remarks' => 'Survey Reward '.$Company_details->Currency_name
							);
							$insert_survey_rewards=$this->Survey_model->insert_survey_rewards_transaction($post_data1);

						if($insert_survey_rewards == TRUE)
						{
							 $Total_Current_Balance=$Current_balance+$Survey_reward_points;
							 $Total_Topup_Amount=$Total_topup_amt+$Survey_reward_points;
							$data1=array(
							'Current_balance' => $Total_Current_Balance,
							'Total_topup_amt' => $Total_Topup_Amount
							);

							$update_balance=$this->Survey_model->update_member_balance($data1,$Enrollment_id,$gv_log_compid);

							$SuperSeller=$this->Igain_model->get_super_seller_details($gv_log_compid);
							$SuperSellerEnrollID=$SuperSeller->Enrollement_id;
							$member_details=$this->Igain_model->get_enrollment_details($Enrollment_id);

							$Total_Current_Balance =  $Total_Current_Balance - $Blocked_points;
							$Email_content = array(
								'SurveyRewardsPoints' => $Survey_reward_points,
								'Survey_name' => $Survey_name,
								'Notification_type' => 'Survey Reward '.$Company_details->Currency_name,
								'Template_type' => 'Survey_rewards'
								);

							$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$SuperSellerEnrollID,$gv_log_compid);

						}
					}
				/*********************igain Log Table*************************/
					$User_id = $result->User_id;
					$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
					$User_id = $Enroll_details->User_id;
					$email = $Enroll_details->User_email_id;
					$opration = 1;
					$what="Survey Response";
					$where="Take Survey";
					$toname="";
					$toenrollid = 0;
					$opval = 'Survey Name: '.$Survey_name;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($gv_log_compid,$Enrollment_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table*************************/
				
					if($Survey_rewarded == 1)
					{
						$data["Message"] = "The Survey Feedback has been submitted successfully. Thank You for the same. You have received $Survey_reward_points Reward Bonus $Company_details->Currency_name . Please check your email for more details.";
					}
					else
					{
						$data["Message"] = "The Survey Feedback has been submitted successfully.";
					}
				}
				else
				{
					$data["Message"] = "Error Submitting Survey Feedback. Please Provide valid data.";
				}
			}
			else		
			{
				$data["Message"] = "It seems you have given the survey or you do not have any survey";
			}
			
			$this->load->view('home/survey_template_app1/message', $data);
		}	
	}
}
?>