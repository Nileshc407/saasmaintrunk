<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model 
{
	public function company_active_list($limit,$start)
	{
		$this->db->limit($limit,$start);
		$query = $this->db->where("Activated",1);
		$query = $this->db->order_by("Company_id",'desc');
		$query = $this->db->get("igain_company_master");

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
	public function company_inactive_list($limit,$start)
	{
		$this->db->limit($limit,$start);
		$this->db->where("Activated",'0');
		$query = $this->db->get("igain_company_master");
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false; 
		
	}   
	public function selected_company_list($limit,$start,$Company_id)
	{	   
		$this->db->select('*');
		$this->db->from('igain_company_master');
		$this->db->where(array('Company_id' =>$Company_id));
		$edit_sql = $this->db->get();						
		if ($edit_sql->num_rows() > 0)
		{
			foreach ($edit_sql->result() as $row)
			{
				if($row->Partner_company_flag== 1)
				{
					$this->db->select('*');
					$this->db->from('igain_company_master');
					$this->db->where(array('Parent_company' =>$row->Company_id));
					$edit_sql = $this->db->get();	
					foreach ($edit_sql->result() as $row1)
					{
						$data[] = $row1;
					}
				}
				$data[] = $row;
			}
			return $data;
		}
		return false;	
	}	
	public function company_active_count()
	{
		/*  $query = $this->db->where("Activated",'1');
		return $this->db->count_all("igain_company_master");  */
		 $this->db->select("COUNT(*)");
		$this->db->where('Activated', 1);
		 $query = $this->db->get('igain_company_master');
		 $result = $query->row_array();
		return	$count2 = $result['COUNT(*)']; 
	}
	public function company_inactive_count()
	{
		/* $query = $this->db->where("Activated",'0');
		return $this->db->count_all("igain_company_master"); */
		 $this->db->select("COUNT(*)");
		$this->db->where('Activated', 0);
		 $query = $this->db->get('igain_company_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)']; 	
	}	
	function insert_company($filepath_logo,$filepath_white_label,$Partner_company_flag,$Parent_company,$Create_user_id)
    {	
		$data['Company_name'] = $this->input->post('cname');
		$data['Company_address'] = $this->input->post('caddress');        
		$data['Country'] = $this->input->post('country');        
		$data['State'] = $this->input->post('state');
		$data['City'] = $this->input->post('city');		
		if($this->input->post('district') != NULL)
		{
			$data['District'] = $this->input->post('district');
		} 	
		$data['Company_primary_contact_person'] = $this->input->post('primarycnt');
		$data['Company_primary_email_id'] = $this->input->post('primaryemailId');
		$data['Company_contactus_email_id'] = $this->input->post('Company_contactus_email_id');
		$data['Company_finance_email_id'] = $this->input->post('Company_finance_email_id');		
		$data['Currency_name'] = $this->input->post('Currency_name');
		$data['Company_primary_phone_no'] = $this->input->post('primaryphoneno');		
		if($this->input->post('secondaryphoneno') != NULL)
		{
			$data['Company_secondary_phone_no'] = $this->input->post('secondaryphoneno');
		} 
		if($this->input->post('regdate') != NULL)
		{
			$data['Comp_regdate'] = $this->input->post('regdate');
		}
		if($this->input->post('cregno') != NULL)
		{
			$data['Company_reg_no'] = $this->input->post('cregno');
		}
		if($this->input->post('domain') != NULL)
		{
			$data['Domain_name'] = $this->input->post('domain');
		}
		if($this->input->post('C_user_name') != NULL)
		{
			$data['Company_username'] = $this->input->post('C_user_name');
		}
		if($this->input->post('C_password') != NULL)
		{
			$data['Company_password'] = $this->input->post('C_password');
		}
		if($this->input->post('C_Encryptionkey') != NULL)
		{
			$data['Company_encryptionkey'] = $this->input->post('C_Encryptionkey');
		}
		if($this->input->post('url') != NULL)
		{
			$data['Website'] = $this->input->post('url');
		}
		if($this->input->post('no_of_licensce') != NULL)
		{
			$data['Seller_licences_limit'] = $this->input->post('no_of_licensce');
		}
		if($filepath_logo != NULL)
		{
			$data['Company_logo'] = $filepath_logo;
		}
		if($this->input->post('card_decsion') != NULL)
		{
			$data['card_decsion'] = $this->input->post('card_decsion');
		}
		if($this->input->post('start_card_no') != NULL)
		{
			$data['Start_card_series'] = $this->input->post('start_card_no');
		}
		if($this->input->post('redemptionratio') != NULL)
		{
			$data['Redemptionratio'] = $this->input->post('redemptionratio');
		}
		if($this->input->post('noti_distance') != NULL)
		{
			$data['Distance'] = $this->input->post('noti_distance');
		}
		if($this->input->post('enb_coalition') != NULL)
		{
			$data['Coalition'] = $this->input->post('enb_coalition');
		}
		if($this->input->post('enb_coalition')==1)
		{
			$data['Coalition_points_percentage'] = $this->input->post('Coalition_points_percentage');
		}
		if($this->input->post('Joining_bonus')==1)
		{
			$data['Joining_bonus'] = $this->input->post('Joining_bonus');
		}		
		if($this->input->post('Joining_bonus')==1)
		{
			$data['Joining_bonus_points'] = $this->input->post('Joining_bonus_points');
		}
		if($this->input->post('Cust_website')!=NULL)
		{
			$data['Cust_website'] = $this->input->post('Cust_website');
		}		
		if($this->input->post('top_access')==1)
		{
			$data['Seller_topup_access'] = $this->input->post('top_access');
			$data['Deposit_amount'] = $this->input->post('amt_deposit');
			$data['Limit_Balance_Merchant'] = $this->input->post('amt_threshold');
			$data['Threshold_Merchant'] = $this->input->post('amt_threshold');
		}		
		if($this->input->post('sms_decsion')==1)
		{
			$data['Sms_enabled'] = $this->input->post('sms_decsion');
			$data['Available_sms'] = $this->input->post('sms');
			$data['Sms_api_link'] = $this->input->post('sms_api_link');
			$data['Sms_api_auth_key'] = $this->input->post('sms_api_auth_key');
		}
		if($this->input->post('discount_flag')!=NULL)
		{
			$data['Discount_flag'] = $this->input->post('discount_flag');
		}
		if($this->input->post('Pin_no_applicable')!=NULL)
		{
			$data['Pin_no_applicable'] = $this->input->post('Pin_no_applicable');
		}
		if($this->input->post('Promo_code_applicable')!=NULL)
		{
			$data['Promo_code_applicable'] = $this->input->post('Promo_code_applicable');
		}
		if($this->input->post('Auction_bid_applicable')!=NULL)
		{
			$data['Auction_bidding_applicable'] = $this->input->post('Auction_bid_applicable');
		}
		if($this->input->post('white_labels')!=NULL)
		{
			$data['Localization_flag'] = $this->input->post('white_labels');
		}			
		if($this->input->post('white_labels')==1)
		{
			$data['Localization_logo'] = $filepath_white_label;
		}
		if($this->input->post('Share_type')==1)
		{
			$data['Share_type'] = $this->input->post('Share_type');
		}
		if($this->input->post('Share_type') == 0)
		{ 
			$data['Share_limit'] = $this->input->post('Share_limit');
		}
		if($this->input->post('Facebook_share_points') != NULL)
		{
			$data['Facebook_share_points'] = $this->input->post('Facebook_share_points');
		}
		if($this->input->post('Twitter_share_points') != NULL)
		{
			$data['Twitter_share_points'] = $this->input->post('Twitter_share_points');
		}
		if($this->input->post('Google_share_points') != NULL)
		{
			$data['Google_share_points'] = $this->input->post('Google_share_points');
		} 
		if($this->input->post('cust_apk_link') != NULL)
		{
			$data['Cust_apk_link'] = $this->input->post('cust_apk_link');
		}
		if($this->input->post('cust_ios_link') != NULL)
		{
			$data['Cust_ios_link'] = $this->input->post('cust_ios_link');
		}
		if($this->input->post('facebook_link') != NULL)
		{
			$data['Facebook_link'] = $this->input->post('facebook_link');
		}
		if($this->input->post('gplus_link') != NULL)
		{
			$data['Googlplus_link'] = $this->input->post('gplus_link');
		}
		if($this->input->post('linked_link') != NULL)
		{
			$data['Linkedin_link'] = $this->input->post('linked_link');
		} 
		if($this->input->post('twitter_link') != NULL)
		{
			$data['Twitter_link'] = $this->input->post('twitter_link');
		}                		
		$data['Creation_date_time'] = date("Y-m-d");
		$data['Create_user_id'] = $Create_user_id;		
		$data['Activated'] = 1;
		if($this->input->post('start_card_no') != NULL)
		{
			$data['next_card_no'] = $this->input->post('start_card_no');
		}
		if($this->input->post('amt_deposit') != NULL)
		{
			$data['Current_bal'] = $this->input->post('amt_deposit');		
		}
		$data['Allow_negative'] = 0;
		$data['Partner_company_flag'] = $Partner_company_flag;
		$data['Parent_company'] = $Parent_company;
		if($this->input->post('Allow_merchant_pin') != NULL)
		{
			$data['Allow_merchant_pin'] = $this->input->post('Allow_merchant_pin');
		}
		if($this->input->post('Allow_membershipid_once') != NULL)
		{
			$data['Allow_membershipid_once'] = $this->input->post('Allow_membershipid_once');
		}
		if($this->input->post('Allow_redeem_item_enrollment') != NULL)
		{
			$data['Allow_redeem_item_enrollment'] = $this->input->post('Allow_redeem_item_enrollment');
		}
		if($this->input->post('Allow_preorder_services') != NULL)
		{
			$data['Allow_preorder_services'] = $this->input->post('Allow_preorder_services');
		}
		if($this->input->post('Membership_redirection_url') != NULL)
		{
			$data['Membership_redirection_url'] = $this->input->post('Membership_redirection_url');
		}
		if($this->input->post('Profile_complete_flag') != NULL)
		{
			$data['Profile_complete_flag'] = $this->input->post('Profile_complete_flag');
		}
		if($this->input->post('Profile_complete_points') != NULL)
		{
			$data['Profile_complete_points'] = $this->input->post('Profile_complete_points');
		}
		if($this->input->post('App_login_flag') != NULL)
		{
			$data['App_login_flag'] = $this->input->post('App_login_flag');
		}
		if($this->input->post('App_login_points') != NULL)
		{
			$data['App_login_points'] = $this->input->post('App_login_points');		
		}
		if($this->input->post('Cron_birthday_flag') != NULL)
		{
			$data['Cron_birthday_flag'] = $this->input->post('Cron_birthday_flag');			
		}
		if($this->input->post('Cron_tier_flag') != NULL)
		{
			$data['Cron_tier_flag'] = $this->input->post('Cron_tier_flag');			
		}	
		if($this->input->post('Cron_evoucher_expiry_flag') != NULL)
		{
			$data['Cron_evoucher_expiry_flag'] = $this->input->post('Cron_evoucher_expiry_flag');	
		}
		if($this->input->post('Cron_evoucher_expiry_flag')==1)
		{
			$data['Evoucher_expiry_period'] = $this->input->post('Evoucher_expiry_period');	
		}
		if($this->input->post('Cron_points_expiry_flag')!=NULL)
		{
			$data['Cron_points_expiry_flag'] = $this->input->post('Cron_points_expiry_flag');	
		}	
		if($this->input->post('Cron_points_expiry_flag')==1)
		{
			$data['Points_expiry_period'] = $this->input->post('Points_expiry_period');		
			$data['Deduct_points_expiry'] = $this->input->post('Deduct_points_expiry');	
		}
		if($this->input->post('Cron_freebies_once_flag')!=NULL)
		{
			$data['Cron_freebies_once_flag'] = $this->input->post('Cron_freebies_once_flag');
		}
		if($this->input->post('Cron_freebies_other_benefit_flag')!=NULL)
		{
			$data['Cron_freebies_other_benefit_flag'] = $this->input->post('Cron_freebies_other_benefit_flag');	
		}
		if($this->input->post('Cron_survey_flag')!=NULL)
		{
			$data['Cron_survey_flag'] = $this->input->post('Cron_survey_flag');
		}
		if($this->input->post('Cron_trigger_flag')!=NULL)
		{
			$data['Cron_trigger_flag'] = $this->input->post('Cron_trigger_flag');
		}
		
		if($this->input->post('Ecommerce_flag')==1)
		{
			$data['Ecommerce_flag']=$this->input->post('Ecommerce_flag');
			$data['Ecommerce_return_policy_in_days']=$this->input->post('return_policy');
		}
		if($this->input->post('Cron_communication_flag')!=NULL)
		{
			$data['Cron_communication_flag'] = $this->input->post('Cron_communication_flag');
		}
		if($this->input->post('Label_1')!=NULL)
		{
			$data['Label_1'] = $this->input->post('Label_1');
		}
		if($this->input->post('Label_2')!=NULL)
		{
			$data['Label_2'] = $this->input->post('Label_2');
		}
		if($this->input->post('Label_3')!=NULL)
		{
			$data['Label_3'] = $this->input->post('Label_3');
		}
		if($this->input->post('Label_4')!=NULL)
		{
			$data['Label_4'] = $this->input->post('Label_4');
		}
		if($this->input->post('Label_5')!=NULL)
		{
			$data['Label_5'] = $this->input->post('Label_5');
		}
		if($this->input->post('Survey_analysis')!=NULL)
		{
			$data['Survey_analysis'] = $this->input->post('Survey_analysis');
		}
		if($this->input->post('Country_language')!=NULL)
		{
			$data['Country_language'] = $this->input->post('Country_language');
		}	
		if($this->input->post('Text_direction')!=NULL)
		{
			$data['Text_direction'] = $this->input->post('Text_direction');
		}		
		if($this->input->post('Call_center_flag')==1)
		{
			$data['Call_center_flag']=$this->input->post('Call_center_flag');
			
		}
		if($this->input->post('ticketno_series')!=NUll)
		{
			$data['Callcenter_query_ticketno_series']=$this->input->post('ticketno_series');
		}
		if($this->input->post('Beneficiary_flag')==1)
		{
			$data['Beneficiary_flag'] = $this->input->post('Beneficiary_flag');
		}			
		if($this->input->post('Shipping_charges_flag')==1)
		{
			$data['Shipping_charges_flag'] =$this->input->post('Shipping_charges_flag');
		}	
		if($this->input->post('Standard_charges')!=NULL)
		{	
			$data['Standard_charges'] = $this->input->post('Standard_charges');
		}
		if($this->input->post('Cost_Threshold_Limit')!=NULL)
		{		
			$data['Cost_Threshold_Limit'] =$this->input->post('Cost_Threshold_Limit');
		}
		if($this->input->post('Active_Vs_inactive_member_graph_flag')==1)
		{		
			$data['Active_Vs_inactive_member_graph_flag'] =$this->input->post('Active_Vs_inactive_member_graph_flag');
		}
		if($this->input->post('Member_enrollments_graph_flag')==1)
		{		
			$data['Member_enrollments_graph_flag'] =$this->input->post('Member_enrollments_graph_flag');
		}
		if($this->input->post('No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag')==1)
		{		
			$data['No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag'] =$this->input->post('No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag');
		}
		if($this->input->post('Partner_qnty_issued_Vs_partner_qnty_used_graph_flag')==1)
		{		
			$data['Partner_qnty_issued_Vs_partner_qnty_used_graph_flag'] =$this->input->post('Partner_qnty_issued_Vs_partner_qnty_used_graph_flag');
		}
		if($this->input->post('Member_suggestions_flag')==1)
		{		
			$data['Member_suggestions_flag'] =$this->input->post('Member_suggestions_flag');
		}
		if($this->input->post('Happy_member_flag')==1)
		{		
			$data['Happy_member_flag'] =$this->input->post('Happy_member_flag');
		}
		if($this->input->post('Worry_member_flag')==1)
		{		
			$data['Worry_member_flag'] =$this->input->post('Worry_member_flag');
		}
		if($this->input->post('Total_point_issued_Vs_total_points_redeemed_graph_flag')==1)
		{		
			$data['Total_point_issued_Vs_total_points_redeemed_graph_flag'] =$this->input->post('Total_point_issued_Vs_total_points_redeemed_graph_flag');
		}
		if($this->input->post('Total_quantity_issued_Vs_total_quantity_used_graph_flag')==1)
		{		
			$data['Total_quantity_issued_Vs_total_quantity_used_graph_flag'] =$this->input->post('Total_quantity_issued_Vs_total_quantity_used_graph_flag');
		}
		
//******** 14-10-2019 Provision for Order , Payment and Delivery URLs, KEY  *******************************
		if($this->input->post('Company_orderapi_encryptionkey') != NULL)
		{
			$data['Company_orderapi_encryptionkey'] = $this->input->post('Company_orderapi_encryptionkey');
		}

		if($this->input->post('Company_api_encryptionkey') != NULL)
		{
			$data['Company_api_encryptionkey'] = $this->input->post('Company_api_encryptionkey');
		}

		if($this->input->post('Delivery_partner_url') != NULL)
		{
			$data['Delivery_partner_url'] = $this->input->post('Delivery_partner_url');
		}	

		if($this->input->post('Delivery_partner_url2') != NULL)
		{
			$data['Delivery_partner_url2'] = $this->input->post('Delivery_partner_url2');
		}

		if($this->input->post('Delivery_api_key1') != NULL)
		{
			$data['Delivery_api_key1'] = $this->input->post('Delivery_api_key1');
		}	

		if($this->input->post('Delivery_api_key2') != NULL)
		{
			$data['Delivery_api_key2'] = $this->input->post('Delivery_api_key2');
		}			
//******** 14-10-2019 Provision for Order , Payment and Delivery URLs, KEY  *******************************		
//******** Nilesh 8-7-2020 Provision for DPO Credit Card Payment URLs, KEY etc  ***********************
		if($this->input->post('Dpo_company_id') != NULL)
		{
			$data['Dpo_company_id'] = $this->input->post('Dpo_company_id');
		}

		if($this->input->post('End_point') != NULL)
		{
			$data['End_point'] = $this->input->post('End_point');
		}

		if($this->input->post('Payment_url') != NULL)
		{
			$data['Payment_url'] = $this->input->post('Payment_url');
		}	

		if($this->input->post('Redirect_url') != NULL)
		{
			$data['Redirect_url'] = $this->input->post('Redirect_url');
		}

		if($this->input->post('Back_url') != NULL)
		{
			$data['Back_url'] = $this->input->post('Back_url');
		}	

		if($this->input->post('PTL') != NULL)
		{
			$data['PTL'] = $this->input->post('PTL');
		}	
		if($this->input->post('Service_type') != NULL)
		{
			$data['Service_type'] = $this->input->post('Service_type');
		}			
//******** Nilesh 8-7-2020 Provision for DPO Credit Card Payment URLs, KEY etc***********************
		if($this->input->post('App_folder_name') != NULL)
		{
			$data['App_folder_name'] = $this->input->post('App_folder_name');
		}
		if($this->input->post('Redeem_request_validity') != NULL)
		{
			$data['Redeem_request_validity'] = $this->input->post('Redeem_request_validity');
		}
		//******** 27-12-2019 AMIT KAMBLE *******************************		
		$data['Company_License_type'] = $this->input->post('Company_License_type');
		$data['Company_Licence_period'] = $this->input->post('Company_Licence_period');
		$data['Transaction_Order_Types_graph_flag'] = $this->input->post('Transaction_Order_Types_graph_flag');
		//******** XXXXXXXXX *******************************	

	//********* gift card 10-05-2020 *********
		if($this->input->post('Gift_card_flag') != NULL)
		{
			$data['Gift_card_flag'] = $this->input->post('Gift_card_flag');
			$data['Gift_card_validity_days'] = $this->input->post('Gift_card_validity_days');
			$data['Minimum_gift_card_amount'] = $this->input->post('Minimum_gift_card_amount');
			$data['Points_used_gift_card'] = $this->input->post('Points_used_gift_card');
		}
	//********* gift card 10-05-2020 *********
		if($this->input->post('Use_pin_flag') != NULL)
		{
			$data['Use_pin_number_as_card_id'] = $this->input->post('Use_pin_flag');
			$data['Pin_number_validity'] = $this->input->post('Otp_code_validity');
		}
		$data['Notification_send_to_email'] = $this->input->post('Notification_send_to_email');
		$data['Enable_company_meal_flag'] = $this->input->post('Enable_company_meal_flag');
		$data['Daily_points_consumption_flag'] = $this->input->post('Daily_points_consumption_flag');
		$data['Redeem_auto_confirm_flag'] = $this->input->post('Redeem_auto_confirm_flag');
		$data['Points_as_discount_flag'] = $this->input->post('Points_as_discount_flag');
		$data['Discount_code'] = $this->input->post('Discount_code');
		$data['Voucher_as_discount_flag'] = $this->input->post('Voucher_as_discount_flag');
		$data['Voucher_discount_code'] = $this->input->post('Voucher_discount_code');
		
		$this->db->insert('igain_company_master', $data);
		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	}
	public function inactive_company($post_data,$Company_id)
	{
		$this->db->where('Company_id', $Company_id);
		$this->db->update('igain_company_master', $post_data); 
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	public function edit_company($Company_id)
	{	   
		$edit_query = "SELECT * FROM igain_company_master WHERE Company_id=$Company_id LIMIT 1";
		
		$edit_sql = $this->db->query($edit_query);
				
		if($edit_sql -> num_rows() == 1)
		{
			return $edit_sql->row();
		}
		else
		{
			return false;
		}		
	}
	public function update_company($filepath_logo,$filepath_white_label,$Create_user_id,$Company_id)
	{ 
		$data['Company_name'] = $this->input->post('cname');
		$data['Company_address'] = $this->input->post('caddress');        
		$data['Country'] = $this->input->post('country');        
		$data['State'] = $this->input->post('state');
		$data['City'] = $this->input->post('city');
		if($this->input->post('district') != NULL)
		{
			$data['District'] = $this->input->post('district');
		}
		$data['Company_primary_contact_person'] = $this->input->post('primarycnt');
		$data['Company_primary_email_id'] = $this->input->post('primaryemailId');
		$data['Company_contactus_email_id'] = $this->input->post('Company_contactus_email_id');
		$data['Company_finance_email_id'] = $this->input->post('Company_finance_email_id');
		$data['Currency_name'] = $this->input->post('Currency_name');
		$data['Company_primary_phone_no'] = $this->input->post('primaryphoneno');
		if($this->input->post('secondaryphoneno') != NULL)
		{
			$data['Company_secondary_phone_no'] = $this->input->post('secondaryphoneno');
		} 
		if($this->input->post('regdate') != NULL)
		{
			$data['Comp_regdate'] = $this->input->post('regdate');
		}
		if($this->input->post('cregno') != NULL)
		{
			$data['Company_reg_no'] = $this->input->post('cregno');
		}
		if($this->input->post('domain') != NULL)
		{
			$data['Domain_name'] = $this->input->post('domain');
		}
		if($this->input->post('C_user_name') != NULL)
		{
			$data['Company_username'] = $this->input->post('C_user_name');
		}
		if($this->input->post('C_password') != NULL)
		{
			$data['Company_password'] = $this->input->post('C_password');
		}
		if($this->input->post('C_Encryptionkey') != NULL)
		{
			$data['Company_encryptionkey'] = $this->input->post('C_Encryptionkey');
		}
		if($this->input->post('url') != NULL)
		{
			$data['Website'] = $this->input->post('url');
		}
		if($this->input->post('no_of_licensce') != NULL)
		{
			$data['Seller_licences_limit'] = $this->input->post('no_of_licensce');
		}
		if($filepath_logo != NULL)
		{
			$data['Company_logo'] = $filepath_logo;
		}	
		if($this->input->post('redemptionratio') != NULL)
		{
			$data['Redemptionratio'] = $this->input->post('redemptionratio');
		}
		if($this->input->post('noti_distance') != NULL)
		{
			$data['Distance'] = $this->input->post('noti_distance');
		}
		if($this->input->post('enb_coalition') != NULL)
		{
			$data['Coalition'] = $this->input->post('enb_coalition');
		}
		if($this->input->post('enb_coalition')==1)
		{
			$data['Coalition_points_percentage'] = $this->input->post('Coalition_points_percentage');
		}
		else{
		$data['Coalition_points_percentage'] = 0;
		}
		if($this->input->post('Joining_bonus')!=NULL)
		{
			$data['Joining_bonus'] = $this->input->post('Joining_bonus');
		}		
		if($this->input->post('Joining_bonus')==1)
		{
			$data['Joining_bonus_points'] = $this->input->post('Joining_bonus_points');
		}
		if($this->input->post('Cust_website')!=NULL)
		{
			$data['Cust_website'] = $this->input->post('Cust_website');
		}
		
		if($this->input->post('top_access')!=NULL)
		{
			$data['Seller_topup_access'] = $this->input->post('top_access');	
			
		}
		if($this->input->post('amt_deposit')!=NULL)
		{
			$data['Deposit_amount'] = $this->input->post('amt_deposit');	
		}
		if($this->input->post('amt_threshold')!=NULL)
		{
			$data['Threshold_Merchant'] = $this->input->post('amt_threshold');	
		}
		if($this->input->post('sms_decsion')!=NULL)
		{
			$data['Sms_enabled'] = $this->input->post('sms_decsion');
		}
		if($this->input->post('sms')!=NULL)
		{
			$data['Available_sms'] = $this->input->post('sms');
		}
		if($this->input->post('sms_api_link')!=NULL)
		{
			$data['Sms_api_link'] = $this->input->post('sms_api_link');
		}
		if($this->input->post('sms_api_auth_key')!=NULL)
		{		
			$data['Sms_api_auth_key'] = $this->input->post('sms_api_auth_key');
		}
		if($this->input->post('discount_flag')!=NULL)
		{
			$data['Discount_flag'] = $this->input->post('discount_flag');
		}
		if($this->input->post('Pin_no_applicable')!=NULL)
		{
			$data['Pin_no_applicable'] = $this->input->post('Pin_no_applicable');
		}
		if($this->input->post('Promo_code_applicable')!=NULL)
		{
			$data['Promo_code_applicable'] = $this->input->post('Promo_code_applicable');
		}
		if($this->input->post('Auction_bid_applicable')!=NULL)
		{
			$data['Auction_bidding_applicable'] = $this->input->post('Auction_bid_applicable');
		}
		if($this->input->post('white_labels')!=NULL)
		{
			$data['Localization_flag'] = $this->input->post('white_labels');
		}			
		if($this->input->post('white_labels')!=NULL)
		{
			$data['Localization_logo'] = $filepath_white_label;
		}
		if($this->input->post('Share_type')!=NULL)
		{
			$data['Share_type'] = $this->input->post('Share_type');
		}
		if($this->input->post('Share_type') == 0)
		{
			$data['Share_limit'] = $this->input->post('Share_limit');
		}
		                
		if($this->input->post('Old_Share_type') != $this->input->post('Share_type'))
		{
			$this->db->where('Company_id', $Company_id);
			$this->db->delete('igain_share_notification_details');
		}
		
		if($this->input->post('Old_Share_limit') != $this->input->post('Share_limit'))
		{
			$this->db->where('Company_id', $Company_id);
			$this->db->delete('igain_share_notification_details');                    
		}
		if($this->input->post('Facebook_share_points') != NULL)
		{
			$data['Facebook_share_points'] = $this->input->post('Facebook_share_points');
		}
		if($this->input->post('Twitter_share_points') != NULL)
		{
			$data['Twitter_share_points'] = $this->input->post('Twitter_share_points');
		}
		if($this->input->post('Google_share_points') != NULL)
		{
			$data['Google_share_points'] = $this->input->post('Google_share_points');
		} 
		if($this->input->post('cust_apk_link') != NULL)
		{
			$data['Cust_apk_link'] = $this->input->post('cust_apk_link');
		}
		if($this->input->post('cust_ios_link') != NULL)
		{
			$data['Cust_ios_link'] = $this->input->post('cust_ios_link');
		}
		if($this->input->post('facebook_link') != NULL)
		{
			$data['Facebook_link'] = $this->input->post('facebook_link');
		}
		if($this->input->post('gplus_link') != NULL)
		{
			$data['Googlplus_link'] = $this->input->post('gplus_link');
		}
		if($this->input->post('linked_link') != NULL)
		{
			$data['Linkedin_link'] = $this->input->post('linked_link');
		} 
		if($this->input->post('twitter_link') != NULL)
		{
			$data['Twitter_link'] = $this->input->post('twitter_link');
		}      
		
		$data['Update_date_time'] = date("Y-m-d");
		$data['Update_user_id'] = $Create_user_id;
		
		$data['Activated'] = 1;
		if($this->input->post('amt_deposit') != NULL)
		{
			$data['Current_bal'] = $this->input->post('amt_deposit');		
		}
		if($this->input->post('Allow_merchant_pin') != NULL)
		{
			$data['Allow_merchant_pin'] = $this->input->post('Allow_merchant_pin');
		}
		if($this->input->post('Allow_membershipid_once') != NULL)
		{
			$data['Allow_membershipid_once'] = $this->input->post('Allow_membershipid_once');
		}
		if($this->input->post('Allow_redeem_item_enrollment') != NULL)
		{
			$data['Allow_redeem_item_enrollment'] = $this->input->post('Allow_redeem_item_enrollment');
		}
		if($this->input->post('Allow_preorder_services') != NULL)
		{
			$data['Allow_preorder_services'] = $this->input->post('Allow_preorder_services');
		}
		if($this->input->post('Membership_redirection_url') != NULL)
		{
			$data['Membership_redirection_url'] = $this->input->post('Membership_redirection_url');
		}
		if($this->input->post('Profile_complete_flag') != NULL)
		{
			$data['Profile_complete_flag'] = $this->input->post('Profile_complete_flag');
		}
		if($this->input->post('Profile_complete_points') != NULL)
		{
			$data['Profile_complete_points'] = $this->input->post('Profile_complete_points');
		}
		if($this->input->post('App_login_flag') != NULL)
		{
			$data['App_login_flag'] = $this->input->post('App_login_flag');
		}
		if($this->input->post('App_login_points') != NULL)
		{
			$data['App_login_points'] = $this->input->post('App_login_points');		
		}
		if($this->input->post('Cron_birthday_flag') != NULL)
		{
			$data['Cron_birthday_flag'] = $this->input->post('Cron_birthday_flag');			
		}
		if($this->input->post('Cron_tier_flag') != NULL)
		{
			$data['Cron_tier_flag'] = $this->input->post('Cron_tier_flag');			
		}	
		if($this->input->post('Cron_evoucher_expiry_flag') != NULL)
		{
			$data['Cron_evoucher_expiry_flag'] = $this->input->post('Cron_evoucher_expiry_flag');	
		}
		if($this->input->post('Cron_evoucher_expiry_flag')!=NULL)
		{
			$data['Evoucher_expiry_period'] = $this->input->post('Evoucher_expiry_period');	
		}
		if($this->input->post('Cron_points_expiry_flag')!=NULL)
		{
			$data['Cron_points_expiry_flag'] = $this->input->post('Cron_points_expiry_flag');	
		}	
		if($this->input->post('Cron_points_expiry_flag')!=NULL)
		{
			$data['Points_expiry_period'] = $this->input->post('Points_expiry_period');		
			$data['Deduct_points_expiry'] = $this->input->post('Deduct_points_expiry');	
		}
		if($this->input->post('Cron_freebies_once_flag')!=NULL)
		{
			$data['Cron_freebies_once_flag'] = $this->input->post('Cron_freebies_once_flag');
		}
		if($this->input->post('Cron_freebies_other_benefit_flag')!=NULL)
		{
			$data['Cron_freebies_other_benefit_flag'] = $this->input->post('Cron_freebies_other_benefit_flag');	
		}
		if($this->input->post('Cron_survey_flag')!=NULL)
		{
			$data['Cron_survey_flag'] = $this->input->post('Cron_survey_flag');
		}
		if($this->input->post('Cron_trigger_flag')!=NULL)
		{
			$data['Cron_trigger_flag'] = $this->input->post('Cron_trigger_flag');
		}
		if($this->input->post('Ecommerce_flag')!=NULL)
		{
			$data['Ecommerce_flag']=$this->input->post('Ecommerce_flag');			
		}
		if($this->input->post('return_policy')!=NULL)
		{			
			$data['Ecommerce_return_policy_in_days']=$this->input->post('return_policy');
		}		
		if($this->input->post('Cron_communication_flag')!=NULL)
		{
			$data['Cron_communication_flag'] = $this->input->post('Cron_communication_flag');
		}	
		if($this->input->post('Label_1')!=NULL)
		{
			$data['Label_1'] = $this->input->post('Label_1');
		}
		if($this->input->post('Label_2')!=NULL)
		{
			$data['Label_2'] = $this->input->post('Label_2');
		}
		if($this->input->post('Label_3')!=NULL)
		{
			$data['Label_3'] = $this->input->post('Label_3');
		}
		if($this->input->post('Label_4')!=NULL)
		{
			$data['Label_4'] = $this->input->post('Label_4');
		}
		if($this->input->post('Label_5')!=NULL)
		{
			$data['Label_5'] = $this->input->post('Label_5');
		}
		if($this->input->post('Survey_analysis')!=NULL)
		{
			$data['Survey_analysis'] = $this->input->post('Survey_analysis');
		}
		if($this->input->post('Country_language')!=NULL)
		{
			$data['Country_language'] = $this->input->post('Country_language');
		}	
		if($this->input->post('Text_direction')!=NULL)
		{
			$data['Text_direction'] = $this->input->post('Text_direction');
		}			
		if($this->input->post('Call_center_flag')!=NULL)
		{
			$data['Call_center_flag']=$this->input->post('Call_center_flag');
			
		}
		if($this->input->post('ticketno_series')!=NUll)
		{
			$data['Callcenter_query_ticketno_series']=$this->input->post('ticketno_series');
		}
		if($this->input->post('Beneficiary_flag')!=NULL)
		{
			$data['Beneficiary_flag'] = $this->input->post('Beneficiary_flag');
		}
		if($this->input->post('Shipping_charges_flag')!=NULL)
		{
			$data['Shipping_charges_flag'] =$this->input->post('Shipping_charges_flag');
		}
		if($this->input->post('Standard_charges')!=NULL)
		{	
			$data['Standard_charges'] = $this->input->post('Standard_charges');
			
		}
		if($this->input->post('Cost_Threshold_Limit')!=NULL)
		{		
			$data['Cost_Threshold_Limit'] =$this->input->post('Cost_Threshold_Limit');
		}
		if($this->input->post('Active_Vs_inactive_member_graph_flag')!=NULL)
		{		
			$data['Active_Vs_inactive_member_graph_flag'] =$this->input->post('Active_Vs_inactive_member_graph_flag');
		}
		if($this->input->post('Member_enrollments_graph_flag')!=NULL)
		{		
			$data['Member_enrollments_graph_flag'] =$this->input->post('Member_enrollments_graph_flag');
		}
		if($this->input->post('No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag')!=NULL)
		{		
			$data['No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag'] =$this->input->post('No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag');
		}
		if($this->input->post('Partner_qnty_issued_Vs_partner_qnty_used_graph_flag')!=NULL)
		{		
			$data['Partner_qnty_issued_Vs_partner_qnty_used_graph_flag'] =$this->input->post('Partner_qnty_issued_Vs_partner_qnty_used_graph_flag');
		}
		if($this->input->post('Member_suggestions_flag')!=NULL)
		{		
			$data['Member_suggestions_flag'] =$this->input->post('Member_suggestions_flag');
		}
		if($this->input->post('Happy_member_flag')!=NULL)
		{		
			$data['Happy_member_flag'] =$this->input->post('Happy_member_flag');
		}
		if($this->input->post('Worry_member_flag')!=NULL)
		{		
			$data['Worry_member_flag'] =$this->input->post('Worry_member_flag');
		}
		if($this->input->post('Total_point_issued_Vs_total_points_redeemed_graph_flag')!=NULL)
		{		
			$data['Total_point_issued_Vs_total_points_redeemed_graph_flag'] =$this->input->post('Total_point_issued_Vs_total_points_redeemed_graph_flag');
		}
		if($this->input->post('Total_quantity_issued_Vs_total_quantity_used_graph_flag')!=NULL)
		{		
			$data['Total_quantity_issued_Vs_total_quantity_used_graph_flag'] =$this->input->post('Total_quantity_issued_Vs_total_quantity_used_graph_flag');
		}
		
			
//******** 14-10-2019 Provision for Order , Payment and Delivery URLs, KEY  *******************************
		if($this->input->post('Company_orderapi_encryptionkey') != NULL)
		{
			$data['Company_orderapi_encryptionkey'] = $this->input->post('Company_orderapi_encryptionkey');
		}

		if($this->input->post('Company_api_encryptionkey') != NULL)
		{
			$data['Company_api_encryptionkey'] = $this->input->post('Company_api_encryptionkey');
		}

		if($this->input->post('Delivery_partner_url') != NULL)
		{
			$data['Delivery_partner_url'] = $this->input->post('Delivery_partner_url');
		}	

		if($this->input->post('Delivery_partner_url2') != NULL)
		{
			$data['Delivery_partner_url2'] = $this->input->post('Delivery_partner_url2');
		}

		if($this->input->post('Delivery_api_key1') != NULL)
		{
			$data['Delivery_api_key1'] = $this->input->post('Delivery_api_key1');
		}	

		if($this->input->post('Delivery_api_key2') != NULL)
		{
			$data['Delivery_api_key2'] = $this->input->post('Delivery_api_key2');
		}			
//******** 14-10-2019 Provision for Order , Payment and Delivery URLs, KEY  *******************************		
//******** Nilesh 8-7-2020 Provision for DPO Credit Card Payment URLs, KEY etc  ***********************
		if($this->input->post('Dpo_company_id') != NULL)
		{
			$data['Dpo_company_id'] = $this->input->post('Dpo_company_id');
		}

		if($this->input->post('End_point') != NULL)
		{
			$data['End_point'] = $this->input->post('End_point');
		}

		if($this->input->post('Payment_url') != NULL)
		{
			$data['Payment_url'] = $this->input->post('Payment_url');
		}	

		if($this->input->post('Redirect_url') != NULL)
		{
			$data['Redirect_url'] = $this->input->post('Redirect_url');
		}

		if($this->input->post('Back_url') != NULL)
		{
			$data['Back_url'] = $this->input->post('Back_url');
		}	

		if($this->input->post('PTL') != NULL)
		{
			$data['PTL'] = $this->input->post('PTL');
		}	
		if($this->input->post('Service_type') != NULL)
		{
			$data['Service_type'] = $this->input->post('Service_type');
		}			
//******** Nilesh 8-7-2020 Provision for DPO Credit Card Payment URLs, KEY etc***********************
		if($this->input->post('App_folder_name') != NULL)
		{
			$data['App_folder_name'] = $this->input->post('App_folder_name');
		}
		if($this->input->post('Redeem_request_validity') != NULL)
		{
			$data['Redeem_request_validity'] = $this->input->post('Redeem_request_validity');
		}
	
		//******** 27-12-2019 AMIT KAMBLE *******************************		
		$data['Company_License_type'] = $this->input->post('Company_License_type');
		$data['Company_Licence_period'] = $this->input->post('Company_Licence_period');
		$data['Transaction_Order_Types_graph_flag'] = $this->input->post('Transaction_Order_Types_graph_flag');
		//******** XXXXXXXXX *******************************

//********* gift card 10-05-2020 *********
		if($this->input->post('Gift_card_flag') != NULL)
		{
			$data['Gift_card_flag'] = $this->input->post('Gift_card_flag');
			$data['Gift_card_validity_days'] = $this->input->post('Gift_card_validity_days');
			$data['Minimum_gift_card_amount'] = $this->input->post('Minimum_gift_card_amount');
			$data['Points_used_gift_card'] = $this->input->post('Points_used_gift_card');
		}
	//********* gift card 10-05-2020 *********
		if($this->input->post('Use_pin_flag') != NULL)
		{
			$data['Use_pin_number_as_card_id'] = $this->input->post('Use_pin_flag');
			$data['Pin_number_validity'] = $this->input->post('Otp_code_validity');
		}
		$data['Notification_send_to_email'] = $this->input->post('Notification_send_to_email');
		$data['Enable_company_meal_flag'] = $this->input->post('Enable_company_meal_flag');
		$data['Daily_points_consumption_flag'] = $this->input->post('Daily_points_consumption_flag');
		$data['Redeem_auto_confirm_flag'] = $this->input->post('Redeem_auto_confirm_flag');
		$data['Points_as_discount_flag'] = $this->input->post('Points_as_discount_flag');
		$data['Discount_code'] = $this->input->post('Discount_code');
		$data['Voucher_as_discount_flag'] = $this->input->post('Voucher_as_discount_flag');
		$data['Voucher_discount_code'] = $this->input->post('Voucher_discount_code');
		
		$this->db->where('Company_id', $Company_id);
		$this->db->update('igain_company_master', $data); 
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function get_common_menus()
	{
		$Menu_id_array = array('21','22','32','33','50','51','52','53','54');
		$this->db->order_by('Menu_id','ASC');
		$this->db->where('Menu_id <=', '17');
		$this->db->or_where_in('Menu_id', $Menu_id_array);		
        $query = $this->db->get("igain_menu_master");
		
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
	}
	
	public function insert_company_menus($Company_id,$Menu_array)
	{
		$this->db->insert('igain_company_menu_master', $Menu_array);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	
	/************************Nilesh Start for beneficiary_company 03-10-2017*****************/
	function insert_beneficiary_company($Post_data)
	{
		$this->db->insert('igain_register_beneficiary_company',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	public function beneficiary_company_active_count()
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Activate_flag', 1);
		$query = $this->db->get('igain_register_beneficiary_company');
		$result = $query->row_array();
		return	$count2 = $result['COUNT(*)']; 
	}
	public function beneficiary_company_active_list()
	{
		// $this->db->limit($limit,$start);
		$query = $this->db->where("Activate_flag",1);
		$query = $this->db->order_by("Register_beneficiary_id",'desc');
		$query = $this->db->get("igain_register_beneficiary_company");

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function beneficiary_company_inactive_count()
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Activate_flag', 0);
		$query = $this->db->get('igain_register_beneficiary_company');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)']; 
	}
	public function beneficiary_company_inactive_list()
	{
		// $this->db->limit($limit,$start);
		$this->db->where("Activate_flag",'0');
		$query = $this->db->get("igain_register_beneficiary_company");
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false; 		
	}
	
	public function edit_beneficiary_company($Company_id)
	{
		// $edit_query = "SELECT * FROM igain_register_beneficiary_company WHERE Register_beneficiary_id=$Company_id LIMIT 1";		
		$this->db->select("*");
		$this->db->from("igain_register_beneficiary_company as A");
		$this->db->join('igain_codedecode_master as B','A.Publishers_category=B.Code_decode_id','left');
		$this->db->where(array("A.Register_beneficiary_id"=>$Company_id));
		
		$edit_sql = $this->db->get();
				
		if($edit_sql -> num_rows() == 1)
		{
			return $edit_sql->row();
		}
		else
		{
			return false;
		}		
	}
	
	public function inactive_beneficiary_company($post_data,$Company_id)
	{
		$this->db->where('Register_beneficiary_id', $Company_id);
		$this->db->update('igain_register_beneficiary_company', $post_data); 
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function get_beneficiary_company_details($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_register_beneficiary_company');
		$this->db->where('Register_beneficiary_id', $Company_id);
		
		$sql50 = $this->db->get();
	
		if($sql50 -> num_rows() == 1)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	function Update_beneficiary_company($Post_data,$Company_id)
    {			
		$this->db->where('Register_beneficiary_id', $Company_id);
		$this->db->update('igain_register_beneficiary_company', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function beneficiary_company_list()
	{
		$query = $this->db->where("Activate_flag",1);
		$query = $this->db->order_by("Register_beneficiary_id",'desc');
		$query = $this->db->get("igain_register_beneficiary_company");

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
	function igain_beneficiary_company($Post_data) 
	{
		$this->db->insert('igain_beneficiary_company',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	public function company_beneficiary_list($Company_id)
	{
		$query = $this->db->where("Company_id",$Company_id);
		$query = $this->db->order_by("Register_beneficiary_id",'desc');
		$query = $this->db->get("igain_beneficiary_company");

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;	
	}
	function Delete_company_beneficiary($Edit_Company_id)
	{
		$this->db->where("Company_id",$Edit_Company_id);
		$this->db->delete("igain_beneficiary_company");
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function Check_beneficiary_company($bccompanyname)
	{			
		$query =  $this->db->select('Beneficiary_company_name')
	   ->from('igain_register_beneficiary_company')
	   ->where('Beneficiary_company_name', $bccompanyname)->get();	   
		return $query->num_rows();			
	}
	public function Check_Authentication_url($Authentication_url)
	{			
		$query =  $this->db->select('Authentication_url')
	   ->from('igain_register_beneficiary_company')
	   ->where('Authentication_url', $Authentication_url)->get();	   
		return $query->num_rows();			
	}
	public function Check_Transaction_url($Transaction_url)
	{			
		$query =  $this->db->select('Transaction_url')
	   ->from('igain_register_beneficiary_company')
	   ->where('Transaction_url', $Transaction_url)->get();	   
		return $query->num_rows();			
	} 
	public function Check_contatct_email($contactemail)
	{			
		$query =  $this->db->select('Contact_email_id')
	   ->from('igain_register_beneficiary_company')
	   ->where('Contact_email_id', $contactemail)->get();	   
		return $query->num_rows();			
	}
	public function Check_contatct_email1($contactemail)
	{			
		$query =  $this->db->select('Contact_email_id')
	   ->from('igain_register_beneficiary_company')
	   ->where('Contact_email_id1', $contactemail)->get();	   
		return $query->num_rows();			
	}
	public function Check_contatct_email2($contactemail)
	{			
		$query =  $this->db->select('Contact_email_id')
	   ->from('igain_register_beneficiary_company')
	   ->where('Contact_email_id2', $contactemail)->get();	   
		return $query->num_rows();			
	} 
	public function Check_contatct_phoneno($contactphoneno)
	{			
		$query =  $this->db->select('Contact_phone_no')
	   ->from('igain_register_beneficiary_company')
	   ->where('Contact_phone_no', $contactphoneno)->get();	   
		return $query->num_rows();			
	}
	public function igain_company_active_list()
	{
		$query = $this->db->where(array('Activated' =>1, 'Partner_company_flag'=>0));
		$query = $this->db->order_by("Company_id",'desc');
		$query = $this->db->get("igain_company_master");

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;
	
	}
	public function get_company_details($Company_id)
	{ 	
		// $this->db->select('Company_id,Company_name,Company_address,City,District,State,Country,Company_primary_contact_person,Company_primary_email_id,Company_primary_phone_no');
		$this->db->select('Company_id,Company_name,Company_username,Company_password,Company_encryptionkey,Redemptionratio,Company_address,City,District,State,Country,Company_primary_contact_person,Company_primary_email_id,Company_primary_phone_no,Company_contactus_email_id,igain_state_master.name as State,igain_city_master.name as City,igain_state_master.id as State_id,igain_city_master.id as City_id,igain_country_master.name AS Country,igain_country_master.id AS Country_id,Company_logo');
		$this->db->from('igain_company_master');
		$this->db->join('igain_state_master', 'igain_company_master.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'igain_company_master.City = igain_city_master.id');
		$this->db->join('igain_country_master', 'igain_company_master.Country = igain_country_master.id');
		$this->db->where(array('Company_id' => $Company_id));
		$query14 = $this->db->get();
		
		if($query14->num_rows() > 0)
		{			
			foreach ($query14->result() as $row)
			{	 
				$result[] = array("Error_flag" => 0, "Company_id" => $row->Company_id, "Company_name" => $row->Company_name, "Company_address" => $row->Company_address, "City" => $row->City,"City_id" => $row->City_id, "District" => $row->District, "State" => $row->State,"State_id" => $row->State_id, "Country_id" => $row->Country_id, "Country" => $row->Country, "Company_contact_person" => $row->Company_primary_contact_person, "primary_email_id" => $row->Company_primary_email_id, "contact_email_id" => $row->Company_contactus_email_id, "contact_phone_no" => $row->Company_primary_phone_no,"Company_username" => $row->Company_username,"Company_password" => $row->Company_password,"Company_encryptionkey" => $row->Company_encryptionkey,"Company_Redemptionratio" => $row->Redemptionratio,"Company_logo" => $row->Company_logo);
			}
			return json_encode($result);
		}
		else
		{
			return 0;
		}
	}
	function Get_Publishers_Category($Code_decode_type_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master');
		$this->db->where(array('Code_decode_type_id'=>$Code_decode_type_id,'Company_id'=>$Company_id));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			foreach ($sql->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
		}
		else
		{
			return false;
		}		
	}
	/*******************************Nilesh End 04-10-2017*********************************/	
		public function Get_Code_decode_master($Code_decode_type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_type_id',$Code_decode_type_id);
		$this->db->order_by('Code_decode_id','DESC');
		$query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
      public function Get_Specific_Code_decode_master($Code_decode_id)
	{
		$this->db->select('Code_decode');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_id',$Code_decode_id);
		
		$query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
        	/* foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; */
			return $query->row();
        }
        return false;
   }
}
?>