<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_notification 
{
    public function __construct() 
    {
		$this->CI = &get_instance();
		$this->CI->load->model('Igain_model');
		$this->CI->load->library('cart');
		$this->CI->load->model('shopping/Shopping_model');
		$this->CI->load->helper(array('form', 'url','encryption_val'));	
    }    
    public function send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id)
    {
        $Template_type = $Email_content['Template_type'];
        $company_details = $this->CI->Igain_model->get_company_details($Company_id);
        $seller_details = $this->CI->Igain_model->get_enrollment_details($Seller_id);
        $customer_details = $this->CI->Igain_model->get_enrollment_details($Enrollment_id);
        $Member_website = $company_details->Cust_website;
		$Company_Currency = $company_details->Currency_name;
        $Date = date("Y-m-d");
        $Enrollement_id = $customer_details->Enrollement_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
		$User_email_id_cont = $customer_details->User_email_id;
        $customer_notification = false;
		$Cust_apk_link = $company_details->Cust_apk_link;
		$Cust_ios_link = $company_details->Cust_ios_link;                
		$Company_name = $company_details->Company_name;                
		$Base_url = base_url();	
		$Base_url2=$this->CI->config->item('base_url2');
		$Gooogle_Play=$Base_url2.'images/Gooogle_Play.png';
		$iOs_app_store=$Base_url2.'images/iOs_app_store.png';				
		$User_id = $customer_details->User_id;
		$Phone_no = App_string_decrypt($customer_details->Phone_no);
		$User_pwd = App_string_decrypt($customer_details->User_pwd);
		$pinno = $customer_details->pinno;
		$Membership_ID = $customer_details->Card_id;		
		$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;

		$Current_balance = $customer_details->Current_balance;
		$Blocked_points=$customer_details->Blocked_points;
		$Debit_points=$customer_details->Debit_points;
		$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
		
		if($Current_point_balance<0)
		{
			$Current_point_balance=0;
		}
		else
		{
			$Current_point_balance=$Current_point_balance;
		}		
		if($Template_type == "Joining_Bonus")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			$Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			$subject = "Complimentary Bonus Points Issued from ".$company_details->Company_name;			
						
			ob_start();			    
			include './application/libraries/Email_templates/Joining_Bonus.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			
						
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Merchant_name','$Membership_ID','$Joining_bonus_points','$Transaction_date','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Merchant_name,$customer_details->Card_id,$Email_content['Joining_bonus_points'],$Transaction_date,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Enroll")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			// $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			// $subject = "Referral Bonus Issued from ".$company_details->Company_name;			
						
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$User_id = $customer_details->User_id;
			$User_email_id = App_string_decrypt($customer_details->User_email_id);
			$Phone_no = App_string_decrypt($customer_details->Phone_no);
			$User_pwd = App_string_decrypt($customer_details->User_pwd);
			$pinno = $customer_details->pinno;
			$Membership_ID = $customer_details->Card_id;
			$Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			
						
			$subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Enroll.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Merchant_name','$Membership_ID','$Enrolled_under','$User_email_id','$Phone_no','$User_pwd','$pinno','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Merchant_name,$Membership_ID,$Email_content['Enrolled_under'],$User_email_id,$Phone_no,$User_pwd,$pinno,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			
        }		
		if($Template_type == "Change_pin" || $Template_type == "Send_pin"  )
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			// $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			// $subject = "Referral Bonus Issued from ".$company_details->Company_name;			
						
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$User_id = $customer_details->User_id;
			$User_email_id = App_string_decrypt($customer_details->User_email_id);
			$Phone_no = App_string_decrypt($customer_details->Phone_no);
			$User_pwd = App_string_decrypt($customer_details->User_pwd);
			$pinno = $customer_details->pinno;
			$Membership_ID = $customer_details->Card_id;
			// $Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			
						
			$subject = "Your Request for Pin in Loyalty Application";		    
			include './application/libraries/Email_templates/Change_send_pin.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Membership_ID','$User_email_id','$Phone_no','$User_pwd','$pinno','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Membership_ID,$User_email_id,$Phone_no,$User_pwd,$pinno,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
        }
		if($Template_type == "Change_password")
        {
		
			// echo"----Email_content-----<br>";
			// var_dump($Email_content);
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			// $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			// $subject = "Referral Bonus Issued from ".$company_details->Company_name;			
			
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$User_id = $customer_details->User_id;
			$User_email_id = App_string_decrypt($customer_details->User_email_id);
			$Phone_no = App_string_decrypt($customer_details->Phone_no);
			$User_pwd = App_string_decrypt($customer_details->User_pwd);
			$pinno = $customer_details->pinno;
			$Membership_ID = $customer_details->Card_id;
			// $Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			
						
			$subject = "Your Login Credentials in ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Change_password.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Membership_ID','$User_email_id','$Phone_no','$User_pwd','$pinno','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Membership_ID,$User_email_id,$Phone_no,$User_pwd,$pinno,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			
        }
		if($Template_type == "Forgot_password")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$User_id = $customer_details->User_id;
			$User_email_id = App_string_decrypt($customer_details->User_email_id);
			$Phone_no = App_string_decrypt($customer_details->Phone_no);
			$User_pwd = App_string_decrypt($customer_details->User_pwd);
			$pinno = $customer_details->pinno;
			$Membership_ID = $customer_details->Card_id;
						
			$subject = "Your Login Credentials in ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Forgot_password.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Membership_ID','$User_email_id','$Phone_no','$User_pwd','$pinno','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Membership_ID,$User_email_id,$Phone_no,$User_pwd,$pinno,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Promo_code")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];			
			
			ob_start();	
						
			$subject = "Thank You for using Promo Code";	    
			include './application/libraries/Email_templates/Promo_code.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Promo_code','$PromocodePoints','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Promo_code'],$Email_content['PromocodePoints'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "No_longer_bider")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];				
			ob_start();							
			$subject = "You are No Longer the Highest Bidder of ".$Email_content['Auction_name'].".";	    
			include './application/libraries/Email_templates/No_longer_bider.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Auction_name','$Min_Bid_Value','$Bid_value_1','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Auction_name'],$Email_content['Min_Bid_Value'],round($Email_content['Bid_value_1']),$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Beneficiary_Transfer_points")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];	
			$From_company = $Email_content['From_company'];				
			$To_company = $Email_content['To_company'];	
			
			$From_member = $Email_content['From_member'];			
			$Get_points = $Email_content['Transferred_to_points'];			
			// $Notification_description = $Email_content['Notification_description'];				
			ob_start();							
			$subject ="You have Transferred Points to '".$Email_content['Transferred_to']." ' ";	    
			include './application/libraries/Email_templates/Beneficiary_Transfer_points.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transferred_to','$Transferred_points','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$From_company','$To_company','$Get_points','$From_member','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Transferred_to'],$Email_content['Transferred_points'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$From_company,$To_company,$Get_points,$From_member,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Transfer_points")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];				
			// $Notification_description = $Email_content['Notification_description'];				
			ob_start();							
			$subject ="You have Transferred Points to '".$Email_content['Transferred_to']." ' ";	    
			include './application/libraries/Email_templates/Transfer_points.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transferred_to','$Transferred_points','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Transferred_to'],$Email_content['Transferred_points'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Get_transfer_points_beneficiary")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];				
			$From_company = $Email_content['From_company'];				
			ob_start();							
			$subject = " You have Received Points from ".$Email_content['Received_from'];	    
			include './application/libraries/Email_templates/Get_transfer_points_beneficiary.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Received_points','$Received_from','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$From_company','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Received_points'],$Email_content['Received_from'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$From_company,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Get_transfer_points")
        {
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];				
			$From_company = $Email_content['From_company'];				
			ob_start();							
			$subject = " You have Received Points from ".$Email_content['Received_from'];	    
			include './application/libraries/Email_templates/Get_transfer_points.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Received_points','$Received_from','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$From_company','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Received_points'],$Email_content['Received_from'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$From_company,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Survey_rewards")
        {
			$Communication_id=0;
			$Offer = $Email_content['Notification_type'];			
			$subject = "Survey Bonus Points Issued from ".$company_details->Company_name;				
			ob_start();								    
			include './application/libraries/Email_templates/Survey_rewards.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Survey_name','$SurveyRewardsPoints','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content['Survey_name'],$Email_content['SurveyRewardsPoints'],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Contactus")
        {
			
			$Communication_id = 0;			
			if($Email_content['Notification_type']=='1')
			{
				$Email_content['Notification_type']='Feedback';
			}
			else if($Email_content['Notification_type']=='2')
			{
				$Email_content['Notification_type']='Request';
			}
			else
			{
				$Email_content['Notification_type']='Suggestion';
			}
			$Offer = $Email_content['Notification_type'];
			$subject = " New Message from ".$Customer_name;				
			ob_start();								    
			include './application/libraries/Email_templates/Contactus.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Company_primary_contact_person','$Offer','$Notification_description','$Membership_ID','$Phone_no','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$company_details->Company_primary_contact_person,$Offer,$Email_content['Notification_description'],$Membership_ID,$Phone_no,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		}
		if($Template_type == "Contactus_feedback")
        {
			
			$Communication_id = 0;			
			if($Email_content['Notification_type']=='1')
			{
				$Email_content['Notification_type']='Feedback';
			}
			else if($Email_content['Notification_type']=='2')
			{
				$Email_content['Notification_type']='Request';
			}
			else
			{
				$Email_content['Notification_type']='Suggestion';
			}
			$Offer = $Email_content['Notification_type'];
			$subject = 'Thank You for your Feedback';			
			ob_start();								    
			include './application/libraries/Email_templates/Contactus_feedback.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Company_primary_contact_person','$Offer','$Notification_description','$Membership_ID','$Phone_no','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$company_details->Company_primary_contact_person,$Offer,$Email_content['Notification_description'],$Membership_ID,$Phone_no,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/			
		}
		if($Template_type == "Freebies" || $Template_type == "Enroll_Freebies")//Delhi
        {
			$Communication_id = $Email_content["Company_merchandize_item_code"];
			 // echo"----Freebies-----<br>";
			$Offer = $Email_content['Notification_type'];
			$Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			$subject = "Congratulations !!! You have recieved free voucher from ".$company_details->Company_name;			
			
			// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
					
						
			// $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Freebies.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Merchandize_item_name','$Voucher_no','$Voucher_status','$Transaction_date','$Item_image','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Email_content["Merchandize_item_name"],$Email_content["Voucher_no"],$Email_content["Voucher_status"],$Transaction_date,$Email_content["Item_image"],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			
        }
		if($Template_type == "Profile_completion_bonus")//Profile_completion_bonus
        {
			$Communication_id = 0;
			 // echo"----Freebies-----<br>";
			$Offer = $Email_content['Notification_type'];
			$Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			$subject = "Congratulations !!! You have extra reward points from ".$company_details->Company_name;			
			
			// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
					
						
			// $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Profile_completion_bonus.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Profile_bonus','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content["Profile_bonus"],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			// echo $html;
			
        }
		if($Template_type == "App_login_reward")//App_login_reward
        {
			$Communication_id = 0;
			 // echo"----Freebies-----<br>";
			$Offer = $Email_content['Notification_type'];
			$Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
			$subject = "Congratulations !!! You have extra reward points from ".$company_details->Company_name;			
			
			// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
					
						
			// $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/App_login_reward.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Login_bonus','$Current_balance','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Email_content["Login_bonus"],$Current_point_balance,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			//echo $html;
			
        }
		/*----------------------------Shopping Order Confirmation Email---------------------------*/
		if($Template_type == "Shopping_order_confirm")
		{ 
			// var_dump($Email_content['Order_details2']);
			$Communication_id = 0;;
			$Offer = $Email_content['Notification_type'];
			
			$subject = "Your Order confirmation for #".$Email_content['Order_no'];		
			$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
			$html .= '<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">';		
			$html .= '<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0"><tr><td>';		
			$html .= '<table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px;">';
			$html .= '<tr>
						<td class="innerpadding borderbottom" style="padding: 0;border-bottom: 1px solid #f2eeed;">
						  <img class="fix" src="'.$this->CI->config->item('base_url2').'images/email_banner2.png" width="100%" border="0" alt="" />
						</td>
					  </tr>';
			$html .= '<tr><td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
							<td class="h2" style="padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;color: #153643; font-family: Tahoma;">
								Dear  '.$customer_details->First_name.' '.$customer_details->Last_name.',
							</td></tr>
							<tr><td class="bodycopy" style="color: #153643; font-family: Tahoma;font-size: 12px; line-height: 22px;">
								Thank you for shopping. <br>
								Your Order No is : <b style="text-transform: uppercase;">#'.$Email_content['Order_no'].'</b>.<br>
								Received on: <b>'.$Email_content['Order_date'].'</b>
								<hr />
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; line-height: 22px;">';
					
					$sub_total = 0;
					foreach($Email_content['Order_details'] as $Order_details)
					{
						$sub_total = $sub_total + ($Order_details['Quantity'] * $Order_details['Unit_price']);
						
						$html .= '<tr>
									<td style="text-align: center;border-left:1px solid #153643;border-top:1px solid #153643;border-bottom:1px solid #153643;padding: 5px;">
										<img class="fix" src="'.$Order_details['Thumbnail_image1'].'" style="width: 35%; margin: 0px auto;" />
									</td>
									<td style="border-right:1px solid #153643;border-top:1px solid #153643;border-bottom:1px solid #153643;padding: 5px;">
										<p><b>'.$Order_details['Merchandize_item_name'].'<b></p>
										<p><b>Quantity : </b>'.$Order_details['Quantity'].'</p>
										<p><b>Price : </b>'.$Email_content['Symbol_of_currency'].' '.$Order_details['Unit_price'].'</p>
									</td>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>';
					}
					
								$html .= '</table>
								
								<hr />
								
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; line-height: 22px;">
								<caption>
									<h3 style="text-align: left; text-decoration: underline;">Shipping Details</h3>
								</caption>
								<tr>
									<td><b>Address : </b></td>
									<td>
										<p>'.$Email_content['Order_details2']->Cust_address.'</p>
									</td>
								</tr>
								<tr>
									<td><b>Mobile Number : </b></td>
									<td>
										<p>'.$Email_content['Order_details2']->Cust_phnno.'</p>
									</td>
								</tr>
								
								</table>
								
								<hr />
								
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; line-height: 22px;">
								<caption>
									<h3 style="text-align: left; text-decoration: underline;">Billing Details</h3>
								</caption>
								<tr>
									<td><b>Order subtotal : </b></td>
									<td>
										<p><b>'.$Email_content['Symbol_of_currency'].' '.$sub_total.'</b></p>
									</td>
								</tr>
								<tr>
									<td><b>Shipping and handling : </b></td>
									<td>
										<p><b>'.$Email_content['Symbol_of_currency'].' '.$Email_content['Order_details2']->Shipping_cost.'</b></p>
									</td>
								</tr>
								<tr>
									<td><b>Total : </b></td>
									<td>
										<p><b>'.$Email_content['Symbol_of_currency'].' '.$Email_content['Order_details2']->Purchase_amount.'</b></p>
									</td>
								</tr>
								
								</table>
								
							</td></tr>
						</table></td></tr>';
						
			$html .= '<tr><td class="innerpadding bodycopy" style="padding: 30px 30px 30px 30px;color: #153643; font-family: Tahoma;font-size: 10px; line-height: 18px;">
						<strong>DISCLAIMER:</strong> This e-mail message is proprietary to '.$company_details->Company_name.' 
						and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or 
						confidential information exempt from disclosure as per applicable law. 
						If you are not the intended recipient 
						or responsible for delivery to the intended recipient,
						you may not copy, deliver, distribute or print this message. The message and its 
						contents have been virus checked.
						but the recipients may conduct their own. '.$company_details->Company_name.' will not accept any claims
						for damages arising out of viruses.<br>
						Thank you for your cooperation.</td></tr>';		
			$html .= '<tr><td class="footer" bgcolor="#44525f" style="padding: 20px 30px 15px 30px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td align="center" class="footercopy" style="font-family: Tahoma; font-size: 14px; color: #ffffff;">
								You can also visit the below link using your login credentials and check details.
							</td></tr>
							<tr><td align="center" class="footercopy" style="font-family: Tahoma; font-size: 14px; color: #ffffff;">
								<a href="'.$Company_website.'" target="_blank" style="color: #ffffff; text-decoration: underline;">
									Customer Website Link
								</a>
							</td></tr>';
					
				if( $company_details->Cust_apk_link != "" || $company_details->Cust_ios_link != "")
				{
					$html .= '<tr><td align="center" class="footercopy" style="font-family: Tahoma; font-size: 14px; color: #ffffff;">
								You can also download Android & iOS App
							</td></tr>
							<tr><td align="center" style="padding: 20px 0 0 0;">
								<table border="0" cellspacing="0" cellpadding="0"><tr>';
									
								if($company_details->Cust_apk_link != "")
								{
									$html .= '<td width="37" style="text-align: center; padding: 0 10px 0 10px;">
										<a href="'.$company_details->Cust_apk_link.'" target="_blank" style="color: #ffffff; text-decoration: underline;">
											<img src="'.$this->CI->config->item('base_url2').'images/Gooogle_Play.png" width="37" height="37" alt="Facebook" border="0" />
										</a>
									</td>';
								}
								
								if($company_details->Cust_ios_link != "")
								{
									$html .= '<td width="37" style="text-align: center; padding: 0 10px 0 10px;">
										<a href="'.$company_details->Cust_ios_link.'" target="_blank" style="color: #ffffff; text-decoration: underline;">
											<img src="'.$this->CI->config->item('base_url2').'images/iOs_app_store.png" width="37" height="37" alt="Twitter" border="0" />
										</a>
									</td>';
								}	
							
								$html .= '</tr>
								</table></td></tr>';
				}
						
			$html .= '</table></td></tr>';		
			$html .= '</table></td></tr></table></body></html>';
		}
		/*----------------------------Shopping Order Confirmation Email---------------------------*/             
                
                
		/*----------------------------Shopping Order Confirmation Email---------------------------*/
        if($Template_type == "Purchase_order")
		{ 
                    $Communication_id = 0;
                    $Offer = $Email_content['Notification_type'];
                    $Transaction_date = $Email_content['Transaction_date'];
                    $Symbol_of_currency = $Email_content['Symbol_of_currency'];
                    $Orderno = $Email_content['Orderno'];
                    $Voucher_array = $Email_content['Voucher_array'];
                    $Voucher_status1 = $Email_content['Voucher_status'];
                    $Standard_charges = $Email_content['Standard_charges'];
                    $Company_Redemptionratio = $Email_content['Company_Redemptionratio'];
                    $Cost_Threshold_Limit = $Email_content['Cost_Threshold_Limit'];
                    $To_Country = $Email_content['To_Country'];
                    $To_State = $Email_content['To_State'];
                    $Shipping_charges_flag = $Email_content['Shipping_charges_flag'];
					
					if($Voucher_status1 == 18)
					{
					 $Voucher_status = "Ordered";
					}
                    $Cust_wish_redeem_point = $Email_content['Cust_wish_redeem_point'];
					if($Cust_wish_redeem_point=="")
					{
						$Cust_wish_redeem_point=0;
					}
                    $EquiRedeem = $Email_content['EquiRedeem'];
                    $grand_total = $Email_content['grand_total'];
                    $subtotal = $Email_content['subtotal'];
                    $total_loyalty_points = $Email_content['total_loyalty_points'];
                    $Update_Current_balance = $Email_content['Update_Current_balance'];
                    $Blocked_points = $Email_content['Blocked_points'];
                    $banner_image = $this->CI->config->item('base_url2').'images/transaction.png';	
                    // $subject = "Purchase Order of our ".$company_details->Company_name ;
                    $subject =$Offer;
                    $html = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
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
                            <table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de;" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
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
             Dear  '.$customer_details->First_name.' '.$customer_details->Last_name.',
             </P>';

            $html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
          
			Thank You for Purchasing Item(s) from our online Catalogue. Please find below the details of your transaction. <br><br>
			<strong>Order Date:</strong> '.$Transaction_date. '<br><br>
			<strong>Order No:</strong> '.$Orderno. '<br><br>

            </P>
			<div class="table-responsive">				
           <TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center>';


            $html .= '<TR>
                           <TD style="border: #dbdbdb 2px ;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Sr.No.</b>
                           </TD>
                           <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b> Product Name</b>
                           </TD>
                          
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Size</b>
                         </TD>
						  <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Quantity</b>
                          </TD>
                        
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>Total Price('.$Symbol_of_currency.')</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>Shipping Cost ('.$Symbol_of_currency.')</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>Merchant Name</b>
						</TD>
					
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Voucher No.</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b> Order Status</b>
						</TD>
                   </TR>';
                        $i=1;		
			if ($cart = $this->CI->cart->contents())
            {
                foreach ($cart as $item)
                {
                    $item_id = $item['id'];
                    $result = $this->CI->Shopping_model->Get_merchandize_item($item_id,$Company_id);
                    $Merchandize_item_name = $result->Merchandize_item_name;
                    $Purchase_amount=$item['qty'] * $item['price'];
                    $Balance_to_pay = round($grand_total * $Purchase_amount ) / $subtotal;
										
                    $Unit_price =  $item['price'];
																								
					if($item['options']['Item_size'] == 1)
					{
					  $size = "Small";
					}
					elseif($item['options']['Item_size'] == 2)
					{	
						$size = "Medium";
					}
					elseif($item['options']['Item_size'] == 3)
					{
						$size = "Large";
					}
					elseif($item['options']['Item_size'] == 4)
					{
						$size = "Extra Large";
					}
					else
					{
						$size = "-";
					}
					 /********Calculate Weighted Shipping Cost AMIT 12-12-2017************/
					   $Partner_state=$item["options"]["Partner_state"];
						$Partner_Country_id=$item["options"]["Partner_Country_id"];
						
						if($item["options"]["Redemption_method"]==29)
						{
							$Exist_Delivery_method=1;
							$Weight_in_KG=0;
							$Weight=0;
							foreach($cart as $rec) 
							{
								 // echo '<br>if('.$rec["options"]["Partner_state"].'=='.$Partner_state.')';
								
								if(($rec["options"]["Partner_state"]==$Partner_state) && ($rec["options"]["Redemption_method"]==29))
								{
									
									 //echo "<br><br><b>Item Weight </b>".$rec["options"]["Item_Weight"]."<b>  Quantity </b>".$rec["qty"]."<b>  Weight_unit_id </b>".$rec["options"]["Weight_unit_id"];
									// $Total_weight_same_location=$Weight+($rec["options"]["Item_Weight"]*$item["qty"]);
									
									$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
									
									// echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location;
									
									$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
									$kg=1;
									switch ($lv_Weight_unit_id)
									{
										case 2://gram
										$kg=0.001;break;
										case 3://pound
										$kg=0.45359237;break;
									}
									// $Total_weight_same_location=array_sum($Total_weight_same_location);
									$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
									  // echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id."<b>  Weight_in_KG </b>".$Weight_in_KG;
									  // $Weight=$Total_weight_same_location;
									  // $Weight=$Weight_in_KG;
								}
								
								
							}
							/*******Single Weight convert into KG****/

							$kg2=1;
							switch ($item["options"]["Weight_unit_id"])
							{
								case 2://gram
								$kg2=0.001;break;
								case 3://pound
								$kg2=0.45359237;break;
							}
							
							/**************************/
							
							$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);
							
						}
						else
						{
							$Total_Weighted_avg_shipping_cost[]=0;
							$Weighted_avg_shipping_cost="-";
						}
						
						if($Shipping_charges_flag==2)//Delivery_price
						{
							if($item["options"]["Redemption_method"]==29)
							{
								
								$Get_shipping_cost = $this->CI->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
								$Shipping_cost= $Get_shipping_cost->Delivery_price;
								
								$Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
								$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
								$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
									
							}
						}
						elseif($Shipping_charges_flag==1)//Standard Charges
						{
							if($item["options"]["Redemption_method"]==29)
							{
								$Cost_Threshold_Limit=round($Cost_Threshold_Limit*$Company_Redemptionratio);
								
								$Shipping_cost=round($Standard_charges*$Company_Redemptionratio);
								
								$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
								
								$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
							}
						}
						else
						{
							$Shipping_cost=0;
							$Weighted_avg_shipping_cost=0;
						}
					
					   /**Calculate Weighted Shipping Cost AMIT 12-12-2017***END******/
					   if($item["options"]['Merchant_flag'] ==1) 
						{
							$get_enrollment = $this->CI->Igain_model->get_enrollment_details($item["options"]['Seller_id']);
							$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
						}
						else
						{
							$merchant_name = "-";
						}
						
					$html .= '<TR>

							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=center> '.$i.')
																																				</TD>
                            <TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$Merchandize_item_name.'
																																				</TD>
																																			
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$size.'
                            </TD>
                                 	<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT:  4px;PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> '.$item['qty'].'
							</TD>                                                                                   
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Purchase_amount.'
							</TD>
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Weighted_avg_shipping_cost.'</TD>
							
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$merchant_name.'
							
							</TD>
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Voucher_array[$i-1].'
							</TD>
							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Voucher_status.'
                            </TD>
                          </TR>  ';
						$i++;
				}

		}
			$html .='</TABLE>
			
			</div>
			
			<br> <TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>

            <TR style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px">
				<TD colspan="2" align=left> 

				</TD>

			</TR>
			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 34px" align=left>                                                                  <b>Sub-Total</b>
					</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 34px" align=left> '.$Symbol_of_currency.' '.$subtotal.'
					</TD>
			</TR>
			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 34px"align=left>                                                                  <b>Total Shipping Cost</b>
					</TD>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 34px" align=left> '.$Symbol_of_currency.' '.$_SESSION["Total_Shipping_Cost"].'
					</TD>
			</TR>
			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>                                                                                    <b>Grand Total</b>
                    </TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Symbol_of_currency.' '.($_SESSION["Total_Shipping_Cost"]+$subtotal).'
					</TD>
			</TR>
			<TR>
                    <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
						<b>Redeemed '.$Company_Currency.' ('.$Cust_wish_redeem_point.' '.$Company_Currency.'.)</b>
                    </TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Symbol_of_currency.' '.$EquiRedeem.' (Eqv.) 
					</TD>
			</TR>
			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>                                                                                    <b>Net Total</b>
                    </TD>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Symbol_of_currency.' '.$grand_total.'
					</TD>
			</TR>

			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>                                                                                     <b>Gained '.$Company_Currency.'</b>
                    </TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$total_loyalty_points.' '.$Company_Currency.'
					</TD>
			</TR>

			<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>                                                                                    <b>Current Balance</b>
                    </TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$Current_point_balance.' '.$Company_Currency.'
					</TD>
			</TR>';
			 if($total_loyalty_points != 0 )
			 {
				$html .= '<TR>
					<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="2"> 																				<b>Note<span style="color:red"> * </span> : '.$total_loyalty_points.' Loyalty points gained will be credited in your loyalty balance when the item(s) gets delivered</b>					 	 </TD>                                                                                                                    
				</TR>';
			 }
			$html .= '</TABLE>';
        $html .= '<br>
			 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left> Regards,<br>Loyalty Team.
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
						<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=center>
						<STRONG>You can also visit the below link using your login credentials and check details.</STRONG> Visit
						<span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
							<a style="color:#C7702E" title="Member Website" href='. $company_details->Website .' target="_blank">Member Website</a>
					   </span>
						</P>
						</td>
					</tr>
					
					<tr style="HEIGHT: 20px">
						<td class="row" style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
						
										$html.=' <div class="table-responsive">';
										if( $company_details->Cust_apk_link != "" || $company_details->Cust_ios_link != "") 
										{ 
											$html .= '<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 20px; mso-line-height-rule: exactly" align="center">
													You can also download Android & iOS App
											</P>';					
										
										  $html.='	<table class="table" align="center" >
													<tbody align="center">
											  <tr>';
												if($company_details->Cust_apk_link != "") 
												{ 
													$html.='<td>
													
													<a href="'.$company_details->Cust_apk_link.'" title="Google Play" target="_blank">
													<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->CI->config->item('base_url2').'images/Gooogle_Play.png" width=64 height=64 hspace="0" vspace="0">
													</a>
													</td>';
												}
												if($company_details->Cust_ios_link != "") 
												{
													$html.='<td>
														
														<a href="'.$company_details->Cust_ios_link.'" title="iOS App" target="_blank">
														<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->CI->config->item('base_url2').'images/iOs_app_store.png" width=64 height=64 hspace="0" vspace="0">
														</a>
													</td>';
												}
												
										}	
										$html.='</tr>
										</tbody>
										</table>
										</div>';
									  
									  
									  $html.='
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
														<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
														If you are not the intended recipient or responsible for delivery to the intended recipient,
														you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
														Thank you for your cooperation.</em>
												</P>
											<br>';
								
						$html.='</td>
					</tr>
					
            
			</table>
           </td>
        </tr>';	

$html.='</table>
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
		
				
		
	}
			
		if($Template_type == "Purchase_Cancel")
		{
			$Communication_id = 0;	
			$Offer =$Email_content['Notification_type'];
			$Voucher_status1=$Email_content['Voucher_status'];
			if($Voucher_status1 == 21)
			{
				$Voucher_status="Cancel";
			}
			else
			{
				$Voucher_status= "";
			}
			$Transaction_date = date("d M Y",strtotime($Email_content['Trans_date']));
			$Todays_date=date("d M Y");
			// $subject ="Purchase Return";
			$subject =$Offer;
			
			
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
			include './application/libraries/Email_templates/Refund_Purchase_item_points.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Item_name','$Order_no','$Voucher_no','$Symbol_of_currency','$Purchase_amount','$Quantity','$Voucher_status','$Credit_points','$Balance_points','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Item_name'],$Email_content['Order_no'],$Email_content['Voucher_no'],$Email_content['Symbol_of_currency'],$Email_content['Purchase_amount'],$Email_content['Quantity'],$Voucher_status,$Email_content['Credit_points'],$Email_content['Balance_points'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
				//echo "<br>";
				//echo $html;
				//echo "<br>";
			/************************************Variable Replace Code******************************/
			
		}
		if($Template_type == "Purchase_item_return_initiated")
		{
			$Communication_id = 0;	
			$Offer = $Email_content['Notification_type'];	
			$Voucher_status1 =$Email_content['Voucher_status'];	
			if($Voucher_status1==22)
			{
				$Voucher_status="Return Initiated";
			}
			else
			{
				$Voucher_status="";
			}
			
			$Transaction_date = date("d M Y",strtotime($Email_content['Trans_date']));
			$Todays_date=date("d M Y");
			// $subject ="Purchase Return";
			$subject = $Offer;
			
			
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
			include './application/libraries/Email_templates/Purchase_item_return_initiated.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Item_name','$Voucher_no','$Order_no','$Symbol_of_currency','$Purchase_amount','$Redeem_points','$Quantity','$Voucher_status','$Notification_type','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Item_name'],$Email_content['Voucher_no'],$Email_content['Order_no'],$Email_content['Symbol_of_currency'],$Email_content['Purchase_amount'],$Email_content['Redeem_points'],$Email_content['Quantity'],$Voucher_status,$Email_content['Notification_type'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
				//echo "<br>";
				//echo $html;
				//echo "<br>";
			/************************************Variable Replace Code******************************/
			
		}
		if($Template_type == "Purchase_item_return_initiated_to_admin")
		{
			$Communication_id = 0;	
			$Offer =$Email_content['Notification_type'];			
			$Admin_email =$Email_content['admin_email'];	
			$Voucher_status1 =$Email_content['Voucher_status'];	
			if($Voucher_status1==22)
			{
				$Voucher_status = "Return Initiated";
			}
			else
			{
				$Voucher_status="";
			}			
			$Partner_contact_person_name =$Email_content['Partner_contact_person_name'];			 
			$Partner_contact_person_email =$Email_content['Partner_contact_person_email'];			 
			$Transaction_date = date("d M Y",strtotime($Email_content['Trans_date']));
			$Todays_date=date("d M Y");
			// $subject ="Purchase Return Initiated";
			$subject =$Offer;
			$Company_primary_contact_person=$company_details->Company_primary_contact_person;
			
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$Membership_ID = $customer_details->Card_id;			
			include './application/libraries/Email_templates/Purchase_item_return_initiated_to_admin.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Partner_contact_person_name','$Customer_name','$Membership_ID','$Transaction_date','$Todays_date','$Item_name','$Voucher_no','$Order_no','$Symbol_of_currency','$Purchase_amount','$Redeem_points','$Quantity','$Voucher_status','$Notification_type','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Partner_contact_person_name,$Customer_name,$Membership_ID,$Transaction_date,$Todays_date,$Email_content['Item_name'],$Email_content['Voucher_no'],$Email_content['Order_no'],$Email_content['Symbol_of_currency'],$Email_content['Purchase_amount'],$Email_content['Redeem_points'],$Email_content['Quantity'],$Voucher_status,$Email_content['Notification_type'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
				//echo "<br>";
				//echo $html;
				//echo "<br>";
			/************************************Variable Replace Code******************************/
			
		}
		if($Template_type == "Purchase_buyone_freeone")
		{
			$Communication_id = 0;	
			$Offer =$Email_content['Offer_name'];			
			$Transaction_date = date("d M Y",strtotime($Email_content['Transaction_date']));
			$Todays_date=date("d M Y");
			$subject =$Email_content['Offer_name'];
			
			// var_dump($Email_content);
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
			include './application/libraries/Email_templates/Purchase_buyone_freeone.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Offer_name','$Item_name','$Item_code','$Orderno','$Free_qty','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Offer_name'],$Email_content['Item_name'],$Email_content['Item_code'],$Email_content['Orderno'],$Email_content['Free_qty'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
		// echo "<br>";
		// echo $html; 
		// echo "<br>";
		// die;
		}
		/*----------------------------Shopping Order Confirmation Email---------------------------*/
		if($Template_type == "Redemption")
		{
			$Communication_id = 0;;
			$Offer = $Email_content['Notification_type'];
			$html = $Email_content['Redemption_details'];
			$subject = $Email_content['subject'];
		}
		if($Template_type == "Polling_ommunication")
        {
			$Date=date("Y-m-d");
			$Communication_id = $Email_content['Communication_id'];
			$Offer = $Email_content['Offer'];
			$html = $Email_content['Offer_description'];
			$subject = "Latest Communication from ".$Company_name;	
        }
		if($Template_type == "Call_Center_Query_Log")
        {
			$Communication_id = 0;	 
			$Offer = $Email_content['Notification_type'];			
			$Transaction_date = $Email_content['Today_date'];
			$Todays_date=date("Y-m-d");
			$subject =" Call Center Query Log  of our ".$company_details->Company_name ;
			
			
			ob_start();	
			$Customer_name =$Email_content['Cust_name'];	
			$Excecative_name =$Email_content['Excecative_name'];	
			$Querylog_ticket =$Email_content['Querylog_ticket'];	
			$Max_resolution_datetime =$Email_content['Max_resolution_datetime'];	
			$Excecative_email =$Email_content['Excecative_email'];	
			// $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
			include './application/libraries/Email_templates/Call_center_query_log.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Excecative_name','$Querylog_ticket','$Max_resolution_datetime','$Excecative_email','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');
				$inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Excecative_name,$Querylog_ticket,$Max_resolution_datetime,$Excecative_email,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			
		}
		if($Template_type == "Online_booking")// Online Service Booking 
        {
			
			$Communication_id = 0;
			 // echo"----Freebies-----<br>";
			$Offer = $Email_content['Notification_type'];
			$subject = " Your Service Appointment Booked Successfully. ";			
			$User_email_id=$Email_content["Email_Id"];
			// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
			$Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;
					
						
			// $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
			include './application/libraries/Email_templates/Online_booking_email.php';			
					
			$body = ob_get_contents();
			ob_end_clean();			
					
			$Pickup_flag=$Email_content["Pickup_flag"];
			if($Pickup_flag ==1 )
			{
				$Pickup_flag='Yes';
			}
			else
			{
				$Pickup_flag='No';
			}
			// echo"------Pickup_flag----".$Pickup_flag."---<br>";
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Service_center','$Create_date','$Appointment_time','$Pickup_flag','$Membership_ID','$Vehicle_no','$Phone_no','$Email_Id','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
				$inserts_contents = array($Email_content['Customer_name'],$Merchant_name,date('d-M-Y',strtotime($Email_content["Date_Appointment"])),$Email_content["Appointment_time"],$Pickup_flag,$Email_content["Membership_id"],$Email_content["Vehicle_number"],$Email_content["Contact_number"],$Email_content["Email_Id"],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
			// echo $html;
			
			
        }
		if($Template_type == "Redemption_Fulfillment")
        {
			$Communication_id = 0;	
			$Offer =$Email_content['Notification_type'];			
			$Transaction_date = date("d M Y",strtotime($Email_content['Trans_date']));
			$Todays_date=date("Y-m-d");
			$subject =" Redemption Fullfillment  of our ".$company_details->Company_name ;
			
			$base_url2=$this->CI->config->item('base_url2');
			ob_start();	
			$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
			include './application/libraries/Email_templates/Redemption_Fulfillment.php';			
					
			$body = ob_get_contents();
			ob_end_clean();				
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Merchandize_item_name','$evoucher','$Points','$Total_points','$Branch_name','$Branch_Address','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');//
				$inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Merchandize_item_name'],$Email_content['evoucher'],$Email_content['Points'],$Email_content['Total_points'],$Email_content['Branch_name'],$Email_content['Branch_Address'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
				// echo $html;
			/************************************Variable Replace Code******************************/
			
		}
		if($Template_type == "From_transfer_miles")
        { 
            $Communication_id = 0;
            $Offer = $Email_content['Notification_type'];	
            $From_company = $Email_content['From_company'];				
            $To_company = $Email_content['To_company'];	

            $From_member = $Email_content['From_member'];			
            $Get_points = $Email_content['Transferred_to_points'];			
            $User_email_id = $Email_content['From_user_email_address'];	
            
            if($Email_content['Status']=="Pending")
            {
               $color="#ff5722";

            } else if($Email_content['Status']=="Approved"){

               $color="#4caf50";    
               
            } else {

               $color="#f12b2b";
            }  
                    
            
            ob_start();							
            $subject =$Offer;	    
            include './application/libraries/Email_templates/From_transfer_miles.php';			

            $body = ob_get_contents();
            ob_end_clean();	

            /************************************Variable Replace Code******************************/
                   
                    $search_variables = array('$Customer_name','$From_publisher','$Transfer_miles','$Purchased_Currency','$To_Beneficiary_Currency','$From_publisher','$To_publisher','$From_Beneficiary_name','$To_Beneficiary_name','$To_Equivalent','$From_beneficiary_id','$To_Beneficiary_id','$Status','$color','$Trans_date','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');
                    $inserts_contents = array($Email_content['From_Beneficiary_name'],$Email_content['From_publisher'],$Email_content['Transfer_miles'],$Email_content['Purchased_Currency'],$Email_content['To_Beneficiary_Currency'],$Email_content['From_publisher'],$Email_content['To_publisher'],$Email_content['From_Beneficiary_name'],$Email_content['To_Beneficiary_name'],$Email_content['To_Equivalent'],$Email_content['From_beneficiary_id'],$Email_content['To_Beneficiary_id'],$Email_content['Status'],$color,$Email_content['Trans_date'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
                    $html = str_replace($search_variables,$inserts_contents,$body);
            /************************************Variable Replace Code******************************/
            //echo $html;
        }
		if($Template_type == "To_transfer_miles")
        { 
            $Communication_id = 0;
            $Offer = $Email_content['Notification_type'];	
            $From_company = $Email_content['From_company'];				
            $To_company = $Email_content['To_company'];	

            $From_member = $Email_content['From_member'];			
            $Get_points = $Email_content['Transferred_to_points'];			
            $User_email_id = $Email_content['From_user_email_address'];	
            
            if($Email_content['Status']=="Pending")
            {
               $color="#ff5722";

            } else if($Email_content['Status']=="Approved"){

               $color="#4caf50";    
               
            } else {

               $color="#f12b2b";
            }  
                    
            
            ob_start();							
            $subject =$Offer;	    
            include './application/libraries/Email_templates/To_transfer_miles.php';			

            $body = ob_get_contents();
            ob_end_clean();	

            /************************************Variable Replace Code******************************/
                   
                    $search_variables = array('$Customer_name','$From_publisher','$Transfer_miles','$Purchased_Currency','$To_Beneficiary_Currency','$From_publisher','$To_publisher','$From_Beneficiary_name','$To_Beneficiary_name','$To_Equivalent','$From_beneficiary_id','$To_Beneficiary_id','$Status','$color','$Trans_date','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');
                    $inserts_contents = array($Email_content['To_Beneficiary_name'],$Email_content['From_publisher'],$Email_content['Transfer_miles'],$Email_content['Purchased_Currency'],$Email_content['To_Beneficiary_Currency'],$Email_content['From_publisher'],$Email_content['To_publisher'],$Email_content['From_Beneficiary_name'],$Email_content['To_Beneficiary_name'],$Email_content['To_Equivalent'],$Email_content['From_beneficiary_id'],$Email_content['To_Beneficiary_id'],$Email_content['Status'],$color,$Email_content['Trans_date'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
                    $html = str_replace($search_variables,$inserts_contents,$body);
            /************************************Variable Replace Code******************************/
            //echo $html;
        }
		if($Template_type == "Transfer_miles_facilition")
        { 
            $Communication_id = 0;
            $Offer = $Email_content['Notification_type'];	
            $From_company = $Email_content['From_company'];				
            $To_company = $Email_content['To_company'];	

            $From_member = $Email_content['From_member'];			
            $Get_points = $Email_content['Transferred_to_points'];			
            
            
            if($Email_content['Status']=="Pending")
            {
               $color="#ff5722";

            } else if($Email_content['Status']=="Approved"){

               $color="#4caf50";    
               
            } else {

               $color="#f12b2b";
            }  
                    
            
            ob_start();							
            $subject =$Offer;	    
            include './application/libraries/Email_templates/Transfer_miles_facilition.php';			

            $body = ob_get_contents();
            ob_end_clean();	

            /************************************Variable Replace Code******************************/
                   
                    $search_variables = array('$Customer_name','$From_publisher','$Transfer_miles','$Purchased_Currency','$To_Beneficiary_Currency','$From_publisher','$To_publisher','$From_Beneficiary_name','$To_Beneficiary_name','$To_Equivalent','$From_beneficiary_id','$To_Beneficiary_id','$Status','$color','$Trans_date','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');
                    $inserts_contents = array($Email_content['To_Beneficiary_name'],$Email_content['From_publisher'],$Email_content['Transfer_miles'],$Email_content['Purchased_Currency'],$Email_content['To_Beneficiary_Currency'],$Email_content['From_publisher'],$Email_content['To_publisher'],$Email_content['From_Beneficiary_name'],$Email_content['To_Beneficiary_name'],$Email_content['To_Equivalent'],$Email_content['From_beneficiary_id'],$Email_content['To_Beneficiary_id'],$Email_content['Status'],$color,$Email_content['Trans_date'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
                    $html = str_replace($search_variables,$inserts_contents,$body);
            /************************************Variable Replace Code******************************/
            //echo $html;
        }
		if($Template_type == "Publisher_new_account")
        { 
            $Communication_id = 0;
            $Offer = $Email_content['Notification_type'];	
            $From_company = $Email_content['From_company'];				
            $To_company = $Email_content['To_company'];	

            $From_member = $Email_content['From_member'];			
            $Get_points = $Email_content['Transferred_to_points'];			
            
            
            if($Email_content['Status']=="Active"){

               $color="#4caf50";    
               
            } else {

               $color="#ff5722";
            }  
                    
            
            ob_start();							
            $subject =$Offer;	    
            include './application/libraries/Email_templates/Publisher_new_account.php';			

            $body = ob_get_contents();
            ob_end_clean();	

            /************************************Variable Replace Code******************************/                   
                    $search_variables = array('$Customer_name','$From_publisher','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');
                    $inserts_contents = array($Customer_name,$Email_content['From_publisher'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
                    $html = str_replace($search_variables,$inserts_contents,$body);
            /************************************Variable Replace Code******************************/
            
        }
		if($Template_type == "Purchase_miles")
        { 
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];	
			$From_company = $Email_content['From_company'];				
			$To_company = $Email_content['To_company'];	
			
			$From_member = $Email_content['From_member'];			
			$Get_points = $Email_content['Transferred_to_points'];			
			// $Notification_description = $Email_content['Notification_description'];				
			ob_start();							
			$subject =$Offer;	    
			include './application/libraries/Email_templates/Purchase_miles.php';			
					
			$body = ob_get_contents();
			ob_end_clean();	
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$From_publisher','$Purchased_miles','$Purchased_Currency','$Equivalent_joy_coins','$Status','$Trans_date','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency');
				$inserts_contents = array($Customer_name,$Email_content['From_publisher'],$Email_content['Purchased_miles'],$Email_content['Purchased_Currency'],$Email_content['Equivalent_joy_coins'],$Email_content['Status'],$Email_content['Trans_date'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
            // echo $html;
        }
		if($Template_type == "Evoucher_redemption")
        { 
			$Communication_id = 0;
			$Offer = $Email_content['Notification_type'];	
			$product_image = $Email_content['product_image'];					
			ob_start();							
			$subject =$subject =$Offer." of our ".$company_details->Company_name ; 	 
			$base_url2=$this->CI->config->item('base_url2');			
			
			$Voucher_no=$Email_content['Voucher_no'];
			
			include './application/libraries/Email_templates/Evoucher_redemption.php';			
					
			$body = ob_get_contents();
			ob_end_clean();
			
			
			
			// print_r($Voucher_no);
			
			/************************************Variable Replace Code******************************/
				$search_variables = array('$Customer_name','$Status','$Trans_date','$Voucher_name','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Company_Currency','$Total_points','$product_image','$Purchase_amount','$Quantity','$Symbol_of_currency','$Voucher_no','$Avialable_balance');
				$inserts_contents = array($Customer_name,$Email_content['Status'],$Email_content['Trans_date'],$Email_content['Voucher_name'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Company_Currency,$Email_content['Total_points'],$Email_content['product_image'],$Email_content['Purchase_amount'],$Email_content['Quantity'],$Email_content['Symbol_of_currency'],$Voucher_no,$Email_content['Avialable_balance']);
				$html = str_replace($search_variables,$inserts_contents,$body);
			/************************************Variable Replace Code******************************/
            // echo $html;
        }
        /*-------------------------Insert Notification-----------------------*/
		if($Enrollement_id != 0 && $customer_details->User_id == 1 && $Template_type != "Contactus" && $Template_type != "Purchase_item_return_initiated_to_admin")
		{
			$cust_notification = array(
					'Company_id' => $Company_id ,
					'Seller_id' => $Seller_id ,
					'Customer_id' => $Enrollement_id,
					'Communication_id' => $Communication_id ,
					'User_email_id' => $User_email_id,
					'Offer' => $Offer,
					'Offer_description' => $html,
					'Open_flag' => '0',
					'Date' => $Date,
					'Active_flag' =>1
			);
			// echo"----cust_notification-----<br>";
			// var_dump($cust_notification);
			$customer_notification = $this->CI->Igain_model->insert_customer_notification($cust_notification);
			if($Template_type == "Communication")
			{
				$new_html = str_replace("#User_notification_id",$customer_notification,$html);
				$post_data = array
				(					
					'Offer_description' => $new_html
				);
				$Update_customer_notification = $this->CI->Igain_model->update_customer_notification($customer_notification,$Company_id,$Enrollement_id,$post_data);
				$html = $new_html;
			}
		}
        /*-------------------------Insert Notification-----------------------*/
		
		if($Template_type == "Contactus")
		{
			$User_email_id  = $company_details->Company_contactus_email_id;
			$Company_primary_email_id= $User_email_id_cont;
		}
		else
		{
			$User_email_id  =$User_email_id; // $com;
			$Company_primary_email_id= $company_details->Company_primary_email_id;
			
		}
		
        //**************************Email Fuction Code*****************************
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'mail.miraclecartes.com';
            $config['smtp_user'] = 'rakeshadmin@miraclecartes.com';
            $config['smtp_pass'] = 'rakeshadmin@123';
            $config['smtp_port'] = 25;
            
            $config['mailtype'] = 'html';
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $this->CI->load->library('email', $config);
            $this->CI->email->initialize($config);
			// echo"---User_email_id-----".$User_email_id."--<br>";
			/* echo"---Template_type-----".$Template_type."--<br>";
			echo"---User_email_id-----".$User_email_id."--<br>";
			echo"---Partner_contact_person_email-----".$Partner_contact_person_email."--<br>";
			echo"---Admin_email-----".$Admin_email."--<br>";
			echo"---***********************************************--<br>"; */
			
			if($Template_type=="Purchase_item_return_initiated_to_admin")
			{						
				// echo"---Purchase_item_return_initiated_to_admin--<br>";
				$Company_primary_email_id=$company_details->Company_primary_email_id;
				$this->CI->email->from($User_email_id);
				$this->CI->email->to($Partner_contact_person_email); 
				$this->CI->email->cc($Admin_email);				
			}
			else
			{
				// echo"---Othera--<br>";
				$Company_primary_email_id=$company_details->Company_primary_email_id;
				$this->CI->email->from($Company_primary_email_id);
				$this->CI->email->to($User_email_id);
			}
			// echo"---Company_primary_email_id-----".$Company_primary_email_id."--<br>";
			// die;
			//if($company_details->Company_id==9 && ( $Template_type == "Freebies" || $Template_type == "Enroll" ) )
			//{
				//$this->CI->email->bcc('amitk@miraclecartes.com');
				//crhead@vw-worldclassauto.co.in
			//}			
            $this->CI->email->subject($subject);
            $this->CI->email->message($html); 			
			//if($Template_type != "Enroll_Freebies")
			//{
				if ( ! $this->CI->email->send())
				{
					return $customer_notification;
				}
				else
				{
					return $customer_notification;
				}
			//}
			
        //**************************Email Fuction Code*****************************/
    }
}

