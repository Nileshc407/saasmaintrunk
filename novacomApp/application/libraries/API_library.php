<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class API_library 
{	
	public function __construct() 
    {
		$this->CI = &get_instance();
		$this->CI->load->model('Igain_model');
		$this->CI->load->library('cart');
		$this->CI->load->library('Send_notification');
		$this->CI->load->model('shopping/Shopping_model');
		$this->CI->load->model('login/Login_model');
		$this->CI->load->model('survey/Survey_model');
		$this->CI->load->model('Beneficiary/Beneficiary_model');
		$this->CI->load->model('Redemption_Catalogue/Redemption_Model');
	}	
	public function Get_survey($enroll,$Company_id)
	{		
		$get_survey_details = $this->CI->Survey_model->get_send_survey_details($enroll,$Company_id);	
		return $get_survey_details;
	}
	public function Get_survey_question($survey_id,$gv_log_compid,$Enrollment_id)
	{		
		$survey_question_details = $this->CI->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);	
		return $survey_question_details;
	}  
	public function get_MCQ_choice_values($Choice_id)
	{		
		$survey_question_details = $this->CI->Survey_model->get_MCQ_choice_values($Choice_id);	
		return $survey_question_details;
	} 
	public function update_profile($column,$value,$Enrollment_id)
	{		
		$Update_profile = $this->CI->Igain_model->update_profile_api($column,$value,$Enrollment_id);	
		return $Update_profile;		
	}
	public function customer_login($username,$password,$Company_id,$flag)
	{		
		$Login_result = $this->CI->Login_model->customer_login($username,$password,$Company_id,$flag);
		return $Login_result;		
	} 
	public function get_tier_name($Tier_id)
	{		
		$Tier_name = $this->CI->Igain_model->get_tier_name($Tier_id);
		return $Tier_name->Tier_name;		
	} 
	public function get_dial_code($Country_id)
	{		
		$Country_details = $this->CI->Igain_model->get_dial_code($Country_id);
		return $Country_details->Country_name;		
	}
	public function Total_gained_points($Company_id,$Enrollement_id)
	{		
		$data["Trans_details_summary"] = $this->CI->Igain_model->get_cust_trans_summary_all($Company_id,$Enrollement_id);
		foreach($data["Trans_details_summary"] as $trans)
		{
			$Total_gainedPoints=$trans["Total_gained_points"];
		}
		return $Total_gainedPoints;		
	}
	public function Check_EmailID($User_email_id,$Company_id)
	{		
		$Check_EmailID= $this->CI->Igain_model->Check_EmailID($User_email_id,$Company_id);
		return $Check_EmailID;		
	}	
	public function forgot_password($email,$Company_id)
	{		
		$Forgot_Password = $result = $this->CI->Igain_model->forgot_email_notification($email,$Company_id);
		if($Forgot_Password !="")
		{
			$Email_content = array(
					'Password' => $result->Forgot_Password,
					'Notification_type' => 'Request For Password',
					'Template_type' => 'Forgot_password'
				);
				
				$Forgot_Password = $this->CI->send_notification->send_Notification_email($result->Enrollement_id,$Email_content,'1',$Company_id);
		}
		return $Forgot_Password;		
	}
	public function change_password($old_Password,$Company_id,$Enrollment_id,$new_Password)
	{		
		$Chnage_Password = $this->CI->Igain_model->Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$new_Password);
		if($Chnage_Password !="")
		{
			
			$SuperSeller=$this->CI->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			$Email_content = array(
				'New_password' => $new_Password,
				'Notification_type' => 'Password Change',
				'Template_type' => 'Change_password'
			);
			$Chnage_Password = $this->CI->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);
				
		}
		return $Chnage_Password;		
	}
	public function Resend_pin($Company_id,$Enrollment_id)
	{		
		$Resend_pin = $this->CI->Igain_model->get_customer_pin($Company_id,$Enrollment_id);
		if($Resend_pin !="")
		{
			
			$SuperSeller=$this->CI->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			$Email_content = array(
				'Pin_No' => $Resend_pin->pinno,
				'Notification_type' => 'Pin Send',
				'Template_type' => 'Change_pin'
				);
			
			$Resend_pin=$this->CI->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);				
		}
		return $Resend_pin;		
	} 
	public function Change_pin($Company_id,$Enrollment_id,$newpin)
	{		
		$Change_pin = $this->CI->Igain_model->Change_Old_Pin($Company_id,$Enrollment_id,$newpin);	
		if($Change_pin !="")
		{			
			$SuperSeller=$this->CI->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			$Email_content = array(
				'Pin_No' => $newpin,
				'Notification_type' => 'Pin Send',
				'Template_type' => 'Change_pin'
				);			
			$Change_pin=$this->CI->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);				
		}
		return $Change_pin;		
	}	
	public function transfer_points($Company_id,$Enrollement_id,$Card_id,$Enrollement_id_1,$Card_id_1,$points_to_transfer)
	{		
		$Enroll_details = $this->CI->Igain_model->get_enrollment_details($Enrollement_id);	
		$logtimezone = $Enroll_details->timezone_entry;
		$timezone = new DateTimeZone($logtimezone);
		$date = new DateTime();
		$date->setTimezone($timezone);
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');
		
		$Transfer_PTS = array(					
						'Company_id' => $Company_id,
						'Trans_type' => '8',
						'Transfer_points' => $points_to_transfer,        
						'Remarks' => 'Transfer Points',       
						'Trans_date' => $lv_date_time,
						'Enrollement_id' => $Enrollement_id,
						'Card_id' => $Card_id,
						'Enrollement_id2' => $Enrollement_id_1,
						'Card_id2' => $Card_id_1,
						);
		$Insert_transaction = $this->CI->Igain_model->Insert_transfer_transaction($Transfer_PTS);		
		
		/*-------Member transafer to Others--------*/
		$First_name=$Enroll_details->First_name;		
		$Last_name=$Enroll_details->Last_name;
		$Enroll_Current_balance=$Enroll_details->Current_balance;		
		$Enroll_Total_topup_amt=$Enroll_details->Total_topup_amt;		
		$Enroll_total_purchase=$Enroll_details->total_purchase;		
		$Enroll_Total_reddems=$Enroll_details->Total_reddems;
		
		$New_login_curr_balance=$Enroll_Current_balance - $points_to_transfer;
		
		$Member_update=$this->CI->Igain_model->update_customer_balance($Card_id,$New_login_curr_balance,$Company_id,$Enroll_Total_topup_amt,$lv_date_time,$Enroll_total_purchase,$Enroll_Total_reddems);				
		
		/*-------Get points from Othres--------*/
		$Transfer_enroll= $this->CI->Igain_model->get_enrollment_details($Enrollement_id_1);
		
		$Transfer_First_name=$Transfer_enroll->First_name;		
		$Transfer_Last_name=$Transfer_enroll->Last_name;		
		$Transfer_Current_balance=$Transfer_enroll->Current_balance;		
		$Transfer_Total_topup_amt=$Transfer_enroll->Total_topup_amt;		
		$Transfer_total_purchase=$Transfer_enroll->total_purchase;		
		$Transfer_Total_reddems=$Transfer_enroll->Total_reddems;
		
		$Transfer_member_curr_balance=$Transfer_Current_balance + $points_to_transfer;	
		$Transfer_ToT_topup_amt=$Transfer_Total_topup_amt + $points_to_transfer;	
		
		$Refree_update=$this->CI->Igain_model->update_customer_balance($Card_id_1,$Transfer_member_curr_balance,$Company_id,$Transfer_ToT_topup_amt,$lv_date_time,$Transfer_total_purchase,$Transfer_Total_reddems);
		
			$Transfer_Points2=$points_to_transfer;
			/**Get Super seller details***/
			$Super_Seller_details=$this->CI->Igain_model->Fetch_Super_Seller_details($Company_id);
			$seller_id=$Super_Seller_details->Enrollement_id;
			$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
			$top_db2 = $Super_Seller_details->Topup_Bill_no;
			$len2 = strlen($top_db2);
			$str2 = substr($top_db2,0,5);
			$tp_bill2 = substr($top_db2,5,$len2);						
			$topup_BillNo2 = $tp_bill2 + 1;
			$billno_withyear_ref = $str2.$topup_BillNo2;
			
			$post_data = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $points_to_transfer,        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Get by Transfer Points',
						'Enrollement_id' => $Enrollement_id_1,
						'Card_id' => $Card_id_1,
						'Enrollement_id2' => $Enrollement_id,
						'Card_id2' => $Card_id,
						'Seller' => $seller_id,
						'Bill_no' => $tp_bill2
					);
					$result45 = $this->CI->Igain_model->insert_transction($post_data);
			
			$result7 = $this->CI->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
			
			if($result45 > 0 )
			{			
				$Email_content12=array(							
					'Notification_type' =>'You have Received Points from ',
					'Received_from' =>$First_name.' '.$Last_name,
					'Received_points' =>$Transfer_Points2,
					'Template_type' => 'Get_transfer_points'
						
				);	
				$result_get_transerfed=$this->CI->send_notification->send_Notification_email($Enrollement_id_1,$Email_content12,'0',$Company_id);			
			
				$Email_content=array(							
					'Notification_type' =>'You have Transferred Points ',
					'Transferred_to' =>$Transfer_First_name.' '.$Transfer_Last_name,
					'Transferred_points' =>$points_to_transfer,
					'Template_type' => 'Transfer_points'										
					);	
				$result_transerfed=$this->CI->send_notification->send_Notification_email($Enrollement_id,$Email_content,'0',$Company_id);
			
			}
			return $result45;		
	}	
	public function update_promocode($Promo_code,$Company_id,$Enrollement_id)
	{
		$Enroll_details = $this->CI->Igain_model->get_enrollment_details($Enrollement_id);	
		$Enrollment_id = $Enroll_details->Enrollement_id;
		$Current_balance = $Enroll_details->Current_balance;
		$logtimezone = $Enroll_details->timezone_entry;
		$membership_id = $Enroll_details->Card_id;
		
		$timezone = new DateTimeZone($logtimezone);
		$date = new DateTime();
		$date->setTimezone($timezone);
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');
		
		$Promocode_Details=$this->CI->Igain_model->get_promocode_details($Promo_code,$Company_id);
		$PromocodePoints=$Promocode_Details->Points;  				
		$Promo_code_status=$Promocode_Details->Promo_code_status;  
		
		$post_data = array('Promo_code_status' =>'1');	
		$result = $this->CI->Igain_model->update_promocode($post_data,$Promo_code,$Company_id,$Enrollment_id,$Current_balance,$membership_id,$lv_date_time);
		
		$SuperSeller=$this->CI->Igain_model->get_super_seller_details($Company_id);
		$SuperSellerEnrollID=$SuperSeller->Enrollement_id;
		if($result == true)
		{
			$Email_content = array(
				'PromocodePoints' => $PromocodePoints,
				'Promo_code' => $Promo_code,
				'Notification_type' => 'Promo Code',
				'Template_type' => 'Promo_code'
			);
		$send_notify=$this->CI->send_notification->send_Notification_email($Enrollment_id,$Email_content,$SuperSellerEnrollID,$Company_id);
		}
		return $PromocodePoints;
	}
	public function Get_callceter_query_type($Company_id)
	{		
		$query_type= $this->CI->Igain_model->get_query_type($Company_id);
		return $query_type;		
	}
	public function Get_sub_query($Query_type_id,$Company_id)
	{		
		$query_type= $this->CI->Igain_model->Get_sub_query_name($Query_type_id,$Company_id);
		return $query_type;		
	}
	public function Insert_contactus($Company_id,$Customer_enrollId,$membership_id,$contact_subject,$contactus_SMS,$Query_type_id,$Query_id)
	{		
		
		if($contact_subject != 4 )
		{
			$contactus_message = $this->CI->Igain_model->Insert_contactus_message($Company_id,$Customer_enrollId,$membership_id,$contact_subject,$contactus_SMS);		
		
			$Super_Seller = $this->CI->Igain_model->Fetch_Super_Seller_details($Company_id);
			$User_email_id=$Super_Seller->User_email_id;
			$Seller_enroll_id=$Super_Seller->Enrollement_id;					
			if($contactus_message > 0)
			{						
				$Email_content = array(
						'Communication_id' => '0',
						'Notification_type' => $contact_subject,
						'Notification_description' =>$contactus_SMS,
						'Template_type' => 'Contactus'
					);								
				$this->CI->send_notification->send_Notification_email($Customer_enrollId,$Email_content,$Seller_enroll_id,$Company_id);
				
				$Email_content12 = array(
						'Communication_id' => '0',
						'Notification_type' => $contact_subject,
						'Notification_description' =>$contactus_SMS,
						'Template_type' => 'Contactus_feedback'
					   );								
				$this->CI->send_notification->send_Notification_email($Customer_enrollId,$Email_content12,$Seller_enroll_id,$Company_id);
				return $contactus_message;		
			}			
		}
		else
		{
			$Query_Type = $Query_type_id;
			$Sub_query_type =  $Query_id;
			$contactus_SMS =  $contactus_SMS;
			$Qstatus='Forward';
			$Closerremark = '';							
			$User_detail = $this->CI->Igain_model->Get_ccquery_user($Query_Type,$Company_id);
			$cc_user_id=$User_detail->Enrollment_id;
			$Company_details= $this->CI->Igain_model->get_company_details($Company_id);
			$Querylog_ticket=$Company_details->Callcenter_query_ticketno_series;
			$today=date('Y-m-d H:i:s');
			$nextday = strftime("%Y-%m-%d", strtotime("$today +1 day"));
			$Post_data=array
				   ( 
					'Company_id'=>$Company_id,
					'Membership_id'=>$membership_id,
					'Querylog_ticket'=>$Querylog_ticket,
					'Call_type'=>'Inbound',
					'Communication_type'=>'Email',
					'Query_type_id'=>$Query_Type,
					'Sub_query_type_id'=>$Sub_query_type,
					'Query_details'=>$contactus_SMS,
					'Next_action_date'=>$today, 
					'Closure_date'=>$nextday,
					'Resolution_priority_levels'=>1,
					'Query_assign'=>$cc_user_id,
					'Enrollment_id'=>$cc_user_id,
					'Query_status'=>$Qstatus,
					'Create_User_id'=>$Customer_enrollId,
					'Creation_date'=>$today
				   );
			$result = $this->CI->Igain_model->Insert_callcenter_querylog_master($Post_data);
			
			$User_detail = $this->CI->Igain_model->Get_ccquery_userchild($Query_Type,$Company_id);
			foreach($User_detail as $user)
			{
			  $cc_user_id=$user['Enrollment_id'];
			  
			  $Post_data1=array
				   ( 
					'Query_log_id'=>$result,
					'Company_id'=>$Company_id,
					'Membership_id'=>$membership_id,
					'Querylog_ticket'=>$Querylog_ticket,
					'Query_details'=>$contactus_SMS,
					'Query_interaction'=>$Closerremark,
					'Enrollment_id'=>$cc_user_id,
					'Call_type'=>'Inbound',
					'Communication_type'=>'Email',							
					'Next_action_date'=>$today, 
					'Closure_date'=>$nextday,
					'Query_status'=>$Qstatus,
					'Query_assign'=>$cc_user_id,
					'Create_User_id'=>$Customer_enrollId,
					'Creation_date'=>$today
				   ); 
				$result1 = $this->CI->Igain_model->Insert_callcenter_querylog_child($Post_data1);
			}			
			$Post_data=array('Callcenter_query_ticketno_series'=>$Querylog_ticket+1);		   
			$result = $this->CI->Igain_model->Update_company_ticketno_series($Post_data,$Company_id);
			
			/***************Send Query Log Notification********************/
			$enroll1=0;
			$Notification_type = "Call center query log";
			$Member_details = $this->CI->Igain_model->get_enrollment_details($Customer_enrollId);
			$Cust_name=$Member_details->First_name.' '.$Member_details->Last_name;
			$Enroll_details1 = $this->CI->Igain_model->get_enrollment_details($cc_user_id);
			$Excecative_name=$Enroll_details1->First_name.' '.$Enroll_details1->Last_name;
			$Excecative_email=$Enroll_details1->User_email_id;
			$Email_content = array(
					'Today_date' => $today,
					'Cust_name' => $Cust_name,
					'Excecative_name' => $Excecative_name,
					'Querylog_ticket' => $Querylog_ticket,
					'Max_resolution_datetime' => $nextday,
					'Excecative_email' => $Excecative_email,
					'Notification_type' => $Notification_type,
					'Template_type' => 'Call_Center_Query_Log'
				);	
			$this->CI->send_notification->send_Notification_email($Customer_enrollId,$Email_content,$enroll1,$Company_id); 
			/***************Send Query Log Notification********************/			
			return $Querylog_ticket;
		}
	}
	public function Fetch_hobbies($Enrollement_id,$Company_id)
	{
		$Hobbies_details=$this->CI->Igain_model->get_hobbies_interest_details($Enrollement_id,$Company_id);
		return $Hobbies_details;
	}
	public function get_all_hobbies_details()
	{
		$All_hobbies=$this->CI->Igain_model->get_all_hobbies_details();
		return $All_hobbies;
	}
	public function delete_hobbies($Company_id,$Enrollment_id)
	{
		$Delete_hobbies= $this->CI->Igain_model->delete_hobbies($Company_id,$Enrollment_id);
		return $Delete_hobbies;
	}
	public function insert_hobbies($Company_id,$Enrollment_id,$hobbis)
	{
		$Insert_hobbies=$this->CI->Igain_model->insert_hobbies($Company_id,$Enrollment_id,$hobbis);
		return $Insert_hobbies;
	}
	public function Fetch_Seller_Campaign($Company_id)
	{
		$todays=date('Y-m-d');
		$SellerCampaign=$this->CI->Igain_model->Fetch_Seller_Campaign($Company_id,$todays);
		return $SellerCampaign;
	}
	public function Fetch_Seller_referral_Campaign($Company_id)
	{
		$todays=date('Y-m-d');
		$SellerReferralCampaign=$this->CI->Igain_model->Fetch_Seller_referral_Campaign($Company_id,$todays);
		return $SellerReferralCampaign;
	}
	public function Fetch_seller_communication($Company_id,$enroll)
	{
		$SellerCommunication=$this->CI->Igain_model->Fetch_seller_communication($Company_id,$enroll);
		return $SellerCommunication;
	}
	public function Fetch_All_notification($Enrollement_id,$Company_id)
	{
		$AllNotification=$this->CI->Igain_model->Fetch_All_Read_NotificationDetails('','',$Enrollement_id,$Company_id);
		return $AllNotification;
	}
	public function Fetch_AllRead_notification($Enrollement_id,$Company_id)
	{
		$AllReadNotification=$this->CI->Igain_model->Fetch_Read_Notifications_Details('','',$Enrollement_id,$Company_id);
		return $AllReadNotification;
	}
	public function Fetch_AllOpen_notification($Enrollement_id,$Company_id)
	{
		$AllOpenNotification=$this->CI->Igain_model->Fetch_Open_Notification_Details('','',$Enrollement_id,$Company_id);
		return $AllOpenNotification;
	}
	public function FetchNotifications($Notification_id)
	{
		$FetchNotification=$this->CI->Igain_model->FetchNotifications($Notification_id);
		$post_data = array('Open_flag' =>'1' );				
		$result = $this->CI->Igain_model->Update_Notification($post_data,$Notification_id);
		return $FetchNotification;
	}
	public function DeleteNotifications($Notification_id)
	{
		$Notifications = $this->CI->Igain_model->delete_notification($Notification_id);		
		return $Notifications;
	}
	public function GetAuction($Company_id,$Today_date)
	{
		$Auction_array = $this->CI->Igain_model->FetchCompanyAuction($Company_id,$Today_date);		
		return $Auction_array;
	}
	public function Auction_Total_Bidder($Auction_id,$Company_id)
	{
		$Total_Auction_Bidder = $this->CI->Igain_model->Auction_Total_Bidder($Auction_id,$Company_id);		
		return $Total_Auction_Bidder;
	}
	public function Auction_Top_Bidder($Auction_id,$Company_id)
	{
		$Top5_Auction_Bidder = $this->CI->Igain_model->Auction_Top_Bidder($Auction_id,$Company_id);		
		return $Top5_Auction_Bidder;
	}
	public function Auction_Max_Bid_Value($Auction_id,$Company_id)
	{
		$Auction_Max_Bid_val = $this->CI->Igain_model->Auction_Max_Bid_Value($Auction_id,$Company_id);		
		return $Auction_Max_Bid_val;
	}
	public function Auction_details($Auction_id)
	{
		$Auction_details = $this->CI->Igain_model->get_auction_details($Auction_id);	
		return $Auction_details;
	}
	public function Fetch_Auction_Max_Bid_Value($Auction_id,$Company_id)
	{
		$MAX_bid_Auction= $this->CI->Igain_model->Fetch_Auction_Max_Bid_Value($Auction_id,$Company_id);	
		return $MAX_bid_Auction;
	}
	public function insert_auction_bidding($Super_Seller,$Auction_id,$Company_id,$Enrollment_id,$Prize,$Bid_value)
	{
		$Creation_date=date('Y-m-d');
		$Insert_Auction= $this->CI->Igain_model->insert_auction_bidding_api($Super_Seller,$Auction_id,$Company_id,$Enrollment_id,$Prize,$Bid_value);	
		return $Insert_Auction;
	}
	public function Check_Beneficiary_members_exist($Company_id,$Enrollment_id,$lv_Beneficiary_membership_id)
	{		
		$Check_already_exist= $this->CI->Beneficiary_model->Check_Beneficiary_members_exist($Company_id,$Enrollment_id,$lv_Beneficiary_membership_id);
		return $Check_already_exist;
	}
	public function Check_beneficiary_customer($Beneficiary_membership_id,$Igain_company_id,$Beneficiary_name)
	{		
		$Check_user= $this->CI->Beneficiary_model->Check_beneficiary_customer($Beneficiary_membership_id,$Igain_company_id,$Beneficiary_name);
		return $Check_user;
	}
	public function Check_beneficiary_customer_membershipid($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name)
	{		
		$Check_user_membershipID= $this->CI->Beneficiary_model->Check_beneficiary_customer_membershipid($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name);
		return $Check_user_membershipID;
	}
	public function Check_beneficiary_customer_name($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name)
	{		
		$Check_user_name= $this->CI->Beneficiary_model->Check_beneficiary_customer_name($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name);
		return $Check_user_name;
	}	
	public function insert_Beneficairy($Company_id,$Card_id,$Enrollement_id,$Beneficiary_Company_id,$Beneficiary_Name,$Beneficiary_Identifier)
	{		
		
		$post_data['Company_id']=$Company_id;
		$post_data['Membership_id']=$Card_id;
		$post_data['Enrollment_id']=$Enrollement_id;
		$post_data['Beneficiary_company_id']=$Beneficiary_Company_id;
		$post_data['Beneficiary_name']=$Beneficiary_Name;
		$post_data['Beneficiary_membership_id']=$Beneficiary_Identifier;
		$post_data['Create_date']=date('Y-m-d H:i:s');
		$post_data['Active_flag']=1;
		$post_data['Beneficiary_status']=1;
		$Insert_beneficiary= $this->CI->Beneficiary_model->insert_Beneficairy($post_data);
		return $Insert_beneficiary;
	}
	public function get_customer_details($Membership_id,$Igain_company_id)
	{		
		$Check_user_name= $this->CI->Igain_model->get_customer_details($Membership_id,$Igain_company_id);
		return $Check_user_name;
	}
	public function Get_Beneficiary_Company($Company_id)
	{		
		$Beneficiary_Company= $this->CI->Igain_model->Get_Beneficiary_Company($Company_id);
		return $Beneficiary_Company;
	}
	public function Insert_transfer_transaction($Company_id,$Beneficiary_Transfer_Points,$Enrollement_id,$Card_id,$Beneficiary_company_id,$Beneficiary_Company_name,$Beneficiary_cust_name,$Beneficiary_Identifier)
	{		
		$Transfer_PTS = array(					
			'Company_id' => $Company_id,
			'Trans_type' => '21',
			'Transfer_points' => $Beneficiary_Transfer_Points,        
			'Remarks' => 'Beneficiary Transfer Points',       
			'Trans_date' => date("Y-m-d H:i:s"),
			'Enrollement_id' => $Enrollement_id,
			'Card_id' => $Card_id,
			'Beneficiary_company_id' => $Beneficiary_company_id,
			'Beneficiary_company_name' => $Beneficiary_Company_name,
			'Beneficiary_cust_name' => $Beneficiary_cust_name,
			'Card_id2' => $Beneficiary_Identifier
			);
		
		$result= $this->CI->Igain_model->Insert_transfer_transaction($Transfer_PTS);
		return $result;
	}
	public function Update_member_balance($Company_id,$Enrollment_id,$New_login_curr_balance)
	{		
		$Get_Beneficiary_Company= $this->CI->Igain_model->Update_member_balance($Company_id,$Enrollment_id,$New_login_curr_balance);
		return $Get_Beneficiary_Company;
	}
	public function get_company_details($Company_id)
	{		
		$Company_details= $this->CI->Igain_model->get_company_details($Company_id);
		return $Company_details;
	}
	public function insert_transction_benrficiary($Company_id,$Igain_company_id,$Currency_to_Points,$Beneficiary_Identifier,$Beneficiary_Enrollement_id,$Enrollment_id,$Membership_id,$Member_Current_balance,$Customer_name,$Beneficiary_Transfer_Points)
	{		
		$Super_Seller_details=$this->CI->Igain_model->Fetch_Super_Seller_details($Igain_company_id);
		$seller_id=$Super_Seller_details->Enrollement_id;
		$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
		$top_db2 = $Super_Seller_details->Topup_Bill_no;
		$len2 = strlen($top_db2);
		$str2 = substr($top_db2,0,5);
		$tp_bill2 = substr($top_db2,5,$len2);						
		$topup_BillNo2 = $tp_bill2 + 1;
		$billno_withyear_ref = $str2.$topup_BillNo2;
		
		$post_data = array(					
			'Trans_type' => '1',
			'Company_id' => $Igain_company_id,
			'Topup_amount' => $Currency_to_Points,        
			'Trans_date' => date('Y-m-d H:i:s'),       
			'Remarks' => 'Get by Transfer Points',
			'Card_id' => $Beneficiary_Identifier,
			'Enrollement_id' => $Beneficiary_Enrollement_id,
			'Enrollement_id2' => $Enrollment_id,
			'Card_id2' => $Membership_id,
			'Seller' => $seller_id,
			'Bill_no' => $tp_bill2
		);
		// var_dump($post_data);
		$result45 = $this->CI->Igain_model->insert_transction($post_data);
		$result7 = $this->CI->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
		
		$New_member_curr_balance=$Member_Current_balance + $Currency_to_Points;
		$result2 = $this->CI->Igain_model->Update_member_balance($Igain_company_id,$Beneficiary_Enrollement_id,$New_member_curr_balance);
		
		
		$Email_content12=array(							
			'Notification_type' =>'You have Received Beneficiary Points from ',
			'Received_from' =>$Customer_name,
			'Received_points' =>$Currency_to_Points,
			'Template_type' => 'Get_transfer_points'
						
			);	
		$this->CI->send_notification->send_Notification_email($Beneficiary_Enrollement_id,$Email_content12,'0',$Igain_company_id);
			
			
		$Email_content=array(							
						'Notification_type' =>'You have Beneficiary Transferred Points ',
						'Transferred_to' =>$Beneficiary_Identifier,
						'Transferred_points' =>$Beneficiary_Transfer_Points,
						'Template_type' => 'Transfer_points'
									
						);	
		$this->CI->send_notification->send_Notification_email($Enrollment_id,$Email_content,'0',$Company_id);
		return $result45;
	}
	public function get_all_items($Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender)
	{		
		$Item_details= $this->CI->Redemption_Model->get_all_items('','',$Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender);
		return $Item_details;
	}
	public function get_items_branches($Company_merchandize_item_code,$Company_id)
	{		
		$Company_details= $this->CI->Redemption_Model->get_all_items_branches($Company_merchandize_item_code,$Company_id);
		return $Company_details;
	}
	public function get_cart($Enrollment_id)
	{		
		$Cart_details= $this->CI->Redemption_Model->get_total_redeeem_points($Enrollment_id);
		return $Cart_details;
	}
	public function get_delivery_item($Company_id,$Company_merchandize_item_code,$Redemption_method)
	{		
		$getDelivery_item=  $this->CI->Igain_model->get_delivery_item($Company_id,$Company_merchandize_item_code,$Redemption_method);
		return $getDelivery_item;
	}
	public function get_item_branch($Company_id,$Company_merchandize_item_code)
	{		
		$getDelivery_item=  $this->CI->Igain_model->get_item_branch($Company_id,$Company_merchandize_item_code);
		return $getDelivery_item;
	}	
	public function Insert_into_cart($Company_merchandize_item_code,$Delivery_method,$Branch,$Points,$Company_id,$Enrollement_id,$Size)
	{		
		$insert_data = array(
			'Item_code' => $Company_merchandize_item_code,
			'Redemption_method' => $Delivery_method,
			'Branch' => $Branch,
			'Points' => $Points,
			'Company_id' => $Company_id,
			'Enrollment_id' => $Enrollement_id,
			'Size' => $Size
		);	
		
		$result = $this->CI->Redemption_Model->insert_item_catalogue($insert_data);
		return $result;
		
	}
	
	public function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{		
		$ItemDetails=  $this->CI->Redemption_Model->Get_Merchandize_Item_details($Company_merchandise_item_id);
		return $ItemDetails;
	}
	public function delete_item_catalogue($Item_code,$Enrollement_id,$Company_id,$Branch,$Size,$Delivery_Method)
	{		
		$ItemDelete=  $this->CI->Redemption_Model->delete_item_catalogue($Item_code,$Enrollement_id,$Company_id,$Branch,$Size,$Delivery_Method);
		return $ItemDelete;
	}
	// public function Insert_Redeem_Items_at_Transaction($Company_merchandize_item_code,$Delivery_method,$Branch,$Points,$Company_id,$Enrollement_id,$Size)
	
	public function Insert_Redeem_Items_at_Transaction($Company_id,$Total_points,$Quantity,$Seller_id,$Seller_name,$Enrollement_id,$Card_Id,$Item_code,$Partner_id,$Branch,$item_size,$Voucher_no)
	{		
		$todays=date('Y-m-d');
		
		
		$Voucher_status="30";
		$insert_data = array(
		'Company_id' => $Company_id,
		'Trans_type' => 10,
		'Redeem_points' => $Total_points,
		'Quantity' => $Quantity,
		'Trans_date' => $todays,
		'Remarks' => 'Redeem Merchandize Gift-API',
		'Seller' => $Seller_id,
		'Seller_name' => $Seller_name,
		'Create_user_id' => $Enrollement_id,
		'Enrollement_id' => $Enrollement_id,
		'Card_id' => $Card_Id,
		'Item_code' => $Item_code,
		'Voucher_no' => $Voucher_no,
		'Voucher_status' => $Voucher_status,
		'Delivery_method' => 28,
		'Merchandize_Partner_id' => $Partner_id,
		'Merchandize_Partner_branch' => $Branch,
		'Item_size' => $item_size
		);
		$Insert = $this->CI->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
		 // $Current_balance=($Current_balance-$Catalogue["Total_points"]);	 
		 
		$Enroll_details = $this->CI->Igain_model->get_enrollment_details($Enrollement_id);
		$Current_balance=$Enroll_details->Current_balance;
		$Total_reddems11=$Enroll_details->Total_reddems;
		// echo"---Current_balance---".$Current_balance."---<br>";
		// echo"---Total_points---".$Total_points."---<br>";
		// echo"---Total_reddems11---".$Total_reddems11."---<br>";
		$lv_Total_reddems=$Total_reddems11+$Total_points;
		$Aval_Current_balance=$Current_balance-$Total_points;
		// echo"---Aval_Current_balance---".$Aval_Current_balance."---<br>";
		// $lv_Blocked_points=$Enroll_details->Blocked_points;
		// $Avialable_balance=($Current_balance-$lv_Blocked_points);
		$Update = $this->CI->Redemption_Model->Update_Customer_Balance($Aval_Current_balance,$lv_Total_reddems,$Enrollement_id);
				 
		return $Insert;
		
	}
	public function Send_redemption_notification($Company_id,$Notification_array,$Enrollement_id)
	{	
		$Company_details = $this->CI->Igain_model->get_company_details($Company_id);
		
		$Enroll_details = $this->CI->Igain_model->get_enrollment_details($Enrollement_id);
		$Full_name=$Enroll_details->First_name.' '.$Enroll_details->Last_name;
		
		$Current_balance=$Enroll_details->Current_balance;
		$Blocked_points=$Enroll_details->Blocked_points;
		$Avialable_balance=$Current_balance-$Blocked_points;
		$lv_date_time=date('Y-m-d');		
		
			$banner_image=$this->CI->config->item('base_url2').'images/redemption.jpg';				
			$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_details->Company_name;
			
			// echo"---subject----".$subject;
			
			$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
			$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>';

			$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';
					
			$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
				<tr>
					<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
					<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
				</tr>
				
				<tr>
					<td vAlign=top>
						<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
							<tr>
								<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 10px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
															<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																<tr>
																	<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																		<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=580 height=200 hspace="0" vspace="0">
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table> 
												
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
													Dear '.$Full_name.' ,
												</P>';

												$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													 Thank You for Redeeming  Item(s)  from our Merchandize Catalogue. Please find below the details of your transaction. <br><br>
													 <strong>Redemption Date:</strong> '.$lv_date_time. '<br><br>
												</P>									
									<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Sr.No.</b>
									</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
									<b>Merchandize item name</b>
									</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Item size</b>
									</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
									<b>Total Redeem Points</b>
									</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
									<b>Quantity</b>
									</TH>		
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Voucher No.</b>
									</TH>	
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Partner Branch Name</b>
									</TH>	
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Address</b>
									</TH>	
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
								<b>Merchant Name</b>
								</TH>			
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
									<b>Status</b>
								</TH>';
												
											$i=0;		
											foreach($Notification_array as $item)
											{																
												$Grand_Total_Redeem_points2[]=$item["Total_points"];
												
												/* if($item["item_size"] == 0)
												{
													$itemSize ="-";
												}
												elseif($item["Size"] == 1)
												{
													$itemSize ="Small";
												}
												elseif($item["Size"] == 2)
												{
													$itemSize ="Medium";
												}
												elseif($item["Size"] == 3)
												{
													$itemSize ="Large";
												}
												elseif($item["Size"] == 4)
												{
													$itemSize ="Extra Large";
												} */
												
												if($item["Merchant_name"] != "")
												{
													$Merchant_name = $item["Merchant_name"];		
												}
												else
												{
													$Merchant_name = "-";
												}												
												$html .= '<TR>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.($i+1).')
															</TD>
													
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.$item["Merchandize_item_name"].'
															</TD>
															
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.$item["itemSize"].'
														</TD>	
													
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															'.$item["Total_points"].'
														</TD>
															
													
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Quantity"].'
														</TD>
												
														
													<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Voucher_no"].'
														</TD>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Branch_name"].'
														</TD>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Address"].'
														</TD>
														
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Merchant_name.'
														</TD>
														
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															Issued
														</TD>
														</TR>										
													';
												$i++;
											}
											
												$html .='</TABLE><br>
												<TABLE style="border: #dbdbdb 1px solid; WIDTH: 40%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=left>
												
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Grand Total Points</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.array_sum($Grand_Total_Redeem_points2).'
														</TD>
													</TR>
																						
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Current Points Balance</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Avialable_balance.'
														</TD>
													</TR>
													</TABLE>';
												$html .= '<br><br><br>
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													Regards,
													<br>Loyalty Team.
												</P>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<td style="BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 20px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													<STRONG>You can also visit the below link using your login credentials and check details.</STRONG> Visit
													<span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
														<a style="color:#C7702E" title="Member Website" href='. $Company_details->Website .' target="_blank">Member Website</a>
													</span>
												</P>';										
												if( $Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") 
												{ 
													$html .= '<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 25px; mso-line-height-rule: exactly" align=center>
															You can also download Android & iOS App
													</P>';
												} 
											$html .= '</td>
										</tr>
									</table>
								</td>
							</tr>';					
					if($Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") 
					{			
							$html.='<tr>
							<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
							<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
							<tr style="HEIGHT: 10px">
							<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';							
							 if( $Company_details->Cust_apk_link != "" && $Company_details->Cust_ios_link != ""){ $app_table_width = "WIDTH: 49%;"; }else{ $app_table_width = "WIDTH: 100%;"; }					
								if($Company_details->Cust_apk_link != "") 
								{ 
								
									$html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
											<tr>
												<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 40px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
														<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
														<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
														<tr>
														<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 100px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
															<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
															<tr>
																	<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																	<a href="'.$Company_details->Cust_apk_link.'" title="Google Play" target="_blank">
																		<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->CI->config->item('base_url2').'images/Gooogle_Play.png" width=64 height=64 hspace="0" vspace="0">
																	</a>
																	</td>
																</tr>
															</table>
														</td>
														</tr>
														</table> 
														</DIV>
												</td>
											</tr>
									</table> ';                                                                       
								} 
								if($Company_details->Cust_ios_link != "") 
								{ 
								
									$html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
											<tr>
											<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 120px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
											<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
											<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
												<tr>
												<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
														<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																<tr>
																	<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																		<a href="'.$Company_details->Cust_ios_link.'" title="iOS App" target="_blank">
																			<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->CI->config->item('base_url2').'images/iOs_app_store.png" width=64 height=64 hspace="0" vspace="0">
																		</a>
																	</td>
																</tr>
														</table>
												</td>
												</tr>
											</table> 
											</DIV>
											</td>
											</tr>
									</table>';
								}
							$html.='</td>
							</tr>
						</table>
						</td>
						</tr>';						
					}				
							$html .= '<tr>
								<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 20px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly" align=left>
													<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
													If you are not the intended recipient or responsible for delivery to the intended recipient,
													you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
													Thank you for your cooperation.</em>
												</P>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>			
				<tr>
					<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
				</tr>
			</table>	
			</table>
			</body>
			</html>
			<style>
			td, th{
			font-size: 13px !IMPORTANT;
			}
			</style>';
			
							// echo "<br>".$html;	
						//'Active_flag' =>1
						
					$Email_content = array(
						'Redemption_details' => $html,
						'subject' => $subject,
						'Notification_type' => 'Redemption',
						'Template_type' => 'Redemption'
					);
					
		$Notification=$this->CI->send_notification->send_Notification_email($Enrollement_id,$Email_content,'0',$Company_id);
				
				 
		return $Notification;
		
	}
	
	
}
?>

